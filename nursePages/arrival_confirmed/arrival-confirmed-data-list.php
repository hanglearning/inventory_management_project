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

		$sql = "SELECT * FROM orders INNER JOIN orderTaken ON orders.orderId = orderTaken.orderId WHERE orderTaken.userId = '$userId' AND orderTaken.orderStatus = '2'";
	    //$sql = "SELECT * FROM orders WHERE closed = :closed";
	    $stmt = $pdo->prepare($sql);

	    $stmt->execute();
	    while ($row = $stmt->fetch()){

	    	$orderId = $row["orderId"];
	    	$orderTakenId = $row["orderTakenId"];
	    	$qtyTaken = $row["qtyTaken"];
	    	$profitPerItem = $row["profitPerItem"];
	    	$totalProfitOnOrder = $qtyTaken * $profitPerItem;
	    	$itemLink = $row["itemLink"]; 
	    	//http://stackoverflow.com/questions/1866098/why-a-full-stop-and-not-a-plus-symbol-for-string-concatenation-in-php
	    	//String concatenation must be .dot than +plus in PHP!!!
	    	echo
	    	"<div class='arrived-orders-div' data-confirm-order-div-orderId='$orderId'>" .
	    	"<input type='checkbox' class='check-for-delivery-request' data-delivery-request-for-orderTakenId='$orderId' checked> " .
	    	"<label>选中对此单的发货申请</label>" .
	    	"</br>" .
	    	"领单时间: "			. $row["orderTakenTime"] . "<br />" .
	    	 "货品名称: " 			. $row["itemName"] . "<br />" .
	    	 "链接: "				. makeLink($itemLink) . "<br />" .
	    	 "下单数量: "			. $qtyTaken . "<br />" .
	    	 "成本: $"				. $row["itemCost"] . "<br />" .
	    	 "Shipping: $"			. $row["itemShipping"] . "<br />" .
	    	 "利润: "				. $profitPerItem . "<br />" .
	    	 "收货价格:  <span style='font-size:30px; color:red'>$"	. $row["itemReceivingPrice"] . "</span><br />" .
	    	 "Cashback推荐: "		. $row["cashBackRec"] . "<br />" .
	    	 "备注: "				. $row["orderNote"] . "<br />" .
	    	 "光这一🥚你就赚了 <span style='font-size:40px; color:red'>$" . $totalProfitOnOrder .
	    	 "</span></div>";
	    }

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