<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'plugins/defects/exceptions/GitLabApi.php';

/**
 * GitLab REST API
 *
 * Wrapper class for the GitLab REST API with functions for
 * retrieving milestones, issues etc.
 */
class GitLab_api
{
    private $_address;
    private $_token;
    private $_projectId;
    private $_curl;

    /**
     * Construct
     *
     * Initializes a new GitLab API object. Expects the web address
     * of the GitLab installation including http or https prefix.
     */	
    public function __construct($address, $token, $projectId)
    {
        $this->_address = str::slash($address);
        $this->_token = $token;
        $this->_projectId = $projectId;
    }
    
    /**
     * Get Labels
     *
     * Returns a list of labels for the configured project. The labels are
     * returned as array of objects, each with its ID and name.
     * 
     * @return array
     */	
    public function get_labels(): array
    {
        $result = [];
        $labels = $this->_send_command(
            'GET',
            "projects/$this->_projectId/labels"
        );

        foreach ($labels ?? [] as $label) {
            $result[] = (object) [
                'id' => $label->name,
                'name' => $label->name
            ];
        }
        
        return $result;
    }

    /**
     * Get Assignees
     * 
     * Returns a list of Assignees. The Assignees are returned as
     * array of objects, each with its ID and name.
     * 
     * @return array
     */
    public function get_assignees(): array
    {
        $result = [];
        $members = $this->_send_command(
            'GET',
            "projects/$this->_projectId/members"
        );

        foreach ($members ?? [] as $member) {
            $result[] = (object) [
                'id' => (string) $member->id,
                'name' => $member->name
            ];
        }

        return $result;
    }

    /**
     * Get Milestones
     *
     * Returns a list of milestones for the given project for the GitLab
     * installation. Milestones are returned as array of objects, each
     * with its ID and name.
     * 
     * @return array
     */
    public function get_milestones(): array
    {
        $result = [];
        $response = $this->_send_command(
            'GET',
            "projects/$this->_projectId/milestones"
        );
        
        foreach ($response ?? [] as $milestone) {
            $result[] = (object) [
                'id' => $milestone->id,
                'name' => $milestone->title
            ]; 
        }
        
        return $result;
    }

    /**
     * Get Issue
     *
     * Gets an existing case from the GitLab installation and returns
     * it. The resulting issue object has various properties such as
     * the summary, description, repo etc.
     * 
     * @param string $issueId Id of an issue.
     * 
     * @return array|object
     */	
    public function get_issue(string $issueId)
    {
        return $this->_send_command(
            'GET',
            "projects/$this->_projectId/issues/" . urlencode($issueId)
        );
    }

    /**
     * Send Command
     *
     * Construct the actual url and send the request.
     * 
     * @param string      $method  Http method.
     * @param string      $command Relative path.
     * @param null|array  $data    Input data for post request.
     * 
     * @return array|object
     */
    public function _send_command(string $method, string $command, $data = null) 
    {
        return $this->_send_request(
            $method,
            "{$this->_address}api/v4/{$command}",
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
     * @throws GitLabException
     */
    private function _send_request(string $method, string $url, $data = null)
    {
        if (!$this->_curl) {
            // Initialize the cURL handle. We re-use this handle to
            // make use of Keep-Alive, if possible.
            $this->_curl = http::open();
        }

        $debuggerOn = logger::is_on(GI_LOG_LEVEL_DEBUG);
        if ($debuggerOn) {
            logger::debug('Issuing GitLab HTTP request');
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
                    'Authorization' => 'Bearer '.$this->_token,
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

        if (!in_array($response->code, [200, 201])) {
            if ($response->code === 401) {
                $errorMessage = 'Invalid HTTP code ({0}). Please check your token.';
            } elseif ($response->code === 404) {
               $errorMessage = 'Invalid HTTP code ({0}). Please check your project_id configuration and the issue exists in GitLab.';
            } else {
                $errorMessage = 'The request to GitLab failed with an invalid HTTP code ({0}).';
            }
            $this->_throw_error($errorMessage, $response->code);
        }

        return json::decode($response->content);
    }

    /**
     * Add Issue
     *
     * Adds a new issue to the GitLab installation with the given
     * parameters (title, description etc.) and returns its identifier.
     * The parameters must be named according to the GitLab API
     * format,
     * e.g.:
     *
     * title:       The title of the new issue
     * milestone:   The ID (number) of the milestone the issue
     *				should be added to
     * description: The description of the new issue
     * 
     * @param array $options Input data the user has entered in the push dialog.
     * @param array $paths User uploaded file path.
     *
     * @return string 
     */	
    public function add_issue(array $options, array $paths = []): string
    {
        $fields = [];
        foreach ($options as $field_name => $field_value) {
            if (!$field_value) {
                continue;
            }

            $field = $this->_format_field(
                $field_name,
                $field_value);

            if (isset($field['name']) && isset($field['value'])) {
                $fields[$field['name']] = $field['value'];
            }
        }

        $response = $this->_send_command(
            'POST',
            'projects/' . $this->_projectId . '/issues',
            $fields
        );
        $this->_add_attachment_repo($paths, $response);
       
        return $response->iid;
    }


    /**
     * Add Attachment Repo
     * 
     * Store attachment in the gitlab cloud infrastructure 
     * and later attach the files to the specific issue.
     * 
     * @param array  $paths        User uploaded file path.
     * @param object $pushResponse Newly created add issue response object.
     * 
     * @return void
     * 
     * @throws GitLabException
     */
    private function _add_attachment_repo(array $paths, object $pushResponse) 
    {
        if (!$this->_curl) {
            $this->_curl = http::open();
        }
        $arrMarkDownUrls[] =  str_replace('\\/', '/', $pushResponse->description."\n\n");
        foreach ($paths ?? [] as $path) {
            $cfile = curl_file_create($path);
            $cfile->postname = $this->_getAttachedFileName($cfile->name);
            $data = ['file' => $cfile];
            $url = $this->_address
            . 'api/v4/projects/'
            . $this->_projectId
            . '/uploads?private_token='
            . $this->_token;
            $response = http::request_ex(
                $this->_curl,
                'POST',
                $url,
                [
                    'data' => $data,
                    'headers' => [
                        'Content-Type' => 'multipart/form-data'
                    ],
                    'skip_url_encode' => true
                ]
            );
            $responseContent = json_decode($response->content);
            // prepare json request body to Patch attachments to a particular work item.
            $arrMarkDownUrls[] =  $responseContent->markdown;
            $uploads['description'] = implode(' ', $arrMarkDownUrls);
        }
        
        if (!empty($uploads)) {
            $urlFileAttach = $this->_address
                . 'api/v4/projects/'
                . $this->_projectId
                . '/issues/'
                . $pushResponse->iid
                . '?private_token='
                . $this->_token;
            $uploadResponse = http::request_ex(
                $this->_curl,
                'PUT',
                $urlFileAttach,
                [
                    'data' => json_encode($uploads),
                    'headers' => [
                        'Content-Type' => 'application/json'
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
            //$occurrence = strpos($filename, $str_pattern)+1;
            return substr($filename, strpos($filename, $str_pattern)+1, strlen($filename));
        }

        return $filename;
    }


    /**
     * Format system field as per Gitlab API. 
     * e.g description field convert to body 
     *
     * @param string $fieldName  default field name
     * @param string|array $fieldValue user select value in push popup
     *
     * @return array.
     */
    private function _format_field(string $fieldName, $fieldValue): array
    {
        $data = [
            'name' => $fieldName
        ];

        switch ($fieldName) {
            case 'milestone':
                $data['name'] = 'milestone_id';
                $data['value'] = $fieldValue;
                break;
            case 'assignees':
                $data['name'] = 'assignee_ids';
                $data['value'] = $fieldValue;
                break;
            case 'labels':
                $data['value'] = implode(', ', $fieldValue);
                break;
            default:
                $data['name'] = $fieldName;
                $data['value'] = $fieldValue;
        }

        return $data;
    }

    /**
     * Throw Error
     * Explicitly throw the Gitlab exception. 
     * 
     * @param string $format Error format to display. 
     * @param string $params Extra parameters.
     * 
     * @return void
     * 
     * @throws GitLabException
     */
    private function _throw_error(string $format, $params = null)
    {
        $args = func_get_args();

        throw new GitLabException(
            count($args) > 0
                ? str::formatv(array_shift($args), $args)
                : $format
        );        
    }
}