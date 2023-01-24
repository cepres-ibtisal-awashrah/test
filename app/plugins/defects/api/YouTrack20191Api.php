<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'plugins/defects/exceptions/YouTrackException.php';
require_once APPPATH . 'enums/' . HttpMethodCodesEnum::class . EXT;

/**
 * YouTrack API
 *
 * Wrapper class for the YouTrack API with login/logout and functions
 * for retrieving projects etc. from a YouTrack installation.
 */
class YouTrack20191_Api
{
    private $_address;
    private $_api_token;
    private $_user;
    private $_login;
    private $_curl;
    const YOUTRACK_PREFIX = 'youtrack/api/';
    const YOUTRACK_LIMIT = -1;

    /**
     * Construct
     *
     * Initializes a new YouTrac API object. Expects the web address
     * of the YouTrac installation including http or https prefix.
     *
     * @param string $address   Web address of YouTrac installation.
     * @param string $api_token Access key to authenticate.
     * @param string $user      User credentials.
     * @param string $login     Login connection
     *
     * @return void
     */
    public function __construct($address, $api_token, $user, $login)
    {
        $this->_address = str::slash($address) . (strpos($address, '/youtrack/') === false
                ? static::YOUTRACK_PREFIX
                : 'api/');
        $this->_user = $user;
        $this->_login = $login;
        $this->_api_token = $api_token;
    }

    /**
     * Throw Error
     *
     * Explicitly throw the YouTrac exception.
     *
     * @param string      $format Error format to display.
     * @param string|null $params Extra parameters.
     *
     * @return void
     *
     * @throws YouTrackException
     */
    private function _throw_error($format, $params = null)
    {
        $args = func_get_args();
        $format = array_shift($args);
        throw new YouTrackException(
            count($args) > 0
                ? str::formatv($format, $args)
                : $format
        );
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
    private function _sendCommand($method, $command, $data = null)
    {
        return $this->_sendRequest(
            $method,
            $this->_address . $command,
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
     * @throws YouTrackException
     */
    private function _sendRequest($method, $url, $data = null)
    {
        $options['data'] = json_encode($data);
        $options['headers'] = [
            'Authorization' => 'Bearer ' . $this->_api_token,
            'Content-Type' => 'application/json'];
        if (!$this->_curl) {
            $this->_curl = http::open();
        }
        $response = http::request_ex(
            $this->_curl,
            $method,
            $url,
            $options
        );
        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debugr('data', $data);
            logger::debugr('options', $options);
            logger::debugr('response', $response);
        }
        if ($response->code === 501) {
            $this->_throw_error(
                'The YouTrack REST API is not enabled ({0})',
                $response->code
            );
        }
        $obj = json::decode($response->content);
        if ($response->code !== 200) {
            $this->_throw_error(
                'HTTP code {0}: {1}',
                $response->code,
                $obj->error_description
            );
        }

        return $obj;
    }

    /**
     * Get Bundles
     *
     * Returns an array of bundles for the YouTrack installation.
     * Each bundle is an array of objects, each with its ID and name.
     *
     * @param string $bundle By default enum is passed.
     *
     * @return object
     */
    public function getBundles($bundle = 'enum')
    {
        return $this->_sendCommand(
            'GET',
            'admin/customFieldSettings/bundles/'
            . $bundle
            .'?fields=name,id,values(name,id)'
        );
    }

    /**
     * Get Projects
     *
     * Returns a list of projects for the YouTrack installation.
     * Projects are returned as array of objects, each with its ID
     * and name.
     *
     * @return array
     */
    public function getProjects()
    {
        $projects = $this->_sendCommand(
            'GET',
            'admin/projects?fields=id,name,shortName&$top=' . static::YOUTRACK_LIMIT
        );
        if (!$projects) {
            return [];
        }
        $result = [];
        foreach ($projects as $project) {
            $newProjectObj = obj::create();
            $newProjectObj->name = $project->name;
            $newProjectObj->id = $project->id;
            $result[] = $newProjectObj;
            $newProjectObj->subsystems = [];
            if (isset($project->subsystems->sub)) {
                foreach ($project->subsystems->sub as $sub) {
                    $newSubSystemObj = obj::create();
                    $newSubSystemObj->name = (string) $sub['value'];
                    $newSubSystemObj->id = $newSubSystemObj->name;
                    $newProjectObj->subsystems[] = $newSubSystemObj;
                }
            }
            $result[] = $newProjectObj;
        }

        return $result;
    }

    /**
     * Get Subsystems
     *
     * Returns a list of subsystems for the given project for the
     * YouTrack installation. Subsystems are returned as array of
     * objects, each with its ID and name.
     *
     * @param string $project_id Id of selected project
     *
     * @return object
     */
    public function get_subsystems($project_id)
    {
        return arr::get(
            obj::get_lookup(
                $this->getProjects()
            ),
            $project_id
        )->subsystems;
    }

    /**
     * Get Issue
     *
     * Gets an existing case from the YouTrack installation and
     * returns it. The resulting issue object has various properties
     * such as the summary, description, project etc.
     *
     * @param string $defectId Id of an Issue or ticket
     *
     * @return object
     */
    public function getIssueDetails(string $defectId): object
    {
        return $this->_sendCommand(
            'GET',
            'issues/'
            . $defectId .
            '?fields=idReadable,project(id,name),summary,description,customFields(name,value(name,isResolved,text))'
        );
    }

    /**
     * Get Customfields
     *
     * Get all customfields defined or associated with that project id.
     *
     * @param string $projectId Id of a project.
     *
     * @return array
     */
    public function get_customfields(string $projectId): array
    {
        $response = $this->_sendCommand(
            'GET',
            'admin/projects/'
            . $projectId
            . '/customFields?fields=id,field(id,name,value(name,id))'
        );
        $result = [];
        foreach ($response ?? [] as $option) {
            $result[] = (object) [
                'id' => $option->id,
                'name' => $option->field->name,
                'type' => $option->{'$type'},
            ];
        }

        return $result;
    }

    /**
     * Get Customfield Values
     *
     * Get all customfield values defined or associated with that project id.
     *
     * @param string $projectId Id of a project
     * @param string $fieldId   Defined field name.
     *
     * @return array
     */
    public function getCustomFieldValues($projectId = '0-0', $fieldId)
    {
        return  $this->_sendCommand(
            'GET',
            'admin/projects/'
            . $projectId
            . '/customFields/'
            . $fieldId
            .'/bundle/values?fields=id,name'
        );
    }

    /**
     * Add Issue
     *
     * Adds a new issue to the YouTrack installation with the given
     * parameters (title, project etc.) and returns its ID.
     *
     * @param array $options Push form fields data.
     * @param array $paths   User uploaded file paths.
     *
     * @return string
     */
    public function add_issue($options, array $paths)
    {
        $fields = [];
        $customFields = [];
        foreach ($options as $fieldName => $fieldValue) {
            if (empty($fieldValue)) {
                continue;
            }
            if ($fieldName === 'customFields') {
                $customFields = $fieldValue;
            } elseif (isset($fieldName)) {
                $fields[$fieldName] = $fieldValue;
            } else {
                // NOP
            }
        }
        if (!empty($customFields)) {
            $fields['customFields'] = $customFields;
        }
        $response = $this->_sendCommand('POST', 'issues?fields=idReadable', $fields);
        if (!isset($response->idReadable)) {
            $this->_throw_error('No issue ID received');
        }
        foreach ($paths ?? [] as $path) {
            $contents[] = $this->_addAttachmentIssue($response->idReadable, $path);
        }

        return (string) $response->idReadable;
    }

    /**
     * Add Attachment Issue
     *
     * Store file attachment for a newly created issue.
     *
     * @param string $issueId Issue ID.
     * @param string $path    User uploaded file path.
     *
     * @return object
     */
    private function _addAttachmentIssue(string $issueId, string $path)
    {
        $url = $this->_address
            . 'issues/'
            . $issueId
            . '/attachments?fields=id,name'
            . '&authorLogin='
            . $this->_login;

        if (!$this->_curl) {
            $this->_curl = http::open();
        }
        $cfile = new CURLFILE($path);
        $cfile->postname = $this->_getAttachedFileName(
            basename($cfile->name)
        );
        $cfile->mime = mime_content_type($path);

        return http::request_ex(
            $this->_curl,
            (string)HttpMethodCodesEnum::$POST,
            $url,
            [
                'headers' => [
                    'Content-Type' => 'multipart/form-data'
                ],
                'user' => $this->_user,
                'password' => $this->_api_token,
                'data' => ['file' => $cfile],
                'skip_url_encode' => true
            ]
        );
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
}
