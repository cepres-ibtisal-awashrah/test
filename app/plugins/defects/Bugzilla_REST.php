<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Bugzilla Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for Bugzilla. Please see
 * http://docs.gurock.com/testrail-integration/defects-plugins for
 * more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */
 
define('GI_DEFECTS_BUGZILLA_REST_API_VERSION', '5.0.6');
class Bugzilla_REST_defect_plugin extends Defect_plugin                                                        
{
    const TYPE_DATE = 9;
    const TYPE_DATE_TIME = 5;
    const TYPE_DROPDOWN = 2;
    const TYPE_MULTISELECT = 3;
   
    private $_api;   
    private $_address;
    private $_user;
    private $_password;

    private $_defaultFields = [
        'summary' => 'on',
        'product' => 'on',
        'component' => 'on',
        'version' => 'on',
        'description' => 'on',
        'op_sys' => 'on',
        'platform' => 'on',
        'attachments' => 'on'
    ];
    private $_hoverDefaultFields = [
        'summary' => 'on',
        'product' => 'on',
        'component' => 'on',
        'version' => 'on',
        'description' => 'on',
        'op_sys' => 'on',
        'platform' => 'on'
    ];
    private $_fieldDefaults =[
        'summary' => [
            'type' => 'string',
            'label' => 'Summary',
            'required' => true,
            'size' => 'full'
            ],
        'product' => [
            'type' => 'dropdown',
            'label' => 'Product',
            'required' => true,
            'remember' => true,
            'cascading' => true,
            'size' => 'compact'
        ],
        'component' => [
            'type' => 'dropdown',
            'label' => 'Component',
            'required' => true,
            'remember' => true,
            'depends_on' => 'product',
            'size' => 'compact'
        ],
        'version' => [
            'type' => 'dropdown',
            'label' => 'Version',
            'required' => true,
            'remember' => true,
            'depends_on' => 'product',
            'size' => 'compact'
        ],
        'description' => [
            'type' => 'text',
            'label' => 'Description',
            'required' => false,
            'rows' => 10
        ],
        'op_sys' => [
            'type' => 'dropdown',
            'label' => 'OS',
            'rows' => 10,
            'required' => true,
            'size' => 'compact'
        ],
        'priority' => [
            'type' => 'dropdown',
            'label' => 'Priority',
            'rows' => 10,
            'size' => 'compact'
        ],
        'severity' => [
            'type' => 'dropdown',
            'label' => 'Severity',
            'rows' => 10,
            'size' => 'compact'
        ],
        'platform' => [
            'type' => 'dropdown',
            'label' => 'Hardware',
            'required' => true,
            'rows' => 10,
            'size' => 'compact'
        ],
        'alias' => [
            'type' => 'string',
            'label' => 'Alias',
            'rows' => 1,
            'size' => 'compact'
        ],  
        'status'=> [
            'type' => 'dropdown',
            'label' => 'Status',
            'rows' => 1,
            'size' => 'compact'
        ],
        'estimated_time' => [
            'type' => 'string',
            'label' => 'Orig. Estimates',
            'rows' => 1,
            'size' => 'compact'
        ],
        'cc' => [
            'type' => 'string',
            'label' => 'CC',
            'rows' => 3,
            'size' => 'compact'
        ],
        'url' => [
            'type' => 'string',
            'label' => 'URL',
            'rows' => 1,
            'size' => 'compact'
        ],
        'blocks' => [
            'type' => 'string',
            'label' => 'Blocks',
            'rows' => 1,
            'size' => 'compact'
        ],
        'see_also' => [
            'type' => 'string',
            'label' => 'See Also',
            'rows' => 1,
            'size' => 'compact'
        ],
        'depends_on' => [
            'type' => 'string',
            'label' => 'Depends On',
            'rows' => 1,
            'size' => 'compact'
        ],
        'deadline' => [
            'type' => 'string',
            'label' => 'Deadline',
            'rows' => 1,
            'size' => 'compact'
        ],
        'attachments' => [
            'type' => 'dropbox',
            'label'=>'attachments',
            'required' => false,
            'size' => 'none'
        ],
        'creator' => [
            'type' => 'string',
            'label'=>'Reported By',
            'required' => false,
            'size' => 'compact'
        ],
        'assigned_to' => [
            'type' => 'string',
            'label'=>'Owner',
            'required' => false,
            'size' => 'compact'
        ]
    ];

    protected static $_meta_defects = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'Bugzilla defect plugin for TestRail',
        'can_push' => true,
        'can_lookup' => true,
        'default_config' => 
            '; Please configure your Bugzilla connection below
[connection]
address=http://<your-server>/
user=testrail
password=secret

[push.fields]
summary = on
product = on
component = on
version = on
platform = on
op_sys = on
description = on
deadline = off
depends_on = off
see_also = off
blocks = off
url = off
estimated_time = off
severity = off
alias = off
status = off
priority = off
attachments=on

[hover.fields]
product = on
component = on
version = on
platform = on
op_sys = on
description = on
deadline = off
depends_on = off
see_also = off
blocks = off
url = off
estimated_time = off
severity = off
alias = off
status = off
creator = off
assigned_to = off
priority = off'
];

protected static $_meta_references = [
    'author' => 'Gurock Software',
    'version' => '1.0',
    'description' => 'Bugzilla defect plugin for TestRail',
    'can_push' => true,
    'can_lookup' => true,
    'default_config' => 
        '; Please configure your Bugzilla connection below
[connection]
address=http://<your-server>/
user=testrail
password=secret

[hover.fields]
summary = on
product = on
component = on
version = on
platform = on
op_sys = on
description = on
deadline = off
depends_on = off
see_also = off
blocks = off
url = off
estimated_time = off
severity = off
alias = off
status = off
creator = off
assigned_to = off
priority = off'
];

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
            if ($field_list === 'push.fields' &&  $option === 'off' && !empty($this->_fieldDefaults[$field])) {
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
        if (str::starts_with($field, 'cf_')) {
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
                    '[field.settings.{0}]',
                    $field
                )
            );
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
     * Required Fields Configured
     * 
     * Checks if required fields are configured .
     * 
     * @param array $configuredFields API configration.
     * 
     * @return void
     * 
     * @throws ValidationException
     */  
    private function requiredFieldsConfigured(array $configuredFields) 
    {
        foreach ($this->_fieldDefaults as $fieldKey => $fieldVal) {
            if (!empty($fieldVal['required']) && $fieldVal['required'] === true 
                && empty($configuredFields[$fieldKey])
            ) {
                throw new ValidationException(
                    $fieldVal['label'] . 
                    ' is missing and it is required.'
                );
            }
        }
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
        return $this->_api?? ( 
            $this->_api = new Bugzilla_api(
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
     * @return array$fields fields configured
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
            $category = [];
            $field = $this->_fieldDefaults[$fieldName] ?? [];
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
        $summary = 'Failed test: ' 
            .  current($context['tests'])->case->title;
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
        foreach ($items ?? [] as $item) {
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
        if ($field === 'summary' || $field === 'description') {
            switch ($field) {
            case 'summary':
                $data['default'] = $this->_get_summary_default($context);
                break;
            case 'description':
                $data['default'] = $this->_get_description_default($context);
                break;
            }
        
            return $data;
        }
        if ($context['event'] === 'prepare') {
            $prefs = arr::get($context, 'preferences');
        } else {
            $prefs = null;
        }
        $api = $this->_get_api();
        switch ($field) {
        case 'product':
            $data['default'] = arr::get($prefs, 'product');
            $data['options'] = $this->_to_id_name_lookup(
                $api->get_products()
            );
            break;
        case 'component':
            if (isset($input['product'])) {
                $data['default'] = arr::get($prefs, 'component');
                $data['options'] = $this->_to_id_name_lookup(
                    $api->get_components($input['product'])
                );
            }
            break;
        case 'version':
            if (isset($input['product'])) {
                $data['default'] = arr::get($prefs, 'version');
                $data['options'] = $this->_to_id_name_lookup(
                    $api->get_versions($input['product'])
                );
            }
            break;
        case 'status':
            $data['default'] = arr::get($prefs, 'status');
            $data['options'] = $this->_to_id_name_lookup(
                $api->get_status()
            );
            break;
        case 'priority':
            $data['default'] = arr::get($prefs, 'priority');
            $data['options'] = $this->_to_id_name_lookup(
                $api->get_priorities()
            );
            break;
        case 'platform':
            $data['default'] = arr::get($prefs, 'platform');
            $data['options'] = $this->_to_id_name_lookup(
                $api->get_platform()
            ); 
            break;
        case 'severity':
            $data['default'] = arr::get($prefs, 'severity');
            $data['options'] = $this->_to_id_name_lookup(
                $api->get_severity()
            );
            break;
        case 'op_sys':
            $data['default'] = arr::get($prefs, 'op_sys');
            $data['options'] = $this->_to_id_name_lookup(
                $api->get_os()
            );
            break;
        }
        if (str::starts_with($field, 'cf_')) {
           
            $data['default'] = arr::get($prefs, $field);
            $data['options'] = $this->_convert_customField_values(
                $this->_get_customfield_values($field)
            );
        }

        return $data;
    }

    /**
     * Convert Customfield values.
     * 
     * Convert Customfield values to get id and name same 
     * as field value.
     *
     * @param array $field default configuration.
     *
     * @return array
     **/
    private function _convert_customField_values(array $field): array
    {      
        $result = [];
        foreach ($field ?? [] as $key => $value) {
            $result[$value] = $value;
        }

        return $result;
    }

    /**
     * Get Customfield by name.
     *
     * @param string $fieldName default configuration.
     *
     * @return object
     **/
    private function get_customFieldByName(string $fieldName): object
    {
        $api = $this->_get_api();
        $customFields = $api->_send(
            'Get', 
            '/field/bug/'
            . $fieldName,
            null
        );
        $customField = !empty(current($customFields)) ?  current($customFields) : null;
        return $customField[0];
    }
    
    /**
     * Get Customfield values.
     *
     * @param string $fieldName default configuration.
     *
     * @return array
     **/
    private function _get_customfield_values(string $fieldName): array
    {
        $returnedValue = [];
        $api = $this->_get_api();
        $customField = $api->_send(
            'Get', 
            '/field/bug/'
            . $fieldName,
            null
        ); 
        if (empty($customField)) {
             _throw_error('Incorrect Name or Custom field does not exists');
        }
        $fields = $customField->fields;
        if (!empty($fields) && count($fields) == 1) {
            $customField  = $fields[0];
            if (isset($customField) && $customField->is_custom) {           
                $fieldFormat = $customField->type;
                if (in_array(
                    $fieldFormat, [Bugzilla_REST_defect_plugin::TYPE_DROPDOWN,
                    Bugzilla_REST_defect_plugin::TYPE_MULTISELECT]
                )
                ) {
                    $returnedValue 
                        = $this->getCustomFieldLegalValues(
                            $fieldName
                        );                   
                }   
            }
        }   

        return $returnedValue;
    }

     /**
      * Get custom field legal values.
      * 
      * Gets the possible leagal values for custom field of dropdown/multiselect type
      *
      * @param string $fieldName 
      *
      * @return array
      **/
    private function getCustomFieldLegalValues(string $fieldName): array
    {
        $response = $this->_get_api()->_send(
            ' Get ', 
            '/field/bug/' 
            . $fieldName 
            . '/values', null
        );  

        return $response -> values;    
    }
 
    /**
     * Push
     * 
     * Method for pushing bug
     *
     * @param object $context default configuration.
     * @param array  $input   Input data for pushing defect
     * @param array  $path    file paths for attachment
     *
     * @return string 
     **/
    public function push($context, $input, $path = []) 
    {
        return $this->_get_api()->add_bug($input, $path);
    }

    /**
     * Lookup
     * 
     * Creates an array of objects of default and custom field with default and 
     * user defined configuration to display on hover popup.
     * 
     * @param int $defect_id defect_id of an bugzilla ticket.
     * 
     * @return array
     **/
    public function lookup($defect_id)
    {
        $api = $this->_get_api();
        $label ;
        $value ;
        $bug = $api->get_bug($defect_id);
        $comments = $api->_get_comments($defect_id);
        $status_id = $bug->is_open 
            ? GI_DEFECTS_STATUS_OPEN
            : GI_DEFECTS_STATUS_CLOSED;

        if (!empty($comments)) {
            $comment = current($comments);
            $description = str::format(
                '<div class="monospace">{0}</div>',
                nl2br(
                    html::link_urls(
                        h($comment['text'])
                    )
                )
            );
        } else {
            $description = null;
        }
        $attributes = [];   
        $fullAttributes = [];
        if (!empty($bug->status)) {
            $attributes['Status'] = h($bug->status);
        }
        $hoverFields = $this->_config['hover.fields'] ?? $this->_hoverDefaultFields;
        foreach ($hoverFields as $fieldName => $value) {
            if ($value !== 'on' || in_array($fieldName, ['summary', 'description', 'attachments'])) {
                if ($fieldName === 'description' && $value !== 'on') {
                    $description = null;  
                }
                continue;
            }
            $fieldConfig = arr::get($this->_config, "field.settings.$fieldName");
            if (empty($fieldConfig)) {
                  $fieldConfig = $this->_fieldDefaults[$fieldName] ?? [];
            }

            $options = [
                'Priority' => $bug->priority,
                'Severity' => $bug->severity,
                'URL' => $bug->url,
                'CC' => $bug->cc ,
                'Alias' => $bug->alias ,
                'Deadline' => $bug->deadline ,
                'Blocks' => $bug->blocks,
                'Version' => $bug->version
            ];
            foreach ($options as $field => $item) {
                if (strcasecmp($field, $fieldName) === 0) {
                    $fldValue = gettype($item) === 'array' 
                        ? implode(',', $item) 
                        : $item;
                    $label = $field;
                }
            }
            switch ($fieldName) {
            case 'estimated_time':
                $fldValue = $bug->estimated_time;
                $label = 'Estimated Time';
                break;
            case 'assigned_to':
                $fldValue = $bug->assigned_to;
                $label = 'Assigned To';
                break;
            case 'creator':
                $fldValue = $bug->creator;
                $label ='Reporter';
                break;
            case 'depends_on':
                $fldValue =  implode(',', $bug->depends_on);
                $label ='Depends On';
                break;  
            case 'see_also':
                $fldValue =  implode(',', $bug->see_also);
                $label ='See Also';
                break;
            case 'op_sys':
                $fldValue =  $bug->op_sys;
                $label ='OS';
                break;  
            case 'platform':
                $fldValue =  $bug->platform;
                $label ='Hardware';
                break;
            case 'product':
                if (!empty($bug->product)) {
                    $fldValue = str::format(
                        '<a target="_blank" href="{0}describecomponents.cgi?
                        product={1}">{2}</a>',
                        a($this->_address),
                        a($bug->product),
                        h($bug->product)
                    );
                }
                $label ='Product';
                break;
            case 'component':
                if (!empty($bug->component)) {
                    $fldValue = h($bug->component);
                }
                $label ='Component';
                break;
            }
            if (str::starts_with($fieldName, 'cf_')) {
                $configGroup = $this->_config['field.settings.' . $fieldName];
                if (!isset($configGroup)) {
                    continue;
                }
                if (!empty($configGroup['label'])) {
                    $label = $configGroup['label'];
                    if (gettype($bug->$fieldName)==='array') {
                        $fldValue = implode(',', $bug->$fieldName);
                    } else {
                        $fldValue =  $bug->$fieldName;
                        $customField = $this->get_customFieldByName($fieldName);
                        $type = !empty($customField) ? $customField->type : null;
                        if ($type === Bugzilla_REST_defect_plugin::TYPE_DATE) {
                            $fldValue
                                = date::format_short_date(
                                    strtotime($bug->$fieldName)
                                );
                        }
                        if ($type === Bugzilla_REST_defect_plugin::TYPE_DATE_TIME) {
                            $fldValue
                                = date::format_short_datetime(
                                    strtotime($bug->$fieldName)
                                );
                        }
                    }
                }

            }

            if (in_array($fieldConfig['type'], ['text', 'string']) 
                && ((!isset($fieldConfig['size']) || $fieldConfig['size'] === 'full'))
            ) {
                $fullAttributes[$label] = str::format(
                    '<div class="monospace">{0}</div>',
                    strip_tags(html_entity_decode($fldValue))
                );
            } else {
                $attributes[$label] = $fldValue;
            }
        } 
        return [
            'id' => $defect_id,
            'url' => str::format(
                '{0}show_bug.cgi?id={1}',
                $this->_address,
                $defect_id
            ),
            'title' => $bug->summary,
            'status_id' => $status_id,
            'status' => $bug->status,
            'description' => $description,
            'attributes' => $attributes ,
            'fullAttributes' => $fullAttributes
        ];
    }
}

/**
 * Bugzilla API
 *
 * Wrapper class for the Bugzilla API with functions for retrieving
 * products, bugs etc. from a Bugzilla installation.
 **/
class Bugzilla_api
{
    private $_address;
    private $_user;
    private $_password;
    private $_version;
    private $_curl;
    
    /**
     * Construct
     *
     * Initializes a new Bugzilla API object. Expects the web address
     * of the Bugzilla API endpoint (e.g. https://bugzilla.readthedocs.io/
     * en/latest/api/core/v1/) including http or https prefix.
     *
     * @param string $address
     * @param string $user
     * @param string $password
     **/
    public function __construct($address, $user, $password)
    {
        $this->_address = str::slash($address).'rest';
        $this->_user = $user;
        $this->_password = $password;
        $this->_version = $this->_check_version();
    }
    
    /**
     * Check Version
     * 
     * Checks version of bugzilla API
     *
     * @return string
     **/
    private function _check_version(): string
    {
        $response = $this->_send('Get', '/version',null);
        if (!isset($response->version)) {
            $this->_throw_error(
                'Invalid response (missing "version" parameter)'
            );
        }
        $version = (string) $response->version;
        if (version_compare($version, GI_DEFECTS_BUGZILLA_REST_API_VERSION, '<')
        ) {
            $this->_throw_error(
                'Unsupported Bugzilla API version: {0}/{1}',
                $version,
                GI_DEFECTS_BUGZILLA_REST_API_VERSION
            );
        }
        
        return $version;
    }
    
    /**
     * Get Status
     * 
     * Gets the values of status field
     *
     * @return array
     **/
    public function get_status(): array 
    {
        $status = [
            'CONFIRMED'=> 'CONFIRMED' ,
            'UNCONFIRMED' => 'UNCONFIRMED',
            'IN_PROGRESS' => 'IN_PROGRESS'
        ];
        $result = [];
        foreach ($status as $id => $name) {
            $p = obj::create();
            $p->id = $id;
            $p->name = $name;
            $result[] = $p;
        }

        return $result;
    }

    /**
     * Get Platform
     * 
     * Gets the values of platform field
     *
     * @return array
     **/
    public function get_platform(): array 
    {
        $platforms = [
            'PC'=> 'PC' ,
            'MACINTOSH' => 'MACINTOSH',
            'ALL' => 'ALL',
            'OTHER' => 'OTHER'
        ];
        $result = [];
        foreach ($platforms as $id => $name) {
            $result[] = (object) [
                'id' =>  $id,
                'name' => $name
            ];
        }  

        return $result;
    }

    /**
     * Get Severity
     * 
     * Gets the values of severity field
     *
     * @return array
     **/
    public function get_severity(): array 
    {
        $severities = [
            'enhancement' => 'enhancement',
            'trivial' => 'trivial',
            'minor' => 'minor',
            'normal' => 'normal',
            'major' => 'major',
            'critical' => 'critical',
            'blocker' => 'blocker'
        ];
        $result = [];
        foreach ($severities as $id => $name) {
            $result[] = (object) [
                'id' =>  $id,
                'name' => $name
            ];            
        }

        return $result; 
    }
    
    /**
     * Get Status
     * 
     * Gets the values of priority field
     *
     * @return array
     **/
    public function get_priorities(): array 
    {
        $priorities = [
            'Highest' => 'Highest',
            'High'=> 'High',
            'Normal' => 'Normal',
            'Low' => 'Low',
            'Lowest' => 'Lowest'
        ];
        $result = [];
        foreach ($priorities as $id => $name) {
            $result[] = (object) [
                'id' =>  $id,
                'name' => $name
            ];
        }

        return $result;
    }

    /**
     * Get Os
     * 
     * Gets the values of operating system field field
     *
     * @return array
     **/
    public function get_os(): array 
    {
        $systems = [
            'Linux'=> 'Linux' ,
            'Windows' => 'Windows',
            'Mac OS' => 'Mac OS',
            'All' => 'All',
            'Other' => 'Other'
        ];
        $result = [];
        foreach ($systems as $id => $name) {
            $result[] = (object) [
                'id' =>  $id,
                'name' => $name
            ];
        }

        return $result; 
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
     * @throws BugzillaException  
     */
    private function _throw_error($format, $params = null)
    {
        $args = func_get_args();
        $format = array_shift($args);
        throw new BugzillaException(
            count($args) > 0
                ? str::formatv($format, $args)
                : $format
        );

        throw new BugzillaException($message);
    }

    /**
     * _send
     * 
     * Sends api request with provided url and queryparams
     *
     * @param string $method     Http method name. 
     * @param string $url        URL of api request.
     * @param string $queryParam query parameters
     *
     * @return object|array
     *
     * @throws BugzillaException  
     **/
    public function _send(string $method, string $url, $queryParam)
    {
        if (!$this->_curl) {
            $this->_curl = http::open();
        }
        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debug('Issuing Bugzilla HTTP REST request');
            logger::debugr(
                'request',
                [
                    'method' => $method,
                    'url' => $url,
                    'data' => $data
                ]
            );
        }        
        $urlWithCredentials = $this->_address . 
            $url 
            . '?' 
            . 'login=' 
            . $this->_user 
            . '&password='  
            . $this->_password;
        $finalUrl = isset($queryParam) ? $urlWithCredentials.$queryParam : 
                    $urlWithCredentials;    
        $response = http::request_ex(
            $this->_curl,
            $method,
            $finalUrl,
            [
                'skip_url_encode' => true , 
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]
        );
        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debug('Got the following response');
            logger::debugr('response', $response);
        }
        $obj = json::decode($response->content);
        if (!in_array($response->code, [200, 201])) {
            $this->_throw_error(
                'Invalid HTTP code ({0}). Please check your username, ' .
                'password and configuration.',
                $response->code
            );
        }

        return $obj;
    }

    /**
     * _send_command
     * 
     * Sends api request with provided url and queryparams
     *
     * @param string $url  url  api URL. 
     * @param string $data data required as request body. 
     *
     * @return object|array
     *
     * @throws BugzillaException  
     **/
    private function _send_command(string $url , array $data = [])
    {       
        if (!$this->_curl) {
             $this->_curl = http::open();
        }
        $urlWithCredentials   
            = $this->_address 
            . $url 
            . '?'
            . 'login='
            . $this->_user 
            . '&password=' 
            . $this->_password;
        $response =  http::post(
            $urlWithCredentials,
            [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],  
                'data' =>json::encode($data),
                'skip_url_encode' => true
            ]
        );
        $docContent = json::decode($response->content);
        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debugr('$request', $request);
            logger::debugr('$response', $response);
        }
        if ($response->code != 200) {
            $this->_throw_error(
                'Invalid HTTP code ({0} Bugzilla Error message {1})', 
                $response->code, $docContent->message
            );
        }

        return $docContent;
    }

    /**
     * Get Products
     *
     * Returns a list of products for the Bugzilla installation.
     * Products are returned as array of objects, each with its ID
     * and name.
     * 
     * @return array
     **/
    public function get_products()
    {
        $response = $this->_send(
            'Get',
            '/product_enterable',
            null  
        );
        $productIds = (array)$response; 
        if (!$response) {
            return [];
        }
        foreach ($productIds['ids'] as $fieldValue) {
            $productParams = '&ids='.$fieldValue;
        }
        $prodresponse = $this->_send('Get', '/product', $productParams);
        $products = (array)$prodresponse; 
        if (!$response) {
            return [];
        }
        if (!isset($products['products'])) {
            $this->_throw_error(
                'Invalid response (missing "products" parameter)'
            );
        }
        foreach ($products as $productfield => $productVal) {
            if (!empty($productVal)) {
                $p = obj::create();
                $p->name = (string)$productVal[0]->name;
                $p->id = $p->name;
                $result[] = $p;
            }
        }
    
        return $result;
    }
    
    /**
     * Get fields
     * 
     * Get fields associated with bug
     *
     * @param string $name  
     * @param int    $product_id  
     *
     * @return object|array
     *
     * @throws BugzillaException  
     **/
    private function _get_fields(string $name, string $product_id)
    {  
        $response = $this->_send(
            ' Get ', 
            '/field/bug/' 
            . $name, 
            null
        );
        $productField = (array)$response;
        if (!$response) {
            return [];
        }    
        if (!isset($productField['fields']) || !$productField['fields']) {
            $this->_throw_error(
                'Invalid response (missing "fields" parameter)'
            );
        }        
        $field = current($productField['fields']);
        $fieldval= (array)$field->values;
        if (empty($fieldval)) {
            return [];
        }        
        $result = [];
        foreach ($fieldval as $value) {
            $visibility= (array)$value->visibility_values;
            if (!$visibility) {
                continue;
            }
            if (in_array($product_id, $visibility)) {
                $f = obj::create();
                $f->name =  (string)$value->name;
                $f->id = $f->name;
                $result[] = $f;
            }
        }

        return $result;
    }
    
    /**
     * Get Components
     *
     * Returns a list of components for the given product for the
     * Bugzilla installation. Components are returned as array of
     * objects, each with its ID and name.
     *
     * @param int $product_id 
     *
     * @return array
     **/
    public function get_components(string $product_id): array
    {
        return $this->_get_fields('component', $product_id);
    }

    /**
     * Get Versions
     *
     * Returns a list of versions for the given product for the
     * Bugzilla installation. Versions are returned as array of
     * objects, each with its ID and name.
     *
     * @param int $product_id productId
     *
     * @return object 
     **/
    public function get_versions($product_id): array
    {
        return $this->_get_fields('version', $product_id);
    }
    
    /**
     * Get Bug
     *
     * Gets the bug with specified bug Id
     * 
     * @param integer $bug_id bugId
     * 
     * @return object
     **/
    public function get_bug($bug_id)
    {
        $response = $this->_send(
            ' Get ', 
            '/bug', 
            '&id=' 
            . $bug_id
        ); 
        if (empty($response) || empty($response->bugs)) {
            $this->_throw_error(
                'Empty response (missing "bugs" tag)'
            );
        }    
        $bug = current($response->bugs);
    
        return $bug;
    }

    /**
     * Get comment
     *
     * Gets comments with specified bug Id
     * 
     * @param integer $bug_id bugId
     * 
     * @return array
     **/         
    public function _get_comments($bug_id): array
    {
        $response = $this->_send(
            ' GET ', 
            '/bug/'
            . $bug_id
            . '/comment', 
            null
        );
        if (empty($response)) {
            return null;
        }    
        if (empty($response->bugs)) {
            return null;
        }
        $bugs = $response->bugs;
        $comments = $bugs->$bug_id->comments;
        if (empty($comments)) {
            return null;
        }        
        $result = [];        
        foreach ($comments as $comment) {
            $author = $comment->creator;
            $time = empty($comment->time) ?  $comment->time :null;
            $result[] = [
                'text' => (string) $comment->text,
                'author' => $author,
                'timestamp' => $time
            ];
        }

        return $result;
    }
     
    /**
     * Validate Custom Fields
     *
     * Validates custom fields for the visibility fields and control fields
     * 
     * @param string $customFieldName     custom field name
     * @param array  $input               bug input parameters array
     * @param object $customFieldValue    customfield value set 
     * @param object $customFieldMetaData custom field metadata object
     * 
     * @return void
     **/ 
    private function validateCustomFields(string $customFieldName, array $input, 
        $customFieldValue, $customFieldMetaData
    ) {       
        $customFieldInfo = $customFieldMetaData->fields;
        if (!empty($customFieldInfo) ) {
            foreach ($customFieldInfo as $field) {
                if ($field->is_custom && !empty($field -> visibility_field)) {
                    $isVisibilityFieldSet = $this->visibilityFieldSet(
                        $field -> visibility_field, $field-> visibility_values,
                        $input, $customFieldName
                    ); 
                    if (!$isVisibilityFieldSet) {
                        $this->_throw_error(
                            'Visibility field'
                            . $field -> visibility_field .
                            ' is turned off or blank . It is required to 
                             be on to use custom field '. $customFieldName
                        ); 
                    }
                    if (!empty($field->value_field) && in_array(
                        $field->type, [
                        Bugzilla_REST_defect_plugin::TYPE_DROPDOWN,
                        Bugzilla_REST_defect_plugin::TYPE_MULTISELECT]
                    )
                    ) {
                        $isControlFieldSet = $this->controlFieldSet(
                            $field->value_field, $field->values,
                            $input, $customFieldValue, 
                            $customFieldName
                        );
                    } 
                } 
            } 
        }   
    }

    /**
     * Visibility field set
     *
     * Checks if visibility field is set
     * 
     * @param string $visibiliyField   visibility field value
     * @param array  $visibilityValues Allowed visibility field values
     * @param object $input            bug data input parameters
     * @param object $customFieldName  custom field name
     * 
     * @return bool
     **/ 
    private function visibilityFieldSet(
        string $visibiliyField, 
        array $visibilityValues, 
        array $input, 
        string $customFieldName
    ): bool {
        $isVisibilityFieldSet = false;
        foreach ($input as $fieldName => $fieldValue) {
            if ($fieldName === $visibiliyField 
                || ($fieldName === 'platform' && $visibiliyField === 'rep_platform')
                || ($fieldName === 'severity' && $visibiliyField === 'bug_severity')
            ) {
                if (!$fieldValue) {
                    $this->_throw_error(
                        'Visibility field'. $visibiliyField .
                        'is turned off or blank in configuration. 
                        It is required to be on or set to use field '
                        . $customFieldName
                    ); 
                } else {
                    if (in_array($fieldValue, $visibilityValues)) {
                        $isVisibilityFieldSet = true;
                        break;
                    } 
                }
            }
        }

        return $isVisibilityFieldSet;  
    }
    
    /**
     * Control field set
     *
     * Checks if visibility field is set
     * 
     * @param string $controlField       controlfield value
     * @param array  $controlFieldValues Allowed control field values 
     * @param array  $input              Bug data input parameters
     * @param object $customFieldValues  customfield values
     * @param object $customFieldName    customfield name
     * 
     * @return bool
     **/ 
    private function controlFieldSet(string $controlField, 
        array $controlFieldValues, array $input, $customFieldValues, 
        string $customFieldName
    ): bool {
        $isControlFieldSet = false;
        $field = $controlField;
        if ($controlField === 'bug_severity') {
            $field = 'severity'; 
        } 
        if ($controlField === 'rep_platform') {
            $field = 'platform'; 
        } 
        if (empty($input[$field])) {
            $this->_throw_error(
                'Control field '
                . $controlField .
                ' is turned off or blank. It is required to 
                be set or on to use field '
                . $customFieldName
            );  
        }        
        $fieldvals = $customFieldValues;
        if (gettype($customFieldValues) !== 'array') {
            $fieldvals = explode(',', $customFieldValues);
        }        
        $isControlFieldSet=$this->containsControlField(
            $input[$field], $fieldvals, $controlFieldValues
        );

        return $isControlFieldSet;
    }
    
    /**
     * Contains Control Field
     *
     * Checks if field value selcted is present in control field values 
     * 
     * @param string $fieldValue         field value
     * @param array  $customFieldValues  Allowed control field values 
     * @param array  $controlFieldValues Control field values
     * 
     * @return bool
     **/ 
    private function containsControlField(string $fieldValue, 
        array $customFieldValues, 
        array $controlFieldValues
    ): bool {
        $isControlFieldSet = false;
        foreach ($customFieldValues as $customFieldValue) {
            foreach ($controlFieldValues as $controlFieldValue) {
                if ($controlFieldValue->name==$customFieldValue) {
                    if (empty($controlFieldValue->visibility_values)) {
                        $isControlFieldSet = true; 
                        break;
                    } else {
                        if (in_array(
                            $fieldValue, 
                            $controlFieldValue->visibility_values 
                        )
                        ) {
                            $isControlFieldSet = true;  
                            break;
                        } else {
                            $this->_throw_error(
                                $fieldValue . ' is not the correct '
                                . 'control field value for '
                                . $customFieldValue
                            );
                        }
                    }
                }
            }
        }

        return $isControlFieldSet;
    }

    /**
     * Add Bug
     *
     * Adds a new bug to the Bugzilla installation with the given
     * parameters (title, project etc.) and returns its ID.
     *
     * summary:     The summary of the new bug
     * product:     The ID of the product the bug should be added
     *              to
     * component:   The ID of the component the bug is added to
     * version:     The ID of the version the bug belongs to
     * description: The description of the new bug
     *
     * @param array $options attributs of bug
     * @param array $paths   attachment paths
     *
     * @return int
     **/
    public function add_bug(array $options,array $paths) : int
    {
        $fields = [];
        foreach ($options as $fieldName => $fieldValue) {
            if (!$fieldValue) {
                continue;
            }
            $field = $this->_format_field($fieldName, $fieldValue); 
            if (str::starts_with($fieldName, 'cf_')) { 
                $response = $this->_send(
                    'Get', '/field/bug/'.$fieldName, 
                    null
                );
                $fieldType = $this->getFieldFormat($response);
                $this->validateCustomFields(
                    $fieldName, $options, 
                    $fieldValue, $response
                );  
                if ($fieldType === Bugzilla_REST_defect_plugin::TYPE_DATE) {
                    $date = date::format_short_date(strtotime($fieldValue));
                    $fields[$fieldName] = $date;
                }
                if ($fieldType === Bugzilla_REST_defect_plugin::TYPE_DATE_TIME
                ) {
                    $dateTime = date::format_short_datetime(strtotime($fieldValue));
                    $fields[$fieldName] = $dateTime;
                } else {
                    $fields[$fieldName] = $field['value'];
                }
            } else {
                if (isset($field['name']) && isset($field['value'])) {
                    $fields[$field['name']] = $field['value'];
                }
            }
        }
        $response = $this->_send_command('/bug', $fields);        
        if (empty($response->id)) {
            $this->_throw_error('No bug ID received');
        }
        if (count($paths) > 1) {
            $this->_throw_error('Only one attachment allowed'); 
        }
        if (!empty($paths)) {
            $this-> _add_attachment($paths[0], $response->id, $options);
        }

        return $response->id ;  
    }

    /**
     * Get field format
     *
     * Get format type of the field
     *
     * @param array $customFieldData custom Field Data
     *
     * @return string
     **/
    private function getFieldFormat($customFieldData) : string
    {
        if (!empty($customFieldData)) { 
            return current($customFieldData->fields)->type;
        }
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
    private function _format_field(string $fieldName, $fieldValue): array
    {
         $data = [];
         $data['name'] = $fieldName;
         $data['value'] = $fieldValue;

        return $data;
    }

    /**
     * Format _add_attachment
     * 
     * Adding attachment to the bug with reference to bugId.
     *
     * @param string $path  file paths
     * @param int    $bugId bugID
     * @param array  $param 
     *  
     * @return array
     **/
    private function _add_attachment($path ,$bugId ,$param)
    {
        if (!$this->_curl) {
            $this->_curl = http::open();
        } 
        $url= $this->_address 
        . '/bug/' 
        . $bugId 
        . '/attachment?' 
        .  'login='
        . $this->_user
        .'&password='
        . $this->_password;

        $data = [];
        $cfile = curl_file_create($path);
        $cfile->postname = basename($cfile->name);
        $data = ['data' => base64_encode(file_get_contents($path)),
            'content_type' => $this->getMimeType($path),
            'file_name' => $cfile->postname,
            'comment' => 'comment',
            'is_patch' => false,
            'summary' => 'summary'
        ];
        $uploadResponse = http::post(
            $url,
            [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],  
                'data' => json_encode($data),
                'skip_url_encode' => true
            ]
        );
        $docContent = json::decode($uploadResponse->content);
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
     * Get MIME type
     *
     * @param string $filename file name
     *  
     * @return string
     **/
    private function getMimeType($filename) 
    {
        $realpath = realpath($filename);
        if ($realpath
            && function_exists('finfo_file')
            && function_exists('finfo_open')
            && defined('FILEINFO_MIME_TYPE')
        ) {
            return finfo_file(finfo_open(FILEINFO_MIME_TYPE), $realpath);
        }
        if (function_exists('mime_content_type')) {
            return mime_content_type($realpath);
        }
    }
}

class BugzillaException extends Exception
{
}
