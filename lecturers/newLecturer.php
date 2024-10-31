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
<title>New Lecturer</title>
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
          <h4>New Lecturer</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Lecturers</li>
              <li class="breadcrumb-item active">New Lecturer</li>
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
            <h3 class="card-title">New Lecturer</h3>
          </div>
          <div class="card-body">
             <form method="post" id="newForm" enctype="multipart/form-data">
            <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Lecturer Name :</label>
                <input type="text" name="lecturerName" class="form-control" placeholder="Lecturer Name">
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
                <label>Contact No:</label>
                <input type="text" name="contactNo" class="form-control" placeholder="Contact No">
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
                <button type="submit" class="btn btn-outline-success btn-block" >Save</button>
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
$("#lecturers a:eq(0),#lecturers a:eq(1)").addClass("active");
$("#lecturers").removeClass("menu-close").addClass("menu-open");
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
        lecturerName: {
          validators: {
            notEmpty: {
              message: 'field is required'
            },
          }
        },
        
        contactNo: {
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
                  type:'lecEmail',
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
          url: '<?php echo $base_url;?>/lecturers/vendor/newLecturer',
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
        }
        else{
          alertify.dismissAll();
          alertify.error("<i class='fa fa-times'></i> Please select an image");
          $('#newForm').bootstrapValidator('revalidateField', 'lecturerName');
        }

      });


});
</script>
</body>
</html>
