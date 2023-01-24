<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * HTTP methods codes.
 *
 * @package Enum
 * @author  Sebastian Karpeta <sebastian@assembla.com>
 */
class HttpMethodCodesEnum extends Enum
{
    /** @var static $GET */
    public static $GET;

    /** @var static $POST */
    public static $POST;

    /** @var static $PUT */
    public static $PUT;

    /** @var static $HEAD */
    public static $HEAD;

    /** @var static $DELETE */
    public static $DELETE;

    /** @var static $PATCH */
    public static $PATCH;

    /** @var static $OPTIONS */
    public static $OPTIONS;
}

HttpMethodCodesEnum::construct();