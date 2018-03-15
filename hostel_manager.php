
<?php
  require_once __DIR__ . '/db/core.php';
  require_once __DIR__ . '/db/db_connect.php';

  $user_id  = 1;
  if(!isset($_SESSION['admin_user_id'])){
    //  $user_id = $_SESSION['admin_user_id'];
    //  header("location:admin_login.php");
  }
  
  $db = new DB_CONNECT();
  
  $finalArray2 = array();
  
  $total_amount = 0;
  $query = mysqli_query($db->connect(), "Select *,(SELECT SUM(`amount`) FROM `hostel` ) AS total_amount FROM `hostel` WHERE  `cleared`  = 'N' AND `amount` > 0 GROUP BY `id`  ") or die(mysqli_error($db->connect()));
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
    
    if(isset($_POST['space_no']) && isset($_POST['room_no']) &&  isset($_POST['year']) && isset($_POST['sem']) && isset($_POST['amount']) && isset($_POST['regno'])){
        $space_no= $_POST['space_no'];
        $room_no = $_POST['room_no'];
        $year = $_POST['year'];
        $amount = $_POST['amount'];
        $sem = $_POST['sem'];
		
     
	     $reg_no = $_POST['regno'];
         $user_id = "";
    
	//echo json_encode($_POST);
	
    $query2 = mysqli_query($db->connect(), "Select * FROM user WHERE `reg_no` = '$reg_no'") or die(mysqli_error($db->connect()));
     if ($query2) {
        $rows = mysqli_num_rows($query2);
        if ($rows > 0) {
           $row = mysqli_fetch_array($query2);
            $user_id = $row['user_id'];       
			
     $query = mysqli_query($db->connect(), "INSERT INTO `hostel` (`user_id`,`space_no`,`room_no`,`academic_year`,`sem`,`amount`) values('$user_id','$space_no','$room_no','$year','$sem',$amount)")or die(mysqli_error($db->connect()));
        if ($query) {
             echo '<script>alert("Successfully added penalty !!");</script>';
             header("location:hostel_manager.php");
        } else {
            echo '<script>alert("Failed to add check fields and try again!!")</script>';
        }
    
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
                                Hostel Manager
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
                                    <i class="icon-building"></i>
                                    <h3>Hostel Manager</h3>
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

                    <div class="col-md-4">	
                        <div class="widget stacked widget-table action-table">
                             <div class="widget-header">
                                <i class="icon-building"></i>
                                <h3>Add Hostel Arrears:</h3>
                            </div> <!-- /widget-header -->
                            <div class="widget-content " style="padding: 20px;">
                                <form method="POST" action="hostel_manager.php">
				<div class="field">
					<label for="firstname">Student Reg No.:</label>
					<input type="text" name="regno"  value="" placeholder="Reg No" class="form-control" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="lastname">Academic Year:</label>	
					<input type="text" name="year"  value="" placeholder="e.g 2017/2018" class="form-control" />
				</div> <!-- /field -->
                                <div class="field">
					<label for="firstname">Semister:</label>
					<input type="text" name="sem"  value="" placeholder="Semister" class="form-control" />
				</div> <!-- /field -->
                                <div class="field">
					<label for="lastname">Hostel.</label>	
					<input type="text" name="space_no"  value="" placeholder="e.g Mt Kenya" class="form-control" />
				</div> <!-- /field -->
				<div class="field">
					<label for="firstname">Room No.</label>
					<input type="text" name="room_no"  value="" placeholder="e.g MD720" class="form-control" />
				</div> <!-- /field -->
				
				
                                
                                <div class="field">
					<label for="lastname">Balance.</label>	
					<input type="text" name="amount"  value="" placeholder="balance" class="form-control" />
				</div> <!-- /field -->
                                
                                <br>
                                <div>
                                    <input type="submit" class="login-action btn btn-primary" Value="Add Data"/>
                                </div>
                               </form>
                            </div> <!-- /widget-content -->

                        </div> <!-- /widget -->
                        
                         
                        </div> <!-- /widget -->
                        <div class="col-md-8">
                          
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
                                           <th>Hostel</th>
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

        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="./js/libs/jquery-1.9.1.min.js"></script>
        <script src="./js/libs/jquery-ui-1.10.0.custom.min.js"></script>
        <script src="./js/libs/bootstrap.min.js"></script>

    </body>
</html>
