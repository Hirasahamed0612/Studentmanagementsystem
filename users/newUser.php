<?php
if(empty($_SESSION)) // if the session not yet started 
   session_start();

if(!isset($_SESSION['user']) || ($_SESSION['user'][2]!="Admin") ) { //if not yet logged in
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
<title>New User</title>
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
          <h4>New User</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
              <li class="breadcrumb-item active">New User</li>
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
            <h3 class="card-title">New User</h3>
          </div>
          <div class="card-body">
             <form method="post" id="newForm" enctype="multipart/form-data">
            <div class="row">
            <div class="col-md-12"> 
              <div class="form-group">
                <label>Select Institute :</label>
                 <select class="form-control" name="institute" id="institute">
                  <option selected disabled>Select Institute</option>
                  <?php
                  $result=$db->select("SELECT * FROM institutes ORDER BY ins_id ASC;");
                  if (!empty($result)) {
                    foreach ($result as $row) {
                  ?>
                  <option value="<?php  echo $row['ins_id']; ?>"><?php  echo $row['ins_name']; ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Fullname:</label>
                <input type="text" name="fullname" class="form-control" placeholder="Fullname">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Contact No:</label>
                <input type="text" name="contactNo" class="form-control" placeholder="Contact No">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Address:</label>
                <input type="text" name="address" class="form-control" placeholder="Address">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email" class="form-control" placeholder="Email">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" placeholder="Password">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Confirm Pasword:</label>
                <input type="password" name="confirmPassword" class="form-control" placeholder="Confirm Password">
              </div>
            </div>
            
            

            <div class="col-md-12"> 
              <div class="form-group"> 
                <label>Image</label>
               <button class="btn btn-outline-dark btn-block" onclick="clickFunction()" style="border-radius: 50px;" type="button"><i class="fas fa-image" ></i> Select Image</button>
              </div>
            </div>
            <div class="col-md-12" id="imgPreview" ></div>
            </div>
            <br>
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
$("#users a:eq(0),#users a:eq(1)").addClass("active");
$("#users").removeClass("menu-close").addClass("menu-open");
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
        var file = evt.data.files.first();
        extension = file.getUrl().split('.').pop();
        if(extension=="jpg" || extension=="jpeg" || extension=="png" || extension=="PNG"){
          images.push(file.getUrl());
          $("#imgPreview").html("<img style='width:100px;height:100px;cursor:pointer;' class='img-fluid img-thumbnail' src='"+file.getUrl()+"'  onclick='lightBox(\""+file.getUrl()+"\")'> &nbsp;&nbsp;"); 
        }
        else{
          alert("Invalid File Type"); 
        }
      } );

      finder.on( 'file:choose:resizedImage', function( evt ) {
        alert("triggered");
        $("#imgPreview").html("<img style='width:100px;height:100px;cursor:pointer' class='img-fluid img-thumbnail' src='"+evt.data.resizedUrl+"' onclick='lightBox(\""+evt.data.resizedUrl+"\")'> &nbsp;&nbsp;"); 
      } );
    }
  } );
}
function lightBox(image){
  var items=[];
  var index="";
  for(var x=0;x<images.length;x++){
    if(images[x]==image){
      index=x;
    }
    items.push({src: images[x]}); 
  }
  var options = {index: 0};
  new PhotoViewer(items, options);
}
var config={
  filebrowserBrowseUrl: '<?php echo $base_url;?>/plugins/ckfinder/ckfinder.html',
  filebrowserUploadUrl: '<?php echo $base_url;?>/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
};
$(document).ready(function(){



//form submission
    $('#newForm').bootstrapValidator({
      excluded: [':disabled'],
      feedbackIcons: false,
      live:'enabled',
      fields: {  
        institute: {
          validators: {
            notEmpty: {
              message: 'field is required'
            },
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
                  type:'userEmail',
                };
              },  
              message: 'Email address already in use',
              url: '<?php echo $base_url;?>/vendor/checkDuplicate'
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
          url: '<?php echo $base_url;?>/users/vendor/newUser',
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
              alertify.success("<i class='fa fa-check'></i> User Created");
              setTimeout(function(){ location.reload(); }, 500);
            }
            else{
              alert(result);
            }
          }
        })
        }
        else{
          alertify.dismissAll();
          alertify.error("<i class='fa fa-times'></i> Please select an image");
          $('#newForm').bootstrapValidator('revalidateField', 'fullname');
        }

      });


});
</script>
</body>
</html>
