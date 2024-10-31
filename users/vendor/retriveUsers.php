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
$sqlSelect = "SELECT * from users where type!='Admin' ORDER BY ins_id DESC;";
$result = $db->select($sqlSelect);
if (!empty($result)) {
  foreach ($result as $row) {
    $id=$row['id'];
    $img=($row['image'])?'<a onclick="lightBox(\''.$row['image'].'\')" style="cursor:pointer" title="Click to preview"><img src="'.$row['image'].'" class="img-thumbnail rounded-circle" style="width:100px;height:100px;"></a>':'No Attachments';
   
    $action='<button class="btn btn-success btn-sm" onclick="edit_user(\''.$id.'\')" title="Edit"><i class="fas fa-edit"></i></button> ';
    $action.='<button class="btn btn-danger btn-sm" onclick="delete_user(\''.$id.'\')"><i class="fas fa-trash-alt"></i></button>';
    $result = $db->select("SELECT ins_name from institutes where ins_id={$row['ins_id']}");
    $ins_name=$result[0]['ins_name'];
    $subdata=array(
      $img,
      $row['fullname'],
      $row['contact_no'],
      $row['address'],
      $row['email'],
      $row['status'],
      $ins_name,
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
