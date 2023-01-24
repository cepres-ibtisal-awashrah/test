<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Trac Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for Trac. Please see
 * http://docs.gurock.com/testrail-integration/defects-plugins for
 * more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 **/
class Trac_defect_plugin extends Defect_plugin
{
    const DASH = '&ndash;';
    const GI_DEFECTS_TRAC_API_VERSION = 1;

    private $_api;
    private $_address;
    private $_user;
    private $_password;

    private $_defaultFields = [
        'summary' => 'on',
        'component' => 'on',
        'type' => 'on',
        'description' => 'on'
    ];
    private $_hoverDefaultFields = [
        'summary' => 'on',
        'component' => 'on',
        'description' => 'on',
        'type' => 'on',
    ];
    private $_fieldDefaults = [
        'summary' => [
            'type' => 'string',
            'label' => 'Summary',
            'required' => true,
            'size' => 'full'
        ],
        'type' => [
            'type' => 'dropdown',
            'label' => 'Type',
            'required' => true,
            'remember' => true,
            'size' => 'compact'
        ],
        'component' => [
            'type' => 'dropdown',
            'label' => 'Component',
            'required' => true,
            'remember' => true,
            'size' => 'compact'
        ],
        'description' => [
            'type' => 'text',
            'label' => 'Description',
            'size' => 'full',
            'rows' => 10
        ],
        'priority' => [
            'type' => 'dropdown',
            'label' => 'Priority',
            'required' => false,
            'remember' => true,
            'size' => 'compact'
        ],
        'severity' => [
            'type' => 'dropdown',
            'label' => 'Severity',
            'required' => false,
            'remember' => true,
            'size' => 'compact'
        ],
        'version' => [
            'type' => 'dropdown',
            'label' => 'Version',
            'required' => false,
            'remember' => true,
            'size' => 'compact'
        ],
        'action' => [
            'type' => 'dropdown',
            'label' => 'Action',
            'required' => false,
            'remember' => true,
            'size' => 'compact'
        ] ,
        'owner' => [
            'type' => 'string',
            'label' => 'Assigned to',
            'required' => false,
            'size' => 'compact'
        ] ,
        'attdescription' => [
            'type' => 'text',
            'label' => 'Attachment Description',
            'required' => false,
            'size' => 'compact'
        ] ,
        'cc' => [
            'type' => 'string',
            'label' => 'Cc',
            'required' => false,
            'size' => 'compact'
        ],
        'milestone' => [
            'type' => 'dropdown',
            'label' => 'Milestones',
            'required' => false,
            'size' => 'compact'
        ] ,
        'reporter' => [
            'type' => 'string',
            'label' => 'Reporter',
            'required' => false,
            'size' => 'compact'
        ] ,
        'attachments' => [
            'type' => 'dropbox',
            'label'=>'attachments',
            'required' => false,
            'size' => 'none'
        ]
    ];
    private static $_meta_defects = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'Trac defect plugin for TestRail',
        'can_push' => true,
        'can_lookup' => true,
        'default_config' =>
            '; Please configure your Trac connection below
    [connection]
    address=http://<your-server>/
    user=testrail
    password=secret

    [push.fields]
    summary=on
    type=on
    component=on
    priority=on
    description=on
    severity=on
    version=on
    milestone=on
    attachments=on
    reporter=on
    attdescription=on
    cc=on

    [hover.fields]
    type=on
    component=on
    priority=on
    description=on
    severity=on
    reporter=on
    version=on
    milestone = on
    cc=on
    '];
    private static $_meta_references = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'Trac defect plugin for TestRail',
        'can_push' => true,
        'can_lookup' => true,
        'default_config' =>
            '; Please configure your Trac connection below
    [connection]
    address=http://<your-server>/
    user=testrail
    password=secret

    [hover.fields]
    type=on
    component=on
    priority=on
    description=on
    severity=on
    version=on
    cc=on
    reporter=on
    milestone=on
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
        if ($field_list === 'push.fields' && array_key_exists($field_list, $ini)) {
            $this->requiredFieldsConfigured($ini[$field_list]);
        }
        foreach ($ini[$field_list] ?? [] as $field => $option) {
            if ($field_list === 'push.fields' && $option === 'off' && !empty($this->_fieldDefaults[$field])) {
                $requiredFld = $this->_fieldDefaults[$field]['required'] ?? '';
                if (!empty($requiredFld) && $requiredFld  === true) {
                    throw new ValidationException(
                        $field . ' is turned off and it is required '
                    );
                }
            }
            if ($option === 'on') {
                $this->_validate_field($ini, $field);
            }
        }
    }

    /**
     * Required Fields Configured
     *
     * Checks if required fields are configured .
     *
     * @param array $configuredFields API configration.
     *
     * @return void
     *
     * @throws ValidationException
    **/
    private function requiredFieldsConfigured(array $configuredFields)
    {
        foreach ($this->_fieldDefaults as $fieldkey => $fieldval) {
            if (!empty($fieldval['required']) && $fieldval['required'] === true
                && empty($configuredFields[$fieldkey])
            ) {
                throw new ValidationException(
                    $fieldval['label'] .
                     ' is missing and it is required.'
                );
            }
        }
    }


    /**
     * Validate field
     * Validate default fields and if
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
        //$category = arr::get($ini, "field.settings.$field");
        $type = arr::get(arr::get($ini, "field.settings.$field"), 'type');
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

    /**
     * Valid config.
     *
     * Validates all configurations for basic parameters such as connection,URLs
     *
     * @param array $config String configuration set by user.
     *
     * @return void
     **/
    public function validate_config($config)
    {
        $ini = ini::parse($config);
        $connection = $ini['connection'];
        if (!isset($ini['connection'])) {
             throw new ValidationException('Missing [connection] group');
        }
        foreach (['address', 'user', 'password'] as $key) {
            if (empty($connection[$key])) {
                throw new ValidationException(
                    "Missing configuration for key '$key'"
                );
            }
        }
        $address = $connection['address'];
        if (!check::url($address)) {
             throw new ValidationException('Address is not a valid');
        }
        foreach (['push.fields', 'hover.fields'] as $field) {
             $this->_ensure_valid_fields($field, $ini);
        }
    }

    /**
     * Valid configure.
     *
     * Configures for basic parameters such as connection,URLs
     *
     * @param array $config String configuration set by user.
     *
     * @return void
     **/
    public function configure($config)
    {
        $this->_config = ini::parse($config);
        $this->_address = str::slash($this->_config['connection']['address']);
        $this->_user = $this->_config['connection']['user'];
        $this->_password = $this->_config['connection']['password'];
    }

    /**
     * Get API
     *
     * Gets API object of Bugzilla API class.
     *
     * @return object
     **/
    private function _get_api()
    {
        return $this->_api ?? (
            $this->_api = new Trac_api(
                $this->_address,
                $this->_user, $this->_password
            )
        );
    }

    /**
     * Prepare Push
     *
     * Prepares all fields with their possible values in case of
     * dropdown/multi select fields and custom fields and push fields
     *
     * @param array $context default configuration.
     *
     * @return array
     **/
    public function prepare_push($context)
    {
        $fields = [];
        $fieldsConfig = isset($this->_config['push.fields'])
            ? ['summary' => 'on'] + $this->_config['push.fields']
            : $this->_defaultFields;
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on') {
                continue;
            }
            $field = $this->_fieldDefaults[$fieldName] ?? [];
            $category = [];
            if ($fieldName !== 'summary') {
                $category = arr::get(
                    $this->_config,
                    "field.settings.$fieldName"
                );
            }
            if ($category) {
                foreach ($category as $prop => $val) {
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
            }
            $fields[$fieldName] = $field;
        }
        $result = ['fields' => $fields];
        $this->_form = $result;

        return $result;
    }

    /**
     * Get Summary Default
     *
     * Get the default value of the summary
     *
     * @param array $context Default configuration.
     *
     * @return string
     */
    private function _get_summary_default(array $context)
    {
        return 'Failed test: '
        . current($context['tests'])->case->title
        . (
            $context['test_count'] > 1
                ? ' (+others)'
                : ''
        );
    }

    /**
     * Get Description Default
     *
     * Get the default value of the description
     *
     * @param array $context Default configuration.
     *
     * @return string
     **/
    private function _get_description_default(array $context): string
    {
        return $context['test_change']->description;
    }

    /**
     * To Id Name lookup
     *
     * Assign name to the Id field
     *
     * @param array $items Default configuration.
     *
     * @return array
     **/
    private function _to_id_name_lookup(array $items): array
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
     * Prepares field with values
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
        if ($field == 'summary' || $field == 'description') {
            $data['default'] = $field === 'summary'
            ? $this->_get_summary_default($context)
            : $this->_get_description_default($context);
            return $data;
        }
        $prefs = $context['event'] == 'prepare'
            ? arr::get($context, 'preferences')
            :null;
        $api = $this->_get_api();
        switch ($field)
        {
        case 'type':
            $data['options'] = $this->_to_id_name_lookup($api->get_types());
            $default = arr::get($prefs, 'type');
            if ($default) {
                $data['default'] = $default;
            } else {
                if ($data['options']) {
                    $data['default'] = key($data['options']);
                }
            }
            break;
        case 'component':
            $data['default'] = arr::get($prefs, 'component');
            $data['options'] = $this->_to_id_name_lookup(
                $api->get_components()
            );
            break;
        case 'priority':
            $data['default'] = arr::get($prefs, 'priority');
            $data['options'] = $this->_to_id_name_lookup(
                $api->get_priority()
            );
            break;
        case 'severity':
            $data['default'] = arr::get($prefs, 'severity');
            $data['options'] = $this->_to_id_name_lookup(
                $api->get_severity()
            );
            break;
        case 'version':
            $data['default'] = arr::get($prefs, 'version');
            $data['options'] = $this->_to_id_name_lookup(
                $api->get_tracRelease()
            );
            break;
        case 'action':
            $data['default'] = arr::get($prefs, 'action');
            $data['options'] = [
                'create' => 'Create',
                'assignedto' => 'Assigned to'
            ];
            break;
        case 'milestone':
            $data['default'] = arr::get($prefs, 'milestone');
            $data['options'] = $this->_to_id_name_lookup(
                $api->get_milestones()
            );
            break;
        default :
            $data['default'] = arr::get($prefs, $field);
        }

        return $data;
    }

    /**
     * Push
     *
     * Push defect form fields to defect API to create a new card/bug/task.
     *
     * @param array|object $context Default configuration.
     * @param array        $input   All field defaults passed as array.
     * @param array        $path    User uploaded file path.
     *
     * @return object
     **/
    public function push($context, $input , array $path = [])
    {
        $api = $this->_get_api();
        return $api->add_ticket($input, $path);
    }

    /**
     * Lookup
     *
     * Creates an array of objects of default and custom field with default and
     * user defined configuration to display on hover popup.
     *
     * @param int $defect_id Id of a defect.
     *
     * @return array
     *
     * @throws ValidationException
     */
    public function lookup($defect_id)
    {
        $ticket = $this->_get_api()->get_ticket($defect_id);
        $hoverFields = $this->_config['hover.fields'] ?? $this->_hoverDefaultFields;
        $attributes = [];
        $fullAttributes = [];
        $status_id = isset($ticket['resolution']) && $ticket['resolution'] ?
        GI_DEFECTS_STATUS_RESOLVED : GI_DEFECTS_STATUS_OPEN;
        $description = null;
        if (isset($ticket['status'])) {
            $attributes['Status'] = h($ticket['status']);
        }
        foreach ($hoverFields as $fieldName => $value) {
            if ($value !== 'on' || in_array($fieldName, ['summary', 'attachments'])) {
                continue;
            }
            $fieldConfig = arr::get($this->_config, "field.settings.$fieldName");
            if (empty($fieldConfig)) {
                  $fieldConfig = $this->_fieldDefaults[$fieldName] ?? [];
            }
            $options = [
                'Priority' => $ticket['priority'],
                'Severity' => $ticket['severity'],
                'Type' => $ticket['type'],
                'Component' =>$ticket['component'],
                'CC' => $ticket['cc'] ,
                'Owner' => $ticket['owner'] ,
                'Reporter' => $ticket['reporter'],
                'Milestone'=> $ticket['milestone'],
                'Status' => $ticket['status'] ,
                'Version' => $ticket['version']
            ];
            $fieldValue = Trac_defect_plugin::DASH;
            foreach ($options as $field => $item) {
                if (!empty($ticket[$fieldName])
                    && strcasecmp($field, $fieldName) === 0
                ) {
                    $fieldValue
                        = gettype($ticket[$fieldName]) === 'array'
                        ? implode(',', $item)
                        : $item;
                    break;
                }
            }
            if ($fieldName === 'description') {
                $description = empty($ticket['description'])
                    ? null
                    : str::format(
                        '<div class="monospace">{0}</div>',
                        nl2br(html::link_urls(h($ticket['description'])))
                    );
            } elseif (in_array($fieldConfig['type'], ['text', 'string']) && ((!isset($fieldConfig['size']) || $fieldConfig['size'] === 'full'))) {
                $fullAttributes[$fieldConfig['label']] = str::format(
                    '<div class="monospace">{0}</div>',
                    strip_tags(html_entity_decode($fieldValue))
                );
            } else {
                $attributes[$fieldConfig['label']] = $fieldValue;
            }
        }

        return [
            'id' => $defect_id,
            'url' => str::format(
                '{0}ticket/{1}',
                $this->_address,
                $defect_id
            ),
            'title' => $ticket['summary'],
            'status_id' => $status_id,
            'status' => $ticket['status'],
            'description' => $description,
            'attributes' => $attributes,
            'fullAttributes' =>  $fullAttributes
        ];
    }
}

/**
 * Trac API
 *
 * Wrapper class for the Trac API with functions for retrieving
 * tickets etc. from a Trac installation.
 */
class Trac_api
{
    private $_address;
    private $_user;
    private $_password;
    private $_version;
    private $_curl;

    /**
     * Construct
     *
     * Initializes a new Trac API object. Expects the web address
     * of the Bugzilla API endpoint (e.g. https://bugzilla.readthedocs.io/
     * en/latest/api/core/v1/) including http or https prefix.
     *
     * @param string $address
     * @param string $user
     * @param string $password
     **/
    public function __construct($address, $user, $password)
    {
        $this->_address = str::slash($address) . 'login/rpc';
        $this->_user = $user;
        $this->_password = $password;
        $this->_version = $this->_check_version();
    }

    /**
     * Check Version
     *
     * Checks the version of available trac APIs and return
     * the latest version.
     *
     * @return object
     **/
    private function _check_version()
    {
        $response = $this->_send_command('system.getAPIVersion');
        if (!isset($response[1])) {
            $this->_throw_error(
                'Invalid response from version check (no major)'
            );
        }
        $major = $response[1];
        if ($major != Trac_defect_plugin::GI_DEFECTS_TRAC_API_VERSION) {
            $this->_throw_error(
                'Unsupported Trac API version: {0}/{1}',
                $major,
                Trac_defect_plugin::GI_DEFECTS_TRAC_API_VERSION
            );
        }

        return $major;
    }

    /**
     * Throw Error
     *
     * Throws error with proper reason and paramets
     *
     * @param String $format Arguments to the function.
     * @param String $params
     *
     * @return void
     *
     * @throws TracException
     */
    private function _throw_error($format, $params = null)
    {
        $args = func_get_args();
        $format = array_shift($args);
        throw new TracException(
            count($args) > 0
                ? str::formatv($format, $args)
                : $format
        );

        throw new TracException($message);
    }

    /**
     * Send Command
     *
     * Construct the actual url and sends an API request using the
     * default address of the configuration. Appends the path to resource and
     * base address, then calls _sendRequest.
     *
     * @param string $command xml-rpc service method.
     * @param array  $data    parameters/structs to xml service methods.
     *
     * @return array|object
     */
    private function _send_command(string $command, array $data = [])
    {
        $request = xmlrpc::encode_request($command, $data);
        if (!$this->_curl) {
            $this->_curl = http::open();
        }
        $response = http::request_ex(
            $this->_curl,
            'POST',
            $this->_address,
            [
                'data' => $request,
                'headers' => array(
                    'Content-Type' => 'text/xml'
                ),
            ]
        );
        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debugr('$request', $request);
            logger::debugr('$response', $response);
        }
        if ($response->code !== 200) {
            $this->_throw_error(
                'Invalid HTTP code ({0})', $response->code
            );
        }
        $dom = xmlrpc::decode_request($response->content);
        $this->handleFault($dom);

        return $dom;
    }

    /**
     * Handle Fault
     *
     * Handles xml-rpc faults occured while execution of service
     * method call and returned as response in xml dom format
     *
     * @param object $dom xml responce returned by execution of service method call.
     *
     * @return void
     *
     * @throws TracException
     */
    private function handleFault($dom)
    {
        if (isset($dom['faultCode'])) {
            if (isset($dom['faultString'])) {
                $this->_throw_error(
                    '{0} (faultCode: {1})',
                    $dom['faultString'],
                    $dom['faultCode']
                );
            } else {
                $this->_throw_error(
                    'Request resulted in error (faultCode: {0})',
                    $dom['faultCode']
                );
            }
        } else if (isset($dom['faultString'])) {
                $this->_throw_error(
                    $dom['faultString']
                );
        } else {
            //NOP
        }
    }


    /**
     * Get Components
     *
     * Returns a list of components for the Trac installation.
     * Components are returned as array of objects, each with its
     * ID and name.
     *
     * @return array
     */
    public function get_components(): array
    {
        $components = $this->_send_command('ticket.component.getAll');

        $result = [];
        foreach ($components as $component) {
            $componentRef = obj::create();
            $componentRef->name = (string)$component;
            $componentRef->id = $componentRef->name;
            $result[] = $componentRef;
        }

        return $result;
    }

    /**
     * Get Priority
     *
     * Returns a list of all priorities for the Trac installation.
     * Priorities are returned as array of objects, each with its
     * ID and name.
     *
     * @return array
     */
    public function get_priority(): array
    {
        $priorities = $this->_send_command('ticket.priority.getAll');
        $result = [];
        foreach ($priorities as $priority) {
            $priorityRef = obj::create();
            $priorityRef->name = (string)$priority;
            $priorityRef->id = $priorityRef->name;
            $result[] = $priorityRef;
        }

        return $result;
    }

    /**
     * Get Severity
     *
     * Returns a list of severities for the Trac installation.
     * Severities are returned as array of objects, each with its
     * ID and name.
     *
     * @return array
     */
    public function get_severity(): array
    {
        $severities = $this->_send_command('ticket.severity.getAll');
        $result = [];
        foreach ($severities as $severity) {
            $severityRef = obj::create();
            $severityRef->name = (string)$severity;
            $severityRef->id = $severityRef->name;
            $result[] = $severityRef;
        }

        return $result;
    }

    /**
     * Get Milestones
     *
     * Returns a list of milestones for the Trac installation.
     * Milestones are returned as array of objects, each with its
     * ID and name.
     *
     * @return array
     */
    public function get_milestones(): array
    {
        $milestones = $this->_send_command('ticket.milestone.getAll');
        $milesstoneResult = [];
        foreach ($milestones as $milestone) {
             $milestoneRef = obj::create();
             $milestoneRef->name = (string)$milestone;
             $milestoneRef->id = $milestoneRef->name;
             $milesstoneResult[] = $milestoneRef;
        }

        return $milesstoneResult;
    }


    /**
     * Get trac release
     *
     * Returns a list of trac release for the Trac installation.
     * Trac releases are returned as array of objects, each with its
     * ID and name.
     *
     * @return array
     */
    public function get_tracRelease(): array
    {
        $releaseResult = [];
        $releases = $this->_send_command('ticket.version.getAll');
        foreach ($releases as $release) {
            $c = obj::create();
            $c->name = $release;
            $c->id = $c->name;
            $releaseResult[] = $c;
        }

        return $releaseResult;
    }

    /**
     * Get Types
     *
     * Returns a list of ticket types for the Trac installation.
     * The types are returned as array of objects, each with its
     * ID and name.
     *
     * @return array
     */
    public function get_types(): array
    {
        $types = $this->_send_command('ticket.type.getAll');
        $result = [];
        foreach ($types as $type) {
            $t = obj::create();
            $t->name = (string)$type;
            $t->id = $t->name;
            $result[] = $t;
        }

        return $result;
    }

    /**
     * Get Ticket
     *
     * Gets an existing ticket from the Trac installation and
     * returns it. The resulting ticket has various properties such
     * as the summary, description etc.
     *
     * @param string $ticket_id
     *
     * @return array
     **/
    public function get_ticket($ticket_id): array
    {
        $ticket = $this->_send_command('ticket.get', [$ticket_id]);
        $attributes = $ticket[3];
        if (!isset($attributes) || !is_array($attributes)) {
            $this->_throw_error(
                'No attributes received for ticket'
            );
        }
        $ticketParams = $this-> getAttributeArray($attributes);
        $ticketParams['description'] = $attributes['description'];
        $ticketParams['summary'] = $attributes['summary'];
        $ticketParams['status'] = $attributes['status'];

        return $ticketParams;
    }

    /**
     * Get Attribute array
     *
     * Gets an attribute array for ticket. Retruns the values of attribute
     * if the attribute is present in options array.
     *
     * @param array $options
     *
     * @return array
     **/
    function getAttributeArray(array $options): array
    {
        return [
            'type' => $options['type'] ?? null ,
            'component' => $options['component'] ?? null,
            'priority' => $options['priority'] ?? null,
            'version' => $options['version'] ?? null,
            'severity' => $options['severity'] ?? null ,
            'cc' => $options['cc'] ?? null ,
            'reporter' => $options['reporter'] ?? null ,
            'owner' => !empty($options['action'])
                && $options['action'] === 'assignedto'
                ? $options['owner']
                : null ,
            'milestone' => $options['milestone'] ?? null
        ];
    }

    /**
     * Add Ticket
     *
     * Adds a new ticket to the Trac installation with the given
     * parameters (title, project etc.) and returns its ID.
     *
     * summary:     The summary of the new ticket
     * type:        The ID of the type of the the new ticket
     * component:   The ID of the component the ticket is added to
     * description: The description of the new ticket
     *
     * @param array $options array of input parameters
     * @param array $paths   array of file paths
     *
     * @return string
     **/
    public function add_ticket(array $options, array $paths): string
    {
        $data = [
            $options['summary'],
            $options['description'] ?? null,
            $this->getAttributeArray($options)
        ];
        $id = $this->_send_command('ticket.create', $data);
        $attDescription = !empty($options['attdescription'])
            ? $options['attdescription']
            : '';
        $this->add_attachment($paths, (int)$id, $attDescription);

        return (string) $id;
    }

    /**
     * Add Attachment
     *
     * Uploads the file/files to the ticketId
     *
     * @param array  $paths       array of input parameters
     * @param int    $ticketId    ticket id
     * @param string $description file upload description
     *
     * @return string
     **/
    private function add_attachment(array $paths, int $ticketId,
        string $description
    ) {
        $replace = 0;
        if (!$this->_curl) {
            $this->_curl = http::open();
        }
        foreach ($paths as $path) {
            $fileName = basename($path);
            $binaryData = base64_encode(
                file_get_contents($path)
            );
            xmlrpc_set_type($ticketId, 'int');
            xmlrpc_set_type($fileName, 'string');
            xmlrpc_set_type($description, 'string');
            xmlrpc_set_type($binaryData, 'base64');
            xmlrpc_set_type($replace, 'boolean');
            $xmlrpcReq = xmlrpc_encode_request(
                'ticket.putAttachment',
                [
                    $ticketId,
                    $fileName,
                    $description,
                    $binaryData,
                    $replace
                ]
            );
            $response = http::request_ex(
                $this->_curl,
                'POST',
                $this->_address,
                [
                    'data' => $xmlrpcReq,
                    'headers' => [
                    'Content-Type' => 'text/xml'
                    ]
                ]
            );
            $this->handleFault(
                xmlrpc::decode_request($response->content)
            );
        }
    }
}

class TracException extends Exception
{
}

// Check for the xmlrpc PHP module/extensions that is required by
// this plugin.
if (!function_exists('xmlrpc_encode_request'))
{
    throw new TracException(
        'The Trac defect plugin requires the xmlrpc PHP
extension which has not yet been installed.'
    );
}
