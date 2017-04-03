<?php
	
	$userEmail 		= $_POST["userEmail"];
	$userPassword 	= $_POST["userPassword"];
	$userName 		= $_POST["userName"];
	$userPhone		= $_POST["userPhone"];
	$userQQ 		= $_POST["userQQ"];
	$userWeChat 	= $_POST["userWeChat"];
	$userReferred 	= $_POST["userReferred"];

	$con = mysqli_connect("localhost", "hangdev", "mindfreak", "realPro");
	if (!$con){
  		die("Connection error: " . mysqli_connect_errno());
  	}
	
	$query = mysqli_query($con, "SELECT userId FROM users WHERE userEmail = '$userEmail'");
	$num = mysqli_num_rows($query);
	
	if ($num != 0){
		echo "This email has already been registered. Please try login.";
	} else {
		$sql = "INSERT INTO users (userEmail, userPassword, userName,
			userPhone, userQQ, userWeChat, userReferred) VALUES ('$userEmail', '$userPassword', '$userName',
			'$userPhone', '$userQQ', '$userWeChat', '$userReferred')";
		$see = mysqli_query($con, $sql);
		
		echo "Thank you $userName! You have succefully registered and please wait for the administrator to activate your account.</br>";
	}

?>