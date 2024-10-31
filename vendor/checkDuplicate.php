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

if($_POST['type']=="insEmail"){
    $email = $conn -> real_escape_string($_POST['email']);
    $sqlSelect="SELECT * from institutes where email='$email';";
}
if($_POST['type']=="insUEmail"){
 
    $oldEmail=$_POST['oldEmail'];
    $email = $conn -> real_escape_string($_POST['email']);
    $sqlSelect="SELECT * from institutes where email!='$oldEmail' and email='$email';";
}

if($_POST['type']=="userEmail"){
    $email = $conn -> real_escape_string($_POST['email']);
    $sqlSelect="SELECT * from users where email='$email';";
}
if($_POST['type']=="userUEmail"){
 
    $oldEmail=$_POST['oldEmail'];
    $email = $conn -> real_escape_string($_POST['email']);
    $sqlSelect="SELECT * from users where email!='$oldEmail' and email='$email';";
}

if($_POST['type']=="lecEmail"){
    $email = $conn -> real_escape_string($_POST['email']);
    $sqlSelect="SELECT * from lecturers where email='$email';";
}
if($_POST['type']=="lecUEmail"){
 
    $oldEmail=$_POST['oldEmail'];
    $email = $conn -> real_escape_string($_POST['email']);
    $sqlSelect="SELECT * from lecturers where email!='$oldEmail' and email='$email';";
}


if($_POST['type']=="stuEmail"){
    $email = $conn -> real_escape_string($_POST['email']);
    $sqlSelect="SELECT * from students where email='$email';";
}
if($_POST['type']=="stuUEmail"){
 
    $oldEmail=$_POST['oldEmail'];
    $email = $conn -> real_escape_string($_POST['editEmail']);
    $sqlSelect="SELECT * from students where email!='$oldEmail' and email='$email';";
}


if($_POST['type']=="changePassword"){
  $old=$db->select("SELECT * from users where id='{$_SESSION['user'][3]}'");
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
