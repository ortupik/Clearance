<?php
require_once('./AfricasTalkingGateway_money.php');

$results = array();

if (isset($_GET['productName']) && isset($_GET['amount'])) {

    $productName = $_GET['productName'];
    $amount = $_GET['amount'];
    
    $username = "sandbox";
    $apiKey = "8e2be9b98609ee44d76064aaafbf7ade1f81a9c641147e2a992a1daeda561873";
//Create an instance of our awesome gateway class and pass your credentials
    $gateway = new AfricasTalkingGateway($username, $apiKey,"sandbox");
    /*     * ***********************************************************************************
      NOTE: If connecting to the sandbox:
      1. Use "sandbox" as the username
      2. Use the apiKey generated from your sandbox application
      https://account.africastalking.com/apps/sandbox/settings/key
      3. Add the "sandbox" flag to the constructor
      $gateway  = new AfricasTalkingGateway($username, $apiKey, "sandbox");
     * ************************************************************************************ */
// Specify the name of your Africa's Talking payment product
    $productName = "Dekut Clearance";
// The phone number of the customer checking out
    $phoneNumber = "+254725612257";
// The 3-Letter ISO currency code for the checkout amount
    $currencyCode = "KES";
// The checkout amount
// Any metadata that you would like to send along with this request
// This metadata will be  included when we send back the final payment notification
    $metadata = array("agentId" => "654",
        "productId" => "321");
    try {
        // Initiate the checkout. If successful, you will get back a transactionId
        $transactionId = $gateway->initiateMobilePaymentCheckout($productName, $phoneNumber, $currencyCode, $amount, $metadata);
        $results["success"] = 1;
        $results["transaction_id"] = $transactionId;
        $results["message"] = "Succssfully made payment !";
        echo json_encode($results);
    } catch (AfricasTalkingGatewayException $e) {
        $results["success"] = 0;
        $results["error"] = $e->getMessage();
        $results["message"] = "Error making payment !";
        echo json_encode($results);
    }
}
?>
