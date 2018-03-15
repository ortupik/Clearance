<?php
$dataPOST = trim(file_get_contents('php://input'));

//Parse the xml data

$xml = simplexml_load_string($checkoutResponse);
		$ns = $xml->getNamespaces(true);
		$soap = $xml->children($ns['SOAP-ENV']);
		$sbody = $soap->Body;
		$mpesa_response = $sbody->children($ns['ns1']);
		$rstatus = $mpesa_response->processCheckOutResponse;
		$status = $rstatus->children();		
		$s_msisdn = $status->MSISDN;
		$s_date = $status->{'M-PESA_TRX_DATE'};
		$s_transactionid = $status->{'M-PESA_TRX_ID'};
		$s_status = $status->TRX_STATUS;
		$s_returncode = $status->RETURN_CODE;
		$s_description = $status->DESCRIPTION;
		$s_merchant_transaction_id = $status->MERCHANT_TRANSACTION_ID;
		$s_encparams = $status->ENC_PARAMS;
		$s_txID = $status->TRX_ID;

	//Save the returned data into the database or use it to finish certain operation.
	
	if($s_status=="Success")
 		{
// Be sure to include the file you've just downloaded
require_once('AfricasTalkingGateway.php');

// Specify your login credentials
  $username   = "jjmomanyis";
    $apikey     = "752f96d2278da710d968d56f621b60bcb08ce9ef3a75a9d64c0b206ac72995e6";

// Specify the numbers that you want to send to in a comma-separated list
// Please ensure you include the country code (+254 for Kenya in this case)
$recipients = "+".$s_msisdn;
$message    = "Confirmed on".$s_date."you paid your bill.";

// Create a new instance of our awesome gateway class
$gateway    = new AfricasTalkingGateway($username, $apikey);

// Any gateway error will be captured by our custom Exception class below, 
// so wrap the call in a try-catch block

try 
{ 
  // Thats it, hit send and we'll take care of the rest. 
  $results = $gateway->sendMessage($recipients, $message);
			
  foreach($results as $result) 
{
  
  }
}
catch ( AfricasTalkingGatewayException $e )
{
  echo "Encountered an error while sending: ".$e->getMessage();
}
	}else{




require_once('AfricasTalkingGateway.php');

// Specify your login credentials
  $username   = "jjmomanyis";
    $apikey     = "752f96d2278da710d968d56f621b60bcb08ce9ef3a75a9d64c0b206ac72995e6";

// Specify the numbers that you want to send to in a comma-separated list
// Please ensure you include the country code (+254 for Kenya in this case)
$recipients = "+254726442087";

// And of course we want our recipients to know what we really do
$message    = "Error occured";

// Create a new instance of our awesome gateway class
$gateway    = new AfricasTalkingGateway($username, $apikey);

// Any gateway error will be captured by our custom Exception class below, 
// so wrap the call in a try-catch block

try 
{ 
  // Thats it, hit send and we'll take care of the rest. 
  $results = $gateway->sendMessage($recipients, $message);
			
  foreach($results as $result) {
    // status is either "Success" or "error message"
   // echo " Number: " .$result->number;
   // echo " Status: " .$result->status;
   // echo " MessageId: " .$result->messageId;
    //echo " Cost: "   .$result->cost."\n";
  }
}
catch ( AfricasTalkingGatewayException $e )
{
  echo "Encountered an error while sending: ".$e->getMessage();
}














		//Perform X operation
	}



?>		


