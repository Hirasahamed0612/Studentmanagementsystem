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
$table="paid_details";
$sqlDelete = "DELETE FROM paid_details WHERE payment_id='{$_POST['paymentId']}' and stu_id='{$_POST['stuId']}';";
$result = $db->delete($sqlDelete);

      $paramArray = array(
        'payment_id'=>$conn -> real_escape_string($_POST['paymentId']),
        'stu_id'=>$conn -> real_escape_string($_POST['stuId']),
        'paid_date'=>$date,
        'status'=>$conn -> real_escape_string($_POST['status']),
        'u_user'=>$_SESSION['user'][3],
        'u_timestamp'=>date('Y-m-d H:i:s'),
        
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
