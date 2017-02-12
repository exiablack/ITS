<?php
$var_error="";
$temp1 = "/Axe/login.php?error=empty";

$actual_link = "$_SERVER[REQUEST_URI]";
if($actual_link==$temp1)
{
$var_error = "* ERROR: &nbsp; INCORRECT CREDENTIALS";

}

?>

<html>
<head>
	<title>Online Reservation</title>
	<link rel="stylesheet" type="text/css" href="css/login.css"/>
</head>
<body>

<?php  include('nav-banner.php');?>
<div class="content-login">
<h1 class="big-title">- Sign in -</h1>
		<hr width="900"></hr>

	<div class="login-box">
		<form action="includes/login.inc.php" method="POST">
		<?php
			if($var_error!="")
			{
				?>
				<div class="note_payment"> <?php echo $var_error;?></div>
		<?php	}else{
				?>
				<div class="note_payment2"> </div>
		<?php }?>
	
		
			<img class="icon-user" src="resources/icons/user.png"/><h4 class="username">Username: <input type="text" class="tField" name="uid" placeholder="Username" /></h4>
			<img class="icon-pass" src="resources/icons/pass.png"/><h4 class="password">Password: <input type="password" class="tField" name="pwd" placeholder="Password"></h4>
			<button class="login-btn"><img class="icon-login" src="resources/icons/login.png"/>LOGIN</button>
		</form>
	</div>
</div>


<!-- Footer PHP FILE -->
<?php include('footer.php');
?>

</body>
</html>