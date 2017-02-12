<?php
session_start();
include '../dbh.php';

$first = $_POST['firstname'];
$last = $_POST['lastname'];
$uid = $_POST['username'];
$pwd = $_POST['password'];
$email = $_POST['email'];


	$sql = "select username from accounts where username='$uid'";
	$result = mysqli_query($conn, $sql);
	$uidcheck = mysqli_num_rows($result);
		if($uidcheck > 0)
		{
			header("Location: ../register.php?error=empty");
			exit();
		}else{
			$encrypted_password = password_hash($pwd, PASSWORD_DEFAULT);
			$sql = "insert into accounts (username, fname, lname, password, email) values ('$uid', '$first','$last','$encrypted_password','$email')";
		$result = mysqli_query($conn, $sql);
		header("Location: ../index.php");
		}

		
?>