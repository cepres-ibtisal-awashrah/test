<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'plugins/defects/exceptions/TrelloExceptions.php';

/**
 * Trello API
 *
 * Wrapper class for the Trello REST API with functions for
 * retrieving assignee, tasks etc.
 */
class Trello_API
{
    private $_address;
    private $_key;
    private $_token;
    private $_curl;
    
    /**
     * Construct
     *
     * Initializes a new Trello API object. Expects the web address
     * of the Trello installation including http or https prefix.
     * 
     * @param string $address Web address of trello installation.
     * @param string $key     Access key to authenticate.
     * @param string $token   Access token to authenticate
     * 
     * @return void
     */
    public function __construct($address, $key, $token)
    {
        $this->_address = str::slash($address);
        $this->_key = $key;
        $this->_token = $token;
    }
    
    /**
     * Throw Error
     * 
     * Explicitly throw the Trello exception. 
     * 
     * @param string      $format Error format to display. 
     * @param string|null $params Extra parameters.
     * 
     * @return void
     * 
     * @throws TrelloException
     */
    private function _throw_error($format, $params = null)
    {
        $args = func_get_args();

        throw new Trello_Exception(
            count($args) > 0
                ? str::formatv(array_shift($args), $args)
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
    private function _sendCommand($method, $command, $data = [])
    {
        return $this->_sendRequest(
            $method, 
            $this->_address 
                . '1/' 
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
     * @throws TrelloException
     */
    private function _sendRequest($method, $url, $data)
    {
        if (!$this->_curl) {
            $this->_curl = http::open();
        }
        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debug('Receive Trello HTTP REST request');
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
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]
        );
        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debug('Got the following response');
            logger::debugr('response', $response);
        }
        if ($response->code !== 200) {
            $message_json = json_decode($response->content);
            // Some 400 errors will be returned in HTML 
            if (!isset($message_json->{'message'})) {	
                $message = sprintf(
                    ' API returned error code %d, but no JSON data. Please verify '
                    . ' the ID you are hovering over, your configuration settings '
                    . ' for the "Push" dialog, and the data being pushed.',
                    $response->code
                );
                $this->_throw_error($message);
            } else {
                $this->_throw_error(
                    ' HTTP code ' 
                    . $response->code 
                    . ' : ' 
                    . $message_json->{'message'}
                );
            }
        }
        
        return json::decode($response->content);
    }

    /**
     * Get Card Details
     * 
     * Gets an existing card from the Trello board and returns the 
     * object with various properties such as the name, project, etc.
     * 
     * @param string $cardId Id of an card.
     * 
     * @return object
     */    
    public function getCardDetails(string $cardId): object
    {
        return $this->_sendCommand(
            'GET',
            'cards/'
                . $cardId 
                . '?customFieldItems=true&members=true&board=true&list=true&checklists=all'
                . $this->_getUrlKeyToken(false)
        );
    }

    /**
     * Get Assignees
     *
     * Returns a list of assignees for the given account for the Trello
     * instance. Assignees are returned as array of objects, each
     * with its id and display name. https://api.trello.com/
     * 
     * @param string $boardId Id of a board.
     *
     * @return array
     */
    public function getAssignees(string $boardId): array
    {
        $result = [];
        $response = $this->_sendCommand(
            'GET',
            'boards/'
                . $boardId 
                . '/members'
                . $this->_getUrlKeyToken(true)
        );
        foreach ($response ?? [] as $assignee) {
            $result[] = (object) [
                'id' => $assignee->id,
                'name' => $assignee->fullName
            ];
        }

        return $result;
    }

    /**
     * Get Labels
     *
     * Returns a list of all labels associated with board 
     * with its id and name. https://api.trello.com/
     * 
     * @param string $boardId Id of a board.
     *
     * @return array
     */
    public function getLabels(string $boardId): array
    {
        return $this->_sendCommand(
            'GET',
            'boards/'
                . $boardId 
                . '/labels'
                . $this->_getUrlKeyToken(true)
        );
    }

    /**
     * Get Boards
     *
     * Returns list of all boards associated with logged member, 
     * with its id and board name. https://api.trello.com/
     * 
     * @return array
     */
    public function getBoards(): array
    {
        return $this->_sendCommand(
            'GET',
            'members/me/boards'
                . $this->_getUrlKeyToken(true)
        );
    }

    /**
     * Get Lists
     *
     * Returns all lists of a particular board.
     * 
     * @param string $boardId Id of the board.
     * 
     * @return array
     */
    public function getLists(string $boardId): array
    {
        return $this->_sendCommand(
            'GET',
            'boards/'.
                $boardId
                . '/lists?fields=name,id' 
                . $this->_getUrlKeyToken(false)
        );
    }

    /**
     * Get Check Lists
     *
     * Gets all checklists of a particular board.
     * 
     * @param string $boardId id of the board.
     * 
     * @return array
     */
    public function getCheckLists(string $boardId): array
    {
        return $this->_sendCommand(
            'GET',
            'boards/'.
                $boardId
                . '/checklists' 
                . $this->_getUrlKeyToken(true)
        );
    }
    
    /**
     * Store Custom Values To Card
     *
     * Store the defined custom field values during new card creation.
     * Card gets created and card id is passed as parameter to associate 
     * custom fields to that particular card.
     * 
     * @param array  $pushData     Push form fields data.
     * @param array  $pluginConfig Data defined in configuration box.
     * @param string $cardId       Newly created card id.
     * 
     * @return void
     */
    public function _storeCustomValuesToCard(array $pushData, array $pluginConfig, string $cardId)
    {
        $data = [];
        $checkIfCustomFieldExists = $this->_getAllCustomFieldsByBoard($pushData['board']);
        foreach ($checkIfCustomFieldExists as $checkIfExists => $val) {
            foreach ($pushData as $postField => $value) {
                $configGroupName = "field.settings.$postField";
                $configGroup = arr::get($pluginConfig, $configGroupName);
                if ($val->id === $configGroup['idCustomField'] && isset($value)) {
                    if ($configGroup['api_type'] === 'dropdown') {
                        $data = [
                            'idValue' => $value
                        ];
                    } else {
                        $data = [
                            'value' => [
                                $configGroup['api_type'] => $value
                            ]
                        ];
                    }
                    $this->_sendCommand(
                        'PUT',
                        'cards/'
                            . $cardId
                            . '/customField/' 
                            . $configGroup['idCustomField']
                            . '/item'
                            . $this->_getUrlKeyToken(true),
                        json::encode($data)
                    );
                }
            }
        }
    }

    /**
     * Copy Checklist To Card
     *
     * Creates a copy the selected checklist data to new card.
     * Newly created card will have all the checkitems of the selected checklist.
     * 
     * @param string $checkListId Checklist id of a card.
     * @param string $cardId      Id of the card.
     * 
     * @return void
     */
    public function _copyChecklistToCard(string $checkListId, string $cardId)
    {
        $data = json::encode(
            ['idChecklistSource' => $checkListId]
        );
        $response = $this->_sendCommand(
            'POST',
            'cards/'
                . $cardId
                . '/checklists' 
                . $this->_getUrlKeyToken(true),
            $data
        );
    }

    /**
     * Get Customfield List
     * 
     * Returns dropdown values of all custom fields drop down possible values. 
     * 
     * @param string $customFieldId Name of the custom field.
     * 
     * @return array
     */
    public function getCustomFieldList(string $customFieldId): array
    {
        $result = [];
        $response = $this->_sendCommand(
            'GET',
            'customfields/'
                . $customFieldId
                . '/options'
                . $this->_getUrlKeyToken(true)
        );
        foreach ($response ?? [] as $options) {
            $result[] = (object) [
                'id' => $options->_id,
                'name' => $options->value->text
            ];
        }

        return $result;
    }

    /**
     * Get All Custom Fields By Board
     * 
     * Returns dropdown values of all custom fields drop down possible values. 
     * 
     * @param string $boardId Name of the custom field.
     * 
     * @return array
     */
    private function _getAllCustomFieldsByBoard(string $boardId): array
    {
        $result = [];
        $response = $this->_sendCommand(
            'GET',
            'boards/'
                . $boardId
                . '/customFields'
                . $this->_getUrlKeyToken(true)
        );
        foreach ($response ?? [] as $options) {
            $result[] = (object) [
                'id' => $options->id,
                'name' => $options->type
            ];
        }

        return $result;
    }

    /**
     * Get Customfield List
     * 
     * Returns dropdown values of all custom fields drop down possible values. 
     * 
     * @param string $customFieldId  Name of the custom field.
     * @param string $selectedOption Selected value from the push form.
     * 
     * @return array
     */
    public function getCustomFieldDropDownValue(string $customFieldId, string $selectedOption): string
    {
        return $this->_sendCommand(
            'GET',
            'customFields/'
                . $customFieldId
                . '/options/'
                . $selectedOption
                . $this->_getUrlKeyToken(true)
        )->value->text;
    }

    /**
     * Get Url Key Token
     * 
     * Returns the concatenated key and token for trello authentication.
     * A boolean value will define weather it should be '?key' or '&key' 
     * 
     * @param bool $param boolean value true or false is passed.
     * 
     * @return string
     */
    private function _getUrlKeyToken(bool $param): string
    {
        $key = $param ? '?key=' : '&key=';
        return $key 
            . $this->_key 
            . '&token='
            . $this->_token;
    }

    /**
     * Add Card
     *
     * Adds a new card to Trello with the given
     * parameters (title, project etc.) and returns its ID.
     *
     * @param array $pushData      The data passed from the push dialog.
     * @param array $pluginConfig  The details entered in Defect Plugin box.
     * @param array $fieldDefaults FieldDefaults array defined in Trello Class.
     * @param array $paths         File attachments.
     * 
     * @return string
     */	
    public function addCard(array $pushData, array $pluginConfig, array $fieldDefaults, array $paths): string
    {
        $card = [];
        foreach ($pushData as $postField => $value) {
            if ($value === null) {
                continue;
            }
            $api_field = null;
            $configGroupName = "field.settings.$postField";
            $configGroup = arr::get($pluginConfig, $configGroupName);
            $api_field = empty($configGroup['api_field'])
                ? $fieldDefaults[$postField]['api_field']
                : $configGroup['api_field'];
            if (empty($configGroup)) {
                $card[$api_field] = $value;
            }
        }
        $response = $this->_sendCommand(
            'POST',
            'cards?idList=' 
                . $card['idList'] 
                . $this->_getUrlKeyToken(false),
            json::encode($card)
        );
        $newCardId = $response->id;
        if (!empty($pushData['checklists'])) {
            $this->_copyChecklistToCard($pushData['checklists'], $newCardId); 
        }
        $this->_addAttachment($paths, $newCardId);
        $this->_storeCustomValuesToCard($pushData, $pluginConfig, $newCardId);

        return $response->id;
    }

    /**
     * Add Attachment
     * 
     * Store attached file and return token and attachment id.
     * 
     * @param array  $paths  User uploaded file paths. 
     * @param string $cardId Newly created card id. 
     * 
     * @return void
     * 
     * @throws TrelloException
     */
    private function _addAttachment(array $paths, string $cardId)
    {
        if (!$this->_curl) {
            $this->_curl = http::open();
        }
        foreach ($paths ?? [] as $path) {
            $cfile = curl_file_create($path);
            $cfile->postname = $this->_getAttachedFileName($cfile->name);
            $urlFileUpload = 'https://api.trello.com/1/cards/'
                . $cardId
                . '/attachments'
                . $this->_getUrlKeyToken(true);
            $response = http::request_ex(
                $this->_curl,
                'POST',
                $urlFileUpload,
                [
                    'user' => $this->_key,
                    'password' => $this->_token,
                    'data' => ['file' => $cfile],
                    'headers' => [
                        'Content-Type' => 'multipart/form-data'
                    ],
                    'skip_url_encode' => true
                ]
            );
            if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
                logger::debug('Got the following response');
                logger::debugr('response', $response);
            }
            if (!in_array($response->code, [200, 201])) {
                $this->_throw_error(
                    'Invalid HTTP code ({0}). Please check your user/' 
                        . 'password and the [repository] configuration.',
                    $response->code
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
