<?php
	session_start();
	$itemName 			= $_POST["itemName"];
	$itemLink 			= $_POST["itemLink"];
	$totalQty 			= $_POST["totalQty"];
	$itemCost			= $_POST["itemCost"];
	$itemShipping 		= $_POST["itemShipping"];
	$profitPerItem 		= $_POST["profitPerItem"];
	$itemReceivingPrice = $_POST["itemReceivingPrice"];
	$cashBackRec 		= $_POST["cashBackRec"];
	$validBy 			= $_POST["validBy"];
	$orderNote 			= $_POST["orderNote"];

	$con = mysqli_connect("localhost", "hangdev", "mindfreak", "realPro");
	if (!$con){
  		die("Connection error: " . mysqli_connect_errno());
  	}
  	
	$insert_order_sql = "INSERT INTO orders (itemName, itemLink, totalQty,
			itemCost, itemShipping, profitPerItem, itemReceivingPrice, cashBackRec, validBy, orderNote) VALUES ('$itemName', '$itemLink', '$totalQty',
			'$itemCost', '$itemShipping', '$profitPerItem', '$itemReceivingPrice', '$cashBackRec', '$validBy', '$orderNote')";

	echo $insert_order_sql;

	$query = mysqli_query($con, $insert_order_sql);

	
	
	/*
	if ($num != 0){
		echo "This email has already been registered. Please try login.";
	} else {
		$sql = "INSERT INTO users (userEmail, userPassword, userName,
			userPhone, userQQ, userWeChat, userReferred) VALUES ('$userEmail', '$userPassword', '$userName',
			'$userPhone', '$userQQ', '$userWeChat', '$userReferred')";
		$see = mysqli_query($con, $sql);
		
		echo "Thank you $userName! You have succefully registered and please wait for the administrator to activate your account.</br>";
	}
	*/

?>
