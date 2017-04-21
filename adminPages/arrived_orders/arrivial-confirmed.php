<?php

	session_start();

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
		$sql = "SELECT * FROM orderTaken WHERE orderStatus='2' ORDER BY orderId DESC, orderTakenTime DESC";
		$stmt = $pdo->prepare($sql);
	    $stmt->execute();
	    $count = $stmt->rowCount();
	    if ($count > 0){
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
	    } else {
	    	echo "<h3 style='color: black; font-size:20px; text-align: center'>没有新被护士确认到货的单子</h3>";
	    }

	    
	    $pdo->commit();

	} 
	catch(Exception $e){
	    echo $e->getMessage();
	    $pdo->rollBack();
	}


?>