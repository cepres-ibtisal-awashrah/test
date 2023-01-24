<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * Test results status enum.
 *
 * @package   Enum
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 */
class TestStatusEnum extends Enum
{
    /** @var int $PASSED */
    public static $PASSED = 1;

    /** @var int $BLOCKED */
    public static $BLOCKED = 2;

    /** @var int $UNTESTED */
    public static $UNTESTED = 3;

    /** @var int $RETEST */
    public static $RETEST = 4;

    /** @var int $FAILED */
    public static $FAILED = 5;

    /** @var int $CUSTOM_STATUS1 */
    public static $CUSTOM_STATUS1 = 6;

    /** @var int $CUSTOM_STATUS2 */
    public static $CUSTOM_STATUS2 = 7;

    /** @var int $CUSTOM_STATUS3 */
    public static $CUSTOM_STATUS3 = 8;

    /** @var int $CUSTOM_STATUS4 */
    public static $CUSTOM_STATUS4 = 9;

    /** @var int $CUSTOM_STATUS5 */
    public static $CUSTOM_STATUS5 = 10;

    /** @var int $CUSTOM_STATUS6 */
    public static $CUSTOM_STATUS6 = 11;

    /** @var int $CUSTOM_STATUS7 */
    public static $CUSTOM_STATUS7 = 12;
}

TestStatusEnum::construct();
