<?php
//Prevent Direct url access to this page
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
  header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
  die( header( 'location: ../../error' ) );
}
else{
date_default_timezone_set("Asia/Kolkata");
if(empty($_SESSION)) // if the session not yet started 
   session_start(); 
require_once '../../DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();
$conn->set_charset("utf8");
$images=explode(",",$_POST['images']);
$table="institutes";
$paramArray = array(
  'ins_name'=>$conn -> real_escape_string($_POST['insName']),
  'district'=>$conn -> real_escape_string($_POST['district']),
  'city'=>$conn -> real_escape_string($_POST['city']),
  'address'=>$conn -> real_escape_string($_POST['address']),
  'contact_no'=>$conn -> real_escape_string($_POST['contactNo']),
  'email'=>$conn -> real_escape_string($_POST['email']),
  'image'=>($images[0])?implode(",", $images):'',

);
$conditions=array(
  "ins_id"=>$_POST['hideId']
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
