<?php
//Prevent Direct url access to this page
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
  header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
  die( header( 'location: ../../error' ) );
}
else{
date_default_timezone_set("Asia/Colombo");
if(empty($_SESSION)) // if the session not yet started 
   session_start(); 
require_once '../../DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();
$conn->set_charset("utf8");
$date = ($conn -> real_escape_string($_POST['date']))?date('Y-m-d',strtotime($conn -> real_escape_string($_POST['date']))):'0000-00-00';
$table="payments";
$paramArray = array(
  'payment_name'=>$conn -> real_escape_string($_POST['paymentName']),
  'description'=>$conn -> real_escape_string($_POST['description']),
  'due_date'=>$date,
  'amount'=>$conn -> real_escape_string($_POST['amount']),
  'batch_id'=>$conn -> real_escape_string($_POST['batch']),
  'course_id'=>$conn -> real_escape_string($_POST['course']),
  'ins_id'=>$_SESSION['user'][4],

);
$result = $db->insert($table,$paramArray);
if($result){
  echo 1;
}
else{
  echo $result;
}

}

?>
