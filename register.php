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
		echo "你早已注册了你的伊妹尔，为什么不先试试到碗里去？";
	} else {
		//youtube mmtuts  42:Hashing and de-hashing using PHP
		$encrypted_password = password_hash($userPassword, PASSWORD_DEFAULT);
		$sql = "INSERT INTO users (userEmail, userPassword, userName,
			userPhone, userQQ, userWeChat, userReferred) VALUES ('$userEmail', '$encrypted_password', '$userName',
			'$userPhone', '$userQQ', '$userWeChat', '$userReferred')";
		$see = mysqli_query($con, $sql);
		
		echo "等着赚大钱吧$userName! 请联系神医激活你的账户。</br>";
	}

?>