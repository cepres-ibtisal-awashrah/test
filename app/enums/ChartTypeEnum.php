<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * Chart type enum.
 *
 * @package Enum
 */
class ChartTypeEnum extends Enum
{
    /** @var string $MILESTONE */
    public static $MILESTONE = 'MILESTONE';

    /** @var string $PLAN */
    public static $PLAN = 'PLAN';

    /** @var string $RUN */
    public static $RUN = 'RUN';

    /** @var string $CHANGE */
    public static $CHANGE = 'CHANGE';
}

ChartTypeEnum::construct();
