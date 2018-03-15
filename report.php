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

   $query = mysqli_query($db->connect(), "Select user,paid,date,transaction_id FROM `report` WHERE `user_id`  = '$user_id' ") or die(mysqli_error($db->connect()));
    if ($query) {
        $rows = mysqli_num_rows($query);
        $count = 0;
        if ($rows > 0) {
            while ($row = mysqli_fetch_array($query)) {
                $paid = $row['paid'];
                if($paid > 0 ){
                $cleared = "Yes";
                $remarks = "Paid Successfully";
              
              
                
                $dataArray = array();
                $dataArray['user'] = $row["user"];
                $dataArray['date'] = $row["date"];
                $dataArray['transaction_id'] = $row["transaction_id"];
                // $dataArray['balance'] = $balance;
                $dataArray['paid'] = $paid;
                $dataArray['cleared'] = $cleared;
                 $dataArray['remarks'] = $remarks;

                $finalArray[$count] = $dataArray;
                $count++;
                }
            }
        }
    }
    
    $query = mysqli_query($db->connect(), "Select * FROM `clearTable` WHERE `user_id`  = $user_id ") or die(mysqli_error($db->connect()));
    if ($query) {
        $rows = mysqli_num_rows($query);
        if ($rows > 0) {
            while ($row = mysqli_fetch_array($query)) {
              
                $status = $row["status"];
                if($status == "Y"){
                     $cleared = "Yes";
                }else{
                     $cleared = "No";
                }
               
                $remarks = "";
                $paid = "";
              
                
                $dataArray = array();
                $dataArray['user'] = $row["user"];
                $dataArray['date'] = "";
                $dataArray['transaction_id'] = "";
                // $dataArray['balance'] = $balance;
                $dataArray['paid'] = $paid;
                $dataArray['cleared'] = $cleared;
                 $dataArray['remarks'] = "";

                $finalArray[$count] = $dataArray;
                $count++;
            }
        }
    }
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Clearance</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">    

        <link href="./css/bootstrap.min.css" rel="stylesheet">
        <link href="./css/bootstrap-responsive.min.css" rel="stylesheet">

        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
        <link href="./css/font-awesome.min.css" rel="stylesheet">        

        <link href="./css/ui-lightness/jquery-ui-1.10.0.custom.min.css" rel="stylesheet">

        <link href="./css/base-admin-3.css" rel="stylesheet">
        <link href="./css/base-admin-3-responsive.css" rel="stylesheet">

        <link href="./css/pages/dashboard.css" rel="stylesheet">   

        <link href="./css/custom.css" rel="stylesheet">
            <link href="./js/plugins/faq/faq.css" rel="stylesheet"> 


        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <style>
            .td{
                margin:50px;
            }
        </style>
    </head>

    <body>

        <nav class="navbar navbar-inverse" role="navigation">

            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="icon-cog"></i>
                    </button>
                    <a class="navbar-brand" href="./index.php">DeKut Clearance</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav navbar-right">
                       

                        <li class="dropdown">

                            <a href="javscript:;" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-user"></i> 
                                 <?php echo $_SESSION['name'] ?>
                                <b class="caret"></b>
                            </a>

                            <ul class="dropdown-menu">
                                <li><a href="login.php">Logout</a></li>
                            </ul>

                        </li>
                    </ul>

                   
                </div><!-- /.navbar-collapse -->
            </div> <!-- /.container -->
        </nav>





        <div class="subnavbar">

            <div class="subnavbar-inner">

                <div class="container">

                    <a href="javascript:;" class="subnav-toggle" data-toggle="collapse" data-target=".subnav-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="icon-reorder"></i>

                    </a>

                    <div class="collapse subnav-collapse">
                        <ul class="mainnav">

                            <li >
                                <a href="./index.php">
                                    <i class="icon-home"></i>
                                    <span>Home</span>
                                </a>	    				
                            </li>
                            <li class="">
                                <a href="./library.php">
                                    <i class="icon-book"></i>
                                    <span>Library</span>
                                </a>	    				
                            </li>
                             <li class="">
                                <a href="./finance.php">
                                    <i class="icon-dollar"></i>
                                    <span>Finance</span>
                                </a>	    				
                            </li>
                             <li class="">
                                <a href="./hostel.php">
                                    <i class="icon-building"></i>
                                    <span>Hostel</span>
                                </a>	    				
                            </li>
                            <li class="">
                                <a href="./sports.php">
                                    <i class="icon-gears"></i>
                                    <span>Sports and Games</span>
                                </a>	    				
                            </li>
                             <li class="active">
                                 <a href="./report.php">
                                    <i class="icon-bookmark"></i>
                                    <span>Report</span>
                                </a>	    				
                            </li>

                        </ul>
                    </div> <!-- /.subnav-collapse -->

                </div> <!-- /container -->

            </div> <!-- /subnavbar-inner -->

        </div> <!-- /subnavbar -->


        <div class="main">

            <div class="container">

                <div class="row">
                    <div class="col-md-3">
                            <div class="widget-content">
                                 <a class="btn btn-primary btn-support-ask" id="download_pdf">Download  PDF</a>	
                            </div> <!-- /widget-content -->
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-12">	
                        <div class="widget widget-nopad stacked">
				
                            <div class="widget-header">
                                    <i class="icon-building"></i>
                                    <h3>MPesa payment Reports</h3>
                            </div> <!-- /widget-header -->
			   <div class="widget-content">
                                 <table class="table  table-bordered">
                                     <thead>
                                         <tr>
                                           <th></th>
                                           <th>Paid(KES)</th> 
                                           <th>Cleared</th>
                                           <th>Remarks</th>
                                           <th>Time/Date</th>
                                         </tr>
                                     </thead>
                                    <tbody>
                                        <?php $count = 0;
                                    for ($j = 0; $j < sizeof($finalArray); $j++){
                                        $count++;
                                        ?>
                                        <tr class="">
                                           <td class="col col-lg-1 "><?php echo $finalArray[$j]["user"]?></td>
                                            <td class="col col-lg-1 "><?php echo $finalArray[$j]["paid"]?></td>
                                            <td class="col col-lg-1 "><?php echo $finalArray[$j]["cleared"]?></td>
                                               <td class="col col-lg-1 "><?php echo $finalArray[$j]["remarks"]?></td>
                                           <td class="col col-lg-1 "><?php echo $finalArray[$j]["date"]?></td>
                                       </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
			
			</div> <!-- /widget -->	
	              
                    </div>
                 

                </div> <!-- /row -->

            </div> <!-- /container -->

       
        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="./js/libs/jquery-3.2.1.min.js"></script>
        <script src="./js/libs/bootstrap.min.js"></script>
        <script src="./js/hostel_payment.js"></script>
        <script>
            $("#download_pdf").on("click",function(){
               $.post("test2.php", function(data, status){
                // alert("Data: " + data + "\nStatus: " + status);
              }); 
            });
        </script>

    </body>
</html>
