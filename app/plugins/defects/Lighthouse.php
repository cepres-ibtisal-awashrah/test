<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Lighthouse Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for Lighthouse. Please
 * see http://docs.gurock.com/testrail-integration/defects-plugins
 * for more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */

class Lighthouse_defect_plugin extends Defect_plugin
{
	private $_api;
	private $_address;
	private $_user;
	private $_password;
	private $_project_id;
	private $_defaultFields = [
		'title' => 'on',
		'state' => 'on',
		'assignee' => 'on',
		'milestone' => 'on',
		'tags' => 'on',
		'project' => 'on',
		'description' => 'on',
		'attachments'=> 'on',
	];
    private $_fieldDefaults = [
        'title' =>  [
            'type' => 'string',
            'label' => 'Title',
            'required' => true,
            'size' => 'full'
        ],
        'state' =>  [
            'type' => 'dropdown',
            'label' => 'Ticket State',
            'required' => false,
            'size' => 'compact'
        ],
        'assignee' =>  [
            'type' => 'dropdown',
            'label' => "Assignee",
            'remember' => true,
            'required' => false,
            'size' => 'compact'
        ],
        'milestone' => [
            'type' => 'dropdown',
            'label' => 'Milestone',
            'remember' => true,
            'required' => false,
            'size' => 'compact'
        ],
        'tags' => [
            'type' => 'string',
            'label' => 'Tags',
            'size' => 'full',
            'description' => 'A comma separated list of tags.'
        ],
        'project' => [
            'type' => 'dropdown',
            'label' => 'Project',
            'required' => true,
            'remember' => true,
            'cascading' => true,
            'size' => 'compact'
        ],
        'description' => [
            'type' => 'text',
            'label' => 'Description',
            'required' => false,
            'rows' => 10
        ],
        'attachments' => [
            'type' => 'dropbox',
            'label' => 'attachments',
            'required' => false,
            'size' => 'none'
        ]
    ];

    private static $_meta = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'Lighthouse defect plugin for TestRail',
        'can_push' => true,
        'can_lookup' => true,
        'default_config' => 
            '; Please configure your Lighthouse connection below
[connection]
address=https://<your-instance>.lighthouseapp.com/
user=testrail
password=secret
project_id=<lighthouse-project-id>

[push.fields]
title=on
state=on
assignee=on
milestone=on
tags=on
description=on
attachments=on

[hover.fields]
title=off
state=on
assignee=on
milestone=on
tags=on
project=on
description=on'
];

	public function get_meta()
	{
		return self::$_meta;
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

		$keys = array('address', 'user', 'password', 'project_id');

		// Check required values for existence
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

		$project_id = $ini['connection']['project_id'];

		// Check whether the project ID is a natural number
		if (!check::natural($project_id))
		{
			throw new ValidationException(
				"The 'project_id' value is needed to relate a ticket to
				the correct project and must be a numeric ID"
			);
		}
		foreach (['push.fields', 'hover.fields'] as $field) {
			foreach ($ini[$field] ?? [] as $field => $option) {
				if ($option === 'on') { 
					$this->_validateField($ini, $field);
				}
			}
		}
	}

	/**
	 * Validate field
	 * Validate custom and default fields and if 
	 * invalid field found then thows error.
	 *
	 * @param array  $ini   API configration.
	 * @param string $field Field name.
	 *
	 * @return void
	 *
	 * @throws ValidationException
	 */
	private function _validateField(array $ini, string $field)
	{
		$validTypes = [
			'dropdown' => true,
			'multiselect' => true,
			'text' => true,
			'string' => true
		];
		$category = arr::get($ini, "field.settings.$field");
		if (isset($category)) {
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
		// The specified type must be well-known.
		$type = arr::get($category, 'type');
		if ($type && !isset($validTypes[str::to_lower($type)])) {
			throw new ValidationException(
				str::format(
					'Invalid field type specified in section ' .
					'[filed.settings.{0}]',
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
		$this->_project_id = $ini['connection']['project_id'];
		$this->_config = $ini;
	}

	// *********************************************************
	// API / CONNECTION
	// *********************************************************

	private function _get_api()
	{
		if (!$this->_api)
		{
			$this->_api = new Lighthouse_api(
				$this->_address,
				$this->_user,
				$this->_password
			);
		}

		return $this->_api;
	}

	// *********************************************************
	// PUSH
	// *********************************************************
	/**
	* Prepare Push
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
			: ['project' => 'off'] + $this->_defaultFields;
		// based on the configuration of the defect plugin.
		foreach ($fieldsConfig as $fieldName => $option) {
			if ($option !== 'on') {
				continue;
			}
			$field = $this->_fieldDefaults[$fieldName] ?? [];
			$category = arr::get(
				$this->_config,
				"field.settings.$fieldName"
			);
			foreach ($category ?? [] as $prop => $val) {
				$property = str::to_lower($prop);
				$value = str::to_lower($val);
				if ($property === 'label') {
					$field[$property] = $val;
					continue;
				}
				if (in_array($property, ['required', 'remember', 'cascading'])) {
					$finalValue = $value === 'true';
				} elseif ($property === 'rows') {
					$finalValue = (int) $value;
				} else {
					$finalValue = $value;
				}
				// This may override the default value from above.
				$field[$property] = $finalValue;
			}
			$fields[$fieldName] = $field;
		}
		$result = ['fields' => $fields];
		// Save the form for later use in prepare_field().
		$this->_form = $result;

		return $result;
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
	
	private function _get_description_default($context)
	{
		return $context['test_change']->description;
	}

	public function prepare_field($context, $input, $field)
	{
		$data = array();

		// Process those fields that do not need a connection to the
		// Lighthouse installation.		
		if ($field == 'title' || $field == 'description')
		{
			switch ($field)
			{
				case 'title':
					$data['default'] = $this->_get_title_default(
						$context);
					break;
					
				case 'description':
					$data['default'] = $this->_get_description_default(
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
			case 'assignee':
				$data['default'] = arr::get($prefs, 'assignee');
				$data['options'] =
					$api->get_project_memberships($this->_project_id);
				break;

			case 'milestone':
				$data['default'] = arr::get($prefs, 'milestone');
				$data['options'] =
					$api->get_milestones($this->_project_id);
				break;

			case 'state':
				$states = $api->get_states($this->_project_id);
				if ($states)
				{
					$data['options'] = $states;				
					$data['default'] = current($states);
				}
				break;
			case 'tags':
				$data['default'] = arr::get($prefs, 'tags');
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
	public function push($context, $input, array $paths = [])
	{
		$api = $this->_get_api();

		return $api->add_ticket($this->_project_id, $input, $paths);
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
    public function lookup($defectId): array
    {
        $attributes = [];
        $fullAttributes = [];
        $description = null;
        $api = $this->_get_api();
        $ticket = $api->get_ticket($this->_project_id, $defectId);
        $project = $api->get_project($this->_project_id);
        $fieldsConfig = $this->_config['hover.fields'] ?? $this->_defaultFields;
        $statusId = arr::exists($project->open_states, $ticket->status)
            ? GI_DEFECTS_STATUS_OPEN
            : GI_DEFECTS_STATUS_CLOSED;
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on' || in_array($fieldName, ['title', 'attachments'])) {
                continue;
            }
            $category = arr::get($this->_config,"field.settings.$fieldName");
            if (isset($category)) {
                $field = $category;
            } elseif (isset($this->_fieldDefaults[$fieldName])) {
                $field = $this->_fieldDefaults[$fieldName];
            } else {
                //NOP
            }
            if ($fieldName === 'state' && isset($ticket->status)) {
                $value = h($ticket->status);
            } elseif (in_array($fieldName, ['title', 'assignee']) && isset($ticket->$fieldName)) {
                $value = h($ticket->$fieldName);
            } elseif ($fieldName === 'tags' && isset($ticket->$fieldName)) {
                $value = h(str::join($ticket->$fieldName, ', '));
            } elseif ($fieldName === 'milestone' && isset($ticket->milestone_title)) {
                $value = str::format(
                    '<a target="_blank" href="{0}projects/{1}/milestones/{2}">{3}</a>',
                    a($this->_address),
                    a($this->_project_id),
                    a($ticket->milestone_id),
                    h($ticket->milestone_title)
                );
            } elseif ($fieldName === 'project' && isset($project->name)) {	
                $value = str::format(
                    '<a target="_blank" href="{0}projects/{1}">{2}</a>',
                    a($this->_address),
                    a($ticket->project_id),
                    h($project->name)					
                );
            } else {
                $value = "&ndash;";
            }
            if ($fieldName === 'description' && !empty($ticket->description)) {
                $description = str::format(
                    '<div class="monospace">{0}</div>',
                    nl2br(html::link_urls(h($ticket->description)))
                );
            } elseif (!isset($field['size']) || ($field['size'] === 'full'
                && in_array($field['type'], ['text', 'string']))
                && isset($value)
            ) {
                $fullAttributes[$field['label']] = str::format(
                    '<div class="monospace">{0}</div>',
                    strip_tags(html_entity_decode($value))
                );
            } else {
                $attributes[$field['label']] = $value;
            }
        }

        return [
            'id' => $defectId,
            'url' => str::format(
                '{0}projects/{1}/tickets/{2}',
                $this->_address,
                $this->_project_id,
                $defectId
            ),
            'title' => $ticket->title,
            'status_id' => $statusId,
            'status' => $ticket->status,
            'description' => $description,
            'attributes' => $attributes,
            'fullAttributes' => $fullAttributes
        ];
    }
}

class Lighthouse_api
{
	private $_address;
	private $_user;
	private $_password;
	private $_curl;

	/**
	 * Construct
	 *
	 * Initializes a new Lighthouse API object. Expects the address of
	 * the Lighthouse installation including https prefix, the user
	 * name and password.
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
		$format = array_shift($args);
		
		if (count($args) > 0)
		{
			$message = str::formatv($format, $args);
		}
		else 
		{
			$message = $format;
		}
		
		throw new LighthouseException($message);
	}

	private function _send_command($method, $uri, $data = null)
	{
		$url = $this->_address . $uri;

		$options = array(
			'headers' => array(
				'Content-Type' => 'application/xml'
			),
			'user' => $this->_user,
			'password' => $this->_password,
			'data' => $data
		);

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

		// In case debug logging is enabled, we append the request
		// data and the response to the log.
		if (logger::is_on(GI_LOG_LEVEL_DEBUG))
		{
			logger::debugr(
				'$rest',
				array(
					'url' => $url,
					'options' => $options,
					'response' => $response
				)
			);
		}

		if ($response->code == 404)
		{
			$this->_throw_error('Resource/ticket not found.');
		}

		if ($response->code == 401)
		{
			$this->_throw_error(
				'Access denied. Please check your Lighthouse user and
				password.'
			);
		}

		$content = xml::parse_string($response->content);

		// Check for additional errors and include the received error
		// message in the exception, if any.
		if ($response->code != 200 && $response->code != 201)
		{
			if (isset($content->error))
			{
				$error = '';
				foreach ($content->error as $e)
				{
					if ($error)
					{
						$error .= "\n";
					}

					$error .= $e;
				}
			}
			else
			{
				$error = (string) $content;
			}

			$this->_throw_error(
				'Invalid HTTP code ({0}). {1}',
				$response->code,
				$error
			);
		}

		return $content;
	}

	/**
	* Add Ticket
	*
	* Adds a new ticket to the Lighthouse installation with the given
	* parameters and returns its ID.
	*
	* @param int   $projectId  The ID of the project that the new ticket is related to.
	* @param array $options    Default configuration.
	* @param array $paths      Attachments.
	* 
	* @return int
	*/
	public function add_ticket(int $projectId, array $options, array $paths): int
	{
		$xhtml = '<?xml version="1.0" encoding="UTF-8"?>
			<ticket>';
			foreach ($options as $fieldName => $fieldValue) {
				switch($fieldName) {
					case 'title':
						$attribute = 'title';
						break;
					case 'description':
						$attribute = 'body';
						$body = $fieldValue;
						break;
					case 'tags':
						$attribute = 'tag';
						break;
					case 'assignee':
						$attribute = 'assigned-user-id';
						break;
					case 'milestone':
						$attribute = 'milestone-id';
						break;
					case 'state':
						$attribute = 'state';
						break;
					case 'attachments':
						$attribute = 'attachments';
						break;
				}
				$xhtml .= '<' . $attribute . '>' . xml::encode($fieldValue) . '</' . $attribute . '>';
			}
		$xhtml .= '</ticket>';
		$data = str::format( $xhtml );
		$response = $this->_send_command(
			'POST',
			str::format(
				'projects/{0}/tickets.xml',
				$projectId
 			),
			$data
		);
		foreach ($paths ?? [] as $path) {
			$this->_add_attachment($path, $projectId, (int)$response->number, $body);
		}

		return (int)$response->number;
	}

    /**
     * Add attachment to the ticket.
     * 
     * @param string $path User uploaded file path.
     * @param int    $projectId Project ID.
     * @param int    $ticketId  Ticket ID.
     * @param string $body      Pass ticket body for to add attachment to ticket.
     *
     * @return void
     */
    private function _add_attachment(string $path, int $projectId, int $ticketId, string $body)
    {
		if (!$this->_curl) {
			$this->_curl = http::open();
		}
		$cfile = curl_file_create($path);
		$cfile->postname = basename($cfile->name);
		$response = http::request_ex(
			$this->_curl,
			'PUT',
			$this->_address . 'projects/' . $projectId . '/tickets/' . $ticketId . '.xml',
			[
				'headers' => [
					'Content-Type' => 'multipart/form-data'
				],
				'user' => $this->_user,
				'password' => $this->_password,
				'data' => [
					'ticket[body]' => $body,
					'ticket[attachment][]' => $cfile
				],
				'skip_url_encode' => true
			]
		);
	}

	/**
	 * Get Ticket
	 *
	 * Gets an existing ticket with the given ID from the Lighthouse
	 * installation.
	 */
	public function get_ticket($project_id, $ticket_id)
	{
		$response = $this->_send_command(
			'GET',
			str::format(
				'projects/{0}/tickets/{1}.xml',
				$project_id,
				$ticket_id
			)
		);

		$ticket = obj::create();
		$ticket->id = (int)$response->number;
		$ticket->title = (string)$response->title;
		$ticket->description = (string)$response->{'latest-body'};
		$ticket->status = (string)$response->state;
		$ticket->project_id = (int)$response->{'project-id'};
		$ticket->assignee = (string)$response->{'assigned-user-name'};
		$ticket->milestone_title = (string)$response->{'milestone-title'};
		$ticket->milestone_id = (int)$response->{'milestone-id'};

		// Split up the tags string into an array of tags. We have to
		// respect that Lighthouse allows tags including whitespaces
		// by putting them into double quotes.
		$ticket->tags = array();
		if ($response->tag)
		{
			preg_match_all(
				'/\b[^\s]+\b|"[^"]+"/', 
				$response->tag, 
				$matches
			);

			foreach ($matches[0] as $match)
			{
				$ticket->tags[] = trim((string)$match, '"');
			}
		}

		return $ticket;
	}

	/**
	 * Get Project Memberships
	 *
	 * Returns a list of all members associated with the project
	 * specified by the given project ID. 
	 */
	public function get_project_memberships($project_id)
	{
		$response = $this->_send_command(
			'GET',
			str::format(
				'projects/{0}/memberships.xml',
				$project_id
			)
		);
		
		$members = array();

		if (isset($response->membership))
		{
			foreach ($response->membership as $member)
			{
				if (!isset($member->{'user-id'}) ||
					!isset($member->user) ||
					!isset($member->user->name))
				{
					continue;
				}

				$members[(int)$member->{'user-id'}] = 
					(string)$member->user->name;
			}
		}

		return $members;
	}

	/**
	 * Get Milestones
	 *
	 * Returns a list of all milestones that exist for the project
	 * specified by the given project ID.
	 */
	public function get_milestones($project_id)
	{
		$response = $this->_send_command(
			'GET',
			str::format(
				'projects/{0}/milestones.xml',
				$project_id
			)
		);

		$milestones = array();

		if (isset($response->milestone))
		{
			foreach ($response->milestone as $milestone)
			{
				if (!isset($milestone->id) ||
					!isset($milestone->title))
				{
					continue;
				}

				$milestones[(int)$milestone->id] =
					(string)$milestone->title;
			}
		}

		return $milestones;
	}

	/**
	 * Get Project
	 *
	 * Gets an existing project with the given ID from the Lighthouse
	 * installation.
	 */
	public function get_project($project_id)
	{
		$response = $this->_send_command(
			'GET',
			str::format(
				'projects/{0}.xml',
				$project_id
			)
		);

		$project = obj::create();
		$project->id = $response->id;
		$project->name = $response->name;
		$project->open_states = str::split(
			$response->{'open-states-list'},
			','
		);
		$project->closed_states = str::split(
			$response->{'closed-states-list'},
			','
		);

		return $project;	
	}

	/**
	 * Get States
	 *
	 * Gets the available states for the project with the given ID
	 * from the Lighthouse installation.
	 */
	public function get_states($project_id)
	{
		$project = $this->get_project($project_id);

		$states = array();
		foreach ($project->open_states as $state)
		{
			$states[$state] = $state;
		}

		foreach ($project->closed_states as $state)
		{
			$states[$state] = $state;
		}

		return $states;
	}
}

class LighthouseException extends Exception
{
}
