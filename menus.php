<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();

?>
<html>
<head>
	<title>Online Reservation</title>
	<link rel="stylesheet" type="text/css" href="css/header-center.css"/>
	<link rel="stylesheet" type="text/css" href="css/menus.css"/>

</head>
<body>

<?php include('nav-banner.php');
?>
	
	<div class="content-menu">
	<h1 class="big-title">- Menu -</h1>
		<hr width="900"></hr>
		<br>

	<?php
	$product_array = $db_handle->runQuery("SELECT * FROM menulist ORDER BY m_id ASC");
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
	?>
		<div class="product-item">

			<div class="product-image"><a class="fancybox" rel="group" href="<?php echo $product_array[$key]["m_image"]; ?>"><img src="<?php echo $product_array[$key]["m_image"]; ?>" alt="<?php echo $product_array[$key]["m_name"]; ?>"></a></div>
			<div><strong><p class="product-name"><?php echo $product_array[$key]["m_name"]; ?></strong></div>
			<!--
			<div class="product-price"><?php echo "P".$product_array[$key]["m_price"]; ?></div>
			<div><input type="text" name="quantity" value="1" size="2" /><input type="submit" value="Add to cart" class="btnAddAction" /></p></div>
			-->

		</div>
	<?php
			}
	}
	?>


	</div><!-- End of Content -->



<!-- Footer PHP FILE -->
<?php include('footer.php');
?>
<script src="jquery/jquery-3.1.1.js"></script>
    
<!-- write script to toggle class on scroll -->
<script src="jquery/custom.js"></script>

 <!-- Add jQuery library -->
    <script type="text/javascript" src="jquery/jquery-latest.min.js"></script>

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="jquery/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox -->
<link rel="stylesheet" href="source/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="source/jquery.fancybox.pack.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>

</body>
</html>