<?php
if(empty($_SESSION)) // if the session not yet started 
   session_start();
require_once 'DataSource.php';
$db = new DataSource();
date_default_timezone_set('Asia/Colombo');

$db->logOut();
?>
