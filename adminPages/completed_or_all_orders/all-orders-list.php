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
 	 
	    //Query 1: Select closed orders from the order table
	    $sql = "SELECT * FROM orders ORDER BY creationTime DESC";
	    $stmt = $pdo->prepare($sql);

	    $stmt->execute();


	    while ($row = $stmt->fetch()){
	    	
	    	$orderID = $row["orderId"];
	    	$qtyLeftNeeded = $row["qtyLeft"];
	    	$profitPerItem = $row["profitPerItem"];
	    	$itemLink = $row["itemLink"];
	    	$totalQtyTaken = $row["totalQtyTaken"];
	    	echo
	    	"<div class='allOrdersTableList' data-all-order-div-orderId='$orderID'>" .
	    	"发布时间: "		. $row["creationTime"] . "<br />" .
	    	 "货品名称: " 			. $row["itemName"] . "<br />" .
	    	 "链接: "				. makeLink($itemLink) . "<br />" .
	    	 "起始收货数量: "			. $row["totalQty"] . "<br />" .
	    	 "未被领单数量: "	. $qtyLeftNeeded . "<br />" .
	    	 "总收货数量: <span style='font-size:40px; color:red'>"	. $totalQtyTaken . "</span><br />" .
	    	 "成本: $"				. $row["itemCost"] . "<br />" .
	    	 "Shipping: $"			. $row["itemShipping"] . "<br />" .
	    	 "利润:  <span style='font-size:40px; color:red'>$" . $profitPerItem . "</span><br />" .
	    	 "收货价格: <span style='font-size:30px; color:red'>$"	 . $row["itemReceivingPrice"] . "</span><br />" .
	    	 "Cashback推荐: "		. $row["cashBackRec"] . "<br />" .
	    	 "有效期至: "				. $row["validBy"] . "<br />" .
	    	 "备注: "				. $row["orderNote"] . "<br />" .
	    	 "</div>";
	    }
	    
	   	$pdo->commit();
	    
	} 

	catch(Exception $e){

	    echo $e->getMessage();

	    $pdo->rollBack();
	}


?>
