<?php
	
	$orderId = $_POST["orderId"];

	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{
		// Set exception status and note
	    $sql = "UPDATE orders SET closed=1 WHERE orderId='$orderId'";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
	    $pdo->commit();
	    echo "截单成功！";
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