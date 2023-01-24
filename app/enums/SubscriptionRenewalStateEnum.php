<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * Subscription renewal state enum.
 *
 * @package Enum
 * @author  Sebastian Karpeta <sebastian@assembla.com>
 */
class SubscriptionRenewalStateEnum extends Enum
{
    /** @var int $NONE */
    public static $NONE = 0;

    /** @var int $LEVEL1 */
    public static $LEVEL1 = 1;

    /** @var int $LEVEL2 */
    public static $LEVEL2 = 2;
}

SubscriptionRenewalStateEnum::construct();
