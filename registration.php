
<?php

        $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        if(isset($_SESSION['username']))
        {
           echo "<script>alert('Already Login');document.location='index.php'</script>";
        } 
        elseif(strpos($url,'error=username') !== false)
        {
            echo "<script>alert('Username already in use!');</script>";
        }
    ?>
<?php
$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "senordepacencia";

$lastname = "";
$firstname = "";
$uid = "";
$pwd = "";
$email = "";


$connect = mysqli_connect($hostname, $username, $password, $databaseName);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{
    $connect = mysqli_connect($hostname, $username, $password, $databaseName);
    
}catch(Exception $ex)
{
    echo 'Error';
}

function getPosts()
{
    $posts = array();
  
    $posts[0] = $_POST['firstname'];
    $posts[1] = $_POST['lastname'];
    $posts[2] = $_POST['uid'];
    $posts[3] = $_POST['pwd'];
    $posts[4] = $_POST['email'];
 
    
    return $posts;
}
//insert
if(isset($_POST['insert']))
{
    $data = getPosts();

    $sql = "select username from accounts where username='$data[2]'";
    $result = mysqli_query($connect, $sql);
    $uidcheck = mysqli_num_rows($result);
        if($uidcheck > 0)
        {
            header("Location: registration.php?error=username");
            exit();
        }
        else{

            $encrypted_password = password_hash($data[3], PASSWORD_DEFAULT);
             $insert_Query = "insert into accounts (username, fname, lname, password, email) values ('$data[2]', '$data[0]','$data[1]','$encrypted_password','$data[4]')";

        try
            {

                $insert_Result = mysqli_query($connect, $insert_Query);
                if($insert_Result)
                {
                    if(mysqli_affected_rows($connect) > 0)
                        {
                          echo "<script>alert('Sign up Successful!');document.location='index.php'</script>";
                        }
                else
                {
                    echo 'Data Not Inserted';
                }
            }
       
        }
        catch(Exception $ex)
            {
            echo 'Error Insert'.$ex->getMessage();
            }
        }//Else
    }//IF
?>

<!DOCTYPE html>
<html>
<head>
  <title>Senor de Pacencia Enterprise</title>
  <link rel="stylesheet" type="text/css" href="css/register.css"/>
    <script src="js/jquery-3.1.1.js"></script>
    
<!-- write script to toggle class on scroll -->
    <script src="js/custom.js"></script>
    <script src="jquery/jquery.min.js" type="text/javascript"></script>
    <script src="jquery/jquery-ui.min.js" type="text/javascript"></script>
    <link href="jquery/jquery-ui.css" rel="Stylesheet" type="text/css" />

    <script type="text/javascript">

        function capitalize(textboxid, str) {
          // string with alteast one character
         if (str && str.length >= 1){       
             var firstChar = str.charAt(0);
             var remainingStr = str.slice(1);
             str = firstChar.toUpperCase() + remainingStr;
         }
         document.getElementById(textboxid).value = str;
     }
     

    
    function myFunction(){
                     alert("Thank you for registering!");
                     
               }

    </script>

</head>

<?php include('nav-banner.php');
?>

<body>
  <div class="content-register">
<h1 class="big-title">- Register -</h1>
    <hr width="900"></hr>
  <div class="register-box">
    <form action="" method="POST" onsubmit="return Validate()" name="vForm">
      <p id="note">Note:<img class="star" src= "resources/star.png"/> fields are required.</p>


      <label id="firstname">Firstname:</label><input type="text" class="tField" pattern="[a-zA-Z]+" name="firstname" placeholder="Firstname" value="<?php echo $firstname;?>"  onkeyup="javascript:capitalize(this.id, this.value);"/><span><img class="star" src= "resources/star.png"/></span><div id="firstname_error" class="val_error"></div> 

      <br>
      <label id="lastname">Lastname:</label><input type="text" class="tField" pattern="[a-zA-Z]+" name="lastname" placeholder="Lastname" value="<?php echo $firstname;?>"/><span><img class="star" src= "resources/star.png"/></span><div id="lastname_error" class="val_error"></div> 
      <br>

      <label id="username">Username:</label><input type="text" class="tField" name="uid" placeholder="Username" /><span><img class="star" src= "resources/star.png"/></span><div id="uid_error" class="val_error"></div> 
      <br>

      <label id="password">Password:</label><input type="password" class="tField" name="pwd" placeholder="Password" /><span><img class="star" src= "resources/star.png"/></span><div id="pwd_error" class="val_error"></div> 
      <br>
      <label id="email">Email:</label><input type="text" class="tField" name="email" placeholder="Email" /><span><img class="star" src= "resources/star.png"/></span><div id="email_error" class="val_error"></div> 

      <button type="submit" name="insert" id="insert" onsubmit="myFunction" class="register-btn">Sign Up</button> 
    </form>
  </div>
</div>
</body>
</html>
<script type="text/javascript">
  // GETTING ALL INPUT TEXT FIELDS
    var firstname = document.forms["vForm"]["firstname"];
    var lastname = document.forms["vForm"]["lastname"];
    var uid = document.forms["vForm"]["uid"];
    var pwd = document.forms["vForm"]["pwd"];
    var email = document.forms["vForm"]["email"];

    // GETTING ALL ERROR OBJECTS
    var firstname_error = document.getElementById("firstname_error");
    var lastname_error = document.getElementById("lastname_error");
    var uid_error = document.getElementById("uid_error");
    var pwd_error = document.getElementById("pwd_error");
    var email_error = document.getElementById("email_error");

     // SETTING ALL EVENT LISTENERS
    firstname.addEventListener( "blur", firstnameVerify, true);
    lastname.addEventListener("blur", lastnameVerify, true);
    uid.addEventListener("blur", uidVerify, true);
    pwd.addEventListener("blur", pwdVerify, true);
    email.addEventListener("blur", emailVerify, true);

    function Validate(){

        // VALIDATE FIRSTNAME
        if(firstname.value == ""){
            firstname_error.textContent = "*firstname is required";
            firstname.style.border = "1px solid red";
            firstname.focus();
            return false;
        }
        // VALIDATE LASTNAME
        if(lastname.value == ""){
            lastname_error.textContent = "*lastname is required";
            lastname.style.border = "1px solid red";
            lastname.focus();
            return false;
        }

                // VALIDATE LOT USERNAME  
        if(uid.value == ""){
            uid_error.textContent = "*Username is required";
            uid.style.border = "1px solid red";
            uid.focus();
            return false;
        } 
                
                // VALIDATE PASSWORD
        if(pwd.value == ""){
            pwd_error.textContent = "*Password is required";
            pwd.style.border = "1px solid red";
            pwd.focus();
            return false;
        } 
                
                // VALIDATE EMAIL   
        if(email.value == ""){
            email_error.textContent = "*Email is required";
            email.style.border = "1px solid red";
            email.focus();
            return false;
        } 

      }

      // ADD EVENT LISTENERS
        
        function firstnameVerify(){
        if (firstname.value != "") {
            firstname_error.innerHTML = "";
            firstname.style.border = "1px solid #110E0F";
            return true;
        }
    }
        function lastnameVerify(){
        if (lastname.value != "") {
            lastname_error.innerHTML = "";
            lastname.style.border = "1px solid #110E0F";
            return true;
        }
    }
     function uidVerify(){
        if (uid.value != "") {
            uid_error.innerHTML = "";
            uid.style.border = "1px solid #110E0F";
            return true;
        }
    }
        function pwdVerify(){
        if (pwd.value != "") {
            pwd_error.innerHTML = "";
            pwd.style.border = "1px solid #110E0F";
            return true;
        }
    }

        function emailVerify(){
        if (email.value != "") {
            email_error.innerHTML = "";
            email.style.border = "1px solid #110E0F";
            return true;
        }
    }
</script>