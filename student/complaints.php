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
   <button class="btn btn-primary " onclick="makeComplaint()">Make New</button><br><br>

<div id="complaints">
  
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
        <div class="form-group">
                <label>Heading :</label>
                <input type="text" name="heading" class="form-control" placeholder="Heading">
        </div>
        <div class="form-group">
                <label>Description :</label>
                <textarea type="text" name="description" rows="10" class="form-control" placeholder="Description"></textarea>
        </div>

    </div>
     <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-success">Create</button>
      </div>
    </div>
    </form>
  </div>
</div>
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
<?php include('layout/footer.php');?>


<script type="text/javascript">
$("#navTitle").text("Complaints");
$("#new_modal").on('hide.bs.modal', function(){
  $("#newForm")[0].reset();
  $('#newForm').bootstrapValidator('resetForm', true);
});
function makeComplaint() {

      $(".modal").trigger('click');
      $('#new_modal').modal('show');     
          
}
//Delete Modal
function delete_complaint(id){
    $(".modal").trigger('click');
    $('#delete_modal').modal('show'); 
    $("#delete_button").attr("onclick","delete_record("+id+")")  ;      
}


//Deelete Function
function delete_record(id){
  $.ajax({
    url: '<?php echo $base_url;?>/vendor/deleteComplaint',
    type: 'POST',
    data: {
      id:id
    },
    success: function(result) {
      if(result==1){
        alertify.dismissAll();
        alertify.success('<i class="fa fa-check"></i> Complaint Deleted');
      }
      else{
        alert(result);
      }
      $('#delete_modal').modal('hide');   
      retriveComplaints();
    }
  });
}
function retriveComplaints(){
  $.ajax({
    url: '<?php echo $base_url;?>/vendor/retriveComplaints',
    type: 'POST',
    success: function(result) {
      $('#complaints').html(result);   
    }
  });
}
$(document).ready(function(){
    retriveComplaints();
  //form submission
    $('#newForm').bootstrapValidator({
      excluded: [':disabled'],
      feedbackIcons: false,
      live:'enabled',
      fields: {  
        heading: {
          validators: {
            notEmpty: {
              message: 'field is required'
            },
          }
        },
        description: {
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
          url: '<?php echo $base_url;?>/vendor/newComplaint',
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
              alertify.success("<i class='fa fa-check'></i> Complaint has sent");
            }
            else{
              alert(result);
            }
            $(".modal").trigger('click');
            $('#new_modal').modal('hide'); 
            retriveComplaints();
          }
        })
      });
  

})
</script>
</body>
</html>
