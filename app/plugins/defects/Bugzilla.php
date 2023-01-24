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
 
define('GI_DEFECTS_BUGZILLA_API_VERSION', '3.6');

class Bugzilla_defect_plugin extends Defect_plugin
{
	private $_api;
	
	private $_address;
	private $_user;
	private $_password;
	
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
password=secret'
	);
	
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
	}
	
	public function configure($config)
	{
		$ini = ini::parse($config);
		$this->_address = str::slash($ini['connection']['address']);
		$this->_user = $ini['connection']['user'];
		$this->_password = $ini['connection']['password'];	
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
		
		$this->_api = new Bugzilla_api(
			$this->_address,
			$this->_user,
			$this->_password);
		
		return $this->_api;
	}
	
	// *********************************************************
	// PUSH
	// *********************************************************

	public function prepare_push($context)
	{
		// Return a form with the following fields/properties
		return array(
			'fields' => array(
				'summary' => array(
					'type' => 'string',
					'label' => 'Summary',
					'required' => true,
					'size' => 'full'
				),
				'product' => array(
					'type' => 'dropdown',
					'label' => 'Product',
					'required' => true,
					'remember' => true,
					'cascading' => true,
					'size' => 'compact'
				),
				'component' => array(
					'type' => 'dropdown',
					'label' => 'Component',
					'required' => true,
					'remember' => true,
					'depends_on' => 'product',
					'size' => 'compact'
				),
				'version' => array(
					'type' => 'dropdown',
					'label' => 'Version',
					'required' => true,
					'remember' => true,
					'depends_on' => 'product',
					'size' => 'compact'
				),
				'description' => array(
					'type' => 'text',
					'label' => 'Description',
					'rows' => 10
				)
			)
		);
	}
	
	private function _get_summary_default($context)
	{		
		$test = current($context['tests']);
		$summary = 'Failed test: ' . $test->case->title;
		
		if ($context['test_count'] > 1)
		{
			$summary .= ' (+others)';
		}
		
		return $summary;
	}
	
	private function _get_description_default($context)
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
		// Bugzilla installation.		
		if ($field == 'summary' || $field == 'description')
		{
			switch ($field)
			{
				case 'summary':
					$data['default'] = $this->_get_summary_default(
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
			case 'product':
				$data['default'] = arr::get($prefs, 'product');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_products()
				);
				break;

			case 'component':
				if (isset($input['product']))
				{
					$data['default'] = arr::get($prefs, 'component');
					$data['options'] = $this->_to_id_name_lookup(
						$api->get_components($input['product'])
					);
				}
				break;

			case 'version':
				if (isset($input['product']))
				{
					$data['default'] = arr::get($prefs, 'version');
					$data['options'] = $this->_to_id_name_lookup(
						$api->get_versions($input['product'])
					);
				}
				break;
		}
		
		return $data;
	}
	
	public function validate_push($context, $input)
	{
	}

	public function push($context, $input)
	{
		$api = $this->_get_api();
		return $api->add_bug($input);
	}
	
	// *********************************************************
	// LOOKUP
	// *********************************************************
	
	public function lookup($defect_id)
	{
		$api = $this->_get_api();
		$bug = $api->get_bug($defect_id);

		// Decide which status to return to TestRail based on the
		// is_open  property of the bug. We can't differentiate it
		// further, it seems.
		if ($bug['is_open'])
		{
			$status_id = GI_DEFECTS_STATUS_OPEN;
		}
		else 
		{
			$status_id = GI_DEFECTS_STATUS_CLOSED;
		}
		
		// The first comment of a Bugzilla bug is the description
		// of the bug.
		if (isset($bug['comments']) && $bug['comments'])
		{
			$comment = current($bug['comments']);
			$description = str::format(
				'<div class="monospace">{0}</div>',
				nl2br(
					html::link_urls(
						h($comment['text'])
					)
				)
			);
		}
		else
		{
			$description = null;
		}
		
		// Add some important attributes for the bug such as the
		// current status and product. Note that the attribute
		// values (and description) support HTML and we thus need
		// to escape possible HTML characters (with 'h') in this
		// plugin.

		$attributes = array();
		
		if (isset($bug['status']))
		{
			$attributes['Status'] = h($bug['status']);
		}

		if (isset($bug['product']))
		{
			// Add a link to the product.
			$attributes['Product'] = str::format(
				'<a target="_blank" href="{0}describecomponents.cgi?product={1}">{2}</a>',
				a($this->_address),
				a($bug['product']),
				h($bug['product'])
			);
		}

		if (isset($bug['component']))
		{
			$attributes['Component'] = h($bug['component']);
		}
		
		return array(
			'id' => $defect_id,
			'url' => str::format(
				'{0}show_bug.cgi?id={1}',
				$this->_address,
				$defect_id
			),
			'title' => $bug['summary'],
			'status_id' => $status_id,
			'status' => $bug['status'],
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
 */
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
	 * of the Bugzilla installation including http or https prefix.
	 */	
	public function __construct($address, $user, $password)
	{
		$this->_address = str::slash($address) . 'xmlrpc.cgi';
		$this->_user = $user;
		$this->_password = $password;
		$this->_version = $this->_check_version();
	}
	
	private function _check_version()
	{
		$response = $this->_send_command('Bugzilla.version');
		if (!isset($response['version']))
		{
			$this->_throw_error(
				'Invalid response (missing "version" parameter)'
			);
		}
		
		// Check if the Bugzilla installation supports our minimum
		// version (i.e. has at least our version).
		$version = (string) $response['version'];		
		if (version_compare(
			$version, 
			GI_DEFECTS_BUGZILLA_API_VERSION,
			'<'))
		{
			$this->_throw_error(
				'Unsupported Bugzilla API version: {0}/{1}',
				$version,
				GI_DEFECTS_BUGZILLA_API_VERSION
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
		
		throw new BugzillaException($message);
	}
	
	private function _send_command($command, $data = array())
	{
		$data['Bugzilla_login'] = $this->_user;
		$data['Bugzilla_password'] = $this->_password;
		
		$request = xmlrpc::encode_request($command, $data);

		if (!$this->_curl)
		{
			// Initialize the cURL handle. We re-use this handle to
			// make use of Keep-Alive, if possible.
			$this->_curl = http::open();
		}

		$response = http::request_ex(
			$this->_curl,
			'POST',
			$this->_address,
			array(
				'data' => $request,
				'headers' => array(
					'Content-Type' => 'text/xml',
				)
			)
		);
		
		// In case debug logging is enabled, we append the data
		// we've sent and the entire request/response to the log.
		if (logger::is_on(GI_LOG_LEVEL_DEBUG))
		{
			logger::debugr('$request', $request);
			logger::debugr('$response', $response);
		}
		
		if ($response->code != 200)
		{
			$this->_throw_error(
				'Invalid HTTP code ({0})', $response->code
			);
		}

		$dom = xmlrpc::decode_request($response->content);
		
		// Check response for faultCode and/or faultString for any
		// errors.
		if (isset($dom['faultCode']))
		{
			if (isset($dom['faultString']))
			{
				$this->_throw_error(
					'{0} (faultCode: {1})',
					$dom['faultString'],
					$dom['faultCode']
				);
			}
			else 
			{
				$this->_throw_error(
					'Request resulted in error (faultCode: {0})',
					$dom['faultCode']
				);
			}
		}
		else 
		{
			if (isset($dom['faultString']))
			{
				$this->_throw_error(
					$dom['faultString']
				);
			}
		}
		
		return $dom;
	}

	/**
	 * Get Products
	 *
	 * Returns a list of products for the Bugzilla installation.
	 * Products are returned as array of objects, each with its ID
	 * and name.
	 */		
	public function get_products()
	{
		// Get a list of product IDs first.
		$response = $this->_send_command('Product.get_enterable_products');

		if (!$response)
		{
			return array();
		}

		// And then look up the properties of the products
		$response = $this->_send_command('Product.get', $response);
		
		if (!$response)
		{
			return array();
		}
		
		if (!isset($response['products']))
		{
			$this->_throw_error(
				'Invalid response (missing "products" parameter)'
			);
		}
		
		$result = array();
		
		$products = $response['products'];
		foreach ($products as $product)
		{
			$p = obj::create();
			$p->name = (string) $product['name'];
			$p->id = $p->name;
			$result[] = $p;
		}
		
		return $result;
	}
	
	private function _get_fields($name, $product_id)
	{
		$data = array('names' => array($name));
		$response = $this->_send_command('Bug.fields', $data);
		
		if (!$response)
		{
			return array();
		}
		
		if (!isset($response['fields']) || !$response['fields'])
		{
			$this->_throw_error(
				'Invalid response (missing "fields" parameter)'
			);
		}
		
		$field = current($response['fields']);
		if (!isset($field['values']) || !$field['values'])
		{
			return array();
		}
		
		$result = array();
		foreach ($field['values'] as $value)
		{
			$visibility = arr::get($value, 'visibility_values');
			
			if (!$visibility)
			{
				continue;
			}
			
			if (arr::exists($visibility, $product_id))
			{
				$f = obj::create();
				$f->name = (string) $value['name'];
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
	 */
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
	 */
	public function get_versions($product_id)
	{
		return $this->_get_fields('version', $product_id);
	}
	
	/**
	 * Get Bug
	 *
	 * Gets an existing case from the Bugzilla installation and
	 * returns it. The resulting bug object has various properties
	 * such as the summary, description, project etc.
	 */	 
	public function get_bug($bug_id)
	{
		$data = array('ids' => $bug_id);
		$response = $this->_send_command('Bug.get', $data);
		
		if (!$response || !isset($response['bugs']))
		{
			$this->_throw_error(
				'Empty response (missing "bugs" tag)'
			);			
		}
		
		$bugs = $response['bugs'];
		if (!$bugs)
		{
			$this->_throw_error(
				'No bug received (empty "bugs" tag)'
			);
		}
		
		$bug = current($bugs);
		
		return array(
			'summary' => $bug['summary'],
			'comments' => $this->_get_comments($bug_id),
			'product' => $bug['product'],
			'component' => $bug['component'],
			'status' => $bug['status'],
			'is_open' => $bug['is_open']
		);
	}
		
	private function _get_comments($bug_id)
	{
		// And then try to add the comments of the bug, if any.
		$data = array('ids' => $bug_id);
		$response = $this->_send_command('Bug.comments', $data);

		if (!$response)
		{
			return null;
		}
		
		if (!isset($response['bugs']) || !$response['bugs'])
		{
			return;
		}
		
		$bugs = $response['bugs'];
		if (!isset($bugs[$bug_id]['comments']))
		{
			return null;
		}
		
		$result = array();
		
		$comments = $bugs[$bug_id]['comments'];
		foreach ($comments as $comment)
		{
			$author = arr::get($comment, 'author');
			if (!$author)
			{
				$author = arr::get($comment, 'creator');
			}

			if (isset($comment['time']->timestamp))
			{
				$timestamp = (int)$comment['time']->timestamp;
			}
			else
			{
				$timestamp = null;
			}

			$result[] = array(
				'text' => (string) $comment['text'],
				'author' => $author,
				'timestamp' => $timestamp
			);
		}
		
		return $result;	
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
	 */	
	public function add_bug($options)
	{
		$response = $this->_send_command('Bug.create', $options);
		
		if (!isset($response['id']))
		{
			$this->_throw_error('No bug ID received');
		}
		
		return (string) $response['id'];
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
