<?php

	session_start();

	$orderTakenId = $_POST["orderTakenId"];
	$orderStatus  = $_POST["orderStatus"];
	$qtyChangeTo  = $_POST["qtyChangeTo"];
	$orderId	  = $_POST["orderId"];

	$pdo = new PDO('mysql:host=localhost;dbname=chenh057_realPro', 'chenh057_hang01', 'bhgoszPg7iBcYD8WLAjeWrjEcH3LUcE96vHqCdGKnpNWZetxe', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{

		$sql = "UPDATE orderTaken SET orderStatus='$orderStatus', qtyTaken='$qtyChangeTo' WHERE orderTakenId='$orderTakenId'";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();
	    //echo $sql;
	    //echo "已修改报数！"; //目前不用，留着
	    
	    //Same as in accept-qty-btn-action.php, update the qtyLeft
	    $sql2 = "SELECT qtyLeft FROM orders WHERE orders.orderId = '$orderId'";
	    $stmt2 = $pdo->prepare($sql2);
	    $stmt2->execute();
	    if ($row = $stmt2->fetch()){
	    	$oldQtyLeft = $row["qtyLeft"];
	    	//Only need to update this, and remember to also take action if the user accepted or delete the accepted qty
	    	//$oldTotalQtyTaken = $row["totalQtyTaken"];
	    	/*
	    	if ((int)($qtyChangeTo) < (int)($oldQtyLeft)){
	    		$newQtyLeft = (string)((int)($oldQtyLeft) - (int)($qtyChangeTo));
	    	} else {
	    		$newQtyLeft = (string)((int)($qtyChangeTo) - (int)($oldQtyLeft));
	    	}*/
    		$newQtyLeft = (string)((int)($oldQtyLeft) - (int)($qtyChangeTo));
    		$sql3 = "UPDATE orders SET qtyLeft='$newQtyLeft' WHERE orderId='$orderId'";
    		$stmt3 = $pdo->prepare($sql3);
    		$stmt3->execute();
	    };
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
