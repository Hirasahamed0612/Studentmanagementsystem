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
$course=$_POST['course'];
	$selectSQL="SELECT * FROM subjects where course_id='$course'; ";
	$result=$db->select($selectSQL);
  	if (!empty($result)) {
    	foreach ($result as $row) {
      	echo "<option value='".$row['sub_id']."'>".$row['subject_name']."</option>";
    	}
  	}




}

?>
