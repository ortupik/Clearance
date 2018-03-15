<?php
  require_once __DIR__ . '/db/core.php';
  require_once __DIR__ . '/db/db_connect.php';

 $user_id = $_SESSION['user_id'];
  if(!isset($_SESSION['user_id'])){
      $user_id = $_SESSION['user_id'];
      header("location:login.php");
  }
  
  $db = new DB_CONNECT();
  
  $finalArray = array();
  $total_amount = 0;

   $query = mysqli_query($db->connect(), "UPDATE `hostel` SET `amount` = 0 WHERE `user_id` = '$user_id'  ") or die(mysqli_error($db->connect()));
    if ($query) {
        $finalArray["message"] = "Successfully Paid";
        $finalArray["success"] = 1;
        echo json_encode($finalArray);
    }else{
       $finalArray["message"] = "Failed to Pay";
       $finalArray["success"] = 0;
       echo json_encode($finalArray);
    }