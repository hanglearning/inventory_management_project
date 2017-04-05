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
 	 
	    //Query 1: Select active orders from the order table
	    //http://stackoverflow.com/questions/767026/how-can-i-properly-use-a-pdo-object-for-a-parameterized-select-query
	    $sql = "SELECT * FROM orders INNER JOIN orderTaken ON orders.orderId = orderTaken.orderId WHERE orderTaken.userId = '$userId' AND orderTaken.orderStatus = '1'";
	    //$sql = "SELECT * FROM orders WHERE closed = :closed";
	    $stmt = $pdo->prepare($sql);

	    $stmt->execute();
	    while ($row = $stmt->fetch()){

	    	$orderID = $row["orderId"];
	    	$qtyTaken = $row["qtyTaken"];
	    	$profitPerItem = $row["profitPerItem"];
	    	$totalProfitOnOrder = $qtyTaken * $profitPerItem;
	    	//http://stackoverflow.com/questions/1866098/why-a-full-stop-and-not-a-plus-symbol-for-string-concatenation-in-php
	    	//String concatenation must be .dot than +plus in PHP!!!
	    	echo
	    	"<div data-confirm-order-div-orderId='$orderID'>" .
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
	    	 "Total profit on this order: $" . $totalProfitOnOrder . "<br />" .
	    	 "<button class='order-confirm-btn' data-confirm-orderId='$orderID' data-confirm-order-userId='$userId' type='submit' 
	    	 	 data-qty-taken-confirm='$qtyTaken'>Confirm</button>" .
	    	 "<button class='order-change-qty-btn' data-change-qty-orderId='$orderID'
	    	 	data-qty-taken = '$qtyTaken'  type='submit' data-change-qty-userId='$userId'>Change Qty</button>" .
	    	 "<div class='order-change-qty-div' data-order-change-qty-div-orderId='$orderID'></div>" .
	    	 "<button class='revert-order-btn' data-revert-orderId='$orderID' type='submit'
	    	 	 data-revert-qty = '$qtyTaken'
	    	 	 data-revert-order-userId='$userId'>Revert</button>" .
	    	 "<button class='close-order-btn' data-close-orderId='$orderID' type='submit' data-close-order-userId='$userId' data-close-order-back-qty='$qtyTaken'>Close</button>" .
	    	 "<div class='close-order-note-div' close-order-note-div-orderId='$orderID'></div>";
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