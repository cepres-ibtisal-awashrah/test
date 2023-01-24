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

class Bugzilla_defect_plugin extends Defect_plugin
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
        'paltform' => 'on',
        'attachments' => 'on'
    ];
    
    private $_hoverDefaultFields = [
        'summary' => 'on',
        'product' => 'on',
        'component' => 'on',
        'version' => 'on',
        'description' => 'on',
        'os' => 'on',
        'platform' => 'on',
        'severity' => 'on',
        'priority' => 'on'
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
            'required' => true,
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
            'rows' => 10,
            'size' => 'compact'
        ],
        'alias' => [
            'type' => 'text',
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
            'type' => 'text',
            'label' => 'Orig. Estimates',
            'rows' => 1,
            'size' => 'compact'
        ],
        'cc' => [
            'type' => 'text',
            'label' => 'CC',
            'rows' => 3,
            'size' => 'compact'
        ],
        'url' => [
            'type' => 'text',
            'label' => 'URL',
            'rows' => 1,
            'size' => 'compact'
        ],
        'blocks' => [
            'type' => 'text',
            'label' => 'Blocks',
            'rows' => 1,
            'size' => 'compact'
        ],
        'see_also' => [
            'type' => 'text',
            'label' => 'See Also',
            'rows' => 1,
            'size' => 'compact'
        ],
        'depends_on' => [
            'type' => 'text',
            'label' => 'Depends On',
            'rows' => 1,
            'size' => 'compact'
        ],
        'deadline' => [
            'type' => 'text',
            'label' => 'Deadline',
            'rows' => 1,
            'size' => 'compact'
        ],
        'attachments' => [
            'type' => 'dropbox',
            'label'=>'attachments',
            'required' => false,
            'size' => 'none'
        ]
    ];
    private static $_meta = array(
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
description = on
deadline = off
depends_on = off
see_also = off
blocks = off
 = off
cc_detail = off 
importance = off
platform = on
estimated_time = off
severity = off
alias = off
status = off
estimated_time = off
priority = off
op_sys = on
attachments=on
');
    
    public function get_meta()
    {
        return self::$_meta;
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
        
        // Check required values for existance
        foreach (['address', 'user', 'password'] as $key) {
            if (empty($connection[$key])) {
                throw new ValidationException(
                    "Missing configuration for key '$key'"
                );
            }
        }
        
        $address = $connection['address'];
        
        // Check whether the address is a valid  (syntax only)
        if (!check::url($address)) {
            throw new ValidationException('Address is not a valid');
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
        $ini = ini::parse($config);
        $this->_address = str::slash($ini['connection']['address']);
        $this->_user = $ini['connection']['user'];
        $this->_password = $ini['connection']['password'];
        $this->_config = $ini;
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
        if ($this->_api) {
            return $this->_api;
        }
        
        $this->_api = new Bugzilla_api(
            $this->_address,
            $this->_user,
            $this->_password
        );
        
        return $this->_api;
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

            $field = $this->_fieldDefaults[$fieldName] ?? [];
            $category = arr::get(
                $this->_config,
                "field.settings.$fieldName"
            );
            
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
     * @return string
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
     * @param array $items Default configuration.
     *
     * @return array
     **/
    private function _to_id_name_lookup($items)
    {
        $result = array();
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
        $data = array();
        if ($field == 'summary' || $field == 'description') {
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
        if ($context['event'] == 'prepare') {
            $prefs = arr::get($context, 'preferences');
        } else {
            $prefs = null;
        }
        // And then try to connect/login (in case we haven't set up a
        // working connection previously in this request) and process
        // the remaining fields.
        $api = $this->_get_api();

        switch ($field)
        {
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
    private function _convert_customField_values($field) 
    {
      
        $result = array();
        foreach ($field as $key => $value) {

            $result[$value] = $value;
        }    

        return $result;
    }
    
    /**
     * Get Customfield values.
     * 
     * Get Customfield values 
     *
     * @param array $field default configuration.
     *
     * @return array
     **/
    private function _get_customfield_values(string $fieldName) 
    {
        $returnedValue = [];
        $api = $this->_get_api();
        $customField = $api->_send('Get','/field/bug/'.$fieldName, null, null); 
        if (empty($customField)) {
             _throw_error("Incorrect Name or Custom field does not exists");
        }
        $fields = $customField->fields;
        if (!empty($fields) && count($fields) == 1) {
            $customField  = $fields[0];
            if (isset($customField) && $customField->is_custom) {
           
                $fieldFormat = $customField->type;
                if (in_array(
                    $fieldFormat, [Bugzilla_defect_plugin::TYPE_DROPDOWN,
                    Bugzilla_defect_plugin::TYPE_MULTISELECT]
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
      * @param array $fieldName 
      *
      * @return array
      **/
    private function getCustomFieldLegalValues(string $fieldName)
    {
        $api = $this->_get_api();
        $response = $api->_send('Get', '/field/bug/'.$fieldName.'/values' ,null);  

        return $response -> values;    
    }
 
    /**
     * Push
     * 
     * Method for pushing bug
     *
     * @param object $context default configuration.
     * @param array  $input  
     * @param array  $path    file paths for attachment
     *
     * @return string 
     **/
    public function push($context, $input, $path = []) 
    {
        $api = $this->_get_api();

        return $api->add_bug($input, $path);
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
        $bug = $api->get_bug($defect_id);
        $comments = $api->_get_comments($defect_id);

        if ($bug->is_open) {        
            $status_id = GI_DEFECTS_STATUS_OPEN;
        } else {
            $status_id = GI_DEFECTS_STATUS_CLOSED;
        }
        
        // The first comment of a Bugzilla bug is the description
        // of the bug.
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

        $attributes = array();
        
        if (!empty($bug->status)) {
            $attributes['Status'] = h($bug->status);
        }

        if (!empty($bug->product)) {
            // Add a link to the product.
            $attributes['Product'] = str::format(
                '<a target="_blank" href="{0}describecomponents.cgi?
                product={1}">{2}</a>',
                a($this->_address),
                a($bug->product),
                h($bug->product)
            );
        }

        if (!empty($bug->component)) {
            $attributes['Component'] = h($bug->component);
        }

        $hoverFields = $this->_config['hover.fields'] ?? $this->_hoverDefaultFields;
        foreach ($hoverFields as $fieldName => $value) {
            if ($value !== 'on') {
                    continue;
            }
            $options = [
                'Priority' => $bug->priority,
                'Severity' => $bug->severity,    
                'Platform' => $bug->platform,
                'OS' => $bug->op_sys,
            ];     
            foreach ($options as $field => $item) {
                if (strcasecmp($field, $fieldName)) {
                    $attributes[$field] = h($item);
                }
            }
            if (str::starts_with($fieldName, 'cf_')) {
               
                $configGroup = $this->_config["field.settings.$fieldName"];
                if (!isset($configGroup)) {
                    continue;
                }
           
                if (!empty($configGroup['label'])) {
                    if (gettype($bug->$fieldName)==='array') {
                        $attributes[$configGroup['label']] 
                            = implode(',', $bug->$fieldName);
                    } else {
                        $attributes[$configGroup['label']] = $bug->$fieldName;
                    }
                }
            }
        
        } 
        
        return array(
            'id' => $defect_id,
            '' => str::format(
                '{0}show_bug.cgi?id={1}',
                $this->_address,
                $defect_id
            ),
            'title' => $bug->summary,
            'status_id' => $status_id,
            'status' => $bug->status,
            'description' => $description,
            'attributes' => $attributes
        );
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
    private function _check_version()
    {
        $response = $this->_send('Get', '/version', null);
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
    public function get_status() 
    {
        $status = [
            'CONFIRMED'=> 'CONFIRMED' ,
            'UNCONFIRMED' => 'UNCONFIRMED',
            'IN_PROGRESS' => 'IN_PROGRESS'
        ];
        $result = array();
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
    public function get_platform() 
    {
        $platforms = [
            'PC'=> 'PC' ,
            'MACINTOSH' => 'MACINTOSH',
            'ALL' => 'ALL',
            'OTHER' => 'OTHER'
        ];
        $result = array();
        foreach ($platforms as $id => $name) {
            $p = obj::create();
            $p->id = $id;
            $p->name = $name;
            $result[] = $p;
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
    public function get_severity() 
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
        $result = array();
        foreach ($severities as $id => $name) {
            $p = obj::create();
            $p->id = $id;
            $p->name = $name;
            $result[] = $p;
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
    public function get_priorities() 
    {
        $priorities = [
            'Highest' => 'Highest',
            'High'=> 'High',
            'Normal' => 'Normal',
            'Low' => 'Low',
            'Lowest' => 'Lowest'
        ];
        $result = array();
        foreach ($priorities as $id => $name) {
             $p = obj::create();
            $p->id = $id;
            $p->name = $name;
            $result[] = $p;
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
    public function get_os() 
    {
        $systems = [
            'Linux'=> 'Linux' ,
            'Windows' => 'Windows',
            'Mac OS' => 'Mac OS',
            'All' => 'All',
            'Other' => 'Other'
        ];
        $result = array();
        foreach ($systems as $id => $name) {
            $p = obj::create();
            $p->id = $id;
            $p->name = $name;
            $result[] = $p;
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
    public function _send($method, $url, $queryParam)
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
        
        $urlWithCredentials = $this->_address . $url . '?' . 'login='.$this->_user .
            '&password='. $this->_password;
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
    private function _send_command($url , $data = array())
    {
        
        if (!$this->_curl) {
             $this->_curl = http::open();
        }
        $urlWithCredentials = $this->_address . $url . '?'. 'login='.$this->_user 
                             . '&password=' . $this->_password;
     
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
        // Get a list of product IDs first.
        $response = $this->_send('Get','/product_enterable',null,null);
        //print_r($response);
        $productIds = (array)$response;
      
        if (!$response) {
            return array();
        }

        foreach ($productIds['ids'] as $fieldValue) {
            $productParams = '&ids='.$fieldValue;
        }
 
        $prodresponse = $this->_send('Get', '/product', $productParams);
        $products = (array)$prodresponse; 
        if (!$response) {
            return array();
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
    
    private function _get_fields($name, $product_id)
    {
        //print_r("in get field");
        $response = $this->_send('Get', "/field/bug/$name", null);
        //print_r($response);
        $productField = (array)$response;

        if (!$response) {
            return array();
        }
        
        if (!isset($productField['fields']) || !$productField['fields']) {
            $this->_throw_error(
                'Invalid response (missing "fields" parameter)'
            );
        }
        
        $field = current($productField['fields']);
        $fieldval= (array)$field->values;
   
        if (empty($fieldval)) {
            return array();
        }
        
        $result = array();
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
    public function get_components($product_id)
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
     * @param integer $product_id productId
     *
     * @return object 
     **/
    public function get_versions($product_id)
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
        $response = $this->_send('Get', '/bug', "&id=$bug_id");
        
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
    public function _get_comments($bug_id)
    {
        $response = $this->_send('GET', '/bug/'.$bug_id.'/comment', null, null);

        if (empty($response)) {
            return null;
        }    
        if (empty($response->bugs)) {
            return;
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
            $result[] = array(
                'text' => (string) $comment->text,
                'author' => $author,
                'timestamp' => $time
            );
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
     * @return array
     **/ 
    private function validateCustomFields(string $customFieldName ,array $input, 
        $customFieldValue,$customFieldMetaData
    ) {       
        $customFieldInfo = $customFieldMetaData->fields;
    
        if (!empty($customFieldInfo) ) {
            foreach ($customFieldInfo as $field) {
                if ($field->is_custom) {

                    $isVisibilityFieldSet = $this->visibilityFieldSet(
                        $field -> visibility_field, $field-> visibility_values,
                        $input, $customFieldName
                    );
                 
                    if (!$isVisibilityFieldSet) {
                        $this->_throw_error(
                            'Visibility field'. $field -> visibility_field .
                            ' is turned off in configuration. It is required to 
                             be on to use custom field'. $customFieldName
                        ); 
                    }

                    if (in_array(
                        $field->type, [
                        Bugzilla_defect_plugin::TYPE_DROPDOWN,
                        Bugzilla_defect_plugin::TYPE_MULTISELECT]
                        )
                    ) {
                        $isControlFieldSet = $this->controlFieldSet(
                            $field->value_field, $field->values,
                            $input, $customFieldValue, 
                            $customFieldName
                        );                                           
                    } 
                } else {
                    throw_error($customFieldName.'is not a custom field');
                    break;    
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
     * @return array
     **/ 
    private function visibilityFieldSet($visibiliyField, $visibilityValues, $input,
        $customFieldName
    ) :bool {
        $isVisibilityFieldSet = false;    
  
        foreach ($input as $fieldName => $fieldValue) {
            if ($fieldName===$visibiliyField 
                || ($fieldName == 'platform' && $visibiliyField == 'rep_platform')
            ) {
                if (!$fieldValue) {
                    $this->_throw_error(
                        'Visibility field'. $visibiliyField .
                        'is turned off in configuration. It is required to 
                        be on to use custom field'. $customFieldName
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
     * @return array
     **/ 
    private function controlFieldSet($controlField ,$controlFieldValues ,$input ,
        $customFieldValues ,$customFieldName
    ) {
        $isControlFieldSet = false;
        foreach ($input as $fieldName => $fieldValue) {
            if ($fieldName===$controlField || ($fieldName ==='severity'
                && $controlField ==='bug.severity')
            ) {
                if (!$fieldValue) {
                    $this->_throw_error(
                        'Control field'. $controlField .
                        'is turned off in configuration. It is required to 
                        be on to use custom field'. $customFieldName
                    );  
                } else {
                    $isControlFieldSet=$this->containsControlField(
                        $fieldValue, $customFieldValues, $controlFieldValues
                    );
                }
            } 
        }    
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
     * @return array
     **/ 
    private function containsControlField(string $fieldValue, 
        array $customFieldValues, 
        array $controlFieldValues
    ) {
        $isControlFieldSet = false;
        
        foreach ($customFieldValues as $customFieldValue) {
            foreach ($controlFieldValues as $controlFieldValue) {
                if ($controlFieldValue->name==$customFieldValue) {
                    if (empty($controlFieldValue->visibility_values)) {
                        $isControlFieldSet = true; 
                    } else {
                        if (in_array(
                            $fieldValue, 
                            $controlFieldValue->visibility_values 
                        )
                        ) {
                            $isControlFieldSet = true;                  
                        } else {
                            $this->_throw_error($controlFieldValue .'is not set correctly');
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
                if ($fieldType === 9) {
                    $date = date::format_short_date(strtotime($fieldValue));
                    $fields[$fieldName] = $date;
                } elseif ($fieldType === 5) {
                    $dateTime = date::format_short_datetime(strtotime($fieldValue));
                    $fields[$fieldName] = $dateTime;
                } else {
                    $fields[$fieldName] = $field['value'];
                }
            }
            if (isset($field['name']) && isset($field['value'])) {
                $fields[$field['name']] = $field['value'];
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
    private function _format_field(string $fieldName, $fieldValue)
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
    private function _add_attachment(String $path ,int $bugId ,array $param)
    {
        if (!$this->_curl) {
            $this->_curl = http::open();
        } 
        // URL for uploading files is different than other API Urls.
        $credentials = 'login='.$this->_user.'&password='.$this->_password;
        $url= $this->_address.'/bug/' . $bugId .'/attachment?' . $credentials;
        $data = [];
        $cfile = curl_file_create($path);
        $cfile->postname = basename($cfile->name);

        $data = ['data' => $cfile ,
        'content_type' => mime_content_type($path) ,
        'file_name' => $cfile->postname,
        'comment' => "comment",
        'is_patch' => false,
        'summary' => "summanry"
        ];
        $uploadResponse = http::post(
            $url,
            [
                'headers' => [
                    'Content-Type' => 'multipart/form-data'
                ],  
                'data' => $data,
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
}

class BugzillaException extends Exception
{
}

// Check for the xmlrpc PHP module/extensions that is required by
// this plugin.
if (!function_exists('xmlrpc_encode_request'))
{
    throw new BugzillaException(
        'The Bugzilla defect plugin requires the xmlrpc PHP
extension which has not yet been installed.'
    );
}
