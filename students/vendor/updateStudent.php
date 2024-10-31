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
$password= $db->encryption($conn -> real_escape_string($_POST['editPassword']));
$table="students";
$paramArray = array(
  'student_name'=>$conn -> real_escape_string($_POST['editStudentName']),
   'email'=>$conn -> real_escape_string($_POST['editEmail']),
  'registration_no'=>$conn -> real_escape_string($_POST['editRegistrationNo']),
  'course_id'=>$conn -> real_escape_string($_POST['editCourse']),
  'image'=>($images[0])?implode(",", $images):'',

);
if(!empty($conn -> real_escape_string($_POST['editPassword']))){
  $paramArray['password'] = password_hash($password, PASSWORD_DEFAULT);
}
$conditions=array(
  "stu_id"=>$_POST['hideId']
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
