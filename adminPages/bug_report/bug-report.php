<?php

	session_start();
	$userId			= $_SESSION['userId'];
	$userName 		= $_SESSION['userName'];
	
	$bugReport 		= $_POST["bugReport"];
 	       
    $con = mysqli_connect("localhost", "hangdev", "mindfreak", "realPro");
	if (!$con){
  		die("Connection error: " . mysqli_connect_errno());
  	}
	$sql = "INSERT INTO bugReport (userId, userName, bugReportText,
			solved) VALUES ('$userId', '$userName', '$bugReport', 0)";
	$query = mysqli_query($con, $sql);
	echo "<h4 style='color: red' style='text-align: center'>提交成功！</h4>";
?>
