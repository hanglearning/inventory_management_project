<?php
	
	session_start();

	$pdo = new PDO('mysql:host=localhost;dbname=chenh057_realPro', 'chenh057_hang01', 'bhgoszPg7iBcYD8WLAjeWrjEcH3LUcE96vHqCdGKnpNWZetxe', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	try{
		//https://www.w3schools.com/sql/sql_groupby.asp
		$sql = "SELECT * FROM users ORDER BY registeredTime DESC";
		$stmt = $pdo->prepare($sql);
	    $stmt->execute();

	    echo "<table><tr><th>ID</th><th>Email</th><th>名字</th><th>QQ</th><th>电话</th><th>微信</th><th>介绍人</th><th>注册时间</th><th>激活</th><th>停用</th></tr>";
	    while ($row = $stmt->fetch()){
	    	$userId = $row["userId"];
	    	$userEmail = $row["userEmail"];
	    	$userName = $row["userName"];
	    	$userQQ = $row["userQQ"];
	    	$userPhone = $row["userPhone"];
	    	$userWeChat = $row["userWeChat"];
	    	$userReferred = $row["userReferred"];
	    	$registeredTime = $row["registeredTime"];
	    	$active = $row["active"];
	    	$admin = $row["admin"];
	    	
	    	$tableRow = "<tr><td>" . $userId . "</td><td>" . $userEmail . "</td><td>" . $userName . "</td><td>" . $userQQ . "</td><td>" . $userPhone . "</td><td>" . $userWeChat . "</td><td>" . $userReferred . "</td><td>" . $registeredTime .  "</td><td>";
	    	if ($admin == '1'){
	    		$tableRow = $tableRow . "</td><td>" . "</td><tr>";
	    	} else {
	    		if ($active == '0'){
		    		$tableRow = $tableRow . "<button class='activate-user' data-activate-userId='$userId'>激活</button>" . "</td><td>" . "</td><tr>";
		    	} else {
		    		$tableRow = $tableRow . "</td><td>" . "<button class='stop-user' data-stop-userId='$userId'>停用</button>" . "</td><tr>";
		    	}
	    	}
	    	
	    	echo $tableRow;
	    }
	    echo "</table>";
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
