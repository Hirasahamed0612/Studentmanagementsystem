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
    $result=$db->select("SELECT * from posts p inner join users u on p.u_user=u.id  where p.ins_id='{$_SESSION['student'][5]}' order by date desc");
    if (!empty($result)) {
  foreach ($result as $row) {
    $x=0;
  ?>
  <div class="card">
    <div class="card-body">
      <div class="card-title w-100">
        <div class="d-flex flex-row">
          <img src="<?php echo $row['image'];?>" class="img-circle" style="width:50px;height:50px">
          <p class="px-4" style="font-weight:bold">
            <?php echo $row['fullname'];?><br><?php echo date('d M Y', strtotime($row['date']))?>
          </p>
          
        </div>
      </div>
      <h5 style="font-weight:bold"><?php echo $row['post_heading'];?></h5>
    <p class="card-text">
    <?php
      $str_array = explode (' ', $row['description']);
         foreach ($str_array as $sub_str) {
             if($x<50){
                   echo $sub_str." ";
             }

             $x+=1;

            }
            if($x>50){
              ?>
              <span  onclick="navigate('home',<?php echo $row['post_id'];?>)" class="btn-link" style="cursor: pointer;">Read more..</span>
              <?php
              
            }
    ?>
      
    </p>
       
  </div>
  </div>
  <?php
  }
  }
  ?>
</div>
  



<?php include('layout/footer.php');?>


<script type="text/javascript">
$("#home").addClass("active");$("#navTitle").text("Home");
</script>
</body>
</html>
