<?php
if(empty($_SESSION)) // if the session not yet started 
   session_start();

if(!isset($_SESSION['user']) || ($_SESSION['user'][2]!="User") ) { //if not yet logged in
  // header('Location: ../dashboard');// send to login page
   //exit;
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
<title>New Post</title>
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
          <h4>New Post</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Posts</li>
              <li class="breadcrumb-item active">New Post</li>
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
            <h3 class="card-title">New Post</h3>
          </div>
          <div class="card-body">
             <form method="post" id="newForm" enctype="multipart/form-data">
            <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Post Heading :</label>
                <input type="text" name="postHeading" class="form-control" placeholder="Post Heading">
              </div>
            </div>
            <div class="col-md-12"> 
              <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control" name="description" id="description" > 
              </div>
            </div>
            <div class="col-md-6"> 
              <div class="form-group"> 
                <label>Date</label>
                <input type="text" name="date" class="form-control" placeholder="yyyy/mm/dd">
              </div>
            </div>
            <div class="col-md-6"> 
              <div class="form-group"> 
                <label>Attachments</label>
               <button class="btn btn-outline-dark btn-block" onclick="clickFunction()" style="border-radius: 50px;" type="button"><i class="fas fa-image" ></i> Select Attachments</button>
              </div>
            </div>
            <div class="col-md-12" id="imgPreview" ></div>

        </div>
        <br>
            <center>
                <button type="submit" class="btn btn-outline-success btn-block" >Upload</button>
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
$("#posts a:eq(0),#posts a:eq(1)").addClass("active");
$("#posts").removeClass("menu-close").addClass("menu-open");
function lightBox(image){
  var items=[];
  var index="";
  for(var x=0;x<images.length;x++){
    if(images[x]==image){
      index=x;
    }
    items.push({src: images[x]}); 
  }
  var options = {index: index  };
  new PhotoViewer(items, options);
}
function clickFunction(){
  selectFileWithCKFinder( );
}
function selectFileWithCKFinder( ) {
  CKFinder.modal( {
    selectmultiple:true,
    chooseFiles: true,
    width: 800,
    height: 600,
    onInit: function( finder ) {
      finder.on( 'files:choose', function( evt ) {
        images.splice(0,images.length);
         $("#imgPreview").html("");
        var files = evt.data.files;
        files.forEach( function( file, i ) {
          extension = file.getUrl().split('.').pop();
        if(extension=="jpg" || extension=="jpeg" || extension=="png" || extension=="PNG"){
          images.push(file.getUrl());
          $("#imgPreview").append("<img style='width:100px;height:100px;cursor:pointer;' class='img-fluid img-thumbnail' src='"+file.getUrl()+"'  onclick='lightBox(\""+file.getUrl()+"\")'> &nbsp;&nbsp;"); 
        }
        else if(extension=="pdf"){
          images.push(file.getUrl());
          $("#imgPreview").append("<a href='"+file.getUrl()+"'><img style='width:100px;height:100px;cursor:pointer;' class='img-fluid img-thumbnail' src='<?php echo $base_url;?>/assets/pdf.jpg'></a> &nbsp;&nbsp;");
        }
        else{
          alert("Invalid File Type Detected"); 
        }

        } );
        
      } );

      finder.on( 'file:choose:resizedImage', function( evt ) {
        alert("triggered");
        $("#imgPreview").append("<img style='width:100px;height:100px;cursor:pointer' class='img-fluid img-thumbnail' src='"+evt.data.resizedUrl+"' onclick='lightBox(\""+evt.data.resizedUrl+"\")'> &nbsp;&nbsp;"); 
      } );
    }
  } );
}

var config={
  filebrowserBrowseUrl: '<?php echo $base_url;?>/plugins/ckfinder/ckfinder.html',
  filebrowserUploadUrl: '<?php echo $base_url;?>/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
};

$(document).ready(function(){

CKFinder.setupCKEditor( CKEDITOR.replace( 'description' ,config) );
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

//form submission
    $('#newForm').bootstrapValidator({
      excluded: [':disabled'],
      feedbackIcons: false,
      live:'enabled',
      fields: {  
        postHeading: {
          validators: {
            notEmpty: {
              message: 'field is required'
            },
          }
        },
        date: {
          trigger:'change',
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
      data.append('images', String(images));
      data.append("description",CKEDITOR.instances['description'].getData())
        $.ajax({
          url: '<?php echo $base_url;?>/posts/vendor/newPost',
          type: 'POST',
          data: data,
          contentType: false,       // The content type used when sending data to the server.
          cache: false,             // To unable request pages to be cached
          processData:false, 
          beforeSend:function(){
            alertify.warning('Uploading...',0);
          },
          success: function(result) {
            if(result==1){
              alertify.dismissAll();
              alertify.success("<i class='fa fa-check'></i> Uploaded");
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
