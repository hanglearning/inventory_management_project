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
					echo "<script>window.location.href='nurseHome.php'</script>";
				}
				
			} else {
				echo "Your password is wrong.";
			}
		}
	} else {
		// User not found
		echo "Your email is not in the database. Please register.";
	}

?>

<DOCTYPE! html>
<html>
	<head>
		<title>Login to Make Money Together</title>
		<script src="js/jquery.js" type="text/javascript"></script>
	</head>
	<body>
		<div style="width: 200px, margin: auto;">
			<p1>Please login to Make Money Together</p1>
			<div id="login-error"></div>
			<form id="login-form">
				<strong>Email</strong>
				<input type="text" id="userEmail" required/>
				<br/>
				<strong>Password</strong>
				<input type="password" id="userPassword" required/>
				<br/>
				<button id="login-btn" type="submit">Login</button>
			</form>
		</div>

	<script>
			$(document).ready(function(){
	
				$("#login-form").on("submit", function(e){

					e.preventDefault(); //From StackOver Flow my question

					var userEmail 		= $("#userEmail").val();
					var userPassword 	= $("#userPassword").val();

					var loginData = "userEmail=" + userEmail + "&userPassword=" + userPassword;

					$.ajax({
						method: "post",
						url:    "login.php?",
						data:   loginData,
						success: function(backData){
							$("#login-error").html(backData);
						}
					});
				});
			});
	</script>
	</body>
	
</html>