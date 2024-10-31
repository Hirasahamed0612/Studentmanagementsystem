<?php
if(empty($_SESSION)) // if the session not yet started 
   session_start();

if(isset($_SESSION['user'])){
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
$password = "";
$err = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    // if the form not yet submitted

            $email = $conn -> real_escape_string($_POST["email"]);
            $password =  $conn -> real_escape_string($_POST["password"]);
         // Validate credentials

        if(empty($err) & !empty($email) & !empty($password)){
            //check if the email entered is in the database.
            $table="users";
            $paramType = "ss";
            $paramArray = array(
                'email'=>$email,
                'status'=>"Active",
            );

            $query_result =  $db->logIn($table,$paramType, $paramArray);

            //conditions
            if (empty($query_result)) {
                //if email entered not yet exists
                $err = 'No account found with that email.';
 
            }
            else {
                //if exists, then extract the password.
                // check if password are equal
                $password= $db->encryption($password);
                if(password_verify($password, $query_result['password'])){
                    $sessionArray=array($email,$query_result['fullname'],$query_result['type'],$query_result['id'],$query_result['ins_id'],$query_result['image']);
                    $_SESSION['user']=$sessionArray;
                   
    
                    header("location: dashboard");
                } 
                else{ 
                    $err = 'The email or password you entered was not valid.';
                }

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
  <title>Sign in</title>
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

  <form  action="" method="post">
    <center>
      <img src="<?php echo $base_url;?>/assets/logo.png" height="80px" width="180px" class="img-fluid" >
    </center>
      <br>
      <h1 class="h3 mb-3 font-weight-normal text-center">Sign in to AIMS</h1>

      <div class="form-group">
          <div class="input-group <?php echo (!empty($err)) ? 'has-error' : ''; ?>" >
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
          </div>
          <input type="email" class="form-control form-control-lg" name="email" id="email"  placeholder="Email" />
        </div>
      </div>
      <div class="form-group">
        <div class="input-group <?php echo (!empty($err)) ? 'has-error' : ''; ?>" >
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-lock"></i></span>  
          </div>
          <input type="password" class="form-control form-control-lg" name="password" id="password"  placeholder="Password" />
        </div>
      </div>
      <p style="color:red;" class="text-center"><?php echo $err;?></p>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
      <p class="mt-2 text-muted text-center"><a href="<?php echo $base_url;?>/reset" >Forget password ?</a></p>
      <p class="mt-2 mb-3 text-muted text-center hide">Solution By
    <a href="#" target="_blank">UOVT</a></p>
    </form>
  </div>
</div>
</div>

<script type="text/javascript">

</script>
<?php
include("layout/links-footer.php");
?>
</body>
</html>