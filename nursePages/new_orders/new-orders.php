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
	    //$sql = "SELECT * FROM orders A WHERE A.closed = '0' AND A.qtyLeft <> '0' AND A.orderId NOT IN (SELECT orderId FROM orderTaken B WHERE B.userId = '$userId' AND (B.orderStatus='0' OR B.orderStatus='1' OR B.orderStatus='2' OR B.orderStatus='3' OR B.orderStatus='7' OR B.orderStatus='8' OR B.orderStatus='9' OR B.orderStatus='12')) ORDER BY creationTime DESC";
	    // SELECT o.*, ot.*, FROM orders o LEFT JOIN orderTaken ot ON o.orderId = ot.orderId WHERE o.closed = '0' AND (ot.orderId IS NULL OR ot.orderStatus NOT IN ('0','1','2','3','7','8','9','12')) ORDER BY o.orderCreationTime DESC
	    /*$sql = "SELECT o.*, 
		          ot.*,
		     FROM orders o 
		LEFT JOIN orderTaken ot
		       ON o.orderId = ot.orderId
		    WHERE o.closed = 0
		      AND (
		            ot.orderId IS NULL
		         OR ot.orderStatus NOT IN (0,1,2,3,7,8,9,12)
		      )
		 ORDER BY o.orderCreationTime DESC";*/
		//$sql = "SELECT o.*, ot.* FROM orders o LEFT JOIN orderTaken ot ON ot.orderId = o.orderId WHERE o.closed =0 AND (ot.orderId IS NULL OR ot.userId = '$userId' AND ot.orderStatus NOT IN ( 0, 1, 2, 3, 7, 8, 9, 12 )) ORDER BY o.creationTime DESC";
		
		//新订单
		$sql = "SELECT * FROM orders A WHERE A.closed = '0' AND A.orderId NOT IN (SELECT orderId FROM orderTaken B WHERE B.userId = '$userId') ORDER BY creationTime DESC";
		$stmt = $pdo->prepare($sql);
	    $stmt->execute();
	    $count = $stmt->rowCount();
	    
	    //待处理订单
		$sql2 = "SELECT o.*, ot.userId, ot.qtyTaken, ot.orderStatus, ot.lastModifiedTime AS requestTime FROM orders o LEFT JOIN orderTaken ot ON o.orderId = ot.orderId WHERE o.closed = 0 AND ot.userId = '$userId' AND ot.orderStatus NOT IN (0, 1, 2, 3, 7, 8, 9, 12)ORDER BY o.creationTime DESC"
	    $stmt2 = $pdo->prepare($sql2);
		$stmt2->execute();
		$count2 = $stmt2->rowCount();
		
		if ($count == 0 and $count2 == 0){
	    	
	    } else {
	    	//处理全新订单
	    	if ($count == 0) {
	    		echo "<h3 style='text-align:center'>没有全新的订单</h3>"
	    	} else {
	    		echo "<h3 style='text-align:center'>以下为全新的订单</h3>"
	    		while ($row = $stmt->fetch()){

			    	$orderId = $row["orderId"];
			    	$qtyLeftNeeded = $row["qtyLeft"];
			    	$profitPerItem = $row["profitPerItem"];
			    	$itemLink = $row["itemLink"];
			    	//$orderStatus = $row["orderStatus"];
			    	//$qtyTaken = $row["qtyTaken"];
			    	
			    	// Based on $orderStatus and $qtyLeftNeeded echo differently
			    	$echoBackDivBeginningForALLIN = "<div class='ongoingOrdersTableList' data-take-order-div-orderId='$orderId'>";
			    	$echoBackDivBeginningForRequest = "<div class='ongoingOrdersTableList' data-request-order-div-orderId='$orderId'>";
			    	$echoBackDivBeginningForNoQtyLeftNeeded = "<div class='generalOrdersTableList' data-noQtyLeftNeeded-order-div-orderId='$orderId'>";
			    	
			    	$echoBackDivGeneral =
			    	"发布时间: "		. $row["creationTime"] . "<br />" .
			    	 "货品名称: " 			. $row["itemName"] . "<br />" .
			    	 "链接: "				. makeLink($itemLink) . "<br />" .
			    	 "成本: $"	. $row["itemCost"] . "<br />" .
			    	 "Shipping: $"			. $row["itemShipping"] . "<br />" .
			    	 "利润:  <span style='font-size:40px; color:red'>$" . $profitPerItem . "</span><br />" .
			    	 "收货价格: <span style='font-size:30px; color:red'>$"	 . $row["itemReceivingPrice"] . "</span><br />" .
			    	 "Cashback推荐: "		. $row["cashBackRec"] . "<br />" .
			    	 "有效期至: "				. $row["valIdBy"] . "<br />" .
			    	 "备注: <span style='font-size:20px; color:red'>" . $row["orderNote"] . "<span><br />";
			    	 
			    	$echoBackDivEndingForALLIN = "收货数量类型: ALL IN <br>" . "<button class='take-order-btn' data-take-orderId='$orderId' data-qtyLeftNeeded = '$qtyLeftNeeded' type='submit' data-submit-order-userId='$userId'>领单！</button>" .
			    	 "<button class='delete-order-btn' data-delete-orderId='$orderId' type='submit' data-delete-order-userId='$userId' data-give-up-profit='$profitPerItem'>删除</button>" .
			    	 "<div class='take-order-div' data-take-orderId-div='$orderId'></div>" .
			    	 "</div>";
			    	 
			    	$echoBackDivEndingForRequest = "请求报数时还可收这些数: "	. $qtyLeftNeeded . "<br />" .
				     "<span style='color:red; font-size: 15px'>注意：此单限制数量，请先请求下单数量并等待批准。</span><br>" .
				      //$qtyLeftNeeded . $orderId . "没有orderId<br>" .
				     "<button class='request-order-btn' data-request-orderId='$orderId' data-qtyLeftNeeded = '$qtyLeftNeeded' type='submit' data-request-order-userId='$userId'>请单！</button>" .
			    	 "<button class='delete-order-btn' data-delete-orderId='$orderId' type='submit' data-delete-order-userId='$userId' data-give-up-profit='$profitPerItem'>删除</button>" .
			    	 "<div class='request-order-div' data-request-orderId-div='$orderId'></div>" .
			    	 "</div>";
			    	 
			    	 $echoBackDivEndingForNoQtyLeftNeeded = "状态：目前此单已收全，但并未截单。若想继续下此单，请等待其他护士修改下单数量，否则请删除。<br>" . 
			    	 "<button class='delete-order-btn' data-delete-orderId='$orderId' type='submit' data-delete-order-userId='$userId' data-give-up-profit='$profitPerItem'>删除</button>" .
			    	 "</div>";

			    	if ($qtyLeftNeeded != 'ALL IN'){
		    	 		//echo "debug NOT ALL IN ";
		    	 		if ($qtyLeftNeeded > 0){
				    		// Haven't taken the order and order still available, request qty
				    		echo $echoBackDivBeginningForRequest . $echoBackDivGeneral .  $echoBackDivEndingForRequest;
			    	 	} else {
			    	 		// Haven't taken the order but no qty left needed
			    	 		//echo "debug no available ";
			    	 		echo $echoBackDivBeginningForNoQtyLeftNeeded . $echoBackDivGeneral . $echoBackDivEndingForNoQtyLeftNeeded;
			    	 	}
		    	 	} else {
		    	 		// Haven't taken order and all in, just take, like the original orderTaken
		    	 		//echo "debug ALL IN ";
		    	 		echo $echoBackDivBeginningForALLIN . $echoBackDivGeneral . $echoBackDivEndingForALLIN;
		    	 	}
			    }
	    	}
	    	//处理待处理订单
	    	if ($count2 == 0) {
	    		echo "<h3 style='text-align:center'>没有待处理的订单</h3>"
	    	} else {
	    		echo "<h3 style='text-align:center'>以下为待处理的订单</h3>"
	    		while ($row2 = $stmt2->fetch()){

			    	$orderId = $row2["orderId"];
			    	$qtyLeftNeeded = $row2["qtyLeft"];
			    	$profitPerItem = $row2["profitPerItem"];
			    	$itemLink = $row2["itemLink"];
			    	$orderStatus = $row2["orderStatus"];
			    	$qtyTaken = $row2["qtyTaken"];
			    	
			    	// Based on $orderStatus and $qtyLeftNeeded echo differently
			    	$echoBackDivBeginningForRequested = "<div class='ongoingOrdersTableList' data-requested-order-div-orderId='$orderId'>";
			        $echoBackDivBeginningForConfirm = "<div class='ongoingOrdersTableList' data-confirm-order-div-orderId='$orderId'>";
			    	
			    	$echoBackDivGeneral =
			    	"发布时间: "		. $row2["creationTime"] . "<br />" .
			    	 "货品名称: " 			. $row2["itemName"] . "<br />" .
			    	 "链接: "				. makeLink($itemLink) . "<br />" .
			    	 "成本: $"	. $row2["itemCost"] . "<br />" .
			    	 "Shipping: $"			. $row2["itemShipping"] . "<br />" .
			    	 "利润:  <span style='font-size:40px; color:red'>$" . $profitPerItem . "</span><br />" .
			    	 "收货价格: <span style='font-size:30px; color:red'>$"	 . $row2["itemReceivingPrice"] . "</span><br />" .
			    	 "Cashback推荐: "		. $row2["cashBackRec"] . "<br />" .
			    	 "有效期至: "				. $row2["valIdBy"] . "<br />" .
			    	 "备注: <span style='font-size:20px; color:red'>" . $row2["orderNote"] . "<span><br />";
			    	 
			    	 $echoBackDivEndingForRequested = "<span style='color:red; font-size: 15px'>此单已报数: "	. $qtyTaken . "，请等待上家获准。</span><br>" .
			    	 "<button class='delete-order-btn' data-delete-orderId='$orderId' type='submit' data-delete-order-userId='$userId' data-give-up-profit='$profitPerItem'>放弃此单</button>" .
			    	 "</div>";
			    	 
			    	 $echoBackDivEndingForConfirm = "<span style='color:red; font-size: 15px'>已获准收货数量: "	. $qtyTaken . "（此数量可能被上家改过），请确认领单。</span><br>" . 
			    	 "<button class='confirm-order-btn' data-confirm-orderId='$orderId' data-qty-can-be-taken = '$qtyTaken' type='submit' data-confirm-order-userId='$userId'>朕知道了</button>" .
			    	 "<div class='confirm-order-div' data-confirm-orderId-div='$orderId'></div>" .
			    	 "<button class='delete-order-btn' data-delete-orderId='$orderId' type='submit' data-delete-order-userId='$userId' data-give-up-profit='$profitPerItem'>删除</button>" .
			    	 "</div>";

			    	if ($orderStatus == '10') {
			    		// order already requested
			    		//echo "debug 10";
			    		echo $echoBackDivBeginningForRequested . $echoBackDivGeneral . $echoBackDivEndingForRequested;
			    	} else if ($orderStatus == '11') {
			    		//echo "debug 11";
			    		// order already accepted, ready to place the order
			    		echo $echoBackDivBeginningForConfirm . $echoBackDivGeneral . $echoBackDivEndingForConfirm;
			    	} else {
			    		// There shouldn't be a else condition, so if it happens then there must be a problem
			    		// Just use this to debug
			    		echo "有问题！";
			    	}
			    	
			    	/*
			    	if ($qtyLeftNeeded != 'ALL IN'){
			    		if ($qtyLeftNeeded > 0){
			    			if ($orderStatus == '') {
					    		// Haven't taken the order and order still available, request qty
					    		echo $echoBackDivBeginningForRequest . $echoBackDivGeneral .  $echoBackDivEndingForRequest;
					    	} else if ()
				    		echo $echoBackDivBeginning .  $echoBackDivGeneral . $echoBackDivEnding;
				    	} else {
				    		echo $echoBackDivBeginning . $echoBackDivGeneral . "状态：目前此单已收全，但并未截单。若想继续下此单，请等待其他护士修改下单数量，否则请删除。</div>";
				    	}
			    	} else {
			    		
				    	// accepted by admin, ready to confirm
			    		//http://stackoverflow.com/questions/1866098/why-a-full-stop-and-not-a-plus-symbol-for-string-concatenation-in-php
				    	//String concatenation must be .dot than +plus in PHP!!!
				    	echo $echoBackDivBeginningForALLIN . $echoBackDivGeneral . $echoBackDivEndingForALLIN;
				    	/*echo
				    	"<div class='ongoingOrdersTableList' data-take-order-div-orderId='$orderId'>" .
				    	"发布时间: "		. $row["creationTime"] . "<br />" .
				    	 "货品名称: " 			. $row["itemName"] . "<br />" .
				    	 "链接: "				. makeLink($itemLink) . "<br />" .
				    	 "目前还可收这些数量: "	. $qtyLeftNeeded . "<br />" .
				    	 "成本: $"				. $row["itemCost"] . "<br />" .
				    	 "Shipping: $"			. $row["itemShipping"] . "<br />" .
				    	 "利润:  <span style='font-size:40px; color:red'>$" . $profitPerItem . "</span><br />" .
				    	 "收货价格: <span style='font-size:30px; color:red'>$"	 . $row["itemReceivingPrice"] . "</span><br />" .
				    	 "Cashback推荐: "		. $row["cashBackRec"] . "<br />" .
				    	 "有效期至: "				. $row["valIdBy"] . "<br />" .
				    	 "备注: <span style='font-size:20px; color:red'>" . $row["orderNote"] . "<span><br />" .
				    	 "<button class='take-order-btn' data-take-orderId='$orderId' data-qtyLeftNeeded = '$qtyLeftNeeded' type='submit' data-submit-order-userId='$userId'>领单！</button>" .
				    	 "<button class='delete-order-btn' data-delete-orderId='$orderId' type='submit' data-delete-order-userId='$userId' data-give-up-profit='$profitPerItem'>删除</button>" .
				    	 "<div class='take-order-div' data-take-orderId-div='$orderId'></div>" .
				    	 "</div>";
			    	}*/
			    }
	    	}

	    }

		//$sql = "SELECT o.*, ot.userId, ot.qtyTaken, ot.orderStatus, ot.lastModifiedTime AS requestTime FROM orders o LEFT JOIN orderTaken ot ON ot.orderId = o.orderId WHERE o.closed =0 AND (ot.orderId IS NULL OR ot.userId = '$userId' AND ot.orderStatus NOT IN ( 0, 1, 2, 3, 7, 8, 9, 12 )) ORDER BY o.creationTime DESC";

	   
	    $pdo->commit();
	    
	} 
	catch(Exception $e){
	    
	    echo $e->getMessage();
	    $pdo->rollBack();
	}

	

?>
