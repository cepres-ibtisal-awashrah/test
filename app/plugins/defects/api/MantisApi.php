<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'plugins/defects/exceptions/MantisApi.php';

/**
 * Mantis REST API
 *
 * Wrapper class for the Mantis REST API with functions for
 * retrieving projects, issues etc.
 */
class Mantis_Api
{
    private $_address;
    private $_token;
    private $_curl;

    /**
     * Construct
     *
     * Initializes a new Mantis API object. Expects the web address
     * of the Mantis installation including http or https prefix.
     * 
     * @param string $address Web address of Mantis installation.
     * @param string $token   Personal access token to authenticate.
     */    
    public function __construct(string $address,string $token)
    {
        $this->_address = str::slash($address);
        $this->_token = $token;
    }
    
    /**
     * Get Projects
     *
     * Returns a list of projects.
     * 
     * @return array
     */    
    public function getProjects(): array
    {
        $projectOptions = [];
        $projects = $this->_sendCommand(
            'GET',
            'projects/'
        )->projects ?? [];
        foreach ($projects as $project) {
            $projectOptions[$project->id] = $project->name;
        }

        return $projectOptions;
    }

    /**  
     * Get Categories
     *
     * Returns categories for the given project.
     * 
     * @param string|null $projectId Id of the project.
     * 
     * @return array
     */    
    public function getCategories($projectId): array
    {
        if (empty($projectId)) {
            return [];
        }
        $categories = $this->_sendCommand(
            'GET',
            'projects/' . $projectId 
        )->projects[0]->categories;

        return empty($categories) 
            ? [(object) ['name' => 'General']]
            : $categories;
    }

    /**
     * Get Customfield List
     * 
     * Returns dropdown values for custom fields. 
     * 
     * @param string      $fieldName Name of the custom field.
     * @param string|null $projectId Id of the project.
     * 
     * @return array
     */
    public function getCustomFieldList(string $fieldName, $projectId): array
    {
        $resultOptions = [];
        if (empty($projectId)) {
            return $resultOptions;
        }
        $projectCustomFields = $this->_sendCommand(
            'GET',
            'projects/' . $projectId
        )->projects[0]->custom_fields;
        foreach ($projectCustomFields as $field) {
            if ((string) $field->id === str::replace($fieldName, 'customfield_', '')) {
                foreach (explode('|', $field->possible_values) as $value) {
                    $resultOptions[$value] = $value;
                }
                break;
            }
        }

        return $resultOptions;
    }

    /**
     * Get Issue
     *
     * Gets an existing issue from the Mantis installation and returns it. 
     * 
     * @param string $issueId Id of an issue.
     * 
     * @return array|object
     */    
    public function getIssue(string $issueId)
    {
        return $this->_sendCommand(
            'GET',
            'issues/' 
                . urlencode($issueId)
        );
    }

    /**
     * Send Command
     *
     * Construct the actual url and send the request.
     * 
     * @param string     $method  Http method.
     * @param string     $command Relative path.
     * @param null|array $data    Input data for post request.
     * 
     * @return array|object
     */
    private function _sendCommand(string $method, string $command, $data = null) 
    {
        return $this->_sendRequest(
            $method,
            $this->_address 
                . 'api/rest/' 
                . $command,
            $data
        );
    }
    
    /**
     * Send Request
     *
     * Sends the API request and handle the exception.
     * 
     * @param string     $method Http method.
     * @param string     $url    Complete url for request.
     * @param null|array $data   Input data for post request.
     * 
     * @return array|object
     * 
     * @throws MantisException
     */
    private function _sendRequest(string $method, string $url, $data = null)
    {
        if (!$this->_curl) {
            $this->_curl = http::open();
        }
        $debuggerOn = logger::is_on(GI_LOG_LEVEL_DEBUG);
        if ($debuggerOn) {
            logger::debug('Issuing Mantis HTTP request');
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
                'data' => json::encode($data),
                'headers' => [
                    'Authorization' => $this->_token,
                    'Content-Type' => 'application/json'
                ]
            ]
        );
        // In case debug logging is enabled, we append the data we've
        // sent and the entire request/response to the log.
        if ($debuggerOn) {
            logger::debug('Got the following response');
            logger::debugr('response', $response);
        }
        $data = json::decode($response->content);
        if (!in_array($response->code, [200, 201])) {
            $message = $data->message ?? '';
            if ($response->code === 401) {
                $errorMessage = 'Invalid HTTP code ({0}). Please check your token.';
            } elseif ($response->code === 404) {
                $errorMessage = 'Invalid HTTP code ({0}). Please check your ' 
                    . 'configuration and the issue exists in Mantis.';
            } elseif ($response->code === 400 && !empty($message) ) {
                $errorMessage =  'Invalid HTTP code ({0}) : ' . $message ;
            } else {
                $errorMessage = 'The request to Mantis failed with an invalid HTTP ' 
                    . 'code ({0}).';
            }
            $this->_throwError($errorMessage, $response->code);
        }

        return $data;
    }

    /**
     * Add Issue
     *
     * Adds a new issue to the Mantis installation with the given
     * parameters (name, description etc.) and returns its identifier.
     * 
     * @param array $options Input data the user has entered in the push dialog.
     * @param array $paths   Attachments.
     * @param array $config  Fields configuration.
     *
     * @return string 
     */    
    public function addIssue(array $options, array $paths, array $config): string
    {
        $customFields = [];
        $fields = [];
        foreach ($options as $fieldName => $fieldValue) {
            if (!$fieldValue) {
                continue;
            }
            if (str::starts_with($fieldName, 'customfield_')) {
                if (is_array($fieldValue)) {
                    $fieldValue = implode('|',$fieldValue);
                }
                if (arr::get($config, "field.settings.$fieldName")['type'] === 'date') {
                    $fieldValue = strtotime($fieldValue);
                } 
                $customFields[] = [
                    'field'=> [ 
                        'id' => str::replace($fieldName, 'customfield_', '')
                    ],
                    'value' => $fieldValue
                ];
            } else {
                $field = $this->_formatField(
                    $fieldName,
                    $fieldValue,
                    $options['project']
                );
                if (isset($field['name']) && isset($field['value'])) {
                    $fields[$field['name']] = $field['value'];
                }
            }
        }
        if (!empty($customFields)) {
            $fields['custom_fields'] = $customFields;
        }
        foreach ($paths ?? [] as $path) {
            $cfile = new CURLFILE($path);
            $fields['files'][] = [
                'name' => $this->_getAttachedFileName(basename($cfile->name)),
                'content' =>  base64_encode(file_get_contents($path))
            ];
        }
        $response = $this->_sendCommand(
            'POST',
            'issues',
            $fields
        )->issue;

        return $response->id;
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
        $str_position = strpos($filename, '.');
        if ($str_position !== false) {
            return substr(
                $filename, 
                ($str_position + 1), 
                strlen($filename)
            );
        }

        return $filename;
    }

    /**
     * Format Field
     * 
     * Format system field as per Mantis API. 
     * e.g description field convert to notes. 
     *
     * @param string       $fieldName  Default field name.
     * @param string|array $fieldValue User selected value in push popup.
     * @param string|null  $project    Selected project value.
     *
     * @return array
     */
    private function _formatField(string $fieldName, $fieldValue, $project): array
    {
        $data = [
            'name' => $fieldName
        ];
        switch ($fieldName) {
            case 'project':
                $data['value'] = [
                    'id' => $fieldValue
                ];
                break;
            case 'category':    
            case 'priority':
            case 'view_state':
            case 'severity':
                $data['value'] = [
                    'name' => $fieldValue
                ];
                break;
            default:
                $data['name'] = $fieldName;
                $data['value'] = $fieldValue;
        }

        return $data;
    }

    /**
     * Throw Error
     * 
     * Explicitly throw the Mantis exception. 
     * 
     * @param string      $format Error format to display. 
     * @param string|null $params Extra parameters.
     * 
     * @return void
     * 
     * @throws MantisException
     */
    private function _throwError(string $format, $params = null)
    {
        $args = func_get_args();
        throw new MantisException(
            count($args) > 0
                ? str::formatv(array_shift($args), $args)
                : $format
        );        
    }
}
