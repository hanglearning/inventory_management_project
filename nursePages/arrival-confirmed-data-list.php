<?php

	session_start();
	$userId			= $_SESSION['userId'];
	$userEmail 		= $_SESSION['userEmail'];
	$userName 		= $_SESSION['userName'];
	$userPhone 		= $_SESSION['userPhone'];
	$userQQ 		= $_SESSION['userQQ'];
	$userWeChat 	= $_SESSION['userWeChat'];
	$userReferred 	= $_SESSION['userReferred'];

	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{

		$sql = "SELECT * FROM orders INNER JOIN orderTaken ON orders.orderId = orderTaken.orderId WHERE orderTaken.userId = '$userId' AND orderTaken.orderStatus = '2'";
	    //$sql = "SELECT * FROM orders WHERE closed = :closed";
	    $stmt = $pdo->prepare($sql);

	    $stmt->execute();
	    while ($row = $stmt->fetch()){

	    	$orderId = $row["orderId"];
	    	$orderTakenId = $row["orderTakenId"];
	    	$qtyTaken = $row["qtyTaken"];
	    	$profitPerItem = $row["profitPerItem"];
	    	$totalProfitOnOrder = $qtyTaken * $profitPerItem;
	    	//http://stackoverflow.com/questions/1866098/why-a-full-stop-and-not-a-plus-symbol-for-string-concatenation-in-php
	    	//String concatenation must be .dot than +plus in PHP!!!
	    	echo
	    	"<div data-confirm-order-div-orderId='$orderId'>" .
	    	"<input type='checkbox' class='check-for-delivery-request' data-delivery-request-for-orderTakenId='$orderId' checked> " .
	    	"<label>Check here to request delivery for this order</label>" .
	    	"</br>" .
	    	"Taken Time: "			. $row["orderTakenTime"] . "<br />" .
	    	 "Item Name: " 			. $row["itemName"] . "<br />" .
	    	 "Link: "				. $row["itemLink"] . "<br />" .
	    	 "Qty Taken: "			. $qtyTaken . "<br />" .
	    	 "Cost: "				. $row["itemCost"] . "<br />" .
	    	 "Shipping: "			. $row["itemShipping"] . "<br />" .
	    	 "Profit: "				. $profitPerItem . "<br />" .
	    	 "Receiving Price: "	. $row["itemReceivingPrice"] . "<br />" .
	    	 "Cash back Rec: "		. $row["cashBackRec"] . "<br />" .
	    	 "Note: "				. $row["orderNote"] . "<br />" .
	    	 "Total profit on this order: $" . $totalProfitOnOrder .
	    	 "</div>";
	    }

	    $pdo->commit();

	} 
	//Our catch block will handle any exceptions that are thrown.
	catch(Exception $e){
	    //An exception has occured, which means that one of our database queries
	    //failed.
	    //Print out the error message.
	    echo $e->getMessage();
	    //Rollback the transaction.
	    $pdo->rollBack();
	}


?>