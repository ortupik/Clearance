    <?php
    require_once __DIR__ . '/AfricasTalkingGateway.php';
    
   if(isset($_GET['message'])){
    // Be sure to include the file you've just downloaded
    
     $message = $_GET['message'];
     
    // Specify your login credentials
    $username   = "chrisadriane";
    $apikey     = "0c96e32597f9d00c0363f8ade6fd8377320f67bd12f11d324811878103d8c7c2";
    // Specify the numbers that you want to send to in a comma-separated list
    // Please ensure you include the country code (+254 for Kenya in this case)
    $recipients = "+254725612257";
    // And of course we want our recipients to know what we really do
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
          
        $results["success"] = 1;
        $results["message"] = "Succssfully sent message !";
        echo json_encode($results);
      }
    }
    catch ( AfricasTalkingGatewayException $e )
    {
        $results["success"] = 0;
        echo json_encode($results);
    }
    }