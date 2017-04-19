<?php
	
	session_start();
	$userEmail 		= $_SESSION['userEmail'];
	$userName 		= $_SESSION['userName'];
	$userPhone 		= $_SESSION['userPhone'];
	$userQQ 		= $_SESSION['userQQ'];
	$userWeChat 	= $_SESSION['userWeChat'];
	$userReferred 	= $_SESSION['userReferred'];
	
	header('Content-Type: text/html; charset=utf-8');

?>

<DOCTYPE! html>
<html>
<head>
	<title>欢迎护士<?php echo $userName ?></title>
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
		/* My question http://stackoverflow.com/questions/43339809/is-there-a-way-to-put-multiple-inline-elements-at-different-specific-positions-w */
		.flex {
		  display: flex;
		  justify-content: space-between;
		}
		/* https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_loader4 */
		.loader {
		  border: 16px solid #f3f3f3;
		  border-radius: 50%;
		  border-top: 8px solid blue;
		  border-right: 8px solid green;
		  border-bottom: 8px solid red;
		  border-left: 8px solid pink;
		  width: 20px;
		  height: 20px;
		  -webkit-animation: spin 2s linear infinite;
		  animation: spin 2s linear infinite;
		}
		
		@-webkit-keyframes spin {
		  0% { -webkit-transform: rotate(0deg); }
		  100% { -webkit-transform: rotate(360deg); }
		}
		
		@keyframes spin {
		  0% { transform: rotate(0deg); }
		  100% { transform: rotate(360deg); }
		}
	</style>
	
</head>
<body>
	<div id="index-navigation">
		<ul>
			<li id="new-orders" class="page-switch-btn"><a href="#new-orders">新的订单</a></li>
			<li id="orders-claimed" class="page-switch-btn"><a href="#orders-claimed">已领订单</a></li>
			<li id="arrival-confirmed" class="page-switch-btn"><a href="#arrival-comfirmed">已到货</a></li> <!-- Can request send packages, see package sent request and comfirm arrival(Can see if labeled by nurse as well) from this page -->
			<li id="payment-requested" class="page-switch-btn"><a href="#payment-requested">请款与确认</a></li> <!-- Can mark up a payment is paid from here -->
			<li id="completed-orders" class="page-switch-btn"><a href="#completed-orders">已完成的订单</a></li>
			<li id="refund-track" class="page-switch-btn"><a href="#refund-track">追踪退款</a></li>
			<li id="all-orders-info" class="page-switch-btn"><a href="#all-orders">所有订单</a></li>
			<li id="my-profile" class="page-switch-btn"><a href="#my-profile">我的资料</a></li>
			<li id="bug-report" class="page-switch-btn"><a href="#bug-report">我很不爽</a></li>
			<li id="logout" class="page-switch-btn"><a href="#logout">登出</a></li>
		</ul>
	</div>
	<h1 style="text-align: center">😊欢迎回来，护士<?php echo $userName ?>!🤗</h1>
	<div id="page-switch">
	</div>
	<script>
		$(document).ready(function(){
			$("#page-switch").load("../nursePages/new-orders.html");
			$('ul li a').click(function() {
			    $('ul li.active').removeClass('active');
			    $(this).closest('li').addClass('active');
			    var page = $(this).closest('li').attr('id');
			    if (page != 'logout'){
			    	$("#page-switch").load("../nursePages/" + page + ".html");
			    } else {
			    	window.location.href='../logout.php';
			    }
			    
			});
		});
	</script>
</body>
</html>

