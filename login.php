<?php
	
	$userEmail 		= $_POST['userEmail'];
	$userPassword 	= $_POST['userPassword'];

	$con = mysqli_connect("localhost", "hangdev", "mindfreak", "realPro");
	if (!$con){
  		die("Connection error: " . mysqli_connect_errno());
  	}
  	// Validate userEmail exists and if it's active
  	$isActiveQuery = mysqli_query($con, "SELECT active FROM users WHERE userEmail = '$userEmail'");
	$num = mysqli_num_rows($isActiveQuery);
	
	if ($num != 0){
		// http://stackoverflow.com/questions/1692614/php-does-mysql-fetch-assoc-return-a-two-dimensional-array
		/* it returns a single row. Calling it again will return the next row, until there are no more rows. Can use a loop to get all rows */
		$isActive = mysqli_fetch_assoc($isActiveQuery);
		$active = $isActive['active'];
		// User exists but not active, skip check password
		if ($active == 0){
			echo "你的账户还未被激活，请联系神医激活！";
		} else {
			// User exists and active, validate Password
			// youtube mmtuts  42:Hashing and de-hashing using PHP
			$query = mysqli_query($con, "SELECT * FROM users WHERE userEmail = '$userEmail'");
			$fetch = mysqli_fetch_assoc($query);
			$hash_pwd = $fetch['userPassword'];
			$hash = password_verify($userPassword, $hash_pwd);
			// If password matches
			if ($hash == 0){

				echo "你的怕死沃德不办啊！再试一次吧！";	
				
			} else {
				
				session_start();
				$fetch = mysqli_fetch_assoc($query);
				$_SESSION['userId'] 		= $fetch['userId'];
				$_SESSION['userEmail'] 		= $fetch['userEmail'];
				$_SESSION['userName'] 		= $fetch['userName'];
				$_SESSION['userPhone']		= $fetch['userPhone'];
				$_SESSION['userQQ'] 		= $fetch['userQQ'];
				$_SESSION['userWeChat'] 	= $fetch['userWeChat'];
				$_SESSION['userReferred'] 	= $fetch['userReferred'];
				$_SESSION['admin'] 			= $fetch['admin'];

				if ($_SESSION['admin'] == 1){
					echo "<script>window.location.href='adminPages/adminHome.php'</script>";
				} else {
					echo "<script>window.location.href='nursePages/nurseHome.php'</script>";
				}
			}
		}
	} else {
		// User not found
		echo "你没打声招呼就想进碗里来？谁知道你有没有毒！";
	}

?>
