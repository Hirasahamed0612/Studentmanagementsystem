<?php
if(empty($_SESSION)) // if the session not yet started 
   session_start();

if(!isset($_SESSION['student']) ) { //if not yet logged in
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






<?php include('layout/header.php');?>
<div class="container">
   <h2>My Profile </h2>
      <hr>
      <div class="row">
        <div class="col-md-12">
          <form method="post" id="profileForm" enctype="multipart/form-data">
            <div class="d-flex flex-row">
              <div class="" id="imgPreview" ></div>
            <div class="">
              <button class="btn btn-primary " onclick="clickFunction()" style="border-radius: 50px;" type="button"><i class="fas fa-image" ></i> Change Image</button>
            </div>
            </div>
            
          <div class="form-group">
            <label>Fullname</label>
            <input type="text" id="studentName" disabled name="studentName" class="form-control form-control-lg" placeholder="*Fullname" required >
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="text" disabled id="email" name="email" class="form-control form-control-lg" placeholder="*Email" required >
          </div>
          <div class="form-group">
            <label>Registration No</label>
            <input type="text" disabled id="registrationNo" name="registrationNo" class="form-control form-control-lg" placeholder="*Registration No" required >
          </div>
          <div class="form-group">
            <label>Course</label>
            <input type="text" id="course" disabled name="course" class="form-control form-control-lg" placeholder="*Course" required >
          </div>
          <div class="form-group">
            <label>Batch</label>
            <input type="text" id="batch"  disabled name="batch" class="form-control form-control-lg" placeholder="*Batch" required >
          </div>
          <!--<div class="form-group">
            <label>Head of Course</label>
            <input type="text" id="lecturer"  disabled name="lecturer" class="form-control form-control-lg" placeholder="*Head Of Course" required >
          </div>-->

          <button class="btn btn-primary btn-block" type="submit">Save</button>
          </form>
        </div>
      </div>


</div>
  



<?php include('layout/footer.php');?>


<script type="text/javascript">
$("#navTitle").text("Profile");
var images=[];
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
          images.splice(0,images.length);
          images.push(file.getUrl());
          $("#imgPreview").html("<img style='width:100px;height:100px;cursor:pointer' class='img-fluid img-thumbnail' src='"+file.getUrl()+"' onclick='lightBox(\""+file.getUrl()+"\")'> &nbsp;&nbsp;"); 
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
function load(){
$.ajax({
      type:'POST',
      url: '<?php echo $base_url;?>/vendor/fillProfile',
      dataType: "json",
      success: function(data) { 
       // alert(data)
        var row=data;
        $("#studentName").val(row[0].studentName);
        $("#email").val(row[0].email);
        $("#registrationNo").val(row[0].registrationNo);
        $("#course").val(row[0].course);
        $("#batch").val(row[0].batch);
        $("#lecturer").val(row[0].lecturer);
        if(row[0].image!=""){
          images.push(row[0].image);
         $("#imgPreview").html("<img style='width:100px;height:100px;cursor:pointer' class='img-fluid img-thumbnail' src='"+row[0].image+"'  onclick='lightBox(\""+row[0].image+"\")'> &nbsp;&nbsp;");
        }
      }
    });
}
$(document).ready(function(){
    load();
  //form submission
    $('#profileForm').bootstrapValidator({
      excluded: [':disabled'],
      feedbackIcons: false,
      live:'enabled',
      fields: {  
  




      }
    }).on('success.form.bv', function(e) {
      //prevent form submission
      e.preventDefault();
      var $form = $(e.target),fv    = $form.data('formValidation');
      var data=new FormData(this);
data.append('images', String(images));
      if(images.length>0){
    
        $.ajax({
          url: '<?php echo $base_url;?>/vendor/updateProfile',
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
              alertify.success("<i class='fa fa-check'></i> Profile Updated");
            }
            else{
              alert(result);
            }
           $("#profileForm")[0].reset();
            $('#profileForm').bootstrapValidator('resetForm', true);
            load();
          }
        })
        }
        else{
          alertify.dismissAll();
          alertify.error("<i class='fa fa-times'></i> Please select an image");
          $('#profileForm').bootstrapValidator('revalidateField', 'studentName');
        }
      });
  

})
</script>
</body>
</html>
