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
 	 
	    //Query 1: Select active orders from the order table
	    //http://stackoverflow.com/questions/767026/how-can-i-properly-use-a-pdo-object-for-a-parameterized-select-query
	    $sql = "SELECT * FROM orders INNER JOIN orderTaken ON orders.orderId = orderTaken.orderId WHERE orderTaken.userId = '$userId' AND orderTaken.orderStatus = '1'";
	    //$sql = "SELECT * FROM orders WHERE closed = :closed";
	    $stmt = $pdo->prepare($sql);

	    $stmt->execute();
	    while ($row = $stmt->fetch()){

	    	$orderId = $row["orderId"];
	    	$qtyTaken = $row["qtyTaken"];
	    	$profitPerItem = $row["profitPerItem"];
	    	$totalProfitOnOrder = $qtyTaken * $profitPerItem;
	    	$orderTakenId = $row["orderTakenId"]; // 你个呆！傻！这个得用与更新自己order的数量以及其他用途怎么这个能忘了，还以为change-qty-btn写完了写的很好能work！怪不得数据库会是乱的！怎么能只记录这个的orderId而不记录自己所对应的orderTakenId
	    	//http://stackoverflow.com/questions/1866098/why-a-full-stop-and-not-a-plus-symbol-for-string-concatenation-in-php
	    	//String concatenation must be .dot than +plus in PHP!!!
	    	$itemLink = $row["itemLink"]; 
	    	//$totalQtyTaken = $row["totalQtyTaken"]; 
	    	echo
	    	"<div class='claimedOrdersTableList' data-confirm-order-div-orderId='$orderId' data-confirm-order-div-orderTakenId='$orderTakenId'>" . //以后在编时，应该要把所有attributes放到div，不用放在button，毕竟可以直接用div[data]=这样选定，再说这些button也是这个div里的，哦不对，div也得有，不然也不知道button对应了哪个order的div。哦，还是看需要写吧。这么来说，好像还是得把orderTakenId放在qty-change-button里，因为在那它才matter。对啊！编程理念就应该紧随哪个matter放在哪！哦，想起来了，或者应该用jQuery去选parentNode。我操！那么一想！妈的其实这些button都需要orderTakenId！当时怎么想的没加上这些！对了利用下chrome里js console去选选btn的parentNode，可以的话，就只在div加入orderTakenId吧。然后，日后的升级要把所有attribute都移上来，然后根据parentNode提取attribute。最简化code，也符合极简主义，也符合编程理念，Do not repeat yourself! well程序员会不会自动就会被培养出极简主义哈哈哈哈！
	    	//Chrome JS Console里面： $("button[data-confirm-orderId=4]").parent().attr("data-confirm-order-div-orderTakenId") -> "4" 没问题！
	    	"领单时间: "			. $row["orderTakenTime"] . "<br />" .
	    	 "货品名称: " 			. $row["itemName"] . "<br />" .
	    	 "链接: "				. makeLink($itemLink) . "<br />" .
	    	 "下单数量: "			. $qtyTaken . "<br />" .
	    	 "成本: $"				. $row["itemCost"] . "<br />" .
	    	 "Shipping: $"			. $row["itemShipping"] . "<br />" .
	    	 "利润: <span style='font-size:30px; color:red'>$"	. $profitPerItem . "</span><br />" .
	    	 "收货价格: "	. $row["itemReceivingPrice"] . "<br />" .
	    	 "Cashback推荐: "		. $row["cashBackRec"] . "<br />" .
	    	 "备注: "				. $row["orderNote"] . "<br />" .
	    	 "光这一🥚你就赚了 <span style='font-size:40px; color:red'>$" . $totalProfitOnOrder . "</span><br />" .
	    	 "<button class='order-confirm-btn' data-confirm-orderId='$orderId' data-confirm-order-userId='$userId' type='submit' 
	    	 	 data-qty-taken-confirm='$qtyTaken'>确认到货</button>" .
	    	 "<button class='order-change-qty-btn' data-change-qty-orderId='$orderId'
	    	 	data-qty-taken = '$qtyTaken'  type='submit' data-change-qty-userId='$userId'>修改数量</button>" .
	    	 "<div class='order-change-qty-div' data-order-change-qty-div-orderId='$orderId'></div>" .
	    	 "<button class='revert-order-btn' data-revert-orderId='$orderId' type='submit'
	    	 	 data-revert-qty = '$qtyTaken'
	    	 	 data-revert-order-userId='$userId'>放弃订单</button>" .
	    	 "<button class='close-order-btn' data-close-orderId='$orderId' type='submit' data-close-order-userId='$userId' data-close-order-back-qty='$qtyTaken'>关闭订单</button>" .
	    	 //"<div class='close-order-note-div' close-order-note-div-orderId='$orderId'></div>" .
	    	 "</div>";
	    	 // data-close-order-back-qty, back-qty means the qty that will be added back
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