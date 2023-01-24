<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * Suffixes that should be removed during load by class name from loaded helpers, libraries, etc...
 *
 * @package Enum
 * @author  Sebastian Karpeta <sebastian@assembla.com>
 */
class DomainElementEnum extends Enum
{
    /** @var string $DRIVER */
    public static $DRIVER;

    /** @var string $HELPER */
    public static $HELPER;

    /** @var string $LIBRARY */
    public static $LIBRARY;

    /** @var string $LISTENER */
    public static $LISTENER;

    /** @var string $MODEL */
    public static $MODEL;

    /** @var string $SERVICE */
    public static $SERVICE;

    /** @var string $OB_LEVEL */
    public static $OB_LEVEL;
}

DomainElementEnum::construct();
