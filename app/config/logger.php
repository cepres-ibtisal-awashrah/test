<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

if (defined('LOG_PATH') && !defined('DEPLOY_LOG_PATH')) {
    define('DEPLOY_LOG_PATH', LOG_PATH);
} else {
    // NOP
}

$config['level'] = 0;

if (defined('DEPLOY_LOG_PATH')) {
    $config['path'] = DEPLOY_LOG_PATH;
    $config['level'] = GI_LOG_LEVEL_ERROR;

    if (defined('DEPLOY_DEBUG') && DEPLOY_DEBUG) {
        $config['level'] |= GI_LOG_LEVEL_ALL;
    } elseif (defined('DEPLOY_DEBUG_TASK') && DEPLOY_DEBUG_TASK) {
        $config['level'] |= GI_LOG_LEVEL_TASK;
    } else {
        // NOP
    }
} else {
    // NOP
}

if (defined('LOG_OUTPUT_TYPE')) {
    $config['output_type'] = LOG_OUTPUT_TYPE;
} else {
    // NOP
}

$config['levels'] = array(
    GI_LOG_LEVEL_DEBUG => 'D',
    GI_LOG_LEVEL_INFO => 'I',
    GI_LOG_LEVEL_ERROR => 'E',
    GI_LOG_LEVEL_TASK => 'T'
);
