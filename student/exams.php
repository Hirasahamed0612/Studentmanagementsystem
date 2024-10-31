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
    $result=$db->select("SELECT * from exams   where ins_id='{$_SESSION['student'][5]}' and batch_id='{$_SESSION['student'][4]}' and course_id='{$_SESSION['student'][3]}' ORDER BY date DESC");
    if (!empty($result)) {
  foreach ($result as $row) {
  ?>
  <div class="card">
    <div class="card-body">
      <div class="card-title w-100">
        <div class="d-flex justify-content-between">
          <p class="px-4" style="font-weight:bold">
            <?php echo $row['exam_name'];?><br><?php echo date('d M Y', strtotime($row['date']))?>
          </p>
          <div class="">
              <?php
                $marks=$db->select("SELECT * from marks where exam_id='{$row['ex_id']}' and stu_id='{$_SESSION['student'][2]}'");
                  if (!empty($marks)) {
                    echo "<span class='badge bg-success'>Uploaded</span>";
                  }
                  else{
                    echo "<span class='badge bg-danger'>Not yet</span>";
                  }
              ?>
          </div>
          
        </div>
      </div>

    <div class="text-center">
      <span  onclick="navigate('exams',<?php echo $row['ex_id'];?>)" class="btn-link" style="cursor: pointer;">View Marks</span>
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
$("#exams").addClass("active");$("#navTitle").text("Exams");
</script>
</body>
</html>
