<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * Display types enum
 *
 * @package   Enum
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 */
class DisplayEnum extends Enum
{
    /** @var string $SMALL */
    public static $SMALL = 'small';

    /** @var string $MEDIUM */
    public static $MEDIUM = 'medium';

    /** @var string $LARGE */
    public static $LARGE = 'large';
}

DisplayEnum::construct();
