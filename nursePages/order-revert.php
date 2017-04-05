<?php

 	$orderId 		= $_POST['orderId'];
	$userId 		= $_POST['userId'];
	$qtyTaken		= $_POST['qtyTaken'];

	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{

	    $sql = "UPDATE orderTaken SET qtyTaken='$qtyTaken' WHERE orderId='$orderId' AND userId = '$userId'";

	    $stmt = $pdo->prepare($sql);

	    $stmt->execute();
	    
	    $pdo->commit();
	    echo "Changed qty to '$qtyTaken', refresh page to see.";
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