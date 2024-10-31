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
$sqlSelect = "SELECT * from courses where ins_id='{$_SESSION['user'][4]}' ORDER BY c_id DESC;";
$result = $db->select($sqlSelect);
if (!empty($result)) {
  foreach ($result as $row) {
    $id=$row['c_id'];

   
    $action='<button class="btn btn-success btn-sm" onclick="edit_course(\''.$id.'\')" title="Edit"><i class="fas fa-edit"></i></button> ';
    $action.='<button class="btn btn-danger btn-sm" onclick="delete_course(\''.$id.'\')"><i class="fas fa-trash-alt"></i></button>';
    if($row['lecturer_id']!=null){
       $result = $db->select("SELECT lecturer_name from lecturers where l_id={$row['lecturer_id']}");
    $hod=$result[0]['lecturer_name'];
    }
    else{
      $hod="NULL";
    }
   
    $subdata=array(
      $row['course_name'],
       $hod,
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
