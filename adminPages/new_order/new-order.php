<?php
	session_start();
	$itemName 			= $_POST["itemName"];
	$itemLink 			= $_POST["itemLink"];
	$totalQty 			= $_POST["totalQty"];
	$itemCost			= $_POST["itemCost"];
	$itemShipping 		= $_POST["itemShipping"];
	$profitPerItem 		= $_POST["profitPerItem"];
	$itemReceivingPrice = $_POST["itemReceivingPrice"];
	$cashBackRec 		= $_POST["cashBackRec"];
	$validBy 			= $_POST["validBy"];
	$orderNote 			= $_POST["orderNote"];
	$creationTime 		= $_POST["creationTime"];


	$con = mysqli_connect("localhost", "hangdev", "mindfreak", "realPro");
	if (!$con){
  		die("Connection error: " . mysqli_connect_errno());
  	}

	$insert_order_sql = "INSERT INTO orders (itemName, itemLink, totalQty, qtyLeft, 
			itemCost, itemShipping, profitPerItem, itemReceivingPrice, cashBackRec, validBy, orderNote, creationTime) VALUES ('$itemName', '$itemLink', '$totalQty', '$totalQty',
			'$itemCost', '$itemShipping', '$profitPerItem', '$itemReceivingPrice', '$cashBackRec', '$validBy', '$orderNote', '$creationTime')";

	$query = mysqli_query($con, $insert_order_sql);

	echo "<h3>订单已建立!</h3>";
	/* 
	//echo $insert_order_sql;
	date_default_timezone_set('America/New_York');
	// https://github.com/PHPMailer/PHPMailer/blob/master/examples/gmail.phps

	// PHPMailer
	// http://stackoverflow.com/questions/1400795/root-path-doesnt-work-with-php-include
	include ($_SERVER['DOCUMENT_ROOT']."/realPro_Chinese_Stage3_Cloud9/adminPages/PHPMailer/PHPMailerAutoload.php");

	//Create a new PHPMailer instance
	$mail = new PHPMailer;
	//Tell PHPMailer to use SMTP
	$mail->isSMTP();
	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	$mail->SMTPDebug = 2;
	//Ask for HTML-friendly debug output
	$mail->Debugoutput = 'html';
	//Set the hostname of the mail server
	$mail->Host = 'smtp.gmail.com';
	// use
	// $mail->Host = gethostbyname('smtp.gmail.com');
	// if your network does not support SMTP over IPv6
	//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
	$mail->Port = 587;
	//Set the encryption system to use - ssl (deprecated) or tls
	$mail->SMTPSecure = 'tls';
	//Whether to use SMTP authentication
	$mail->SMTPAuth = true;
	//Username to use for SMTP authentication - use full email address for gmail
	$mail->Username = "chenhangnewarkde@gmail.com";
	//Password to use for SMTP authentication
	$mail->Password = "ACqcB4FXkHdgC(wmg7bPYw,DHiJ8DexFqERpomCWm2W,iGvjaWtUBqAUwr&6Bix)";
	//Set who the message is to be sent from
	$mail->setFrom('hang@delaware.com', 'Hang Delaware');
	//Set an alternative reply-to address
	$mail->addReplyTo('chenhanginud@hotmail.com', 'Hang Chen');
	//Set who the message is to be sent to
	$mail->addAddress('dingdannumber1@gmail.com', 'Ding Dan');
	//Set the subject line
	$mail->Subject = 'new订单！';
	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
	//Replace the plain text body with one created manually
	$mail->Body = "发布时间: "		. $creationTime . "<br />" .
	    	 "货品名称: " 			. $itemName . "<br />" .
	    	 "链接: 哈哈！请登录领单！<br />" .
	    	 "所需总量: "	. $totalQty . "<br />" .
	    	 "成本: $"				. $itemCost . "<br />" .
	    	 "Shipping: $"			. $itemShipping . "<br />" .
	    	 "利润:  <span style='font-size:40px; color:red'>$" . $profitPerItem . "</span><br />" .
	    	 "收货价格: <span style='font-size:30px; color:red'>$"	 . $itemReceivingPrice . "</span><br />" .
	    	 "Cashback推荐: "		. $cashBackRec . "<br />" .
	    	 "有效期至: "				. $validBy . "<br />" .
	    	 "备注: <span style='font-size:20px; color:red'>" . $orderNote . "<span><br />";
	//Attach an image file
	//$mail->addAttachment('images/phpmailer_mini.png');
	//send the message, check for errors
	if (!$mail->send()) {
	    echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	    echo "<h3>订单已建立!邮件已发送！</h3>";
	}*/
?>
