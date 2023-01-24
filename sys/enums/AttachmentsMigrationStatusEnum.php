<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * Attachments migration status enum.
 *
 * @package Enum
 * @author  Sebastian Karpeta <sebastian@assembla.com>
 */
class AttachmentsMigrationStatusEnum extends Enum
{
    /** @var static $NONE */
    public static $NONE = 0;

    /** @var static $SCHEDULED_MIGRATION_TO_CASSANDRA */
    public static $SCHEDULED_MIGRATION_TO_CASSANDRA = 1;

    /** @var static $SCHEDULED_MIGRATION_TO_DATABASE */
    public static $SCHEDULED_MIGRATION_TO_DATABASE = 2;

    /** @var static $MIGRATING_ATTACHMENTS */
    public static $MIGRATING_ATTACHMENTS = 3;

    /** @var static $MIGRATING_ENTITIES */
    public static $MIGRATING_ENTITIES = 4;

    /** @var static $DONE */
    public static $DONE = 5;


}

AttachmentsMigrationStatusEnum::construct();
