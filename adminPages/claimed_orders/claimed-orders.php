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
		echo "<h3 style='color: black; font-size:20px; text-align: center'>以下为护士报数的单子，请依情况执行操作。</h3>";
		//http://stackoverflow.com/questions/43478069/best-way-to-identify-a-mysql-changed-group-by-field-value-in-a-statement-fetch
		// My question
		$sql = "SELECT * FROM orderTaken WHERE orderStatus='10' ORDER BY orderId DESC, orderTakenTime DESC";
		$stmt = $pdo->prepare($sql);
	    $stmt->execute();
	    $count = $stmt->rowCount();
		for ($i = 0; $i < $count + 1; $i++){
			if ($row = $stmt->fetch()){
				$orderId = $row["orderId"];
				$qtyRequested = $row["qtyTaken"];
				$requestedTime = $row["lastModifiedTime"];
				$orderTakenId = $row["orderTakenId"];
				//$totalQtyRequested += (int)($qtyRequested);
				if (isset($oldOrderId)){
					if ($oldOrderId != $orderId){
						/*
						echo "看看" . $oldOrderId;
						echo "NEWNEW";*/
						echo "</table><br>";
						//echo "NEWNEW2";
						echo "共请求数量：" . $totalQtyRequested . "<br>";
						if ($isFull == false){
							$qtyLeftNeededNew = (int)($totalQty) - ((int)($totalQtyRequested) + (int)($totalQtyTaken));
							if ($qtyLeftNeededNew > 0){
								echo "若全部批准，此单还可收<span style='color: red; font-size:20px'>" . $qtyLeftNeededNew . "</span>单。<br></div>";
							} else if ($qtyLeftNeededNew == 0){
								echo "若全部批准，此单正好收全。<br></div>";
							} else {
								$qtyLeftNeededNew = (int)$qtyLeftNeededNew * (-1);
								echo "注意！若全部批准，此单将<span style='color: red; font-size:20px'>超量" . $qtyLeftNeededNew . "</span>单！<br></div>";
							}
						} else {
							$qtyLeftExceeded = (int)($totalQtyTaken) - (int)($totalQty);
							$qtyLeftExceededNew = (int)($totalQtyRequested) + (int)($qtyLeftExceeded);
							echo "此单已超量<span style='color: red; font-size:20px'>". $qtyLeftExceeded . "</span>单！<br>";
							echo "若全部批准，此单将<span style='color: red; font-size:20px'>总超量" . $qtyLeftExceededNew . "</span>单！<br></div>";
						}
						$totalQtyRequested = 0;
						$totalQtyRequested += (int)($qtyRequested);
						//echo "前Sequence" . $orderIdChangeSequence;
						$orderIdChangeSequence++;
						//echo "后Sequence" . $orderIdChangeSequence;
						echo "<div orderSequenceNum='$orderIdChangeSequence'>单子：" . $orderIdChangeSequence . "<br>";
						$sql2 = "SELECT * FROM orders WHERE orderId='$orderId'";
						$stmt2 = $pdo->prepare($sql2);
				    	$stmt2->execute();
				    	if($row2 = $stmt2->fetch()){
				    		$itemName = $row2["itemName"];
				    		$itemLink = makeLink($row2["itemLink"]);
				    		$itemCost = $row2["itemCost"];
				    		$itemReceivingPrice = $row2["itemReceivingPrice"];
				    		$totalQty = $row2["totalQty"];
				    		$totalQtyTaken = $row2["totalQtyTaken"];
				    		$qtyLeft = $row2["qtyLeft"];
				    		$creationTime = $row2["creationTime"];
				    	}
				    	$orderInfoGeneral = "货名: " . $itemName . "<br>" .
				    						"链接: " . $itemLink . "<br>" .
				    						"单价: " . $itemCost . "<br>" .
					    					"收价: " . $itemReceivingPrice . "<br>" . 
											"订单建立时间" . $creationTime . "<br>" .
											"目标收货数量" . $totalQty . "<br>" .
				    						"目前已收数量" . $totalQtyTaken . "<br>";
				    	if ((int)($totalQtyTaken) >= (int)($totalQty)) {
				    		$isFull = true;
				    		echo $orderInfoGeneral . "<span style='color: red; font-size:20px'>注意，此单已收满！</span><br>";
				    	} else {
				    		$isFull = false;
				    		$qtyLeftNeeded = (int)($totalQty) - (int)($totalQtyTaken);
				    		echo $orderInfoGeneral . "此单还可收<span style='color: red; font-size:20px'>" . $qtyLeftNeeded . "</span>单。<br>";
				    	}
				    	//echo "DEBUG 1";
				    	echo "<table><tr><th>护士</th><th>QQ</th><th>请求数量1</th><th>请求时间</th><th>批准</th><th>修改并批数量</th><th>拒绝</th></tr>";
				    	//echo "FUCK";
				    	$userId = $row["userId"];
				    	$sql3 = "SELECT * FROM users WHERE userId='$userId'";
				    	$stmt3 = $pdo->prepare($sql3);
				    	$stmt3->execute();
				    	if($row3 = $stmt3->fetch()){
				    		$userName = $row3["userName"];
				    		$userQQ = $row3["userQQ"];
				    	}
				    	echo "<tr><td>" . $userName . "</td><td>" . $userQQ . "</td><td>" . $qtyRequested . "</td><td>" . $requestedTime . "</td><td>" .
				    	"<button class='accept-qty-btn' data-accept-orderTakenId='$orderTakenId'>批</button>" . "</td><td>" .
				    	"<button class='accept-change-qty-btn' data-accept-change-qty-orderTakenId='$orderTakenId' data-accept-change-qty-userName='$userName'>改并批</button>" . "</td><td>" .
				    	"<button class='reject-qty-btn' data-reject-orderTakenId='$orderTakenId' data-accept-change-qty-userName='$userName'>拒</button>" . "</td></tr>";
				    	//echo "不一样前最新setoldOrderId为". $oldOrderId;
				    	$oldOrderId = $orderId;
				    	//echo "不一样后最新setoldOrderId为". $oldOrderId;
				    //$oldOrderId == $orderId
				    } else {
				    	//echo "SAME";
				    	//若一样则继续print
				    	$totalQtyRequested += (int)($qtyRequested);
				    	$userId = $row["userId"];
				    	$sql3 = "SELECT * FROM users WHERE userId='$userId'";
				    	$stmt3 = $pdo->prepare($sql3);
				    	$stmt3->execute();
				    	if($row3 = $stmt3->fetch()){
				    		$userName = $row3["userName"];
				    		$userQQ = $row3["userQQ"];
				    	}
				    	//echo "SAME YEA";
				    	echo "<tr><td>" . $userName . "</td><td>" . $userQQ . "</td><td>" . $qtyRequested . "</td><td>" . $requestedTime . "</td><td>" .
				    	"<button class='accept-qty-btn' data-accept-orderTakenId='$orderTakenI'>批</button>" . "</td><td>" .
				    	"<button class='accept-change-qty-btn' data-accept-change-qty-orderTakenId='$orderTakenId' data-accept-change-qty-userName='$userName'>改并批</button>" . "</td><td>" .
				    	"<button class='reject-qty-btn' data-reject-orderTakenId='$orderTakenId' data-accept-change-qty-userName='$userName'>拒</button>" . "</td></tr>";
				    	//echo "一样前最新setoldOrderId为". $oldOrderId;
				    	$oldOrderId = $orderId;
				    	//echo "一样后最新setoldOrderId为". $oldOrderId;
				    }
				} else {
					//echo "XIN";
					//全新
					// 检查应该是无误了 041917 101920am 3E
					$orderIdChangeSequence = 0;
					$totalQtyRequested = 0;
					$totalQtyRequested += (int)($qtyRequested);
					$orderIdChangeSequence++;
					echo "<div orderSequenceNum='$orderIdChangeSequence'>单子：" . $orderIdChangeSequence . "<br>";
					$sql2 = "SELECT * FROM orders WHERE orderId='$orderId'";
					$stmt2 = $pdo->prepare($sql2);
			    	$stmt2->execute();
			    	if($row2 = $stmt2->fetch()){
			    		$itemName = $row2["itemName"];
			    		$itemLink = makeLink($row2["itemLink"]);
			    		$itemCost = $row2["itemCost"];
			    		$itemReceivingPrice = $row2["itemReceivingPrice"];
			    		$totalQty = $row2["totalQty"];
			    		$totalQtyTaken = $row2["totalQtyTaken"];
			    		$qtyLeft = $row2["qtyLeft"];
			    		$creationTime = $row2["creationTime"];
			    	}
			    	$orderInfoGeneral = "货名: " . $itemName . "<br>" .
			    						"链接: " . $itemLink . "<br>" .
			    						"单价: " . $itemCost . "<br>" .
				    					"收价: " . $itemReceivingPrice . "<br>" . 
										"订单建立时间" . $creationTime . "<br>" .
										"目标收货数量" . $totalQty . "<br>" .
			    						"目前已收数量" . $totalQtyTaken . "<br>";
			    	if ((int)($totalQtyTaken) >= (int)($totalQty)) {
			    		$isFull = true;
			    		echo $orderInfoGeneral . "<span style='color: red; font-size:20px'>注意，此单已收满！</span><br>";
			    	} else {
			    		$isFull = false;
			    		$qtyLeftNeeded = (int)($totalQty) - (int)($totalQtyTaken);
			    		echo $orderInfoGeneral . "此单还可收<span style='color: red; font-size:20px'>" . $qtyLeftNeeded . "</span>单。<br>";
			    	}
			    	/*echo "DEBUG2";
			    	echo "oldOrderId第一次：";
			    	echo $oldOrderId;
			    	echo "CAONIMA0";*/
			    	echo "<table><tr><th>护士</th><th>QQ</th><th>请求数量2</th><th>请求时间</th><th>批准</th><th>修改并批数量</th><th>拒绝</th></tr>";
			    	//echo "CAONIMA";
			    	$userId = $row["userId"];
			    	$sql3 = "SELECT * FROM users WHERE userId='$userId'";
			    	$stmt3 = $pdo->prepare($sql3);
			    	$stmt3->execute();
			    	if($row3 = $stmt3->fetch()){
			    		$userName = $row3["userName"];
			    		$userQQ = $row3["userQQ"];
			    	}
			    	//echo "CAONIMA2";
			    	echo "<tr><td>" . $userName . "</td><td>" . $userQQ . "</td><td>" . $qtyRequested . "</td><td>" . $requestedTime . "</td><td>" .
			    	"<button class='accept-qty-btn' data-accept-orderTakenId='$orderTakenId'>批</button>" . "</td><td>" .
			    	"<button class='accept-change-qty-btn' data-accept-change-qty-orderTakenId='$orderTakenId' data-accept-change-qty-userName='$userName'>改并批</button>" . "</td><td>" .
			    	"<button class='reject-qty-btn' data-reject-orderTakenId='$orderTakenId' data-accept-change-qty-userName='$userName'>拒</button>" . "</td></tr>";
			    	//echo "CAONIMA3";
			    	//echo "前最新setoldOrderId为". $oldOrderId;
			    	$oldOrderId = $orderId;
			    	//echo "后最新setoldOrderId为". $oldOrderId;
				}
			}
			//echo "i是" . $i . "count是" . $count . "<br>";
			// 没显示
			if ($i == $count){
				//echo "进来哦？？";
				if (isset($totalQtyRequested)){
					//echo "进来呀？";
					echo "</table><br>";
					//echo "LAST共请求数量：" . $totalQtyRequested . "<br>";
					echo "共请求数量：" . $totalQtyRequested . "<br>";
					if ($isFull == false){
						$qtyLeftNeededNew = (int)($totalQty) - ((int)($totalQtyRequested) + (int)($totalQtyTaken));
						if ($qtyLeftNeededNew > 0){
							echo "若全部批准，此单还可收<span style='color: red; font-size:20px'>" . $qtyLeftNeededNew . "</span>单。<br></div>";
						} else if ($qtyLeftNeededNew == 0){
							echo "若全部批准，此单正好收全。<br></div>";
						} else {
							$qtyLeftNeededNew = (int)$qtyLeftNeededNew * (-1);
							echo "注意！若全部批准，此单将<span style='color: red; font-size:20px'>超量" . $qtyLeftNeededNew . "</span>单！<br></div>";
						}
					} else {
						$qtyLeftExceeded = (int)($totalQtyTaken) - (int)($totalQty);
						$qtyLeftExceededNew = (int)($totalQtyRequested) + (int)($qtyLeftExceeded);
						echo "此单已超量<span style='color: red; font-size:20px'>". $qtyLeftExceeded . "</span>单！<br>";
						echo "若全部批准，此单将<span style='color: red; font-size:20px'>总超量" . $qtyLeftExceededNew . "</span>单！<br></div>";
					}
				} else {
					
				}
			}
		}
		
		/* PART II */
		
		echo "<h3 style='color: black; font-size:20px; text-align: center'>以下为护士已确认申领的单子</h3>";
		
		$sql = "SELECT * FROM orderTaken WHERE orderStatus='1' ORDER BY orderId DESC, orderTakenTime DESC";
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
	    	
	    	$tableRow = "<tr><td>" . $userName . "</td><td>" . $userQQ . "</td><td>" . $qtyTaken . "</td><td>" . $itemName . "</td><td>" . $itemLink . "</td><td>" . $itemCost . "</td><td>" . $itemReceivingPrice . "</td><td>" . $orderTakenTime .  "</td></tr>";
	    	echo $tableRow;
	    }
	    echo "</table>";
	    $pdo->commit();

	} 
	catch(Exception $e){
	    echo $e->getMessage();
	    $pdo->rollBack();
	}


?>