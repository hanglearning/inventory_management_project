<?php
	
	session_start();
	$userEmail 		= $_SESSION['userEmail'];
	$userName 		= $_SESSION['userName'];
	$userPhone 		= $_SESSION['userPhone'];
	$userQQ 		= $_SESSION['userQQ'];
	$userWeChat 	= $_SESSION['userWeChat'];
	$userReferred 	= $_SESSION['userReferred'];

?>

<DOCTYPE! html>
<html>
<head>
	<title>Welcome Back</title>
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

		/* Change the link color to #111 (black) on hover */
		li a:hover {
		    background-color: #111;
		}
	</style>
	
</head>
<body>
	<div id="index-navigation">
		<ul>
			<li id="new-orders" class="page-switch-btn">New Orders</li>
			<li id="order-claimed" class="page-switch-btn">Orders Claimed</li>
			<li id="arrival-confirmed" class="page-switch-btn">Arrival Comfirmed</li> <!-- Can request send packages, see package sent request and comfirm arrival(Can see if labeled by nurse as well) from this page -->
			<li id="payment-requested" class="page-switch-btn">Payment Requested</li> <!-- Can mark up a payment is paid from here -->
			<li id="closed-orders" class="page-switch-btn">Closed Orders</li>
			<li id="my-profile" class="page-switch-btn">My Profile</li>
			<li id="logout" class="page-switch-btn">logout</li>
		</ul>
	</div>
	<div id="page-switch">
	</div>
	<script>
		$(document).ready(function(){
			$("#page-switch").load("../nursePages/payment-requested.php");
			$(".page-switch-btn").on("click", function(){
				var page = $(this).attr("id");
				$("#page-switch").load("../nursePages/" + page + ".html");
			});
		});
	</script>
</body>
</html>

