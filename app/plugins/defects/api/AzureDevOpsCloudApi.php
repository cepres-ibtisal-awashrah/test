<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'plugins/defects/exceptions/AzureDevOpsCloud.php';

/**
 * DevOps API
 *
 * Wrapper class for the Azure Devops API with functions for retrieving
 * projects, bugs etc. from a Azure Devops installation.
 */
class DevOps_Cloud_api
{
    private $_address;
    private $_user;
    private $_password;
    private $_version;
    private $_curl;

    const API_VERSION = 'api-version=5.0';
    const API_PREVIEW = '-preview.1';
    const API_URI_END = self::API_VERSION . self::API_PREVIEW; 
    const AZURE_ENDPOINT = 'https://vssps.dev.azure.com/{ORGANIZATION_NAME}/_apis/graph/users?{URI_SUFFIX}';
    
    /**
     * Construct
     *
     * Initializes a new DevOps API object. Expects the web address
     * of the DevOps installation including http or https prefix.
     */	
    public function __construct($address, $user, $password)
    {
        $this->_address = str::slash($address);
        $this->_user = $user;
        $this->_password = $password;
    }
    
    private function _throw_error($format, $params = null)
    {
        $args = func_get_args();

        throw new DevOps_Cloud_Exception(
            count($args) > 0
                ? str::formatv(array_shift($args), $args)
                : $format
        ); 
    }
    
    // Sends an API request using the default address of the configuration
    // Appends the path to the resource to the base address, then calls _send_request
    private function _send_command($method, $command, $data = array())
    {
        return $this->_send_request($method, $this->_address . $command, $data);
    }
    
    // Sends an API request.
    // Requires the full URL for the request to be made data can be null
    private function _send_request($method, $url, $data)
    {
        if (!$this->_curl) {
            // Initialize the cURL handle. We re-use this handle to
            // make use of Keep-Alive, if possible.
            $this->_curl = http::open();
        }
        
        // In case debug logging is enabled, we append the data
        // we've sent and the entire request/response to the log.
        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debug('Issuing DevOps HTTP REST request');
            logger::debugr(
                'request',
                [
                    'method' => $method,
                    'url' => $url,
                    'data' => $data
                ]
            );
        }
                
        $response = http::request_ex(
            $this->_curl,
            $method, 
            $url, 
            [
                'data' => $data,
                'user' => $this->_user,
                'password' => $this->_password,
                'headers' => [
                    'Content-Type' => 'application/json-patch+json'
                ]
            ]
        );

        // In case debug logging is enabled, we append the data we've
        // sent and the entire request/response to the log.
        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debug('Got the following response');
            logger::debugr($response, $response);
        }

        if ($response->code != 200) {
            $message_json = json_decode($response->content);
            // Some 400 errors will be returned in HTML 
            if (!isset($message_json->{'message'})) {
                $message = sprintf(
                    'API returned error code %d, but no JSON data. Please verify '
                    . 'the ID you are hovering over, your configuration settings for the "Push" dialog, and the '
                    . 'data being pushed.',
                    $response->code
                );

                $this->_throw_error($message);
            } else {
                $message = $message_json->{'message'};
                $this->_throw_error(
                    'HTTP code ' . $response->code . ': ' . $message
                );
            }
        }
        
        return json::decode($response->content);
    }


    /**
    * Get Issue
    *
    * Gets an existing issue from the DevOps project and
    * returns it. The resulting issue object has various properties
    * such as the name, project, etc.
    */
    public function get_issue($issue_id, $project)
    {
        return $this->_send_command(
            'GET', $project . '/_apis/wit/workitems/' . urlencode($issue_id) . '?' . static::API_VERSION
        )->fields;
    }

    /**
     * Get Assignees
     *
     * Returns a list of assignees for the given project for the DevOps
     * instance. Assignees are returned as array of objects, each
     * with its name principal name and display name.
     *
     * If an x-ms-continuationtoken header is returned, the header
     * value is used to retrieve the next set of users.
     *
     * https://docs.microsoft.com/en-us/rest/api/azure/devops/graph/users/list?view=azure-devops-rest-5.0
     */
    public function get_assignees()
    {
        $requestAssignee = $this->_get_assignee_batches();
        $response = $requestAssignee->{'value'};
        while (isset($requestAssignee->{'headers'}['x-ms-continuationtoken'])) {
            $continuation = $requestAssignee->{'headers'}['x-ms-continuationtoken'];
            $r = $this->_get_assignee_batches($continuation);

            if ($requestAssignee->{'count'} > 0) {
                $response = array_merge($response, $requestAssignee->{'value'});
            }
        }
        if (!$response) {
            return [];
        }
        
        $result = [];
        foreach ($response as $assignee) {
            $result[] = (object) [
                'id' => $assignee->principalName,
                'name' => $assignee->displayName
            ];
        }

        return $result;
    }
    
    /** 
     * Get Assignees in batches
     * 
     * Return a list of users based on $continuation token, as the
     * DevOps API limits the number of results and includes a continuation token
     * token if there are more results
     * 
     * @param string $continuationToken x-ms-continuationtoken header is returned, the header
     * value is used to retrieve the next set of users
     * 
     * @return void
     */
    private function _get_assignee_batches($continuationToken = null)
    {
        $data = [];
        $uriEnd = 'subjectTypes=msa&';
        if ($continuationToken !== null) {
            $uriEnd .= 'continuationToken=' . $continuationToken . '&' . $uriEnd;
        }
        $uriEnd .= static::API_URI_END;
        $organizationName = explode('/', $this->_address)[3] ?? null;

        return $this->_send_request(
            'GET',
            str_replace(
                ['{ORGANIZATION_NAME}', '{URI_SUFFIX}'],
                [$organizationName, $uriEnd ], 
                static::AZURE_ENDPOINT
            ),
            $data
        );
    }
    
    /**
     * Add Issue
     *
     * Adds a new issue to DevOps with the given
     * parameters (title, project etc.) and returns its ID.
     *
     * push_data: The data passed from the push dialog
     * field_defaults: _fieldDefaults from the DevOps Class
     * plugin_config: The details entered into the 'Defect Plugin' text box
     */	
    public function add_issue($push_data, $project, $plugin_config, $field_defaults, array $paths)
    {	
        $issue_type = $push_data['item_type'];
        // The configuration for description fields based on issue type
        $issue_type_settings = arr::get($plugin_config, "type.settings.$issue_type");
        //Convert whitespace to %20 to handle types with spaces
        $issue_type = str_replace(' ', '%20', $issue_type);
        $issue = [];
        foreach ($push_data as $post_field => $value) {
            if ($value === null || $post_field === 'item_type') {
                continue;
            }

            // Drill down to push.field.post_field -> api_field, if it exists
            // Otherwise use field_defaults[post_field]['api_field']
            $api_field = null;
            $config_group_name = "field.settings.$post_field";
            $config_group = arr::get($plugin_config, $config_group_name);
            $api_field = empty($config_group['api_field'])
                ? $field_defaults[$post_field]['api_field']
                : $config_group['api_field'];

            switch($post_field) {
                case 'description':
                case 'repro_steps':
                case 'system_info':
                    // Ignore text entered into Description, System Info, or Repro Steps if not explicitly enabled
                    if (!$this->is_config_field_on($issue_type_settings, $post_field)) {
                        break;
                    }
                default:
                    $issue[] = [
                        'op' => 'add',
                        'path' => '/fields/' . $api_field,
                        'from' => null,
                        'value' => $value
                    ];
                    break;
            }
        }
        $data = json::encode($issue);
        $response = $this->_send_command(
            'POST',
            $project 
                . '/_apis/wit/workitems/$' 
                . $issue_type 
                . '?' 
                . static::API_VERSION,
            $data
        );
        $this->_add_attachment($paths, $response->id);

        return $response->id;
    }
    
    /**
     * Get Types
     *
     * Gets the available entity types for the DevOps project
     * Types are returned as array of objects, each with its ID
     * and name.
     * 
     * @param string $project sending project name.
     * 
     * @return array
     */
    public function get_types(string $project): array
    {
        return $this->_send_command(
            'GET', $project . '/_apis/wit/workitemtypes?' . static::API_VERSION
        )->value;
    }

    /**
     * Get Status
     *
     * Gets the available states for the DevOps project
     * Status are returned as array of objects, each with its ID
     * and name.
     * 
     * @param string $project sending project name.
     * 
     * @return array
     */
    public function get_status(string $project, string $item_type): array
    {
        return $this->_send_command(
            'GET', $project . '/_apis/wit/workitemtypes/' .$item_type. '/states?' . static::API_URI_END
        )->value;
    }
    
    /**
     * Get List
     *
     * Gets the options for a specific list in DevOps
     * Parses the response and returns an array of list options
     * 
     * @param string $list_id pass packlist id to fetch possible values.
     * 
     * @return array
     * 
     * @throws ValidationException
     */
    public function get_list(string $list_id): array
    {
        $data = [];
        $url = $this->_address 
            . '_apis/work/processes/lists/' 
            . $list_id 
            . '?' 
            . static::API_URI_END;
        $response = $this->_send_request('GET', $url, $data);
        $result = [];
        if (isset($response->{'items'})) {
            foreach ($response->{'items'} as $item) {
                $result[$item] = $item;
            }

            return $result;
        } else {
            $this->_throw_error(
                'List ID ' . $list_id . ' could not be retrieved or has no items.'
            );
        }
    }
    
    /**
	 * Parse Organization
     * 
	 * Parse organization from the base address.
	 * 
	 * @return string
	 */
    private function _parse_organization()
    {
        return preg_split(
            '/\./',
            parse_url($this->_address, PHP_URL_HOST)
        )[0] ?? '';
    }

    /**
	 * Add Attachment
     * 
	 * Store attached file and return token and attachment id.
	 * 
	 * @param array $paths   User uploaded file paths. 
	 * @param int   $issueId Newly created Issue id. 
	 * 
	 * @return object
	 * 
	 * @throws BitbucketException
	 */
	private function _add_attachment(array $paths, int $issueId)
	{
        $uploads = [];
        if (!$this->_curl) {
            $this->_curl = http::open();
        }
        foreach ($paths ?? [] as $fileName) {
            if (!empty($fileName) && $data = file_get_contents($fileName)) {
                $params = [
                    'filename' => $this->_getAttachedFileName(basename($fileName)),
                    'api-version' => '5.0',
                ];
                $data = file_get_contents($fileName);
                $urlFileUpload = $this->_address
                    . '_apis/wit/attachments?'
                    . http_build_query($params);
                $response = http::request_ex(
                    $this->_curl,
                    'POST',
                    $urlFileUpload,
                    [
                        'user' => $this->_user,
                        'password' => $this->_password,
                        'data' => $data,
                        'headers' => [
                            'Content-Type' => 'application/octet-stream'
                        ],
                        'skip_url_encode' => true
                    ]
                );
                $obj = json::decode($response->content);
                // prepare json request body to Patch attachments to a particular work item. 
                $uploads[] =  [ 
                    "op" => "add",
                    "path" => "/relations/-",
                    "value" => [
                        "rel" => "AttachedFile",
                        "url" => $obj->url,
                        "attributes" => [
                            "comment" => "File attached"
                        ]
                    ]
                ];
            }
        }

        if (!empty($uploads)) {
            $urlFileAttach = $this->_address
                .'_apis/wit/workitems/'
                . $issueId. '?'
                . static::API_VERSION;
            $uploadResponse = http::request_ex(
                $this->_curl,
                'PATCH',
                $urlFileAttach,
                [
                    'user' => $this->_user,
                    'password' => $this->_password,
                    'data' => json_encode($uploads),
                    'headers' => [
                        'Content-Type' => 'application/json-patch+json'
                    ],
                    'skip_url_encode' => true
                ]
            );
            // In case debug logging is enabled, we append the data we've
            // sent and the entire request/response to the log.
            if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
                logger::debug('Got the following response');
                logger::debugr($response, $uploadResponse);
            }

            if (!in_array($uploadResponse->code, [200, 201])) {
                $this->_throw_error(
                    'Invalid HTTP code ({0}). Please check your user/' .
                    'password and the [repository] configuration.',
                    $uploadResponse->code
                );
            }
        }
	}

	/**
     * Get Attached Filename
     * 
	 * Fetch pure filename from filepath.
	 * 
	 * @param string $filename User uploaded file path. 
	 * 
	 * @return string
	 */
	private function _getAttachedFileName(string $filename): string
	{
		$str_pattern = '.';
		if (strpos($filename, $str_pattern) !== false) {
			return substr(
                $filename, 
                (strpos($filename, $str_pattern) + 1), 
                strlen($filename)
            );
		}

		return $filename;
     }
     
    /**
     * Get Config Value
     * 
     * Checks if $field[$target] exists, and if it exists, if it is set '=on' 
     * 
     * @param array  $field  Default fields list.
     * @param string $target Item type defined in configuration block.
     * 
     * @return bool
     */ 
    private function is_config_field_on(array $field, string $target): bool
    {
        return isset($field[$target]) && $this->is_on($field[$target]);
    }
    
    /**
     * Is On
     * 
     * Check if the defined fieldname in configuration block is on or off.
     * 
     * @param string $value field name defined in configuration block.
     * 
     * @return string
     */
    private function is_on(string $value): string
    {
        return (str::to_lower($value) === 'on') || (str::to_lower($value) === 'default');
    }
}
