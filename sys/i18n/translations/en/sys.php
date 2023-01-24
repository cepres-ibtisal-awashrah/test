<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$lang['args_invalid_method'] = 'Unsupported HTTP method "{0}" for this action.';
$lang['args_invalid_param'] = 'Invalid parameter in rule "{0}".';

$lang['cache_callback_missing'] = 'Internal error: no callback for type "{0}".';
$lang['cache_callback_noobject'] = 'No object of type "{0}" with ID "{1}".';

$lang['csv_unexpected'] = 'Invalid CSV: Unexpected character at position {0} ("{1}"). Expected end of cell but text found.';

$lang['db_config_missing'] = 'No database configuration found.';
$lang['db_config_incomplete'] = 'Database configuration incomplete.';
$lang['db_no_transaction'] = 'No transaction in progress to call commit or rollback.';
$lang['db_unknown_type'] = 'Unsupported database type in SQL query.';
$lang['db_no_single_row_query'] = 'The database result has more than one row.';
$lang['db_no_result_resource'] = 'The SQL statement did not return a result.';
$lang['db_no_limit'] = 'Limit is required when specifying offset.';
$lang['db_unknown_column'] = 'The specified column is not available in the result.';
$lang['db_unknown_isolation_level'] = 'The specified isolation level is unknown.';
$lang['db_unknown_error'] = 'An unknown error occurred during the last database operation.';
$lang['db_unknown_driver'] = 'Unsupported database driver "{0}".';

$lang['filecheck_open_error'] = 'Could not open file check list: {0}';
$lang['filecheck_line_invalid'] = 'Invalid format at line {0} in file check list.';
$lang['filecheck_md5_error'] = 'Could not compute checksum for file "{0}": {1}. Please make sure that the file can be read by the web server (permissions). You can also try to copy the TestRail files again (please make sure to stop your web server before).';
$lang['filecheck_checksum_invalid'] = 'Invalid checksum for file "{0}" ({1}). Please make sure that the file can be read by the web server (permissions). You can also try to copy the TestRail files again (please make sure to stop your web server before).';

$lang['files_copy_error'] = 'Could not copy {0} to {1}: {2}';
$lang['files_temp_error'] = 'Could not create temporary file or directory: {0}';
$lang['files_open_error'] = 'Could not open file {0}: {1}';
$lang['files_opendir_error'] = 'Could not open directory {0}: {1}';
$lang['files_mkdir_error'] = 'Could not create directory {0}: {1}';
$lang['files_put_error'] = 'Could not write content to file {0}: {1}';
$lang['files_delete_error'] = 'Could not delete file or directory {0}: {1}';
$lang['files_rename_error'] = 'Could not rename file or directory {0} to {1}: {2}';
$lang['files_read_error'] = 'Could not read file: {0}';
$lang['files_link_error'] = 'Could not link file: {0}';
$lang['files_chmod_error'] = 'Could not change file or directory access: {0}';

$lang['http_incomplete_proxy_response'] = 'Incomplete response from proxy server';

$lang['icons_bmp'] = 'Bitmap Image';
$lang['icons_default'] = 'Other File';
$lang['icons_doc'] = 'Word Document';
$lang['icons_docx'] = 'Word Document';
$lang['icons_exe'] = 'Application';
$lang['icons_gif'] = 'Gif Image';
$lang['icons_jpg'] = 'Jpeg Image';
$lang['icons_jpeg'] = 'Jpeg Image';
$lang['icons_log'] = 'Log File';
$lang['icons_pdf'] = 'PDF Document';
$lang['icons_png'] = 'Png Image';
$lang['icons_ppt'] = 'PowerPoint Document';
$lang['icons_pptx'] = 'PowerPoint Document';
$lang['icons_odp'] = 'Open Office Impress';
$lang['icons_ods'] = 'Open Office Calc';
$lang['icons_odt'] = 'Open Office Writer';
$lang['icons_tif'] = 'Tiff Image';
$lang['icons_tiff'] = 'Tiff Image';
$lang['icons_htm'] = 'Html Document';
$lang['icons_html'] = 'Html Document';
$lang['icons_sil'] = 'SmartInspect Log File';
$lang['icons_txt'] = 'Text Document';
$lang['icons_xhtml'] = 'Html Document';
$lang['icons_xls'] = 'Excel Document';
$lang['icons_xlsx'] = 'Excel Document';
$lang['icons_xml'] = 'Xml Document';
$lang['icons_zip'] = 'Zip Document';

$lang['ini_invalid_format'] = 'Invalid INI format at line {0}.';
$lang['ini_group_empty'] = 'Empty group at line {0}.';
$lang['ini_key_missing'] = 'Missing key at line {0}.';

$lang['pagination_prev'] = 'Prev';
$lang['pagination_next'] = 'Next';

$lang['security_hash_na'] = 'The authentication method your password was secured with is not available on this server.
This situation can happen if your installation was moved to a different server.
Please reset your password on the Forgot Password page.';

$lang['session_no_config'] = 'No settings configured for session handling.';
$lang['session_not_active'] = 'There is no active session for the current user.';

$lang['sizes_gb'] = '{0}G';
$lang['sizes_mb'] = '{0}M';
$lang['sizes_kb'] = '{0}K';
$lang['sizes_by'] = '{0}B';

$lang['timespans_second_short'] = 's';
$lang['timespans_minute_short'] = 'm';
$lang['timespans_hour_short'] = 'h';
$lang['timespans_day_short'] = 'd';
$lang['timespans_week_short'] = 'w';
$lang['timespans_second'] = 'second';
$lang['timespans_minute'] = 'minute';
$lang['timespans_hour'] = 'hour';
$lang['timespans_day'] = 'day';
$lang['timespans_week'] = 'week';
$lang['timespans_seconds'] = 'seconds';
$lang['timespans_minutes'] = 'minutes';
$lang['timespans_hours'] = 'hours';
$lang['timespans_days'] = 'days';
$lang['timespans_weeks'] = 'weeks';
$lang['timespans_ignore_words'] = 'and und et y';

$lang['translations_unknown'] = 'Unknown language file "{0}".';

$lang['uploads_error_maxsize'] = 'No file attached or upload size was exceeded.';
$lang['uploads_error_nofile'] = 'No attachment or file uploaded.';
$lang['uploads_error_notemp'] = 'No temporary directory available or configured.';
$lang['uploads_error_catchall'] = 'An error occurred while uploading the file.';

$lang['validation_no_rules_controller'] = 'No validation rules file found for controller "{0}".';
$lang['validation_no_rules_method'] = 'No validation rules found for method "{0}".';
$lang['validation_values_missing'] = 'Internal error: no values for validation.';
$lang['validation_callback_missing'] = 'Internal error: no callback for type "{0}".';
$lang['validation_format_missing'] = 'Internal error: unknown format "{0}".';
$lang['validation_optional_missing'] = 'Internal error: no include rule found for field "{0}".';
$lang['validation_null'] = 'Field {0} cannot be null.';
$lang['validation_bool'] = 'Field {0} is not a valid boolean.';
$lang['validation_color'] = 'Field {0} is not in a valid color format (hexadecimal RGB representation).';
$lang['validation_date'] = 'Field {0} is not in a valid date format.';
$lang['validation_date_format'] = 'Field {0} is not a valid date format.
You need to specify a day (d or dd), month (M or MM) and year (yy or yyyy).';
$lang['validation_dir'] = 'Field {0} is not a valid directory.';
$lang['validation_dir_writable'] = 'Field {0} is not a valid (writable) directory. Please either create the directory or adjust its permissions.';
$lang['validation_enum'] = 'Field {0} is not a supported enum value ("{1}").';
$lang['validation_email'] = 'Field {0} is not a valid email address.';
$lang['validation_column'] = 'Field {0} is not a valid field identifier.';
$lang['validation_file'] = 'Field {0} is not a valid file.';
$lang['validation_file_writable'] = 'Field {0} is not a valid (writable) file.';
$lang['validation_lang'] = 'Field {0} is not a valid system language.';
$lang['validation_locale'] = 'Field {0} is not a valid system locale.';
$lang['validation_integer'] = 'Field {0} is not a valid integer.';
$lang['validation_natural'] = 'Field {0} is not a valid natural number.';
$lang['validation_number_min'] = 'Field {0} is too small (minimum {1}).';
$lang['validation_number_max'] = 'Field {0} is too large (maximum {1}).';
$lang['validation_number_in'] = 'Field {0} is invalid option (available options {1}).';
$lang['validation_url'] = 'Field {0} is not a valid URL.';
$lang['validation_ip'] = 'Field {0} is not a valid IP address.';
$lang['validation_required'] = 'Field {0} is a required field.';
$lang['validation_string'] = 'Field {0} is not a valid string.';
$lang['validation_string_max'] = 'Field {0} is too long ({1} characters at most).';
$lang['validation_string_min'] = 'Field {0} is too short ({1} characters required).';
$lang['validation_string_utf8'] = 'Field {0} is not a valid UTF-8 character sequence.';
$lang['validation_timespan'] = 'Field {0} is not in a valid time span format.';
$lang['validation_timespan_millisecond_less'] = 'Field {0} is less than a millisecond.';
$lang['validation_timezone'] = 'Field {0} is not a valid system time zone.';
$lang['validation_id'] = 'Field {0} is not a valid ID.';
$lang['validation_ids'] = 'Field {0} is not a valid ID list.';
$lang['validation_json'] = 'Field {0} is not a valid JSON array.';
$lang['validation_array'] = 'Field {0} is not a valid array.';
$lang['validation_csv'] = 'Field {0} is not a valid CSV list.';
$lang['validation_encoding'] = 'Field {0} is not a valid string encoding.';

$lang['zip_no_extension'] = 'The ZIP helper requires the zip PHP extension which has not yet been installed.';
$lang['zip_open_error'] = 'Could not create ZIP file (error code: {0})';
$lang['zip_close_error'] = 'Could not close ZIP file.';
$lang['zip_opendir_error'] = 'Could not open directory: {0}';
$lang['zip_addfile_error'] = 'Could not add file to ZIP file (file may not exist or insufficient permissions): {0}';
