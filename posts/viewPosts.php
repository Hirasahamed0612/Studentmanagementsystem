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
<title>View Posts</title>
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
          <h4>View Posts</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Posts</li>
              <li class="breadcrumb-item active">View Posts</li>
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
            <h3 class="card-title">View Posts</h3>
          </div>
          <div class="card-body">
              <table id="dtTable" class="table table-bordered table-hover " style="width:100%">
                <thead>
                  <tr>
                    <th>Post Heading</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Attachments</th>
                    <th>User</th>
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
<!--Edit Modal------------------------------------------------------->
<div class="modal fade" id="edit_modal" data-backdrop="static" data-keyboard="false"  aria-labelledby="popupForm" aria-hidden="true">
  <div class="modal-dialog  modal-xl">
    <form method="post" id="editForm" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" name="hideId" id="hideId" class="d-none" placeholder="English">
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
     
    </div>
     <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit"  id="delete_button" class="btn btn-success">Update</button>
      </div>
    </form>
  </div>
</div>

<?php include('../layout/links-footer.php');?>
<script type="text/javascript">
var table;
var images=[];
$("#posts a:eq(0),#posts a:eq(2)").addClass("active");
$("#posts").removeClass("menu-close").addClass("menu-open");
//funtion for inz table
function inz(){
 table=$('#dtTable').DataTable({
  "ajax": {
    "url": "<?php echo $base_url;?>/posts/vendor/retrivePosts",
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



$("#edit_modal").on('hide.bs.modal', function(){
  $("#editForm")[0].reset();
  $('#editForm').bootstrapValidator('resetForm', true);
  $("#imgPreview").html("");
  images.splice(0,images.length);
});

 
//Delete Modal
function delete_post(id){
    $(".modal").trigger('click');
    $('#delete_modal').modal('show'); 
    $("#delete_button").attr("onclick","delete_record("+id+")")  ;      
}


//Deelete Function
function delete_record(id){
  $.ajax({
    url: '<?php echo $base_url;?>/posts/vendor/deletePost',
    type: 'POST',
    data: {
      id:id
    },
    success: function(result) {
      if(result==1){
        table.ajax.reload(null,false);
        alertify.dismissAll();
        alertify.success('<i class="fa fa-check"></i> Post Deleted');
      }
      else{
        alert(result);
      }
      $('#delete_modal').modal('hide');   
    }
  });
}
//Edit Modal
function edit_post(id) {
    
    $.ajax({
      type:'POST',
      url: '<?php echo $base_url;?>/posts/vendor/fillPost',
      dataType: "json",
      data:{
        id:id,
      },
      success: function(data) { 
        var row=data;
        $("#hideId").val(row[0].hideId);
        $("input[name=postHeading]").val(row[0].postHeading);
        CKEDITOR.instances['description'].setData(row[0].description);
        var date=new Date(row[0].date);
        if(!isNaN(date)){
          $('input[name=date]').val(moment(date).format('YYYY/MM/DD')).change();
           $('input[name=date]').data('daterangepicker').setStartDate(moment(date).format('YYYY/MM/DD'));
           $('input[name=date]').data('daterangepicker').setEndDate(moment(date).format('YYYY/MM/DD'));
           
        }
        var attachments=row[0].attachments.split(",");
        for(var x=0;x<attachments.length;x++){
          if(attachments[x]){
            var ext = attachments[x].substr( (attachments[x].lastIndexOf('.') +1) );
            if(ext == "jpg" || ext == "png" || ext == "jpeg" || ext == "gif" ){
              images.push(attachments[x]);
              $("#imgPreview").append("<div class='col-md-2 col-6 nopadding rmv"+x+"'><img style='width:100px;height:100px;float:left;margin-right:5px;margin-bottom:5px;' class='img-fluid img-thumbnail' src='"+attachments[x]+"'' onclick='lightBox(\""+attachments[x]+"\")' ><button type='button' class='btn btn-outline-danger btn-xs' onclick='removeOldAttachments(\""+attachments[x]+"\","+x+")' style='float:left'><i class='fas fa-times-circle fa-lg'></i></button></div>");

            }
            else if(ext=="pdf"){
              images.push(attachments[x]);
              $("#imgPreview").append("<div class='col-md-2 col-6 nopadding rmv"+x+"'><a href='"+attachments[x]+"'><img style='width:100px;height:100px;float:left;margin-right:5px;margin-bottom:5px;' class='img-fluid img-thumbnail' src='<?php echo $base_url ?>/assets/pdf.jpg'></a><button type='button' class='btn btn-outline-danger btn-xs' onclick='removeOldAttachments(\""+attachments[x]+"\","+x+")' style='float:left'><i class='fas fa-times-circle fa-lg'></i></button></div>");
            }
            

          }
        }

         
      },
      complete:function(){ 
        $(".modal").trigger('click');
        $('#edit_modal').modal('show'); 
      }
    });      
}
 function removeOldAttachments(attachment,id){
    $(".rmv"+id).remove();
    for(var i = 0; i < images.length; i++) {
      if(images[i] == attachment) {
        images.splice(i,1);
      }
    }
  }
var config={
  filebrowserBrowseUrl: '<?php echo $base_url;?>/plugins/ckfinder/ckfinder.html',
  filebrowserUploadUrl: '<?php echo $base_url;?>/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
};
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
   CKFinder.setupCKEditor( CKEDITOR.replace( 'description' ,config) );


  //form submission
    $('#editForm').bootstrapValidator({
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
          url: '<?php echo $base_url;?>/posts/vendor/updatePost',
          type: 'POST',
          data: data,
          contentType: false,       // The content type used when sending data to the server.
          cache: false,             // To unable request pages to be cached
          processData:false, 
          beforeSend:function(){
            alertify.warning('Updating...',0);
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
