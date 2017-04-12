<?php

	session_start();
	$userId			= $_SESSION['userId'];
	$userEmail 		= $_SESSION['userEmail'];
	$userName 		= $_SESSION['userName'];
	$userPhone 		= $_SESSION['userPhone'];
	$userQQ 		= $_SESSION['userQQ'];
	$userWeChat 	= $_SESSION['userWeChat'];
	$userReferred 	= $_SESSION['userReferred'];

	echo "<div style='width: 800px; margin: auto'>
		<h1>修改我的资料</h1>
		<h4>不想更改的数据请留在输入框，若无需更改密码则两项都留空。</h4>
		<div id='registerOutput'></div>
		<form id='registration-form'>
				<strong>Email：</strong>
				<input id='userEmail' type='email' value='$userEmail' required/>
				<span id='email_invalid_error_message'></span>
				<br/>
			<br/>
				<strong>密码：</strong>
				<input id='userPassword' type='password' maxlength='50' required />
				<br/>
			<br/>
				<strong>确认密码：</strong>
				<input id='userPasswordConfirm' type='password' maxlength='50' required />
				<br/>
			<br/>
				<strong>称谓：</strong>
				<input id='userName' type='text' value='$userName' required />
				<br/>
			<br/>
				<strong>📱电话号码</strong>
				<input id='userPhone' type='text' maxlength='10' value='$userPhone' required />
				<br/>
			<br/>
				<strong>🐧QQ号</strong>
				<input id='userQQ' type='text' value='$userQQ' required />
				<br/>
			<br/>
				<strong>㊙️微信</strong>
				<input id='userWeChat' type='text' value='$userWeChat' />
			<br/>
				<button id='register-btn' type='submit'>提交更改</button>
		</form>
	</div>

	";


?>