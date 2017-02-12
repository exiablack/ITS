<?php
if(isset($_POST['get_option']))
{
 $host = 'localhost';
 $user = 'root';
 $pass = '';
 mysql_connect($host, $user, $pass);
 mysql_select_db('senordepacencia');

 $package = $_POST['get_option'];
 $find=mysql_query("SELECT pcl_name, pcl_details from packagelist where pkg_name='$package'");
 while($row=mysql_fetch_array($find))
 {
 	
  echo "<tr><td> <select><option>".$row['pcl_name']."</option> </select></td>";
  echo "<td>".$row['pcl_details']."</td></tr>";
 }
 exit;
}
?>