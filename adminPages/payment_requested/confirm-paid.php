<?php

	session_start();
	
	$sentReqId = $_POST["sentReqId"];

	$pdo = new PDO('mysql:host=localhost;dbname=chenh057_realPro', 'chenh057_hang01', 'bhgoszPg7iBcYD8WLAjeWrjEcH3LUcE96vHqCdGKnpNWZetxe', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{

		$sql = "UPDATE sentrequestbynurse SET paidByAdmin='1' WHERE sentReqId='$sentReqId'";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();

	    echo "已确认付款！等待护士确认付款并完结订单。\n订单完成后，将显示在已完结订单。";

	    $pdo->commit();

	} 
	catch(Exception $e){

	    echo $e->getMessage();
	    $pdo->rollBack();
	}


?>
