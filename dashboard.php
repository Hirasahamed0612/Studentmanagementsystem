<?php
if(empty($_SESSION)) // if the session not yet started 
   session_start();

if(!isset($_SESSION['user']) ) { //if not yet logged in
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
<body class="hold-transition light-modesidebar-mini layout-fixed layout-navbar-fixed  ">
<div class="wrapper">

<?php include('layout/header.php');?>
<?php include('layout/sidebar-left.php');?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
             <h4>Dashboard</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <?php
          if(isset($_SESSION['user']) && ($_SESSION['user'][2]=="Admin") ) {
          ?>
          <div class="row">
          <?php
            $result=$db->select("SELECT * FROM institutes;");
            if (!empty($result)) {

          ?>
          <div class="col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-building"></i> </span>

              <div class="info-box-content">
                <span class="info-box-text">Institutes</span>
                <span class="info-box-number">
               <?php echo count($result);?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
            <?php  }?>
            <?php
            $result=$db->select("SELECT * FROM users;");
            if (!empty($result)) {

          ?>
          <div class="col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i> </span>

              <div class="info-box-content">
                <span class="info-box-text">Users</span>
                <span class="info-box-number">
               <?php echo count($result);?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
            <?php  }?>
        </div>
        <?php
          }
        ?>
        

        <?php
          if(isset($_SESSION['user']) && ($_SESSION['user'][2]=="User") ) {
        ?>
          <div class="row">
          <?php
            $result=$db->select("SELECT * FROM lecturers where ins_id='{$_SESSION['user'][4]}';");
            if (!empty($result)) {

          ?>
          <div class="col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas  fa-user-tie"></i> </span>

              <div class="info-box-content">
                <span class="info-box-text">Lecturers</span>
                <span class="info-box-number">
               <?php echo count($result);?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
            <?php  }?>
            <?php
            $result=$db->select("SELECT * FROM courses where ins_id='{$_SESSION['user'][4]}';");
            if (!empty($result)) {

          ?>
          <div class="col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas  fa-graduation-cap"></i> </span>

              <div class="info-box-content">
                <span class="info-box-text">Courses</span>
                <span class="info-box-number">
               <?php echo count($result);?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

            <?php  }?>
            <?php
            $result=$db->select("SELECT * FROM students where ins_id='{$_SESSION['user'][4]}';");
            if (!empty($result)) {

          ?>
          <div class="col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-book-reader"></i> </span>

              <div class="info-box-content">
                <span class="info-box-text">Students</span>
                <span class="info-box-number">
               <?php echo count($result);?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          
            <?php  }?>
            <?php
            $result=$db->select("SELECT * FROM posts where ins_id='{$_SESSION['user'][4]}';");
            if (!empty($result)) {

          ?>
          <div class="col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-comment-alt"></i> </span>

              <div class="info-box-content">
                <span class="info-box-text">Post available</span>
                <span class="info-box-number">
               <?php echo count($result);?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          
            <?php  }?>
        </div>
        <?php
          }
        ?>
       

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include('layout/sidebar-right.php');?>

<?php include('layout/footer.php');?>
</div>
<!-- ./wrapper -->
<?php include('layout/links-footer.php');?>
<script type="text/javascript">

  
  $("#dashboard").addClass("active");
</script>
</body>
</html>
