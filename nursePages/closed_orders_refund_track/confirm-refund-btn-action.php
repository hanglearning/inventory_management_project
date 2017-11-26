<?php
	session_start();
	$orderTakenId = $_POST['orderTakenId'];

	$pdo = new PDO('mysql:host=localhost;dbname=chenh057_realPro', 'chenh057_hang01', 'bhgoszPg7iBcYD8WLAjeWrjEcH3LUcE96vHqCdGKnpNWZetxe', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{
 	 
	    $sql = "UPDATE orderTaken SET orderStatus='9' WHERE orderTakenId = '$orderTakenId'";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();

	    echo "确认退款成功！下次下🥚好运！🙂";
	    
	   	$pdo->commit();
	    
	} 

	catch(Exception $e){

	    echo $e->getMessage();

	    $pdo->rollBack();
	}


?>
