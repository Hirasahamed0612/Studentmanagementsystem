<?php
//Prevent Direct url access to this page
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
  header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
  die( header( 'location: ../../error' ));
}
else{

if(empty($_SESSION)) // if the session not yet started 
  session_start(); 
if(!isset($_SESSION['user']) || ($_SESSION['user'][2]!="User" && $_SESSION['user'][2]!="Admin") ) { //if not yet logged in
   echo "Session expired. Please Signin again";// send to login page
   exit;
}
date_default_timezone_set('Asia/Colombo');
require_once '../../DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();
$conn->set_charset("utf8");
$table="users";
$paramArray = array(
  'fullname'=> $conn -> real_escape_string($_POST['fullname']),
  'contact_no'=>$conn -> real_escape_string($_POST['contactNo']),
  'address'=>$conn -> real_escape_string($_POST['address']),

);
$conditions=array(
  "id"=>$_SESSION['user'][3]
);
$result = $db->update($table,$paramArray,$conditions);
    if($result){
      echo 1;
      $_SESSION['user'][1]=$conn -> real_escape_string($_POST['fullname']);
    }
    else{
      echo $result;
    }


}

?>
