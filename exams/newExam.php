<?php
if(empty($_SESSION)) // if the session not yet started 
   session_start();

if(!isset($_SESSION['user']) || ($_SESSION['user'][2]!="User") ) { //if not yet logged in
   header('Location: ../dashboard');// send to login page
   exit;
} 
require_once '../DataSource.php';
$db = new DataSource();
date_default_timezone_set("Asia/Kolkata");
$date=date('Y-m-d');
$conn = $db->getConnection();
$conn->set_charset("utf8");
$base_url=$db->getBase(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>New Exam</title>
<?php include('../layout/links-header.php');?>
</head>
<body class="hold-transition sidebar-mini">
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
          <h4>New Exam</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Exams</li>
              <li class="breadcrumb-item active">New Exam</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card card-danger">
          <div class="card-header">
            <h3 class="card-title">New Exam</h3>
          </div>
          <div class="card-body">
             <form method="post" id="newForm" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                <label>Exam Name :</label>
                <input type="text" name="examName" class="form-control" placeholder="Exam Name">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Date :</label>
                <input type="text" name="date" class="form-control" placeholder="yyyy/mm/dd">
              </div>
            </div>
            <div class="col-md-6"> 
              <div class="form-group">
                <label>Batch :</label>
                 <select class="form-control" name="batch" id="batch">
                  <option selected disabled>Select</option>
                  <?php
                  $result=$db->select("SELECT * FROM batches where ins_id='{$_SESSION['user'][4]}' ORDER BY batch_name ASC;");
                  if (!empty($result)) {
                    foreach ($result as $row) {
                  ?>
                  <option value="<?php  echo $row['batch_id']; ?>"><?php  echo $row['batch_name']; ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-6"> 
              <div class="form-group">
                <label>Course :</label>
                 <select class="form-control" name="course" id="course" onchange="fillSubjects(this.value)">
                  <option selected disabled>Select</option>
                  <?php
                  $result=$db->select("SELECT * FROM courses where ins_id='{$_SESSION['user'][4]}' ORDER BY course_name ASC;");
                  if (!empty($result)) {
                    foreach ($result as $row) {
                  ?>
                  <option value="<?php  echo $row['c_id']; ?>"><?php  echo $row['course_name']; ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group"> 
                <label>Subjects</label>
                  <select class="select2" name="subjects[]" multiple="multiple"  style="width: 100%;"> 
                  </select>
              </div>
            </div>
        </div>
            <center>
                <button type="submit" class="btn btn-outline-success btn-block" >Create</button>
            </center>
          
          </form>
          </div>
        </div><!-- /.card -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include('../layout/sidebar-right.php');?>

<?php include('../layout/footer.php');?>
</div>
<!-- ./wrapper -->




<?php include('../layout/links-footer.php');?>
<script type="text/javascript">
var table;
var images=[];
$("#exams a:eq(0),#exams a:eq(1)").addClass("active");
$("#exams").removeClass("menu-close").addClass("menu-open");


var config={
  filebrowserBrowseUrl: '<?php echo $base_url;?>/plugins/ckfinder/ckfinder.html',
  filebrowserUploadUrl: '<?php echo $base_url;?>/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
};
function fillSubjects(course){
    $.ajax({
          url: 'vendor/fillSubjects',
          type: 'POST',
          data: {
            course:course,
          },
          beforeSend:function(){
            alertify.dismissAll();
            alertify.warning("Loading...",0);   
          },
          success: function(result) {
            alertify.dismissAll();
            $("select[name='subjects[]']").val("").change();
            $("select[name='subjects[]']").html(result);

          }

        })
        
  }
$(document).ready(function(){
  $('input[name=date]').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    autoApply:true,
    drops:'auto',
    locale: {
      format:'YYYY/MM/DD'
    },
    autoUpdateInput: false
  });
$('input[name="date"]').on('hide.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY/MM/DD')).change();
  });
  $('.select2').select2({
    placeholder:"Select Subjects",
    theme: 'bootstrap4',
    allowClear: true,
    closeOnSelect: true
  });

//form submission
    $('#newForm').bootstrapValidator({
      excluded: [':disabled'],
      feedbackIcons: false,
      live:'enabled',
      fields: {  
        examName: {
          validators: {
            notEmpty: {
              message: 'field is required'
            },
          }
        },
        date: {
          validators: {
            notEmpty: {
              message: 'field is required'
            },
          }
        },
        batch: {
          validators: {
            notEmpty: {
              message: 'field is required'
            },
          }
        },
        course: {
          validators: {
            notEmpty: {
              message: 'field is required'
            },
          }
        },
        'subjects[]': {
          validators: {
            notEmpty: {
              message: 'field is required'
            },
          }
        },       

      
      }
    }).on('success.form.bv', function(e) {
      //prevent form submission
      e.preventDefault();
      var $form = $(e.target),fv    = $form.data('formValidation');
      var data=new FormData(this);

        $.ajax({
          url: '<?php echo $base_url;?>/exams/vendor/newExam',
          type: 'POST',
          data: data,
          contentType: false,       // The content type used when sending data to the server.
          cache: false,             // To unable request pages to be cached
          processData:false, 
          beforeSend:function(){
            alertify.warning('Saving...',0);
          },
          success: function(result) {
            if(result==1){
              alertify.dismissAll();
              alertify.success("<i class='fa fa-check'></i> Saved");
              setTimeout(function(){ location.reload(); }, 500);
            }
            else{
              alert(result);
            }
          }
        })

      });


});
</script>
</body>
</html>
