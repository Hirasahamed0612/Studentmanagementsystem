<?php
//Prevent Direct url access to this page
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
  header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
  die( header( 'location: ../error' ) );
}
else{
if(empty($_SESSION)) // if the session not yet started 
   session_start(); 

require '../plugins/PHPMailer/src/Exception.php';
require '../plugins/PHPMailer/src/PHPMailer.php';
require '../plugins/PHPMailer/src/SMTP.php';
require_once '../DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();
$conn->set_charset("utf8");
$base_url=$db->getBase(); 
//get timezone
$country=$db->select("SELECT code FROM countries  where cn_id='{$_POST['country']}';");
$timezone = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY,$country[0]['code']);
 date_default_timezone_set($timezone[0]);
$password= $db->encryption($conn -> real_escape_string($_POST['password']));
$code=$db->encryption($conn -> real_escape_string($_POST['email']));
$table="users";
$paramArray = array(
  'firstname'=>$conn -> real_escape_string($_POST['firstname']),
  'lastname'=>$conn -> real_escape_string($_POST['lastname']),
  'display_name'=>$conn -> real_escape_string($_POST['firstname'])." ".$conn -> real_escape_string($_POST['lastname']) ,
  'email'=>$conn -> real_escape_string($_POST['email']),
  'type'=>'User',
  'password'=>password_hash($password, PASSWORD_DEFAULT),
  'code'=>$code,
  'status'=>'Pending',
  'image'=>'default.png',
  'theme'=>'light',
  'timezone'=>$timezone[0],
  'timestamp'=>date('Y-m-d H:i:s'),
);

$result = $db->insert($table,$paramArray);

if($result){
$paramArray = array(
  'user_id'=>$result,
  'country'=>$conn -> real_escape_string($_POST['country']),
  'timestamp'=>date('Y-m-d H:i:s'),
);
$db->insert("personal_details",$paramArray);
  $subject="Account Verification";
  $body=<<<EOT
  <h3>This message from $base_url</h3><br>
  <a href='$base_url/setup/confirm/$code'>Click here</a> to active your account <br>
  EOT;
  $db->sendNotification($subject,$body,$conn -> real_escape_string($_POST['email']));
  echo 1;
}
else{
  echo $result;
}

}

?>
