<?php
	/* NEED TO BE SOLVED: SESSION NOT WORK - 041217 111858am 3E */
	/*
	1. Check if session is set. Use in here to redirect user to adminHome/nurseHome
	http://stackoverflow.com/questions/6901547/check-if-session-is-set-or-not-and-if-not-create-one
	2. Put php above HTML
	http://stackoverflow.com/questions/21630638/where-to-put-the-html-form-above-or-below-the-php-or-it-doesnt-matter
	*/
	
	header('Content-Type: text/html; charset=utf-8');

	if(isset($_SESSION))
	 {
	    $userId			= $_SESSION['userId'];
		$userEmail 		= $_SESSION['userEmail'];
		$userName 		= $_SESSION['userName'];
		$userPhone 		= $_SESSION['userPhone'];
		$userQQ 		= $_SESSION['userQQ'];
		$userWeChat 	= $_SESSION['userWeChat'];
		$userReferred 	= $_SESSION['userReferred'];
		$isAdmin 		= $_SESSION['admin'];

		if ($isAdmin == '1'){
			header ('Location: ../adminPages/adminHome.php');
			exit;
		} else {
			header ('Location: ../nursePages/nurseHome.php');
			exit;
		}
		
	 }
	 else
	 {	
	 	/*header ('Location: index.php');
	 	exit;*/
	 }
?>

<html>
<head>
	<title>欢迎来到 Make Money Together！</title>
	<script src="js/jquery.js"></script>

	<!-- 用到的CSS
	https://www.w3schools.com/css/css_navbar.asp
	https://www.w3schools.com/css/tryit.asp?filename=trycss_navbar_horizontal_black_active -->
	<style>
	ul {
	    list-style-type: none;
	    margin: 0;
	    padding: 0;
	    overflow: hidden;
	    background-color: #333;
	}

	li {
	    float: left;
	}

	li a {
	    display: block;
	    color: white;
	    text-align: center;
	    padding: 14px 16px;
	    text-decoration: none;
	}

	li a:hover:not(.active) {
	    background-color: #111;
	}

	.active {
	    background-color: #4CAF50;
	}
	</style>
	
</head>
<body>
	<div id="index-navigation">
	<ul>
		<li class="active" id="login"><a href="#login">登陆</a></li>
		<li id="create"><a href="#create">注册账户</a></li>
		<li id="forget"><a href="#forget">忘记密码</a></li>
		<!-- DEBUG SESSION VAR
		<li id="test"><a href="#test"><?php $userEmail ?></a></li>
		<li id="test2"><a href="#test2">DEBUG</a></li>
		-->
	</ul>
	</div>
	<div id="page-switch">
	</div>
</body>

<script>
	$(document).ready(function(){
		//Default Page
		$("#page-switch").load("login.html");	
		/* http://stackoverflow.com/questions/9688778/jquery-add-class-to-current-li-and-remove-prev-li-when-click-inside-li-a */
		$('ul li a').click(function() {
		    $('ul li.active').removeClass('active');
		    $(this).closest('li').addClass('active');
		    var pageSwitch = $(this).closest('li').attr('id');
		    if (pageSwitch == 'login'){
		    	$("#page-switch").load("login.html");
		    }
		    else if (pageSwitch == 'create'){
		    	$("#page-switch").load("register.html");
		    } else {
		    	$("#page-switch").load("forget.html");
		    }
		});
	});
</script>
</html>
