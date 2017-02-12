<?php
session_start();
if(isset($_POST['get_pendingFood']))
{
 $qfoi_id = $_POST['get_pendingFood'];
 $host = 'localhost';
 $user = 'root';
 $pass = '';

if($qfoi_id==""){
  exit();
}
if(isset($_SESSION['username'])){
  $account = $_SESSION['username'];
}

 mysql_connect($host, $user, $pass);
 mysql_select_db('senordepacencia');

$select_menulist=mysql_query("SELECT a.foi_id, a.firstname, a.lastname, a.contactno, a.address, a.deliverydate, a.deliverytime, b.foi_id, b.total FROM foodorderinfo as a INNER JOIN foodorderdetails as b ON a.foi_id=b.foi_id WHERE a.paymentstatus='paid' && a.foi_id='$qfoi_id' && a.status='pending' && a.username='$account'");
  while($row=mysql_fetch_array($select_menulist))
  {
    $_foi_id=$row['foi_id'];
    $_firstname=$row['firstname'];
    $_lastname=$row['lastname'];  
    $_contactno=$row['contactno'];
    $_address=$row['address'];
    $_deliveryDate=$row['deliverydate'];
    $_deliveryTime=$row['deliverytime'];
    $_total=$row['total'];
  }
?>
    
  <tr><td><strong>Name: </strong></td><td><?php echo $_firstname;?> <?php echo $_lastname;?></td></tr>
    <tr><td><strong>Contact No: </strong></td><td><?php echo $_contactno;?></td></tr> 
    <tr><td><strong>Address: </strong></td><td><?php echo $_address;?></td></tr> 
    <tr><td><strong>Delivery Date: </strong></td><td><?php echo $_deliveryDate;?></td></tr> 
    <tr><td><strong>Delivery Time: </strong></td><td><?php echo $_deliveryTime;?></td></tr>
    <tr><td colspan='5' align=right><strong>Total:</strong> <?php echo $_total;?></td></tr>
 <?php exit;
}
?>