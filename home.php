<DOCTYPE! html>
<html>
<head>
	<title>Welcome Back!</title>
</head>
<body>
</html>


<?php
	session_start();
	$userEmail 		= $_SESSION['userEmail'] 
	$userName 		= $_SESSION['userName']
	$userPhone 		= $_SESSION['userPhone']
	$userQQ 		= $_SESSION['userQQ'] 
	$userWeChat 	= $_SESSION['userWeChat']
	$userReferred 	= $_SESSION['userReferred']
	$admin 			= $_SESSION['admin'];



	echo "Welcome $userName";
?>