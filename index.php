<?php
  require_once __DIR__ . '/db/core.php';
  require_once __DIR__ . '/db/db_connect.php';

  $user_id = 1;
  $user_id = $_SESSION['user_id'];
  if(!isset($_SESSION['user_id'])){
   
      header("location:login.php");
  }
  
  $balance  = 0;
  $hasBalance = "You have cleared balance !!";
    
  
  $db = new DB_CONNECT();
  
  $finalArray = array();
  
  $total_amount = 0;

   $query = mysqli_query($db->connect(), "Select *,(Select SUM(`amount_due`) FROM `library` WHERE `user_id` = '$user_id') AS total_amount FROM `library` WHERE `user_id` = '$user_id' AND `amount_due` > 0 GROUP BY `id` ") or die(mysqli_error($db->connect()));
    if ($query) {
        $rows = mysqli_num_rows($query);
        $count = 0;
        if ($rows > 0) {
            while ($row = mysqli_fetch_array($query)) {
                $isbn = $row['isbn'];
                $title = $row['title'];
                $author = $row['author'];
                $amount_due = $row['amount_due'];
                $cleared = "Yes";
                if($amount_due > 0){
                    $cleared = "No";
                }
                $time_borrowed = $row['time_borrowed'];

                $dataArray = array();
                $dataArray['isbn'] = $isbn;
                $dataArray['title'] = $title;
                $dataArray['author'] = $author;
                $dataArray['amount_due'] = $amount_due;
                $dataArray['cleared'] = $cleared;
                
                $dataArray['time_borrowed'] = $time_borrowed;
                $total_amount = $row['total_amount'];
                
                $finalArray[$count] = $dataArray;
                $count++;
            }
        }
    }
    
    $finalArray2 = array();
    

   $query = mysqli_query($db->connect(), "Select *,(SELECT SUM(`amount`)  FROM `hostel` WHERE `user_id` = '$user_id'  ) AS total_amount FROM `hostel` WHERE `user_id` = '$user_id' AND `amount` > 0  GROUP BY `id`  ") or die(mysqli_error($db->connect()));
    if ($query) {
        $rows = mysqli_num_rows($query);
        $count2 = 0;
        if ($rows > 0) {
            while ($row = mysqli_fetch_array($query)) {
                $space_no = $row['space_no'];
                $room_no = $row['room_no'];
                $amount = $row['amount'];
                $academic_year = $row['academic_year'];
                $sem = $row['sem'];
                $cleared = $row['cleared'];

                $dataArray = array();
                $dataArray['space_no'] = $space_no;
                $dataArray['room_no'] = $room_no;
                $dataArray['amount'] = $amount;
                $dataArray['academic_year'] = $academic_year;
                $dataArray['sem'] = $sem;
                
                $cleared = "Yes";
                if($amount > 0){
                    $cleared = "No";
                }
                
                $dataArray['cleared'] = $cleared;
                $total_amount = $row['total_amount'];

                $finalArray2[$count2] = $dataArray;
                $count2++;
            }
        }
    }
    
   $query = mysqli_query($db->connect(), "Select * FROM `finance` WHERE `user_id` = '$user_id'") or die(mysqli_error($db->connect()));
    if ($query) {
        $rows = mysqli_num_rows($query);
        $count2 = 0;
        if ($rows > 0) {
            while ($row = mysqli_fetch_array($query)) {
                $balance = $row['balance'];
                if($balance > 0){
                    $hasBalance = "You have outstanding balance !!";
                }
            
            }
        }
    }
    
    $user_data = array();
    $query = mysqli_query($db->connect(), "Select * FROM user,user_details WHERE user.`user_id` = '$user_id' AND user.`user_id` = user_details.`user_id`") or die(mysqli_error($db->connect()));
    if ($query) {
        $rows = mysqli_num_rows($query);
        if ($rows > 0) {
           $row = mysqli_fetch_array($query);
           $user_data = $row;
           $_SESSION['name'] = $user_data['names'];
         //  echo json_encode($user_data);
            
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

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

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
                                <?php echo $user_data['names'] ?>
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

                            <li class="active">
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
                             <li class="">
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

                    <div class="col-md-6">	
                        <div class="widget stacked widget-table action-table">
                            <div class="widget-header">
                                <i class="icon-user"></i>
                                <h3>Personal Information</h3>
                            </div> <!-- /widget-header -->
                            <div class="widget-content">
                                <table class="table  table-bordered">
                                    <tbody>
                                        <tr><td>Admission No</td><td><span id="Main_lblNo"> <?php echo $user_data['reg_no'] ?></span></td></tr>
                                        <tr><td>Names</td><td><span id="Main_lblNames">  <?php echo $user_data['id_no'] ?></span></td></tr>
                                        <tr><td>ID/ Passport</td><td><span id="Main_lblIDNo"> <?php echo $user_data['names'] ?></span></td></tr>
                                        <tr><td>Gender</td><td><span id="Main_lblGender"> <?php echo $user_data['gender'] ?></span></td></tr>
                                        <tr><td>Date of Birth</td><td><span id="Main_lblDOB"> <?php echo $user_data['dob'] ?></span><span id="Main_Label8"></span></td></tr>
                                    </tbody>
                                </table>
                                
                            </div> <!-- /widget-content -->

                        </div> <!-- /widget -->
                        
                         <div class="widget stacked widget-table  action-table">
                            <div class="widget-header">
                                <i class="icon-dollar"></i>
                                <h3>Financial Information</h3>
                            </div> <!-- /widget-header -->
                            <div class="widget-content">
                                <table class="table table-bordered table-condensed">
                                    <thead>
                                        
                                    </thead>
                                    <tbody>
                                        <tr>
                                          <td colspan="3">
                                            <div class="label label-default">
                                                <?php echo $hasBalance?>
                                            </div>
                                            </td>
                                        </tr>
                                        <tr><td>Balance</td><td><span id="Main_lblBal"><?php echo $balance;?></span></td><td><a class="btn btn-sm btn-info" href="./finance.php">View</a></td></tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                                
                            </div> <!-- /widget-content -->

                        </div> <!-- /widget -->
                        <div class="col-md-6">
                            <div class="widget stacked widget-table  action-table">
                            <div class="widget-header">
                                <i class="icon-dollar"></i>
                                <h3>Academic Information</h3>
                            </div> <!-- /widget-header -->
                            <div class="widget-content">
                                <table class="table table-bordered table-condensed">
                                    <thead>
                                        
                                    </thead>
                                    <tbody>
                                        <tr>
                                          <td colspan="3">
                                            <div class="label label-success">
                                                You have no <strong>pending</strong> units !.
                                            </div>
                                            </td>
                                        </tr>
                                        <tr><td>Cleared 84 units</td></tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                                
                            </div> <!-- /widget-content -->
                             <div class="widget stacked widget-table  action-table">
                            <div class="widget-header">
                                <i class="icon-book"></i>
                                <h3>Library Clearance</h3>
                            </div> <!-- /widget-header -->
                            <div class="widget-content">
                                <table class="table table-bordered table-condensed">
                                    <thead>
                                       <thead>
                                        <tr>
                                        <th>#</th>   
                                         <th>Book ISBN</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Penalty</th>
                                        <th>Time</th>
                                        </tr>
                                    </thead>  
                                    </thead>
                                    <tbody>
                                        <tr>
                                         <!-- <td colspan="3">
                                            <div class="label label-danger">
                                                You have uncleared book(s) !
                                            </div>
                                            </td>-->
                                        </tr>
                                        <?php $count = 0;
                                    for ($j = 0; $j < sizeof($finalArray); $j++){
                                        $count++;
                                        ?>
                                        <tr class="">
                                           <td class="col col-lg-1 "> <?php echo $count; ?></td>
                                           <td class="col col-lg-2 "><?php echo $finalArray[$j]["isbn"]?></td>
                                            <td class="col col-lg-4 "><?php echo $finalArray[$j]["title"]?></td>
                                           <td class="col col-lg-1 "><?php echo $finalArray[$j]["author"]?></td>
                                           <td class="col col-lg-1 "><?php echo $finalArray[$j]["amount_due"]?></td>
                                          <td class="col col-lg-1 "><?php echo $finalArray[$j]["time_borrowed"]?></td>
                                       </tr>
                                    <?php }?>
                                        
                                    </tbody>
                                </table>
                            </div>
                                
                            </div> <!-- /widget-content -->
                             <div class="widget stacked widget-table  action-table">
                            <div class="widget-header">
                                <i class="icon-building"></i>
                                <h3>Hostels </h3>
                            </div> <!-- /widget-header -->
                            <div class="widget-content">
                                <table class="table table-bordered table-condensed">
                                   <thead>
                                         <tr>
                                             <th>#</th>  
                                           <th>Year</th>
                                           <th>Sem</th>
                                           <th>Room No</th>
                                           <th>Space No</th>
                                           <th>Balance</th>
                                            <th>Cleared</th>
                                         </tr>
                                     </thead>
                                    <tbody>
                                        <tr>
                                         <!-- <td colspan="3">
                                            <div class="label label-warning">
                                                You haven't cleared your hostel!.
                                            </div>
                                            </td> -->
                                        </tr>
                                        <?php $count2 = 0;
                                    for ($j = 0; $j < sizeof($finalArray2); $j++){
                                        $count2++;
                                        ?>
                                        <tr class="">
                                           <td class="col col-lg-1 "> <?php echo $count2; ?></td>
                                           <td class="col col-lg-1 "><?php echo $finalArray2[$j]["academic_year"]?></td>
                                           <td class="col col-lg-1 "><?php echo $finalArray2[$j]["sem"]?></td>
                                            <td class="col col-lg-1 "><?php echo $finalArray2[$j]["room_no"]?></td>
                                           <td class="col col-lg-1 "><?php echo $finalArray2[$j]["space_no"]?></td>
                                           <td class="col col-lg-1 "><?php echo $finalArray2[$j]["amount"]?></td>
                                          <td class="col col-lg-1 "><?php echo $finalArray2[$j]["cleared"]?></td>
                                       </tr>
                                    <?php }?>
                                        
                                    </tbody>
                                </table>
                            </div>
                                
                            </div> <!-- /widget-content -->
                        </div>
                    </div> <!-- /span6 -->

                </div> <!-- /row -->

            </div> <!-- /container -->

         <div class="footer">

            <div class="container">

                <div class="row">

                    <div id="footer-copyright" class="col-md-6">
                        &copy; 2017. Dekut
                    </div> <!-- /span6 -->

                    <div id="footer-terms" class="col-md-6">
                        Dekut Clearence Portal 2017/2018
                    </div> <!-- /.span6 -->

                </div> <!-- /row -->

            </div> <!-- /container -->

        </div> <!-- /footer -->





        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="./js/libs/jquery-1.9.1.min.js"></script>
        <script src="./js/libs/jquery-ui-1.10.0.custom.min.js"></script>
        <script src="./js/libs/bootstrap.min.js"></script>

        <script src="./js/plugins/flot/jquery.flot.js"></script>
        <script src="./js/plugins/flot/jquery.flot.pie.js"></script>
        <script src="./js/plugins/flot/jquery.flot.resize.js"></script>

        <script src="./js/Application.js"></script>

        <script src="./js/charts/area.js"></script>
        <script src="./js/charts/donut.js"></script>

    </body>
</html>
