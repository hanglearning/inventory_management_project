<?php

 	$orderId 		= $_POST['orderId'];
	$userId 		= $_POST['userId'];
	$qtyAddedBack		= $_POST['qtyAddedBack'];
	$orderStatus = $_POST['orderStatus'];
	$exceptionNote = $_POST['exceptionNote'];

	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{
		// Set exception status and note
	    $sql = "UPDATE orderTaken SET orderStatus='$orderStatus', exceptionNote='$exceptionNote' WHERE orderId='$orderId' AND userId = '$userId'";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
	    
	    // Update qtyLeft in order
	    $sql2 = "SELECT qtyLeft FROM orders WHERE orders.orderId = '$orderId'";
	    $stmt2 = $pdo->prepare($sql2);
	    $stmt2->execute();
	    if ($row = $stmt2->fetch()){
	    	$qtyLeft = $row["qtyLeft"];
	    	if ($qtyLeft != "ALL IN"){
	    		$updatedQty = (string)(parseInt($qtyLeft) + parseInt($qtyAddedBack));
	    		$sql3 = "UPDATE orders SET qtyLeft='$updatedQty' WHERE orderId='$orderId'";

	    		$stmt3 = $pdo->prepare($sql3);
	    		$stmt3->execute();

	    	} else {
	    	}
	    };

	    $pdo->commit();
	    echo "You have successfully closed your order.";
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