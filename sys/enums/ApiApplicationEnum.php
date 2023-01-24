<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * ApiApplicationEnum
 *
 * @package Enum
 * @author  Sebastian Karpeta <sebastian@assembla.com>
 */
class ApiApplicationEnum extends Enum
{
    /** @var string $DEFAULT */
    public static $DEFAULT = 'default';

    /** @var string $ASSEMBLA */
    public static $ASSEMBLA = 'asm';

    /** @var string $RANOREX */
    public static $RANOREX = 'rx';

    /** @var string $TRL */
    public static $TEST_RAIL_LITE = 'trl';

    /** @var string $BETA */
    public static $BETA = 'beta';

}

ApiApplicationEnum::construct();
