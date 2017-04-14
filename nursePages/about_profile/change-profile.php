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
		  	$con = mysqli_connect("localhost", "hangdev", "mindfreak", "realPro");
			if (!$con){
		  		die("Connection error: " . mysqli_connect_errno());
		  	}
		  	//https://www.w3schools.com/php/php_mysql_update.asp 用逗号就行
		  	$sql = "UPDATE users SET userEmail='$userEmail', userName='$userName', userPhone='$userPhone', userQQ='$userQQ', userWeChat='$userWeChat' WHERE userId='$userId'";
			
			$query = mysqli_query($con, $sql);
			echo "🌚成功更换马甲（但哥还是一样认得你）！为防止你频繁换甲，名字的更改下次登入生效。";
		} else {
			echo '即便你换了新号，哥还是能认出来你给我的是假的！😡';
		}
	} else {
		if ($userPassword != $userPasswordConfirm){
			if ($userPassword == '' || $userPasswordConfirm==''){
				echo "不要考验我的耐心。🙄";
			} else {
				echo "😂即便要更换密码你也不该给我俩让我猜你想换的是哪一个！";
			}
		} else {
			if(preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $userPhoneValidation)) {
			  	$con = mysqli_connect("localhost", "hangdev", "mindfreak", "realPro");
				if (!$con){
			  		die("Connection error: " . mysqli_connect_errno());
			  	}

			  	$encrypted_password = password_hash($userPassword, PASSWORD_DEFAULT);

			  	$sql = "UPDATE users SET userEmail='$userEmail', userPassword='$encrypted_password', userName='$userName', userPhone='$userPhone', userQQ='$userQQ', userWeChat='$userWeChat' WHERE userId='$userId'";
				
				$query = mysqli_query($con, $sql);
				echo "🌚成功更换马甲（但哥还是一样认得你）！";
			} else {
				echo '即便你换了新号，哥还是能认出来你给我的是假的！😡';
			}
		}
	}
?>