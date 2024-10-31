<?php
//Prevent Direct url access to this page
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
  header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
  die( header( 'location: ../error' ) );
}
else{
if(empty($_SESSION)) // if the session not yet started 
   session_start(); 
require_once '../DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();
$conn->set_charset("utf8");
$base_url=$db->getBase(); ;
$sqlSelect = "SELECT * from complaints where stu_id='{$_SESSION['student'][2]}' ORDER BY timestamp DESC;";
$result = $db->select($sqlSelect);
if (!empty($result)) {

foreach ($result as $row) {

?>
<div class="card">
    <div class="card-body">
      <div class="col-md-12">
        <div class="d-flex justify-content-between">
          <p class="px-4" style="font-weight:bold">
            <?php echo $row['heading'];?><br><?php echo date('d M Y', strtotime($row['timestamp']))?>
          </p>
          <div class="">
            <?php
                  if ($row['status']=="Solved") {
                    echo "<span class='badge bg-success'>{$row['status']}</span>";
                  }
                  else  if ($row['status']=="Cancelled") {
                    echo "<span class='badge bg-danger'>{$row['status']}</span>";
                  }
                  else{
                     echo "<span class='badge bg-warning'>{$row['status']}</span>";
                  }
              ?>

          </div>
          
        </div>
      </div>
      <div class="col-md-12">
        <div class="d-flex justify-content-between">
         <span  onclick="navigate('exams',<?php echo $row['com_id'];?>)" class="btn-link" style="cursor: pointer;">View Complaint</span>
          <div class="">
            <?php
          echo '<button class="btn btn-danger btn-sm" onclick="delete_complaint(\''.$row['com_id'].'\')"><i class="fas fa-trash-alt"></i></button>';
          ?>
          </div>
          
        </div>
      </div>
      


    <div class="text-center">
      
    </div>
  </div>
  </div>
<?php
}

}
}
?>
