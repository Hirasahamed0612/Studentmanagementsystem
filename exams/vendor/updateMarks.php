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

$table="marks";
$sqlDelete = "DELETE FROM marks WHERE exam_id='{$_POST['examId']}' and stu_id='{$_POST['stuId']}';";
$result = $db->delete($sqlDelete);
    foreach ($_POST['subjects'] as $key=>$subject) {
      $paramArray = array(
        'exam_id'=>$conn -> real_escape_string($_POST['examId']),
        'stu_id'=>$conn -> real_escape_string($_POST['stuId']),
        'sub_id'=>$subject,
        'marks'=>$_POST['marks'][$key],
      );
      $paramArrays[]=$paramArray;
    }
    $result = $db->insertMulti($table,$paramArrays);

if($result){
    echo 1;
}
else{
  echo $result;
}

}

?>
