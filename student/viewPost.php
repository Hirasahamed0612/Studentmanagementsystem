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
$post_id=$_GET['id'];
?>






<?php include('layout/header.php');?>
<div class="container">
  <?php
    $result=$db->select("SELECT * from posts where post_id='{$post_id}';");
  if (!empty($result)) {
    $attachments=$db->select("SELECT * from post_attachments  where post_id='{$post_id}';");

    ?>
    <h1><?php echo $result[0]['post_heading'];?> </h1>
    <p><?php echo $result[0]['description'];?></p>
  <?php
        if(!empty($attachments)){
           $attachs=array();
          foreach ($attachments as $attachment) {
            $ext = pathinfo($attachment['attachment'], PATHINFO_EXTENSION);
            if($ext == "jpg" || $ext == "png" || $ext == "jpeg" || $ext == "gif" ){
              $attachs[]=$attachment['attachment'];
            echo '<img src="'.$attachment['attachment'].'"  style="width: 100px;height: 100px;cursor:pointer;" class="img-thumbnail" onclick="lightBox(\''.$attachment['attachment'].'\')"> ';
            }
            elseif($ext=="pdf"){
            echo '<a href="'.$attachment['attachment'].'" target="_blank" ><img src="'.$base_url.'/assets/pdf.jpg"  style="width: 100px;height: 100px;"></a>';
            }
          }
          $attachs=implode(",", $attachs);
        }
      ?>


    
 <?php
  }
?>
</div>
  



<?php include('layout/footer.php');?>


<script type="text/javascript">

$("#home").addClass("active");$("#navTitle").text("View Post");

  var attachments="<?php echo $attachs; ?>";
  attachments=attachments.split(",");
function lightBox(attachment){
  var items=[];
  var index="";
  for(var x=0;x<attachments.length;x++){
    if(attachments[x]==attachment){
      index=x;
    }
    items.push({src: attachments[x]}); 
  }
  var options = {index: index};
  new PhotoViewer(items, options);
}

</script>
</body>
</html>
