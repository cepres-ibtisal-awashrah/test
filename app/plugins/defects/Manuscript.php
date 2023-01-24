<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Manuscript Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for Fogcreek Manuscript. Please
 * see http://docs.gurock.com/testrail-integration/defects-plugins
 * for more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */

define('GI_DEFECTS_MANUSCRIPT_API_VERSION', 6);

class Manuscript_defect_plugin extends Defect_plugin
{
	private $_api;
	private $_address;
	private $_user;
	private $_password;
	private $_defaultFields = [
		'title' => 'on',
		'category' => 'on',
		'project' => 'on',
		'status' => 'on',
		'area' => 'on',
		'assignee' => 'on',
		'comment' => 'on',
		'attachments' => 'on',
	];
	private $_fieldDefaults = [
		'title' =>  [
			'type' => 'string',
			'label' => 'Title',
			'required' => true,
			'size' => 'full'
		],
		'category' => [
			'type' => 'dropdown',
			'label' => 'Category',
			'required' => true,
			'remember' => true,
			'size' => 'compact'
		],
		'status' => [
			'type' => 'dropdown',
			'label' => 'Status',
			'required' => true,
			'remember' => true,
			'size' => 'compact'
		],
		'project' => [
			'type' => 'dropdown',
			'label' => 'Project',
			'required' => true,
			'remember' => true,
			'cascading' => true,
			'size' => 'compact'
		],
		'area' => [
			'type' => 'dropdown',
			'label' => 'Area',
			'remember' => true,
			'remember' => true,
			'depends_on' => 'project',
			'size' => 'compact'
		],
		'assignee' =>  [
			'type' => 'dropdown',
			'label' => "Assigned To",
			'required' => false,
			'remember' => true,
			'size' => 'compact'
		],
		'comment' => [
			'type' => 'text',
			'label' => 'Comment',
			'required' => false,
			'rows' => 10,
			'dropzone_enabled' => true
		],
		'attachments' => [
		    'type' => 'dropbox',
		    'label'=>'attachments',
		    'required' => false,
		    'size' => 'none'
		]
	];
	private static $_meta = [
		'author' => 'Gurock Software',
		'version' => '1.0',
		'description' => 'Manuscript defect plugin for TestRail',
		'can_push' => true,
		'can_lookup' => true,
		'default_config' => 
			'; Please configure your Manuscript connection below
[connection]
address=https://<your-server>.manuscript.com/
user=testrail
password=secret

[push.fields]
title=on
category=on
project=on
area=on
assignee=on
comment=on
attachments=on

[hover.fields]
category=on
project=on
area=on
assignee=on
status=on
comment=on'
];

	public function get_meta()
	{
		return self::$_meta;
	}
		
	// *********************************************************
	// CONSTRUCT / DESTRUCT
	// *********************************************************

	public function __construct()
	{
	}
	
	public function __destruct()
	{
		if ($this->_api)
		{
			try
			{
				$api = $this->_api;
				$this->_api = null;
				// Intentionally left out because Manuscript' API is
				// quite slow and this saves one request.
				// $api->logout(); 
			}
			catch (Exception $e)
			{
				// Possible exceptions are ignored here.
			}
		}
	}
	
	// *********************************************************
	// CONFIGURATION
	// *********************************************************

	public function validate_config($config)
	{
		$ini = ini::parse($config);
		
		if (!isset($ini['connection']))
		{
			throw new ValidationException('Missing [connection] group');
		}
		
		$keys = array('address', 'user', 'password');
		
		// Check required values for existance
		foreach ($keys as $key)
		{
			if (!isset($ini['connection'][$key]) ||
				!$ini['connection'][$key])
			{
				throw new ValidationException(
					"Missing configuration for key '$key'"
				);
			}
		}
		
		$address = $ini['connection']['address'];
		
		// Check whether the address is a valid url (syntax only)
		if (!check::url($address))
		{
			throw new ValidationException('Address is not a valid url');
		}
        foreach (['push.fields', 'hover.fields'] as $fieldSection) {
            foreach ($ini[$fieldSection] ?? [] as $field => $option) {
                if ($option === 'on') { 
                    $this->_validateField($ini, $field);
                }
            }
        }
	}
	
    /**
     * Validate Field
     * 
     * Validate default fields and if invalid 
     * field found then throw error.
     *
     * @param array  $ini   API configuration.
     * @param string $field Field name.
     *
     * @return void
     *
     * @throws ValidationException
     */
    private function _validateField(array $ini, string $field)
    {
        $valid_types = [
            'dropdown' => true,
            'multiselect' => true,
            'text' => true,
            'string' => true,
            'date' => true,
            'datetime' => true
        ];
        $category = arr::get($ini, "field.settings.$field");
        if (str::starts_with($field, 'customfield_')) {
            if (!$category) {
                throw new ValidationException(
                    str::format(
                        'Field "{0}" is enabled but configuration ' 
                        . 'section [field.settings.{0}] is missing',
                        $field
                    )
                );
            }
        }
        foreach (['label', 'type'] as $key) {
            if (isset($category) && !isset($category[$key])) {
                throw new ValidationException(
                    str::format(
                        'Missing configuration for key "{0}" in ' 
                            . 'section [field.settings.{1}]',
                        $key,
                        $field
                    )
                );
            }
        }
        $type = arr::get($category, 'type'); 
        if ($type && !isset($valid_types[str::to_lower($type)])) {
            throw new ValidationException(
                str::format(
                    'Invalid field type specified in section ' 
                        . '[field.settings.{0}]',
                    $field
                )
            );
        }
    }

	public function configure($config)
	{
		$ini = ini::parse($config);
		$this->_address = str::slash($ini['connection']['address']);
		$this->_user = $ini['connection']['user'];
		$this->_password = $ini['connection']['password'];
		$this->_config = $ini;
	}
	
	// *********************************************************
	// API / CONNECTION
	// *********************************************************

	private function _get_api()
	{
		if ($this->_api)
		{
			return $this->_api;
		}
		
		$this->_api = new Manuscript_api($this->_address);
		$this->_api->login($this->_user, $this->_password);		
		return $this->_api;
	}

    /**
     * Prepare Push
     *
     * Creates an array of objects of default and custom field
     * with default and user defined configuration.
     *
     * @param array $context default configuration.
     *
     * @return array
     */
    public function prepare_push($context): array
    {
        $fields = [];
        $fieldsConfig = isset($this->_config['push.fields'])
            ? ['title' => 'on'] + $this->_config['push.fields']
            : ['status' => 'off'] + $this->_defaultFields;
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on') {
                continue;
            }
            $field = $this->_fieldDefaults[$fieldName] ?? [];
            $category = arr::get($this->_config,"field.settings.$fieldName");
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

        return ['fields' => $fields];
    }

	private function _get_title_default($context)
	{
		$test = current($context['tests']);
		$title = 'Failed test: ' . $test->case->title;
		
		if ($context['test_count'] > 1)
		{
			$title .= ' (+others)';
		}
		
		return $title;
	}
	
	private function _get_comment_default($context)
	{
		return $context['test_change']->description;
	}
	
	private function _to_id_name_lookup($items)
	{
		$result = array();
		foreach ($items as $item)
		{
			$result[$item->id] = $item->name;
		}
		return $result;
	}

	public function prepare_field($context, $input, $field)
	{
		$data = array();
		
		// Process those fields that do not need a connection to the
		// Manuscript installation.
		if ($field == 'title' || $field == 'comment')
		{
			switch ($field)
			{
				case 'title':
					$data['default'] = $this->_get_title_default(
						$context);
					break;
					
				case 'comment':
					$data['default'] = $this->_get_comment_default(
						$context);
					break;
			}
			
			return $data;
		}
		
		// Take into account the preferences of the user, but only
		// for the initial form rendering (not for dynamic loads).
		if ($context['event'] == 'prepare')
		{
			$prefs = arr::get($context, 'preferences');
		}
		else
		{
			$prefs = null;
		}
		
		// And then try to connect/login (in case we haven't set up a
		// working connection previously in this request) and process
		// the remaining fields.
		$api = $this->_get_api();
		
		switch ($field)
		{
			case 'category':
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_categories()
				);
				
				// Select the stored preference or the first item in
				// the list otherwise.
				$default = arr::get($prefs, 'category');
				if ($default)
				{
					$data['default'] = $default;
				}
				else
				{
					if ($data['options'])
					{
						$data['default'] = key($data['options']);
					}
				}
				break;

			case 'project':
				$data['default'] = arr::get($prefs, 'project');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_projects()
				);
				break;
				
			case 'area':
				if (isset($input['project']))
				{
					$data['default'] = arr::get($prefs, 'area');
					$data['options'] = $this->_to_id_name_lookup(
						$api->get_areas($input['project'])
					);
				}
				break;

			case 'assignee':
				$data['default'] = arr::get($prefs, 'assignee');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_users()
				);
				break;
		}

		return $data;
	}
	
	public function validate_push($context, $input)
	{
	}

	/**
	* Push
	* Push an array of objects of default field
	* with default and user defined configuration.
	*
	* @param array|object $context Default configuration.
	* @param array|object $input   Default plugin configuration.
	* @param array        $paths   Attachments.
	*
	* @return int
	*/
	public function push($context, $input,  array $paths = [])
	{
		$api = $this->_get_api();

		return $api->add_case($input, $paths);
	}

    // *********************************************************
    // LOOKUP
    // *********************************************************
    /**
     * Lookup
     * 
     * Creates an array of objects of default and user
     * defined configuration to display on hover popup.
     *
     * @param int $defectId  Defect id of an issue.
     *
     * @return array
     */
    public function lookup($defectId)
    {
        $description = null;
        $api = $this->_get_api();
        $case = $api->get_case(
            $defectId,
            [
                'sTitle',
                'ixStatus',
                'sStatus',
                'sProject',
                'ixCategory',
                'sCategory',
                'ixArea',
                'sArea',
                'ixPersonAssignedTo',
                'sPersonAssignedTo',
                'fOpen',
                'sLatestTextSummary'
            ]
        );
        $attributes = [];
        $fullAttributes = [];
        $fieldsConfig = $this->_config['hover.fields'] ?? ['title' => 'off'] + $this->_defaultFields;
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on' || in_array($fieldName, ['title', 'attachments'])) {
                continue;
            }
            $field = arr::get($this->_config, "field.settings.$fieldName") 
                ?? $this->_fieldDefaults[$fieldName];
            if (isset($case)) {
                switch($fieldName) {
                    case 'project':
                        $fieldValue = $case['sProject'];
                        break;
                    case 'category':
                        $fieldValue = $case['sCategory'];
                        break;
                    case 'area':
                        $fieldValue = $case['sArea'];
                        break;
                    case 'assignee':
                        $fieldValue = $case['sPersonAssignedTo'];
                        break;
                    case 'status':
                        $fieldValue = $case['sStatus'];
                        break;
                }
            }
            if ($fieldName === 'comment' && $case['sLatestTextSummary']) {
                $description = str::format(
                    '<div class="monospace">{0}</div>',
                    nl2br(html::link_urls(h($case['sLatestTextSummary'])))
                );
            } elseif (in_array($field['type'], ['text', 'string']) 
                && (!isset($field['size']) || $field['size'] === 'full')
                && isset($fieldValue)
            ) {
                $fullAttributes[$field['label']] = str::format(
                    '<div class="monospace">{0}</div>',
                    strip_tags(html_entity_decode($fieldValue))
                );
            } else {
                $attributes[$field['label']] = h($fieldValue);
            }
        }
        if ($case['fOpen'] === 'false') {
            $statusId = GI_DEFECTS_STATUS_CLOSED;
        } else {
            $statuses = obj::get_lookup(
                $api->get_statuses($case['ixCategory'])
            );
            $status = arr::get($statuses, $case['ixStatus']);
            if (!$status) {
                throw new ManuscriptException(
                    'Invalid status with ID ' . $case['ixStatus']
                );
            }
            $statusId = $status->resolved ? GI_DEFECTS_STATUS_RESOLVED : GI_DEFECTS_STATUS_OPEN;
        }

        return [
            'id' => $defectId,
            'url' => str::format(
                '{0}default.asp?{1}',
                $this->_address,
                $defectId
            ),
            'title' => $case['sTitle'],
            'status_id' => $statusId,
            'status' => $case['sStatus'],
            'description' => $description,
            'attributes' => $attributes,
            'fullAttributes' => $fullAttributes
        ];
    }
}

/**
 * Manuscript API
 *
 * Wrapper class for the Manuscript API with login/logout and functions
 * for retrieving projects etc. from a Manuscript installation.
 */
class Manuscript_api
{
	private $_version;
	private $_token;
	private $_address;
	private $_curl;
	
	/**
	 * Construct
	 *
	 * Initializes a new Manuscript API object. Checks the min version
	 * the Manuscript installation supports and raises an exception if
	 * its greater than the version we support. Expects the web
	 * address of the Manuscript installation including http or https
	 * prefix.
	 */
	public function __construct($address)
	{
		$this->_address = str::slash($address);
		$this->_version = $this->_check_version();
	}
	
	private function _check_version()
	{
		$url = $this->_address . 'api.xml';
		$version = $this->_send_request('GET', $url);
		
		// Check for minimum version
		$min = (int)$version->minversion;
		if ($min > GI_DEFECTS_MANUSCRIPT_API_VERSION)
		{
			$this->_throw_error(
				'Unsupported Manuscript API version: {0}/{1}',
				$min,
				GI_DEFECTS_MANUSCRIPT_API_VERSION
			);
		}
		
		return $version;
	}
	
	private function _throw_error($format, $params = null)
	{
		$args = func_get_args();
		$format = array_shift($args);
		
		if (count($args) > 0)
		{
			$message = str::formatv($format, $args);
		}
		else 
		{
			$message = $format;
		}
		
		throw new ManuscriptException($message);
	}
		
	private function _parse_response($response)
	{
		$dom = xml::parse_string($response);
		
		// Manuscript API:
		// "If the first child node is <error>, something went wrong."
		if (isset($dom->error))
		{
			$this->_throw_error((string) $dom->error);
		}
		
		return $dom;
	}
	
	private function _send_command($command, $data = null)
	{
		$url = $this->_address;
		$url .= $this->_version->url . 'cmd=' . $command;
		
		if ($this->_token)
		{
			$url .= '&token=' . $this->_token;
		}
		
		return $this->_send_request('POST', $url, $data);
	}
	
	private function _send_request($method, $url, $data = null)
	{
		$options['data'] = $data;

		if (!$this->_curl)
		{
			// Initialize the cURL handle. We re-use this handle to
			// make use of Keep-Alive, if possible.
			$this->_curl = http::open();
		}

		$response = http::request_ex(
			$this->_curl,
			$method,
			$url,
			$options
		);
		
		// In case debug logging is enabled, we append the data
		// we've sent and the entire request/response to the log.
		if (logger::is_on(GI_LOG_LEVEL_DEBUG))
		{
			logger::debugr('$data', $data);
			logger::debugr('$response', $response);
		}
		
		if ($response->code != 200)
		{
			$this->_throw_error(
				'Invalid HTTP code ({0})', $response->code
			);
		}
		
		return $this->_parse_response($response->content);
	}
	
	/**
	 * Login
	 *
	 * Logs in to the Manuscript installation using the provided user/
	 * email address and password.
	 */
	public function login($user, $password)
	{
		$data['email'] = $user;
		$data['password'] = $password;
		$response = $this->_send_command('logon', $data);
		$this->_token = (string)$response->token;
	}
	
	/**
	 * Logout
	 *
	 * Logs the user out. You can use login() to log in again.
	 */
	public function logout()
	{
		$this->_send_command('logoff');
		$this->_token = null;
	}
	
	/**
	 * Get Projects
	 *
	 * Returns a list of projects for the Manuscript installation. The
	 * projects are returned as array of objects, each with its ID
	 * and name.
	 */
	public function get_projects()
	{
		$response = $this->_send_command('listProjects');
		
		if (!isset($response->projects))
		{
			return array();
		}
		
		$projects = $response->projects; // <projects>
		
		$result = array();
		foreach ($projects->project as $project)
		{
			if (isset($project->fInbox))
			{
				if ($project->fInbox == 'true')
				{
					continue; // Skip the 'Inbox' project
				}
			}
			
			$p = obj::create();
			$p->id = (int) $project->ixProject;
			$p->name = (string) $project->sProject;
			$result[] = $p;
		}
		
		return $result;
	}

	/**
	 * Get Areas
	 *
	 * Returns a list of areas for the given project for the Manuscript
	 * installation. Areas are returned as array of objects, each	 
	 * with its ID, name and project ID.
	 */
	public function get_areas($project_id)
	{
		$data['ixProject'] = $project_id;
		$response = $this->_send_command('listAreas', $data);

		if (!isset($response->areas))
		{
			return array();
		}
		
		$areas = $response->areas; // <areas>
		
		$result = array();
		foreach ($areas->area as $area)
		{
			$a = obj::create();
			$a->id = (int) $area->ixArea;
			$a->name = (string) $area->sArea;
			$a->project_id = (int) $area->ixProject;
			$result[] = $a;
		}
		
		return $result;
	}

	/**
	 * Get Users
	 *
	 * Returns a list of users for the Manuscript installation. Users are
	 * returned as array of objects, each with its ID and name.
	 */
	public function get_users()
	{
		$response = $this->_send_command('listPeople');

		if (!isset($response->people))
		{
			return array();
		}
		
		$users = $response->people; // <people>
		
		$result = array();
		foreach ($users->person as $user)
		{
			$u = obj::create();
			$u->id = (int) $user->ixPerson;
			$u->name = (string) $user->sFullName;
			$result[] = $u;
		}
		
		return $result;
	}
	
	/**
	 * Get Categories
	 *
	 * Returns a list of categories for the Manuscript installation.
	 * Categories are returned as array of objects, each with its ID,
	 * and name.
	 */
	public function get_categories()
	{
		$response = $this->_send_command('listCategories');

		if (!isset($response->categories))
		{
			return array();
		}
		
		$categories = $response->categories; // <categories>
		
		$result = array();
		foreach ($categories->category as $category)
		{
			if (isset($category->fDeleted))
			{
				if ($category->fDeleted == 'true')
				{
					continue; // Skip this deleted category
				}
			}
			
			$c = obj::create();
			$c->id = (int) $category->ixCategory;
			$c->name = (string) $category->sCategory;
			$result[] = $c;
		}

		return $result;
	}
	
	/**
	 * Get Statuses
	 *
	 * Returns a list of statuses for the given category for the
	 * Manuscript installation. Statuses are returned as array of
	 * objects, each with its ID, and name.
	 */
	public function get_statuses($category_id)
	{
		$data['ixCategory'] = $category_id;
		$response = $this->_send_command('listStatuses', $data);

		if (!isset($response->statuses))
		{
			return array();
		}
		
		$statuses = $response->statuses; // <statuses>
		
		$result = array();
		foreach ($statuses->status as $status)
		{
			if (isset($status->fDeleted))
			{
				if ($status->fDeleted == 'true')
				{
					continue; // Skip this deleted status
				}
			}
			
			$s = obj::create();
			$s->id = (int) $status->ixStatus;
			$s->name = (string) $status->sStatus;
			$s->resolved = $status->fResolved == 'true';
			$result[] = $s;
		}

		return $result;
	}
	
	/**
	 * Get Case
	 *
	 * Gets an existing case from the Manuscript installation with the
	 * given ID and requested columns (sTitle, ixStatus etc.). The
	 * columns must be named according to the Manuscript API format.
	 */	 
	public function get_case($case_id, $columns)
	{
		$data['q'] = $case_id;
		$data['cols'] = str::join($columns, ',');
		$response = $this->_send_command('search', $data);

		if (!$response->cases)
		{
			return array();
		}
		
		$cases = $response->cases; // <cases>
		
		if (!isset($cases->case))
		{
			$this->_throw_error('The requested case does not exist');
		}
		
		$case = $cases->case;		
		
		$result = array();		
		foreach ($columns as $column)
		{
			if (!isset($case->$column))
			{
				$this->_throw_error('Missing column "{0}"', $column);
			}
			
			$result[$column] = (string) $case->$column;
		}
		
		return $result;
	}

	/**
	* Add Case
	*
	* Adds a new case to the Manuscript installation with the given
	* parameters and returns its ID.
	*
	* @param array $options Default configuration.
	* @param array $paths   Attachments.
	*
	* @return string
	*/
	public function add_case($options,  array $paths): string
	{
		$i = 1;
		$data = [];
		foreach ($options as $fieldName => $fieldValue) {
			if (empty($fieldValue)) {
				continue;
			}
			if (isset($fieldName)) {
				switch($fieldName) {
					case 'title' :
						$attribute = 'sTitle';
						break;
					case 'category' :
						$attribute = 'ixCategory';
						break;
					case 'project' :
						$attribute = 'ixProject';
						break;
					case 'area' :
						$attribute = 'ixArea';
						break;
					case 'assignee' :
						$attribute = 'ixPersonAssignedTo';
						break;
					case 'comment' :
						$attribute = 'sEvent';
						break;
				}
				$data[$attribute] = $fieldValue;
			}
		}
		$response = $this->_send_command('new', $data);
		$case = $response->case;
		if (!isset($case['ixBug'])) {
			$this->_throw_error('No case ID received (ixBug)');
		}
		foreach ($paths ?? [] as $path) {
			$this->_add_attachment($path, (int) $case['ixBug'], $i);
			$i++;
		}

		return (string) $case['ixBug'];
	}

	/**
	 * Add attachment to the ticket.
	 *
	 * @param string $path   User uploaded file path.
	 * @param int    $caseId Case ID.
	 * @param int    $i      Increment number for each iteration.
	 *
	 * @return void
	 */
	private function _add_attachment(string $path, int $caseId, int $i)
	{
		if (!$this->_curl) {
			$this->_curl = http::open();
		}
		$cfile = curl_file_create($path);
		$cfile->postname = basename($cfile->name);
		$response = http::request_ex(
			$this->_curl,
			'POST',
			$this->_address . 'api/edit',
			[
				'headers' => [
					'Content-Type' => 'multipart/form-data'
				],
				'data' => [
					'File' . $i => $cfile,
					'request' => json_encode([
						'ixBug' => $caseId,
						'token' => $this->_token
						]
					)
				],
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
}

class ManuscriptException extends Exception
{
}
