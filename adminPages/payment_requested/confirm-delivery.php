<?php
	
	session_start();
	
	$sentReqId = $_POST["sentReqId"];

	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{

		$sql = "UPDATE sentrequestbynurse SET deliveryConfirmedByAdmin='1' WHERE sentReqId='$sentReqId'";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();

	    echo "已确认收货！等待护士提供请款信息。";

	    $pdo->commit();

	} 
	catch(Exception $e){
	    
	    echo $e->getMessage();
	    $pdo->rollBack();
	}


?>