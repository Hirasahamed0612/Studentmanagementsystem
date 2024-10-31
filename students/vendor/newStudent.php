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
$images=explode(",",$_POST['images']);
$password= $db->encryption($conn -> real_escape_string($_POST['password']));
$table="students";
$paramArray = array(
  'student_name'=>$conn -> real_escape_string($_POST['studentName']),
  'registration_no'=>$conn -> real_escape_string($_POST['registrationNo']),
  'email'=>$conn -> real_escape_string($_POST['email']),
  'password'=>password_hash($password, PASSWORD_DEFAULT),
  'image'=>($images[0])?implode(",", $images):'',
  'course_id'=>$conn -> real_escape_string($_POST['course']),
  'batch_id'=>$conn -> real_escape_string($_POST['batchId']),
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
