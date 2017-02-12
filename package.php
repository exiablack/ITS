<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();

?>
<html>
<head>
	<title>Online Reservation</title>

	<link rel="stylesheet" type="text/css" href="css/packagecss.css"/>
</head>
<body>
<?php include('nav-banner.php');
?>

	<div class="content-packages">
	
	<h2 class="big-title">- Packages on Wedding, Debut & Special Occasions –</h1>
	<!-- DEFAULT CLASS = header-pkg (PACKAGES ON WEDDING, DEBUT & SPECIAL OCCASIONS) -->

	<!-- START OF SET A PACKAGES ON WEDDING, DEBUT & SPECIAL OCCASIONS -->

	<hr width="900"></hr>

<?php
	$product_array = $db_handle->runQuery("SELECT * FROM package WHERE pkg_name='Set1A'");
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
	?>	
			<h3 class="h3-pkg">Package Buffet Menu @ <?php echo $product_array[$key]["pkg_price"]; ?>.00 for first 100 guests<br>
			In excess of <?php echo $product_array[$key]["pkg_guest"]; ?> guests, the charge will be computed @ P<?php echo $product_array[$key]["price_per_head"]; ?>.00 per head<br>
			+<?php echo $product_array[$key]["service_charge_percent"]; ?> service charge on the total amount</h3>
		
	<?php
			}
	}
	?>

<?php
	$package = $db_handle->runQuery("SELECT pkg_name FROM package ");
	$check="A";
	if (!empty($package)) { 
			foreach($package as $key=>$value){		
				$pax_name = $package[$key]['pkg_name'];
				if($pax_name == "Set1B")
				{
					
					$product_array = $db_handle->runQuery("SELECT * FROM package WHERE pkg_name='Set1B'");
					if (!empty($product_array)) { 
						foreach($product_array as $key=>$value){
					?>

				<div class="pkg-includes">
			<h2>SET A: PACKAGE INCLUDES :</h2>
			<p>a. Venue's flower arrangement<br><br>
			b. Three(3) layer cake<br><br>
			c. Wedding: Rented doves, wedding bell & wine<br><br>
			Debut: 18 roses & 18 candles, bouquet<br><br>
			d. With soup & noodles for presidential guests only</p>
		</div>
		<br>		
			<hr width="900"></hr>
			<h3 class="h3-pkg">Package Buffet Menu @ <?php echo $product_array[$key]["pkg_price"]; ?>.00 for first 100 guests<br>
			In excess of <?php echo $product_array[$key]["pkg_guest"]; ?> guests, the charge will be computed @ P<?php echo $product_array[$key]["price_per_head"]; ?>.00 per head<br>
			+<?php echo $product_array[$key]["service_charge_percent"]; ?> service charge on the total amount</h3>
		
	<?php
			}
	}
	
				}//HELLO
				if($pax_name!=$check)
				{
					$check = $pax_name;

					$pax = $db_handle->runQuery("SELECT * FROM packagelist WHERE pkg_name='$check' ");
					if (!empty($pax)) { 
					?>
					<div class="set-box">
					<h2 class="h2-pkg"><?php echo $pax[$key]["pkg_name"]; ?></h2>

		<?php
			foreach($pax as $key=>$value){		
		?>
			<p class="p-pkg"><?php echo $pax[$key]["pcl_name"]; ?>
		
	<?php
			}
			?>
			</p></div>
	<?php		
	}
	?>
			<?php
				}
				else{
					return;
				}
			}
	}
	?>

<div class="pkg-includes">
			<h2>SET B: PACKAGE INCLUDES :</h2>
			<p>a. Venue's flower arrangement<br><br>
			b. Three(3) layer cake<br><br>
			c. Wedding: Rented doves, wedding bell & wine<br><br>
			Debut: 18 roses & 18 candles, bouquet<br><br>
			d. With soup & ONE VIAND for presidential guests only</p>
		</div>
		<br>
		<!-- END OF SET B -->
		<hr width="900"></hr>

		<div class="pkg-optional">
			<h2>OPTIONAL :</h2>
			<h4>I. SALAD BAR @ P75.00 PER HEAD</h4>
			<div class="pkg-optional-mini">
				<p>A. POTATO & TUNA SALAD<br><br>
				CHICKEN & PASTA SALAD<br><br>
				TOSSED GREEN SALAD <br>
				WITH ASSORTED CONDIMENTS</p>
			</div>
			<div class="pkg-optional-mini">
				<p>B. HERBED POTATO SALAD<br><br>
				ALL PASTA SALAD<br><br>
				MIXED GREEN SALAD <br>
				WITH ASSORTED VINAIGRETTE</p>
			</div>
			<h4>II. CHOCOLATE FOUNTAINS(BROWN & WHITE) WITH ASSORTED FRUITS & MARSHMALLOW @ P85.00 PER HEAD</h4>
		</div>
		<br>
		<hr width="900"></hr>
		<div class="pkg-amenities">
			<h2>- AMENITIES -</h2>
			<h3>WEDDING/DEBUT RECEPTION PACKAGE</h3>
			<hr width="850"></hr>
			<p>
				Buffet Tables with Attractive Centerpieces<br><br>
				Tables & Chairs with Floor Length Centerpieces<br><br>
				Use of all Utensils<br><br>
				An Elegant Presidential Table with Floral Arrangement<br><br>
				Complete Floral Dress-up of Reception Area<br><br>
				Skirted Tables for Gifts and Cake<br><br>
				3-layer Bridal/Birthday Cake<br><br>
				Doves and Cage/18 roses, 18 candles & boquet<br><br>
				Ice for the Drinks & Purified Drinking Water<br><br>
				Trained and Uniformed Waiters & Buffet Attendants
			</p>
		</div>


	</div><!-- END of CONTENT -->
	<a href="#"><h3 class="back-to-top" >Back to top</h3></a>
<!-- Footer PHP FILE -->
<?php include('footer.php');
?>
	<!-- import jQuery -->
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"> -->
<script src="js/jquery-3.1.1.js"></script>
    
<!-- write script to toggle class on scroll -->
<script src="js/custom.js"></script>

</body>
</html>