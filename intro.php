<?php
	header('Content-Type: text/html; charset=utf-8');
?>

<DOCTYPE! html>
<html>
<head>
	<script src="js/jquery.js" type="text/javascript"></script>
	<title>Welcome!</title>
	<style>
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

			#intro {
			    /* margin-top: 100px; */
			    margin-bottom: 100px;
			    margin-right: 150px;
			    margin-left: 80px;
			}

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
	</style>
</head>
<body>
	<div>
		<h1 style="text-align:center">🌎Inventory Management System Intro🌎</h1>
		<div id="intro">
			<h2>This online inventory management system was initially made for an international logistics company in Delaware. The app has both administrative and regular users. They have different privileges and functions, and they would interact differently depending on various phases in a logistics process.
			</h2>
			<h2>This site is mostly written in jQuery and PHP, by using a MySQL database at the backend. You can <a href="https://github.com/hanglearning/inventory_management_project" target="_blank">view the code here</a>.
			</h2>
			<h2>This site is in Chinese. If you are not a Chinese speaker and curious about what this site could do and want to have a taste of how this website is constructured, please refer to this <a href="https://www.youtube.com/watch?v=w0Bov93C-DU" target="_blank">YouTube video</a> I made. <a href="http://v.youku.com/v_show/id_XMzI2NjIxNzIxNg==.html?spm=a2hzp.8244740.0.0#paction" target="_blank">(China Youku Mirror Link: 点我打开优酷)</a>
			</h2>
			<img src="images/peek.png" height="400" width="800" style="display: block; margin: 0 auto"><br>
			<h2>If you have any suggestion, question or concern, you are welcome to <a href="mailto:hanglearning@gmail.com">email me by clicking here</a>.
			</h2>
			<div style="text-align:center">
				<button id="go" >Thanks! Please enjoy the website :)</button>
			</div>
		</div>
	</div>
</body>
<script>
	$(document).ready(function(){
		$("#go").click(function() {
		    window.location.href='../inventory_management/';
		});
	});
</script>
</html>