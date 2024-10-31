<?php

if(empty($_SESSION)) // if the session not yet started 
   session_start();

if(!isset($_SESSION['user']) || ($_SESSION['user'][2]!="User" && $_SESSION['user'][2]!="Admin") ) {//if not yet logged in
   echo "Session expired. Please Signin again";// send to login page
   exit;
}
require_once '../DataSource.php';
$db = new DataSource();
date_default_timezone_set('Asia/Colombo');
$date=date('Y-m-d');
$conn = $db->getConnection();
$conn->set_charset("utf8");
$base_url=$db->getBase(); 
?>

  
      <div class="container-fluid">
     	<?php include('tabs.php');?>
      <br>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Change Password</label><br>
            <button class="btn btn-primary" onclick="change_password_modal()">Change</button>
          </div>
        </div>
      </div>
      <hr>
      
      <h2>My Profile </h2>
      <hr>
      <div class="row">
        <div class="col-md-6">
          <form method="post" id="profileForm" enctype="multipart/form-data">
          <div class="form-group">
            <label>Fullname</label>
            <input type="text" id="fullname" name="fullname" class="form-control form-control-lg" placeholder="*Fullname" required >
          </div>
          <div class="form-group">
            <label>Contact No</label>
            <input type="text" id="contactNo" name="contactNo" class="form-control form-control-lg" placeholder="*Contact No" required >
          </div>
          <div class="form-group">
            <label>Address</label>
            <input type="text" id="address" name="address" class="form-control form-control-lg" placeholder="*Address" required >
          </div>

          <button class="btn btn-primary" type="submit">Save</button>
          </form>
        </div>
      </div>
        <br>
        <br>

      <br>
      </div><!-- /.container-fluid -->

  
<!--Change Password Modal------------------------------------------------------->
<div class="modal fade" id="change_password_modal" data-backdrop="static" data-keyboard="false"  aria-labelledby="viewForm" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" id="changeForm" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Old Password </label>
          <input type="password" name="oldPassword" class="form-control form-control-lg" required>
        </div>
        <div class="form-group">
          <label>New Password </label>
          <input type="password" name="newPassword" class="form-control form-control-lg" required>
        </div>
        <div class="form-group">
          <label>Confirm Password </label>
          <input type="password" name="confirmPassword" class="form-control form-control-lg" required>
        </div>

        
        
      
          
      </div> 
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit"  id="delete_button" class="btn btn-success">Change</button>
      </div>
    </div>
    </form>
  </div>
</div>



<script type="text/javascript">
$("#settings,#profile").addClass("active")
function change_password_modal() {
  $(".modal").trigger('click');
  $('#change_password_modal').modal('show'); 
}
$("#change_password_modal").on('hide.bs.modal', function(){
  $("#changeForm")[0].reset();
  $('#changeForm').bootstrapValidator('resetForm', true);
});
function load(){
$.ajax({
      type:'POST',
      url: 'vendor/fillProfile',
      dataType: "json",
      success: function(data) { 
        var row=data;
        $("#fullname").val(row[0].fullname);
        $("#contactNo").val(row[0].contactNo);
        $("#address").val(row[0].address);
      }
    });
} 
$(document).ready(function(){

load();
//form submission
    $('#changeForm').bootstrapValidator({
      excluded: [':disabled', ':hidden', ':not(:visible)'],
      feedbackIcons: false,
      live:'enabled',
      fields: { 
        oldPassword:{
          validators:{
            remote: {
              type:'POST',
              data:function(validator) {
                return {
                  type:'changePassword',
                };
              },  
              message: 'Old Password is invalid',
              url: '<?php echo $base_url;?>/vendor/checkDuplicate'
            }
          }
        },
        newPassword:{
          validators:{
            identical: {
              field: 'confirmPassword',
              message: 'The password and its confirm are not the same'
            },
            regexp: {
                regexp: RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})"),
                message: 'Password strength is low'
            }
          }
        },
        confirmPassword:{
          validators:{
            identical: {
              field: 'newPassword',
              message: 'The password and its confirm are not the same'
            }
          }
        },
        
      }
    }).on('success.form.bv', function(e) {
      //prevent form submission
      e.preventDefault();
      var $form = $(e.target),fv    = $form.data('formValidation');
      var data=new FormData(this);
        $.ajax({
          url: 'vendor/changePassword',
          type: 'POST',
          data: data,
          contentType: false,       // The content type used when sending data to the server.
          cache: false,             // To unable request pages to be cached
          processData:false, 
          beforeSend:function(){
            alertify.warning('Updating...',0);
          },
          success: function(result) {
            alertify.dismissAll();
            if(result==1){
              alertify.success("<i class='fa fa-check'></i> Password Changed");
              
            }
            else{
              alert(result);
            }
            $('#change_password_modal').modal('hide'); 
          }
        })
    })
  //form submission
    $('#profileForm').bootstrapValidator({
      excluded: [':disabled', ':hidden', ':not(:visible)'],
      feedbackIcons: false,
      live:'enabled',
      fields: {  

      }
    }).on('success.form.bv', function(e) {
      //prevent form submission
      e.preventDefault();
      var $form = $(e.target),fv    = $form.data('formValidation');
      var data=new FormData(this);
        $.ajax({
          url: 'vendor/updateProfile',
          type: 'POST',
          data: data,
          contentType: false,       // The content type used when sending data to the server.
          cache: false,             // To unable request pages to be cached
          processData:false, 
          beforeSend:function(){
            alertify.warning('Updating...',0);
          },
          success: function(result) {
             alertify.dismissAll();
            if(result==1){
             
              alertify.success("<i class='fa fa-check'></i> Saved");
              setTimeout(function(){ location.reload(); }, 1500);
              
            }
            else{
              alert(result);
            }
          }
        })
    })

}); 

</script>

