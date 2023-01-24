<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * Content type enum.
 *
 * @package Enum
 */
class ContentTypeEnum extends Enum
{
	/** @var string $HEADER_CONTENT_TYPE */
	public static $HEADER_CONTENT_TYPE = 'application/json';
}

ContentTypeEnum::construct();
