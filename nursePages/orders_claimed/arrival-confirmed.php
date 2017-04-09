<?php

 	$orderId 		= $_POST['orderId'];
	$userId 		= $_POST['userId'];
	$orderTakenId	= $_POST['orderTakenId'];
	$orderStatus	= $_POST['orderStatus'];

	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{

	    //$sql = "UPDATE orderTaken SET orderStatus='$orderStatus' WHERE orderId='$orderId' AND userId = '$userId'";
	    //哦！当时的逻辑是这样的啊，诚不知，忘记了，直接一个orderTakenId不就搞定了吗？
		$sql = "UPDATE orderTaken SET orderStatus='$orderStatus' WHERE orderTakenId='$orderTakenId'";

	    $stmt = $pdo->prepare($sql);

	    $stmt->execute();
	    
	    $pdo->commit();

	    echo "Congrats! 你已经确认这单的到来！\n你现在可以对这单发送送货请求了。\n💰马上就要到手了！";
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