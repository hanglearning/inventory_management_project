<?php
	session_start();

	$pdo = new PDO('mysql:host=localhost;dbname=chenh057_realPro', 'chenh057_hang01', 'bhgoszPg7iBcYD8WLAjeWrjEcH3LUcE96vHqCdGKnpNWZetxe', array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false
	));

	$pdo->beginTransaction();

	// http://stackoverflow.com/questions/3452319/convert-plain-text-urls-to-html-hyperlinks-in-php
	function makeLink($url)
	{
	    return ("<a href=" . $url . " target='_blank'>" . $url . "</a>");
	}

	try{
 	 
	    //Query 1: Select active orders from the order table
	    //http://stackoverflow.com/questions/767026/how-can-i-properly-use-a-pdo-object-for-a-parameterized-select-query
	    $sql = "SELECT * FROM orders A WHERE A.closed = '0' ORDER BY creationTime DESC";
	    //$sql = "SELECT * FROM orders WHERE closed = :closed";
	    $stmt = $pdo->prepare($sql);

	    $stmt->execute();

	    //$totalOrders = 0;

	    while ($row = $stmt->fetch()){
	    	
	    	//$totalOrders++;

	    	$orderID = $row["orderId"];
	    	$qtyLeftNeeded = $row["qtyLeft"];
	    	$profitPerItem = $row["profitPerItem"];
	    	$itemLink = $row["itemLink"];
	    	//http://stackoverflow.com/questions/1866098/why-a-full-stop-and-not-a-plus-symbol-for-string-concatenation-in-php
	    	//String concatenation must be .dot than +plus in PHP!!!
	    	echo
	    	"<div class='ongoingOrdersTableList' data-take-order-div-orderId='$orderID'>" .
	    	"发布时间: "		. $row["creationTime"] . "<br />" .
	    	 "货品名称: <span style='font-size:25px; color:blue'>" . $row["itemName"] . "</span><br />" .
	    	 "链接: "				. makeLink($itemLink) . "<br />" .
	    	 "起始收货数量: "			. $row["totalQty"] . "<br />" .
	    	 "目前还可收这些数量: "	. $qtyLeftNeeded . "<br />" .
	    	 "成本: $"				. $row["itemCost"] . "<br />" .
	    	 "Shipping: $"			. $row["itemShipping"] . "<br />" .
	    	 "利润:  $" . $profitPerItem . "<br />" .
	    	 "收货价格: <span style='font-size:30px; color:red'>$"	 . $row["itemReceivingPrice"] . "</span><br />" .
	    	 "Cashback推荐: "		. $row["cashBackRec"] . "<br />" .
	    	 "有效期至: "				. $row["validBy"] . "<br />" .
	    	 "备注: "				. $row["orderNote"] . "<br />" .
	    	 //"<button class='take-order-btn' data-take-orderId='$orderID' data-qtyLeftNeeded = '$qtyLeftNeeded' type='submit' data-submit-order-userId='$userId'>修改订单</button>" .
	    	 "<button class='close-order-btn' data-close-orderId='$orderID' type='submit'>截单</button>" .
	    	 "<div class='close-order-info-div' data-close-orderId-div='$orderID'></div>" .
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
