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
$sqlSelect = "SELECT * FROM courses WHERE c_id='$id'";
$result = $db->select($sqlSelect);
if (!empty($result)) {

    $row=array(
      "hideId"=>$result[0]['c_id'],
      "courseName"=>$result[0]['course_name'],
      "lecturer"=>$result[0]['lecturer_id'],

    );
    $data[]=$row;

  echo json_encode($data, JSON_PRETTY_PRINT);
}

}

?>
