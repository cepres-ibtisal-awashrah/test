<?php

if (php_sapi_name() != 'cli' || isset($_SERVER['REMOTE_ADDR'])) {
    // The background task is not allowed to be run via browser. It
    // should only be started via command line.
    die('Access denied.');
}

@set_time_limit(0);
define('STARTED_WITH_CLI', true);
$_GET['tasks'] = true; // Set the controller to invoke

// Check for environment variables/options that can influence the
// runtime behavior of the task and set them as defines, if found.
$envs = array(
    'DEPLOY_INSTANCE_ID',
    'DEPLOY_HOSTNAME',
    'DEPLOY_INSTALLATION_URL',
    'DEPLOY_ATTACHMENT_PATH',
    'DEPLOY_BACKUP_PATH',
    'DEPLOY_CUSTOM_PATH',
    'DEPLOY_EXPORT_PATH',
    'DEPLOY_LOG_PATH',
    'LOG_OUTPUT_TYPE',
    'DEPLOY_REQUEST_HOSTED',
    'DEPLOY_REPORT_PATH',
    'DEPLOY_DEBUG',
    'DEPLOY_DEBUG_TASK',
    'DEPLOY_PROXY_HOST',
    'DEPLOY_PROXY_PORT',
    'DB_DRIVER',
    'DB_HOSTNAME',
    'DB_DATABASE',
    'DB_USERNAME',
    'DB_PASSWORD',
    'CASSANDRA_HOSTNAME',
    'CASSANDRA_PORT',
    'CASSANDRA_KEYSPACE',
    'CASSANDRA_USERNAME',
    'CASSANDRA_PASSWORD',
    'RABBITMQ_HOST',
    'RABBITMQ_PORT',
    'RABBITMQ_USER',
    'RABBITMQ_PASSWORD',
    'RABBITMQ_USE_SSL',
    'DEPLOY_TASK_REMOVE_ATTACHMENTS_INTERVAL',
    'DEPLOY_TASK_REMOVE_ATTACHMENTS_REMOVAL_TIME_INTERVAL',
    'DEPLOY_LICENSE_ENTERPRISE',
    'ATTACHMENT_SIZE',
    'DATABASE_SIZE',
    'STORAGE_HARD_LIMIT',
    'STORAGE_SOFT_LIMIT',
    'ENTERPRISE_STORAGE_HARD_LIMIT',
    'ENTERPRISE_STORAGE_SOFT_LIMIT',
    'DEPLOY_LICENSE_INSTANCE_ID',
    'DEPLOY_LICENSE_ACCOUNT',
    'DEPLOY_LICENSE_ACCOUNT_TYPE',
    'APPLICATION_CONFIG',
    'DEPLOY_LICENSE_PAYMENT_TYPE',
    'DEPLOY_LICENSE_SUBSCRIPTION_EXPIRATION_DATE',
    'DEPLOY_LICENSE_CAN_RENEW_ONLINE',
    'META_INTERNAL_SERVICE_HOST',
    'META_API_KEY'
);

foreach ($envs as $env) {
    $value = getenv($env);
    if ($value !== false) {
        $jsonValue = json_decode($value, true);
        define(
            $env,
            json_last_error() === 0
                ? $jsonValue
                : $value
        );
    }
}

// And finally include the standard index.php of TestRail
require_once dirname(__FILE__) . '/' . 'index.php';
