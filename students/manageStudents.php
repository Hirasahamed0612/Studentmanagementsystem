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
<title>Student Management</title>
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
          <h4>Student Management</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Students</li>
              <li class="breadcrumb-item active">Student Management</li>
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
            <h3 class="card-title">Student Management</h3>
          </div>
          <div class="card-body">
            <div class="d-flex ">
              <div class="form-group p-2">
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
              <div class="form-group p-2 align-self-center">
                <br>
                <button class="btn btn-primary " onclick="addStudent($('#batch').val())">Add Student</button>
              </div>
            </div>
              <table id="dtTable" class="table table-bordered table-hover " style="width:100%">
                <thead>
                  <tr>
                    <th>Image</th>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Registration No</th>
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
        <span class="text-danger">All details(Payment,Marks) related to this student will be deleted</span>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" name="batchId" id="batchId" class="d-none" placeholder="English">
        <div class="form-group">
                <label>Registration No :</label>
                <input type="text" name="registrationNo" class="form-control" placeholder="Registration No">
        </div>
        <div class="form-group">
                <label>Student Name :</label>
                <input type="text" name="studentName" class="form-control" placeholder="Student Name">
        </div>
        <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email" class="form-control" placeholder="Email">
              </div>
        <div class="form-group ">
            <label>Course :</label>
              <select class="form-control" name="course" id="course">
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
              

              <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" placeholder="Password">
              </div>


              <div class="form-group">
                <label>Confirm Pasword:</label>
                <input type="password" name="confirmPassword" class="form-control" placeholder="Confirm Password">
              </div>
              <div class="form-group"> 
                <label>Image</label>
               <button class="btn btn-outline-dark btn-block" onclick="clickFunction()" style="border-radius: 50px;" type="button"><i class="fas fa-image" ></i> Select Image</button>
              </div>

            <div class="col-md-12 imgPreview " id="imgPreview" ></div>

     
    </div>
     <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-success">Create</button>
      </div>
    </div>
    </form>
  </div>
</div>

<!--Edit Modal------------------------------------------------------->
<div class="modal fade" id="edit_modal" data-backdrop="static" data-keyboard="false"  aria-labelledby="popupForm1" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <form method="post" id="editForm" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Edit</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" name="hideId" id="hideId" class="d-none" placeholder="English">
            
              
              <div class="form-group">
                <label>Student Name :</label>
                <input type="text" name="editStudentName" class="form-control" placeholder="Student Name">
              </div>
           <div class="form-group">
            <input type="hidden" name="oldEmail" id="oldEmail" class="form-control" placeholder="Email">
                <label>Email:</label>
                <input type="text" name="editEmail" class="form-control" placeholder="Email">
              </div>
            
              <div class="form-group">
                <label>Registration No :</label>
                <input type="text" name="editRegistrationNo" class="form-control" placeholder="Registration No">
              </div>
          

              <div class="form-group">
                <label>Course :</label>
                 <select class="form-control" name="editCourse" id="editCourse">
                  <option selected disabled>Select</option>
                  <?php
                  $result=$db->select("SELECT * FROM courses where ins_id='{$_SESSION['user'][4]}' ORDER BY c_id ASC;");
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

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="editPassword" class="form-control" placeholder="Password">
              </div>


              <div class="form-group">
                <label>Confirm Pasword:</label>
                <input type="password" name="editConfirmPassword" class="form-control" placeholder="Confirm Password">
              </div>
              <div class="form-group"> 
                <label>Image</label>
               <button class="btn btn-outline-dark btn-block" onclick="clickFunction()" style="border-radius: 50px;" type="button"><i class="fas fa-image" ></i> Select Image</button>
              </div>

            <div class="col-md-12 imgPreview" id="imgPreview" ></div>

     
     
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
var images=[];
$("#students a:eq(0),#students a:eq(3)").addClass("active");
$("#students").removeClass("menu-close").addClass("menu-open");
//funtion for inz table
function inz(){
 table=$('#dtTable').DataTable({
  "ajax": {
    "url": "<?php echo $base_url;?>/students/vendor/retriveStudents",
    "type": "POST",
    "data": function ( d ) {
        d.batch= $("#batch").val();

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
function clickFunction(){
  selectFileWithCKFinder( );
}
function selectFileWithCKFinder( ) {
  CKFinder.modal( {
    chooseFiles: true,
    width: 800,
    height: 600,
    onInit: function( finder ) {
      finder.on( 'files:choose', function( evt ) {
        images.splice(0,images.length);

        var file = evt.data.files.first();
        extension = file.getUrl().split('.').pop();
        if(extension=="jpg" || extension=="jpeg" || extension=="png" || extension=="PNG"){
          images.push(file.getUrl());
          $(".imgPreview").html("<img style='width:100px;height:100px;cursor:pointer;' class='img-fluid img-thumbnail' src='"+file.getUrl()+"'  onclick='lightBox(\""+file.getUrl()+"\")'> &nbsp;&nbsp;"); 
        }
        else{
          alert("Invalid File Type"); 
        }
      } );

      finder.on( 'file:choose:resizedImage', function( evt ) {
        alert("triggered");
        $(".imgPreview").html("<img style='width:100px;height:100px;cursor:pointer' class='img-fluid img-thumbnail' src='"+evt.data.resizedUrl+"' onclick='lightBox(\""+evt.data.resizedUrl+"\")'> &nbsp;&nbsp;"); 
      } );
    }
  } );
}
function lightBox(image){
  var items=[];
  var index="";
  if(images.length>0){
    for(var x=0;x<images.length;x++){
      if(images[x]==image){
        index=x;
      }
      items.push({src: images[x]}); 
    }
     var options = {index: index};
  }
  else{
    items.push({src: image}); 
    var options = {index: 0};
  }
 
  new PhotoViewer(items, options);
}
var config={
  filebrowserBrowseUrl: '<?php echo $base_url;?>/plugins/ckfinder/ckfinder.html',
  filebrowserUploadUrl: '<?php echo $base_url;?>/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
};

$("#batch").change(function(){
 table.ajax.reload(null,false);
})

$("#new_modal").on('hide.bs.modal', function(){
  $("#newForm")[0].reset();
  $('#newForm').bootstrapValidator('resetForm', true);
  $(".imgPreview").html("");
  images.splice(0,images.length);

});
$("#edit_modal").on('hide.bs.modal', function(){
  $("#editForm")[0].reset();
  $('#editForm').bootstrapValidator('resetForm', true);
$(".imgPreview").html("");
  images.splice(0,images.length);
});
 
//Delete Modal
function delete_student(id){
    $(".modal").trigger('click');
    $('#delete_modal').modal('show'); 
    $("#delete_button").attr("onclick","delete_record("+id+")")  ;      
}


//Deelete Function
function delete_record(id){
  $.ajax({
    url: '<?php echo $base_url;?>/students/vendor/deleteStudent',
    type: 'POST',
    data: {
      id:id
    },
    success: function(result) {
      if(result==1){
        table.ajax.reload(null,false);
        alertify.dismissAll();
        alertify.success('<i class="fa fa-check"></i> Student Deleted');
      }
      else{
        alert(result);
      }
      $('#delete_modal').modal('hide');   
    }
  });
}
//New Modal
function addStudent(batch) {
    if(batch!=null){
      $("#batchId").val(batch);
      $(".modal").trigger('click');
      $('#new_modal').modal('show'); 
    }
    else{
        alertify.error('<i class="fa fa-times"></i> Please select the batch');
    }
      
          
}
//Edit Modal
function edit_student(id) {
    
    $.ajax({
      type:'POST',
      url: '<?php echo $base_url;?>/students/vendor/fillStudent',
      dataType: "json",
      data:{
        id:id,
      },
      success: function(data) { 
        var row=data;
        $("#hideId").val(row[0].hideId);
        $("input[name=editStudentName]").val(row[0].studentName);
        $("input[name=editRegistrationNo]").val(row[0].registrationNo);
        $("select[name=editCourse]").val(row[0].course);
        $("input[name=editEmail]").val(row[0].email);
        $("input[name=oldEmail]").val(row[0].email);
        if(row[0].image!=""){
          images.push(row[0].image);
         $(".imgPreview").html("<img style='width:100px;height:100px;cursor:pointer' class='img-fluid img-thumbnail' src='"+row[0].image+"'  onclick='lightBox(\""+row[0].image+"\")'> &nbsp;&nbsp;");
        }

         
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
    $('#newForm').bootstrapValidator({
      excluded: [':disabled'],
      feedbackIcons: false,
      live:'enabled',
      fields: {  
        studentName: {
          validators: {
            notEmpty: {
              message: 'field is required'
            },
          }
        },
        registrationNo: {
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

        email: {
          validators: {
            notEmpty: {
              message: 'field is required'
            },
            regexp: {
              regexp: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
              message: 'Invalid Email'
            },
            remote: {
              type:'POST',
              data:function(validator) {
                return {
                  type:'stuEmail',
                };
              },  
              message: 'Email address already in use',
              url: '<?php echo $base_url;?>/vendor/checkDuplicate'
            }
          }
        },
        password: {
          validators: {
            notEmpty: {
              message: 'Please enter the password'
            },
            identical: {
              field: 'confirmPassword',
              message: "The password doesn't match"
            },
            regexp: {
                regexp: RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})"),
                message: 'Password strength is low'
            }
          }
        },
        confirmPassword: {
          validators: {
            notEmpty: {
              message: 'Please enter the password'
            },
            identical: {
              field: 'password',
              message: "The password doesn't match"
            }
          }
        },

      }
    }).on('success.form.bv', function(e) {
      //prevent form submission
      e.preventDefault();
      var $form = $(e.target),fv    = $form.data('formValidation');
      var data=new FormData(this);
      data.append('images', String(images));
      if(images.length>0){
    
        $.ajax({
          url: '<?php echo $base_url;?>/students/vendor/newStudent',
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
      }
      else{
          alertify.dismissAll();
          alertify.error("<i class='fa fa-times'></i> Please select an image");
          $('#newForm').bootstrapValidator('revalidateField', 'email');
        }
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
        editEmail: {
          validators: {
            notEmpty: {
              message: 'field is required'
            },
            regexp: {
              regexp: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
              message: 'Invalid Email'
            },
            remote: {
              type:'POST',
              data:function(validator) {
                return {
                  type:'stuUEmail',
                  oldEmail:$("#oldEmail").val()
                };
              },  
              message: 'Email address already in use',
              url: '<?php echo $base_url;?>/vendor/checkDuplicate'
            }
          }
        },
        editPassword: {
          validators: {
            identical: {
              field: 'editConfirmPassword',
              message: "The password doesn't match"
            },
            regexp: {
                regexp: RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})"),
                message: 'Password strength is low'
            }
          }
        },
        editConfirmPassword: {
          validators: {
            identical: {
              field: 'editPassword',
              message: "The password doesn't match"
            }
          }
        },

      }
    }).on('success.form.bv', function(e) {
      //prevent form submission
      e.preventDefault();
      var $form = $(e.target),fv    = $form.data('formValidation');
      var data=new FormData(this);
        data.append('images', String(images));
      if(images.length>0){
    
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
        }
      else{
          alertify.dismissAll();
          alertify.error("<i class='fa fa-times'></i> Please select an image");
          $('#editForm').bootstrapValidator('revalidateField', 'editEmail');
        }
      });
});
</script>
</body>
</html>
