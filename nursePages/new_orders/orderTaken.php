<?php
	
  session_start();

  $orderId 		           = $_POST['orderId'];
	$userId 		           = $_POST['userId'];
	$qtyTaken 		         = $_POST['qtyTaken'];
	$orderStatus	         = $_POST['orderStatus'];
  //041217 94844am 3E 这个也不用，重新query，下次改code把html里的originalQtyLeftNeeded都purge掉，现在先在php留着吧，不影响 $originalQtyLeftNeeded = $_POST['qtyLeftNeeded']; 041317 10327am 3E 相当于已purge
  //$beforeTotalQtyTaken   = $_POST['beforeTotalQtyTaken'];


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


      if ($oldQtyLeft != "ALL IN") {
        $newQtyLeftNeeded = (int)$oldQtyLeft - (int)$qtyTaken;
        $newTotalQtyTaken = (int)$oldTotalQtyTaken + (int)$qtyTaken;
        $sql3 = "UPDATE orders SET qtyLeft='$newQtyLeftNeeded', totalQtyTaken='$newTotalQtyTaken' WHERE orderId = '$orderId'";
        $stmt3 = $pdo->prepare($sql3);
        $stmt3->execute();
      } else {
        $sql3 = "UPDATE orders SET totalQtyTaken='$newTotalQtyTaken' WHERE orderId = '$orderId'";
        $stmt3 = $pdo->prepare($sql3);
        $stmt3->execute();
      }
      
      
      $pdo->commit();
      
  } 
  catch(Exception $e){
      
      echo $e->getMessage();
      $pdo->rollBack();
  }

  	
?>