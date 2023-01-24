<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * Database type enum.
 *
 * @package Enum
 */
class DatabaseTypeEnum extends Enum
{
    /** @var static $MYSQL */
    public static $MYSQL;

    /** @var static $SQLSRV */
    public static $SQLSRV;
}

DatabaseTypeEnum::construct();
