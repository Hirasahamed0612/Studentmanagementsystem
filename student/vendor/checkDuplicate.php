<?php
//Prevent Direct url access to this page
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
  header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
  die( header( 'location: ../error.php' ) );
}
else{
if(empty($_SESSION)) // if the session not yet started 
   session_start(); 
require_once '../DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();
$conn->set_charset("utf8");
$isAvailable=true;
$sqlSelect="";
$oldPassword="";
$password="";




if($_POST['type']=="changePassword"){
  $old=$db->select("SELECT * from students where stu_id='{$_SESSION['student'][2]}'");
    $oldPassword=$old[0]['password'];
    $password= $db->encryption($conn -> real_escape_string($_POST['oldPassword']));
}
if(!empty($sqlSelect)){
 $result = $conn->query($sqlSelect); 
}



if($_POST['type']=="changePassword"){
  
  if(!password_verify($password, $oldPassword)){
      $isAvailable = false;
  }
}
else{
  if($result->num_rows > 0){
      $isAvailable = false;
  }
}

// Finally, return a JSON
echo json_encode(array(
    'valid' => $isAvailable,
));


}

?>
