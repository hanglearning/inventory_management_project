<?php

 	$orderId 		= $_POST['orderId'];
	$userId 		= $_POST['userId'];
	$orderStatus	= $_POST['orderStatus'];

	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{

	    $sql = "UPDATE orderTaken SET orderStatus='$orderStatus' WHERE orderId='$orderId' AND userId = '$userId'";

	    $stmt = $pdo->prepare($sql);

	    $stmt->execute();
	    
	    $pdo->commit();
	    echo "You have confirmed the arrival of this order.\nYou may then send a delivery request to the administrator.";
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