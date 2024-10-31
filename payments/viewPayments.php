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
<title>View Payments</title>
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
          <h4>View Payments</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Payments</li>
              <li class="breadcrumb-item active">View Payments</li>
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
            <h3 class="card-title">View Payments</h3>
          </div>
          <div class="card-body">
              <table id="dtTable" class="table table-bordered table-hover " style="width:100%">
                <thead>
                  <tr>
                    <th>Payments Name</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                    <th>Batch</th>
                    <th>Course</th>
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
$("#payments a:eq(0),#payments a:eq(2)").addClass("active");
$("#payments").removeClass("menu-close").addClass("menu-open");
//funtion for inz table
function inz(){
 table=$('#dtTable').DataTable({
  "ajax": {
    "url": "<?php echo $base_url;?>/payments/vendor/retrivePayments",
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






 
//Delete Modal
function delete_payment(id){
    $(".modal").trigger('click');
    $('#delete_modal').modal('show'); 
    $("#delete_button").attr("onclick","delete_record("+id+")")  ;      
}


//Deelete Function
function delete_record(id){
  $.ajax({
    url: '<?php echo $base_url;?>/payments/vendor/deletePayment1',
    type: 'POST',
    data: {
      id:id
    },
    success: function(result) {
      if(result==1){
        table.ajax.reload(null,false);
        alertify.dismissAll();
        alertify.success('<i class="fa fa-check"></i> Payment Deleted');
      }
      else{
        alert(result);
      }
      $('#delete_modal').modal('hide');   
    }
  });
}


$(document).ready(function(){
   
  //intialize dataTable
  inz();
  



});
</script>
</body>
</html>
