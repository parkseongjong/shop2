<?php
require_once __DIR__ . '/_common.php';
require_once __DIR__ . '/../settle_payup.inc.php';

(empty($_POST['cardNo']) === true || preg_match('/^[\d]+$/', $_POST['cardNo']) === false) && fn_ajax_output(['responseCode' => 400]);
$result = $PayUp->cardCheck($_POST['cardNo']);
fn_ajax_output($result);
