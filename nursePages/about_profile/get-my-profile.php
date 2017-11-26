<?php

	session_start();
	$userId			= $_SESSION['userId'];
	
	$con = mysqli_connect("localhost", "chenh057_hang01", "bhgoszPg7iBcYD8WLAjeWrjEcH3LUcE96vHqCdGKnpNWZetxe", "chenh057_realPro");
	if (!$con){
  		die("Connection error: " . mysqli_connect_errno());
  	}
  	$query = mysqli_query($con, "SELECT * FROM users WHERE userId = '$userId'");
	$fetch = mysqli_fetch_assoc($query);

	$userEmail 		= $fetch['userEmail'];
	$userName 		= $fetch['userName'];
	$userPhone		= $fetch['userPhone'];
	$userQQ 		= $fetch['userQQ'];
	$userWeChat 	= $fetch['userWeChat'];

	echo "<div style='width: 800px; margin: auto'>
		<h1>🤡小样别以为你穿个马甲我就不认识你了！🤠</h1>
		<h4>不想更改的数据就请留在输入框，若无需更改怕死沃德则两项都留空。</h4>
		<div id='registerOutput'></div>
		<form id='registration-form'>
				<strong>💌伊妹尔💌</strong>
				<input id='userEmail' type='email' value='$userEmail' required/>
				<span id='email_invalid_error_message'></span>
				<br/>
				<span>要换个妹妹包养？</span>
			<br/>
				<strong>🔞怕死沃德</strong>
				<input id='userPassword' type='password' maxlength='50'/>
				<br/>
				<span>改了你可得记得啊！</span>
			<br/>
				<strong>🙄确认怕死沃德</strong>
				<input id='userPasswordConfirm' type='password' maxlength='50'/>
				<br/>
				<span>我还是不信任你🙄</span>
			<br/>
				<strong>🌝名字</strong>
				<input id='userName' type='text' value='$userName' required />
				<br/>
				<span>这你也要改？？</span>
			<br/>
				<strong>📱电话号码</strong>
				<input id='userPhone' type='text' maxlength='10' value='$userPhone' required />
				<br/>
				<span>你左手一个iPhone右手一个Pixel？</span>
			<br/>
				<strong>🐧QQ号</strong>
				<input id='userQQ' type='text' value='$userQQ' required />
				<br/>
				<span>要换小号吗？🙂</span>
			<br/>
				<strong>㊙️微信</strong>
				<input id='userWeChat' type='text' value='$userWeChat' placeholder='还是，爱填不填'/>
			<br/>
				<button id='register-btn' type='submit'>提交更改</button>
		</form>
	</div>

	";


?>
