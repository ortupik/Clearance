$(function(){
   $("#pay_fees").on("click",function(){
      
        var ref = $("#ref_no").val();
        
        if(ref == "ref1234"){
             var proceed = confirm("You are about to pay fees , proceed ?");
                if(proceed){
                      setTimeout(function(){
                     updateFinance();
                },10000);
                }
        }else{
            alert("Please insert valid ref number !");
        }
       
      
   });
   
    function updateFinance(){
        
       
       $.ajax({
        type: "GET",
        url: "update_finance.php",
        dataType: "json",
        data:""
        }).done(function (res) {
            alert(res["message"]);
            if(res["success"] == 1){
                var message  = "Dekut Finance Clearance... Dear Anthony, You have successfully paid . You have cleared with Finance ! ";
                $.ajax({
                   type: "GET",
                   url: "sendMessage.php",
                   dataType: "json",
                   data:"message="+message
                   }).done(function (res) {
                       alert(res["message"]);
                       if(res["success"] == 1){
                           location.reload();
                       }
                   });
                
            }
        });
        
        
      
   }
});