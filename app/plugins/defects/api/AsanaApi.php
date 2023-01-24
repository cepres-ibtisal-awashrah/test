<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'plugins/defects/exceptions/AsanaApi.php';

/**
 * Asana REST API
 *
 * Wrapper class for the Asana REST API with functions for
 * retrieving assignee, tasks etc.
 */
class Asana_Api
{
    private $_address;
    private $_token;
    private $_workspaceId;
    private $_curl;

    /**
     * Construct
     *
     * Initializes a new Asana API object. Expects the web address
     * of the Asana installation including http or https prefix.
     *
     * @param string $address     Web address of asana installation.
     * @param string $token       Personal access token to authenticate.
     * @param string $workspaceId Id of the workspace
     */
    public function __construct(string $address,string $token,string $workspaceId)
    {
        $this->_address = str::slash($address);
        $this->_token = $token;
        $this->_workspaceId = $workspaceId;
    }

    /**
     * Get List From Workspace
     *
     * Returns a list of resources for the configured workspace.
     *
     * @param string $fieldName Name of the field.
     *
     * @return array
     */
    public function getListFromWorkspace(string $fieldName): array
    {
        return $this->_sendCommand(
            'GET',
            'workspaces/'
                . $this->_workspaceId
                . '/'
                . $fieldName
        )->data;
    }

    /**
     * Get Sections
     *
     * Returns sections for the given project.
     *
     * @param string $projectId Id of the project.
     *
     * @return array
     */
    public function getSections(string $projectId): array
    {
        return $this->_sendCommand(
            'GET',
            'projects/'
                . $projectId
                . '/sections'
        )->data;
    }

    /**
     * Get Customfield List
     *
     * Returns dropdown values for custom fields.
     *
     * @param string $fieldName Name of the custom field.
     * @param string $projectId Id of the project.
     *
     * @return array
     */
    public function getCustomFieldList(string $fieldName, string $projectId): array
    {
        $customField = [];
        $fields = $this->_sendCommand(
            'GET',
            str::format(
                'projects/{0}/custom_field_settings',
                $projectId
            )
        )->data ?? [];
        foreach ($fields as $field) {
            if ($field->custom_field->gid === str::replace($fieldName, 'customfield_', '')
                && isset($field->custom_field->enum_options)) {
                $customField = $field->custom_field->enum_options;
            }
        }

       return $customField;
    }

    /**
     * Get Task
     *
     * Gets an existing task from the Asana installation and returns it.
     *
     * @param string $taskId Id of an task.
     *
     * @return array|object
     */
    public function getTask(string $taskId)
    {
        return $this->_sendCommand(
            'GET',
            "tasks/"
                . urlencode($taskId)
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
                . 'api/1.0/'
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
     * @throws AsanaException
     */
    private function _sendRequest(string $method, string $url, $data = null)
    {
        if (!$this->_curl) {
            $this->_curl = http::open();
        }
        $debuggerOn = logger::is_on(GI_LOG_LEVEL_DEBUG);
        if ($debuggerOn) {
            logger::debug('Issuing Asana HTTP request');
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
                    'Authorization' => 'Bearer ' . $this->_token,
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
            $message = $data->errors[0]->message ?? '';
            if ($response->code === 401) {
                $errorMessage = 'Invalid HTTP code ({0}). Please check your token.';
            } elseif ($response->code === 404) {
                $errorMessage = 'Invalid HTTP code ({0}). Please check your '
                    . 'workspace id configuration and the task exists in Asana.';
            } elseif ($response->code === 400 && !empty($message) ) {
                $errorMessage =  'Invalid HTTP code ({0}) : ' . $message ;
            } else {
                $errorMessage = 'The request to Asana failed with an invalid HTTP '
                    . 'code ({0}).';
            }
            $this->_throwError($errorMessage, $response->code);
        }

        return $data;
    }

    /**
     * Add Task
     *
     * Adds a new task to the Asana installation with the given
     * parameters (name, description etc.) and returns its identifier.
     *
     * @param array $options Input data the user has entered in the push dialog.
     * @param array $paths   Attachments.
     *
     * @return string
     */
    public function addTask(array $options, array $paths): string
    {
        $customFields = [];
        $fields = [
            'workspace' => $this->_workspaceId
        ];
        foreach ($options as $fieldName => $fieldValue) {
            if (!$fieldValue) {
                continue;
            }
            if (str::starts_with($fieldName, 'customfield_')) {
                $customFields[
                    str::replace($fieldName, 'customfield_', '')
                ] =  $fieldValue;
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
            $fields["custom_fields"] = $customFields;
        }
        $response = $this->_sendCommand(
            'POST',
            'tasks',
            ['data' => $fields]
        )->data;
        foreach ($paths ?? [] as $path) {
            $this->_addAttachment($path, (int) $response->gid);
        }

        return $response->gid;
    }

    /**
     * Add Attachment
     *
     * Add attachment to the task.
     *
     * @param string $path   User uploaded file path.
     * @param int    $taskId task ID.
     *
     * @return void
     */
    private function _addAttachment(string $path, int $taskId)
    {
        if (!$this->_curl) {
            $this->_curl = http::open();
        }

        $cfile = new CURLFILE($path);
        $cfile->postname = $this->_getAttachedFileName(basename($cfile->name));
        $cfile->mime = $this->getMimeType($path);
        $response = http::request_ex(
            $this->_curl,
            'POST',
            $this->_address
               . 'api/1.0/tasks/'
               . $taskId
               . '/attachments',
            [
                'headers' => [
                    'Content-Type' => 'multipart/form-data',
                    'Authorization' => 'Bearer ' .  $this->_token
                ],
                'data' => [
                    'file' => $cfile
                ],
                'skip_url_encode' => true
            ]
        );
        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debugr('Got the following response', '');
            logger::debugr('response', $response);
        }
        if ($response->code !== 200) {
            $this->_throwError(
                'Invalid HTTP code ({0})', $response->code
            );
        }
    }

    /**
     * Get MIME type
     *
     * @param string $path file path
     *
     * @return string
     **/
    private function getMimeType(string $path): string
    {
        if ($path
            && function_exists('finfo_file')
            && function_exists('finfo_open')
            && defined('FILEINFO_MIME_TYPE')
        ) {
            return finfo_file(finfo_open(FILEINFO_MIME_TYPE), $path);
        }
        if (function_exists('mime_content_type')) {
            return mime_content_type($path);
        } else {
            return mime::get_type($path);
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
     * Format system field as per Asana API.
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
            case 'description':
                $data['name'] = 'notes';
                $data['value'] = $fieldValue;
                break;
            case 'project':
                $data['name'] = 'projects';
                $data['value'] = [$fieldValue];
                break;
            case 'section':
                $data['name'] = 'memberships';
                $data['value'] = [
                    (object) [
                        'section' => $fieldValue,
                        'project' => $project
                    ]
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
     * Explicitly throw the Asana exception.
     *
     * @param string      $format Error format to display.
     * @param string|null $params Extra parameters.
     *
     * @return void
     *
     * @throws AsanaException
     */
    private function _throwError(string $format, $params = null)
    {
        $args = func_get_args();
        throw new AsanaException(
            count($args) > 0
                ? str::formatv(array_shift($args), $args)
                : $format
        );
    }
}
