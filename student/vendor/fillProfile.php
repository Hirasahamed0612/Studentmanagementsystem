<?php
//Prevent Direct url access to this page
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
  header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
  die( header( 'location: ../error' ));
}
else{
if(empty($_SESSION)) // if the session not yet started 
   session_start(); 

date_default_timezone_set('Asia/Colombo');
require_once '../DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();
$conn->set_charset("utf8");
$data=array();
$sqlSelect = "SELECT * FROM students WHERE stu_id='{$_SESSION['student'][2]}'";
$result = $db->select($sqlSelect);
 $course = $db->select("SELECT * from courses where c_id={$result[0]['course_id']}");
    $course=$course[0]['course_name'];
 // $lecturer=$db->select("SELECT * from lecturers where l_id={$course[0]['lecturer_id']}");

$batch = $db->select("SELECT batch_name from batches where batch_id={$result[0]['batch_id']}");
    $batch=$batch[0]['batch_name'];
if (!empty($result)) {
    $row=array(
      "hideId"=>$result[0]['stu_id'],
      "studentName"=>$result[0]['student_name'],
      "email"=>$result[0]['email'],
      "registrationNo"=>$result[0]['registration_no'],
      "image"=>$result[0]['image'],
      "course"=>$course,
     // "lecturer"=>$lecturer['lecturer_name'],
      "batch"=>$batch,
    );
    $data[]=$row;

  echo json_encode($data, JSON_PRETTY_PRINT);
}

}

?>
