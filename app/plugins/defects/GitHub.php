<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

    /**
     * GitHub Defect Plugin for TestRail
     *
     * Copyright Gurock Software GmbH. All rights reserved.
     *
     * This is the TestRail defect plugin for GitHub. Please see
     * http://docs.gurock.com/testrail-integration/defects-plugins for
     * more information about TestRail's defect plugins.
     *
     * http://www.gurock.com/testrail/
     */

class GitHub_defect_plugin extends Defect_plugin
{
    const DASH = '&ndash;';

    private $_api;
    private $_address;
    private $_user;
    private $_password;
    private $_repo;
    private $_defaultFields = [
        'summary' => 'on',
        'milestone' => 'on',
        'assignee' => 'on',
        'label' => 'on',
        'description' => 'on',
    ];
    private $_fieldDefaults = [
        'summary' => [
            'type' => 'string',
            'label' => 'Summary',
            'size' => 'full',
            'required' => true
        ],
        'milestone' => [
            'type' => 'dropdown',
            'label' => 'Milestone',
            'required' => false,
            'remember' => true,
            'size' => 'compact'
        ],
        'assignee' => [
            'type' => 'dropdown',
            'label' => 'Assignee',
            'required' => false,
            'remember' => true,
            'size' => 'compact'
        ],
        'label' => [
            'type' => 'multiselect',
            'label' => 'Labels',
            'required' => false,
            'size' => 'full'
        ],
        'description' => [
            'type' => 'text',
            'label' => 'Description',
            'required' => false,
            'rows' => 10
        ]
    ];
    private $_hoverDefaultFields = [
        'summary' => 'on',
        'milestone' => 'on',
        'assignee' => 'on',
        'label' => 'on',
        'description' => 'on',
    ];
    private static $_meta = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'GitHub defect plugin for TestRail',
        'can_push' => true,
        'can_lookup' => true,
        'default_config' =>
            '; Please configure your GitHub connection below.
; Note: requires GitHub API v3 or later. You
; can alternatively specify a GitHub Enterprise
; server address.
[connection]
address=https://api.github.com/
user=testrail
password=secret

[repository]
owner=<repository-owner>
name=<repository-name>

[push.fields]
summary=on
milestone=on
assignee=on
label=on
description=on

[hover.fields]
summary=on
milestone=on
assignee=on
label=on
description=on'
    ];

    public function get_meta()
    {
        return self::$_meta;
    }

    // *********************************************************
    // CONSTRUCT / DESTRUCT
    // *********************************************************

    public function __construct()
    {
    }

    public function __destruct()
    {
        if ($this->_api) {
            try {
                $api = $this->_api;
                $this->_api = null;
            } catch (Exception $e) {
                // Possible exceptions are ignored here.
            }
        }
    }

    // *********************************************************
    // CONFIGURATION
    // *********************************************************

    public function validate_config($config)
    {
        $ini = ini::parse($config);

        $groups = array(
            'connection' => array(
                'address',
                'user',
                'password'
            ),
            'repository' => array(
                'owner',
                'name'
            )
        );

        foreach ($groups as $group => $keys) {
            if (!isset($ini[$group])) {
                throw new ValidationException(
                    "Missing [$group] group"
                );
            }

            // Check required values for existance
            foreach ($keys as $key) {
                if (
                    !isset($ini[$group][$key]) ||
                    !$ini[$group][$key]
                ) {
                    throw new ValidationException(
                        "Missing configuration for key '$key'"
                    );
                }
            }
        }

        $address = $ini['connection']['address'];

        // Check whether the address is a valid url (syntax only)
        if (!check::url($address)) {
            throw new ValidationException(
                'Address is not a valid url'
            );
        }
        $this->_ensure_valid_fields('push.fields', $ini);
        $this->_ensure_valid_fields('hover.fields', $ini);
    }

    /**
     * Ensure Valid fields
     * Validate all push and hover fields which are set '=on'
     *
     * @param string $fieldList Field name.
     * @param array  $ini        API configration.
     *
     * @return void
     */
    private function _ensure_valid_fields(string $fieldList, array $ini)
    {
        foreach ($ini[$fieldList] ?? [] as $field => $option) {
            if ($option === 'on') {
                $this->_validate_field($ini, $field);
            }
        }
    }

    /**
     * Validate field
     * Validate custom and default fields and if
     * invalid field found then thows error.
     *
     * @param array  $ini   API configration.
     * @param string $field Field name.
     *
     * @return void
     *
     * @throws ValidationException
     */
    private function _validate_field(array $ini, string $field)
    {
        $valid_types = [
            'dropdown' => true,
            'multiselect' => true,
            'text' => true,
            'string' => true
        ];
        $category = arr::get($ini, "field.settings.$field");
        // Custom fields must always have a separate category.
        if (str::starts_with($field, 'customfield_')) {
            if (!$category) {
                throw new ValidationException(
                    str::format(
                        'Field "{0}" is enabled but configuration ' .
                        'section [field.settings.{0}] is missing',
                        $field
                    )
                );
            }
            foreach (['label', 'type'] as $key) {
                if (!isset($category[$key])) {
                    throw new ValidationException(
                        str::format(
                            'Missing configuration for key "{0}" in ' .
                            'section [field.settings.{1}]',
                            $key,
                            $field
                        )
                    );
                }
            }
        }
        // The specified type must be well-known.
        $type = arr::get($category, 'type');
        if ($type && !isset($valid_types[str::to_lower($type)])) {
            throw new ValidationException(
                str::format(
                    'Invalid field type specified in section ' .
                    '[filed.settings.{0}]',
                    $field
                )
            );
        }
    }

    public function configure($config)
    {
        $ini = ini::parse($config);
        $connection = $ini['connection'];
        $repository = $ini['repository'];
        $this->_address = str::slash($connection['address']);
        $this->_user = $connection['user'];
        $this->_password = $connection['password'];
        $this->_repo = $repository['owner']
            . '/'
            . $repository['name'];
        $this->_config = $ini;
    }

    // *********************************************************
    // API / CONNECTION
    // *********************************************************

    private function _get_api()
    {
        if ($this->_api) {
            return $this->_api;
        }

        $this->_api = new GitHub_api(
            $this->_address,
            $this->_user,
            $this->_password,
            $this->_repo
        );

        return $this->_api;
    }

    // *********************************************************
    // PUSH
    // *********************************************************
    /**
     * Prepare Push
     * Creates an array of objects of default field
     * with default and user defined configuration.
     *
     * @param array|object $context default configuration.
     *
     * @return array
     */
    public function prepare_push($context): array
    {
        $fields = [];
        $fieldsConfig = isset($this->_config['push.fields'])
            ? ['summary' => 'on'] + $this->_config['push.fields']
            : $this->_defaultFields;
        // based on the configuration of the defect plugin.
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on') {
                continue;
            }
            $field = $this->_fieldDefaults[$fieldName] ?? [];
            $category = arr::get(
                $this->_config,
                "field.settings.$fieldName"
            );
            if ($category) {
                foreach ($category as $prop => $val) {
                    $property = str::to_lower($prop);
                    $value = str::to_lower($val);
                    if ($property === 'label') {
                        $field[$property] = $val;
                        continue;
                    }
                    if (
                        (!isset($category['size']) || $category['size'] === 'full'
                        && in_array($category['type'], ['text', 'string']))
                    ) {
                        $field['size'] = 'full';
                    }
                    if (in_array($property, ['required', 'remember', 'cascading'])) {
                        $finalValue = $value === 'true';
                    } elseif ($property === 'rows') {
                        $finalValue = (int) $value;
                    } else {
                        $finalValue = $value;
                    }
                    // This may override the default value from above.
                    $field[$property] = $finalValue;
                }
            }
            $fields[$fieldName] = $field;
        }
        $result = ['fields' => $fields];
        // Save the form for later use in prepare_field().
        $this->_form = $result;

        return $result;
    }

    private function _get_summary_default($context)
    {
        $test = current($context['tests']);
        $summary = 'Failed test: ' . $test->case->title;

        if ($context['test_count'] > 1) {
            $summary .= ' (+others)';
        }

        return $summary;
    }

    private function _get_description_default($context)
    {
        return $context['test_change']->description;
    }

    private function _to_id_name_lookup($items)
    {
        $result = array();
        foreach ($items as $item) {
            $result[$item->id] = $item->name;
        }
        return $result;
    }

    public function prepare_field($context, $input, $field)
    {
        $data = array();

        // Process those fields that do not need a connection to the
        // GitHub installation.
        if ($field == 'summary' || $field == 'description') {
            switch ($field) {
                case 'summary':
                    $data['default'] = $this->_get_summary_default(
                        $context
                    );
                    break;

                case 'description':
                    $data['default'] = $this->_get_description_default(
                        $context
                    );
                    break;
            }

            return $data;
        }

        // Take into account the preferences of the user, but only
        // for the initial form rendering (not for dynamic loads).
        if ($context['event'] == 'prepare') {
            $prefs = arr::get($context, 'preferences');
        } else {
            $prefs = null;
        }

        // And then try to connect/login (in case we haven't set up a
        // working connection previously in this request) and process
        // the remaining fields.
        $api = $this->_get_api();

        switch ($field) {
            case 'label':
                $data['default'] = arr::get($prefs, 'label');
                $data['options'] = $this->_to_id_name_lookup(
                    $api->get_labels($this->_repo)
                );
                break;

            case 'assignee':
                $data['default'] = arr::get($prefs, 'assignee');
                $data['options'] = $this->_to_id_name_lookup(
                    $api->get_assignees($this->_repo)
                );
                break;

            case 'milestone':
                $data['default'] = arr::get($prefs, 'milestone');
                $data['options'] = $this->_to_id_name_lookup(
                    $api->get_milestones($this->_repo)
                );
                break;
        }

        return $data;
    }

    public function validate_push($context, $input)
    {
    }

    public function push($context, $input, array $paths = []): int
    {
        $api = $this->_get_api();
        return $api->add_issue($input, $paths);
    }

    /**
     * Lookup
     *
     * Creates an array of objects of default field with default and
     * user defined configuration to display on hover popup.
     *
     * @param int $defectId Defect id of an issue.
     *
     * @return array
     */
    public function lookup($defectId)
    {
        $issue = $this->_get_api()->get_issue($defectId);
        $status_id = GI_DEFECTS_STATUS_OPEN;
        $status = $description = null;
        $fullAttributes = [];
        if (isset($issue->url)) {
            $attributes['Repository'] = str::format(
                '<a target="_blank" href="{0}">{1}</a>',
                a("http://github.com/$this->_repo"),
                h($this->_repo)
            );
        }
        $attributes = [];
        if (isset($issue->state)) {
            $status = $issue->state;
            $attributes['Status'] = h($status);
            if ($status === 'closed') {
                $status_id = GI_DEFECTS_STATUS_RESOLVED;
            }
        }
        if (!empty($issue->body)) {
            $description = str::format(
                '<div class="monospace">{0}</div>',
                nl2br(
                    html::link_urls(
                        h($issue->body)
                    )
                )
            );
        }
        $hoverFields = $this->_config['hover.fields'] ?? $this->_hoverDefaultFields;
        $fieldValue = '';
        foreach ($hoverFields as $fieldName => $value) {
            if ($value !== 'on' || in_array($fieldName, ['summary', 'description'])) {
                if ($fieldName === 'description' && $value !== 'on') {
                    $description = null;
                }
                continue;
            }
            $field = arr::get(
                $this->_config,
                "field.settings.$fieldName"
            );
            if (empty($field)) {
                $field = $this->_fieldDefaults[$fieldName] ?? [];
            }
            if ($fieldName === 'milestone') {
                $fieldValue = isset($issue->milestone)
                    ? h($issue->milestone->title)
                    : static::DASH;
            }
            if ($fieldName === 'assignee') {
                $fieldValue = isset($issue->assignee->login)
                    ? h($issue->assignee->login)
                    : static::DASH;
            }
            if ($fieldName === 'label') {
                $fieldValue =  empty($issue->labels)
                    ? static::DASH
                    : implode(', ', array_column($issue->labels, 'name'));
            }
            if (
                in_array($field['type'], ['text', 'string'])
                && (!isset($field['size']) || $field['size'] === 'full')
            ) {
                $fullAttributes[$field['label']] = $fieldValue;
            } else {
                $attributes[$field['label']] = $fieldValue;
            }
        }

        return [
            'id' => $defectId,
            'url' => $issue->html_url,
            'title' => $issue->title,
            'status_id' => $status_id,
            'status' => $status,
            'description' => $description,
            'attributes' => $attributes,
            'fullAttributes' => $fullAttributes
        ];
    }
}
    /**
     * GitHub REST API
     *
     * Wrapper class for the GitHub REST API with functions for
     * retrieving repos, issues etc.
     */
class GitHub_api
{
    private $_address;
    private $_user;
    private $_password;
    private $_repo;
    private $_curl;

    /**
     * Construct
     *
     * Initializes a new GitHub API object. Expects the web address
     * of the GitHub installation including http or https prefix.
     */
    public function __construct($address, $user, $password, $repo)
    {
        $this->_address = str::slash($address);
        $this->_user = $user;
        $this->_password = $password;
        $this->_repo = $repo;
    }

    /**
     * Get Labels
     *
     * Returns a list of labels for the given repo. The labels are
     * returned as array of objects, each with its ID and name.
     */
    public function get_labels($repo)
    {
        $labels = $this->_send_command(
            'GET',
            "repos/$repo/labels"
        );

        $result = array();
        foreach ($labels as $label) {
            $p = obj::create();
            $p->id = (string) $label->name;
            $p->name = (string) $label->name;
            $result[] = $p;
        }

        return $result;
    }

    /**
     * Get Assignees
     *
     * Returns a list of Assignees. The Assignees are returned as
     * array of objects, each with its ID and name.
     */
    public function get_assignees($repo)
    {
        $response = $this->_send_command(
            'GET',
            str::format(
                "repos/{0}/assignees",
                $repo
            )
        );

        if (!$response) {
            return array();
        }

        $result = array();
        foreach ($response as $assignee) {
            $a = obj::create();
            $a->id = (string) $assignee->login;
            $a->name = (string) $assignee->login;
            $result[] = $a;
        }

        return $result;
    }

    /**
     * Get Milestones
     *
     * Returns a list of milestones for the given repo for the GitHub
     * installation. Milestones are returned as array of objects, each
     * with its ID and name.
     */
    public function get_milestones($repo)
    {
        $response = $this->_send_command(
            'GET',
            "repos/$repo/milestones"
        );

        if (!$response) {
            return array();
        }

        $result = array();
        foreach ($response as $milestone) {
            $m = obj::create();
            $m->id = (string) $milestone->number;
            $m->name = (string) $milestone->title;
            $result[] = $m;
        }

        return $result;
    }

    /**
     * Get Issue
     *
     * Gets an existing case from the GitHub installation and returns
     * it. The resulting issue object has various properties such as
     * the summary, description, repo etc.
     */
    public function get_issue($issue_id)
    {
        return $this->_send_command(
            'GET',
            "repos/$this->_repo/issues/" . urlencode($issue_id)
        );
    }

    public function _send_command($method, $command, $data = null)
    {
        $page = 0;
        $limit = 100;
        $response = array();

        do {
            $page++;

            $r = $this->_send_command_batch(
                $method,
                $command,
                $page,
                $limit,
                $data
            );

            if (!is_array($r)) {
                return $r;
            }

            $count = count($r);
            if ($count > 0) {
                $response = array_merge($response, $r);
            }
        } while ($count == $limit);

        return $response;
    }

    private function _send_command_batch(
        $method,
        $command,
        $page,
        $limit,
        $data = null
    ) {
        return $this->_send_request(
            $method,
            str::format(
                '{0}{1}?page={2}&per_page={3}',
                $this->_address,
                $command,
                $page,
                $limit
            ),
            $data
        );
    }

    private function _send_request($method, $url, $data = null)
    {
        if (!$this->_curl) {
            // Initialize the cURL handle. We re-use this handle to
            // make use of Keep-Alive, if possible.
            $this->_curl = http::open();
        }

        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debug('Issuing GitHub HTTP request');
            logger::debugr(
                '$request',
                array(
                    'method' => $method,
                    'url' => $url,
                    'data' => $data
                )
            );
        }

        $response = http::request_ex(
            $this->_curl,
            $method,
            $url,
            array(
                'user' => $this->_user,
                'password' => $this->_password,
                'data' => json::encode($data),
                'headers' => array(
                    'User-Agent' => 'testrail-git',
                    'Content-Type' => 'application/json'
                )
            )
        );

        // In case debug logging is enabled, we append the data we've
        // sent and the entire request/response to the log.
        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debug('Got the following response');
            logger::debugr('$response', $response);
        }

        $obj = json::decode($response->content);

        if ($response->code != 200 && $response->code != 201) {
            switch ($response->code) {
                case '403':
                case '401':
                    $this->_throw_error(
                        'Invalid HTTP code ({0}). Please check your user/' .
                        'password.',
                        $response->code
                    );
                    break;

                case '404':
                    $this->_throw_error(
                        'Invalid HTTP code ({0}). Please check your ' .
                        '[repository] configuration and that the issue ' .
                        'exists in GitHub.',
                        $response->code
                    );
                    break;

                default:
                    $this->_throw_error(
                        'The request to GitHub failed with an invalid ' .
                        'HTTP code ({0}).',
                        $response->code
                    );
                    break;
            }
        }

        return $obj;
    }

    /**
     * Add Issue
     *
     * Adds a new issue to the GitHub installation with the given
     * parameters (title, repo etc.) and returns its identifier.
     * The parameters must be named according to the GitHub API
     * format,
     * e.g.:
     *
     * summary:     The summary of the new issue
     * repo:        The name of the repository
     * milestone:   The ID (number) of the milestone the issue
     *              should be added to
     * description: The description of the new issue
     * assignee:    The login the issue should be assigned to
     */
    public function add_issue(array $options, array $paths): int
    {
        $fields = [];
        foreach ($options as $fieldName => $fieldValue) {
            if (!$fieldValue) {
                continue;
            } else {
                $field = $this->_format_field($fieldName, $fieldValue);
                if (isset($field['name']) && isset($field['value'])) {
                    $fields[$field['name']] = $field['value'];
                }
            }
        }
        $response = $this->_send_command(
            'POST',
            "repos/$this->_repo/issues",
            $fields
        );

        return $response->number;
    }

    /**
     * Format system field as per GitHub API.
     * e.g summary field convert to title
     *
     * @param string       $fieldName  default field name
     * @param string|array $fieldValue user select value in push popup
     *
     * @return array.
     */
    private function _format_field(string $fieldName, $fieldValue): array
    {
        $data['name'] = $fieldName;
        switch ($fieldName) {
            case 'summary':
                $data['name'] = 'title';
                $data['value'] = $fieldValue;
                break;
            case 'description':
                $data['name'] = 'body';
                $data['value'] = $fieldValue;
                break;
            case 'assignee':
            case 'milestone':
                $data['value'] = $fieldValue;
                break;
            case 'label':
                $data['name'] = 'labels';
                $data['value'] = $fieldValue;
                break;
        }

        return $data;
    }

    private function _throw_error($format, $params = null)
    {
        $args = func_get_args();
        $format = array_shift($args);

        if (count($args) > 0) {
            $message = str::formatv($format, $args);
        } else {
            $message = $format;
        }

        throw new GitHubException($message);
    }
}

class GitHubException extends Exception
{
}
