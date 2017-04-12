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

		$sql = "SELECT * FROM sentrequestbynurse WHERE userId = '$userId' AND confirmPaidByNurseAndComplete = '0'";
	    //$sql = "SELECT * FROM orders WHERE closed = :closed";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();
	    
	    $requestSequence = 1;

	    while ($row = $stmt->fetch()){
	    	$sentReqId = $row["sentReqId"];
	    	$requestDate = $row["requestDate"];
	    	$deliveryConfirmedByAdmin = $row["deliveryConfirmedByAdmin"];
	    	$paymentReqSentByNurse = $row["paymentReqSentByNurse"];
	    	$bankNote = $row["bankNote"];
	    	$paidByAdmin = $row["paidByAdmin"];
	    	$lastModifiedTime = $row["lastModifiedTime"];
	    	echo "<div sent-payment-requested-div-for-sentReqId='$sentReqId'>";
	    	echo "请款序号:" . $requestSequence . " 送货请求时间: " . $requestDate . "<br>";
	    	echo "<table><tr><th>货品名称</th><th>链接</th><th>数量</th><th>单个利润</th><th>单个收价</th><th>总利润</th><th>总收价</th></tr>";
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
		    	$bigTotalProfit 		+= $smallTotalProfit;
		    	$bigTotalReceivingPrice += $smallTotalReceivingPrice;
		    	$tableRow = "<tr><td>" . $itemName . "</td><td>" . $itemLink . "</td><td>" . $qtyTaken . "</td><td>" . $profitPerItem . "</td><td>" . $itemReceivingPrice . "</td><td>" . $smallTotalProfit . "</td><td>" . $smallTotalReceivingPrice .  "</td></tr>";
		    	echo $tableRow;
			}
			echo "</table>";
			echo "大总利润：<span style='font-size:40px; color:red'>$" . $bigTotalProfit . "</span> 总请款额：<span style='font-size:40px; color:red'>$" . $bigTotalReceivingPrice ."</span><br>";
			if ($paidByAdmin == '0'){
				//环环相扣啊真是
				if ($paymentReqSentByNurse == '0'){
					if ($deliveryConfirmedByAdmin == '0') {
						echo "状态：请等待上家确认收货。<br>";
					} else {
						echo "状态：上家已确认到货，可以申请付款。 " . "确认到货时间：" . $lastModifiedTime . "<br>";
						echo "<button class='payment-request-btn' data-req-payment-for-sentReqId='$sentReqId'>请款</button>" . //php这个string里面‘’还有能不能直接用$string表现value以及“”的与''比的特殊性还得学学
						     "<div class='bankNote-div' data-bankNote-div-for-sentReqId='$sentReqId'>" .
							 "<textarea rows='6' cols='50' data-bankNote-for-sentReqId='$sentReqId'></textarea>" .
							 "<button data-req-payment-submit-btn-sentReqId='$sentReqId'>确认请款</button>" . 
							 "<button data-req-payment-submit-btn-cancel-sentReqId='$sentReqId'>返回</button></div>";
					}
				} else {
					echo "状态：已经请款，银行信息如下：<br>";
					echo $bankNote;
					echo "<br>请款时间：" . $lastModifiedTime;
					echo "<br>⚠️目前无法手动修改请款银行信息，请联系上家修改。";
				}	
			} else {
				echo "状态：上家已付款，请及时确认，银行信息如下：<br>";
				echo $bankNote;
				echo "<br>付款时间：" . $lastModifiedTime;
				echo "<br><button class='payment-confirm-btn' data-confirm-payment-for-sentReqId='$sentReqId'>确认到款并完成以上订单</button>";
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