<?php
session_start();
if(isset($_POST['get_history']))
{
 $host = 'localhost';
 $user = 'root';
 $pass = '';

$Qeventtype="";
$Qeventdate="";
$Qsetup_time="";
$Qservice_end="";
$Qpax="";
$Qvenue="";
$Qmotif="";
$Qpkg_name="";
$Qop1="";
$Qop2="";
$Qop3="";
$Qop4="";
$Qtotal="";

$beef="";
$fish="";
$chicken="";
$noodles="";
$vegetables="";
$rice="";
$dessert="";
$drinks="";
 $historyDate = $_POST['get_history'];
if(isset($_SESSION['username'])){
  $account = $_SESSION['username'];
}
 mysql_connect($host, $user, $pass);
 mysql_select_db('senordepacencia');


$select_menu=mysql_query("SELECT * from menureserved WHERE username='$account' && paymentstatus='paid' && status='reserve' && datereserved='$historyDate' && mr_id=(SELECT MAX(mr_id) FROM menureserved WHERE username='$account')");
  while($row=mysql_fetch_array($select_menu))
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

 $historyDate = $_POST['get_history'];
 $find=mysql_query("SELECT a.eventtype, a.eventdate, a.setup_time, a.service_end, a.pax, a.venue, a.motif, b.pkg_name, b.op1, b.op2, b.op3, b.op4, b.total, b.status FROM reservationlist as a INNER JOIN packagereserve as b ON a.datereserved=b.datereserved WHERE a.datereserved='$historyDate' && b.status='reserve'");
 while($row=mysql_fetch_array($find))
 {

    $Qeventtype=$row['eventtype'];
    $Qeventdate=$row['eventdate'];
    $Qsetup_time=$row['setup_time'];
    $Qservice_end=$row['service_end'];
    $Qpax=$row['pax'];
    $Qvenue=$row['venue'];
    $Qmotif=$row['motif'];
    $Qpkg_name=$row['pkg_name'];
    $Qop1=$row['op1'];
    $Qop2=$row['op2'];
    $Qop3=$row['op3'];
    $Qop4=$row['op4'];
    $Qtotal=$row['total'];
 
 }
if($Qop1=="")
{
  $Qop1 = "None";
}
if($Qop2=="")
{
  $Qop2= "None";
}
if($Qop3=="")
{
  $Qop3= "None";
}
if($Qop4=="")
{
  $Qop4= "None";
}

 echo "<tr><td><strong> Event Type</strong></td>";
  echo "<td>".$Qeventtype."</td></tr>";
  echo "<tr><td><strong> Event Date</strong></td>";
  echo "<td>".$Qeventdate."</td></tr>";
  echo "<tr><td><strong> Setup Time</strong></td>";
  echo "<td>".$Qsetup_time."</td></tr>";
  echo "<tr><td><strong> Service End</strong></td>";
  echo "<td>".$Qservice_end."</td></tr>";
  echo "<tr><td><strong> Number of Guests</strong></td>";
  echo "<td>".$Qpax."</td></tr>";
  echo "<tr><td><strong> Venue</strong></td>";
  echo "<td>".$Qvenue."</td></tr>";
  echo "<tr><td><strong> Motif</strong></td>";
  echo "<td>".$Qmotif."</td></tr>";
  echo "<tr><td><strong> Pax Name</strong></td>";
  echo "<td>".$Qpkg_name."</td></tr>";
  echo "<tr><td><strong>Beef: </strong></td><td>".$beef."</td><tr>";
  echo "<tr><td><strong>Fish: </strong></td><td>".$fish."</td><tr>";
  echo "<tr><td><strong>Chicken: </strong></td><td>".$chicken."</td><tr>";
  echo "<tr><td><strong>Noodles: </strong></td><td>".$noodles."</td><tr>";
  echo "<tr><td><strong>Vegetables: </strong></td><td>".$vegetables."</td><tr>";
  echo "<tr><td><strong>Rice: </strong></td><td>".$rice."</td><tr>";
  echo "<tr><td><strong>Dessert: </strong></td><td>".$dessert."</td><tr>";
  echo "<tr><td><strong>Drinks: </strong></td><td>".$drinks."</td><tr>";
  echo "<tr><td><strong> Optional 1</strong></td>";
  echo "<td>".$Qop1."</td></tr>";
  echo "<tr><td><strong> Optional 2</strong></td>";
  echo "<td>".$Qop2."</td></tr>";
  echo "<tr><td><strong> Optional 3</strong></td>";
  echo "<td>".$Qop3."</td></tr>";
  echo "<tr><td><strong> Optional 4</strong></td>";
  echo "<td>".$Qop4."</td></tr>";
  echo "<tr><td><strong> Total (PHP)</strong></td>";
  echo "<td>".$Qtotal."</td></tr>";
 exit;
}
?>