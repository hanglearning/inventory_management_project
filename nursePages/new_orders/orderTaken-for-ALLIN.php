<?php
	
  session_start();

  $orderId 		           = $_POST['orderId'];
	$userId 		           = $_POST['userId'];
	$qtyTaken 		         = $_POST['qtyTaken'];
	$orderStatus	         = $_POST['orderStatus'];
  $orderTakenTime        = $_POST['orderTakenTime'];

  $pdo = new PDO('mysql:host=localhost;dbname=chenh057_realPro', 'chenh057_hang01', 'bhgoszPg7iBcYD8WLAjeWrjEcH3LUcE96vHqCdGKnpNWZetxe', array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_EMULATE_PREPARES => false
  ));

  $pdo->beginTransaction();

try{
      // Insert orderTaken
      $sql = "INSERT INTO orderTaken (orderId, userId, qtyTaken, orderStatus, orderTakenTime) 
        VALUES ('$orderId', '$userId', '$qtyTaken', '$orderStatus', '$orderTakenTime')";
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      echo "下单成功！当货物到时，请进行确认，或者万一出现砍单等情况，请关闭订单。";

      // Update orders
      // $newTotalQtyTaken = (int)$beforeTotalQtyTaken + (int)$qtyTaken; WRONG！应当重新query！
      $sql2 = "SELECT * FROM orders WHERE orderId = '$orderId'";
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->execute();
      if ($row = $stmt2->fetch()){
        $oldTotalQtyTaken = $row["totalQtyTaken"];
        //Yea，both reQuery
        $oldQtyLeft = $row["qtyLeft"];
      }

      $newTotalQtyTaken = (int)$oldTotalQtyTaken + (int)$qtyTaken;
      $sql3 = "UPDATE orders SET totalQtyTaken='$newTotalQtyTaken' WHERE orderId = '$orderId'";
      $stmt3 = $pdo->prepare($sql3);
      $stmt3->execute();
      
      
      
      $pdo->commit();
      
  } 
  catch(Exception $e){
      
      echo $e->getMessage();
      $pdo->rollBack();
  }

  	
?>
