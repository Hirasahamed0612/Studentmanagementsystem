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
  <?php
    $result=$db->select("SELECT * from students where stu_id='{$_SESSION['student'][2]}'");
  ?>
   <div class="d-flex flex-row" >
          <img src="<?php echo $result[0]['image'];?>" class="img-circle" style="width:50px;height:50px">
          <p class="px-4" style="font-weight:bold">
            <?php echo $result[0]['student_name'];?><br><?php echo $result[0]['registration_no'];?>
          </p>
          
        </div>
        <div class="d-flex flex-column" >
           <div href="#" onclick="navigate('profile')" style="color:#000;cursor: pointer;">
          <div class="card">
            <div class="card-body">
              <i class="fas fa-user"></i> Profile
            </div>
          </div>
        </div>
          <div href="#" onclick="navigate('complaints')" style="color:#000;cursor: pointer;">
          <div class="card">
            <div class="card-body">
              <i class="fas fa-edit"></i> Complaints
            </div>
          </div>
          </div>
          <div href="#" onclick="change_password_modal()" style="color:#000;cursor: pointer;">
          <div class="card">
            <div class="card-body">
              <i class="fas fa-lock"></i> Change Password
            </div>
          </div>
           </div>
          <a href="<?php echo $base_url;?>/logOut" style="color:#000">
          <div class="card">
            <div class="card-body">
              <i class="fas fa-sign-out-alt"></i> Log Out
            </div>
          </div>
          </a>
        </div>

</div>
  
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


<?php include('layout/footer.php');?>


<script type="text/javascript">
$("#settings").addClass("active");$("#navTitle").text("Settings");
function change_password_modal() {
  $(".modal").trigger('click');
  $('#change_password_modal').modal('show'); 
}
$("#change_password_modal").on('hide.bs.modal', function(){
  $("#changeForm")[0].reset();
  $('#changeForm').bootstrapValidator('resetForm', true);
});
$(document).ready(function(){

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
  });
</script>
</body>
</html>
