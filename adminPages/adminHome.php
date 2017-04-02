<DOCTYPE! html>
<html>
<head>
	<title>Welcome Back</title>
	<script src="jquery.js"></script>
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
			<li id="new-order" class="page-switch-btn">New Order</li>
			<li id="order-claimed" class="page-switch-btn">Order Claimed</li>
			<li id="arrival-confirmed" class="page-switch-btn">Arrival Comfirmed</li> <!-- Can request send packages, see package sent request and comfirm arrival(Can see if labeled by nurse as well) from this page -->
			<li id="payment-requested" class="page-switch-btn">Payment Requested</li> <!-- Can mark up a payment is paid from here -->
			<li id="closed-orders" class="page-switch-btn">Closed Orders</li>
			<li id="user-list" class="page-switch-btn">User List</li>
			<li id="my-profile" class="page-switch-btn">My Profile</li>
			<li id="logout" class="page-switch-btn">logout</li>
		</ul>
	</div>
	<div id="page-switch">
	</div>
	<script>
		$(document).ready(function(){
			$("#page-switch").load("adminPages/payment-requested.html");
			$(".page-switch-btn").on("click", function(){
				var page = $(this).attr("id");
				alert(page);
			});
		});
	</script>
</body>
</html>

