<?php
	
  $orderId 		           = $_POST['orderId'];
	$userId 		           = $_POST['userId'];
	$qtyTaken 		         = $_POST['qtyTaken'];
	$orderStatus	         = $_POST['orderStatus'];
  $originalQtyLeftNeeded = $_POST['qtyLeftNeeded'];


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
      // Update orderTaken
      $sql = "INSERT INTO orderTaken (orderId, userId, qtyTaken, orderStatus) 
        VALUES ('$orderId', '$userId', '$qtyTaken', '$orderStatus')";
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      echo "下单成功！当货物到时，请进行确认，或者万一出现砍单等情况，请关闭订单。";
      //echo "Order taken! Please confirm the order once it arrives or close this order if it is cancled by the manufacturer or there is an exception.";

      // Update orders
      if ($originalQtyLeftNeeded != "ALL IN") {
        $newQtyLeftNeeded = (int)$originalQtyLeftNeeded - (int)$qtyTaken;
        $sql2 = "UPDATE orders SET qtyLeft='$newQtyLeftNeeded' WHERE orderId = '$orderId'";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute();
      } else {
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