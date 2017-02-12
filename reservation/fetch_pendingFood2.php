<?php
session_start();
if(isset($_POST['get_pendingFood2']))
{
 $qfoi_id = $_POST['get_pendingFood2'];
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

$select_menulist=mysql_query("SELECT a.foi_id, b.total, c.m_name, c.code, c.quantity, c.m_price FROM foodorderinfo as a INNER JOIN foodorderdetails as b ON a.foi_id=b.foi_id INNER JOIN foodordermenus as c ON b.foi_id=c.foi_id WHERE a.paymentstatus='paid' && a.status='pending' && a.foi_id='$qfoi_id' && a.username='$account'");
  while($row=mysql_fetch_array($select_menulist))
  {
    $total=$row['total'];
?>
    <tr><td><?php echo $row['m_name']?></td><td><?php echo $row['code'];?></td><td><?php echo $row['quantity'];?></td><td><?php echo $row['m_price']?><td></tr>
   
    

  <?php
}?>
<tr><td colspan='5' align=right><strong>Total:</strong> <?php echo $total;?></td></tr>

<?php   
exit;
}
?>