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
 
$sqlSelect = "SELECT * from complaints c inner join students s on c.stu_id=s.stu_id  where c.ins_id='{$_SESSION['user'][4]}'  ORDER BY c.timestamp DESC;";
$result = $db->select($sqlSelect);
if (!empty($result)) {
  foreach ($result as $row) {
    $id=$row['com_id'];
    if($row['status']=="Solved"){
      $status="<span class='badge bg-success'>{$row['status']}</span>";
    }
    else if($row['status']=="Cancelled"){
      $status="<span class='badge bg-danger'>{$row['status']}</span>";
    }
    else{
      $status="<span class='badge bg-warning'>{$row['status']}</span>";
    }
    
 

    $action='<button class="btn btn-danger btn-sm" onclick="deleteComplaint(\''.$id.'\')" title="Delete complaint"><i class="fas fa-trash"></i></button> ';
    $action.='<button class="btn btn-info btn-sm" onclick="updateComplaint(\''.$id.'\')" title="Update status"><i class="fas fa-edit"></i></button> ';

    $subdata=array(
      $row['student_name'],
      $row['registration_no'],
      $row['heading'],
      $row['description'],
     date('d M Y', strtotime($row['timestamp'])),
      $status,
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
