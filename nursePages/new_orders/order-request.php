<?php
	
  session_start();

  $orderId 		           = $_POST['orderId'];
	$userId 		           = $_POST['userId'];
	$qtyRequested 		     = $_POST['qtyRequested'];
	$orderStatus	         = $_POST['orderStatus'];
  $orderRequestedTime    = $_POST['orderRequestedTime'];

  /* 将改pdo！040917 90419pm 3E OBS
  $con = mysqli_connect("localhost", "chenh057_hang01", "bhgoszPg7iBcYD8WLAjeWrjEcH3LUcE96vHqCdGKnpNWZetxe", "chenh057_realPro");
  if (!$con){
      die("Connection error: " . mysqli_connect_errno());
    }
  */

  $pdo = new PDO('mysql:host=localhost;dbname=chenh057_realPro', 'chenh057_hang01', 'bhgoszPg7iBcYD8WLAjeWrjEcH3LUcE96vHqCdGKnpNWZetxe', array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_EMULATE_PREPARES => false
  ));

  $pdo->beginTransaction();

try{
      // Insert orderRequested 
      // NOTE: here cut the time-insert, since lastModifiedTime in the table can be the order-requested time
      $sql = "INSERT INTO orderTaken (orderId, userId, qtyTaken, orderStatus) 
        VALUES ('$orderId', '$userId', '$qtyRequested', '$orderStatus')";
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      echo "已报数量". $qtyTaken . "！请等待神医批准。\n若此单已发布很久，请直接联系神医提醒批准。";
  
      $pdo->commit();
      
  } 
  catch(Exception $e){
      
      echo $e->getMessage();
      $pdo->rollBack();
  }

  	
?>
