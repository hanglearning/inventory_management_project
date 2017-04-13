<?php

	session_start();
	$userId			= $_SESSION['userId'];
	$userName 		= $_SESSION['userName'];
	
	$bugReport 		= $_POST["bugReport"];
 	       
    $con = mysqli_connect("localhost", "hangdev", "mindfreak", "realPro");
	if (!$con){
  		die("Connection error: " . mysqli_connect_errno());
  	}
	$sql = "INSERT INTO bugReport (userId, userName, bugReportText, solved, creationTime) VALUES ('$userId', '$userName', '$bugReport', 0, '$creationTime')";
	$query = mysqli_query($con, $sql);
	echo "<h4 style='color: red; text-align: center; font-size: 40px' >就让你牛逼一回！😳咱别揍我行不？😥</h4>";
?>
