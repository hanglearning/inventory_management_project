<?php
	session_start();

	$pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
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
	    $sql = "SELECT * FROM orders A WHERE A.closed = '1' ORDER BY creationDate DESC";
	    $stmt = $pdo->prepare($sql);

	    $stmt->execute();


	    while ($row = $stmt->fetch()){
	    	
	    	$orderID = $row["orderId"];
	    	$qtyLeftNeeded = $row["qtyLeft"];
	    	$profitPerItem = $row["profitPerItem"];
	    	$itemLink = $row["itemLink"];
	    	//http://stackoverflow.com/questions/1866098/why-a-full-stop-and-not-a-plus-symbol-for-string-concatenation-in-php
	    	//String concatenation must be .dot than +plus in PHP!!!
	    	echo
	    	"<div class='closedOrdersTableList' data-close-order-div-orderId='$orderID'>" .
	    	"发布时间: "		. $row["creationDate"] . "<br />" .
	    	 "货品名称: " 			. $row["itemName"] . "<br />" .
	    	 "链接: "				. makeLink($itemLink) . "<br />" .
	    	 "起始收货数量： "			. $row["totalQty"] . "<br />" .
	    	 "未被领单数量: "	. $qtyLeftNeeded . "<br />" .
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
