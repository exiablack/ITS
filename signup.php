<html>
<head>
	<title>Online Reservation</title>
	<link rel="stylesheet" type="text/css" href="css/register.css"/>
</head>
<body>
<script type="text/javascript">
	function myFunction()
	{
		alert("Registration Successful!");
	}
</script>
<?php include('nav-banner.php');
?>
<?php

		$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		if(strpos($url,'error=empty_first') !== false)
		{
			echo"Fill out username!";
		}
		elseif(strpos($url,'error=empty_last') !== false)
		{
			echo"Username already exists!";
		}
		elseif(strpos($url,'error=empty_uid') !== false)
		{
			echo"Username already exists!";
		}
		elseif(strpos($url,'error=empty_pass') !== false)
		{
			echo"Username already exists!";
		}
		elseif(strpos($url,'error=empty_email') !== false)
		{
			echo"Username already exists!";
		}
	?>
<div class="content-register">
<h1 class="big-title">- Register -</h1>
		<hr width="900"></hr>
	<div class="register-box">
		<form action="includes/signup.inc.php" method="POST" onsubmit="return Validate()" name="vForm">
			<p id="note">Note:<img class="star" src= "resources/star.png"/> fields are required.</p>
			<label id="firstname">Firstname:</label><input type="text"  class="tField" name="firstname" placeholder="Firstname" /><span><img class="star" src= "resources/star.png"/></span><div id="firstname_error" class="val_error"></div> 

			<br>
			<label id="lastname">Lastname:</label><input type="text" class="tField" name="lastname" placeholder="Lastname" /><span><img class="star" src= "resources/star.png"/></span>
			<br>
			<label id="username">Username:</label><input type="text" class="tField" name="username" placeholder="Username" /><span><img class="star" src= "resources/star.png"/></span>
			<br>
			<label id="password">Password:</label><input type="password" class="tField" name="password" placeholder="Password" /><span><img class="star" src= "resources/star.png"/></span>
			<br>
			<label id="email">Email:</label><input type="text" class="tField" name="email" placeholder="Email" /><span><img class="star" src= "resources/star.png"/></span>

			<button type="submit" onsubmit="myFunction" class="register-btn">REGISTER</button> 
		</form>
	</div>
</div>
		

<!-- Footer PHP FILE -->
<?php include('footer.php');
?>

</body>
</html>
<script language="javascript">
	// GETTING ALL INPUT TEXT FIELDS
	var firstname = document.forms["vForm"]["firstname"];
	var lastname = document.forms["vForm"]["lastname"];
	var username = document.forms["vForm"]["username"];
	var password = document.forms["vForm"]["password"];
	var email = document.forms["vForm"]["email"];

	// GETTING ALL ERROR OBJECTS
	var firstname_error = document.getElementById("firstname_error");
	var lastname_error = document.getElementById("lastname_error");
	var username_error = document.getElementById("username_error");
	var password_error = document.getElementById("password_error");
	var email_error = document.getElementById("email_error");

	// SETTING ALL EVENT LISTENERS
    firstname.addEventListener( "blur", firstnameVerify, true);
    lastname.addEventListener("blur", lastnameVerify, true);
    username.addEventListener( "blur", usernameVerify, true);
    password.addEventListener("blur", passwordVerify, true);
    email.addEventListener( "blur", emailVerify, true);

    function Validate()
	{

		if(firstname.value == ""){
            firstname_error.textContent = "*firstname is required";
            firstname.style.border = "1px solid red";
            firstname.focus();
            return false;
        }
        if(lastname.value == ""){
            lastname_error.textContent = "*lastname is required";
            lastname.style.border = "1px solid red";
            lastname.focus();
            return false;
        }
        if(username.value == ""){
            username_error.textContent = "*lastname is required";
            username.style.border = "1px solid red";
            username.focus();
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
    function usernameVerify(){
        if (username.value != "") {
            username_error.innerHTML = "";
            username.style.border = "1px solid #110E0F";
            return true;
        }
    }
    function passwordVerify(){
        if (password.value != "") {
            password_error.innerHTML = "";
            password.style.border = "1px solid #110E0F";
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