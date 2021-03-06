<?php
	
  session_start();

  $orderTakenId	         = $_POST['orderTakenId'];
  $orderId               = $_POST['orderId'];
	//$userId 		           = $_POST['userId'];
	$qtyTaken 		         = $_POST['qtyTaken'];
	$originalAcceptedQty   = $_POST['originalAcceptedQty'];
	$orderStatus	         = $_POST['orderStatus'];
  $orderTakenTime        = $_POST['orderTakenTime'];

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
      // Insert orderRequested NONONO 042017 95435am 3E
      // ALLIN insert 没问题，但这里是绝对的update！
      // NOTE: here cut the time-insert, since lastModifiedTime in the table can be the order-requested time
      $sql = "UPDATE orderTaken SET qtyTaken='$qtyTaken', orderStatus='$orderStatus', orderTakenTime='$orderTakenTime' WHERE orderTakenId='$orderTakenId'";
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      //echo $sql;
      echo "下单成功！当货物到时，请进行确认，或者万一出现砍单等情况，请关闭订单。";
      
      // Update orders
      // $newTotalQtyTaken = (int)$beforeTotalQtyTaken + (int)$qtyTaken; WRONG！应当重新query！
      $sql2 = "SELECT * FROM orders WHERE orderId = '$orderId'";
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->execute();
      if ($row = $stmt2->fetch()){
        // No matter what happens, always update the totalQtyTaken though
        $oldTotalQtyTaken = $row["totalQtyTaken"];
        $newTotalQtyTaken = (int)$oldTotalQtyTaken + (int)$qtyTaken;
        //$newQtyLeftNeeded = (int)$oldQtyLeft - (int)$qtyTaken;
        // But here, when updating $newQtyLeftNeeded it's complicated, see below, so reWrite this query and yea I still want to update both in one query
        /*$sql3 = "UPDATE orders SET qtyLeft='$newQtyLeftNeeded', totalQtyTaken='$newTotalQtyTaken' WHERE orderId = '$orderId'";
        $stmt3 = $pdo->prepare($sql3);
        $stmt3->execute();*/
        
        //Yea，both reQuery
        // 042017 81047pm 3E qtyLeft has already been advised in admin's accept/change qty php page, so no need to change qtyLeft here, just update the totalQtyTaken, see OBS
        // WAIT, something makes it more complicated, I do need to change qtyLeft if this nurse has even changed the qty taken!!! aight 042017 91248pm 3E
        //Well, let's compare $originalAcceptedQty with $qtyTaken, and yea so update $qtyTaken in query1 $sql makes sense
        $oldQtyLeft = $row["qtyLeft"];
        if ((int)$qtyTaken == (int)$originalAcceptedQty){
          //Only update totalQtyTaken
          $sql3 = "UPDATE orders SET totalQtyTaken='$newTotalQtyTaken' WHERE orderId = '$orderId'";
          $stmt3 = $pdo->prepare($sql3);
          $stmt3->execute();
        } else if ((int)$qtyTaken < (int)$originalAcceptedQty){
          $difference = (int)$originalAcceptedQty - (int)$qtyTaken;
          $newQtyLeft = (int)$oldQtyLeft + $difference;
          $sql3 = "UPDATE orders SET totalQtyTaken='$newTotalQtyTaken', qtyLeft='$newQtyLeft' WHERE orderId = '$orderId'";
          $stmt3 = $pdo->prepare($sql3);
          $stmt3->execute();
        } else {
          echo "有问题哦！JS端没检查好大小。";
        }
      }
      $pdo->commit();
      
  } 
  catch(Exception $e){
      
      echo $e->getMessage();
      $pdo->rollBack();
  }

  	
?>
