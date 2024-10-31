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
$id=$_POST['id'];
$data=array();
$sqlSelect = "SELECT * FROM students WHERE stu_id='$id'";
$result = $db->select($sqlSelect);
if (!empty($result)) {

    $row=array(
      "hideId"=>$result[0]['stu_id'],
      "studentName"=>$result[0]['student_name'],
      "email"=>$result[0]['email'],
      "registrationNo"=>$result[0]['registration_no'],
      "course"=>$result[0]['course_id'],
      "image"=>$result[0]['image'],

    );
    $data[]=$row;

  echo json_encode($data, JSON_PRETTY_PRINT);
}

}

?>
