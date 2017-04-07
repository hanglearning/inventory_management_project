<?php
	
	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

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
	    while ($row = $stmt->fetch()){

	    	$userId = $row["userId"];
	    	$orderTakenArrayString = $row["orderTakenArray"];
	    	
	    	$sql2 = "SELECT * FROM users WHERE userId = '$userId'";
	    	$stmt2 = $pdo->prepare($sql2);
	    	$stmt2->execute();
	    	
	    	// Should be 1 userId for 1 user so use If here
	    	if ($row = $stmt2->fetch()){
	    		$userName = $row["userName"];
	    		$userEmail = $row["userName"];
	    		$userPhone = $row["userPhone"];
	    		$userQQ = $row["userQQ"];
	    	}

	    	$orderTakenArray = explode(",", $orderTakenArrayString);
	    	$orderTakenArrayLength = count($orderTakenArray);

	    	$oneDliveryRequestOrdersArray = [];

	    	for($i = 0; $i < $orderTakenArrayLength; $i++) {
	    		$orderTakenId = $orderTakenArray[$i];
	    		// Get the info like qtyTaken and order id, then back to order table using order id to get the order name and shit info(yea, I'm pretty bajed right now...very tired but can't fall in sleep and still desire to code so, give me power!!! 040717 43807am 3E damn! It's 0407le and 0426 I'm going!!! Kuaidian zhuajinshijian banshi le!!! Company close! Tax and shit!!! haoduo, haihaodoujizaigooglekeeplile. taihaole, jiusuanshangmiandekanbudong, yenengzhaodaoOBS, youzijideluyin, zhidaozaishuoshenme. Hint: all above are CHinese Pinyin, use pinyin to decode it if you really cant undersatnd but I guess you will, unless you are 80 now. Well, there gonna be one day for sure. And, I feel that day is tomorrow. Good or bad? I feel tired thought! I wanna feel young but still want to always remind me that I will be old one day. then I feel time is soon. Does it make my feeling of time too quick? Like I should feel 80 years but maybe only, 40~60 years? Will, I dont know. Everything is a double edge. Feel your one day now, one day is very very quick, but remember back to Primary school(Im feekling it! In Wei Ji Jiao Shi, cao wen zhang, jiao shi men kou, zou lang, lan se(blue), baishangyixiaofu? zhengqianfanghoumiandetiemen? ))
	    		$sql3 = "SELECT * FROM orderTaken WHERE userId = '$userId' AND orderTakenId = '$orderTakenId'";
	    		$stmt3 = $pdo->prepare($sql3);
	    		$stmt3->execute();

	    	}
	    	echo
	    	"<div data-confirm-order-div-orderId='$orderId'>" .
	    	"<input type='checkbox' class='check-for-delivery-request' data-delivery-request-for-orderTakenId='$orderId' checked> " .
	    	"<label>Check here to request delivery for this order</label>" .
	    	"</br>" .
	    	"Taken Time: "			. $row["orderTakenTime"] . "<br />" .
	    	 "Item Name: " 			. $row["itemName"] . "<br />" .
	    	 "Link: "				. $row["itemLink"] . "<br />" .
	    	 "Qty Taken: "			. $qtyTaken . "<br />" .
	    	 "Cost: "				. $row["itemCost"] . "<br />" .
	    	 "Shipping: "			. $row["itemShipping"] . "<br />" .
	    	 "Profit: "				. $profitPerItem . "<br />" .
	    	 "Receiving Price: "	. $row["itemReceivingPrice"] . "<br />" .
	    	 "Cash back Rec: "		. $row["cashBackRec"] . "<br />" .
	    	 "Note: "				. $row["orderNote"] . "<br />" .
	    	 "Total profit on this order: $" . $totalProfitOnOrder .
	    	 "</div>";
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