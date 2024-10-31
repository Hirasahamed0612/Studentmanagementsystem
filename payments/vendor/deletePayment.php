<?php
//Prevent Direct url access to this page
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
  header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
  die( header( 'location: ../../error' ) );
}
else{
if(empty($_SESSION)) // if the session not yet started 
   session_start(); 
require_once '../../DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();
$conn->set_charset("utf8");
$stuId=$_POST['stuId'];
$paymentId=$_POST['paymentId'];
$sqlDelete = "DELETE FROM paid_details WHERE payment_id='{$paymentId}' and stu_id='{$stuId}';";
$result = $db->delete($sqlDelete);
if (!empty($result)) { 
  echo 1;  
}
else{
  echo $result;
}


}

?>
