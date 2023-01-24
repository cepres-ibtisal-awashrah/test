<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * Entity type enum
 *
 * @package   Enum
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 */
class EntityTypeEnum extends Enum
{
    /** @var static $ENTITY_RUN_NAME  */
    public static $ENTITY_RUN_NAME = 'run';

    /** @var static $ENTITY_PLAN_NAME */
    public static $ENTITY_PLAN_NAME = 'plan';

    /** @var static $ENTITY_ENTRY_NAME */
    public static $ENTITY_ENTRY_NAME = 'entry';

    /** @var static $ENTITY_CONFIG_NAME */
    public static $ENTITY_CONFIG_NAME = 'config';

    /** @var static $ENTITY_PROJECT_NAME */
    public static $ENTITY_PROJECT_NAME = 'project';

    /** @var static $ENTITY_SECTION_NAME */
    public static $ENTITY_SECTION_NAME = 'section';

    /** @var static $ENTITY_MILESTONE_NAME */
    public static $ENTITY_MILESTONE_NAME = 'milestone';

    /** @var static $ENTITY_CASE_NAME */
    public static $ENTITY_CASE_NAME = 'case';

    /** @var static $ENTITY_TEST_CHANGE_NAME */
    public static $ENTITY_TEST_CHANGE_NAME = 'test_change';

    /** @var static $ENTITY_SUITE_NAME */
    public static $ENTITY_SUITE_NAME = 'suite';

    /** @var static $ENTITY_SHARED_STEPS_NAME */
    public static $ENTITY_SHARED_STEPS_NAME = 'shared_steps';

    /** @var static $ENTITY_CASE_COMMENT_NAME */
    public static $ENTITY_CASE_COMMENT_NAME = 'case_comment';
}

EntityTypeEnum::construct();
