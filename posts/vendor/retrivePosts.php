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
$sqlSelect = "SELECT * from posts where ins_id='{$_SESSION['user'][4]}' and u_user='{$_SESSION['user'][3]}' ORDER BY post_id DESC;";
$result = $db->select($sqlSelect);
if (!empty($result)) {
  foreach ($result as $row) {
    $id=$row['post_id'];
    $attach="";
     $attachments=$db->select("SELECT * FROM post_attachments where post_id='{$id}'");
      if(!empty($attachments)){
          foreach ($attachments as $attachment) {
            $ext = pathinfo($attachment['attachment'], PATHINFO_EXTENSION);
            if($ext == "jpg" || $ext == "png" || $ext == "jpeg" || $ext == "gif" ){
            $attach.='<img src="'.$attachment['attachment'].'"  style="width: 80px;height: 80px;cursor:pointer;" class="img-thumbnail" onclick="lightBox(\''.$attachment['attachment'].'\')"> ';
            }
            elseif($ext=="pdf"){
            $attach.='<a href="'.$attachment['attachment'].'" target="_blank" ><img src="'.$base_url.'/assets/pdf.jpg"  style="width: 80px;height: 80px;"></a> ';
            }
          }
        }
        else{
          $attach="No Attachments";
        }
   
    $action='<button class="btn btn-success btn-sm" onclick="edit_post(\''.$id.'\')" title="Edit"><i class="fas fa-edit"></i></button> ';
    $action.='<button class="btn btn-danger btn-sm" onclick="delete_post(\''.$id.'\')"><i class="fas fa-trash-alt"></i></button>';
    if($row['u_user']!=null){
       $result = $db->select("SELECT fullname from users where id={$row['u_user']}");
    $user=$result[0]['fullname'];
    }
    else{
      $user="NULL";
    }
   
    $subdata=array(
      $row['post_heading'],
      $row['description'],
      $row['date'],
      $attach,
      $user,
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
