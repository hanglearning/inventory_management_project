<DOCTYPE! html>
<html>
<head>
	<title>Welcome to Make Money Together</title>
	<script src="jquery.js"></script>

	<!-- https://www.w3schools.com/css/css_navbar.asp -->
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
		<li id="login">Login</li>
		<li id="create">Create Account</li>
		<li id="forget">Forget Password</li>
	</ul>
	</div>
	<div id="page-switch">
	</div>
</body>

<script>
	$(document).ready(function(){
		$("#page-switch").load("login.html");	//Default Page
		$("#login").on("click", function(){
			$("#page-switch").load("login.html");
		});
		$("#create").on("click", function(){
			$("#page-switch").load("register.html");
		});
		$("#forget").on("click", function(){
			$("#page-switch").load("forget.html");
		});
	});
</script>
</html>
