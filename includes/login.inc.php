<?php
session_start();
include '../dbh.php';

$uid = $_POST['uid'];
$pwd = $_POST['pwd'];


$sql = "select * from accounts where username ='$uid'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$hash_pwd = $row['password'];
$hash = password_verify($pwd, $hash_pwd);

if($hash == 0)
{
	header("Location: ../login.php?error=empty");
	exit();
}else{
	$sql = "select * from accounts where username='$uid' AND password='$hash_pwd'";
	$result = mysqli_query($conn, $sql);
	if(!$row = mysqli_fetch_assoc($result))
	{
		echo "<script>alert('Incorrect Username or Password!');document.location='../login.php?error=incorrect'</script>";
	}else{
		$_SESSION['username'] = $row['username'];
	}
	echo "<script>alert('Welcome back ". $_SESSION['username']."');document.location='../index.php'</script>";
}


?>