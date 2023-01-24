<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * Attachments migration status enum.
 *
 * @package Enum
 * @author  Sebastian Karpeta <sebastian@assembla.com>
 * @author  Piotr Milcarz <piotr.milcarz@gurock.io>
 */
class DatabaseEnum extends Enum
{
    /** @var static $WINDOWS */
    public static $WINDOWS = 'sqlsrv';

    /** @var static $LINUX */
    public static $LINUX = 'mysql';
}

DatabaseEnum::construct();
