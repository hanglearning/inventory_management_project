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

<!DOCTYPE html>
<html>
<head>
	<Title>Register Make Money Together</Title>
	<script src="js/jquery.js"></script>
</head>
<body>
	<div style="width: 400px; margin: auto">
		<h1>Create a new account</h1>
		<div id="registerOutput"></div>
		<form id="registration-form">
				<strong>Email</strong>
				<input id="userEmail" type="text" required />
				<br/>
				<span>It will also be your username.</span>
			<br/>
				<strong>Password</strong>
				<input id="userPassword" type="password" required />
				<br/>
				<span>BETTER NOT USE YOUR COMMON PASSWORD!</span>
			<br/>
				<strong>Name</strong>
				<input id="userName" type="text" required />
				<br/>
				<span>Whatever you want to be called.</span>
			<br/>
				<strong>Phone Number</strong>
				<input id="userPhone" type="text" required />
				<br/>
				<span>US Phone number, required!</span>
			<br/>
				<strong>QQ Account Info</strong>
				<input id="userQQ" type="text" required />
				<br/>
				<span>QQ is essential for communication.</span>
			<br/>
				<strong>WeChat Account Info</strong>
				<input id="userWeChat" type="text" placeholder="Optional"/>
			<br/>
				<strong>Referred By</strong>
				<input id="userReferred" type="text" placeholder="Optional"/>
			<br/>
				<button id="register-btn" type="submit">Submit</button>
		</form>
	</div>
	<script>
		$(document).ready(function(){

			$("#registration-form").on("submit", function(e){

				e.preventDefault();

				var userEmail 		= $("#userEmail").val();
				var userPassword 	= $("#userPassword").val();
				var userName 		= $("#userName").val();
				var userPhone		= $("#userPhone").val();
				var userQQ 			= $("#userQQ").val();
				var userWeChat 		= $("#userWeChat").val();
				var userReferred 	= $("#userReferred").val();

				var registerData = "userEmail=" + userEmail + "&userPassword=" + userPassword + "&userName=" + userName + "&userPhone=" 
				+ userPhone + "&userQQ=" + userQQ + "&userWeChat=" + userWeChat + "&userReferred=" + userReferred;

				$.ajax({
					method: "post",
					url: 	"register.php?",
					data: 	registerData,
					success: function(backData){
						$("#registerOutput").html(backData);
					}
				});
			});
		});
	</script>
</body>
</html>