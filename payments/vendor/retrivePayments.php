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
$sqlSelect = "SELECT * from payments where ins_id='{$_SESSION['user'][4]}' ORDER BY course_id ASC;";
$result = $db->select($sqlSelect);
if (!empty($result)) {
  foreach ($result as $row) {
    $id=$row['payment_id'];

 
    $result = $db->select("SELECT batch_name from batches where batch_id={$row['batch_id']}");
    $batch=$result[0]['batch_name'];
    $result = $db->select("SELECT course_name from courses where c_id={$row['course_id']}");
    $course=$result[0]['course_name'];

    $action='<button class="btn btn-danger btn-sm" onclick="delete_payment(\''.$id.'\')"><i class="fas fa-trash-alt"></i></button>';
    $subdata=array(
      $row['payment_name'],
      $row['description'],
      $row['due_date'],
      "Rs. ".$row['amount'],
      $batch,
      $course,
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
