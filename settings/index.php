<?php
if(empty($_SESSION)) // if the session not yet started 
   session_start();

if(!isset($_SESSION['user']) || ($_SESSION['user'][2]!="User" && $_SESSION['user'][2]!="Admin") ) { //if not yet logged in
   header('Location: ../index');// send to login page
   exit;
}
require_once '../DataSource.php';
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
<title>Settings</title>
<?php include('../layout/links-header.php');?>
<style type="text/css">

</style>
</head>
<body class="hold-transition sidebar-mini ">
<div class="wrapper">
	<?php include('../layout/header.php');?>
	<?php include('../layout/sidebar-left.php');?>
	<!-- Content Wrapper. Contains page content -->
	 <div class="content-wrapper">
		 <!-- Content Header (Page header) -->
	    <div class="content-header">
	      <div class="container-fluid">
	        <div class="row mb-2">
	          <div class="col-sm-6">
	            <h4>Settings</h4>
	          </div><!-- /.col -->
	          <div class="col-sm-6">
	            <ol class="breadcrumb float-sm-right">
	              <li class="breadcrumb-item"><a href="#">Home</a></li>
	              <li class="breadcrumb-item active">Settings</li>
	            </ol>
	          </div><!-- /.col -->
	        </div><!-- /.row -->
	      </div><!-- /.container-fluid -->
	    </div>
	    <!-- /.content-header -->
	    <!-- Main content -->
    	<div class="content">
    	</div>
    	<!-- /.content -->
	 </div>
  	<!-- /.content-wrapper -->
	<?php include('../layout/sidebar-right.php');?>
	<?php include('../layout/footer.php');?>
</div>
<?php include('../layout/links-footer.php');?>
<script type="text/javascript">

navigate("<?php if(isset($_GET['menu'])) echo $_GET['menu'] ?>");
function navigate(menu){
if(menu=="profile" || menu=="" ){
$(".content").load("<?php echo $base_url;?>/settings/profile.php");
}
else{
  $("body").load("<?php echo $base_url;?>/error" );
}


 

 
 
}
</script>
</body>
</html>
