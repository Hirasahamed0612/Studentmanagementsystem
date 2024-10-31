<?php
if(empty($_SESSION)) // if the session not yet started 
   session_start();

if(isset($_SESSION['user']) && $_SESSION['user'][5]==true){
header("location: ../dashboard"); 
   exit;
}

require_once '../DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();

$base_url=$db->getBase(); 

?>
<!DOCTYPE html>
<html>
<head>
<?php
include("../layout/links-header.php");
?>
  <title>Reset Account</title>
<style type="text/css">

</style>
</head>
<body >


    <div class="container" id="main">
        <br>
    <div class="col-sm-12">
        <?php
            $email=$db->decryption($_GET['code']);
            $password1="User".random_int(100000, 999999);
            $password=$db->encryption($password1);
            
            $table='users';
            $paramArray = array(
                'password'=>password_hash($password, PASSWORD_DEFAULT)
            );
            $conditions=array(
                "email"=>$email
            );
            $result = $db->update($table,$paramArray,$conditions);
            if($result>0 && !empty($email) && $conn -> affected_rows>0){
        ?>
        <div class="card text-white bg-success">
            <div class="card-header">Account reset successfully</div>
            <div class="card-body">
                <p class="card-text">  
                <label>Email :</label> 
                <?php echo $email; ?>  <br>
                <label>Password : </label>
                <?php echo $password1; ?>   
                </p>
            </div>
        </div>
        <?php
        }
        else{
        ?>
        <div class="card text-white bg-danger">
            <div class="card-header">Failed</div>
            <div class="card-body">
                <h6 class="card-title">Reset Failed</h6>
                <p class="card-text">      
                </p>
            </div>
        </div>
        <?php  
        }
        ?>
        
    </div>
    </div>

<script type="text/javascript">

</script>
<?php
include("../layout/links-footer.php");
?>
</body>
</html>