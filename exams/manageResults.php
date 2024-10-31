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
<title>Results Management</title>
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
          <h4>Results Management</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Exams</li>
              <li class="breadcrumb-item active">Results Management</li>
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
            <h3 class="card-title">Results Management</h3>
          </div>
          <div class="card-body">
            <div class="d-flex ">
              <div class="form-group p-2">
                <label>Exam :</label>
                 <select class="form-control select2" name="exam" id="exam">
                  <option selected disabled>Select</option>
                  <?php
                  $result=$db->select("SELECT e.ex_id,e.exam_name,e.batch_id,e.course_id,b.batch_name FROM exams e inner join batches b on e.batch_id=b.batch_id  where e.ins_id='{$_SESSION['user'][4]}' ORDER BY e.course_id ASC;");
                  if (!empty($result)) {
                    foreach ($result as $row) {
                      $result = $db->select("SELECT course_name from courses where c_id={$row['course_id']}");
                    $course=$result[0]['course_name'];
                  ?>
                  <option value="<?php  echo $row['ex_id']; ?>" <?php  echo ($row['ex_id']==$_GET['exam_id'])?'selected':''; ?> ><?php  echo $row['exam_name'].' - '.$row['batch_name'].' - '.$course; ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
              <table id="dtTable" class="table table-bordered table-hover " style="width:100%">
                <thead>
                  <tr>
                    <th>Registration No</th>
                    <th>Student Name</th>
                    <th>Marks</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
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



<!--New Modal------------------------------------------------------->
<div class="modal fade" id="new_modal" data-backdrop="static" data-keyboard="false"    aria-labelledby="popupForm" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" id="newForm" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Marks</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" name="stuId" id="stuId"  class="d-none" placeholder="English">
         <input type="text" name="examId" id="examId" class="d-none" value="<?php echo $_GET['exam_id'];?>" placeholder="English">
         <?php
          $result = $db->select("SELECT s.subject_name,e.sub_id from exam_subjects e inner join subjects s on e.sub_id=s.sub_id where e.exam_id='{$_GET['exam_id']}';");
          foreach($result as $subject){
         ?>
        <div class="form-group">
                <label><?php echo $subject['subject_name'] ?> :</label>
                <input type="hidden" name="subjects[]" class="form-control" value="<?php echo $subject['sub_id'] ?>">
                <input type="text" name="marks[]" class="form-control" placeholder="Marks">
        </div>
      <?php } ?>
     
    </div>
     <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-success">Update</button>
      </div>
    </div>
    </form>
  </div>
</div>
<!--Delete Modal------------------------------------------------------->
<div class="modal fade" id="delete_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="popupForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Alert</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" role="alert">
          Are you sure want to delete?
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button"  id="delete_button" class="btn btn-success">Confirm</button>
      </div>
    </div>
  </div>
</div>
<?php include('../layout/links-footer.php');?>
<script type="text/javascript">
var table;
$("#exams a:eq(0),#exams a:eq(3)").addClass("active");
$("#exams").removeClass("menu-close").addClass("menu-open");
//funtion for inz table
function inz(){
 table=$('#dtTable').DataTable({
  "ajax": {
    "url": "<?php echo $base_url;?>/exams/vendor/retriveStudents",
    "type": "POST",
    "data": function ( d ) {
        d.exam= $("#exam").val();

    },
  },

    stateSave: true,
    responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return data[1];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'

                } )
            }
        },
        "ordering": false
  });
}


$("#exam").change(function(){
  window.location.href="<?php echo $base_url;?>/exams/manageResults?exam_id="+$(this).val();
})

$("#new_modal").on('hide.bs.modal', function(){
  $("#newForm")[0].reset();
  $('#newForm').bootstrapValidator('resetForm', true);
});

 //Delete Modal
function deleteMarks(stuId,examId){
    $(".modal").trigger('click');
    $('#delete_modal').modal('show'); 
    $("#delete_button").attr("onclick","delete_record("+stuId+","+examId+")")  ;      
}


//Deelete Function
function delete_record(stuId,examId){
  $.ajax({
    url: '<?php echo $base_url;?>/exams/vendor/deleteMarks',
    type: 'POST',
    data: {
      stuId:stuId,
      examId:examId
    },
    success: function(result) {
      if(result==1){
        table.ajax.reload(null,false);
        alertify.dismissAll();
        alertify.success('<i class="fa fa-check"></i> Marks Deleted');
      }
      else{
        alert(result);
      }
      $('#delete_modal').modal('hide');   
    }
  });
}



//Deelete Function

//New Modal
function updateMarks(stuId) {

      $("#stuId").val(stuId);

        $(".modal").trigger('click');
        $('#new_modal').modal('show'); 

      
    
      
          
}

$(document).ready(function(){
    $('.select2').select2({
    placeholder:"Select Exam",
    theme: 'bootstrap4',
    allowClear: true,
    closeOnSelect: true
  });
  //intialize dataTable
  inz();
  


  //form submission
    $('#newForm').bootstrapValidator({
      excluded: [':disabled'],
      feedbackIcons: false,
      live:'enabled',
      fields: {  
        'subjects[]': {
          validators: {
            notEmpty: {
              message: 'field is required'
            },
          }
        },
        'marks[]': {
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
          url: '<?php echo $base_url;?>/exams/vendor/updateMarks',
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
              table.ajax.reload(null,false);
            }
            else{
              alert(result);
            }
            $('#new_modal').modal('hide'); 
          }
        })
      });

    //form submission
    $('#editForm').bootstrapValidator({
      excluded: [':disabled'],
      feedbackIcons: false,
      live:'enabled',
      fields: {  
        editStudentName: {
          validators: {
            notEmpty: {
              message: 'field is required'
            },
          }
        },
        editRegistrationNo: {
          validators: {
            notEmpty: {
              message: 'field is required'
            },
          }
        },
        editCourse: {
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
          url: '<?php echo $base_url;?>/students/vendor/updateStudent',
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
              alertify.success("<i class='fa fa-check'></i> Updated");
              table.ajax.reload(null,false);
            }
            else{
              alert(result);
            }
            $('#edit_modal').modal('hide'); 
          }
        })
      });
});
</script>
</body>
</html>
