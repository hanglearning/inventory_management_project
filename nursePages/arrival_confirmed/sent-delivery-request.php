<?php
	session_start();
	$userId			= $_SESSION['userId'];
	$userEmail 		= $_SESSION['userEmail'];
	$userName 		= $_SESSION['userName'];
	$userPhone 		= $_SESSION['userPhone'];
	$userQQ 		= $_SESSION['userQQ'];
	$userWeChat 	= $_SESSION['userWeChat'];
	$userReferred 	= $_SESSION['userReferred'];

	$requestDateAndTime = $_POST['requestDateAndTime'];
	$deliveryRequestCheckedArray = $_POST['deliveryRequestCheckedArray'];

	//$deliveryRequestCheckedArrayInDB = implode(",", $deliveryRequestCheckedArray);
	//Should use explode! https://www.w3schools.com/php/func_string_explode.asp
	$deliveryRequestCheckedArrayToUseInLoop = explode(",", $deliveryRequestCheckedArray);
	//若$deliveryRequestCheckedArray = explode(",", $deliveryRequestCheckedArray); 则在db中那一栏显示的是Array，因为直接插入$deliveryRequestCheckedArray，除非改query
	$arrayLength = count($deliveryRequestCheckedArrayToUseInLoop);

	$pdo = new PDO('mysql:host=localhost;dbname=chenh057_realPro', 'chenh057_hang01', 'bhgoszPg7iBcYD8WLAjeWrjEcH3LUcE96vHqCdGKnpNWZetxe', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	//echo gettype($deliveryRequestCheckedArray);

	try{

		//http://stackoverflow.com/questions/10054633/insert-array-into-mysql-database-with-php
		//You can not insert an array directly to mysql as mysql doesn't understand php data types.

		$sql = "INSERT INTO sentrequestbynurse (userId, orderTakenArray, deliveryConfirmedByAdmin, requestDateAndTime) VALUES ('$userId', '$deliveryRequestCheckedArray', '0', '$requestDateAndTime')";

	    $stmt = $pdo->prepare($sql);

	    $stmt->execute();

	    for($i = 0; $i < $arrayLength; $i++) {
		    $sql2 = "UPDATE orderTaken SET orderStatus='3' WHERE orderTakenId='" .$deliveryRequestCheckedArrayToUseInLoop[$i]. "'";
		   	$stmt2 = $pdo->prepare($sql2);
	    	$stmt2->execute();
		}
	    
	    $pdo->commit();

	    //echo $deliveryRequestCheckedArrayInDB;
		echo "送货申请发送成功！神医端已经可以看到你的申请，你也可以注重联系神医确认送货时间地点。📞";

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
