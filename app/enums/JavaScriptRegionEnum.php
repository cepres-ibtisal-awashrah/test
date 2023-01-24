<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * JavaScript region enum
 *
 * @package   Enum
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 */
class JavaScriptRegionEnum extends Enum
{
    /** @var $HEADER */
    public static $HEADER;

    /** @var $FOOTER */
    public static $FOOTER;

    /** @var $READY */
    public static $READY;
}

JavaScriptRegionEnum::construct();
