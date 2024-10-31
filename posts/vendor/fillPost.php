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
$id=$_POST['id'];
$data=array();
$attachs=array();
$sqlSelect = "SELECT * FROM posts WHERE post_id='$id'";
$result = $db->select($sqlSelect);
if (!empty($result)) {
    $attachments=$db->select("SELECT attachment FROM post_attachments where post_id='{$id}'");
  if($attachments){
    foreach ($attachments as $attachment) {
      $attachs[]=$attachment['attachment'];
    }
  }
    $row=array(
      "hideId"=>$result[0]['post_id'],
      "postHeading"=>$result[0]['post_heading'],
      "description"=>$result[0]['description'],
      "date"=>$result[0]['date'],
      "attachments"=>($attachs)?implode(",", $attachs):'',

    );
    $data[]=$row;

  echo json_encode($data, JSON_PRETTY_PRINT);
}

}

?>
