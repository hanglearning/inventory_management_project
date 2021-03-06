<?php

	session_start();

 	$orderId 			= $_POST['orderId'];
	$userId 			= $_POST['userId'];
	$qtyAddedBack		= $_POST['qtyAddedBack'];
	$orderTakenId		= $_POST['orderTakenId'];

	$pdo = new PDO('mysql:host=localhost;dbname=chenh057_realPro', 'chenh057_hang01', 'bhgoszPg7iBcYD8WLAjeWrjEcH3LUcE96vHqCdGKnpNWZetxe', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{
		//先改状态为0
		$sql = "UPDATE orderTaken SET orderStatus='0' WHERE orderTakenId = '$orderTakenId'";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();

	    $sql2 = "SELECT * FROM orders WHERE orders.orderId = '$orderId'";

	    $stmt2 = $pdo->prepare($sql2);
	    $stmt2->execute();
	    if ($row = $stmt2->fetch()){
	    	$oldQtyLeft = $row["qtyLeft"];
	    	$oldtotalQtyTaken = $row["totalQtyTaken"];
	    	if ($oldQtyLeft != "ALL IN"){
	    		$newQtyLeft = (string)((int)($oldQtyLeft) + (int)($qtyAddedBack));
	    		$newtotalQtyTaken = (string)((int)($oldtotalQtyTaken) - (int)($qtyAddedBack));
	    		$sql3 = "UPDATE orders SET qtyLeft='$newQtyLeft', totalQtyTaken='$newtotalQtyTaken' WHERE orderId='$orderId'";
	    		$stmt3 = $pdo->prepare($sql3);
	    		$stmt3->execute();
	    	} else {
	    		$newtotalQtyTaken = (string)((int)($oldtotalQtyTaken) - (int)($qtyAddedBack));
	    		$sql3 = "UPDATE orders SET totalQtyTaken='$newtotalQtyTaken' WHERE orderId='$orderId'";
	    		$stmt3 = $pdo->prepare($sql3);
	    		$stmt3->execute();
	    	}

	    	echo "你已成功放弃这个订单并给予了更多的年轻人机会！\n目前本系统不支持撤销放弃订单，以后就可以了。";
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
