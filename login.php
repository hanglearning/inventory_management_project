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
		$isActive = mysqli_fetch_assoc($isActiveQuery);
		$active = $isActive['active'];
		// User exists but not active, skip check password
		if ($active == 0){
			echo "Sorry your account has not been activated yet. Please wait for administrator to activitate your account.";
		} else {
			// User exists and active, validate Password
			$query = mysqli_query($con, "SELECT * FROM users WHERE userEmail = '$userEmail' AND userPassword = '$userPassword'");
			$num2 = mysqli_num_rows($query);
			// If password matches
			if ($num2 != 0){
				
				session_start();
				$fetch = mysqli_fetch_assoc($query);
				$_SESSION['userEmail'] = $fetch['userEmail'];
				$_SESSION['userName'] = $fetch['userName'];
				$_SESSION['userPhone'] = $fetch['userPhone'];
				$_SESSION['userQQ'] = $fetch['userQQ'];
				$_SESSION['userWeChat'] = $fetch['userWeChat'];
				$_SESSION['userReferred'] = $fetch['userReferred'];

				echo "<script>window.location.href='home.php'</script>";
			} else {
				echo "Your password is wrong.";
			}
		}
	} else {
		// User not found
		echo "Your email is not in the database. Please register.";
	}

?>