$(function(){
   $("#pay_mpesa").on("click",function(){
       
        var amount = $("#amount").attr("data");
            
       $.ajax({
        type: "GET",
        url: "aTRequestPayment.php",
        dataType: "text",
        data:"productName="+'Dekut Sports & Games Clearance&amount='+amount
        }).done(function (res) {
            
            alert("To complete this transaction, enter your PIN on your handset");
          //  if(res["success"] == 1){
                setTimeout(function(){
                     updateSports();
                },30000);
            //}
            
        });
     
        
   });
   
    function updateSports(){
            
       $.ajax({
        type: "GET",
        url: "update_sports.php",
        dataType: "json",
        data:""
        }).done(function (res) {
            if(res["success"] == 1){
               sendMessage();
            }
        });
      
   }
   
   function sendMessage(){
        var amount = $("#amount").attr("data"); 
        var message  = "Dekut Sports Clearance... Dear Anthony, You have successfully paid "+amount+". You have cleared with Soprts Department ! ";
        $.ajax({
           type: "GET",
           url: "sendMessage.php",
           dataType: "json",
           data:"message="+message
           }).done(function (res) {
              // alert(res["message"]);
               if(res["success"] == 1){
                   location.reload();
               }
           });
   }
});