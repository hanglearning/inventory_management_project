<?php
	
	$orderId 		= $_POST['orderId'];
	$userId 		= $_POST['userId'];
	$qtyTaken 		= $_POST['qtyTaken'];
	$orderStatus	= $_POST['orderStatus'];

	$con = mysqli_connect("localhost", "hangdev", "mindfreak", "realPro");
	if (!$con){
  		die("Connection error: " . mysqli_connect_errno());
  	}

  	$sql = "INSERT INTO orderTaken (orderId, userId, qtyTaken, orderStatus) 
  			VALUES ('$orderId', '$userId', '$qtyTaken', '$orderStatus')";
  	mysqli_query($con, $sql);
  	echo "你成功的把它抛弃了！";
  	
?>