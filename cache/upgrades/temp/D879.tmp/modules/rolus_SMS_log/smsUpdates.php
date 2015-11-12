<?php

global $db;

$target_module = 'rolus_SMS_log';
$class = $GLOBALS['beanList'][$target_module];
require_once($GLOBALS['beanFiles'][$class]);

$GLOBALS['log']->debug("update sms file =>");
$GLOBALS['log']->debug(print_r($_REQUEST,1));

$SMS = new rolus_SMS_log();
$status = $_REQUEST['SmsStatus'];
$reference_id = $_REQUEST['SmsSid'];

$SMS->updateStatus($reference_id,$status);

?>