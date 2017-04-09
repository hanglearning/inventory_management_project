<?php

 	$orderId 		= $_POST['orderId'];
	$userId 		= $_POST['userId'];
	$qtyTaken		= $_POST['qtyTaken'];
	$cutOrdersNum	= $_POST['cutOrdersNum'];
	$orderTakenId	= $_POST['orderTakenId'];

	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{

		//Update qtyLeft in orders
		// 1. Get old qty taken by the user
		$sql = "SELECT qtyTaken FROM orderTaken WHERE orderTaken.orderId = '$orderId' AND orderTaken.userId = '$userId'" ;
		$stmt = $pdo->prepare($sql);
	    $stmt->execute();
	    if ($row = $stmt->fetch()){
	    	$oldQtyTaken = $row["qtyLeft"];
	    }else{
	    }
	    
	    // 2. Calculate difference
	    $qtyDiff = $oldQtyTaken - $qtyTaken;

	    // 3. Update
	    $sql2 = "SELECT qtyLeft FROM orders WHERE orders.orderId = '$orderId'";

	    // from order-revert.php, add qty back to the database
	    $stmt2 = $pdo->prepare($sql2);
	    $stmt2->execute();
	    if ($row = $stmt2->fetch()){
	    	$qtyLeft = $row["qtyLeft"];
	    	if ($qtyLeft != "ALL IN"){
	    		$updatedQty = (string)((int)$qtyLeft + (int)$qtyDiff);
	    		$sql3 = "UPDATE orders SET qtyLeft='$updatedQty' WHERE orderId='$orderId'";
	    		$stmt3 = $pdo->prepare($sql3);
	    		$stmt3->execute();

	    	} else {
	    	}
	    };
	    
	    $pdo->commit();
	    echo "你成功把本订单的下单数量改到了'$qtyTaken'！刷新可见。" . $sql3;
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