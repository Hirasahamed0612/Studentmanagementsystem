<?php
if(empty($_SESSION)) // if the session not yet started 
   session_start();

if(!isset($_SESSION['student']) ) { //if not yet logged in
   header('Location: index');// send to login page
   exit;
} 
require_once 'DataSource.php';
$db = new DataSource();
date_default_timezone_set('Asia/Colombo');
$date=date('Y-m-d');
$conn = $db->getConnection();
$conn->set_charset("utf8");
$base_url=$db->getBase(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Dashboard</title>
<?php include('layout/links-header.php');?>
</head>
<body class="py-5 mb-5 content">


  





<!-- ./wrapper -->
<?php include('layout/links-footer.php');?>
<script type="text/javascript">
navigate("<?php if(isset($_GET['menu'])) echo $_GET['menu'] ?>","<?php if(isset($_GET['id'])) echo $_GET['id'] ?>");
function navigate(menu,id){

if(menu=="home" || menu=="" ){
  if(id!=null && id!=""){
    $(".content").load("<?php echo $base_url;?>/viewPost?id="+id);
    window.history.replaceState({}, '','<?php echo $base_url;?>/dashboard?menu='+menu+"&id="+id);
  }
  else{
   $(".content").load("<?php echo $base_url;?>/home.php");
window.history.replaceState({}, '','<?php echo $base_url;?>/dashboard?menu='+menu);
  }

}
else if(menu=="exams"){
  if(id!=null && id!=""){
    $(".content").load("<?php echo $base_url;?>/viewMarks?id="+id);
    window.history.replaceState({}, '','<?php echo $base_url;?>/dashboard?menu='+menu+"&id="+id);
  }
  else{
    $(".content").load("<?php echo $base_url;?>/exams.php");
    window.history.replaceState({}, '','<?php echo $base_url;?>/dashboard?menu='+menu);
  }

}
else if(menu=="payments" ){
  if(id!=null && id!=""){
    $(".content").load("<?php echo $base_url;?>/viewPayment?id="+id);
    window.history.replaceState({}, '','<?php echo $base_url;?>/dashboard?menu='+menu+"&id="+id);
  }
  else{
    $(".content").load("<?php echo $base_url;?>/payments.php");
    window.history.replaceState({}, '','<?php echo $base_url;?>/dashboard?menu='+menu);
  }

    


}
else if(menu=="settings" ){
$(".content").load("<?php echo $base_url;?>/settings.php");
window.history.replaceState({}, '','<?php echo $base_url;?>/dashboard?menu='+menu);
}
else if(menu=="complaints" ){
$(".content").load("<?php echo $base_url;?>/complaints.php");
window.history.replaceState({}, '','<?php echo $base_url;?>/dashboard?menu='+menu);
}
else if(menu=="profile" ){
$(".content").load("<?php echo $base_url;?>/profile.php");
window.history.replaceState({}, '','<?php echo $base_url;?>/dashboard?menu='+menu);
}
else{
  $(".content").load("<?php echo $base_url;?>/error" );
  window.history.replaceState({}, '','<?php echo $base_url;?>/dashboard?menu='+menu);
}

}
</script>
</body>
</html>
