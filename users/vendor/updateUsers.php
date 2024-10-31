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
$password= $db->encryption($conn -> real_escape_string($_POST['password']));
$table="users";
$paramArray = array(
  'fullname'=>$conn -> real_escape_string($_POST['fullname']),
  'contact_no'=>$conn -> real_escape_string($_POST['contactNo']),
  'address'=>$conn -> real_escape_string($_POST['address']),
  'email'=>$conn -> real_escape_string($_POST['email']),
  'type'=>'User',
  'status'=>'Active',
  'image'=>($images[0])?implode(",", $images):'',
  'ins_id'=>$conn -> real_escape_string($_POST['institute']),

);
if(!empty($conn -> real_escape_string($_POST['password']))){
  $paramArray['password'] = password_hash($password, PASSWORD_DEFAULT);
}
$conditions=array(
  "id"=>$_POST['hideId']
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
