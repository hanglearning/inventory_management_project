<?php
	
	session_start();
	$userId = $_SESSION['userId'];

	$userEmail 			 = $_POST["userEmail"];
	$userPassword 		 = $_POST["userPassword"];
	$userPasswordConfirm = $_POST["userPasswordConfirm"];
	$userName 			 = $_POST["userName"];
	$userPhone			 = $_POST["userPhone"];
	$userQQ 			 = $_POST["userQQ"];
	$userWeChat 		 = $_POST["userWeChat"];

	//http://stackoverflow.com/questions/19452392/adding-a-character-in-the-middle-of-a-string
	$userPhoneValidation = substr($userPhone,0,3).'-'.substr($userPhone,3,3).'-'.substr($userPhone,6,9);

	// http://stackoverflow.com/questions/3090862/how-to-validate-phone-number-using-php
	if ($userPassword == '' and $userPasswordConfirm == ''){
		if(preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $userPhoneValidation)) {
		  	$con = mysqli_connect("localhost", "chenh057_hang01", "bhgoszPg7iBcYD8WLAjeWrjEcH3LUcE96vHqCdGKnpNWZetxe", "chenh057_realPro");
			if (!$con){
		  		die("Connection error: " . mysqli_connect_errno());
		  	}
		  	//https://www.w3schools.com/php/php_mysql_update.asp 用逗号就行
		  	$sql = "UPDATE users SET userEmail='$userEmail', userName='$userName', userPhone='$userPhone', userQQ='$userQQ', userWeChat='$userWeChat' WHERE userId='$userId'";
			
			$query = mysqli_query($con, $sql);
			echo "更新成功！";
		} else {
			echo '手机号码格式无效，请重新输入！';
		}
	} else {
		if ($userPassword != $userPasswordConfirm){
			echo "两次密码输入不一致。";
		} else {
			if(preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $userPhoneValidation)) {
			  	$con = mysqli_connect("localhost", "chenh057_hang01", "bhgoszPg7iBcYD8WLAjeWrjEcH3LUcE96vHqCdGKnpNWZetxe", "chenh057_realPro");
				if (!$con){
			  		die("Connection error: " . mysqli_connect_errno());
			  	}

			  	$encrypted_password = password_hash($userPassword, PASSWORD_DEFAULT);

			  	$sql = "UPDATE users SET userEmail='$userEmail', userPassword='$encrypted_password', userName='$userName', userPhone='$userPhone', userQQ='$userQQ', userWeChat='$userWeChat' WHERE userId='$userId'";
				
				$query = mysqli_query($con, $sql);
				echo "更新成功！";
			} else {
				echo '手机号码格式无效，请重新输入！';
			}
		}
	}
?>
