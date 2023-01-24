<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['system_version_mismatch'] = 'Your installation was updated to TestRail {0} but this page still runs the previous version. Please refresh this page.';

$lang['system_install_required'] = 'The installation of your TestRail installation has not been finished. Please contact a TestRail administrator to finish the installation process.';

$lang['system_update_required'] = 'A TestRail update has been installed but the database hasn\'t been updated yet. Please contact a TestRail administrator to run the database update.';
$lang['system_update_hosted'] = 'The database of your hosted TestRail installation is too old but cannot be updated manually.';
$lang['system_db_newer'] = 'Your TestRail installation requires an older database version (version {0} or less required, but found {1}). Please install the TestRail version that matches your database version or contact the Gurock Software support in case you have any questions.';

$lang['system_js_test'] = 'JavaScript Test';
$lang['system_page_initial'] = 'Initial Load';
$lang['system_env_na_hosted'] = 'This endpoint or API function is not supported on this TestRail platform (Hosted/Cloud).';
$lang['system_env_na_server'] = 'This endpoint or API function is not supported on this TestRail platform (Server).';

$lang['system_updated_by'] = 'Updated By';
$lang['system_updated_on'] = 'Updated On';
$lang['system_force_update'] = 'Force Update';

$lang['system_browser_title'] = 'Your browser is not supported';
$lang['system_browser_header'] = 'Sorry, your browser is not supported.';
$lang['system_browser_intro'] = 'TestRail is a modern web application and uses the latest technology.
Unfortunately, your browser is a bit outdated and not supported by TestRail.
Please upgrade to a modern web browser such as Chrome, Firefox, Safari or newer versions of
Internet Explorer (10 or later).';
$lang['system_browser_show_ua'] = 'Show my browser information';

#Your TestRail license will expire on <date>. Please contact a TestRail administrator or extend your license by contacting the Gurock Software support team for a quote.
$lang['system_license_expires_enterprise'] = 'Your TestRail license will expire on <strong class="text-softer">{0}</strong>.
Please contact a TestRail administrator or extend your license by contacting the 
<a target="_blank" href="https://secure.gurock.com/customers/support/">Gurock Software support team</a> for a quote.';

$lang['system_license_expires'] = 'Your TestRail license will expire on <strong class="text-softer">{0}</strong>.
Please contact a TestRail administrator or extend your license with your
<a target="_blank" href="https://secure.gurock.com/customers/portal/licenses/">Gurock Software customer account</a>.';
$lang['system_license_nosupport'] = '<strong>Your current license key indicates that your support plan has expired on {0}</strong>.
You are not eligible to install new version or update to the new version and please <a href="https://secure.gurock.com/portal/" target="_blank">renew your support plan</a>.
If you\'ve already renewed the support plan, please make sure to apply the new license key.';
$lang['system_lock_page_title'] = 'TestRail instance is locked';
$lang['system_lock_page_description'] = '<strong>Your current license key indicates that your support plan has expired on {0}</strong>.
Please <a href="https://secure.gurock.com/portal/" target="_blank">renew your support plan</a>.
If you\'ve already renewed the support plan, please make sure to apply the new license key.';
