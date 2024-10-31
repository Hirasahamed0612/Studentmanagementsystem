<?php
//Prevent Direct url access to this page
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
  header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
  die( header( 'location: ../../error' ));
}
else{

if(empty($_SESSION)) // if the session not yet started 
  session_start(); 
if(!isset($_SESSION['user']) || ($_SESSION['user'][2]!="User" && $_SESSION['user'][2]!="Admin") ) { //if not yet logged in
   echo "Session expired. Please Signin again";// send to login page
   exit;
}
date_default_timezone_set('Asia/Colombo');
require_once '../../DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();
$conn->set_charset("utf8");
$old=$db->select("SELECT * from users where id='{$_SESSION['user'][3]}'");
$oldPassword=$old[0]['password'];
$password= $db->encryption($conn -> real_escape_string($_POST['oldPassword']));
$newPasword=$conn -> real_escape_string($_POST['newPassword']);
$confirmPasword=$conn -> real_escape_string($_POST['confirmPassword']);
if(!password_verify($password, $oldPassword)){
  echo "Old password is invalid";
  exit;
} 
if($newPasword!=$confirmPasword){
  echo "Passowrd doen't match";
  exit;
} 
$table="users";
$paramArray = array(
  'password'=> password_hash($db->encryption($newPasword), PASSWORD_DEFAULT),
);
$conditions=array(
  "id"=>$_SESSION['user'][3]
);
$result = $db->update($table,$paramArray,$conditions);
    if($result){
      echo 1;
    }
    else{
      echo $result;
    }


}

?>
