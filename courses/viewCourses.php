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
<title>View Courses</title>
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
          <h4>View Courses</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Courses</li>
              <li class="breadcrumb-item active">View Courses</li>
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
            <h3 class="card-title">View Courses</h3>
          </div>
          <div class="card-body">
              <table id="dtTable" class="table table-bordered table-hover " style="width:100%">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Head of Course</th>
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
        <span class="text-danger">All subjects related to this course will be deleted</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button"  id="delete_button" class="btn btn-success">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!--Edit Modal------------------------------------------------------->
<div class="modal fade" id="edit_modal" data-backdrop="static" data-keyboard="false"  aria-labelledby="popupForm" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <form method="post" id="editForm" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" name="hideId" id="hideId" class="d-none" placeholder="English">
            <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                <label>Course Name :</label>
                <input type="text" name="courseName" class="form-control" placeholder="Course Name">
              </div>
            </div>
            <div class="col-md-6"> 
              <div class="form-group">
                <label>Head of Course :</label>
                 <select class="form-control" name="lecturer" id="lecturer">
                  <option selected disabled>Select</option>
                  <?php
                  $result=$db->select("SELECT * FROM lecturers where ins_id='{$_SESSION['user'][4]}' ORDER BY l_id ASC;");
                  if (!empty($result)) {
                    foreach ($result as $row) {
                  ?>
                  <option value="<?php  echo $row['l_id']; ?>"><?php  echo $row['lecturer_name']; ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
            </div>

        </div>
     
    </div>
     <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit"  id="delete_button" class="btn btn-success">Update</button>
      </div>
    </form>
  </div>
</div>

<?php include('../layout/links-footer.php');?>
<script type="text/javascript">
var table;
$("#courses a:eq(0),#courses a:eq(2)").addClass("active");
$("#courses").removeClass("menu-close").addClass("menu-open");
//funtion for inz table
function inz(){
 table=$('#dtTable').DataTable({
  "ajax": {
    "url": "<?php echo $base_url;?>/courses/vendor/retriveCourses",
    "type": "POST"
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




$("#edit_modal").on('hide.bs.modal', function(){
  $("#editForm")[0].reset();
  $('#editForm').bootstrapValidator('resetForm', true);

});

 
//Delete Modal
function delete_course(id){
    $(".modal").trigger('click');
    $('#delete_modal').modal('show'); 
    $("#delete_button").attr("onclick","delete_record("+id+")")  ;      
}


//Deelete Function
function delete_record(id){
  $.ajax({
    url: '<?php echo $base_url;?>/courses/vendor/deleteCourse',
    type: 'POST',
    data: {
      id:id
    },
    success: function(result) {
      if(result==1){
        table.ajax.reload(null,false);
        alertify.dismissAll();
        alertify.success('<i class="fa fa-check"></i> Course Deleted');
      }
      else{
        alert(result);
      }
      $('#delete_modal').modal('hide');   
    }
  });
}
//Edit Modal
function edit_course(id) {
    
    $.ajax({
      type:'POST',
      url: '<?php echo $base_url;?>/courses/vendor/fillCourse',
      dataType: "json",
      data:{
        id:id,
      },
      success: function(data) { 
        var row=data;
        $("#hideId").val(row[0].hideId);
        $("input[name=courseName]").val(row[0].courseName);
        $("select[name=lecturer]").val(row[0].lecturer);

         
      },
      complete:function(){ 
        $(".modal").trigger('click');
        $('#edit_modal').modal('show'); 
      }
    });      
}

$(document).ready(function(){
   
  //intialize dataTable
  inz();
  


  //form submission
    $('#editForm').bootstrapValidator({
      excluded: [':disabled'],
      feedbackIcons: false,
      live:'enabled',
      fields: {  
        courseName: {
          validators: {
            notEmpty: {
              message: 'field is required'
            },
          }
        },
        lecturer: {
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
          url: '<?php echo $base_url;?>/courses/vendor/updateCourse',
          type: 'POST',
          data: data,
          contentType: false,       // The content type used when sending data to the server.
          cache: false,             // To unable request pages to be cached
          processData:false, 
          beforeSend:function(){
            alertify.warning('Updating...',0);
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
