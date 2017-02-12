<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" type="text/css" href="css/nav-banner.css"/>
    <link href="jquery/jquery-ui.css" rel="Stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="css/header-center.css"/>
	<script src="jquery/jquery-3.1.1.js"></script>
    <script src="jquery/jquery.min.js" type="text/javascript"></script>
    <script src="jquery/jquery-ui.min.js" type="text/javascript"></script>
</head>
<body>
<div class="header-cont">
	<header>
	
	</header>
</div>
	<div class="nav-cont">
	<nav class="navi">
		<ul>
		<li><a href="index.php">Home</a></li>
		<li><a href="menus.php">Menu</a></li>
		<li><a href="package.php">Packages</a></li>
		<li><a href="food-order.php">Food Order</a></li>
		
		<?php
				if(isset($_SESSION['username']))
			{
				echo "<li><a href='calendar.php'>Event Calendar</a></li>";
				echo "<li><a href='reservationV2.php'>Reservation</a></li>";
					
			}
				
			?>
		<li><a href="photo-gallery.php">Gallery</a></li>
		<li><a href="about.php">About Us</a></li>

		

			<?php
				if(isset($_SESSION['username']))
			{
				echo "<li style='float:right; width: 200px; background-color: rgba(0,0,0,0.8);'><button style='width: 200px;'>".$_SESSION['username']."</button><ul>";
					echo "<li><a href='reservationPayment.php'>Reservation Cart</a></li>";
					echo "<li><a href='food-order-payment.php'>Food Order Cart</a></li>";
					echo "<li><a href='dashboard.php'>Dashboard</a></li>";
					echo "<li><a href='includes/logout.inc.php'>Logout</a></li>";
					echo "</ul>";
				echo "</li>";
			} else{
				echo "<li style='float:right;'><a href='terms-and-conditions.php'>SIGNUP</a></li>";
				echo"<li style='float:right;'><a href='login.php'><span style='color: yellow; text-shadow: 2px 2px 5px black;''>SIGN IN</span></a></li>";
			}
				
			?>

		<!-- <li style="float:right;"><a href="register.php">REGISTER</a></li>
		<li style="float:right;"><a href="login.php"><span style="color: yellow; text-shadow: 2px 2px 5px white;">LOGIN</span></a></li> -->
		</ul>
	</nav>
	</div>
		<!-- import jQuery -->
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"> -->

    
<!-- write script to toggle class on scroll -->
	<script src="jquery/custom.js"></script>
</body>
</html>