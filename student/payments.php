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
    $result=$db->select("SELECT * from payments  where ins_id='{$_SESSION['student'][5]}' and batch_id='{$_SESSION['student'][4]}' and course_id='{$_SESSION['student'][3]}' ORDER BY due_date DESC");
    if (!empty($result)) {
  foreach ($result as $row) {
  ?>
  <div class="card">
    <div class="card-body">
      <div class="col-md-12">
        <div class="d-flex justify-content-between">
          <p class="" style="font-weight:bold">
            <?php echo $row['payment_name'];?><br><?php echo "Due Date : ".date('d M Y', strtotime($row['due_date']))?>
          </p>
          <div class="">
              <?php
                $paid=$db->select("SELECT * from paid_details where payment_id='{$row['payment_id']}' and stu_id='{$_SESSION['student'][2]}'");
                if(!empty($paid)){
                  if ($paid[0]['status']=="Paid") {
                    echo "<span class='badge bg-success'>Paid</span>";
                  }
                  elseif($paid[0]['status']=="Cancelled"){
                     echo "<span class='badge bg-danger'>Cancelled</span>";
                  }
                }
                else{
                    echo "<span class='badge bg-warning'>Not yet</span>";
                }
                  
              ?>
          </div>
          
        </div>
      </div>
      <div class="col-md-12">
        <div class="d-flex justify-content-between">
         <span  onclick="navigate('payments',<?php echo $row['payment_id'];?>)" class="btn-link" style="cursor: pointer;">View Payment</span>
          <div class="">
            <?php echo "Rs. ".$row['amount'];?>
          </div>
          
        </div>
      </div>

  </div>
  </div>
  <?php
  }
  }
  ?>
</div>
  



<?php include('layout/footer.php');?>


<script type="text/javascript">
$("#payments").addClass("active");$("#navTitle").text("Payments");
</script>
</body>
</html>
