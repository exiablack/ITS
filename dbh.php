<?php
$conn = mysqli_connect("localhost","root","","senordepacencia");
if(!$conn)
{
	/* delete mysqli_connect_error() in deployment*/
	/* mysqli_connect_error() prone to sql injection*/
	die("Connection failed: ".mysqli_connect_error());
}
?>