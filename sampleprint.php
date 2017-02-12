<?php
  session_start();
$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "senordepacencia";
// define variables and set to empty values
$packagename="";
$opt1="";
$opt2="";
$opt3="";
$opt4="";
  date_default_timezone_set("Asia/Bangkok");
  $datereserved = date("Y-m-d");
$packageprice=0;
$optional="";
$please="";
$optional1="";
$optional2="";
$optional3="";
$optional4="";
$counter="";
$count="";
$numberofpax=0;
$total="";
$account ="none";
if(isset($_SESSION['username']))
{
  $account= $_SESSION['username'];

  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');

  $select=mysql_query("SELECT pax from reservationlist WHERE username='$account' && rsv_id=(SELECT MAX(rsv_id) FROM reservationlist)");
  while($row=mysql_fetch_array($select))
  {
   $num = $row['pax'];
   $numberofpax = Intval($num);
  }
}

?>

<!DOCTYPE HTML>  
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/reservation-style.css">
<link rel="stylesheet" type="text/css" href="css/header-center.css">
  <link rel="stylesheet" type="text/css" href="reservation/css/packageForm.css">
 <script src="js/jquery-3.1.1.js"></script>
    
<!-- write script to toggle class on scroll -->
    <script src="js/custom.js"></script>

    <script src="jquery/jquery.min.js" type="text/javascript"></script>
    <script src="jquery/jquery-ui.min.js" type="text/javascript"></script>
    <link href="jquery/jquery-ui.css" rel="Stylesheet" type="text/css" />
    
</head>
<body>  
<?php include('nav-banner.php');
?>


<div class="content-reservation">
 <h1 class="big-title">- Reservation -</h1>
    <hr width="900"></hr>
  <?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');
  $option =1;
  $query=mysql_query("SELECT a.c_fname, a.c_lname, a.contno, b.eventtype, b.eventdate, b.setup_time, b.service_end, b.pax, b.venue, b.motif, c.pkg_name, c.op1, c.op2, c.op3, c.op4, c.total FROM customerinfo as a INNER JOIN reservationlist as b ON a.username=b.username INNER JOIN packagereserve as c ON b.username=c.username WHERE a.username='$account'");
  while($row=mysql_fetch_array($query))
  {
      
   echo "<p class='names'>First Name: ". $row['c_fname']. " &nbsp; Last Name: ". $row['c_lname']."<br>";
   echo "Contact No: ".$row['contno']."<br>";
   echo "Event Type: ".$row['eventtype']."<br>";
   echo "Date of Event: ".$row['eventdate']."<br>";
   echo "Serviece Start: ".$row['setup_time']."<br>";
   echo "Service End: ".$row['service_end']."<br>";
   echo "Number of Guest: ".$row['pax']."<br>";
   echo "Event Venue: ".$row['venue']."<br>";
   echo "Motif: ".$row['motif']."<br>";
   echo "Package Name: ".$row['pkg_name']."<br>";
   echo "Optional1: ".$row['op1']."<br>";
   echo "Optional2: ".$row['op2']."<br>";
   echo "Optional3: ".$row['op3']."<br>";
   echo "Optional4: ".$row['op4']."<br>";
   echo "Total: ".$row['total']."<br></p>";
    
  }
 ?>
 
</div><!--End of Content -->

</body>
</html>
