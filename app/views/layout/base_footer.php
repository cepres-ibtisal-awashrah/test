<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

// Are we allowed to use optimized/combined versions of our javascript
// files? Note that these settings are not defined when no config.php
// is present (e.g. during the installation) and we therefore default
// to true.

$optimize_js_include_build = true;

if (defined('DEPLOY_DEVELOP') && DEPLOY_DEVELOP) {
    $optimize_js = false;
} else {
    $optimize_js = !defined('DEPLOY_OPTIMIZE_JS') || DEPLOY_OPTIMIZE_JS;
    if (defined('DEPLOY_HOSTED') && DEPLOY_HOSTED) {
        $optimize_js_include_build = false;
    }
}

// Note: JavaScript files are included at the end of the page for
// performance reasons. We currently don't use "defer" loading as we
// have seen a race condition with inline JS script blocks (e.g.
// $.datepicker.setDefaults in the header may raise an JS error
// despite being put in an actually safe $(document).ready block).
//
// Also see:
// http://developer.yahoo.com/blogs/ydn/posts/2007/07/high_performanc_5/

?>

<?php if ($optimize_js) : ?>
    <?php if ($optimize_js_include_build) : ?>
        <script type="text/javascript" src="<?php echo  r('js/extensions-combined.js?1000') ?>"></script>
        <script type="text/javascript" src="<?php echo  r('js/application-combined.js?1000') ?>"></script>
    <?php else : ?>
        <script type="text/javascript" src="<?php echo  r('js/extensions-combined.js') ?>"></script>
        <script type="text/javascript" src="<?php echo  r('js/application-combined.js') ?>"></script>
    <?php endif ?>
<?php else : ?>
    <script type="text/javascript" src="<?php echo  r('js/base64.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/jquery.blockui.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/jquery.textarearesizer.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/jquery.upload.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/jquery.ui.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/jquery.sortable.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/jquery.extensions.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/jquery.fancybox.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/jquery.bubble.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/jquery.jstree.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/jquery.tabby.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/jquery.pubsub.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/jquery.chosen.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/jquery.colorpicker.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/jquery.sticky.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/jquery.tooltip.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/jquery.hotkeys.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/jquery.clipboard.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/json2.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/dropzone.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/js.cookie.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.env.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.filters.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.users.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.page.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.controls.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.effects.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.validation.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.sections.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.dialogs.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.ajax.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.attachments.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.tables.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.cases.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.projects.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.runs.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.suites.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.site_settings.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.milestones.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.tests.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.editor.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.dropdowns.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.help.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.admin.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.plans.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.configs.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.dragdrop.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.fields.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.update.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.priorities.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.sidebar.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.defects.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.tabs.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.todos.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.install.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.statuses.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.case_statuses.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.reports.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.report_plugins.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.charts.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.dashboard.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.announcements.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.storage.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.translations.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.tooltips.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.export_csv.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.hotkeys.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.ext.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.jira.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.references.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.qpane.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.responsive.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.dropzone.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.import.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.bulk.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/md5.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.dirty_checker.js') ?>"></script>
    <script type="text/javascript" src="<?php echo  r('js/application.notification.js') ?>"></script>
	<script type="text/javascript" src="<?php echo  r('js/application.shared_steps.js') ?>"></script>
	<script type="text/javascript" src="<?php echo  r('js/autocomplete.js') ?>"></script>
	<script type="text/javascript" src="<?php echo  r('js/application.drilldown.js') ?>"></script>
<?php endif ?>

<?php
echo ViewModel::getJavaScriptDataProvider()->getFooterScripts();

if (isset($GI->load)) {
    $GI->load->view(
        'translations/js',
        [
            'translations' => [
                'timespans_hour_short',
                'timespans_minute_short',
                'timespans_second_short'
            ]
        ]
    );
}

$documentReadyInit = [];
if (!empty($page_sidebar)) {
    $documentReadyInit[] = 'App.Sidebar.init();';
}


if (!empty($page_show_announcement) && isset($GI->auth)) {
    $announcement = announcements::get_latest();
    if ($announcement) {
        $GI->load->view(
            'announcements/dialog',
            ['announcement' => $announcement]
        );
        $documentReadyInit[] = 'App.Announcements.showDialog();';
    }
}

if (
    defined('DEPLOY_HOSTED')
    && DEPLOY_HOSTED
    && ViewModel::getApplicationConfig()->getPendoAuth()->getApiKey()
    && !empty(ViewModel::getPendoUserData())
    && empty($doNotIncludePendo)
) {
    $GI->load->view('layout/pendo');
}
?>

<script>
    $(function() {
        <?php echo  join("\n", $documentReadyInit) . "\n"; ?>
        <?php
        /** @var int $characterRepeatCount */
        $characterRepeatCount = 2;
        echo SpecialCharsEnum::$EOL->value;
        foreach (ViewModel::getJavaScriptDataProvider()->getReadyScripts() ?? [] as $script) {
            echo str_repeat(
                SpecialCharsEnum::$TAB->value,
                    $characterRepeatCount
            )
            . $script->getScript()
            . SpecialCharsEnum::$EOL->value;
        }
        ?>
    });
</script>

</body>
</html>
