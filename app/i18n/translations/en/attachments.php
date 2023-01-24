<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$lang['attachments_attachment'] = 'Attachment';
$lang['attachments_title'] = 'Attachments';
$lang['attachments_noattachments'] = 'No attachments.';
$lang['attachments_file'] = 'File';
$lang['attachments_file_desc'] = 'Choose the file to upload.';
$lang['attachments_image'] = 'Image';
$lang['attachments_image_desc'] = 'Choose the image to upload.';
$lang['attachments_add'] = 'Add Attachment';
$lang['attachments_attach_file'] = 'Attach file';
$lang['attachments_attach'] = 'Attach';
$lang['attachments_addimage'] = 'Add Images';
$lang['attachments_confirm_delete'] = 'This <strong>deletes selected instances of your attachments.</strong> The files will keep on being stored on your Library. Go to Attachments on Data Storage to delete permanently.';
$lang['attachments_confirm_delete_admin'] = 'This action <strong>deletes selected attachment/s and all their instances across your projects</strong> (except those on closed Test Runs & Plans) permanently. This cannot be undone. Do you wish to continue?';
$lang['attachments_error_exists'] = 'The attachment does not exist or you do not have the permission to access it.';
$lang['attachments_error_in_progress'] = 'The attachment migration process is in progress.';
$lang['attachments_error_required'] = 'The File field is required.';
$lang['attachments_error_partial'] = 'Attachment was only partially uploaded.';
$lang['attachments_error_nodir'] = 'No attachments directory configured.';
$lang['attachments_error_noaccess'] = 'Attachments directory is not writable.';
$lang['attachments_error_rename'] = 'An error occurred while renaming the attachment.';
$lang['attachments_error_in_use'] = 'Cannot delete an attachment that is still in use.';
$lang['attachments_denied_add'] = 'You are not allowed to add attachments (insufficient permissions).';
$lang['attachments_denied_add_storage_limit'] = 'Your TestRail instance is out of space. Case Fields can no longer be added, attachments cannot be uploaded and data exports will not be allowed until your instance is back inside the allowed limit for your subscription. Please refer to our https://www.ideracorp.com/Legal/Gurock/DataStoragePolicy.';
$lang['attachments_denied_edit'] = 'You are not allowed to edit attachments (insufficient permissions).';
$lang['attachments_denied_delete'] = 'You are not allowed to delete attachments (insufficient permissions).';
$lang['attachments_denied_replace'] = 'You are not allowed to repalce attachments (insufficient permissions).';
$lang['attachments_denied_rename'] = 'You are not allowed to rename attachments (insufficient permissions).';
$lang['attachments_element'] = 'Element';
$lang['attachments_error_malicious_file'] = 'It is restricted to upload malicious file';

$lang['attachments_drop'] = 'Drop files here to attach, or click to browse.';
$lang['attachments_drop_image'] = 'Drop images here to embed, or click to browse.';
$lang['attachments_drop_image_nobrowse'] = 'Drop images here to embed.';
$lang['attachments_drop_notype'] = 'You can only add images to this text field (example: PNG or JPG files).';
$lang['attachments_drop_notype_canattach'] = 'You can only add images to this text field (example: PNG or JPG files). You can attach other file types to a case or result from the sidebar or result dialogs.';
$lang['attachments_drop_notype_canattach_jira'] = 'You can only add images to this text field (example: PNG or JPG files).';

$lang['attachments_remove_image'] = 'Remove';
$lang['attachments_delete'] = 'Delete';
$lang['attachments_delete_dont_show_again'] = 'Don’t show me this again';

$lang['attachments_screenshot_take_mac'] = 'How to take a screenshot on your Mac:';
$lang['attachments_screenshot_take_win'] = 'How to take a screenshot on Windows:';
$lang['attachments_screenshot_paste'] = 'Then paste it:';

$lang['attachments_upload_idp_certificate'] = 'Upload IDP Certificate';
$lang['attachments_upload_file'] = 'Upload File';
$lang['attachments_file_here'] = 'Drop file here, or click to browse.';
$lang['attachments_file_desc'] = 'Choose the file to upload.';

$lang['attachments_not_found'] = 'Attachments were not found.';

$lang['attachments_overview_orderby'] = 'Order By';
$lang['attachments_overview_filter'] = 'Filter';

$lang['attachments_filter_type'] = 'Type';
$lang['attachments_filter_createdon'] = 'Upload date';
$lang['attachments_filter_owner'] = 'Created by';
$lang['attachments_filter_case'] = 'Case';
$lang['attachments_filter_run'] = 'Run';
$lang['attachments_filter_plan'] = 'Plan';
$lang['attachments_filter_milestone'] = 'Milestone';
$lang['attachments_filter_project'] = 'Project';
$lang['attachments_filter_orphaned'] = 'Orphaned';

$lang['attachments_add_file'] = 'Attach file';
$lang['attachments_confirm_replace'] = 'This action <strong>replaces current attachment with selected one. This will refresh all attachment’s instances across your projects</strong> (except those on closed Runs & Plans). This cannot be undone. Do you wish to continue?';
$lang['attachments_replace_title'] = 'Replace?';
$lang['attachments_loading_error_title'] = 'Loading error';
$lang['attachments_loading_error_generic'] = '<strong>An unexpected uploading error occurred.</strong><br><br>Try again!';

$lang['attachments_library_title'] = 'Files Library';
$lang['attachments_library_media_title'] = 'Media Library';
$lang['attachments_library_add_new'] = 'Add New';
$lang['attachments_library_delete'] = 'Delete';
$lang['attachments_library_replace'] = 'Replace';
$lang['attachments_library_sort'] = 'Sort:';
$lang['attachments_library_sort_date'] = 'Date';
$lang['attachments_library_sort_name'] = 'Name';
$lang['attachments_library_sort_size'] = 'Size';
$lang['attachments_library_filter'] = 'Filter:';
$lang['attachments_library_filter_none'] = 'None';
$lang['attachments_library_dropzone_text_drop'] = 'Drop files here to upload, or';
$lang['attachments_library_dropzone_text_select'] = 'Select Files';
$lang['attachments_library_dropzone_text_info'] = 'Maximum file size: 256 MB.';
$lang['attachments_library_size_info_1'] = 'Size of attachments: <strong><span id="filteredAttachmentsSize"></span></strong>.';
$lang['attachments_library_size_info_2'] = '<a target="_blank" href="https://www.gurock.com/testrail/docs/user-guide">Learn more about your storage limits.</a>';

$lang['attachments_dialog_info'] = 'Maximum file size: 256 MB.';

$lang['attachment_info_title'] = 'Attachment Details';
$lang['attachment_info_type'] = 'File Type';
$lang['attachment_info_size'] = 'Size';
$lang['attachment_info_uploaded_on'] = 'Uploaded on';
$lang['attachment_info_url'] = 'URL';
$lang['attachment_info_accessible_in'] = 'Accessible in';
$lang['attachment_info_full_image'] = 'Full Resolution';
$lang['attachment_info_download'] = 'Download';
$lang['attachment_info_done'] = 'Done';
$lang['attachment_info_all_projects'] = 'All Projects';

$lang['attachment_entity_list_dropzone'] = 'Drop files here to attach,<br />or click on &quot;+&quot; to browse';

$lang['attachment_delete_mode_info'] = '(Click and hold to enter delete mode)';

$lang['attachment_info_currently_being_upgraded'] = 'Your attachments are currently being upgraded.';
$lang['attachment_info_edit_delete_disabled'] = 'Edit and delete functions are temporarily disabled until the migration process is completed.';