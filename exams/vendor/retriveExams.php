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
$base_url=$db->getBase(); 
$data=array();
$sqlSelect = "SELECT * from exams where ins_id='{$_SESSION['user'][4]}' ORDER BY course_id ASC;";
$result = $db->select($sqlSelect);
if (!empty($result)) {
  foreach ($result as $row) {
    $id=$row['ex_id'];

 
    $result = $db->select("SELECT batch_name from batches where batch_id={$row['batch_id']}");
    $batch=$result[0]['batch_name'];
    $result = $db->select("SELECT course_name from courses where c_id={$row['course_id']}");
    $course=$result[0]['course_name'];
    $result = $db->select("SELECT s.subject_name from exam_subjects e inner join subjects s on e.sub_id=s.sub_id where e.exam_id={$id}");
    $subjects=array();
    foreach($result as $sub){
      $subjects[]=$sub['subject_name'];
    }
    $action='<button class="btn btn-danger btn-sm" onclick="delete_exam(\''.$id.'\')"><i class="fas fa-trash-alt"></i></button>';
    $subdata=array(
      $row['exam_name'],
      $row['date'],
      $batch,
      $course,
      implode(",",$subjects),
      $action
    );
    $data['data'][]=$subdata;
  }

}
else{
  
  $data['data']=array();
 
}
 echo json_encode($data, JSON_PRETTY_PRINT);
}
?>
