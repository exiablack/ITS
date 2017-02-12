<?php include_once('functions.php');

$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "senordepacencia";

$maxDate = "";
$connect = mysqli_connect($hostname, $username, $password, $databaseName);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{
    $connect = mysqli_connect($hostname, $username, $password, $databaseName);
    
}catch(Exception $ex)
{
    echo 'Error';
}

$query = "SELECT max_date FROM maintenance";

$result1 = mysqli_query($connect, $query);
while ($row1 = mysqli_fetch_array($result1)) {
	$maxDate = $row1["max_date"];
}

 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Online Reservation</title>
	<link type="text/css" rel="stylesheet" href="style.css"/>
	<link type="text/css" rel="stylesheet" href="css/calendar.css"/>
	<link type="text/css" rel="stylesheet" href="css/header-center.css"/>
	<script src="jquery.min.js"></script>
</head>
<body>
<?php include('nav-banner.php');
?>

		<div class="content-calendar">
		<h1 class="big-title">- Calendar Of Events -</h1>
		<hr width="900"></hr>
			<div class="legend">
				<p><strong>NOTE:</strong> &nbsp; Max Event Per Day ( <?php echo $maxDate;?> )</p>
			</div>

			<div id="calendar_div">
				<?php echo getCalender(); ?>
			</div>

		</div>
		<!-- Footer PHP FILE -->
		<?php
    		include('footer.php');
		?>
	

	<!-- import jQuery -->
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"> -->
<script src="js/jquery-3.1.1.js"></script>
    
<!-- write script to toggle class on scroll -->
<script src="js/custom.js"></script>

</body>
</html>