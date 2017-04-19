<?php

	session_start();

	$orderTakenId = $_POST["orderTakenId"];
	$orderStatus  = $_POST["orderStatus"];
	$qtyChangeTo  = $_POST["qtyChangeTo"];

	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
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