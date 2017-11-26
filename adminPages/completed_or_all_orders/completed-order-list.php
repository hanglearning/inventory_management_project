<?php
	
	session_start();

	function makeLink($url)
	{
		return ("<a href=" . $url . " target='_blank'>" . $url . "</a>");
	}

	$pdo = new PDO('mysql:host=localhost;dbname=chenh057_realPro', 'chenh057_hang01', 'bhgoszPg7iBcYD8WLAjeWrjEcH3LUcE96vHqCdGKnpNWZetxe', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{

		$sql = "SELECT * FROM sentrequestbynurse WHERE confirmPaidByNurseAndComplete = '1' ORDER BY requestDateAndTime ASC";
	    //$sql = "SELECT * FROM orders WHERE closed = :closed";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();
	    
	    $requestSequence = 1;

	    while ($row = $stmt->fetch()){
	    	$sentReqId = $row["sentReqId"];
	    	$requestDateAndTime = $row["requestDateAndTime"];
	    	$deliveryConfirmedByAdmin = $row["deliveryConfirmedByAdmin"];
	    	$paymentReqSentByNurse = $row["paymentReqSentByNurse"];
	    	$bankNote = $row["bankNote"];
	    	$paidByAdmin = $row["paidByAdmin"];
	    	$lastModifiedTime = $row["lastModifiedTime"];
	    	echo "<div sent-payment-requested-div-for-sentReqId='$sentReqId'>";
	    	echo "<p class='flex'><span>序号:" . $requestSequence . " </span><span>护士送货请求时间: " . $requestDateAndTime . "</span></p>";
	    	echo "<table><tr><th>货品名称</th><th>链接</th><th>数量</th><th>单个成本</th><th>单个收价</th><th>总成本</th><th>总收价</th></tr>";
	    	$orderTakenArray = $row["orderTakenArray"];
	    	$paymentRequestedOrdersTakenIdContained = explode(",", $orderTakenArray);
	    	$numOfOrdersOfPaymentRequested = count($paymentRequestedOrdersTakenIdContained);
	    	//要用for loop，这个for loop可以从sent-delivery-request.php借来，毕竟这也是上一个过程过来的，所以连着都需要差不多的code功能架构
	    	$bigTotalProfit = 0;
	    	$bigTotalReceivingPrice = 0;
	    	for($i = 0; $i < $numOfOrdersOfPaymentRequested; $i++) {
	    		$orderTakenId = $paymentRequestedOrdersTakenIdContained[$i];
			    $sql2 = "SELECT * FROM orderTaken WHERE orderTakenId='$orderTakenId'";
			   	$stmt2 = $pdo->prepare($sql2);
		    	$stmt2->execute();
		    	//Using if since there is only one row for a specific orderTakenId
		    	if ($row2 = $stmt2->fetch()){
		    		$orderId  = $row2["orderId"];
		    		$qtyTaken = $row2["qtyTaken"];
		    		$sql3 = "SELECT * FROM orders WHERE orderId='$orderId'";
			   		$stmt3 = $pdo->prepare($sql3);
		    		$stmt3->execute();
		    		if ($row3 = $stmt3->fetch()){	//对，你看我不join table也可以用这种办法都把东西提取出来，一个一个的弄出来，实际上结果是一样的，但这种办法很直接，我脑子直
		    			$itemName 			= $row3["itemName"];
		    			$itemLink 			= makeLink($row3["itemLink"]);
		    			$itemCost 			= $row3["itemCost"];		
		    			$profitPerItem 		= $row3["profitPerItem"];
		    			$itemReceivingPrice = $row3["itemReceivingPrice"];
		    			$orderNote 			= $row3["orderNote"];
		    		}
		    	}
		    	$smallTotalProfit 			= (int)$qtyTaken * (float)$profitPerItem;
		    	$smallTotalReceivingPrice 	= (int)$qtyTaken * (float)$itemReceivingPrice;
		    	$smallTotalCost				= (int)$qtyTaken * (float)$itemCost;
		    	$bigTotalProfit 		+= $smallTotalProfit;
		    	$bigTotalReceivingPrice += $smallTotalReceivingPrice;
		    	$tableRow = "<tr><td>" . $itemName . "</td><td>" . $itemLink . "</td><td>" . $qtyTaken . "</td><td>" . $itemCost . "</td><td>" . $itemReceivingPrice . "</td><td>" . $smallTotalCost . "</td><td>" . $smallTotalReceivingPrice .  "</td></tr>";
		    	echo $tableRow;
			}
			echo "</table>";
			$totalTotalProfit += $bigTotalProfit;
		    $totalTotalReceivingPrice += $bigTotalReceivingPrice;
			echo "<p style='text-align: right'>此票护士总赚：<span style='font-size:30px; color:red'>$" . $bigTotalProfit . "</span> 总请款额：<span style='font-size:40px; color:red'>$" . $bigTotalReceivingPrice ."</span></p>";
			
			echo "</div>";
			$requestSequence++;
	    }
	    echo "<p style='text-align: right'>全部护士已赚：<span style='font-size:30px; color:red'>$" . $totalTotalProfit . "</span> 大总请款额（全部现金流）：<span style='font-size:40px; color:red'>$" . $totalTotalReceivingPrice ."</span></p>";

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
