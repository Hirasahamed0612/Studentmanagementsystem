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
<title>Complaints</title>
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
          <h4>Complaints</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Complaints</li>
              <li class="breadcrumb-item active">View</li>
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
            <h3 class="card-title">Complaints</h3>
          </div>
          <div class="card-body">
              <table id="dtTable" class="table table-bordered table-hover " style="width:100%">
                <thead>
                  <tr>
                    <th>Registration No</th>
                    <th>Student Name</th>
                    <th>Complaint Heading</th>
                    <th>Description</th>
                    <th>Date & Time</th>
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
          Are you sure want to remove status?
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button"  id="delete_button" class="btn btn-success">Confirm</button>
      </div>
    </div>
  </div>
</div>

<!--New Modal------------------------------------------------------->
<div class="modal fade" id="new_modal" data-backdrop="static" data-keyboard="false"    aria-labelledby="popupForm" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" id="newForm" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Complaint</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" name="comId" id="comId"  class="d-none" placeholder="English">
      
        <div class="form-group">
    
            <select class="form-control" id="status" name="status">
              <option selected disabled value="">Select</option>
              <option value="Solved">Solved</option>
              <option value="Cancelled">Cancelled</option>
            </select>
        </div>

    </div>
     <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-success">Update</button>
      </div>
    </div>
    </form>
  </div>
</div>
<?php include('../layout/links-footer.php');?>
<script type="text/javascript">
var table;
$("#complaints").addClass("active");
//funtion for inz table
function inz(){
 table=$('#dtTable').DataTable({
  "ajax": {
    "url": "<?php echo $base_url;?>/complaints/vendor/retriveComplaints",
    "type": "POST",
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
/*
 $.ajax({
    url: '<?php echo $base_url;?>/complaints/vendor/retriveComplaints',
    type: 'POST',
    data: {
      payment:$("#payment").val(),
    },
    success: function(result) {
     alert(result)
    }
  });

*/



 //Delete Modal
function deleteComplaint(id){
    $(".modal").trigger('click');
    $('#delete_modal').modal('show'); 
    $("#delete_button").attr("onclick","delete_record("+id+")")  ;      
}


//Deelete Function
function delete_record(id){
  $.ajax({
    url: '<?php echo $base_url;?>/complaints/vendor/deleteComplaint',
    type: 'POST',
    data: {
      id:id,
    },
    success: function(result) {
      if(result==1){
        table.ajax.reload(null,false);
        alertify.dismissAll();
        alertify.success('<i class="fa fa-check"></i> Complaint Deleted');
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
function updateComplaint(comId) {

      $("#comId").val(comId);

        $(".modal").trigger('click');
        $('#new_modal').modal('show'); 

      
    
      
          
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
  //intialize dataTable
  inz();
  


  //form submission
    $('#newForm').bootstrapValidator({
      excluded: [':disabled'],
      feedbackIcons: false,
      live:'enabled',
      fields: {  

        status: {
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
          url: '<?php echo $base_url;?>/complaints/vendor/updateComplaint',
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
