<?php
	
	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{

		// Instead of using JOIN table, here my logic is to get datas from two tables and display data by the 'JOIN' logic made myself
		// And well for now, if a user has made two delivery request then this user will be displayed once, since I still need to loop an array for each user and the logic would be simpler for now to not show all delivery request grouped by a single user
		$sql = "SELECT * FROM sentrequestbynurse WHERE deliveryConfirmedByAdmin = '0'";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();
	    while ($row1 = $stmt->fetch()){

	    	$userId = $row1["userId"];
	    	$orderTakenArrayString = $row1["orderTakenArray"];
	    	$sentReqId = $row1["sentReqId"];
	    	
	    	$sql2 = "SELECT * FROM users WHERE userId = '$userId'";
	    	$stmt2 = $pdo->prepare($sql2);
	    	$stmt2->execute();
	    	
	    	// Should be 1 userId for 1 user so use If here
	    	if ($row2 = $stmt2->fetch()){
	    		$userId = $row2["userId"];
	    		$userName = $row2["userName"];
	    		$userEmail = $row2["userName"];
	    		$userPhone = $row2["userPhone"];
	    		$userQQ = $row2["userQQ"];
	    	}
	    	echo "<div class='requested-by-one-orderTaken-div' data-requested-by-userId='$userId'>" .
	    		 "The following orders are requested delivery by " . $userName . ".<br/>" . //所以这里其实应该可以用'$userName'包含在double quotes里，我觉得。
	    		 "<button class='show-user-info' data-requested-by-user-info='$userId'>Show user contact info</button>" .
	    		 "<div class='data-requested-userInfo' data-requested-by-userinfo-userId='$userId'>" .
	    		 "Email: " . $userEmail . "<br/>" .
	    		 "Phone: " . $userPhone . "<br/>" .
	    		 "QQ: " . $userQQ . "<br/>" . "</div>";

	    	$orderTakenArray = explode(",", $orderTakenArrayString);
	    	//041017 80244pm 3E 终于在这里找到用过的explode！，就记得哪里用过，之前好像记错在implode那个位置用到的？OBS记录了反正，看这个时候OBS录的话吧（时间就是041017 80356pm）。将会同样用在nurse的payment-requested-data-list.php
	    	$orderTakenArrayLength = count($orderTakenArray);

	    	//$oneDliveryRequestOrdersArray = [];

	    	for($i = 1; $i < $orderTakenArrayLength + 1; $i++) {
	    		$orderTakenId = $orderTakenArray[$i];
	    		// Get the info like qtyTaken and order id, then back to order table using order id to get the order name and shit info(yea, I'm pretty bajed right now...very tired but can't fall in sleep and still desire to code so, give me power!!! 040717 43807am 3E damn! It's 0407le and 0426 I'm going!!! Kuaidian zhuajinshijian banshi le!!! Company close! Tax and shit!!! haoduo, haihaodoujizaigooglekeeplile. taihaole, jiusuanshangmiandekanbudong, yenengzhaodaoOBS, youzijideluyin, zhidaozaishuoshenme. Hint: all above are CHinese Pinyin, use pinyin to decode it if you really cant undersatnd but I guess you will, unless you are 80 now. Well, there gonna be one day for sure. And, I feel that day is tomorrow. Good or bad? I feel tired thought! I wanna feel young but still want to always remind me that I will be old one day. then I feel time is soon. Does it make my feeling of time too quick? Like I should feel 80 years but maybe only, 40~60 years? Will, I dont know. Everything is a double edge. Feel your one day now, one day is very very quick, but remember back to Primary school(Im feekling it! In Wei Ji Jiao Shi, cao wen zhang, jiao shi men kou, zou lang, lan se(blue), baishangyixiaofu? zhengqianfanghoumiandetiemen? ))
	    		$sql3 = "SELECT * FROM orderTaken WHERE userId = '$userId' AND orderTakenId = '$orderTakenId'";
	    		$stmt3 = $pdo->prepare($sql3);
	    		$stmt3->execute();
	    		while ($row3 = $stmt3->fetch()){
	    			$orderId 		= $row3["orderId"];
	    			$qtyTaken	 	= $row3["qtyTaken"];
	    			$orderTakenTime = $row3["orderTakenTime"];
	    			$sql4 = "SELECT * FROM orders WHERE orderId = '$orderId'";
	    			$stmt4 = $pdo->prepare($sql4);
	    			$stmt4->execute();
	    			// orderId is primary key so one order Id is associated to one item-ed order(yea bc one order contains one specific item)
	    			if ($row4 = $stmt4->fetch()){
	    				$itemName 			= $row4["itemName"];
	    				$itemLink 			= $row4["itemLink"];
	    				$itemCost 			= $row4["itemCost"];
	    				$itemReceivingPrice = $row4["itemReceivingPrice"];
	    			}
	    			echo "<div data-thisOrder-requested-by-userId='$userId' data-thisOrder-requested-orderTakenId='$orderTakenId'>" . 
	    				 $i . "<br/>" .
	    				 "Item name: " . $itemName . "<br/>" .
	    				 "Item link: " . $itemLink . "<br/>" . 
	    				 "Cost: " . $itemCost . "<br/>" .
	    				 "Receiving Price: " . $itemReceivingPrice . "<br/>" .
	    				 "Taken Qty: " . $qtyTaken . "<br/>" . 
	    				 "</div>";
	    		}
	    		echo "<button class='confirm-delivery-button' data-thisOrder-confirm-sentReqId='$sentReqId'>Confirm Delivery</button>".

	    	}
	    	echo "</div>";
	    	
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