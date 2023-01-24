<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * Webhook event type enum.
 *
 * @package Enum
 */
class WebhookEventTypeEnum extends Enum
{
    /** @var string $PLAN_CREATED */
    public static $PLAN_CREATED = 'plan_created';

    /** @var string $PLAN_UPDATED */
    public static $PLAN_UPDATED = 'plan_updated';

    /** @var string $PLAN_ENTRY_CREATED */
    public static $PLAN_ENTRY_CREATED = 'plan_entry_created';

    /** @var string $PLAN_ENTRIES_CREATED */
    public static $PLAN_ENTRIES_CREATED = 'plan_entries_created';

    /** @var string $PLAN_ENTRY_UPDATED */
    public static $PLAN_ENTRY_UPDATED = 'plan_entry_updated';

    /** @var string $PLAN_ENTRIES_UPDATED */
    public static $PLAN_ENTRIES_UPDATED = 'plan_entries_updated';

    /** @var string $RUN_CREATED */
    public static $RUN_CREATED = 'run_created';

    /** @var string $RUN_UPDATED */
    public static $RUN_UPDATED = 'run_updated';

    /** @var string $CASE_CREATED */
    public static $CASE_CREATED = 'case_created';

    /** @var string $CASE_UPDATED */
    public static $CASE_UPDATED = 'case_updated';

    /** @var string $CASES_UPDATED */
    public static $CASES_UPDATED = 'cases_updated';

    /** @var string $TEST_RESULT_CREATED */
    public static $TEST_RESULT_CREATED = 'test_result_created';

    /** @var string $TEST_RESULTS_CREATED */
    public static $TEST_RESULTS_CREATED = 'test_results_created';

    /** @var string $REPORT_CREATED */
    public static $REPORT_CREATED = 'report_created';
}

WebhookEventTypeEnum::construct();
