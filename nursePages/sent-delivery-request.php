<?php
	session_start();
	$userId			= $_SESSION['userId'];
	$userEmail 		= $_SESSION['userEmail'];
	$userName 		= $_SESSION['userName'];
	$userPhone 		= $_SESSION['userPhone'];
	$userQQ 		= $_SESSION['userQQ'];
	$userWeChat 	= $_SESSION['userWeChat'];
	$userReferred 	= $_SESSION['userReferred'];

	$deliveryRequestCheckedArray = $_POST['deliveryRequestCheckedArray'];
	$arrayLength = count($deliveryRequestCheckedArray);

	//$deliveryRequestCheckedArrayInDB = implode(",", $deliveryRequestCheckedArray);

	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	//echo gettype($deliveryRequestCheckedArray);

	try{

		//http://stackoverflow.com/questions/10054633/insert-array-into-mysql-database-with-php
		//You can not insert an array directly to mysql as mysql doesn't understand php data types.

		$sql = "INSERT INTO sentrequestbynurse (userId, orderTakenArray, deliveryConfirmedByAdmin) VALUES ('$userId', '$deliveryRequestCheckedArray', '0')";

	    $stmt = $pdo->prepare($sql);

	    $stmt->execute();

	    for($i = 0; $i < $arrayLength; $i++) {
		    $sql2 = "UPDATE orderTaken SET orderStatus='3' WHERE orderId='" .$deliveryRequestCheckedArray[$i]. "' AND userId = '$userId'";
		   	$stmt2 = $pdo->prepare($sql2);
	    	$stmt2->execute();
		}
	    
	    $pdo->commit();

	    //echo $deliveryRequestCheckedArrayInDB;
		echo "Success! Admin can see your request at his/her end but you can also message him/her about it.";

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