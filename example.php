<?php

require_once('config/Constant.php');
require_once('lib/MpesaAPI.php');

//added by jjmomanyis
$PAYBILL_NO = "898998";
$MERCHENTS_ID = $PAYBILL_NO;
$MERCHANT_TRANSACTION_ID = generateRandomString();
$PRODUCT_ID = "1717171717171";
//

//Get the server address for callback
$host=gethostname();
$ip = gethostbyname($host);

//$Password=Constant::generateHash();
$Password='ZmRmZDYwYzIzZDQxZDc5ODYwMTIzYjUxNzNkZDMwMDRjNGRkZTY2ZDQ3ZTI0YjVjODc4ZTExNTNjMDA1YTcwNw==';
$mpesaclient=new MpesaAPI;

/**
 * Make payment
 */

$action=1;
if($action=1){
	//Replace the data with relevant information
	$mpesaclient->processCheckOutRequest($Password,$MERCHENTS_ID,$MERCHANT_TRANSACTION_ID,$PRODUCT_ID,"10","254728318609",$ip);
}
else if ($_GET['transactionType']=='txStatus') {
	//Replace the data with relevant information
	$TXID=$_GET['txid'];
	$MERCHANT_TRANSACTION_ID=$_GET['mt_id'];
	$mpesaclient->statusRequest($Password,MERCHANT_ID,$TXID,$MERCHANT_TRANSACTION_ID);
}
else{

	echo json_encode("No operation selected");
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
