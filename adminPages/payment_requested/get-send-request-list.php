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

		$sql = "SELECT * FROM sentrequestbynurse WHERE confirmPaidByNurseAndComplete = '0' ORDER BY requestDateAndTime ASC";
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
	    	$userId = $row["userId"];
	    	$sql4 = "SELECT * FROM users WHERE userId = '$userId'";
		    $stmt4 = $pdo->prepare($sql4);
		    $stmt4->execute();
		    //Forgot to get the name
		    if ($row4 = $stmt4->fetch()){
		    	$userName = $row4["userName"];
		    }
	    	echo "<div sent-payment-requested-div-for-sentReqId='$sentReqId'>";
	    	echo "<p class='flex'><span>请款序号: " . $requestSequence . "</span> <span>请款护士: <span style='color:blue; font-size: 20px'>" . $userName . "</span></span> <span>送货请求时间: " . $requestDateAndTime . "</span></p>";
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
		    	$smallTotalCost 			= (int)$qtyTaken * (float)$itemCost;
		    	$smallTotalReceivingPrice 	= (int)$qtyTaken * (float)$itemReceivingPrice;
		    	$bigTotalCost 			+= $smallTotalCost;
		    	$bigTotalReceivingPrice += $smallTotalReceivingPrice;
		    	$tableRow = "<tr><td>" . $itemName . "</td><td>" . $itemLink . "</td><td>" . $qtyTaken . "</td><td>" . $itemCost . "</td><td>" . $itemReceivingPrice . "</td><td>" . $smallTotalCost . "</td><td>" . $smallTotalReceivingPrice .  "</td></tr>";
		    	echo $tableRow;
			}
			echo "</table>";
			//echo 大总成本：<span style='font-size:30px; color:red'>$" . $bigTotalCost . "</span> 
			echo "总请款额：<span style='font-size:40px; color:red'>$" . $bigTotalReceivingPrice ."</span><br>";
			if ($paidByAdmin == '0'){
				//环环相扣啊真是
				if ($paymentReqSentByNurse == '0'){
					if ($deliveryConfirmedByAdmin == '0') {
						echo "状态：护士已发送送货请求，请在收到货盘点后确认收货。<br>";
						echo "<button class='confirm-delivery-btn' data-confirm-delivery-for-sentReqId='$sentReqId'>确认收货</button>";
					} else {
						echo "状态：已确认收货，正在等待护士提供请款信息。";
					}
				} else {
					echo "状态：护士已经请款，银行信息如下：<br>";
					echo $bankNote;
					echo "<br>请款时间：" . $lastModifiedTime . "<br>";
					echo "<button class='confirm-paid-btn' data-confirm-paid-for-sentReqId='$sentReqId'>已付款</button>";
				}	
			} else {
				echo "状态：已付款，正在等待护士确认，银行信息如下：<br>";
				echo $bankNote;
				echo "<br>付款时间：" . $lastModifiedTime;
			}
			
			echo "</div>";
			$requestSequence++;
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