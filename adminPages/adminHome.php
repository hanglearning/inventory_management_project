<?php
	
	session_start();
	$userEmail 		= $_SESSION['userEmail'];
	$userName 		= $_SESSION['userName'];
	$userPhone 		= $_SESSION['userPhone'];
	$userQQ 		= $_SESSION['userQQ'];
	$userWeChat 	= $_SESSION['userWeChat'];
	$userReferred 	= $_SESSION['userReferred'];

?>

<html>
<head>
	<title>欢迎神医<?php echo $userName ?></title>
	<script src="../js/jquery.js"></script>
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
		input[type=email], select {
		    width: 50%;
		    padding: 12px 20px;
		    margin: 8px 0;
		    display: inline-block;
		    border: 1px solid #ccc;
		    border-radius: 4px;
		    box-sizing: border-box;
		}

		input[type=text], select {
		    width: 50%;
		    padding: 12px 20px;
		    margin: 8px 0;
		    display: inline-block;
		    border: 1px solid #ccc;
		    border-radius: 4px;
		    box-sizing: border-box;
		}

		input[type=password], select {
		    width: 50%;
		    padding: 12px 20px;
		    margin: 8px 0;
		    display: inline-block;
		    border: 1px solid #ccc;
		    border-radius: 4px;
		    box-sizing: border-box;
		}

		input[type=submit] {
		    width: 100%;
		    background-color: #4CAF50;
		    color: white;
		    padding: 14px 20px;
		    margin: 8px 0;
		    border: none;
		    border-radius: 4px;
		    cursor: pointer;
		}

		input[type=submit]:hover {
		    background-color: #45a049;
		}

		div {
		    border-radius: 5px;
		    background-color: #f2f2f2;
		    padding: 20px;
		}

		h1 {text-align:center;}

		button {
		    background-color: #4CAF50;
		    border: none;
		    color: white;
		    padding: 15px 32px;
		    text-align: center;
		    text-decoration: none;
		    display: inline-block;
		    font-size: 16px;
		    margin: 4px 2px;
		    cursor: pointer;
		}
		/*https://www.w3schools.com/css/tryit.asp?filename=trycss_buttons_basic*/
		span {
			color: red;
			font-size: 80%;
		}
	</style>
	
</head>
<body>
	<div id="index-navigation">
		<ul>
			<li id="new-order" class="page-switch-btn" class="active"><a href="#new-order">新建订单</a></li>
			<li id="ongoing-orders" class="page-switch-btn"><a href="#open-orders">进行中</a></li>
			<li id="order-claimed" class="page-switch-btn"><a href="#order-claimed">护士已下</a></li>
			<li id="arrival-confirmed" class="page-switch-btn"><a href="#arrival-confirmed">护士已收到</a></li> 
			<li id="payment-requested" class="page-switch-btn"><a href="#payment-requested">收货及请款</a></li>
			<li id="completed-orders" class="page-switch-btn"><a href="#completed-orders">已完结订单</a></li>
			<li id="closed-orders" class="page-switch-btn"><a href="#closed-orders">历史订单</a></li>
			<li id="all-orders" class="page-switch-btn"><a href="#all-orders">所有订单</a></li>
			<li id="user-list" class="page-switch-btn"><a href="#user-list">用户列表</a></li>
			<li id="my-profile" class="page-switch-btn"><a href="#my-profile">我的信息</a></li>
			<li id="bug-report" class="page-switch-btn"><a href="#bug-report">意见建议</a></li>
			<li id="logout" class="page-switch-btn"><a href="#logout">登出</a></li>
		</ul>
	</div>
	<h1 style="text-align: center">😊欢迎回来，神医<?php echo $userName ?>!🤗</h1>
	<div id="page-switch">
	</div>
	<script>
		$(document).ready(function(){
			$("#page-switch").load("../adminPages/new-order.html");//Default
			$('ul li a').click(function() {
			    $('ul li.active').removeClass('active');
			    $(this).closest('li').addClass('active');
			    var page = $(this).closest('li').attr('id');
			    if (page != "logout") {
			    	$("#page-switch").load("../adminPages/" + page + ".html");
			    } else {
			    	window.location.href='../logout.php';
			    }
			});
		});
	</script>
</body>
</html>

