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

	$insert_order_sql = "INSERT INTO orders (itemName, itemLink, totalQty, qtyLeft, 
			itemCost, itemShipping, profitPerItem, itemReceivingPrice, cashBackRec, validBy, orderNote) VALUES ('$itemName', '$itemLink', '$totalQty', '$totalQty',
			'$itemCost', '$itemShipping', '$profitPerItem', '$itemReceivingPrice', '$cashBackRec', '$validBy', '$orderNote')";

	$query = mysqli_query($con, $insert_order_sql);
	//echo $insert_order_sql;
	echo "<h3>订单已建立!</h3>";
?>
