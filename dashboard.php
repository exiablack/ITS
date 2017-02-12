<?php
session_start();
$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "senordepacencia";

$account="";
$qPaxprice="";
$Qeventtype="";
$Qeventdate="";
$Qsetup_time="";
$Qservice_end="";
$Qpax="";
$Qvenue="";
$Qmotif="";
$Qstatus="";
$Qpkg_name="";
$Qtotal="";

$qOp[1]="";
$qOp[2]="";
$qOp[3]="";
$qOp[4]="";
$qTotal="";

$q2Total="";
$qOps[1]="";
$qOps[2]="";
$qOps[3]="";
$qOps[4]="";
$ops[1]="";
$ops[2]="";
$ops[3]="";
$ops[4]="";

$beef="";
$fish="";
$chicken="";
$noodles="";
$vegetables="";
$rice="";
$dessert="";
$drinks="";
$cardnumberErr="";
$rsv_max_id="";
$qPaxprice="";
if(isset($_SESSION['username'])){
  $account = $_SESSION['username'];
}

$connect = mysqli_connect($hostname, $username, $password, $databaseName);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{
    $connect = mysqli_connect($hostname, $username, $password, $databaseName);
    
}catch(Exception $ex)
{
    echo 'Error';
}

$query = "SELECT datereserved FROM reservationlist WHERE paymentstatus='paid' && status='reserve' && username='$account'";
$select_menulist="SELECT foi_id, datereserved FROM foodorderinfo WHERE paymentstatus='paid' && status='pending' && username='$account'";
$query2 = "SELECT datereserved FROM foodorderinfo WHERE paymentstatus='paid' && status='reserve' && username='$account'";

$result1 = mysqli_query($connect, $query);
$result2 = mysqli_query($connect, $select_menulist);
$result3 = mysqli_query($connect, $query2);

?>
<!DOCTYPE HTML>  
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/dashboard.css">
<link rel="stylesheet" type="text/css" href="css/dashboard2.css">
<link rel="stylesheet" type="text/css" href="css/header-center.css">

 <script src="js/jquery-3.1.1.js"></script>
    
<!-- write script to toggle class on scroll -->
    <script src="js/custom.js"></script>

    <script src="jquery/jquery.min.js" type="text/javascript"></script>
    <script src="jquery/jquery-ui.min.js" type="text/javascript"></script>
    <link href="jquery/jquery-ui.css" rel="Stylesheet" type="text/css" />

<script type="text/javascript">
function fetch_history(val)
{
 $.ajax({
 type: 'post',
 url: 'reservation/fetch_history.php',
 data: {
  get_history:val
 },
 success: function (response) {
  document.getElementById("display_history").innerHTML=response; 
 }
 });
}
function fetch_historyFood(val)
{
 $.ajax({
 type: 'post',
 url: 'reservation/fetch_historyFood.php',
 data: {
  get_historyFood:val
 },
 success: function (response) {
  document.getElementById("display_historyFood").innerHTML=response; 
 }
 });
}
function fetch_pendingFood(val)
{
 $.ajax({
 type: 'post',
 url: 'reservation/fetch_pendingFood.php',
 data: {
  get_pendingFood:val
 },
 success: function (response) {
  document.getElementById("display_pendingFood").innerHTML=response; 
 }
 });
}
function fetch_pendingFood2(val)
{
 $.ajax({
 type: 'post',
 url: 'reservation/fetch_pendingFood2.php',
 data: {
  get_pendingFood2:val
 },
 success: function (response) {
  document.getElementById("display_pendingFood2").innerHTML=response; 
 }
 });
}
</script>
<style>
.hex {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

li {
    float: left;
}

li a, .dropbtn {
    display: inline-block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover, .dropdown:hover .dropbtn {
    background-color: red;
}

li.dropdown {
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
    display: block;
}
</style>
</head>
<body>  
<?php include('nav-banner.php');
?>
<div class="content-dashboard">
 <h1 class="big-title">- Dashboard -</h1>
    <hr width="900"></hr>

<ul class="hex">
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">Food Order</a>
    <div class="dropdown-content">
     <a href="javascript:void(0)" class="tablinks" onclick="openDashboard(event, 'PendingFoodOrder')" id="defaultOpen">Pending</a>
     <a href="javascript:void(0)" class="tablinks" onclick="openDashboard(event, 'HistoryFoodOrder')">Transaction History</a>
    </div>
    <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">Reservation</a>
    <div class="dropdown-content">
       <a href="javascript:void(0)" class="tablinks" onclick="openDashboard(event, 'Pending')">Pending</a>
      <a href="javascript:void(0)" class="tablinks" onclick="openDashboard(event, 'History')">Transaction History</a>
    </div>
</ul>


 <div id="Pending" class="tabcontent">
<?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');
  
$select_menulist=mysql_query("SELECT * from menureserved WHERE username='$account' && status='pending' && paymentstatus='paid' && mr_id=(SELECT MAX(mr_id) FROM reservationlist WHERE username='$account')");
  while($row=mysql_fetch_array($select_menulist))
  {
    $beef= $row['beef'];
    $fish= $row['fish'];
    $chicken= $row['chicken'];
    $noodles= $row['noodles'];
    $vegetables= $row['vegetables'];
    $rice= $row['rice'];
    $dessert= $row['dessert'];
    $drinks= $row['drinks'];
  }


  $query=mysql_query("SELECT c.price_per_head, a.eventtype, a.eventdate, a.setup_time, a.service_end, a.pax, a.venue, a.motif, a.status, b.pkg_name, b.op1, b.op2, b.op3, b.op4, b.paymentstatus, b.status, b.total FROM reservationlist as a INNER JOIN packagereserve as b ON a.username=b.username INNER JOIN package as c ON b.pkg_name=c.pkg_name INNER JOIN bpipayment as d ON a.username=d.username WHERE b.paymentstatus='paid' && b.paymentstatus='paid' && b.status='pending' && d.type='reservation' && a.username='$account'");
  	while($row=mysql_fetch_array($query))
	{
		$qPaxprice=$row['price_per_head'];
		$Qeventtype=$row['eventtype'];
		$Qeventdate=$row['eventdate'];
		$Qsetup_time=$row['setup_time'];
		$Qservice_end=$row['service_end'];
		$Qpax=$row['pax'];
		$Qvenue=$row['venue'];
		$Qmotif=$row['motif'];
		$Qstatus=$row['status'];
		$Qpkg_name=$row['pkg_name'];
		$qOp[1]=$row['op1'];
		$qOp[2]=$row['op2'];
		$qOp[3]=$row['op3'];
		$qOp[4]=$row['op4'];
		$Qtotal=$row['total'];
	}
	if ($qOp[1]!="none") {

    }else{
      $ops[1] = "";
      $qOp[1] = "";
    }
    if ($qOp[2]!="none") {
      
    }else{
      $ops[2] = "";
      $qOp[2] = "";
    }
    if ($qOp[3]!="none") {
      
    }else{
      $ops[3] = "";
      $qOp[3] = "";
    }
    if ($qOp[4]!="none") {
    
    }else{
      $ops[4] = "";
      $qOp[4] = "";
    }
  	for ($i=1; $i <= 4; $i++) { 
      if($qOp[$i] != "")
      {
      $qoptional=mysql_query("SELECT op_price FROM tbl_optional WHERE op_name = '$qOp[$i]'");
        while($row=mysql_fetch_array($qoptional))
          {
            $qOps[$i]="(P ".$row['op_price']."&nbsp; Per Head)";
            $ops[$i] = $row['op_price'];
        }
      }else{
        $qOps[$i]="";
      }
    }
 ?>
	<div class="customer_info">
		<h4 class="title"> Event Information</h4>
    <table class='tbl-head' cellpadding='10' cellspacing='1'>
    <tbody>
    <tr><td><strong>Event Type: </strong></td><td><?php echo $Qeventtype;?></td></tr>
    <tr><td><strong>Event Date: </strong></td><td><?php echo $Qeventdate;?></td></tr> 
    <tr><td><strong>Setup Time: </strong></td><td><?php echo $Qsetup_time;?></td></tr> 
    <tr><td><strong>Service End: </strong></td><td><?php echo $Qservice_end;?></td></tr> 
    <tr><td><strong>Number of Guests: </strong></td><td><?php echo $Qpax;?></td></tr>
    <tr><td><strong>Venue: </strong></td><td><?php echo $Qvenue;?></td></tr> 
    <tr><td><strong>Motif: </strong></td><td><?php echo $Qmotif;?></td></tr>  
    </tbody>
    </table> 


			<br>
		<h4 class="title"> Package Information</h4>
    <table cellpadding='10' cellspacing='1'>
    <tbody>
    <tr><td><strong>Pax Name: </strong></td><td><?php echo $Qpkg_name;?></td></tr>
    <tr><td><strong>Pax Price Per Head: </strong></td><td><?php echo $qPaxprice;?></td></tr> 
    
   
    <?php
  echo "<tr><td><strong>Sub Total :  </strong>  &nbsp;&nbsp;&nbsp;".$Qpax." x ".$qPaxprice."</td><td>P ".$qPaxprice * $Qpax." </td></tr>";
  echo "<tr><td><strong>Beef: </strong></td><td>".$beef."</td><tr>";
  echo "<tr><td><strong>Fish: </strong></td><td>".$fish."</td><tr>";
  echo "<tr><td><strong>Chicken: </strong></td><td>".$chicken."</td><tr>";
  echo "<tr><td><strong>Noodles: </strong></td><td>".$noodles."</td><tr>";
  echo "<tr><td><strong>Vegetables: </strong></td><td>".$vegetables."</td><tr>";
  echo "<tr><td><strong>Rice: </strong></td><td>".$rice."</td><tr>";
  echo "<tr><td><strong>Dessert: </strong></td><td>".$dessert."</td><tr>";
  echo "<tr><td><strong>Drinks: </strong></td><td>".$drinks."</td><tr>";
  echo "<tr><td colspan='5'><strong>Optionals: </strong></td></tr>";
   if($qOp[1]=="none"){ }
  else {
   echo "<tr><td>".$qOp[1]." ".$qOps[1]." x ".$Qpax."</td><td>P ".$ops[1] * $Qpax."</td></tr>"; }
    if($qOp[2]=="none"){ }
  else {
   echo "<tr><td>".$qOp[2]." ".$qOps[2]." x ".$Qpax."</td><td>P ".$ops[2] * $Qpax."</td></tr>"; }
    if($qOp[3]=="none"){ }
  else {
   echo "<tr><td>".$qOp[3]." ".$qOps[3]." x ".$Qpax."</td><td>P ".$ops[3] * $Qpax."</td></tr>"; }
    if($qOp[4]=="none"){ }
  else {
   echo "<tr><td>".$qOp[4]." ".$qOps[4]." x ".$Qpax."</td><td>P ".$ops[4] * $Qpax."</td></tr>"; } 
    ?>
    
    <tr><td><strong>Total: </strong></td><td>P<?php echo $Qtotal;?></td></tr> 
    </tbody>
    </table> 
	
	</div>
	<div class="status_info">
		<h4 class="title"> Reservation Status</h4>
    <?php
     $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');

  $select=mysql_query("SELECT COUNT(eventdate) FROM reservationlist WHERE paymentstatus='paid' && status='pending' && username='$account'" );
  while($row=mysql_fetch_array($select))
  {
    $pendingStat = $row["0"];
  }
  if($pendingStat == 0)
    $pendingStat = "NONE";
    ?>
		<label>Status: </label> Pending ( <?php echo $pendingStat;?> )
	</div>
 </div>

<div id="History" class="tabcontent">
	<div class="history_customer">
		<h4 class="title"> Menu Information</h4>
		<label>Date Reserved: </label> 
		<select class="selectDate" onchange="fetch_history(this.value);">
    <option value="">-Select Date Reserved-</option>
			<?php while($row1 = mysqli_fetch_array($result1)):;?>

				
            	<option value="<?php echo $row1['foi_id'];?>"><?php echo $row1['datereserved'];?></option>

            <?php endwhile;?>                  
        </select>
			
      <table class="tbl-head" cellpadding="10" cellspacing="1">
      
      <table id="display_history" cellpadding="10" cellspacing="1">
      <!-- Fetch_data.php values insert here -->
      <tbody>   
      </tbody>
      </table>

	</div>

</div>

<div id="PendingFoodOrder" class="tabcontent">

  <div class="customer_info">
    <h4 class="title"> Food Order Information</h4>

<table class="tbl-head" cellpadding="10" cellspacing="1">
      
      <table id="display_pendingFood" cellpadding="10" cellspacing="1">
      <!-- Fetch_data.php values insert here -->
      <tbody>   
      </tbody>
      </table>

      <br>
    <h4 class="title"> Menu Information</h4>
    <table class="tbl-head" cellpadding="10" cellspacing="1">
      
      <table id="display_pendingFood2" cellpadding="10" cellspacing="1">
      <!-- Fetch_data.php values insert here -->
      <tbody>   
      </tbody>
      </table>
  
  </div>
  <div class="status_info">
    <h4 class="title"> Food Order Status</h4>
    <?php
     $host = 'localhost';
  $user = 'root';
  $pass = '';
  mysql_connect($host, $user, $pass);
  mysql_select_db('senordepacencia');

  $select=mysql_query("SELECT COUNT(datereserved) FROM foodorderinfo WHERE paymentstatus='paid' && status='pending' && username='$account'" );
  while($row=mysql_fetch_array($select))
  {
    $pendingStat = $row["0"];
  }
  if($pendingStat == 0)
    $pendingStat = "NONE";

    ?>
    <label>Status: </label> Pending ( <?php echo $pendingStat;?> )<br><br>
    <label>Select Date Reserved:</label> 
    <select class="selectDate2" onchange="fetch_pendingFood(this.value); fetch_pendingFood2(this.value);">
    <option value=""></option>
    <?php while($row1 = mysqli_fetch_array($result2)):;?>

        
              <option value="<?php echo $row1['foi_id'];?>"><?php echo $row1['datereserved'];?></option>

            <?php endwhile;
            ?>
                 
    </select>
  </div>
 </div>
<div id="HistoryFoodOrder" class="tabcontent">
  <div class="history_customer">
    <h4 class="title"> Menu Information</h4>
    <label>Date Reserved: </label> 
    <select class="selectDate" onchange="fetch_historyFood(this.value);">
    <option value="">-Select Date Reserved-</option>
      <?php while($row1 = mysqli_fetch_array($result3)):;?>

        
              <option value="<?php echo $row1['datereserved'];?>"><?php echo $row1['datereserved'];?></option>

            <?php endwhile;?>                  
        </select>
      
      <table class="tbl-head" cellpadding="10" cellspacing="1">
      
      <table id="display_historyFood" cellpadding="10" cellspacing="1">
      <!-- Fetch_data.php values insert here -->
      <tbody>   
      </tbody>
      </table>

  </div>

</div>
</div><!--End of Content -->

</body>
</html>

<script>
function openDashboard(evt, dash) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(dash).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
