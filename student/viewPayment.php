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
$payment_id=$_GET['id'];
?>






<?php include('layout/header.php');?>
<div class="container">
  <?php
    $result=$db->select("SELECT * from payments where payment_id='{$payment_id}';");
  if (!empty($result)) {
    $payment=$db->select("SELECT * from paid_details  where payment_id='{$payment_id}' and stu_id='{$_SESSION['student'][2]}';");

    ?>
    <h1><?php echo $result[0]['payment_name']." - Rs. ". $result[0]['amount'];?> </h1>
    <span class="badge bg-red ">Due Date : <?php echo $result[0]['due_date'];?></span>
    <p><?php echo $result[0]['description'];?></p>
   
    

    
 <?php
 echo "<div class='col-md-12 text-center'>";
 if(!empty($payment)){
  if($payment[0]['status']=="Paid"){
    echo "<span class='text-center'>Paid Date : {$payment[0]['paid_date']}</span><br>";
    echo "<span class='badge bg-success text-center' style='font-size:4vh'>{$payment[0]['status']}</span>";
  }
  elseif($payment[0]['status']=="Cancelled"){
     echo "<span class='text-center'>Reject Date : {$payment[0]['paid_date']}</span><br>";
    echo "<span class='badge bg-danger' style='font-size:4vh'>Rejected</span>";
  }
 }
 else{
    echo "<span class='badge bg-warning' style='font-size:4vh'>Not yet</span>";
 }
 
 echo "</div>";
  }

  ?>
</div>
  



<?php include('layout/footer.php');?>


<script type="text/javascript">
$("#payments").addClass("active");$("#navTitle").text("View Payments");
</script>
</body>
</html>
