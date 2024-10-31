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
$sqlSelect = "SELECT * FROM users WHERE id='$id'";
$result = $db->select($sqlSelect);
if (!empty($result)) {

    $row=array(
      "hideId"=>$result[0]['id'],
      "institute"=>$result[0]['ins_id'],
      "fullname"=>$result[0]['fullname'],
      "contactNo"=>$result[0]['contact_no'],
      "address"=>$result[0]['address'],
      "email"=>$result[0]['email'],
      "image"=>$result[0]['image'],
    );
    $data[]=$row;

  echo json_encode($data, JSON_PRETTY_PRINT);
}

}

?>