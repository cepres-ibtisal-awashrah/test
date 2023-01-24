<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Assembla Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for Assembla. Please see
 * http://docs.gurock.com/testrail-integration/defects-plugins for
 * more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */

if (!class_exists(Defect_plugin::class)) {
    require_once APPPATH . 'base/plugins/defect.php';
}

class Assembla_defect_Plugin extends defect_plugin
{
    const ASSEMBLA_DEFECT_PLUGIN_NAME = 'assembla';
    const DASH = "&ndash;";

    private $_api;
    private $_address;
    private $_key;
    private $_secret;
    private $_space;
    private $_customFields = [];
    private $_form;
    private $_token;
    private $_defaultFields = [
        'summary' => 'on',
        'description' => 'on',
        'priority' => 'on',
        'milestone' => 'on',
        'tags' => 'on',
        'attachments' => 'on',
        'assignedto' => 'on',
        'duedate' => 'on',
        'tags' => 'on',
        'planlevel' => 'on'
    ];
    private $_hoverDefaultFields = [
        'space' => 'on',
        'owner' => 'on',
        'status' => 'on',
        'reportedby' => 'on',
        'priority' => 'on',
        'milestone' => 'on',
        'description' => 'on',
        'duedate' => 'on',
        'owner' => 'on'
    ];
    private $_field_defaults = [
        'summary' => [
            'type' => 'string',
            'label' => 'Summary',
            'size' => 'full',
            'required' => true
        ],
        'priority' => [
            'type' => 'dropdown',
            'label' => 'Priority',
            'required' => false,
            'remember' => true,
            'size' => 'compact'
        ],
        'assignedto' => [
            'type' => 'dropdown',
            'label' => 'Assigned to',
            'required' => false,
            'remember' => true,
            'size' => 'compact'
        ],
        'milestone' => [
            'type' => 'dropdown',
            'label' => 'Milestone',
            'required' => false,
            'remember' => true,
            'size' => 'compact'
        ],
        'status' => [
            'type' => 'string',
            'label' => 'Status',
            'size' => 'compact'
        ],
        'description' => [
            'type' => 'text',
            'label' => 'Description',
            'required' => false,
            'rows' => 10
        ],
        'tags' => [
            'type' => 'multiselect',
            'label' => 'Tags',
            'size' => 'full',
            'required' => false,
            'rows' => 10
        ],
        'duedate' => [
            'type' => 'date',
            'label' => 'Due Date',
            'required' => false,
            'size' => 'compact',
            'rows' => 3
        ],
        'reportedby' => [
            'type' => 'string',
            'label' => 'Reported by',
            'size' => 'compact'
        ],
        'space' => [
            'type' => 'string',
            'label' => 'Space',
            'size' => 'compact'
        ],
        'owner' => [
            'type' => 'string',
            'label' => 'Owner',
            'size' => 'compact'
        ],
        'planlevel' => [
            'type' => 'dropdown',
            'label' => 'Plan Level',
            'required' => false,
            'rows' => 10
        ],
        'attachments' => [
            'type' => 'dropbox',
            'label' => 'attachments',
            'required' => false,
            'size' => 'none'
        ]
    ];

    private static $_meta = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'Assembla defect plugin for TestRail',
        'can_push' => true,
        'can_lookup' => true,
        'default_config' =>
            '; Please configure your Assembla connection and API
; settings below. The API key and secret is per user
; and can be found in the Assembla user profiles.
[connection]
address=https://api.assembla.com/
key=testrail
secret=secret
space=name

[push.fields]
description=on
priority=on
milestone=on
attachments=on
assignedto=on
tags=off
planlevel=off
duedate=off

[hover.fields]
space=off
status=on
priority=off
description=on
milestone=on
owner=on
tags=on
planlevel=on
reportedby=on
duedate=on
',
        'oauth_token_config' =>
            '; Please configure your Assembla connection and API
; settings below. The API key and secret is per user
; and can be found in the Assembla user profiles.
[connection]
address=https://api.assembla.com/
token=%user_access_token%
space=name

[push.fields]
description=on
priority=on
milestone=on
attachments=on
assignedto=on
tags=off
planlevel=off
duedate=off

[hover.fields]
space=off
status=on
priority=off
description=on
milestone=on
owner=on
tags=on
planlevel=on
reportedby=on
duedate=on
'];

    public function get_meta()
    {
        return self::$_meta;
    }

    /**
     * Valid config.
     *
     * Validates all configurations for basic parameters such as connection,URLs
     *
     * @param string $config String configuration set by user.
     *
     * @return void
     **/
    public function validate_config($config)
    {
        $ini = ini::parse($config);

        if (!isset($ini['connection'])) {
            throw new ValidationException('Missing [connection] group');
        }

        $keys = array_key_exists('token', $ini['connection'])
            ? ['address', 'token', 'space']
            : ['address', 'key', 'secret', 'space'];

        // Check required values for existance
        foreach ($keys as $key) {
            if (!isset($ini['connection'][$key]) ||
                !$ini['connection'][$key]) {
                throw new ValidationException(
                    "Missing configuration for key '$key'"
                );
            }
        }

        if (!check::url($ini['connection']['address'])) {
            throw new ValidationException('Address is not a valid url');
        }
        $this->_ensure_valid_fields('push.fields', $ini);
        $this->_ensure_valid_fields('hover.fields', $ini);
    }

    /**
     * Ensure Valid fields
     *
     * Validate all push and hover fields which are set '=on'
     *
     * @param string $field_list Field List
     * @param array  $ini
     *
     * @return void
     **/
    private function _ensure_valid_fields(string $field_list, array $ini)
    {
        foreach ($ini[$field_list] ?? [] as $field => $option) {
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
     * @param string $field field name.
     *
     * @return void
     *
     * @throws ValidationException
     **/
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
        $this->_address = str::slash($connection['address']);
        $this->_space = $ini['connection']['space'];

        if (isset($ini['connection']['key'])) {
            $this->_key = $connection['key'];
            $this->_secret = $connection['secret'];
        }

        if (isset($ini['connection']['token'])) {
            $this->_token = $connection['token'];
        }
        $this->_config = $ini;
    }

    /**
     * Get API
     * Gets API object of Assembla API class.
     *
     * @return assembla api object
     **/
    private function _get_api()
    {
        global $_token;

        if ($this->_api) {
            return $this->_api;
        }

        $this->_api = new Assembla_api(
            $this->_address,
            $this->_key,
            $this->_secret,
            $this->_space,
            $this->_token
        );

        return $this->_api;
    }

    /**
     * Prepare Push
     *
     * Creates an array of objects of default fields
     * with default and user defined configuration.
     *
     * @param array $context default configuration.
     *
     * @return array$fields fields configured
     **/
    public function prepare_push($context)
    {
        $fields = [];
        $fieldsConfig = isset($this->_config['push.fields'])
            ? ['summary' => 'on'] + $this->_config['push.fields']
            : $fieldsConfig = $this->_defaultFields;

        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on') {
                continue;
            }
            $field = $this->_field_defaults[$fieldName] ?? [];
            $category = arr::get(
                $this->_config,
                "field.settings.$fieldName"
            );

            if ($category) {
                foreach ($category as $prop => $val) {
                    //except label value remaning all values should be downcase.
                    $property = str::to_lower($prop);
                    if ($property === 'label') {
                        $field[$property] = $val;
                        continue;
                    }
                    $value = str::to_lower($val);
                    if (in_array($property, ['required', 'remember', 'cascading'])) {
                        $value = $value === 'true';
                    } elseif ($property === 'rows') {
                        $value = (int)$value;
                    } else {
                        // NOP
                    }
                    // This may override the default value from above.
                    $field[$property] = $value;
                }
            }
            if (in_array($field['type'], ['date', 'datetime'])) {
                $field['type'] = 'string';
                $field['description'] = 'All dates and times are UTC. '
                    . 'Example: 2000-01-30 12:00';
            }
            $fields[$fieldName] = $field;
        }
        $result = ['fields' => $fields];
        $this->_form = $result;

        return $result;
    }

    /**
     * Find custom field by Id
     *
     * Find custom field object in array of objects using ID.
     *
     * @param int   $id           Custom field ID
     * @param array $customFields Array of custom fields
     *
     * @return object
     */
    private function _find_custom_field_by_id(int $id, array $customFields)
    {
        $returnedValue = null;
        foreach ($customFields as $element) {
            if ($id === $element->id) {
                $returnedValue = $element;
                break;
            }
        }

        return $returnedValue;
    }

    /**
     * Get Summary Default
     *
     * Get the default value of the summary
     *
     * @param array $context Default configuration.
     *
     * @return object
     */
    private function _get_summary_default($context)
    {
        $test = current($context['tests']);
        $summary = 'Failed test: ' . $test->case->title;

        if ($context['test_count'] > 1) {
            $summary .= ' (+others)';
        }

        return $summary;
    }

    /**
     * Get Description Default
     *
     * Get the default value of the description
     *
     * @param array $context Default configuration.
     *
     * @return object
     **/
    private function _get_description_default($context)
    {
        return $context['test_change']->description;
    }

    /**
     * To Id Name lookup
     *
     * Assign name to the Id field
     *
     * @param array|object $items Default configuration.
     *
     * @return array|object
     **/
    private function _to_id_name_lookup($items)
    {
        $result = [];
        foreach ($items as $item) {
            $result[$item->id] = $item->name;
        }

        return $result;
    }

    /**
     * Prepare Fields
     *
     * Prepares Fields
     *
     * @param object $context default configuration.
     * @param array  $input   Input fields
     * @param string $field   configured field
     *
     * @return array
     **/
    public function prepare_field($context, $input, $field)
    {
        $data = [];
        $descriptionFieldName = 'description';

        if (in_array($field, [$descriptionFieldName, 'summary'])) {
            $data['default'] = $field === $descriptionFieldName ? $this->_get_description_default($context)
                : $this->_get_summary_default($context);
        }

        if ($context['event'] == 'prepare') {
            $prefs = arr::get($context, 'preferences');
        } else {
            $prefs = null;
        }

        $api = $this->_get_api();
        $options = [
            'assignedto' => $api->get_users($this->_space),
            'milestone' => $api->get_milestones($this->_space),
            'priority' => $api->get_priorities($this->_space),
            'tags' => $api->get_space_tags($this->_space),
            'planlevel' => $api->get_planLevel($this->_space)
        ];
        foreach ($options as $fieldName => $items) {
            if ($fieldName === $field) {
                $data['default'] = arr::get($prefs, $fieldName);
                $data['options'] = $fieldName === 'planlevel' ? $items :
                    $this->_to_id_name_lookup($items);
            }
        }
        if (str::starts_with($field, 'customfield_')) {
            $data['default'] = arr::get($prefs, $field);
            $data['options'] = $this->_get_default_customfield_values(
                $api,
                $field
            );
        }

        return $data;
    }

    /**
     * Push
     *
     * Method for pushing defect
     *
     * @param object $context default configuration.
     * @param array  $input
     * @param array  $path    file paths for attachment
     *
     * @return string
     **/
    public function push($context, $input, $path = []): int
    {
        return $this->_get_api()->add_ticket($input, $path);
    }

    /**
     * Get Default Customfield Values.
     *
     * @param object $api Assembla API object.
     * @param string $id  Defect field name.
     *
     * @return object
     */
    private function _get_customfield_values(object $api, int $id): object
    {
        $customField = $this->_find_custom_field_by_id($id, $this->_customFields);

        if (!isset($customField)) {
            $this->_customFields = $api->get_customfields();
            $customField = $this->_find_custom_field_by_id($id, $this->_customFields);
        }

        return $customField;
    }

    /**
     * Get default customfield values
     *
     * Get default customfield values
     *
     * @param object $api       Assembla API.
     * @param string $fieldName Custom field id.
     *
     * @return object|null.
     */
    private function _get_default_customfield_values(
        object $api,
        string $fieldName
    ) {
        $customField = $this->_get_customfield_values(
            $api,
            str::replace(
                $fieldName,
                'customfield_',
                ''
            )
        );
        $returnedValue = [];

        if (isset($customField)) {
            $returnedValue = $customField->default_value;
            $fieldFormat = $customField->type;

            if (in_array($fieldFormat, ['List', 'Team list'])) {
                $returnedValue =
                    $customField->list_options;
            }
            if ($fieldFormat === 'Checkbox') {
                $returnedValue = ['No', 'Yes'];
            }

            return $returnedValue;
        }
    }

    /**
     * Lookup
     *
     * Creates an array of objects of default and user
     * defined configuration to display on hover popup.
     *
     * @param string $ticket_number     Ticket Number of an issue.
     * @param string $oauthPortfolioUrl oAuth parameter.
     *
     * @return array
     */
    public function lookup($ticket_number, string $oauthPortfolioUrl = null): array
    {
        if (!is_numeric($ticket_number)) {
            $ticket_number = preg_replace('/[^0-9,.]+/', '', $ticket_number);
        }
        if (!$oauthPortfolioUrl) {
            $oauthPortfolioUrl = $this->_address;
        }
        $api = $this->_get_api();
        $ticket = $api->get_ticket($ticket_number);
        $attributes = [];
        $fullAttributes = [];
        $description = null;
        $status_id = GI_DEFECTS_STATUS_OPEN;
        // Fixed is one of the default closed states
        $status_id = $ticket->status === 'Fixed'
                ? GI_DEFECTS_STATUS_RESOLVED
                : GI_DEFECTS_STATUS_CLOSED;

        // Add some important attributes for the ticket such as the
        // type, current status and project. Note that the
        // attribute values (and description) support HTML and we
        // thus need to escape possible HTML characters (with 'h')
        // in this plugin.
        if (isset($this->_space)) {
            // Add a link to the project.
            $attributes['Space'] = str::format(
                '<a target="_blank" href="{0}/spaces/{1}">{2}</a>',
                $oauthPortfolioUrl,
                a($ticket->space_id ?? $this->_space),
                h($this->_space)
            );
        }

        if (isset($ticket->status)) {
            $status = $ticket->status;
        }
        $hoverFields = $this->_config['hover.fields'] ?? $this->_hoverDefaultFields;
        foreach ($hoverFields as $fieldName => $option) {
            $value = null;
            if ($option !== 'on' || in_array($fieldName, ['summary', 'attachments'])) {
                continue;
            }
            $field = arr::get(
                $this->_config,
                "field.settings.$fieldName"
            );
            if (empty($field)) {
                $field = $this->_field_defaults[$fieldName] ?? [];
            }
            if ($fieldName === 'status') {
                $value = h($ticket->status);
            }
            if ($fieldName === 'owner') {
                if (isset($ticket->assigned_to_id)) {
                    $owner = $api->get_user($ticket->assigned_to_id);
                    if (isset($owner)) {
                        $value = $owner->name;
                    }
                }
            }
            if ($fieldName === 'reportedby') {
                if (isset($ticket->reporter_id)) {
                    $reporter = $api->get_user($ticket->reporter_id);
                    if ($reporter) {
                        $value = $reporter->name;
                    }
                }
            }
            if ($fieldName === 'milestone') {
                if (isset($ticket->milestone_id)) {
                    $milestone = $api->get_milestone($ticket->milestone_id);
                    if ($milestone) {
                        $value = $milestone->title;
                    }
                }
            }
            if ($fieldName === 'priority') {
                if (isset($ticket->priority)) {
                    $priority = $api->get_priority($ticket->priority);
                    if ($priority) {
                        $value = $priority->name;
                    }
                } else {
                    $value = Assembla_defect_plugin::DASH;
                }
            }
            if ($fieldName === 'planlevel') {
                $planLevalValues = $api->get_planLevel();
                $value = $planLevalValues[$ticket->hierarchy_type];
            }
            if ($fieldName === 'tags') {
                $tagArray = [];
                $tags = $api->get_ticket_tags($ticket->number);
                if (!empty($tags)) {
                    foreach ($tags as $key) {
                        $tagArray[] = $key->name;
                    }
                }
                $value = implode(',', $tagArray)
                        ?? Assembla_defect_plugin::DASH;
            }
            if ($fieldName === 'duedate') {
                $value = !empty($ticket->due_date)
                        ? date::format_short_date(strtotime($ticket->due_date))
                        : Assembla_defect_plugin::DASH;
            }
            if ($fieldName === 'space') {
                $value = $this->_space;
            } elseif (str::starts_with($fieldName, 'customfield_')) {
                if (!isset($field)) {
                    continue;
                }
                $array = json_decode(json_encode($ticket->custom_fields), true);
                $cfield = $api->get_Custom_Field_By_Id(
                    str::replace($fieldName, 'customfield_', '')
                );
                $value = $array[$cfield->title];
                if ($cfield->type === 'Date') {
                    $value = date::format_short_date(
                        strtotime($array[$cfield->title])
                    );
                }
                if ($cfield->type === 'Date Time') {
                    $value = date::format_short_datetime(
                        strtotime($array[$cfield->title])
                    );
                }
            }
            $finalValue = !empty($value) ? $value : Assembla_defect_plugin::DASH;
            if ($fieldName === 'description' && isset($ticket->description)) {
                $description = str::format(
                    '<div class="monospace">{0}</div>',
                    nl2br(
                        html::link_urls(
                            h($ticket->description)
                        )
                    )
                );
            } elseif (in_array($field['type'], ['text', 'string']) && (!isset($field['size']) || $field['size'] === 'full')) {
                $fullAttributes[$field['label']] = str::format(
                    '<div class="monospace">{0}</div>',
                    strip_tags(html_entity_decode($finalValue))
                );
            } else {
                $attributes[$field['label']] = $finalValue;
            }
        }

        return [
                'id' => $ticket_number,
                'url' => str::format(
                    '{0}/spaces/{1}/tickets/{2}',
                    $oauthPortfolioUrl,
                    a($this->_space),
                    h($ticket_number)
                ),
                'title' => $ticket->summary,
                'status_id' => $status_id,
                'status' => $status,
                'description' => $description,
                'attributes' => $attributes,
                'fullAttributes' => $fullAttributes
            ];
    }

    /**
     * Checking that Assembla integration exists overall or by project.
     *
     * @oaram object $project
     *
     * @return bool
     */
    public static function isAssmeblaDefectPlugin($project): bool
    {
        return strtolower(defects::get_current_plugin($project)) === static::ASSEMBLA_DEFECT_PLUGIN_NAME
            && (
                !empty($project->defect_plugin)
                && strtolower($project->defect_plugin) === static::ASSEMBLA_DEFECT_PLUGIN_NAME
            );
    }

    /**
     * Changing Assembla ticket number to correct format
     *
     * @param $stringWithUrls
     *
     * @return string
     */
    public static function formatAssemblaTicketNumber($stringWithUrls)
    {
        $urls = [];
        foreach (explode(',', $stringWithUrls) as $url) {
            preg_match_all('/ticket=(.*)">/', $url, $matches);
            $validTicketNumber = preg_replace('/[^0-9]/', '', $matches[1][0] ?? '');
            $preparedUrl = str_replace(
                $matches[0][0] ?? '',
                'ticket=' . $validTicketNumber . '">',
                $url
            );

            $urls[] = preg_replace(
                '/rel="(.*?)"/',
                'rel="' . $validTicketNumber . '"',
                $preparedUrl
            );
        }

        return join(', ', $urls);
    }
}

/**
 * Assembla REST API
 *
 * Wrapper class for the Assembla API with functions for retrieving
 * projects, getting and adding tickets etc.
**/
class Assembla_api
{
    const ATTACHMENT_URL = 'https://bigfiles.assembla.com/v1/spaces/';
    const DOCUMENT_SITE_ID = 18;

    private static $_priorities = [
        '1' => 'Highest',
        '2' => 'High',
        '3' => 'Normal',
        '4' => 'Low',
        '5' => 'Lowest',
    ];

    private $_allowed_status_codes = [
        '200',
        '201',
        '204'
    ];

    private $_address;
    private $_key;
    private $_secret;
    private $_space;
    private $_curl;
    private $_token;
    private $_api;

    private $_config;

    public function init($config)
    {
        $this->_config = $config;
    }

    // *********************************************************
    // CONSTRUCT / DESTRUCT
    // ********************************************************
    public function __destruct()
    {
        if ($this->_api) {
            $this->_api = null;
        }
    }

    /**
     * Construct
     *
     * Initializes a new Assembla API object. Expects the web address
     * of the Assembla API endpoint (e.g. api.assembla.com) including
     * http or https prefix.
     *
     * @params string $address
     * @params string $key
     * @params string $secret
     * @params string $space
     * @params string $token
     */
    public function __construct($address, $key, $secret, $space, $token)
    {
        $this->_address = str::slash($address);
        $this->_key = $key;
        $this->_secret = $secret;
        $this->_space = $space;
        $this->_token = $token;
    }

    /**
     * Get Customfields
     *
     * Gets all custome fields created at assembla for the space.
     *
     * @return array
     **/
    public function get_customfields(): array
    {
        return $this->_send_command('GET', "spaces/$this->_space/tickets/custom_fields");
    }

    /**
     * Get Priorities
     *
     * Returns a list of priorities for the given project. Priorities
     * are returned as array of objects, each with its ID and name.
     *
     * @return void
     **/
    public function get_priorities()
    {
        // The priorities are hard-coded since there's no API for
        // this as it appears.
        $result = [];
        foreach (self::$_priorities as $priorityId => $name) {
            $result[]= (object) [
                'id' =>  $priorityId ,
                'name' => $name
            ];
        }

        return $result;
    }

    /**
     * Get Space tags
     *
     * @param string $space space name for fetching data
     *
     * @return object
     **/
    public function get_space_tags($space): array
    {
        $response = $this->_send_command(
            'GET',
            "spaces/$space/tags"
        );
        if (!$response) {
            return [];
        }
        $result = [];
        foreach ($response as $tag) {
            $result[] = (object) [
                'id' =>  $tag->name,
                'name' => $tag->name
            ];
        }

        return $result;
    }

    /**
     * Get Priority
     *
     * Returns the priority for a given user priority ID.
     *
     * @param int $priority_id priorityid of an assembla ticket.
     *
     * @return array
     */
    public function get_priority($priority_id)
    {
        $name = arr::get(self::$_priorities, $priority_id);
        if (!$name) {
            return null;
        }

        return (object) [
            'id' => $priority_id,
            'name' => $name
        ];
    }

    /**
     * Get Users
     *
     * Returns a list of users for the given project for the Assembla
     * installation. Users are returned as array of objects, each
     * with its ID and name.
     *
     * @param string $space space name.
     *
     * @return array
     */
    public function get_users($space)
    {
        $response = $this->_send_command(
            'GET',
            "spaces/$space/users"
        );
        if (!$response) {
            return [];
        }
        $result = [];
        foreach ($response as $user) {
            $result[] = (object) [
                'id' =>  $user->id,
                'name' => $user->name
            ];
        }

        return $result;
    }

    /**
     * Get User
     *
     * Returns the user for a given user ID.
     *
     * @param int $user_id userId.
     *
     * @return object|null
     */
    public function get_user($user_id)
    {
        return $this->_send_command('GET', 'users/' . $user_id);
    }

    /**
     * Get Milestones
     *
     * Returns a list of milestones for the given project for the
     * Assembla installation. Milestones are returned as array of
     * objects, each with its ID and title.
     *
     * @param string $space space name.
     *
     * @return array
     */
    public function get_milestones($space)
    {
        $response = $this->_send_command(
            'GET',
            "spaces/$space/milestones?per_page=100"
        );

        if (!$response) {
            return [];
        }

        $result = [];
        foreach ($response as $milestone) {
            $result[] = (object) [
                'id' =>  (string) $milestone->id,
                'name' => (string) $milestone->title
            ];
        }

        return $result;
    }

    /**
     * Get Milestone
     *
     * Returns the milestone for a given milestone ID.
     *
     * @param int $milestone_id milestone ID
     *
     * @return object Milestone object already created.
     */
    public function get_milestone($milestone_id)
    {
        return $this->_send_command(
            'GET',
            "spaces/$this->_space/milestones/$milestone_id"
        );
    }

    /**
     * Get Plan Level
     *
     * @return array
     **/
    public function get_planLevel() : array
    {
        return [
          0 => 'No plan level',
          1 => 'Subtask',
          2 => 'Story',
          3 => 'Epic',
        ];
    }

    /**
     * Get Ticket
     *
     * Gets an existing ticket from the Assembla installation and
     * returns it. The resulting ticket object has various properties
     * such as the summary, description etc.
     * options
     *
     * @param int $ticket_id ticket id for fetching data
     *
     * @return object
     **/
    public function get_ticket(int $ticket_id)
    {
        return $this->_send_command(
            'GET',
            "spaces/$this->_space/tickets/$ticket_id"
        );
    }

    /**
     * Get Ticket tags
     *
     * @param int $ticketId ticket id for fetching data
     *
     * @return array
     **/
    public function get_ticket_tags(int $ticketId): array
    {
        return $this->_send_command(
            'GET',
            "spaces/$this->_space/tickets/$ticketId/tags"
        ) ?? [];
    }

    /**
     * Send Command
     *
     * Construct the actual url and sends an API request using the
     * default address of the configuration. Appends the path to resource and
     * base address, then calls _sendRequest.
     *
     * @param string     $method  Http method.
     * @param string     $command Relative path.
     * @param null|array $data    Input data for post request.
     *
     * @return array|object
     */
    private function _send_command($method, $command, $data = null)
    {
        return $this->_send(
            $method,
            $this->_address
            . 'v1/'
            . $command,
            $data
        );
    }

    private function _send($method, $url, $data = null)
    {
        if (!$this->_curl) {
            // Initialize the cURL handle. We re-use this handle to
            // make use of Keep-Alive, if possible.
            $this->_curl = http::open();
        }

        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debug('Issuing Assembla HTTP REST request');
            logger::debugr(
                'request',
                [
                    'method' => $method,
                    'url' => $url,
                    'data' => $data
                ]
            );
        }

        if (!empty($this->_key)) {
            $request_headers = [
                'user' => $this->_key,
                'data' => json::encode($data),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Api-Key' => $this->_key,
                    'X-Api-Secret' => $this->_secret
                ]
            ];
        } else {
            $request_headers = [
                'data' => json::encode($data),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$this->_token
                ]
            ];
        }

        $response = http::request_ex(
            $this->_curl,
            $method,
            $url,
            $request_headers
        );

        // In case debug logging is enabled, we append the data we've
        // sent and the entire request/response to the log.
        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debug('Got the following response');
            logger::debugr('$response', $response);
        }

        $obj = json::decode($response->content);
        if ($response->code === 401) {
            $this->_refresh_oauth_token($data);
            $obj = self::_send_request($method, $url, $data);
        } elseif (!in_array($response->code, $this->_allowed_status_codes)) {
            $this->_throw_error(
                'Invalid HTTP code ({0}). Please check your API key, ' .
                'secret or oauth token and configured space.',
                $response->code
            );
        }

        return $obj;
    }

    /**
    * Refresh Oauth Token
    *
    * Returns the oauth refresh token for the given token.
    *
    * @param object $data
    *
    */
    private function _refresh_oauth_token($data)
    {
        $refresh_token_details = users::generate_refresh_token_details($this->_token);
        $refresh_token = $refresh_token_details['refresh_token'];
        if ($refresh_token) {
            $refresh_request_headers = [
                'user' => $this->_key,
                'data' => json::encode($data),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Api-Key' => $this->_key,
                    'X-Api-Secret' => $this->_secret
                ]
            ];

            $refresh_response = http::request_ex(
                $this->_curl,
                'POST',
                $refresh_token_details['refresh_token_url'],
                $refresh_request_headers
            );
            $refresh_output = json_decode($refresh_response->content, true);
            $new_access_token = isset($refresh_output['access_token']) ? $refresh_output['access_token'] : false;
            if ($new_access_token) {
                users::refresh_oauth_access_token(
                    $new_access_token,
                    $this->_token,
                    $refresh_token,
                    $refresh_output['expires_in']
                );
                $this->_token = $new_access_token;
            } elseif (!in_array($refresh_response->code, $this->_allowed_status_codes)) {
                $this->_throw_error(
                    'Invalid HTTP code ({0}). Please check your oauth token, ' .
                    ' and configured space.',
                    $refresh_response->code
                );
            }
        } else {
            $this->_throw_error(
                'Please check your oauth token and configured space.'
            );
        }
    }

    /**
     * Add Ticket
     *
     * Adds a new ticket to the Assembla installation with the given
     * parameters (summary, priority etc.) and returns its ID. The
     * parameters must be named according to the Assembla API format,
     * e.g.:
     *
     * summary: The summary of the new ticket
     * priority: The ID of the priority the ticket should be
     *          added with
     * assignedto: The ID of the user the ticket should be
     *             assigned to
     * milestone: The ID of the milestone the ticket should be
     *            added with
     * description: The description of the new ticket
     * Attachments: Files attached to the ticket
     *
     * @param array $options options array
     * @param array $paths   File paths
     *
     * @return int ticketId saved ticket Id on assembla
     **/
    public function add_ticket(array $options, array $paths): int
    {
        $fields = [];
        $customFieldData = [];
        $tag = [];
        foreach ($options as $fieldName => $fieldValue) {
            if (!$fieldValue) {
                continue;
            }
            $field = $this->_format_field($fieldName, $fieldValue);

            if (str::starts_with($fieldName, 'customfield_')) {
                $customField = $this->get_Custom_Field_By_Id(
                    str::replace($fieldName, 'customfield_', '')
                );
                $fieldFormat = $customField->type;
                if (in_array($fieldFormat, ['List', 'Team list'])) {
                    $possible_values = $customField->list_options;
                    $selectedValue = $possible_values[$fieldValue];
                    $customFieldData[$customField->title] = $selectedValue;
                } elseif ($fieldFormat === 'Checkbox') {
                    $value = $fieldValue === '0' ? 'no' : 'yes';
                    $customFieldData[$customField->title] = $value;
                } else {
                    $customFieldData[$customField->title] = $field['value'];
                }
            } else {
                if (isset($field['name']) && isset($field['value'])) {
                    if ($field['name'] === 'duedate') {
                        $fields['due_date'] = $field['value'];
                    } elseif ($field['name'] === 'tags') {
                        if (!empty($field['value'])) {
                            $fields['tags'] = $field['value'];
                        }
                    } elseif ($field['name'] === 'planlevel') {
                        $fields['hierarchy_type']
                            = $field['value'];
                    } else {
                        $fields[$field['name']] = $field['value'];
                    }
                }
            }
        }
        if (!empty($customFieldData)) {
            $fields['custom_fields'] = $customFieldData;
        }
        $data = ['ticket' => $fields];
        $array = json_encode($data, true);
        $ticket = $this->_send_command(
            'POST',
            "spaces/$this->_space/tickets.json",
            $data
        );
        $this->_add_attachment($paths, $ticket->id);

        return $ticket->number;
    }

    /**
     * Format Field
     *
     * Formats the input field to give field name and values.
     *
     * @param string $fieldName  Field name
     * @param Object $fieldValue Field value
     *
     * @return array
     **/
    private function _format_field(string $fieldName, $fieldValue)
    {
        $data = [];
        $data['name'] = $fieldName;
        switch ($fieldName) {
        case 'milestone':
            $data['name'] = 'milestone_id';
            $data['value'] = $fieldValue;
            break;
        case 'assignedto':
            $data['name'] = 'assigned_to_id';
            $data['value'] = $fieldValue;
            break;
        default:
            $data['value'] = $fieldValue;
        }

        return $data;
    }

    /**
     * Document Tool Available
     *
     * Checks if the Document tool used for uploading files through API
     * is set for space.
     *
     * @return bool
     **/
    private function document_tool_available() : bool
    {
        $isDocumentToolExist = false;
        $availableTools = $this->_send_command(
            'GET',
            "spaces/$this->_space/space_tools"
        );
        foreach ($availableTools as $tool => $value) {
            if ($value->tool_id === Assembla_api::DOCUMENT_SITE_ID) {
                $isDocumentToolExist = true;
                break;
            }
        }

        return $isDocumentToolExist;
    }

    /**
     * Add document tool for Space
     *
     * If the DocumentTool is not set for the space ,it is set by calling API
     * Document tool Id = 18
     *
     * @return void
     **/
    private function add_document_tool_for_space()
    {
        $docTool = $this->_send_command(
            'POST',
            "spaces/$this->_space/space_tools/18/add"
        );
        if (empty($docTool)) {
            if (!in_array($uploadResponse->code, [200, 201])) {
                $this->_throw_error(
                    'Invalid HTTP code ({0}). Please check your secrete key/' .
                    'API key and space name',
                    $uploadResponse->code
                );
            }
        }
    }

    /**
     * Add Attachment
     *
     * Uploads the files attached to a tickets
     *
     * @param array $paths    file paths attached to the ticket for uploading
     * @param int   $ticketId ticket Id to which documents needs to be uploaded
     *
     * @return void
     */
    private function _add_attachment(array $paths, int $ticketId)
    {
        $toolAvailable = $this->document_tool_available();
        if (!$toolAvailable) {
            $this->add_document_tool_for_space();
        }
        foreach ($paths as $path) {
            $this->execute_upload_file($path, $ticketId);
        }
    }

    /**
     * Execute Upload File
     *
     * This method calls API to upload a document and attach a document to
     * a ticket with provided ticket Id.
     * If there is failure in uploading a file error is thrown.
     *
     * @param string $path     file path attached to the ticket for uploading.
     * @param int    $ticketId ticket Id to which documents needs to be uploaded.
     *
     * @return void
     *
     * @throws AssemblaException
     */
    private function execute_upload_file(string $path, int $ticketId)
    {
        if (!$this->_curl) {
            $this->_curl = http::open();
        }
        $cfile = curl_file_create($path);
        $cfile->postname = basename($cfile->name);
        $headers = [
            'Content-Type' => 'multipart/form-data',
            'X-Api-Key' =>  $this->_key,
            'X-Api-Secret' => $this->_secret,
        ];

        if (!(isset($this->_key) && isset($this->_secret))) {
            $headers = array_merge(
                $headers,
                ['Authorization' => 'Bearer ' . $this->_token]
            );
            unset($headers['X-Api-Key'], $headers['X-Api-Secret']);
        }

        $uploadResponse = http::request_ex(
            $this->_curl,
            GI_HTTP_METHOD_POST,
            Assembla_api::ATTACHMENT_URL
            . $this->_space
            . '/documents.json',
            [
                'headers' => $headers,
                'data' => [
                    'document[file]' => $cfile,
                    'document[attachable_type]' => 'Ticket',
                    'document[attachable_id]' => $ticketId ,
                    'document[ticket_id]' => $ticketId
                ],
                'skip_url_encode' => true
            ]
        );

        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debug('Got the following response');
            logger::debugr('response', $uploadResponse);
        }
        if (!in_array($uploadResponse->code, [200, 201])) {
            $this->_throw_error(
                'Invalid HTTP code ({0}). Please check your secrete key/' .
                'API key and configuration.',
                $uploadResponse->code
            );
        }
    }

    /**
     * Get Custon Field By Id
     *
     * Gets the custom field by ID
     *
     * @param int $customFieldId custom field
     *
     * @return object customfield customFiled object returned by get API
     **/
    public function get_Custom_Field_By_Id($customFieldId)
    {
        return $this->_send_command(
            'GET',
            "spaces/$this->_space/tickets/custom_fields/$customFieldId"
        );
    }

    /**
     * Throw Error
     *
     * This method calls API to upload a document and attach a document to
     * a ticket with provided ticket Id.
     * If there is failure in uploading a file error is thrown.
     *
     * @param String $format Arguments to the function.
     * @param String $params
     *
     * @return void
     *
     * @throws AssemblaException
     */
    private function _throw_error($format, $params = null)
    {
        $args = func_get_args();
        $format = array_shift($args);
        throw new AssemblaException(
            count($args) > 0
                ? str::formatv($format, $args)
                : $format
        );
    }
}

class AssemblaException extends Exception
{
}
