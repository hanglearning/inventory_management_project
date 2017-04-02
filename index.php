<!DOCTYPE html>
<html>
<head>
	<Title>Register Make Money Together</Title>
	<script src="jquery.js"></script>
	<script src="register.js"></script>
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
				<button id="register" type="submit"/>Submit</button>
		</form>
	</div>
</body>
</html>