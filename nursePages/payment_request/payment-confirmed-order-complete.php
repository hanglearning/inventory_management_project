<?php

	session_start();
	
	$sentReqId = $_POST["sentReqId"];

	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{
		$sql = "SELECT orderTakenArray FROM sentrequestbynurse WHERE sentReqId='$sentReqId'";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		if ($row = $stmt->fetch()){
			$orderTakenArray = $row["orderTakenArray"];
		}
		//From payment-requested-data-list.php
		$paymentRequestedOrdersTakenIdContained = explode(",", $orderTakenArray);
	    $numOfOrdersOfPaymentRequested = count($paymentRequestedOrdersTakenIdContained);
	    for($i = 0; $i < $numOfOrdersOfPaymentRequested; $i++) {
	    		$orderTakenId = $paymentRequestedOrdersTakenIdContained[$i];
			    $sql2 = "UPDATE orderTaken SET orderStatus='7' WHERE orderTakenId='$orderTakenId'";
			   	$stmt2 = $pdo->prepare($sql2);
		    	$stmt2->execute();
		}

	    $sql3 = "UPDATE sentrequestbynurse SET confirmPaidByNurseAndComplete='1' WHERE sentReqId='$sentReqId'";
		$stmt3 = $pdo->prepare($sql3);
		$stmt3->execute();
	    //https://zhidao.baidu.com/question/331245075548145645.html?si=1&qbpn=1_1&tx=&wtp=wk&word=%E8%B5%9A%E9%92%B1+%E8%AF%97%E8%AF%8D&fr=solved&from=qb&ssid=&uid=bd_1427146674_400&pu=sz%40224_240%2Cos%40&step=6&bd_page_type=1&init=middle
	    //https://www.w3schools.com/php/func_math_rand.asp
	    $ran = rand(1, 7);
	    if ($ran == 1){
	    	echo "开花无数黄金钱，从此即可挥霍钱！";
	    } else if ($ran == 2){
	    	echo "暗掷金钱卜远人，远人从此求保养！";
	    } else if ($ran == 3){
	    	echo "石竹金钱何细碎，碎碎细细来挥霍！";
	    } else if ($ran == 4){
	    	echo "敕赐金钱二百万，何时我赚二百万！";
	    } else if ($ran == 5){
	    	echo "万人楼下拾金钱，偏偏我来把钱赚！";
	    } else if ($ran == 6){
	    	echo "东篱菊放金钱小，想要大钱还下单！";
	    } else if ($ran == 7){
	    	echo "来啊！挥霍啊！大把时间像金山！";
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