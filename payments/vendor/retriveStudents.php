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
if(!empty($_POST['payment'])){
   
$result = $db->select("SELECT * from payments where payment_id='{$_POST['payment']}';");
$sqlSelect = "SELECT * from students where batch_id='{$result[0]['batch_id']}' and course_id='{$result[0]['course_id']}' ORDER BY student_name ASC;";
$result = $db->select($sqlSelect);
if (!empty($result)) {
  foreach ($result as $row) {
    $id=$row['stu_id'];
    $status = $db->select("SELECT * from paid_details  where payment_id='{$_POST['payment']}' and stu_id='{$id}' and status='Paid';");
    if (!empty($status)){ 

  
    $status="<span class='badge bg-success'>Paid</span>";
    }
    else{
      $status = $db->select("SELECT * from paid_details  where payment_id='{$_POST['payment']}' and stu_id='{$id}' and status='Cancelled';");
      if (!empty($status)){ 
      $status="<span class='badge bg-danger'>Cancelled</span>";
      }
      else{
        $status="<span class='badge bg-warning'>Not yet</span>";
      }
    }
    
    $action='<button class="btn btn-success btn-sm" onclick="updatePayment(\''.$id.'\')" title="Update payment"><i class="fas fa-credit-card"></i></button> ';
    $action.='<button class="btn btn-danger btn-sm" onclick="deletePayment(\''.$id.'\',\''.$_POST['payment'].'\')" title="Delete marks"><i class="fas fa-trash"></i></button> ';

     

    $subdata=array(
      $row['student_name'],
      $row['registration_no'],
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
