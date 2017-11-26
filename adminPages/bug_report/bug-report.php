<?php

	session_start();
	$userId			= $_SESSION['userId'];
	$userName 		= $_SESSION['userName'];
	
	$bugReport 		= $_POST["bugReport"];
	$creationTime 	= $_POST["creationTime"];
 	       
    $con = mysqli_connect("localhost", "chenh057_hang01", "bhgoszPg7iBcYD8WLAjeWrjEcH3LUcE96vHqCdGKnpNWZetxe", "chenh057_realPro");
	if (!$con){
  		die("Connection error: " . mysqli_connect_errno());
  	}
	$sql = "INSERT INTO bugReport (userId, userName, bugReportText, solved, creationTime) VALUES ('$userId', '$userName', '$bugReport', 0, '$creationTime')";	
	$query = mysqli_query($con, $sql);
	echo "<h4 style='color: red' style='text-align: center'>提交成功！</h4>";
?>
