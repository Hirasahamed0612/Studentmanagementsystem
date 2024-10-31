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
$exam_id=$_GET['id'];
?>






<?php include('layout/header.php');?>
<div class="container">
  <?php
    $result=$db->select("SELECT s.subject_name,m.marks from marks m inner join subjects s on m.sub_id=s.sub_id where m.exam_id='{$exam_id}' and m.stu_id='{$_SESSION['student'][2]}';");
    if (!empty($result)) {
      $exam=$db->select("SELECT * from exams  where ex_id='{$exam_id}';");
     echo '<div class="card">';
    echo '<div class="card-body">';
    echo "<div class='card-title w-100 text-center'>{$exam[0]['exam_name']}</div>";
    echo "<table class='table'>";
    echo "<thead><tr><th>Subject</th><th>Marks</th></tr></thead>";
    echo "<tbody>";
  foreach ($result as $row) {
  ?>
  <tr>
    <td><?php echo $row['subject_name'];?></td>
    <td><?php echo $row['marks'];?></td>
  </tr>
      

      
  
  <?php
  }
  echo "</tbody>";
  echo "</table";
  echo '</div>';
  echo '</div>';
  }
  else{
    ?>
    <div class="d-flex justify-content-center">
      <div class="text-center text-danger">Results not updated yet</div>
    </div>
    <?php
   
  }
  ?>
</div>
  



<?php include('layout/footer.php');?>


<script type="text/javascript">
$("#exams").addClass("active");$("#navTitle").text("View Marks");
</script>
</body>
</html>
