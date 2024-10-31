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
$images=explode(",",$_POST['images']);
$date = ($conn -> real_escape_string($_POST['date']))?date('Y-m-d',strtotime($conn -> real_escape_string($_POST['date']))):'0000-00-00';
$table="posts";
$paramArray = array(
  'post_heading'=>$conn -> real_escape_string($_POST['postHeading']),
  'description'=>$conn -> real_escape_string($_POST['description']),
  'date'=>$date,
  'u_timestamp'=>date('Y-m-d H:i:s'),
  'u_user'=>$_SESSION['user'][3],
  'ins_id'=>$_SESSION['user'][4],

);


$result = $db->insert($table,$paramArray);
if($result){
  if($images[0]){
    $table="post_attachments";
    foreach ($images as $image) {
      $paramArray = array(
        'post_id'=>$result,
        'attachment'=>$image,
      );
      $paramArrays[]=$paramArray;
    }
    $result = $db->insertMulti($table,$paramArrays);
    echo 1;
  }
  else{
    echo 1;
  }
}
else{
  echo $result;
}

}

?>
