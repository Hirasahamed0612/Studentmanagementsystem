<?php
//Prevent Direct url access to this page
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
  header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
  die( header( 'location: ../error' ) );
}
else{
date_default_timezone_set("Asia/Kolkata");
if(empty($_SESSION)) // if the session not yet started 
   session_start(); 
require_once '../DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();
$conn->set_charset("utf8");
$images=explode(",",$_POST['images']);
$table="students";
$paramArray = array(
  'image'=>($images[0])?implode(",", $images):'',

);
$conditions=array(
  "stu_id"=>$_SESSION['student'][2]
);

$result = $db->update($table,$paramArray,$conditions);
if($result){
  echo 1;
}
else{
  echo $result;
}

}

?>
