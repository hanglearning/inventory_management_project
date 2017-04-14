<?php
	
	session_start();
	/*
 	$orderId 		= $_POST['orderId'];
	$userId 		= $_POST['userId'];
	$qtyAddedBack	= $_POST['qtyAddedBack'];
	$orderStatus 	= $_POST['orderStatus'];
	$exceptionNote 	= $_POST['exceptionNote'];
	$orderTakenId	= $_POST['orderTakenId'];
	*/

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
	    $sql2 = "SELECT * FROM orders WHERE orders.orderId = '$orderId'";
	    $stmt2 = $pdo->prepare($sql2);
	    $stmt2->execute();
	    if ($row = $stmt2->fetch()){
	    	$oldQtyLeft = $row["qtyLeft"];
	    	$oldTotalQtyTaken = $row["totalQtyTaken"];
	    	if ($oldQtyLeft != "ALL IN"){
	    		$newQtyLeft = (string)((int)($oldQtyLeft) + (int)($qtyAddedBack));
	    		$newtotalQtyTaken = (string)((int)($oldTotalQtyTaken) - (int)($qtyAddedBack));
	    		$sql3 = "UPDATE orders SET qtyLeft='$newQtyLeft', totalQtyTaken='$newtotalQtyTaken' WHERE orderId='$orderId'";
	    		$stmt3 = $pdo->prepare($sql3);
	    		$stmt3->execute();
	    	} else {
	    		$newtotalQtyTaken = (string)((int)($oldTotalQtyTaken) - (int)($qtyAddedBack));
	    		$sql3 = "UPDATE orders SET totalQtyTaken='$newtotalQtyTaken' WHERE orderId='$orderId'";
	    		$stmt3 = $pdo->prepare($sql3);
	    		$stmt3->execute();
	    	}
	    };

	    $pdo->commit();
	    echo "你成功的煎了这个🥚！";
	    //echo "oldTotalQtyTaken" . $oldTotalQtyTaken . "qtyAddedBack" . $qtyAddedBack . "newtotalQtyTaken" . $newtotalQtyTaken . $sql3;
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