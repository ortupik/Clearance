$(function(){
   $("#pay_mpesa").on("click",function(){
       
       var amount = $("#amount").attr("data");
       
        $.ajax({
        type: "GET",
        url: "aTRequestPayment.php",
        dataType: "text",
        data:"productName="+'Dekut Hostel Clearance&amount='+amount
        }).done(function (res) {
           // if(res["success"] == 1){
             alert("To complete this transaction, enter your PIN on your handset");
                 setTimeout(function(){
                     updateHostel();
                },30000);
            //}
        });
    
   });
   
    function updateHostel(){
              
       $.ajax({
        type: "GET",
        url: "update_hostel.php",
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
       var message  = "Dekut Hostel Clearance... Dear Anthony You have successfully paid "+amount+". You have cleared with hostel ! ";
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