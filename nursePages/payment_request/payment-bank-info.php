<?php

	session_start();
	$userId			= $_SESSION['userId'];
	$userEmail 		= $_SESSION['userEmail'];
	$userName 		= $_SESSION['userName'];
	$userPhone 		= $_SESSION['userPhone'];
	$userQQ 		= $_SESSION['userQQ'];
	$userWeChat 	= $_SESSION['userWeChat'];
	$userReferred 	= $_SESSION['userReferred'];

	$sentReqId = $_POST["sentReqId"];
	$bankNote  = $_POST["bankNote"];

	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{

		$sql = "UPDATE sentrequestbynurse SET bankNote='$bankNote' AND paymentReqSentByNurse=1 WHERE sentReqId='$sentReqId'";
	    //$sql = "SELECT * FROM orders WHERE closed = :closed";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();

	    echo "请款信息已发送！💰就要飞到你手中！🍚就要飞到你口中！求包养！";

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