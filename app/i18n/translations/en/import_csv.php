<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['import_csv_options_import'] = 'Format';
$lang['import_csv_options_file'] = 'File';
$lang['import_csv_options_layout'] = 'Layout';
$lang['import_csv_options_columns'] = 'Columns';
$lang['import_csv_options_values'] = 'Values';

$lang['import_csv_csvfile'] = 'CSV File';
$lang['import_csv_csvfile_required'] = 'Please upload your CSV file you wish to import.';
$lang['import_csv_csvfile_na'] = 'The uploaded CSV file could not be found. Please try to upload the CSV file again.';
$lang['import_csv_csvfile_size'] = 'CSV file exceeds the size limit. Please split your CSV file into multiple smaller files.';
$lang['import_csv_format'] = 'Format';
$lang['import_csv_mapfile'] = 'Configuration File';
$lang['import_csv_mapfile_required'] = 'Please upload a valid import configuration file (.cfg).';
$lang['import_csv_mapfile_na'] = 'The uploaded configuration file could not be found.';
$lang['import_csv_mapfile_size'] = 'Configuration file exceeds the size limit and is ignored.';
$lang['import_csv_mapfile_json'] = 'Configuration file is not a valid TestRail import configuration file.';
$lang['import_csv_mapfile_invalid'] = 'Configuration file invalid: {0}';

$lang['import_csv_importto'] = 'Import To';
$lang['import_csv_importto_na'] = 'Field Import To is not a valid section or may have been deleted.';
$lang['import_csv_encoding'] = 'Encoding';
$lang['import_csv_delimiter'] = 'CSV Delimiter';
$lang['import_csv_start_row'] = 'Start Row';
$lang['import_csv_has_header'] = 'Has Header';
$lang['import_csv_template'] = 'Template';
$lang['import_csv_skip_empty'] = 'Skip Empty';
$lang['import_csv_layout_format'] = 'Layout';
$lang['import_csv_layout_break'] = 'Layout Column';
$lang['import_csv_layout_break_na'] = 'You selected a multi-row layout.
Please also select the column to detect new test cases.';
$lang['import_csv_layout_break_novalue'] = 'You selected a multi-row layout but the column to detect new test cases
is empty for one or more CSV rows (column {0}). Please make sure that this column has a value for the first row
of each test case.';
$lang['import_csv_columns'] = 'Columns';
$lang['import_csv_columns_na'] = 'You need to select at least one TestRail field.';
$lang['import_csv_columns_notitle'] =
	'The Title field is a required field in TestRail and must be mapped to a CSV column.';
$lang['import_csv_columns_maxone'] = 'You can only assign a single CSV column to the TestRail field "{0}".';
$lang['import_csv_values'] = 'Values';
$lang['import_csv_values_removehtml'] = 'Remove HTML';
$lang['import_csv_values_dateformat'] = 'Date Format';
$lang['import_csv_values_dateformat_missing'] = 'Field Date Format is a required field (column {0}).';
$lang['import_csv_values_dateformat_invalid'] = 'Field Date Format is not a valid date format (column {0}).';
$lang['import_csv_values_date_invalid'] = 'A date value does not match the specified date format (column {0}: "{1}").';
$lang['import_csv_values_timespan_invalid'] = 'A timespan value does not match the supported timespan format (column {0}: "{1}").
You can specify hours, minutes and seconds using the following formats: "10h 30m", "5 minutes and 30 seconds" or simply "45s".';
$lang['import_csv_values_mapping'] = 'Mapping';
$lang['import_csv_values_title_missing'] = 'Field Title is a required field for test cases
but a test case in the CSV file (ending at record {0}) does not specify a title.';
$lang['import_csv_values_section_invalid'] = 'Section "{0}" is invalid and could not be imported: {1}';
$lang['import_csv_values_case_invalid'] = 'Test case "{0}" is invalid and could not be imported: {1}';

$lang['import_csv_column_steps_step'] = '{0} (Step)';
$lang['import_csv_column_steps_expected'] = '{0} (Expected Result)';
$lang['import_csv_column_steps_additional_info'] = '{0} (Additional Info)';
$lang['import_csv_column_steps_refs'] = '{0} (References)';
$lang['import_csv_column_steps_shared_step_id'] = '{0} (Shared Step ID)';
