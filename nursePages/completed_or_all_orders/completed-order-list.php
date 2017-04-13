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

		$sql = "SELECT * FROM sentrequestbynurse WHERE userId = '$userId' AND confirmPaidByNurseAndComplete = '1' ORDER BY requestDate DESC";
	    //$sql = "SELECT * FROM orders WHERE closed = :closed";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();
	    
	    $requestSequence = 1;

	    $totalTotalProfit = 0;

	    while ($row = $stmt->fetch()){
	    	$sentReqId = $row["sentReqId"];
	    	$bankNote = $row["bankNote"];
	    	$lastModifiedTime = $row["lastModifiedTime"];
	    	echo "<div sent-payment-requested-div-for-sentReqId='$sentReqId'>";
	    	echo "完成序号:" . $requestSequence . " 确认完成时间: " . $lastModifiedTime . "<br>";
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
		    		if ($row3 = $stmt3->fetch()){
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
		    	$totalTotalProfit += $bigTotalProfit;
		    	$tableRow = "<tr><td>" . $itemName . "</td><td>" . $itemLink . "</td><td>" . $qtyTaken . "</td><td>" . $profitPerItem . "</td><td>" . $itemReceivingPrice . "</td><td>" . $smallTotalProfit . "</td><td>" . $smallTotalReceivingPrice .  "</td></tr>";
		    	echo $tableRow;
			}
			echo "</table>";
			echo "大总利润：<span style='font-size:40px; color:red'>$" . $bigTotalProfit . "</span> 总请款额：<span style='font-size:40px; color:red'>$" . $bigTotalReceivingPrice ."</span><br>";
			echo "回款信息：<br>";
			echo $bankNote;
			echo "</div>";
			$requestSequence++;
	    }
	    echo "<p style='text-align: right'>我赚了钱了赚钱了我都不知道怎么去花 <span style='font-size:40px; color:red'>$" . $totalTotalProfit . "</span></p>";

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