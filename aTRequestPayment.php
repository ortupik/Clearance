<?php

    require_once('config/Constant.php');
    require_once('lib/MpesaAPI.php');
   require_once __DIR__ . '/db/core.php';
   require_once __DIR__ . '/db/db_connect.php';

 $user_id = $_SESSION['user_id'];
  $db = new DB_CONNECT();
 

    $results = array();
    
    
   $user = "";
        
   
    if(isset($_GET['productName']) && isset($_GET['amount'])){
      
        $productName = $_GET['productName'];
       $amount = $_GET['amount'];
       
       
       switch($productName){
           case  "Dekut Library Clearance":
               $user =  "Librarian";
               break;
           case  "Dekut Sports & Games Clearance":
               $user =  "Sports Officer";
               break;
           case  "Dekut Hostel Clearance":
               $user =  "Hostel Manager";
               break;
            case  "Finance":
               $user =  "Finance";
               break;
            case  "Dekut Damages Clearance":
               $user =  "Damages";
               break;
        }
        
        $query2 = mysqli_query($db->connect(), "SELECT *  FROM report where user_id = $user_id ") or die(mysqli_error($db->connect()));
        if ($query2) {
             $rows = mysqli_num_rows($query2);
             if ($rows > 0) {
                   $query = mysqli_query($db->connect(), "UPDATE `report` SET `paid` = $amount  WHERE `user` = '$user' AND `user_id` = $user_id ") or die(mysqli_error($db->connect()));
                    if ($query) {
                        $results["success"] = 1;
                        $results["message"] = "Successfully made payment !";
                      //  echo json_encode($results);
                     }
             }else{
                   $query3 = mysqli_query($db->connect(), "CALL insertReport($user_id); ") or die(mysqli_error($db->connect()));
                    if ($query3) {
                        $query = mysqli_query($db->connect(), "UPDATE `report` SET `paid` = $amount  WHERE `user` = '$user' AND `user_id` = $user_id ") or die(mysqli_error($db->connect()));
                         if ($query) {
                             $results["success"] = 1;
                             $results["message"] = "Successfully made payment !";
                           //  echo json_encode($results);
                          }
                    }
             }
         }
      

        //added by jjmomanyis
        $PAYBILL_NO = "898998";
        $MERCHENTS_ID = $PAYBILL_NO;
        $MERCHANT_TRANSACTION_ID = generateRandomString();
        $PRODUCT_ID = $productName;

        //Get the server address for callback
        $host=gethostname();
        $ip = gethostbyname($host);

        //$Password=Constant::generateHash();
        $Password='ZmRmZDYwYzIzZDQxZDc5ODYwMTIzYjUxNzNkZDMwMDRjNGRkZTY2ZDQ3ZTI0YjVjODc4ZTExNTNjMDA1YTcwNw==';
        $mpesaclient = new MpesaAPI;


        $action=1;
        if($action=1){
                $mpesaclient->processCheckOutRequest($Password,$MERCHENTS_ID,$MERCHANT_TRANSACTION_ID,$PRODUCT_ID,10,"254725612257",$ip);//254725612257
        }else if ($_GET['transactionType']=='txStatus') {
                //Replace the data with relevant information
                $TXID = $_GET['txid'];
                $MERCHANT_TRANSACTION_ID = $_GET['mt_id'];
                $mpesaclient->statusRequest($Password,MERCHANT_ID,$TXID,$MERCHANT_TRANSACTION_ID);
               
        }
        else{
                $results["success"] = 0;
                $results["message"] = "No operation selected";
                echo json_encode($results);
        }
      
    }else{
         $results["success"] = 0;
                $results["message"] = "Not set !!";
                echo json_encode($results);
    }
    
    function generateRandomString() {
            $length = 10;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
        
?>
        