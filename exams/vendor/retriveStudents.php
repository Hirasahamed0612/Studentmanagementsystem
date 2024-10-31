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
if(!empty($_POST['exam'])){
   
$result = $db->select("SELECT * from exams where ex_id='{$_POST['exam']}';");
$sqlSelect = "SELECT * from students where batch_id='{$result[0]['batch_id']}' and course_id='{$result[0]['course_id']}' ORDER BY student_name ASC;";
$result = $db->select($sqlSelect);
if (!empty($result)) {
  foreach ($result as $row) {
    $id=$row['stu_id'];
    $marks = $db->select("SELECT s.subject_name,m.marks from marks m inner join subjects s on m.sub_id=s.sub_id where m.exam_id='{$_POST['exam']}' and m.stu_id='{$id}';");
    $rs="";
    if (!empty($marks)) {
    foreach($marks as $mark){
      $rs.="{$mark['subject_name']} : {$mark['marks']}<br>";
    }
    $status="<span class='badge bg-success'>Uploaded</span>";
    }
    else{
      $status="<span class='badge bg-danger'>Not yet</span>";
    }
    $action='<button class="btn btn-success btn-sm" onclick="updateMarks(\''.$id.'\')" title="Update marks"><i class="fas fa-upload"></i></button> ';
    $action.='<button class="btn btn-danger btn-sm" onclick="deleteMarks(\''.$id.'\',\''.$_POST['exam'].'\')" title="Delete marks"><i class="fas fa-trash"></i></button> ';


    $subdata=array(
      $row['student_name'],
      $row['registration_no'],
      $rs,
      $status,
      $action
    );
    $data['data'][]=$subdata;
  }

}
else{
  
  $data['data']=array();
 
}
}
else{
   $data['data']=array();
}
 echo json_encode($data, JSON_PRETTY_PRINT);
}


?>
