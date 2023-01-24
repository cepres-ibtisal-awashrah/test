<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['reports_cas_meta_label'] = 'Activity Summary';
$lang['reports_cas_meta_group'] = 'Cases';
$lang['reports_cas_meta_summary'] = 'Shows a summary of new and updated test cases.';
$lang['reports_cas_meta_description'] = 'Shows a summary of new and updated test cases. Please see the Report Options section below to configure the report specific options.';

$lang['reports_cas_form_grouping'] = 'Grouping &amp; Changes';
$lang['reports_cas_form_suites'] = 'Test Suites';
$lang['reports_cas_form_sections'] = 'Sections';
$lang['reports_cas_form_cases'] = 'Test Cases';
$lang['reports_cas_form_cases_groupby'] = 'Group the changes by:';
$lang['reports_cas_form_cases_groupby_day'] = 'Day';
$lang['reports_cas_form_cases_groupby_month'] = 'Month';
$lang['reports_cas_form_cases_groupby_cases'] = 'Test Cases';
$lang['reports_cas_form_cases_groupby_suite'] = 'Test Suite';
$lang['reports_cas_form_cases_groupby_invalid'] = 'Unknown or unsupported test case grouping option.';

$lang['reports_cas_form_cases_changes'] = 'Include the following changes:';
$lang['reports_cas_form_cases_include_new'] = 'New test cases';
$lang['reports_cas_form_cases_include_updated'] = 'Updated test cases <em>(latest update only)</em>';
$lang['reports_cas_form_cases_limit'] = 'Maximum number of test cases to display:';
$lang['reports_cas_form_cases_required'] = 'Please include at least one change option (new or updated).';

$lang['reports_cas_suites_header'] = 'Test Suites';
$lang['reports_cas_suites_header_info'] = 'Shows the list of test suites that are used for this report.';
$lang['reports_cas_suites_empty'] = 'No test suites found.';
$lang['reports_cas_changes_header'] = 'Changes';
$lang['reports_cas_changes_header_info'] = 'Shows the new and/or updated test cases, grouped by the configured attribute.';

$lang['reports_cas_cases_groupby_unknown'] = 'Unknown';
$lang['reports_cas_cases_groupby_day'] = 'Day';
$lang['reports_cas_cases_groupby_month'] = 'Month';
$lang['reports_cas_cases_groupby_suite'] = 'Test Suite';
$lang['reports_cas_cases_groupby_cases'] = 'Test Cases';
$lang['reports_cas_cases_created'] = 'Created';
$lang['reports_cas_cases_created_short'] = 'C';
$lang['reports_cas_cases_updated'] = 'Updated';
$lang['reports_cas_cases_updated_short'] = 'U';
$lang['reports_cas_cases_percent'] = 'Percent';
$lang['reports_cas_cases_empty'] = 'No changes found.';
$lang['reports_cas_cases_more_created'] = 'There {0?{are}:{is}} {0} more new {0?{test cases}:{test case}} that {0?{are}:{is}} not displayed (in total).';
$lang['reports_cas_cases_more_updated'] = 'There {0?{are}:{is}} {0} more updated {0?{test cases}:{test case}} that {0?{are}:{is}} not displayed (in total).';
$lang['reports_cas_cases_change'] = 'Change';
$lang['reports_cas_cases_changes'] = 'Changes';

$lang['reports_cas_charts_bar_title'] = 'Changes by {0}';
$lang['reports_cas_charts_bar_title_to'] = 'Changes by {0} (up to {1})';
$lang['reports_cas_charts_bar_title_from'] = 'Changes by {0} (from {1})';
$lang['reports_cas_charts_bar_title_from_to'] = 'Changes by {0} ({1} - {2})';
$lang['reports_cas_charts_legend_created'] = 'Created';
$lang['reports_cas_charts_legend_updated'] = 'Updated';
