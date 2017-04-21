<?php

	session_start();

	$orderTakenId = $_POST["orderTakenId"];
	$orderStatus  = $_POST["orderStatus"];
	$acceptedQty  = $_POST["acceptedQty"];
	$orderId	  = $_POST["orderId"];

	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{

		$sql = "UPDATE orderTaken SET orderStatus='$orderStatus' WHERE orderTakenId='$orderTakenId'";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();
	    echo "已接受报数！"; //目前不用，留着
	    
	    
	    //Temporarily change qtyLeft, substract this number from it since then claimed-orders.php refreshed the admin can get a better idea how much is still left after he/she accepts or change the qty//(wrote this in tea house? see obs) and I just changed to $qtyLeft in claimed-orders.php as well for the sake of cotinuity
	    $sql2 = "SELECT qtyLeft FROM orders WHERE orders.orderId = '$orderId'";
	    $stmt2 = $pdo->prepare($sql2);
	    $stmt2->execute();
	    if ($row = $stmt2->fetch()){
	    	$oldQtyLeft = $row["qtyLeft"];
	    	//echo $oldQtyLeft;
	    	//Only need to update this, and remember to also take action if the user accepted or delete the accepted qty
	    	//$oldTotalQtyTaken = $row["totalQtyTaken"];
    		$newQtyLeft = (string)((int)($oldQtyLeft) - (int)($acceptedQty));
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