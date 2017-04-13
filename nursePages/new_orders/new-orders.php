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

	//http://thisinterestsme.com/php-pdo-transaction-example/
	// from php official website it seems to make use of the official transaction feature then PDO must be used? See OBS 040317 62512pm 3E
	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	
	
	try{
 	       
	    // Query 1: Select active orders from the order table
	    // http://stackoverflow.com/questions/767026/how-can-i-properly-use-a-pdo-object-for-a-parameterized-select-query
	    // Mysql trigger can automatically close the order once it expires?
	    $sql = "SELECT * FROM orders A WHERE A.closed = '0' AND A.qtyLeft <> '0' AND A.orderId NOT IN (SELECT orderId FROM orderTaken B WHERE B.userId = '$userId') ORDER BY creationTime DESC";
	    $stmt = $pdo->prepare($sql);

	    $stmt->execute();
	    while ($row = $stmt->fetch()){

	    	$orderID = $row["orderId"];
	    	$qtyLeftNeeded = $row["qtyLeft"];
	    	$profitPerItem = $row["profitPerItem"];
	    	$itemLink = $row["itemLink"];
	    	
	    	//http://stackoverflow.com/questions/1866098/why-a-full-stop-and-not-a-plus-symbol-for-string-concatenation-in-php
	    	//String concatenation must be .dot than +plus in PHP!!!
	    	echo
	    	"<div class='ongoingOrdersTableList' data-take-order-div-orderId='$orderID'>" .
	    	"发布时间: "		. $row["creationTime"] . "<br />" .
	    	 "货品名称: " 			. $row["itemName"] . "<br />" .
	    	 "链接: "				. makeLink($itemLink) . "<br />" .
	    	 "目前还可收这些数量: "	. $qtyLeftNeeded . "<br />" .
	    	 "成本: $"				. $row["itemCost"] . "<br />" .
	    	 "Shipping: $"			. $row["itemShipping"] . "<br />" .
	    	 "利润:  <span style='font-size:40px; color:red'>$" . $profitPerItem . "</span><br />" .
	    	 "收货价格: <span style='font-size:30px; color:red'>$"	 . $row["itemReceivingPrice"] . "</span><br />" .
	    	 "Cashback推荐: "		. $row["cashBackRec"] . "<br />" .
	    	 "有效期至: "				. $row["validBy"] . "<br />" .
	    	 "备注: "				. $row["orderNote"] . "<br />" .
	    	 "<button class='take-order-btn' data-take-orderId='$orderID' data-qtyLeftNeeded = '$qtyLeftNeeded' type='submit' data-submit-order-userId='$userId'>领单！</button>" .
	    	 "<button class='delete-order-btn' data-delete-orderId='$orderID' type='submit' data-delete-order-userId='$userId' data-give-up-profit='$profitPerItem'>删除</button>" .
	    	 "<div class='take-order-div' data-take-orderId-div='$orderID'></div>" .
	    	 "</div>";
	    }
	    
	   
	    $pdo->commit();
	    
	} 
	catch(Exception $e){
	    
	    echo $e->getMessage();
	    $pdo->rollBack();
	}

	

?>
