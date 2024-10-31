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

$table="subjects";
$paramArray = array(
  'subject_name'=>$conn -> real_escape_string($_POST['subjectName']),
  'course_id'=>$conn -> real_escape_string($_POST['courseId']),

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
