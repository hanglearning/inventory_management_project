<?php
	
	session_start();
 	$orderId 		= $_POST['orderId'];
	$userId 		= $_POST['userId'];
	$qtyTaken		= $_POST['qtyTaken'];
	$cutOrdersNum	= $_POST['cutOrdersNum'];
	$orderTakenId	= $_POST['orderTakenId'];
	//$beforeTotalQtyTaken = $_POST['beforeTotalQtyTaken'];

	$pdo = new PDO('mysql:host=localhost;dbname=chenh057_realPro', 'chenh057_hang01', 'bhgoszPg7iBcYD8WLAjeWrjEcH3LUcE96vHqCdGKnpNWZetxe', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{

		// 1. Update orderTaken table qtyTaken by this user
		$sql = "UPDATE orderTaken SET qtyTaken='$qtyTaken' WHERE orderTakenId = '$orderTakenId'";
		$stmt = $pdo->prepare($sql);
	    $stmt->execute();
	    
	    // 2. Add qty back to the orders table and also substract totalQtyTaken on this order
	    // Since qtyLeft is a varchar type in db, so direct adding a text to a number in sql query might not work.
	    // So first, select the qtyLeft from order table
	    $sql2 = "SELECT * FROM orders WHERE orderId = '$orderId'";
	    $stmt2 = $pdo->prepare($sql2);
	    $stmt2->execute();
	    // 还是从下面又借上来了
	    if ($row = $stmt2->fetch()){
	    	$oldQtyLeft = $row["qtyLeft"];
	    	$oldTotalQtyTaken = $row["totalQtyTaken"];
	    	if ($oldQtyLeft != "ALL IN"){
	    		$newQtyLeft = (string)((int)$oldQtyLeft + (int)$cutOrdersNum);
	    		$newTotalQtyTaken = (string)((int)$oldTotalQtyTaken - (int)$cutOrdersNum);
	    		$sql3 = "UPDATE orders SET qtyLeft = '$newQtyLeft', totalQtyTaken = '$newTotalQtyTaken' WHERE orderId = '$orderId'";
			    $stmt3 = $pdo->prepare($sql3);
			    $stmt3->execute();
	    	} else {
	    		$newTotalQtyTaken = (string)((int)$oldTotalQtyTaken - (int)$cutOrdersNum);
	    		$sql3 = "UPDATE orders SET totalQtyTaken = '$newTotalQtyTaken' WHERE orderId = '$orderId'";
			    $stmt3 = $pdo->prepare($sql3);
			    $stmt3->execute();
	    	}
	    };

		/* Archived at 040917 62328am 换了思维了，重写，看上面
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
	    */
	    $pdo->commit();
	    echo "你成功把下蛋的数量改到了 " . $qtyTaken . "！"; //反正平常echo用 . 加起来，sql里用'括起来'
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
