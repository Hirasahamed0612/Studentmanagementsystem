<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Prevent Direct url access to this page
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
  header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
  die( header( 'location: ../../error' ));
}
else{
    

class DataSource

{



    // PHP 7.1.0 visibility modifiers are allowed for class constants.

    // when using above 7.1.0, declare the below constants as private

   	const HOST = 'localhost';



    const USERNAME = 'root';



    const PASSWORD = '';



    const DATABASENAME = 'final_project';



    private $conn;

    

    private $base_url;   





    function __construct()

    {
        $this->conn = new mysqli(self::HOST, self::USERNAME, self::PASSWORD, self::DATABASENAME);



        if (mysqli_connect_errno()) {

            trigger_error("Problem with connecting to database.");

        }

        //get base url for php operations

        if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {

            $uri = 'https://';

        } else {

            $uri = 'http://';

        }
        
        $uri .= $_SERVER['HTTP_HOST'];
        $this->base_url =$uri."/student";

    }

    function __destruct()
    {
        $this->conn->close();
    }



    public function getConnection()

    {

        return $this->conn;

    }

    public function getBase()

    {

        return $this->base_url;

    }
    public function  logIn($table,$paramType, $paramArray){
        foreach ($paramArray as $key => $value) {
            $keys[]=$key;
            $values[]=$value;
        }
        $checkQuery = "SELECT * FROM $table WHERE $keys[0]=?";
        $stmt = $this->conn->prepare($checkQuery);
      
        $stmt->bind_param($paramType, $values[0]);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row;
    }

    public function  logOut(){



        session_start();

        // Unset all of the session variables

         unset($_SESSION['student']);

        // Redirect to login page

        header("location: index");

        exit;



    }

    public function insert($table,$paramArray){



        foreach ($paramArray as $key => $value) {

            $keys[]=$key;

            $values[]="'".$value."'";

        }

        $keys=implode(",",$keys);

        $values=implode(",",$values);

        $insertQuery = "INSERT INTO $table($keys) VALUES($values);";

        $this->conn->query($insertQuery);

        $insertId = $this->conn->insert_id;

        return $insertId;



    }

    public function insertMulti($table,$paramArrays){

        $insertQuery="";



        foreach ($paramArrays as $paramArray) {

         

            $keys=array();

            $values=array();

            

            foreach ($paramArray as $key => $value) {

                $keys[]=$key;

                $values[]="'".$value."'";

            }

            $keysString=implode(",",$keys);

            $valuesString=implode(",",$values);

            $insertQuery .= "INSERT INTO $table($keysString) VALUES($valuesString);";

            

        }

        if($this->conn->multi_query($insertQuery)){

            return 1;

        }else{

             return "Error: " . $this->conn->error;

        }

        

    }

    public function update($table,$paramArray,$conditions){

        foreach ($paramArray as $key => $value) {

            $criteria[]="".$key."='".$value."'";

        }

        foreach ($conditions as $key => $value) {

            $whereClause[]="".$key."='".$value."'";

        }

        $criteria=implode(",", $criteria);

        $whereClause=implode(" AND ", $whereClause);



        $updateQuery = "UPDATE $table SET $criteria WHERE $whereClause;";

        $result=$this->conn->query($updateQuery);

        return $result;

        



    }

    public function imageUpload($imgArray,$uploadDirectory){

        foreach ($imgArray as $img) {

            $uploadPath = $uploadDirectory . basename($img['image']); 

            $didUpload = move_uploaded_file($img['tmpName'], $uploadPath);

        }  

    }

    public function encryption($value){

        $encrypt_method='AES-256-CBC';

        $secret_key="abdul";

        $secret_iv="arham";

        $key=hash('sha256', $secret_key);

        $intialization_vector=substr(hash('sha256',$secret_iv), 0,16);

        $value=openssl_encrypt($value, $encrypt_method, $key,0,$intialization_vector);

        return base64_encode($value); 

    }

    public function decryption($value){

        $encrypt_method='AES-256-CBC';

        $secret_key="abdul";

        $secret_iv="arham";

        $key=hash('sha256', $secret_key);

        $intialization_vector=substr(hash('sha256',$secret_iv), 0,16);

        $value=base64_decode($value);

        return openssl_decrypt($value, $encrypt_method, $key,0,$intialization_vector);

    }

    public function imageUriUpload($image,$uploadDirectory,$imageName){

        $image_array_1 = explode(";", $image);

        $image_array_2 = explode(",", $image_array_1[1]);

        $img = base64_decode($image_array_2[1]);

        $imageName = $uploadDirectory.$imageName;

        file_put_contents($imageName, $img);  

    }

    public function removeImages($removeImages,$uploadDirectory){

        foreach ($removeImages as $image) {

             $unlink=unlink($uploadDirectory.$image); 

        }

    }

    public function delete($query){

        $result =  $this->conn->query($query);

        return 1;

    }

    public function select($query){

       $result =  $this->conn->query($query);

       if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $resultset[] = $row;

            } 

       }

        if (!empty($resultset)) {

            return $resultset;

        }

    }

    function extractVideoID($url){

        $regExp = "/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/";

        preg_match($regExp, $url, $video);

        return $video[7];

    }

    function getYouTubeThumbnailImage($video_id) {

        return "https://i3.ytimg.com/vi/$video_id/hqdefault.jpg"; //pass 0,1,2,3 for different sizes like 0.jpg, 1.jpg

    }   

    function getVimeoId($url){

        if (preg_match('#(?:https?://)?(?:www.)?(?:player.)?vimeo.com/(?:[a-z]*/)*([0-9]{6,11})[?]?.*#', $url, $m)) {

            return $m[1];

         }

        return false;

    }

    function getVimeoThumb($id){

        $arr_vimeo = unserialize($this->curl_get_file_contents("https://vimeo.com/api/v2/video/$id.php"));

        //return $arr_vimeo[0]['thumbnail_small']; // returns small thumbnail

     return $arr_vimeo[0]['thumbnail_medium']; // returns medium thumbnail

    // return $arr_vimeo[0]['thumbnail_large']; // returns large thumbnail

    }
    function curl_get_file_contents($URL)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) return $contents;
        else return FALSE;
    }
    public function mailConfig(){
            $this->mail = new PHPMailer(true);
            $this->mail->isSMTP();                                            // Send using SMTP
            $this->mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $this->mail->Username   = 'fastinneeded@gmail.com';                     // SMTP username
            $this->mail->Password   = 'crtghb68p2';                               // SMTP password
            $this->mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $this->mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $this->mail->setFrom('fastinneeded@gmail.com','Dodge Exchange');
 
           // $this->mail->addReplyTo('admin@designerclearance.co.uk', 'No reply');
    }
    public function  sendResetLink($email){
        $code=$this->encryption($email);
        $url=$this->base_url."/vendor/resetAccount?code=".$code."&timesCount=".random_int(100000, 999999);
        try {
            
            $this->mailConfig();
            $this->mail->addAddress("$email");    
            $this->mail->isHTML(true);                                  // Set email format to HTML
            $this->mail->Subject = 'Reset Link';
            $this->mail->Body    = "Your reset link <a href='$url'>Click Here</a>";
            //$this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $this->mail->send();
            if($this->mail){
                return 1;
            }
            else{
                return 0;
            }
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }   
    }
    public function  sendNotification($subject,$body,$to){

        try {
            
            $this->mailConfig();
            $this->mail->addAddress($to);    
            $this->mail->isHTML(true);                                  // Set email format to HTML
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
          
            $this->mail->send();
            if($this->mail){
                return 1;
            }
            else{
                return 0;
            }
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }   
    }
    

    public function getIp() {
        $mainIp = '';
        if (getenv('HTTP_CLIENT_IP'))
            $mainIp = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $mainIp = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $mainIp = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $mainIp = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $mainIp = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $mainIp = getenv('REMOTE_ADDR');
        else
            $mainIp = 'UNKNOWN';
        return $mainIp;
    }
    public  function getInfo(){
        $ip=$this->getIp();
        //$ip='163.172.174.138';
        $url = "http://ipinfo.io/".$ip;
        $ip_info = json_decode(file_get_contents($url));
        return $ip_info;
    }
    public  function getCurrency(){
        if(empty($_SESSION)) // if the session not yet started 
            session_start();;
         $result=$this->select("SELECT a.country,b.currency FROM personal_details a inner join countries b on a.country=b.cn_id where a.user_id='{$_SESSION['student'][3]}';");

        return $result[0]['currency'];
    }
    function exchange($amount,$from_currency,$to_currency){
      $apikey = 'b1cd8df3f3f8e2bf4220';

      $from_Currency = urlencode($from_currency);
      $to_Currency = urlencode($to_currency);
      $query =  "{$from_Currency}_{$to_Currency}";

      // change to the free URL if you're using the free version
      $json = file_get_contents("https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}");
      $obj = json_decode($json, true);
      if(!empty($obj["$query"])){
        $val = floatval($obj["$query"]);
        $total = ($val * $amount);
        $total-=$total*0.03;
        return number_format($total, 8, '.', '');
      }
      else{
        $msg="Rate not available to";
        return $msg;
      }

      
      
    }


}
}
?>