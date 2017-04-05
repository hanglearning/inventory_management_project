<?php

 	$orderId 			= $_POST['orderId'];
	//$userId 			= $_POST['userId'];
	$qtyAddedBack		= $_POST['qtyAddedBack'];

	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{

	    $sql = "SELECT qtyLeft FROM orders WHERE orders.orderId = '$orderId'";

	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();
	    if ($row = $stmt->fetch()){
	    	$qtyLeft = $row["qtyLeft"];
	    	if ($qtyLeft != "ALL IN"){
	    		$updatedQty = (string)(parseInt($qtyLeft) + parseInt($qtyAddedBack));
	    		$sql2 = "UPDATE orders SET qtyLeft='$updatedQty' WHERE orderId='$orderId'";

	    		$stmt2 = $pdo->prepare($sql2);
	    		$stmt2->execute();

	    	} else {
	    	}
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