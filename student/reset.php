<?php
if(empty($_SESSION)) // if the session not yet started 
   session_start();

if(isset($_SESSION['student']) && $_SESSION['student'][5]==true){
header("location: dashboard"); 
   exit;
}
require 'plugins/PHPMailer/src/Exception.php';
require 'plugins/PHPMailer/src/PHPMailer.php';
require 'plugins/PHPMailer/src/SMTP.php';
require_once 'DataSource.php';
$db = new DataSource();

$conn = $db->getConnection();
$conn->set_charset("utf8");
$base_url=$db->getBase(); 
$email =""; 
$err = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    // if the form not yet submitted

            $email = $conn -> real_escape_string($_POST["email"]);
         // Validate credentials

        if(empty($err) & !empty($email)){
            //check if the username entered is in the database.
            $table="students";
            $paramType = "sss";
            $paramArray = array(
                'email'=>$email,
                'type'=>'User',
                'status'=>"Active"
            );

            $query_result =  $db->logIn($table,$paramType, $paramArray);

            //conditions
            if (empty($query_result)) {
                //if username entered not yet exists
                $err = 'No account found with that email.';
 
            }
            else {
              $reset=$db->sendResetLink($query_result['email']);
              if($reset==1){
                $err="<span style='color:green;'>Reset link sent successfully to your email.</span>";
              }
              else{
                $err="Something went wrong.";
              }
              //header("Refresh:0");
            }
        }
        else{
            $err = 'Please fill the fields.';
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
<?php
include("layout/links-header.php");
?>
  <title>Sign up</title>
<style type="text/css">

.vertical-center {
   margin: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}


</style>
</head>
<body >


<div class="col-md-4 offset-md-4 animate-bottom vertical-center"   id="main"> 
  <br>
  <div class="card">
    <div class="card-body">
<form class="form-signin" action="" method="post">
	<center>
		 <img src="<?php echo $base_url;?>/assets/logo.png" height="80px" width="180px" class="img-fluid" >
	</center>
	<br>
      <h1 class="h3 mb-3 font-weight-normal text-center">Reset Password</h1>

      <div class="form-group">
          <div class="input-group <?php echo (!empty($err)) ? 'has-error' : ''; ?>" >
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
          </div>
          <input type="email" class="form-control form-control-lg" name="email" id="email"  placeholder="Email address" />
        </div>
      </div> 
      <p style="color:red;" class="text-center"><?php echo $err;?></p>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Reset Password</button>
      <p class="mt-2 text-muted text-center"><a href="<?php echo $base_url;?>/" >Log In</a></p>
 
    </form>
  </div>
</div>
</div>


<?php
include("layout/links-footer.php");
?>
<script type="text/javascript">

$(document).ready(function(){
  
}); 
</script>
</body>
</html>