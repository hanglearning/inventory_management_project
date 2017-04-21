<?php

	$userEmail 			 = $_POST["userEmail"];
	$userPassword 		 = $_POST["userPassword"];
	$userPasswordConfirm = $_POST["userPasswordConfirm"];
	$userName 			 = $_POST["userName"];
	$userPhone			 = $_POST["userPhone"];
	$userQQ 			 = $_POST["userQQ"];
	$userWeChat 		 = $_POST["userWeChat"];
	$userReferred 		 = $_POST["userReferred"];
	$registeredTime 	 = $_POST["registeredTime"];


	//http://stackoverflow.com/questions/19452392/adding-a-character-in-the-middle-of-a-string
	$userPhoneValidation = substr($userPhone,0,3).'-'.substr($userPhone,3,3).'-'.substr($userPhone,6,9);

	// http://stackoverflow.com/questions/3090862/how-to-validate-phone-number-using-php

	if ($userPassword != $userPasswordConfirm){
		echo "😂你给我的这两个怕死沃德到底哪一个才是真的？？";
	} else {
		if(preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $userPhoneValidation)) {
		  	$con = mysqli_connect("localhost", "hangdev", "mindfreak", "realPro");
			if (!$con){
		  		die("Connection error: " . mysqli_connect_errno());
		  	}
			
			$query = mysqli_query($con, "SELECT userId FROM users WHERE userEmail = '$userEmail'");
			$num = mysqli_num_rows($query);
			
			if ($num != 0){
				echo "🌚你早已注册了你的伊妹尔，为什么不先试试到碗里去？";
			} else {
				//youtube mmtuts  42:Hashing and de-hashing using PHP
				$encrypted_password = password_hash($userPassword, PASSWORD_DEFAULT);
				$sql = "INSERT INTO users (userEmail, userPassword, userName, userPhone, userQQ, userWeChat, userReferred, registeredTime) VALUES ('$userEmail', '$encrypted_password', '$userName', '$userPhone', '$userQQ', '$userWeChat', '$userReferred', '$registeredTime')";
				$see = mysqli_query($con, $sql);

				echo "<h3>等着赚大钱吧💵💵💵<strong>$userName</strong>💵💵💵! 请联系神医激活你的账户。<h3>";
			}
		} else {
			echo '你丫真以为我好蒙吗填个假电话号码来骗我！😡';
		}
	}
?>