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
$table="exams";
$paramArray = array(
  'exam_name'=>$conn -> real_escape_string($_POST['examName']),
   'date'=>$date,
  'batch_id'=>$conn -> real_escape_string($_POST['batch']),
  'course_id'=>$conn -> real_escape_string($_POST['course']),
  'ins_id'=>$_SESSION['user'][4],

);
$result = $db->insert($table,$paramArray);
if($result){
$exam_id=$result;
//insert organization category and sub categories
  $table="exam_subjects";
  foreach ($_POST['subjects'] as $subject) {
    $paramArray = array(
      'exam_id'=>$exam_id,
      'sub_id'=>$conn -> real_escape_string($subject),
    );
    $paramArrays[]=$paramArray;

  }
  //insert exam subjects
  $result=$db->insertMulti($table,$paramArrays);
  

  echo 1;
}
else{
  echo $result;
}

}

?>
