<?php

	session_start();
	$userId			= $_SESSION['userId'];
	$userEmail 		= $_SESSION['userEmail'];
	$userName 		= $_SESSION['userName'];
	$userPhone 		= $_SESSION['userPhone'];
	$userQQ 		= $_SESSION['userQQ'];
	$userWeChat 	= $_SESSION['userWeChat'];
	$userReferred 	= $_SESSION['userReferred'];

	function makeLink($url)
	{
		return ("<a href=" . $url . " target='_blank'>" . $url . "</a>");
	}

	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{
		//https://www.w3schools.com/sql/sql_groupby.asp
		$sql = "SELECT * FROM orderTaken WHERE orderStatus='2' GROUP BY orderId ORDER BY orderTakenTime ASC";
		$stmt = $pdo->prepare($sql);
	    $stmt->execute();

	    echo "<table><tr><th>护士</th><th>QQ</th><th>数量</th><th>货名</th><th>链接</th><th>单价</th><th>收价</th><th>领单时间</th></tr>";
	    while ($row = $stmt->fetch()){
	    	$userId = $row["userId"];
	    	$sql2 = "SELECT * FROM users WHERE userId='$userId'";
	    	$stmt2 = $pdo->prepare($sql2);
	    	$stmt2->execute();
	    	if($row2 = $stmt2->fetch()){
	    		$userName = $row2["userName"];
	    		$userQQ = $row2["userQQ"];
	    	}

	    	$orderId = $row["orderId"];
	    	$sql3 = "SELECT * FROM orders WHERE orderId='$orderId'";
	    	$stmt3 = $pdo->prepare($sql3);
	    	$stmt3->execute();
	    	if($row3 = $stmt3->fetch()){
	    		$itemName = $row3["itemName"];
	    		$itemLink = makeLink($row3["itemLink"]);
	    		$itemCost = $row3["itemCost"];
	    		$itemReceivingPrice = $row3["itemReceivingPrice"];
	    	}

	    	$qtyTaken = $row["qtyTaken"];
	    	$orderTakenTime = $row["orderTakenTime"];
	    	
	    	$tableRow = "<tr><td>" . $userName . "</td><td>" . $userQQ . "</td><td>" . $qtyTaken . "</td><td>" . $itemName . "</td><td>" . $itemLink . "</td><td>" . $itemCost . "</td><td>" . $itemReceivingPrice . "</td><td>" . $itemReceivingPrice .  "</td></tr>";
	    	echo $tableRow;
	    }
	    echo "</table>";
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