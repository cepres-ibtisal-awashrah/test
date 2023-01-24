<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$lang['suites_runtest'] = 'Run Test';
$lang['suites_runreport'] = 'Reports';
$lang['suites_view_runs'] = 'Test Runs';
$lang['suites_runtest_desc'] = 'Create a new test run for this test suite.';
$lang['suites_addtestrun'] = 'Add Test Run';
$lang['suites_shared_steps'] = 'Shared Test Steps';

$lang['suites_addcase'] = 'Add Case';
$lang['suites_runningtest'] = 'Running Test';
$lang['suites_runningtests'] = 'Running Tests';
$lang['suites_completed'] = '<strong>This test suite is completed.</strong> You can no longer modify its sections or test cases.';

$lang['suites_reports_cases'] = 'Cases';
$lang['suites_reports_cases_activity_summary'] = 'Activity Summary';
$lang['suites_reports_cases_activity_summary_hint'] = 'Shows a summary of new and updated test cases.';
$lang['suites_reports_cases_reference_coverage'] = 'Coverage for References';
$lang['suites_reports_cases_reference_coverage_hint'] = 'Shows the test case coverage for references (requirements, user stories, etc.) in a coverage matrix.';
$lang['suites_reports_cases_property_groups'] = 'Property Distribution';
$lang['suites_reports_cases_property_groups_hint'] = 'Shows the distribution and groups for a specific test case attribute (e.g. priority or type).';
$lang['suites_reports_cases_status_tops'] = 'Status Tops';
$lang['suites_reports_cases_status_tops_hint'] = 'Shows the test cases with the highest number of failed, blocked etc. results.';

$lang['suites_reports_defects'] = 'Defects';
$lang['suites_reports_defects_summary'] = 'Summary';
$lang['suites_reports_defects_summary_hint'] = 'Shows a summary of found defects for the test cases and select test runs.';
$lang['suites_reports_defects_cases_summary'] = 'Summary for Cases';
$lang['suites_reports_defects_cases_summary_hint'] = 'Shows a summary and comparison of found defects per test case and select test runs.';
$lang['suites_reports_defects_references_summary'] = 'Summary for References';
$lang['suites_reports_defects_references_summary_hint'] = 'Shows a summary and comparison of found defects for the references (requirements, user stories, etc.).';

$lang['suites_reports_results'] = 'Results';
$lang['suites_reports_results_case_coverage'] = 'Comparison for Cases';
$lang['suites_reports_results_case_coverage_hint'] = 'Compares the results for the test cases over multiple test runs (result coverage).';
$lang['suites_reports_results_reference_coverage'] = 'Comparison for References';
$lang['suites_reports_results_reference_coverage_hint'] = 'Compares the results for the references (requirements, user stories, etc.) over multiple test runs (result coverage).';

$lang['suites_overview_description'] = 'Has {0} {0?{sections}:{section}} with {1} {1?{test cases}:{test case}}.';
$lang['suites_overview_description_short'] = '{0} {0?{sections}:{section}} with <strong>{1} {1?{cases}:{case}}</strong>';
$lang['suites_overview_description_runs'] = '<strong>{0}</strong> active {0?{test runs}:{test run}}.';
$lang['suites_overview_description_runs_short'] = '{1} {0?{Runs}:{Run}}';
$lang['suites_overview_description_noruns'] = 'No active test runs.';

$lang['suites_overview_display'] = 'Display';
$lang['suites_overview_display_large'] = 'Detail View';
$lang['suites_overview_display_large_desc'] = 'Displays the test suites with many details. Useful if you have just a few suites.';
$lang['suites_overview_display_medium'] = 'Medium View';
$lang['suites_overview_display_medium_desc'] = 'Displays the test suites in a medium-sized way.';
$lang['suites_overview_display_small'] = 'Compact View';
$lang['suites_overview_display_small_desc'] = 'Displays the test suites as a compact list. Useful if you have many suites.';

$lang['suites_overview_baselines'] = 'Baselines';
$lang['suites_overview_baselines_noactive'] = 'No active baselines.';
$lang['suites_overview_baselines_completed'] = 'Completed';

$lang['suites_view_display'] = 'Display';
$lang['suites_view_display_tree'] = 'All groups and tests';
$lang['suites_view_display_tree_name'] = 'All';
$lang['suites_view_display_subtree'] = 'Selected group and subgroups';
$lang['suites_view_display_subtree_name'] = 'Subgroups';
$lang['suites_view_display_compact'] = 'Selected group only';
$lang['suites_view_display_compact_name'] = 'Selected';

$lang['suites_group_by'] = 'Group By';
$lang['suites_group_by_none'] = 'Section';
$lang['suites_group_by_reset'] = 'Reset grouping to sections.';
$lang['suites_group_by_reset_menu'] = 'Reset to sections';
$lang['suites_group_order'] = 'Group Order';
$lang['suites_group_id'] = 'Group ID';

$lang['suites_filter_reset'] = 'Remove filter and show all test cases.';
$lang['suites_filter_none'] = 'None';
$lang['suites_filter_group_active'] = 'Active';
$lang['suites_filter_group_upcoming'] = 'Upcoming';
$lang['suites_filter_group_completed'] = 'Completed';
$lang['suites_filter_empty'] = 'No test cases found.';

$lang['suites_sidebar_suites_stats'] = '<strong class="text-softer">{0}</strong> {0?{test suites}:{test suite}} and <strong class="text-softer">{1}</strong> {1?{cases}:{case}} in this project.';
$lang['suites_sidebar_suites_stats_baselines'] =
'<strong class="text-softer">{0}</strong> master {0?{suites}:{suite}},
<strong class="text-softer">{1}</strong> {1?{baselines}:{baseline}} and a total of <strong class="text-softer">{2}</strong> active {2?{cases}:{case}}.';
$lang['suites_sidebar_sections'] = 'Groups';
$lang['suites_sidebar_cases'] = 'Test Cases';

$lang['suites_case_ids'] = 'Case IDs';

$lang['suites_mode_single_not_allowed'] = 'This operation is not permitted because this project only supports a single test suite.';

$lang['suites_new'] = 'Add Test Suite';
$lang['suites_edit'] = 'Edit Test Suite';
$lang['suites_add'] = 'Add Test Suite';
$lang['suites_save'] = 'Save Test Suite';
$lang['suites_view'] = 'View Test Suite';
$lang['suites_view_short'] = 'Test Suite';
$lang['suites_view_veryshort'] = 'Suite';
$lang['suites_actions'] = 'Actions';
$lang['suites_delete'] = 'Delete Test Suite';
$lang['suites_delete_link'] = 'Delete this test suite';
$lang['suites_delete_descr'] = 'Delete this test suite to remove it from your project. This also deletes all related test cases and running tests.';
$lang['suites_delete_confirm'] = 'Really delete this test suite and all <strong>related active test runs and results</strong>? This cannot be undone. You can close active test runs to archive them and prevent them from being deleted.';
$lang['suites_delete_confirm_checkbox'] = 'Yes, delete this test suite (cannot be undone)';
$lang['suites_delete_confirm_extra'] = 'You will irrevocably delete at least <strong>{0}</strong> {0?{test cases}:{test case}} and <strong>{1}</strong> active {1?{test runs}:{test run}} (including tests and results).';
$lang['suites_print_confirm'] = 'This test suite contains {0} test cases. The <em>Details</em> view will generate hundreds of pages and may be slow. Continue?';

$lang['suites_baselines_new'] = 'Add Baseline';
$lang['suites_baselines_name'] = 'Name';
$lang['suites_baselines_name_desc'] = 'The name of the new baseline, e.g. <em>Version 2.0</em>.';
$lang['suites_baselines_parent'] = 'Copy From';
$lang['suites_baselines_parent_desc'] = 'Choose a project and the test suite to use as the basis for the new baseline.';

$lang['suites_denied_add'] = 'You are not allowed to add test suites (insufficient permissions).';
$lang['suites_denied_add_baseline'] = 'You are not allowed to add baselines (insufficient permissions).';
$lang['suites_denied_edit'] = 'You are not allowed to edit test suites (insufficient permissions).';
$lang['suites_denied_delete'] = 'You are not allowed to delete test suites (insufficient permissions).';
$lang['suites_denied_delete_master'] = 'This test suite is a master suite and cannot be deleted.';
$lang['suites_denied_completed'] = 'This operation is not allowed. The test suite is marked as completed.';

$lang['suites_return_location'] = 'Return Location';
$lang['suites_suite'] = 'Test Suite';
$lang['suites_suite_short'] = 'Suite';
$lang['suites_ids'] = 'Test Suite IDs';
$lang['suites_cases'] = 'Test Cases';
$lang['suites_case_count'] = 'Case Count';
$lang['suites_section_count'] = 'Section Count';
$lang['suites_sections'] = 'Sections';
$lang['suites_box'] = 'Test Suite';
$lang['suites_name'] = 'Name';
$lang['suites_name_desc'] = 'Ex: <em>User Interface Test</em> or <em>Release Protocol</em>';
$lang['suites_iscompleted'] = 'Is Completed';
$lang['suites_iscompleted_name'] = 'This test suite is completed';
$lang['suites_iscompleted_desc'] = 'The test cases of a completed test suite are freezed and can no longer be modified.
This is useful for finished versions or releases with a final set of test cases.';
$lang['suites_include_sidebar'] = 'Include Sidebar';
$lang['suites_partial'] = 'Is Partial';
$lang['suites_offset'] = 'Offset';
$lang['suites_expands'] = 'Group Expands';
$lang['suites_description'] = 'Description';
$lang['suites_description_edit'] = 'Edit Description';
$lang['suites_description_save'] = 'Save Description';
$lang['suites_description_desc'] = 'Use this description to explain the content and purpose of this test suite.';
$lang['suites_description_desc_single'] = 'Use this description to explain the content and purpose of the test cases.';

$lang['suites_columns'] = 'Columns';

$lang['suites_sections_confirm_delete'] = 'Really delete this section and all related test cases and running tests? This also deletes <strong>all subsections and cases of this section</strong> and cannot be undone.';
$lang['suites_sections_confirm_delete_checkbox'] = 'Yes, delete this section (cannot be undone)';
$lang['suites_sections_confirm_delete_extra'] = 'You will irrevocably delete at least <strong>{0}</strong> {0?{sections}:{section}} and <strong>{1}</strong> {1?{test cases}:{test case}}.';

$lang['suites_success_add'] = 'Successfully added the new test suite.
<a href="{0}">Add another</a>';
$lang['suites_success_delete'] = 'Successfully deleted the test suite.';
$lang['suites_error_add'] = 'An error occurred while adding the new test suite.';
$lang['suites_error_delete'] = 'An error occurred while deleting the test suite. Maybe the test suite didn\'t exist anymore?';
$lang['suites_error_exists'] = 'The specified test suite does not exist or you do not have the permission to access it.';
$lang['suites_success_update'] = 'Successfully updated the test suite.';
$lang['suites_error_update'] = 'An error occurred while saving the test suite.';

$lang['suites_sections_new'] = 'Add Section';
$lang['suites_sections_edit'] = 'Edit Section';
$lang['suites_sections_error_exists'] = 'The specified section does not exist or you do not have the permission to access it.';
$lang['suites_sections_add'] = 'Add Section';
$lang['suites_sections_save'] = 'Save Section';

$lang['suites_sections_copy_move_invalid'] = 'Invalid arguments for copy/move section (e.g., some sections no longer exist). Please refresh this page and try again.';
$lang['suites_sections_denied_add'] = 'You are not allowed to add sections (insufficient permissions).';
$lang['suites_sections_denied_edit'] = 'You are not allowed to edit sections (insufficient permissions).';
$lang['suites_sections_denied_copy'] = 'You are not allowed to copy sections (insufficient permissions).';
$lang['suites_sections_denied_move'] = 'You are not allowed to move sections (insufficient permissions).';
$lang['suites_sections_denied_delete'] = 'You are not allowed to delete sections (insufficient permissions).';

$lang['suites_subsection_new'] = 'Add Subsection';

$lang['suites_section'] = 'Section';
$lang['suites_section_show_empty'] = 'Show Empty';
$lang['suites_section_ids'] = 'Section IDs';
$lang['suites_section_parent'] = 'Section Parent';
$lang['suites_section_mode'] = 'Section Mode';
$lang['suites_sections_name_error'] = 'The Name field is required.';
$lang['suites_sections_name'] = 'Name';
$lang['suites_sections_parent'] = 'Parent';
$lang['suites_sections_no_parent'] = 'The specified parent section does not exist.';
$lang['suites_sections_desc'] = 'Ex: <em>Save Dialog Tests</em>, <em>Contact Form</em> or <em>Performance Tests</em>';
$lang['suites_sections_description'] = 'Description';
$lang['suites_sections_description_desc'] = 'An optional description for this section (e.g. to explain its content or purpose).';

$lang['suites_sections_columns'] = 'Columns';
$lang['suites_sections_dnd_copy'] = 'Copy here';
$lang['suites_sections_dnd_copy_hint'] = '(shift)';
$lang['suites_sections_dnd_move'] = 'Move here';
$lang['suites_sections_dnd_move_hint'] = '(ctrl/cmd)';
$lang['suites_sections_dnd_cancel'] = 'Cancel';

$lang['suites_runs_active'] = 'Active';
$lang['suites_runs_completed'] = 'Completed';
$lang['suites_loading'] = 'Loading cases ..';

$lang['suites_sidebar_menu_suite'] = 'Sections &amp; Cases';
$lang['suites_sidebar_menu_runs'] = 'Test Runs';

$lang['suites_sidebar_info'] = 'Contains <strong class="text-softer">{0}</strong> {0?{sections}:{section}}
and <a class="link link-dashed" id="estimatesLink" href="javascript:void(0)"><strong class="text-softer">{1}</strong>
<span>{1?{cases}:{case}}</span></a>.';
$lang['suites_sidebar_info_simple'] = 'Contains <strong class="text-softer">{0}</strong> {0?{sections}:{section}}
and <strong class="text-softer">{1}</strong> {1?{cases}:{case}}.';
$lang['suites_sidebar_info_edit_description'] = 'Edit description';

$lang['suites_sidebar_suites'] = 'Test Suites';
$lang['suites_sidebar_suites_sections'] = 'Sections in this test suite:';
$lang['suites_sidebar_suites_empty'] = 'No sections or groups.';

$lang['suites_estimates_title'] = 'Show the estimates and forecasts for this test suite.';
$lang['suites_estimates_cases'] = 'Total cases';
$lang['suites_estimates_without'] = 'No estimates';
$lang['suites_estimates_estimate'] = 'Total estimate';
$lang['suites_estimates_forecast'] = 'Total forecast';

$lang['suites_cases_new'] = 'Add Test Case';
$lang['suites_cases_new_short'] = 'Add Case';
$lang['suites_cases_title_error'] = 'The Case Title field is required.';
$lang['suites_cases_title'] = 'Case Title: ';
$lang['suites_cases_toolbar_sorted'] = 'Sort:';
$lang['suites_cases_toolbar_display_deleted_cases'] = 'Display Deleted Test Cases';
$lang['suites_cases_toolbar_add_case'] = 'Add Case';
$lang['suites_cases_toolbar_add_section'] = 'Add Section';
$lang['suites_cases_toolbar_add_section_disabled_hint'] = 'Adding sections is only supported if the cases are grouped by sections.';
$lang['suites_cases_toolbar_delete_cases'] = 'Delete';
$lang['suites_cases_toolbar_delete_cases_desc'] = 'Delete the selected test cases.';
$lang['suites_cases_toolbar_delete_cases_confirm'] = 'Really mark all selected test cases as deleted?';
$lang['suites_cases_toolbar_edit_cases'] = 'Edit';
$lang['suites_cases_toolbar_edit_cases_selected'] = 'Edit selected';
$lang['suites_cases_toolbar_edit_cases_selected_hint'] = 'Edits all selected test cases.';
$lang['suites_cases_toolbar_edit_cases_group'] = 'Edit all in current view';
$lang['suites_cases_toolbar_edit_cases_group_hint'] = 'Edits the cases of the current section or group, respecting the current filter.';
$lang['suites_cases_toolbar_edit_cases_subtree_hint'] = 'Edits the cases of the current section or group (including subsections), respecting the current filter.';
$lang['suites_cases_toolbar_edit_cases_all'] = 'Edit all in filter';
$lang['suites_cases_toolbar_edit_cases_all_hint'] = 'Edits all cases of this test suite, respecting the current filter.';
$lang['suites_cases_toolbar_filter'] = 'Filter:';

$lang['suites_empty_title'] = 'This test suite doesn\'t contain any test cases, yet.';
$lang['suites_empty_title_master'] = 'There aren\'t any test cases, yet.';
$lang['suites_empty_body'] = 'There aren\'t any sections or test cases in this suite yet. Use the following buttons to create the first test case and section.';
$lang['suites_empty_body_master'] = 'There aren\'t any sections or test cases. Use the following buttons to create the first test case and section.';
$lang['suites_empty_nogrouping_body'] = 'There aren\'t any sections or test cases in this suite yet. Use the following button to create the first section.';
$lang['suites_empty_noaccess_body'] = 'There aren\'t any sections or test cases in this suite yet.
Unfortunately, you don\'t have the required permissions to add test cases or sections.
Please contact your administrator.';
$lang['suites_empty_expl_title'] = 'Test cases and sections?';
$lang['suites_empty_expl_body'] = 'A test case verifies a certain feature, functionality or requirement. Sections are used to organize related test cases into groups.';

$lang['suites_select_title'] = 'Select Cases';
$lang['suites_select_filter'] = 'Selection Filter';
$lang['suites_select_filter_set'] = 'Set Selection';
$lang['suites_select_filter_add'] = 'Add To Selection';
$lang['suites_select_filter_remove'] = 'Remove From Selection';
$lang['suites_select_filter_matches'] = '<strong>{0}</strong> {0?{test cases}:{test case}} matched.';
$lang['suites_select_empty'] = 'No test cases found.';

$lang['suites_overview_empty_title'] = 'This project doesn\'t contain any test suites, yet.';
$lang['suites_overview_empty_body'] = 'No test suites have been added to this project yet. Use the following button to add the first test suite.';
$lang['suites_overview_empty_noaccess_body'] = 'No test suites have been added to this project yet.
Unfortunately, you don\'t have the required permissions to add new test suites.
Please contact your administrator.';
$lang['suites_overview_empty_expl_title'] = 'What\'s a test suite?';
$lang['suites_overview_empty_expl_body'] = 'A test suite is a collection of test cases. Test suites are used to organize related test cases into groups and execute them at once.';

$lang['suites_dialogs_width'] = 'Width';
$lang['suites_dialogs_height'] = 'Height';
$lang['suites_dialogs_splitter'] = 'Splitter';

$lang['suites_runs_new'] = 'Add Test Run';

$lang['suites_runs_empty_title'] = 'There aren\'t any test runs for this suite, yet.';
$lang['suites_runs_empty_body'] = 'No test runs have been defined for this suite, yet. Use the following button to add your first test run.';
$lang['suites_runs_empty_noaccess_body'] = 'No test runs have been defined for this suite, yet.
Unfortunately, you don\'t have the required permissions to add test runs.
Please contact your administrator.';
$lang['suites_runs_empty_expl_title'] = 'What\'s a test run?';
$lang['suites_runs_empty_expl_body'] = 'Test runs let you execute the test cases of a test suite, enter test results and aggregate statistics about the tests.';

$lang['suites_print_hint'] = 'Print Suite';
$lang['suites_print_hint_single'] = 'Print Cases';
$lang['suites_print_hint_desc'] = 'Opens a print view of this test suite.';
$lang['suites_print_hint_desc_single'] = 'Opens a print view of this test case repository.';
$lang['suites_print_format'] = 'Print Format';
$lang['suites_export_hint'] = 'Export Suite';
$lang['suites_export_hint_single'] = 'Export Cases';
$lang['suites_export_hint_desc'] = 'Exports this test suite into different formats (XML, Excel/CSV).';
$lang['suites_export_hint_desc_single'] = 'Exports the sections and test cases into different formats (XML, Excel/CSV).';
$lang['suites_export_format'] = 'Format';
$lang['suites_export_section_include'] = 'Section Include';
$lang['suites_export_section_ids'] = 'Section IDs';
$lang['suites_export_columns'] = 'Columns';
$lang['suites_export_separator_hint'] = 'Separator Hint';
$lang['suites_export_separated_rows'] = 'Separated rows for separated steps';
$lang['suites_suite_not_empty'] = 'You are not allowed to delete suites with test cases (insufficient permissions).';
$lang['suites_section_not_empty'] = 'You are not allowed to delete sections with test cases (insufficient permissions).';

$lang['suites_import_hint'] = 'Import Cases';
$lang['suites_import_hint_desc'] = 'Imports sections and test cases from a TestRail XML or CSV file.';
$lang['suites_import'] = 'Import from XML';
$lang['suites_import_file'] = 'File';
$lang['suites_import_short'] = 'Import';
$lang['suites_import_file_desc'] = 'Choose the file to import. Must be a valid TestRail XML import file.
<a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/howto/import-xml">Learn more</a>';
$lang['suites_import_insert'] = 'Add new test cases';
$lang['suites_import_insert_desc'] = 'Test cases and sections from the XML file are imported as new test cases &amp; sections and are appended to this test suite.';
$lang['suites_import_update'] = 'Update existing test cases';
$lang['suites_import_update_desc'] = 'Existing test cases are updated. All test cases in the XML import file must reference valid test case IDs (via a &lt;id&gt; field).';
$lang['suites_import_error_db'] = 'A database error occurred while importing';
$lang['suites_import_error_required'] = 'The File field is required.';
$lang['suites_import_error_val'] = 'The file is not a valid TestRail XML import file';

$lang['suites_import_csv'] = 'Import from CSV';
$lang['suites_import_csv_submit'] = 'Import';
$lang['suites_import_csv_step1'] = 'Load File and Settings';
$lang['suites_import_csv_step1_file'] = 'File';
$lang['suites_import_csv_step1_file_desc'] = 'Choose the file to import. Must be a valid CSV file.
<a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/howto/import-csv">Learn more</a>';
$lang['suites_import_csv_step1_file_upload_success'] = 'CSV file uploaded successfully.';
$lang['suites_import_csv_step1_format'] = 'Format &amp; Mapping';
$lang['suites_import_csv_step1_format_create'] = 'Configure new mapping';
$lang['suites_import_csv_step1_format_load'] = 'Load mapping from configuration file';
$lang['suites_import_csv_step1_format_upload_success'] = 'Configuration file uploaded successfully.';
$lang['suites_import_csv_step1_advanced'] = 'Advanced Options';
$lang['suites_import_csv_step1_section'] = 'Import To';
$lang['suites_import_csv_step1_encoding'] = 'File Encoding';
$lang['suites_import_csv_step1_encoding_excel'] = ' &ndash; Excel default';
$lang['suites_import_csv_step1_encoding_googledocs'] = ' &ndash; Google Docs default';
$lang['suites_import_csv_step1_delimiter'] = 'CSV Delimiter';
$lang['suites_import_csv_step1_delimiter_desc'] = 'Usually , or ; or \\t (for tab)';
$lang['suites_import_csv_step1_rows_start'] = 'Start Row';
$lang['suites_import_csv_step1_rows_header'] = 'Is header row';
$lang['suites_import_csv_step1_no_columns'] = 'No columns found in the CSV file. Please check the start row and CSV delimiter.';
$lang['suites_import_csv_step2'] = 'Map Columns &amp; Row Layout';
$lang['suites_import_csv_step2_intro'] = 'TestRail analyzed the CSV file and found the following CSV columns.
Please configure the row layout (single row/multiple rows) and map the CSV columns to TestRail\'s fields.';
$lang['suites_import_csv_step1_template'] = 'Template';
$lang['suites_import_csv_step1_template_desc'] = 'Template for imported cases';
$lang['suites_import_csv_step2_rows'] = 'Row Layout';
$lang['suites_import_csv_step2_rows_single'] = 'Test cases use a single row';
$lang['suites_import_csv_step2_rows_multi'] = 'Test cases use multiple rows.
<a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/howto/import-csv">Learn more</a>';
$lang['suites_import_csv_step2_rows_multi_column'] = 'Column to detect new test cases:';
$lang['suites_import_csv_step2_mapping_column'] = 'CSV Column';
$lang['suites_import_csv_step2_mapping_field'] = 'TestRail Field';
$lang['suites_import_csv_step2_column'] = 'Column';
$lang['suites_import_csv_step2_rows_skip_notitle'] = 'Ignore test cases/records without a title (example: empty records at file end)';
$lang['suites_import_csv_step3'] = 'Map Values';
$lang['suites_import_csv_step3_intro'] = 'The next step is to map the CSV values to TestRail.
For example, if you have a priority value of <em>Medium</em> in your CSV file,
this step allows you to map this to a priority of <em>Low</em> or <em>Normal</em> in
TestRail.';
$lang['suites_import_csv_step3_values_removehtml'] = 'Remove HTML tags from CSV values';
$lang['suites_import_csv_step3_values_dateformat'] = 'Date Format';
$lang['suites_import_csv_step3_values_dateformat_sample'] = 'M/d/yyyy';
$lang['suites_import_csv_step3_values_dateformat_more'] =
	'<a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/howto/import-csv">Learn more</a>';
$lang['suites_import_csv_step3_values_empty'] = 'No values found for this column.';
$lang['suites_import_csv_step4'] = 'Preview Import';
$lang['suites_import_csv_step4_intro'] = 'TestRail found <strong class="text-softer">{0}</strong>
{0?{test cases}:{test case}} in the CSV file. Please review the first few cases before importing the CSV file.
You can go back with the <em>Previous</em> button to make changes to your
file settings and column or value mapping.';
$lang['suites_import_csv_step4_preview_empty'] = 'Empty';
$lang['suites_import_csv_step4_preview_case'] = 'Case {0}:';
$lang['suites_import_csv_step4_preview_default'] = 'Case {0}:';
$lang['suites_import_csv_step4_preview_more'] = 'And <strong class="text-softer">{0}</strong> more
{0?{test cases}:{test case}} test cases will be imported.';
$lang['suites_import_csv_step5'] = 'Imported Successfully';
$lang['suites_import_csv_step5_intro'] = 'Your CSV file was imported successfully!
TestRail added <strong class="text-softer">{0}</strong> {0?{sections}:{section}} and <strong class="text-softer">{1}</strong>
{1?{cases}:{case}}.';
$lang['suites_import_csv_step5_configuration'] =
'Download the <a id="{0}" href="javascript:void(0)">configuration file</a> of this
import for future imports.';

$lang['suites_import_sections_missing'] = 'No <sections> tag found.';
$lang['suites_import_sections_empty'] = 'No <section> tag found in <sections>.';
$lang['suites_import_sections_no_array'] = 'Invalid <section> tag found in <sections>.';
$lang['suites_import_section_no_name'] = 'No <name> tag found in <section>.';
$lang['suites_import_section_no_object'] = 'Section type in <sections> tag is not an object.';
$lang['suites_import_section_invalid'] = 'Found invalid section during import ("{0}"): {1}';
$lang['suites_import_cases_empty'] = 'No <case> tag found in <cases>.';
$lang['suites_import_case_no_title'] = 'No <title> tag found in <case>.';
$lang['suites_import_case_invalid'] = 'Found invalid test case during import ("{0}"): {1}';
$lang['suites_import_cases_no_object'] = 'Cases type in <section> tag is not an object.';
$lang['suites_import_cases_no_array'] = 'Invalid <cases> tag found in <section>.';
$lang['suites_import_case_update_no_id'] = 'Test case does not have an ID (<id> tag missing): "{0}".';
$lang['suites_import_case_update_id_invalid'] = 'Test case ID uses an invalid format ({0}).';
$lang['suites_import_case_update_no_case'] = 'Test case {0} does not exist.';
$lang['suites_import_case_update_different_suite'] = 'Test case {0} is from a different test suite and cannot be updated.';

$lang['suites_copycases'] = 'Copy or Move Cases';
$lang['suites_copycases_hint'] = 'Copy or Move Cases';
$lang['suites_copycases_hint_desc'] = 'Copies or moves sections and test cases from another test suite or project.';
$lang['suites_copycases_source'] = 'Source';
$lang['suites_copycases_source_required'] = 'The Source field is required.';
$lang['suites_copycases_sections_cases'] = 'Copy/move cases only';
$lang['suites_copycases_sections_sections'] = 'Also copy/move sections';
$lang['suites_copycases_sections_sections_all'] = 'Also copy/move sections + all parents';
$lang['suites_copycases_appendto'] = 'Append To:';
$lang['suites_copycases_intro'] = 'Please select a test suite.';
$lang['suites_copycases_cases_required'] = 'Please select at least one test case.';
$lang['suites_copycases_select'] = 'Select';
$lang['suites_copycases_select_all'] = 'All';
$lang['suites_copycases_select_none'] = 'None';
$lang['suites_copycases_invalid'] = 'Invalid arguments for copy/move cases (e.g., some cases no longer exist). Please refresh this page and try again.';
$lang['suites_copycases_self_doc'] = 'Copy or move test cases within the same suite via drag&amp;drop:';
$lang['suites_copycases_self_doc_1'] = 'Move test cases via drag&amp;drop';
$lang['suites_copycases_self_doc_2'] = 'Hold the shift key to copy test cases instead';
$lang['suites_copycases_self_doc_3'] = 'Copy or move sections in the sidebar';
$lang['suites_copycases_move_confirm'] = 'Moving the test cases will remove all their test results in active test runs (test results are not moved). This cannot be undone. Continue?';
$lang['suites_copycases_move_confirm_checkbox'] = 'Yes, move all selected cases (cannot be undone)';

$lang['suites_fallback_copy_section'] = 'Copied Test Cases';
$lang['suites_fallback_move_section'] = 'Moved Test Cases';

$lang['suites_tree_tests_not_displayed'] = '{0} more {0?{cases}:{case}} available.
Switch to <a href="{1}">compact view</a> to see all cases.';

$lang['suites_view_page_type'] = 'Page Type';
$lang['suites_view_print_format'] = 'Print View Type';
