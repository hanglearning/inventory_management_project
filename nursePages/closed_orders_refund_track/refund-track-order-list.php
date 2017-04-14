<?php
	session_start();
	$userId = $_SESSION['userId'];

	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	function makeLink($url)
	{
	    return ("<a href=" . $url . " target='_blank'>" . $url . "</a>");
	}

	try{
 	 
	    $sql = "SELECT * FROM orderTaken WHERE userId = '$userId' AND orderStatus='8' ORDER BY lastModifiedTime DESC";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();

	    while ($row = $stmt->fetch()){
	    	
	    	//$totalOrders++;
	    	$orderId = $row["orderId"];
	    	$orderTakenId = $row["orderTakenId"];
	    	$qtyTaken = $row["qtyTaken"];
	    	$lastModifiedTime = $row["lastModifiedTime"];
	    	$exceptionNote = $row["exceptionNote"];

	    	$sql2 = "SELECT * FROM orders WHERE orderId = '$orderId'";
		    $stmt2 = $pdo->prepare($sql2);
		    $stmt2->execute();
		    if ($row2 = $stmt2->fetch()){
		    	$itemName = $row2["itemName"];
		    	$itemLink = $row2["itemLink"];
		    	$itemCost = $row2["itemCost"];
		    	$itemShipping = $row2["itemShipping"];
		    }
		    $totalRefund = (int)($qtyTaken) * ((int)($itemCost) + (int)($itemShipping));
	    	
	    	//http://stackoverflow.com/questions/1866098/why-a-full-stop-and-not-a-plus-symbol-for-string-concatenation-in-php
	    	//String concatenation must be .dot than +plus in PHP!!!
	    	echo
	    	"<div class='closedOrdersTableList' data-closed-order-div-orderTakenId='$orderTakenId'>" .
	    	"关闭时间: "		. $lastModifiedTime . "<br />" .
	    	 "货品名称: " 			. $itemName . "<br />" .
	    	 "链接: "				. makeLink($itemLink) . "<br />" .
	    	 "成本: $"				. $itemCost . "<br />" .
	    	 "Shipping: $"			. $itemShipping . "<br />" .
	    	 "应回款总额: <span style='font-size:30px; color:red'>$" . $totalRefund . "</span><br />" .
	    	 "自填备注: "				. $exceptionNote . "<br />" .
	    	 //"<button class='take-order-btn' data-take-orderId='$orderId' data-qtyLeftNeeded = '$qtyLeftNeeded' type='submit' data-submit-order-userId='$userId'>修改订单</button>" .
	    	 "<button class='refund-confirm-btn' data-refund-confirm-orderTakenId='$orderTakenId' type='submit'>确认退款</button>" .
	    	 "</div>";
	    }

	    //echo "<div class='totalOrders-info' data-totalOrders='$totalOrders' style='display: none'></div>";
	    
	   	$pdo->commit();
	    
	} 

	catch(Exception $e){

	    echo $e->getMessage();

	    $pdo->rollBack();
	}


?>
