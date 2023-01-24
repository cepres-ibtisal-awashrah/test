<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'plugins/defects/api/GitLabApi.php';

/**
 * GitLab Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for GitLab. Please see
 * http://docs.gurock.com/testrail-integration/defects-plugins for
 * more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */

class GitLab_defect_plugin extends Defect_plugin
{
    private $_api;
    private $_address;
    private $_token;
    private $_projectId;
    private $_config;
    const DASH = '&ndash;';
    private $_defaultPushFields = [
        'title' => 'on',
        'milestone' => 'on',
        'assignees' => 'on',
        'labels' => 'off',
        'confidential' => 'off',
        'due_date' => 'off',
        'description' => 'on'
    ];

    private $_defaultHoverFields = [
        'state' => 'on',
        'milestone' => 'on',
        'assignees' => 'on',
        'description' => 'on',
        'labels' => 'off',
        'confidential' => 'off',
        'due_date' => 'off',
        'author' => 'off',
        'created_at' => 'off',
        'updated_at' => 'off',
        'closed_at' => 'off',
        'closed_by' => 'off',
        'upvotes' => 'off',
        'downvotes' => 'off',
        'weight' => 'off'
    ];

    private $_fieldDefaults = [
        'title' => [
            'type' => 'string',
            'label' => 'Title',
            'size' => 'full',
            'required' => true
        ],
        'due_date' => [
            'type' => 'date',
            'label' => 'Due Date',
            'size' => 'compact',
            'required' => true
        ],
        'milestone' => [
            'type' => 'dropdown',
            'label' => 'Milestone',
            'required' => false,
            'remember' => true,
            'size' => 'compact'
        ],
        'confidential' => [
            'type' => 'bool',
            'label' => 'Confidential',
            'required' => false,
            'remember' => true,
            'size' => 'compact'
        ],
        'assignees' => [
            'type' => 'multiselect',
            'label' => 'Assignees',
            'required' => false,
            'remember' => true,
            'size' => 'full'
        ],
        'labels' => [
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
        ],
        'closed_by' => [
            'type' => 'string',
            'label' => 'Closed By',
        ],
        'author' => [
            'type' => 'string',
            'label' => 'Author',
        ],
        'upvotes' => [
            'type' => 'string',
            'label' => 'Upvotes',
        ],
        'downvotes' => [
            'type' => 'string',
            'label' => 'Downvotes',
        ],
        'weight' => [
            'type' => 'string',
            'label' => 'Weight',
        ],
        'created_at' => [
            'type' => 'datetime',
            'label' => 'Created At',
        ],
        'updated_at' => [
            'type' => 'datetime',
            'label' => 'Updated At',
        ],
        'closed_at' => [
            'type' => 'datetime',
            'label' => 'Closed At',
        ],
        'state' => [
            'type' => 'string',
            'label' => 'State',
        ],
        'attachments' => [
            'type' => 'dropbox',
            'label'=>'attachments',
            'required' => false,
            'size' => 'none',
            'remember' => false,
        ],
    ];

    private static $_meta_defects = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'GitLab defect plugin for TestRail',
        'can_push' => true,
        'can_lookup' => true,
        'default_config' => 
            '; Please configure your GitLab connection below.
; Note: requires GitLab API v4 or later. You
; can alternatively specify a GitLab Enterprise
; server address.
[connection]
address=https://<your-server>/
token=secret
project_id=<gitlab-project-id>

[push.fields]
milestone=on
assignees=on
labels=off
confidential=off
due_date=off
description=on

[hover.fields]
state=on
milestone=on
assignees=on
description=on
labels=off
confidential=off
due_date=off
author=off
created_at=off
updated_at=off
closed_at=off
closed_by=off
upvotes=off
downvotes=off
weight=off
'];

    private static $_meta_references = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'GitLab reference plugin for TestRail',
        'can_push' => false,
        'can_lookup' => true,
        'default_config' => 
            '; Please configure your GitLab connection below.
; Note: requires GitLab API v4 or later. You
; can alternatively specify a GitLab Enterprise
; server address.
[connection]
address=https://<your-server>/
token=secret
project_id=<gitlab-project-id>

[hover.fields]
state=on
milestone=on
assignees=on
description=on
labels=off
confidential=off
due_date=off
author=off
created_at=off
updated_at=off
closed_at=off
closed_by=off
upvotes=off
downvotes=off
weight=off
'];

    /**
     * Get Meta
     *
     * Expected to return meta data for this plugin such as Author,
     * Version, Description and supported plugin capabilities.
     * 
     * @return array
     */
    public function get_meta(): array
    {
        return $this->get_type() === GI_INTEGRATION_TYPE_REFERENCES
            ? static::$_meta_references
            : static::$_meta_defects;
    }
    
    public function __destruct()
    {
        if ($this->_api) {
            $this->_api = null;
        }
    }

    /**
     * Validate Config
     *
     * Validates the plugin configuration that is entered in the site
     * or project settings. Expected to throw a ValidationException
     * in case the passed configuration does not validate.
     * 
     * @param string $config configuration for the plugin as specified 
     * in the site/project settings.
     * 
     * @return void
     *
     * @throws ValidationException
     */
    public function validate_config($config)
    {
        $ini = ini::parse($config);

        if (!isset($ini['connection'])) {
            throw new ValidationException('Missing [connection] group');
        }

        $connection = $ini['connection'];
        $keys = array('address', 'token', 'project_id');

        foreach ($keys as $key) {
            if (!isset($connection[$key]) ||
                !$connection[$key]) {
                throw new ValidationException(
                    "Missing configuration for key '$key'"
                );
            }
        }

        if (!check::url($connection['address'])) {
            throw new ValidationException('Address is not a valid url');
        }

        foreach (['push.fields', 'hover.fields'] as $field) {
            foreach ($ini[$field] ?? [] as $field => $option) {
                if ($option === 'on') { 
                    $this->_validate_field($ini, $field);
                }
            }
        }
    }

    /**
     * Validate field
     * Validate default fields and if invalid 
     * field found then throws error.
     *
     * @param array  $ini   API configuration.
     * @param string $field field name.
     *
     * @return void
     *
     * @throws ValidationException
     */
    private function _validate_field(array $ini, string $field)
    {
        $valid_types = [
            'dropdown' => true,
            'text' => true,
            'string' => true,
            'bool' => true,
            'date' => true,
            'datetime' => true
        ];
        
        $type = arr::get(arr::get($ini, "field.settings.$field"), 'type');
        if ($type && !isset($valid_types[str::to_lower($type)])) {
            throw new ValidationException(
                str::format(
                    'Invalid field type specified in section ' .
                    '[field.settings.{0}]',
                    $field
                )
            );
        }
    }

    /**
     * Configure
     * Parse and store configuration in respective fields. 
     *
     * @param string $config configuration for the plugin 
     * as specified in the site/project settings.
     *
     * @return void
     */
    public function configure($config)
    {
        $ini = ini::parse($config);
        $this->_address = str::slash($ini['connection']['address']);
        $this->_token = $ini['connection']['token'];
        $this->_projectId = $ini['connection']['project_id'];
        $this->_config = $ini;
    }
    
    /**
     * Get API
     * Return existing/new Gitlab_api objects.
     * 
     * @return object
     */
    private function _get_api(): object
    {
        return $this->_api ?? new GitLab_api($this->_address, $this->_token, $this->_projectId);
    }

    /**
     * Prepare Push
     * Creates an array of objects of default fields
     * with default and user defined configuration.
     *
     * @param array $context Context information such 
     * as details about the test case, the test and so on.
     * 
     * @return array
     */
    public function prepare_push($context): array
    {
        $fields = [];
        $fieldsConfig = isset($this->_config['push.fields'])
            ? ['title' => 'on'] + $this->_config['push.fields']
            : $this->_defaultPushFields;
        
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on') {
                continue;
            }

            $field = $this->_fieldDefaults[$fieldName] ?? [];
            $category = arr::get(
              $this->_config,
              "field.settings.$fieldName"
            );
            
            foreach ($category ?? [] as $prop => $val) {
                $property = str::to_lower($prop);
                if ($property === 'label') {
                    $field[$property] = $val;
                    continue;
                }

                $value = str::to_lower($val);
                if (in_array($property, ['required', 'remember', 'cascading'])) {
                    $final_value = $value === 'true';
                } elseif ($property === 'rows') {
                    $final_value = (int) $value;
                } else {
                    $final_value = $value;
                }

                $field[$property] = $final_value;
            }
            
            if (in_array($field['type'], ['date', 'datetime'])) {
                $field['type'] = 'string';
                $field['description'] = 'All dates and times are UTC. '
                    . 'Example: 2000-01-30 12:00';
            } elseif ($field['type'] === 'bool') {
                $field['type'] = 'dropdown';
            } else {
                // NOP
            }

            $fields[$fieldName] = $field;
        }
        $result = ['fields' => $fields];

        return $result;
    }

    /**
     * Get Title Default
     * Builds and return title using context.
     *
     * @param array $context Context information such 
     * as details about the test case, the test and so on.
     * 
     * @return string
     */
    private function _get_title_default(array $context): string
    {
        return 'Failed test: ' . current($context['tests'])->case->title . ($context['test_count'] > 1 ? ' (+others)' : '');
    }

    /**
     * Get Description Default
     * Builds and return description using context.
     *
     * @param array $context Context information such 
     * as details about the test case, the test and so on.
     * 
     * @return string
     */
    private function _get_description_default(array $context): string
    {
        return $context['test_change']->description;
    }
    
    /**
     * Get Option List
     * Builds and returns the option list for given array of object
     *
     * @param array $items Items array.
     * 
     * @return array
     */
    private function _get_option_list(array $items): array
    {
        $result = [];
        foreach ($items as $item) {
            $result[$item->id] = $item->name;
        }

        return $result;
    }

    /**
     * Prepare Field
     * Called for each field of the push form to gather the field
     * data for the form. The plugin can return default values or
     * available options for the field (in case of a dropdown box,
     * for example), among other values.
     *
     * @param array  $context Context information such as details 
     * about the test case, the test and so on.
     * @param array  $input   Input data the user has entered in the
     * push dialog.
     * @param string $field   Field name 
     * 
     * @return array
     */
    public function prepare_field($context, $input, $field): array
    {
        $data = [];
        /** @var GitLab_api $api */
        $api = $this->_get_api();
        $prefs = $context['event'] === 'prepare' 
            ? arr::get($context, 'preferences') 
            : null;

        switch ($field) {
            case 'title':
                $data['default'] = $this->_get_title_default(
                    $context);
                break;
            case 'description':
                $data['default'] = $this->_get_description_default(
                    $context);
                break;
            case 'confidential':
                $data['default'] = 'False';
                $data['options'] = [
                    'True' => 'True',
                    'False' => 'False'
                ];
                break;
            case 'labels':
                $data['default'] = arr::get($prefs, 'labels');
                $data['options'] = $this->_get_option_list(
                    $api->get_labels()
                );
                break;
            case 'assignees':
                $data['default'] = arr::get($prefs, 'assignees');
                $data['options'] = $this->_get_option_list(
                    $api->get_assignees()
                );
                break;
            case 'milestone':
                $data['default'] = arr::get($prefs, 'milestone');
                $data['options'] = $this->_get_option_list(
                    $api->get_milestones($this->_projectId)
                );
                break;
        }
        
        return $data;
    }
    
    /**
     * Push
     *
     * Executes the actual push request by adding a new issue to the
     * Gitlab.
     * @param array $context Context information such as details 
     * about the test case, the test and so on.
     * @param array $input Input data the user has entered in the push dialog.
     * @param array $paths User uploaded file path.
     *
     * @return integer 
     */	
    public function push($context, $input, array $paths = [])
    {
        return $this->_get_api()->add_issue($input, $paths);
    }

    /**
     * Return field value for all default and custom.
     *
     * @param object $issue Current issue details
     * @param string $fieldName Configured field name
     *
     * @return string
     */
    private function _getAttributeValue(object $issue, string $fieldName): string
    {
        switch ($fieldName) {
            case 'milestone':
                $value = $this->_getMilestoneValue($issue);
                break;
            case 'labels':
                $value = $this->_getLabelsValue($issue, $fieldName);
                break;
            case 'assignees':
                $value = $this->_getAssigneesNames($issue);
                break;
            case 'closed_by':
            case 'author':
                $value = $this->_getByName($issue, $fieldName);
                break;
            case 'upvotes':
            case 'downvotes':
                $value = h($issue->$fieldName);
                break;
            case 'confidential':
                $value = $issue->$fieldName ? 'True' : 'False';
                break;
            case 'due_date':
                $value = empty($issue->$fieldName) 
                    ? self::DASH 
                    : date::format_short_date(strtotime($issue->$fieldName));
                break;
            case 'created_at':
            case 'updated_at':
            case 'closed_at':
                $value = empty($issue->$fieldName) 
                    ? self::DASH 
                    : date::format_short_datetime(strtotime($issue->$fieldName));
                break;
            default:
                $value = empty($issue->$fieldName) 
                    ? self::DASH 
                    : h($issue->$fieldName);
        }

        return $value;
    }
    
    /**
     * Returns milestone value for the given issue.
     *
     * @param object $issue Current issue details
     *
     * @return string
     */
    private function _getMilestoneValue(object $issue): string
    {
        return !empty($issue->milestone->title)
            ? h($issue->milestone->title) 
            : self::DASH;
    }

    /**
     * Returns comma separated values of labels for the given issue.
     *
     * @param object $issue Current issue details
     * @param string $fieldName Configured field name
     *
     * @return string
     */
    private function _getLabelsValue(object $issue, string $fieldName): string 
    {	
        $labels = $issue->$fieldName;

        return empty($labels) 
            ? self::DASH 
            : h(implode(', ', $labels));
    }

    /**
     * Returns comma separated assignees names for the given issue.
     *
     * @param object $issue Current issue details
     *
     * @return string
     */
    private function _getAssigneesNames(object $issue): string
    {
        $assignees = $issue->assignees;
        if (empty($assignees)) {
            return self::DASH;
        }

        $names = [];
        foreach ($assignees as $assignee) { 
            array_push($names, $assignee->name);
        }

        return h(implode(', ', $names));
    }

    /**
     * Returns names for the configured field of the given issue.
     *
     * @param object $issue Current issue details
     *
     * @return string
     */
    private function _getByName(object $issue, string $fieldName): string
    {
        return empty($issue->$fieldName) 
            ? self::DASH 
            : h($issue->$fieldName->name);
    }
    
    /**
     * LOOKUP
     * 
     * Creates an array of objects of default fields with default and 
     * user defined configuration to display on hover popup.
     * 
     * @param int $issueId Issue id of an issue.
     * 
     * @return array
     */
    public function lookup($issueId)
    {
        $issue = $this->_get_api()->get_issue($issueId);
        $description = null;
        $fieldsConfig = $this->_config['hover.fields'] ?? $this->_defaultHoverFields;
        $attributes = [];
        $status = $issue->state ?? '';
        $status_id = !empty($issue->state) && $issue->state === 'closed' 
            ? GI_DEFECTS_STATUS_RESOLVED
            : GI_DEFECTS_STATUS_OPEN;

        if (!empty($issue->description)) {
            $description = str::format(
                '<div class="monospace">{0}</div>',
                nl2br(
                    html::link_urls(
                        h($issue->description)
                    )
                )
            );
        }

        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on' || $fieldName === 'description') {
                continue;
            }
            
            $field = $this->_fieldDefaults[$fieldName] ?? '';
            $attributes[$field['label']] = $this->_getAttributeValue($issue, $fieldName);
        }
        
        return array(
            'id' => $issueId,
            'url' => str::format(a($issue->web_url)),
            'title' => $issue->title,
            'status_id' => $status_id,
            'status' => $status,
            'description' => $description,
            'attributes' => $attributes
        );
    }
}