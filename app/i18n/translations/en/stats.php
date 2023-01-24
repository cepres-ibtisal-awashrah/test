<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$lang['stats_chart_passed'] = '{0} Passed';
$lang['stats_chart_passed_desc'] = '{0}% were successful.';
$lang['stats_chart_retest'] = '{0} Retest';
$lang['stats_chart_retest_desc'] = '{0}% marked as retest.';
$lang['stats_chart_failed'] = '{0} Failed';
$lang['stats_chart_failed_desc'] = '{0}% were unsuccessful.';
$lang['stats_chart_untested'] = '{0} Untested';
$lang['stats_chart_untested_desc'] = '{0}% are untested.';
$lang['stats_chart_untested_note'] = '{0} / {1} untested ({2}%).';
$lang['stats_chart_blocked'] = '{0} Blocked';
$lang['stats_chart_blocked_desc'] = '{0}% marked as blocked.';
$lang['stats_chart_done'] = '{0}%';
$lang['stats_chart_done_desc'] = 'passed';
$lang['stats_chart_done_desc_upper'] = 'Passed';
$lang['stats_chart_status'] = '{0} {1}';
$lang['stats_chart_status_desc'] = '{0}% set to {1}';

$lang['stats_chart_tooltip_passed'] = '{0}% passed ({1}/{2} {2?{tests}:{test}})';
$lang['stats_chart_tooltip_retest'] = '{0}% retest ({1}/{2} {2?{tests}:{test}})';
$lang['stats_chart_tooltip_blocked'] = '{0}% blocked ({1}/{2} {2?{tests}:{test}})';
$lang['stats_chart_tooltip_failed'] = '{0}% failed ({1}/{2} {2?{tests}:{test}})';
$lang['stats_chart_tooltip_untested'] = '{0}% untested ({1}/{2} {2?{tests}:{test}})';
$lang['stats_chart_tooltip_status'] = '{1}% {0} ({2}/{3} {3?{tests}:{test}})';
$lang['stats_chart_tooltip_empty'] = '100% untested';

$lang['stats_chart_missing_flash'] = 'The charts require Adobe flash.
<a href="http://www.adobe.com/go/getflashplayer">Download flash here.</a>';
