<?php
session_start();
if(isset($_POST['get_historyFood']))
{
 $historyDate = $_POST['get_historyFood'];
 $host = 'localhost';
 $user = 'root';
 $pass = '';

$_foi_id="";
$_firstname="";
$_lastname="";  
$_contactno="";
$_address="";
$_deliveryDate="";
$_deliveryTime="";
$_total="";
if($historyDate==""){
  exit();
}
if(isset($_SESSION['username'])){
  $account = $_SESSION['username'];
}

 mysql_connect($host, $user, $pass);
 mysql_select_db('senordepacencia');

$select_menulist=mysql_query("SELECT a.foi_id, a.firstname, a.lastname, a.contactno, a.address, a.deliverydate, a.deliverytime, b.foi_id, b.total FROM foodorderinfo as a INNER JOIN foodorderdetails as b ON a.foi_id=b.foi_id WHERE a.paymentstatus='paid' && a.datereserved='$historyDate' && a.status='reserve' && a.username='$account'");
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
    
      <tbody>   
      </tbody>
      </table>
<table cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th style="background-color: orange;"><strong>Menu Name</strong></th>
<th style="background-color: orange;"><strong>Code</strong></th>
<th style="background-color: orange;"><strong>Quantity</strong></th>
<th style="background-color: orange;"><strong>Price</strong></th>
</tr> 
 <?php
$select_menulist=mysql_query("SELECT a.foi_id, b.total, c.m_name, c.code, c.quantity, c.m_price FROM foodorderinfo as a INNER JOIN foodorderdetails as b ON a.foi_id=b.foi_id INNER JOIN foodordermenus as c ON b.foi_id=c.foi_id WHERE a.paymentstatus='paid' && a.status='reserve' && a.datereserved='$historyDate' && a.username='$account'");
  while($row=mysql_fetch_array($select_menulist))
  {
    $total=$row['total'];
?>
    <tr><td><?php echo $row['m_name']?></td><td><?php echo $row['code'];?></td><td><?php echo $row['quantity'];?></td><td><?php echo $row['m_price']?></td></tr>
   
    

  <?php
}?>
<tr><td colspan='5' align=right><strong>Total:</strong> <?php echo $_total;?></td></tr>
<?php exit;
}
?>