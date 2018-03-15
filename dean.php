
<?php
  require_once __DIR__ . '/db/core.php';
  require_once __DIR__ . '/db/db_connect.php';

  if(!isset($_SESSION['admin_user_id'])){
    //  $user_id = $_SESSION['admin_user_id'];
     // header("location:admin_login.php");
  }
  
  
  $db = new DB_CONNECT();
  
  $finalArray = array();
  
  $total_amount = 0;
  
  

   $query = mysqli_query($db->connect(), "Select * FROM `damages`,`user` WHERE `damages`.`user_id` = `user`.`user_id`   AND `type` = 'student' AND `amount` > 0 GROUP BY `id`") or die(mysqli_error($db->connect()));
    if ($query) {
        $rows = mysqli_num_rows($query);
        $count = 0;
        if ($rows > 0) {
            while ($row = mysqli_fetch_array($query)) {
                $description = $row['description'];
                $item = $row['item'];
                $amount = $row['amount'];
                $reg_no = $row['reg_no'];
                

                $dataArray = array();
                $dataArray['item'] = $item;
                $dataArray['amount'] = $amount;
                $dataArray['description'] = $description;
                 $dataArray['reg_no'] = $reg_no;
               $dataArray['time'] =$row['time'];
                
                $finalArray[$count] = $dataArray;
                $count++;
            }
        }
    }
    
   
    if(isset($_POST['description']) && isset($_POST['regno']) && isset($_POST['item']) && isset($_POST['amount_due'])){
        $description = $_POST['description'];
        $item = $_POST['item'];
        $amount_due = $_POST['amount_due'];
        
          $reg_no = $_POST['regno'];
         $user_id = "";
    
         
          
    $query = mysqli_query($db->connect(), "Select * FROM user WHERE `reg_no` = '$reg_no'") or die(mysqli_error($db->connect()));
     if ($query) {
        $rows = mysqli_num_rows($query);
        if ($rows > 0) {
           $row = mysqli_fetch_array($query);
            $user_id = $row['user_id'];            
    
     
     $query2 = mysqli_query($db->connect(), "INSERT INTO `damages` (`user_id`,`item`,`description`,`amount`) values($user_id,'$item','$description',$amount_due)")or die(mysqli_error($db->connect()));
        if ($query2) {
             echo '<script>alert("Successfully added Damages !!");</script>';
             header("location:dean.php");
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
                                Dean of Student
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
                                    <h3>Dean of Students</h3>
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
                                <i class="icon-book"></i>
                                <h3>Record Damages:</h3>
                            </div> <!-- /widget-header -->
                            <div class="widget-content " style="padding: 30px;">
                                <form method="POST" action="dean.php">
				<div class="field">
					<label for="firstname">Student Reg No.:</label>
					<input type="text" name="regno"  value="" placeholder="Reg No" class="form-control" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="lastname">Item Name:</label>	
					<input type="text" name="item"  value="" placeholder="e.g Window Pane" class="form-control" />
				</div> <!-- /field -->
                                <div class="field">
					<label for="firstname">Description.:</label>
                                        <textarea type="text" name="description"  value=""  class="form-control" ></textarea>
				</div> <!-- /field -->
				
				
				<div class="field">
					<label for="lastname">Amount Due:</label>	
					<input type="text" name="amount_due"  value="" placeholder="Penalty" class="form-control" />
				</div> <!-- /field -->
                                
                                
                                
                                <br>
                                <div>
                                    <input type="submit" class="login-action btn btn-primary" Value="Add Item"/>
                                </div>
                               </form>
                            </div> <!-- /widget-content -->

                        </div> <!-- /widget -->
                        
                         
                        </div> <!-- /widget -->
                        <div class="col-md-8">
                          
                             <div class="widget stacked widget-table  action-table">
                            <div class="widget-header">
                                <i class="icon-book"></i>
                                <h3>Damages by Students</h3>
                            </div> <!-- /widget-header -->
                            <div class="widget-content">
                                <table class="table table-bordered table-condensed">
                                    <thead>
                                       <thead>
                                        <tr>
                                        <th>#</th>   
                                        <th>Student Reg No.</th>
                                         <th>Item Name</th>
                                        <th>Description</th>
                                        <th>Amount Due</th>
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
                                             <td class="col col-lg-2 "><?php echo $finalArray[$j]["reg_no"]?></td>
                                           <td class="col col-lg-2 "><?php echo $finalArray[$j]["item"]?></td>
                                            <td class="col col-lg-4 "><?php echo $finalArray[$j]["description"]?></td>
                                           <td class="col col-lg-1 "><?php echo $finalArray[$j]["amount"]?></td>
                                          <td class="col col-lg-1 "><?php echo $finalArray[$j]["time"]?></td>

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
