<?php

	session_start();
	
	$sentReqId = $_POST["sentReqId"];

	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{

		$sql = "UPDATE sentrequestbynurse SET paidByAdmin='1' WHERE sentReqId='$sentReqId'";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();

	    echo "已确认付款！等待护士确认付款并完结订单。<br>订单完成后，将显示在已完结订单。";

	    $pdo->commit();

	} 
	catch(Exception $e){

	    echo $e->getMessage();
	    $pdo->rollBack();
	}


?>