<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'plugins/defects/exceptions/VersionOneApi.php';

define('GI_API_VERSION', 'rest-1.v1/');

/**
 * VersionOne REST API
 *
 * Wrapper class for the VersionOne REST API with functions for
 * retrieving milestones, issues etc.
 */
class VersionOne_Api
{
    private $_address;
    private $_user;
    private $_password;
    private $_token;
    private $_curl;
    private $_config;

    /**
     * Construct
     *
     * Initializes a new VersionOne API object. Expects the web address
     * of the VersionOne installation including http or https prefix.
     * 
     * @param string       $address  Address url
     * @param string       $user     Username
     * @param string       $password Password
     * @param string       $token    Token
     * @param array|object $config   Configuration Settings
     * 
     * @return void
     */
    public function __construct(string $address, string $user,
        string $password, string $token, $config
    ) {
        $this->_address = str::slash($address);
        $this->_user = $user;
        $this->_password = $password;
        $this->_token = $token;
        $this->_config = $config;
    }

    /**
     * Get Issue
     *
     * Gets an existing case from the VersionOne installation and returns
     * it. The resulting issue object has various properties such as
     * the summary, description, repo etc.
     * 
     * @param int    $issueId   Id of an issue.
     * @param string $assetType Asset Type.
     * 
     * @return array|object
     */
    public function getIssue(int $issueId, string $assetType)
    {
        return $this->sendCommand(
            'GET',
            GI_API_VERSION . 'Data/' . $assetType . '/' . $issueId . '?Accept=application/json'
        );
    }

    /**
     * Get Option List
     * Builds and returns the option list for given array of object
     *
     * @param array|object $options Options array.
     * 
     * @return array
     */
    private function _getOptionList($options): array
    {
        $result = [];
        if (!isset($options)) {
            return [];
        }
        foreach ($options as $option) {
            $result[] = (object) [
                'id' => (string) $option->_oid,
                'name' => (string) $option->Name
            ];
        }

        return $result;
    }

    /**
     * Get Data
     * Builds and returns the array for given asset type
     *
     * @param string $assetType Asset Type
     * 
     * @return array|object
     */
    private function _getData(string $assetType)
    {
        return $this->sendCommand(
            'POST',
            'api/asset',
            [
                'from' => $assetType,
                'select' => [
                    'Name'
                ]
            ]
        );
    }

    /**
     * Get Options
     *
     * Returns a list of options for the Manuscript installation. The
     * options are returned as array of objects, each with its ID
     * and name.
     * 
     * @param string $assetType Asset Type
     * 
     * @return array
     */
    public function getOptions(string $assetType): array
    {
        $response = $this->_getData($assetType);

        return $this->_getOptionList($response->queryResult->results[0]);
    }

    /**
     * Get Teams
     *
     * Returns a list of teams for the VersionOne projects. Teams are
     * returned as array of objects, each with its ID and name.
     * 
     * @param string $assetType Asset Type
     * 
     * @return array
     */
    public function getTeams(string $assetType): array
    {
        $result = [];
        if ($assetType !== 'Request') {
            $response = $this->_getData('Team');
            $result = $this->_getOptionList($response->queryResult->results[0]);
        }

        return $result;
    }

    /**
     * Get Sprints
     *
     * Returns a list of sprints for the VersionOne projects. Sprints are
     * returned as array of objects, each with its ID and name.
     * 
     * @param string $assetType Asset Type
     * 
     * @return array
     */
    public function getSprints(string $assetType): array
    {
        $result = [];
        if (in_array($assetType, ['Story', 'Defect'])) {
            $response = $this->sendCommand(
                'GET',
                GI_API_VERSION . 'Data/Timebox?sel=Name&sel=Owner.Name&Accept=application/json'
            );
            foreach ($response->Assets ?? [] as $option) {
                if (isset($option->Attributes->{'Owner.Name'}->value)) {
                    $result[] = (object) [
                        'id' => (string) $option->id,
                        'name' => (string) $option->Attributes->Name->value
                    ];
                }
            }
        }

        return $result;
    }

    /**
     * Get Tags
     *
     * Returns a list of tags for the VersionOne projects. tags are
     * returned as array of objects, each with its ID and name.
     * 
     * @return array
     */
    public function getTags(): array
    {
        $result = [];
        $response = $this->sendCommand(
            'GET',
            'api/tags/all'
        );
        $projects = $response;
        if (!isset($projects)) {
            return [];
        }
        foreach ($projects as $project) {
            $result[] = (object) [
                'id' => (string) $project->tag,
                'name' => (string) $project->tag
            ];
        }

        return $result;
    }

    /**
     * Get Source
     *
     * Returns a list of teams for the VersionOne projects. Teams are
     * returned as array of objects, each with its ID and name.
     * 
     * @param string $assetType Asset Type
     * 
     * @return array
     */
    public function getSource(string $assetType): array
    {
        if ($assetType !== 'RegressionTest') {
            $response = $this->sendCommand(
                'GET',
                GI_API_VERSION . 'Data/StorySource?sel=Name&Accept=application/json'
            );

            return $this->_getList($response->Assets);
        }

        return [];
    }

    /**
     * Get Priority
     *
     * Returns a list of teams for the VersionOne projects. Teams are
     * returned as array of objects, each with its ID and name.
     * 
     * @param string $asset Asset Type
     * 
     * @return array
     */
    public function getPriority(string $asset): array
    {
        $assetPriority =  [
            'Story' => 'WorkitemPriority',
            'Defect' => 'WorkitemPriority',
            'Issue' => 'IssuePriority',
            'Request' => 'RequestPriority'
        ];
        if ($asset !== 'RegressionTest') {
            $response = $this->sendCommand(
                'GET',
                GI_API_VERSION . 'Data/' . $assetPriority[$asset]
                . '?sel=Name&Accept=application/json'
            );

            return $this->_getList($response->Assets);
        }

        return [];
    }

    /**
     * Get Priority
     *
     * Returns a list of teams for the VersionOne projects. Teams are
     * returned as array of objects, each with its ID and name.
     * 
     * @param string $asset Asset Type
     * 
     * @return array
     */
    public function getType(string $asset): array
    {
        $assetTypes =  [
            'Story' => 'StoryCategory',
            'Defect' => 'DefectType',
            'Issue' => 'IssueCategory',
            'RegressionTest' => 'TestCategory',
            'Request' => 'RequestCategory'
        ];
        if ($asset) {
            $response = $this->sendCommand(
                'GET',
                GI_API_VERSION . 'Data/' . $assetTypes[$asset]
                . '?sel=Name&Accept=application/json'
            );

            return $this->_getList($response->Assets);
        }

        return [];
    }

    /**
     * Get Status
     *
     * Returns a list of teams for the VersionOne projects. Teams are
     * returned as array of objects, each with its ID and name.
     * 
     * @param string $asset Asset Type
     * 
     * @return array
     */
    public function getStatus(string $asset):array
    {
        $assetStatus =  [
            'Story' => 'StoryStatus',
            'Defect' => 'StoryStatus',
            'RegressionTest' => 'RegressionTestStatus',
            'Request' => 'RequestStatus'
        ];
        if ($asset !== 'Issue') {
            $response = $this->sendCommand(
                'GET',
                GI_API_VERSION . 'Data/' . $assetStatus[$asset]
                . '?sel=Name&Accept=application/json'
            );

            return $this->_getList($response->Assets);
        }

        return [];
    }

    /**
     * Get List
     * Builds and returns the option list for given array of object
     *
     * @param array|object $options Options array.
     * 
     * @return array
     */
    private function _getList($options): array
    {
        $result = [];
        if (!isset($options)) {
            return [];
        }
        foreach ($options as $option) {
            $result[] = (object) [
                'id' => (string) $option->id,
                'name' => (string) $option->Attributes->Name->value
            ];
        }

        return $result;
    }

    /**
     * Get Customfield Values
     *
     * @param string $assetType Asset Type
     * 
     * @return array
     */
    public function getCustomFields(string $assetType): array
    {
        $response = $this->sendCommand(
            'GET',
            GI_API_VERSION . 'Data/' . $assetType . '?sel=Name&Accept=application/json'
        );

        return $this->_getList($response->Assets);
    }

    /**
     * Get Customfield Values
     *
     * @param int    $issueId   Issue Id
     * @param string $assetType Asset Type
     * @param string $fieldName Field Name
     * 
     * @return array|object
     */
    public function getCustomFieldValue(int $issueId, string $assetType, string $fieldName)
    {
        return $this->sendCommand(
            'GET',
            GI_API_VERSION . 'Data/' . $assetType . '/' . $issueId
            . '?sel=' . $fieldName . '&Accept=application/json'
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
    public function sendCommand(string $method, string $command, $data = null) 
    {
        return $this->_send_request(
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
     * @throws VersionOneException
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
            logger::debug('Issuing VersionOne HTTP request');
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
            } else {
                $errorMessage = 'The request to VersionOne failed
                with an invalid HTTP code ({0}).';
            }
            $this->_throwError($errorMessage, $response->code);
        }

        return json::decode($response->content);
    }

    /**
     * Add Issue
     *
     * Adds a new Issue to the VersionOne installation with the given
     * parameters and returns its ID.
     *
     * @param array|object $options Default configuration.
     * @param array        $paths   Attachments.
     *
     * @return string
     */
    public function addIssue($options,  array $paths): string
    {
        $data = [];
        foreach ($options as $fieldName => $fieldValue) {
            if (empty($fieldValue)) {
                continue;
            }
            if (isset($fieldName)) {
                switch($fieldName) {
                    case 'asset' :
                        $attribute = 'AssetType';
                        $attributeValue = $attributeAsset = $fieldValue;
                        break;
                    case 'title' :
                        $attribute = 'Name';
                        $attributeValue = $fieldValue;
                        break;
                    case 'project' :
                        $attribute = 'Scope';
                        $attributeValue = $fieldValue;
                        break;
                    case 'type' :
                        $attribute = $attributeAsset === 'Defect' ? 'Type' : 'Category';
                        $attributeValue = $fieldValue;
                        break;
                    case 'status' :
                        $attribute = 'Status';
                        $attributeValue = $fieldValue;
                        break;
                    case 'priority' :
                        $attribute = 'Priority';
                        $attributeValue = $fieldValue;
                        break;
                    case 'sprint' :
                        $attribute = 'Timebox';
                        $attributeValue = $fieldValue;
                        break;
                    case 'team' :
                        $attribute = 'Team';
                        $attributeValue = $fieldValue;
                        break;
                    case 'tags' :
                        $attribute = 'TaggedWith';
                        $attributeValue = $fieldValue;
                        break;
                    case 'owner' :
                        $attribute = in_array($attributeAsset, ['Story','Defect','RegressionTest'])
                            ? 'Owners'
                            : 'Owner';
                        $attributeValue = $fieldValue;
                        break;
                    case 'source' :
                        $attribute = 'Source';
                        $attributeValue = $fieldValue;
                        break;
                    case 'reference' :
                        $attribute = 'Reference';
                        $attributeValue = $fieldValue;
                        break;
                    case 'description' :
                        $attribute = 'Description';
                        $attributeValue = $fieldValue;
                        break;
                }
                $data[$attribute] = $attributeValue;
                if (str::starts_with($fieldName, 'custom_')) {
                    $category = arr::get(
                        $this->_config,
                        "field.settings.$fieldName"
                    );
                    $data[$category['field_name']] = $fieldValue;
                }
            }
        }
        $response = $this->sendCommand(
            'POST',
            'api/asset',
            $data
        );
        if (isset($response->commandFailures->commands[0]->error->message)) {
            $this->_throwError(
                $response->commandFailures->commands[0]->error->message
            );
        }
        $assetType = (string) $response->assetsCreated->oidTokens[0];
        foreach ($paths ?? [] as $path) {
            $this->_createAttachment($path, $assetType, (string) $data['Name']);
        }

        return $assetType;
    }

    /**
     * Create attachment for the asset.
     *
     * @param string $path           User uploaded file path.
     * @param string $assetType      Asset Type.
     * @param string $attachmentName Attachment Name.
     *
     * @return void
     */
    private function _createAttachment(string $path, string $assetType, string $attachmentName)
    {
        $fileName = basename($path);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        if (!$this->_curl) {
            $this->_curl = http::open();
        }
        $response = http::request_ex(
            $this->_curl,
            'POST',
            $this->_address . GI_API_VERSION . 'Data/Attachment?Accept=application/json',
            [
                'headers' => [
                    'Authorization' => "Bearer $this->_token",
                    'Content-Type' => 'application/xml'
                ],
                'data' => '<Asset>
                    <Attribute name="Content" act="set" />
                    <Relation name="Asset" act="set">
                        <Asset idref="' . $assetType .'" />
                    </Relation>
                    <Attribute name="Name" act="set">' . $attachmentName . '</Attribute>
                    <Attribute name="Filename" act="set">' . $fileName . '</Attribute>
                    <Attribute name="ContentType" act="set">text/' . $extension . '</Attribute>
                </Asset>',
                'skip_url_encode' => true
            ]
        );
        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debugr('Got the following response');
            logger::debugr('response', $response);
        }
        if ($response->code !== 200) {
            $this->_throw_error(
                'Invalid HTTP code ({0})', $response->code
            );
        }
        $content = json_decode($response->content);
        $attachment = explode(':', $content->id);
        $this->_addAttachment(
            (int) $attachment[1],
            $path,
            $extension
        );
    }

    /**
     * Add attachment to the asset.
     *
     * @param string $attachmentId Attachment ID.
     * @param string $path         User uploaded file path.
     * @param string $extension    File extension
     *
     * @return void
     */
    private function _addAttachment(int $attachmentId, string $path, string $extension)
    {
        if (!$this->_curl) {
            $this->_curl = http::open();
        }
        $response = http::request_ex(
            $this->_curl,
            'POST',
            $this->_address . 'attachment.img/' . $attachmentId,
            [
                'headers' => [
                    'Authorization' => "Bearer $this->_token",
                    'Content-Type' => "image/$extension"
                ],
                'data' => file_get_contents($path),
                'skip_url_encode' => true
            ]
        );
        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debugr('Got the following response');
            logger::debugr('response', $response);
        }
        if ($response->code !== 200) {
            $this->_throw_error(
                'Invalid HTTP code ({0})', $response->code
            );
        }
    }

    /**
     * Throw Error
     * Explicitly throw the VersionOne exception. 
     * 
     * @param string $format Error format to display. 
     * @param string $params Extra parameters.
     * 
     * @return void
     * 
     * @throws VersionOneException
     */
    private function _throwError(string $format, $params = null)
    {
        $args = func_get_args();

        throw new VersionOneException(
            count($args) > 0
                ? str::formatv(array_shift($args), $args)
                : $format
        );        
    }
}
