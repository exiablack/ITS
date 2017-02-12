<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!isset($_SESSION['username']))
		{
			echo "<script>alert('You must sign in first to order.');document.location='login.php'</script>";
			session_destroy();
		}
		if(!empty($_POST["quantity"])) {
			$productByCode = $db_handle->runQuery("SELECT * FROM menulist WHERE code='" . $_GET["code"] . "'");
			$itemArray = array($productByCode[0]["code"]=>array('m_name'=>$productByCode[0]["m_name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'm_price'=>$productByCode[0]["m_price"]));
			
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByCode[0]["code"],$_SESSION["cart_item"])) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["code"] == $k)
								$_SESSION["cart_item"][$k]["quantity"] = $_POST["quantity"];
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["code"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
	if(!empty($_SESSION["username"])) {
			unset($_SESSION["cart_item"]);
		}else{
			
			echo "<script>alert('You must Sign in first to order.');document.location='login.php'</script>";
			session_destroy();
		}
		
	break;
	case "pay":
		if(!empty($_SESSION["username"])) {
			$account = $_SESSION["username"];
			date_default_timezone_set("Asia/Bangkok");
  			$datereserved = date("Y-m-d");

			$check = $db_handle->runQuery("SELECT * FROM foodorderinfo WHERE datereserved='$datereserved' && paymentstatus='unpaid' && username='$account'");
			if(!empty($check))
			{
				header('Location: food-order-payment.php');
			}else{
				header('Location: food-order-info.php');
			}
			
		}else{
			
			echo "<script>alert('You must Sign in first to order.');document.location='login.php'</script>";
			session_destroy();
		}
	break;	
}
}
?>
<html>
<head>
	<title>Online Reservation</title>
	<link rel="stylesheet" type="text/css" href="css/product.css"/>
</head>
<body>

<?php include('nav-banner.php');
?>
	
	<div class="content-order">
	<h1 class="big-title">- Food Order -</h1>
		<hr width="900"></hr>
		<br>
		
<div class="txt-heading">Shopping Cart <a id="btnEmpty" href="food-order.php?action=empty">Empty Cart</a> <a id="btnEmpty" href="food-order.php?action=pay">Checkout</a></div>
<table class="tbl-head" cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th><strong>Name</strong></th>
<th><strong>Code</strong></th>
<th><strong>Quantity</strong></th>
<th><strong>Price</strong></th>
<th><strong>Action</strong></th>
</tr>
</tbody>
</table>
<div id="shopping-cart">
<?php
if(isset($_SESSION["cart_item"])){
    $item_total = 0;
?>	
<table cellpadding="10" cellspacing="1">
<tbody>
<!-- <tr>
<th><strong>Name</strong></th>
<th><strong>Code</strong></th>
<th><strong>Quantity</strong></th>
<th><strong>Price</strong></th>
<th><strong>Action</strong></th>
</tr>	 -->
<?php		
    foreach ($_SESSION["cart_item"] as $item){
		?>
				<tr>
				<td><strong><?php echo $item["m_name"]; ?></strong></td>
				<td><?php echo $item["code"]; ?></td>
				<td><?php echo $item["quantity"]; ?></td>
				<td align=right><?php echo "P".$item["m_price"]; ?></td>
				<td><a href="food-order.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction">Remove Item</a></td>
				</tr>
				<?php
        $item_total += ($item["m_price"]*$item["quantity"]);
		}
		?>

<tr>
<td colspan="5" align=right><strong>Total:</strong> <?php echo "P".$item_total; ?></td>
</tr>
</tbody>
</table>		
  <?php
}
?>
</div>

<div id="product-grid">
	<div class="txt-heading">Products</div>
	<?php
	$product_array = $db_handle->runQuery("SELECT * FROM menulist ORDER BY m_id ASC");
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
	?>
		<div class="product-item">
			<form method="post" action="food-order.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
			<div class="product-image"><a class="fancybox" rel="group" href="<?php echo $product_array[$key]["m_image"]; ?>"><img src="<?php echo $product_array[$key]["m_image"]; ?>"></a></div>
			<div><strong><p class="product-name"><?php echo $product_array[$key]["m_name"]; ?></strong></div>
			<div class="product-price"><?php echo "P".$product_array[$key]["m_price"]; ?></div>
			<div><input type="text" name="quantity" value="1" size="2" /><input type="submit" value="Add to cart" class="btnAddAction" /></p></div>
			</form>
		</div>
	<?php
			}
	}
	?>
</div>

	</div><!-- End of Content -->



<!-- Footer PHP FILE -->
<?php include('footer.php');
?>
<script src="js/jquery-3.1.1.js"></script>
    
<!-- write script to toggle class on scroll -->
<script src="js/custom.js"></script>

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