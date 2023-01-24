<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * Run type enum
 *
 * @package   Enum
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 */
class RunTypeEnum extends Enum
{
    /** @var $OPEN */
    public static $OPEN;

    /** @var $COMPLETION_PENDING */
    public static $COMPLETION_PENDING;

    /** @var $COMPLETED */
    public static $COMPLETED;
}

RunTypeEnum::construct();
