<?php
	
	session_start();
	
	$orderId 		= $_POST['orderId'];
	$userId 		= $_POST['userId'];
	$givedUpQty 	= $_POST['givedUpQty'];
	$orderStatus	= $_POST['orderStatus'];
	
	/*
	$con = mysqli_connect("localhost", "chenh057_hang01", "bhgoszPg7iBcYD8WLAjeWrjEcH3LUcE96vHqCdGKnpNWZetxe", "chenh057_realPro");
	if (!$con){
  		die("Connection error: " . mysqli_connect_errno());
  	}

  	$sql = "INSERT INTO orderTaken (orderId, userId, qtyTaken, orderStatus) 
  			VALUES ('$orderId', '$userId', '$qtyTaken', '$orderStatus')";
  	mysqli_query($con, $sql);*/
  	
  	$pdo = new PDO('mysql:host=localhost;dbname=chenh057_realPro', 'chenh057_hang01', 'bhgoszPg7iBcYD8WLAjeWrjEcH3LUcE96vHqCdGKnpNWZetxe', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{
		//Update orderTaken on this user on this order
		$sql = "UPDATE orderTaken SET qtyTaken='0', orderStatus='$orderStatus' WHERE orderId='$orderId' AND userId='$userId'";
		$stmt = $pdo->prepare($sql);
	    $stmt->execute();
  		
  		//Update orders table, give back the qty to the qtyLeft
	  	$sql2 = "SELECT qtyLeft FROM orders WHERE orders.orderId = '$orderId'";
	    $stmt2 = $pdo->prepare($sql2);
	    $stmt2->execute();
	    if ($row = $stmt2->fetch()){
	    	$oldQtyLeft = $row["qtyLeft"];
			$newQtyLeft = (string)((int)($qtyLeft) + (int)($givedUpQty));
			$sql3 = "UPDATE orders SET qtyLeft='$newQtyLeft' WHERE orderId='$orderId'";
			$stmt3 = $pdo->prepare($sql3);
			$stmt3->execute();
	    };
	    
	  	echo "你成功的把它抛弃了！皇阿玛吉祥！";
	    
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
