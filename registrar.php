<?php
  require_once __DIR__ . '/db/core.php';
  require_once __DIR__ . '/db/db_connect.php';

 if(!isset($_SESSION['admin_user_id'])){
    //  $user_id = $_SESSION['admin_user_id'];
     // header("location:admin_login.php");
  }
  
  $dataSet = FALSE;
    $status ="";
  
  if(isset($_POST['regno'])){
      
   $db = new DB_CONNECT();
  
  $finalArray = array();
  
  $total_amount = 0;
      
   $reg_no = $_POST['regno'];
   
    $query = mysqli_query($db->connect(), "Select * FROM user WHERE `reg_no` = '$reg_no'") or die(mysqli_error($db->connect()));
     if ($query) {
        $rows = mysqli_num_rows($query);
        if ($rows > 0) {
           $row = mysqli_fetch_array($query);
            $user_id = $row['user_id']; 
            $_SESSION['user_user_id'] = $user_id;
              $dataSet = TRUE;
        }
     }
    
  $user_id =  $_SESSION['user_user_id'];
  if(isset($_POST['status_btn']) && $user_id != NULL){
      
       $queryAvail = mysqli_query($db->connect(), "SELECT (SELECT COUNT(*) FROM sports WHERE user_id = $user_id AND amount_due > 0) + (SELECT COUNT(*) FROM library WHERE user_id = $user_id  AND amount_due > 0) + (SELECT COUNT(*) FROM hostel WHERE user_id = $user_id AND amount > 0) + (SELECT COUNT(*) FROM damages WHERE user_id = $user_id AND amount > 0) +(SELECT COUNT(*) FROM finance WHERE user_id = $user_id AND balance > 0)  as available") or die(mysqli_error($db->connect()));
    if ($queryAvail) {
        $rows = mysqli_num_rows($queryAvail);
        if ($rows > 0) {
           $row = mysqli_fetch_array($queryAvail);
           $avail = $row['available'];
           if($avail > 0 ){
                echo '<script>alert("The Student Can\'t be cleared because, he/she has not cleared other departments!!")</script>';
           }else{
                     $query = mysqli_query($db->connect(), "UPDATE `cleartable` SET `status` = 'Y'  WHERE `user` = 'Registrar' AND `user_id` = $user_id ") or die(mysqli_error($db->connect()));
           }
        }
    }
   
  }
   
   
     
  $balance  = 0;
  $hasBalance = "Student has  No balance !!";
    
  
 $query2 = mysqli_query($db->connect(), "Select * FROM `cleartable` WHERE `user_id` = '$user_id' AND user = 'Director' ") or die(mysqli_error($db->connect()));
    if ($query2) {
        $rows2 = mysqli_num_rows($query2);
        if ($rows2 > 0) {
                $query = mysqli_query($db->connect(), "Select * FROM `cleartable` WHERE `user_id` = '$user_id' AND status = 'Y' AND user = 'Registrar'") or die(mysqli_error($db->connect()));
                   if ($query) {
                       $rows = mysqli_num_rows($query);
                       if ($rows > 0) {
                          $status = "STATUS: Student Cleared";
                       }else{
                           $status = "STATUS: Student NOT Cleared";
                       }
                   }
        }else{
            $query3 = mysqli_query($db->connect(), "CALL clearTable($user_id); ") or die(mysqli_error($db->connect()));
            if ($query3) {
                $query = mysqli_query($db->connect(), "Select * FROM `cleartable` WHERE `user_id` = '$user_id' AND status = 'Y' AND user = 'Registrar'") or die(mysqli_error($db->connect()));
                if ($query) {
                    $rows = mysqli_num_rows($query);
                    if ($rows > 0) {
                       $status = "STATUS: Student Cleared";
                    }else{
                        $status = "STATUS: Student NOT Cleared";
                    }
                }
            }
        }
    }

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
  }else{
      $reg_no = "";
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
                               Registrar(AA)
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
                                <a href="#">
                                    <i class="icon-book"></i>
                                    <h3>Registrar(AA)</h3>
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
                    <div class="col-md-12 row">
                        <form method="POST" action="registrar.php">
				<div class="field col-lg-3">
					<label for="firstname"> Enter Student Reg No.:</label>
					<input type="text" name="regno"  value="<?php echo  $reg_no; ?>"  class="form-control" />
				</div> <!-- /field -->
                                
                                <br>
                                <div class="field col-lg-2">
                                    <input type="submit" class="login-action btn btn-primary" Value="Get Details"/>
                                </div>
                                  <div class="field col-lg-2">
                                       <?php if($dataSet == TRUE){?>
                                     <h1><label class="label label-default"> <?php echo  $status; ?></label></h1><br>
                                     <?php if($status == "STATUS: Student NOT Cleared"){
                                         ?><input type="submit" class=" btn btn-danger btn-lg " name="status_btn" Value="Clear Student"/>
                                       <?php }}?>
                                     
                                </div>
                                
                               </form>
                    </div><br>
                </div>
                <?php if($dataSet == TRUE){?>
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
                                            <div class="label label-default">
                                                Student has no <strong>pending</strong> units !.
                                            </div>
                                            </td>
                                        </tr>
                                        <tr><td>Cleared 84 units</td></tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                                
                            </div> <!-- /widget-content -->
                            
                        </div>
                    </div> <!-- /span6 -->
               
                </div> <!-- /row -->

            </div> <!-- /container -->

        

 <?php }?>



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
