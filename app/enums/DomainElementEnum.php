<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * Suffixes that should be removed during load by class name from loaded helpers, libraries, etc...
 *
 * @package   Enum
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 */
class DomainElementEnum extends Enum
{
    /** @var static $DATAPROVIDER */
    public static $DATAPROVIDER;

    /** @var static $DRIVER */
    public static $DRIVER;

    /** @var static $HELPER */
    public static $HELPER;

    /** @var static $LIBRARY */
    public static $LIBRARY;

    /** @var static $LISTENER */
    public static $LISTENER;

    /** @var static $MODEL */
    public static $MODEL;

    /** @var static $SERVICE */
    public static $SERVICE;

    /** @var static $OB_LEVEL */
    public static $OB_LEVEL;
}

DomainElementEnum::construct();
