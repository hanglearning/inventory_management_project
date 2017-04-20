<?php
	
  session_start();

  $orderId 		           = $_POST['orderId'];
	$userId 		           = $_POST['userId'];
	$qtyTaken 		         = $_POST['qtyTaken'];
	$orderStatus	         = $_POST['orderStatus'];
  $orderTakenTime        = $_POST['orderTakenTime'];

  /* 将改pdo！040917 90419pm 3E OBS
  $con = mysqli_connect("localhost", "hangdev", "mindfreak", "realPro");
  if (!$con){
      die("Connection error: " . mysqli_connect_errno());
    }
  */

  $pdo = new PDO('mysql:host=localhost;dbname=realPro', 'hangdev', 'mindfreak', array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_EMULATE_PREPARES => false
  ));

  $pdo->beginTransaction();

try{
      // Insert orderRequested 
      // NOTE: here cut the time-insert, since lastModifiedTime in the table can be the order-requested time
      $sql = "INSERT INTO orderTaken (orderId, userId, qtyTaken, orderStatus, orderTakenTime) 
        VALUES ('$orderId', '$userId', '$qtyTaken', '$orderStatus' , '$orderTakenTime')";
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
      $newQtyLeftNeeded = (int)$oldQtyLeft - (int)$qtyTaken;
      $sql3 = "UPDATE orders SET qtyLeft='$newQtyLeftNeeded', totalQtyTaken='$newTotalQtyTaken' WHERE orderId = '$orderId'";
      $stmt3 = $pdo->prepare($sql3);
      $stmt3->execute();
      
  
      $pdo->commit();
      
  } 
  catch(Exception $e){
      
      echo $e->getMessage();
      $pdo->rollBack();
  }

  	
?>