
<?php
  require_once __DIR__ . '/db/core.php';
  require_once __DIR__ . '/db/db_connect.php';

  $user_id  = 1;
  if(!isset($_SESSION['admin_user_id'])){
    //  $user_id = $_SESSION['admin_user_id'];
     // header("location:admin_login.php");
  }
  
  
  $db = new DB_CONNECT();
  
  $finalArray = array();
  
  $total_amount = 0;

   $query = mysqli_query($db->connect(), "Select * FROM user,user_details WHERE  user.`user_id` = user_details.`user_id`") or die(mysqli_error($db->connect()));
    if ($query) {
        $rows = mysqli_num_rows($query);
        $count = 0;
        if ($rows > 0) {
            while ($row = mysqli_fetch_array($query)) {
                

                $finalArray[$count] = $row;
                $count++;
            }
        }
    }
	
	//echo json_encode($finalArray);
    
    if(isset($_POST['names']) && isset($_POST['reg_no']) &&  isset($_POST['id_no']) && isset($_POST['gender'])  && isset($_POST['id_no'])){
        $names= $_POST['names'];
        $reg_no = $_POST['reg_no'];
        $id_no = $_POST['id_no'];
        $gender = $_POST['gender'];
		$dob = $_POST['dob'];
     
     $query = mysqli_query($db->connect(), "INSERT INTO `user` (`reg_no`,`password`,`type`) values('$reg_no','pass123','student')")or die(mysqli_error($db->connect()));
     $query2 = mysqli_query($db->connect(), "INSERT INTO `user_details` (`names`,`id_no`,`gender`,`dob`) values('$names','$id_no','$gender','$dob')")or die(mysqli_error($db->connect()));
 
	   if ($query) {
             echo '<script>alert("Successfully added Student !!");</script>';
             header("location:admin.php");
        } else {
            echo '<script>alert("Failed to add check fields and try again!!")</script>';
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
                    <a class="navbar-brand" href="./index.php">Admin</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav navbar-right">
                       

                        <li class="dropdown">

                            <a href="javscript:;" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-user"></i> 
                                Admin
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
                                    <h3>Admin</h3>
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
                                <h3>All Students:</h3>
                            </div> <!-- /widget-header -->
                            <div class="widget-content " style="padding: 30px;">
                                <form method="POST" action="admin.php">
				<div class="field">
					<label for="firstname">Student Reg No.:</label>
					<input type="text" name="reg_no"  value="" placeholder="Reg No" class="form-control" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="lastname">Names:</label>	
					<input type="text" name="names"  value=""  class="form-control" />
				</div> <!-- /field -->
                                <div class="field">
					<label for="firstname">ID NO.:</label>
					<input type="text" name="id_no"  value="" class="form-control" />
				</div> <!-- /field -->
				<div class="field">
					<label for="firstname">Gender.:</label>
					<input type="text" name="gender"  value=""  class="form-control" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="lastname">DOB:</label>	
					<input type="text" name="dob"  value=""  class="form-control" />
				</div> <!-- /field -->
                                
                                <br>
                                <div>
                                    <input type="submit" class="login-action btn btn-primary" Value="Add Student"/>
                                </div>
                               </form>
                            </div> <!-- /widget-content -->

                        </div> <!-- /widget -->
                        
                         
                        </div> <!-- /widget -->
                        <div class="col-md-8">
                          
                             <div class="widget stacked widget-table  action-table">
                            <div class="widget-header">
                                <i class="icon-book"></i>
                                <h3>All Students</h3>
                            </div> <!-- /widget-header -->
                            <div class="widget-content">
                                <table class="table table-bordered table-condensed">
                                    <thead>
                                       <thead>
                                        <tr>
                                        <th>#</th>   
                                        <th>Student Reg No.</th>
                                         <th>Student Name</th>
                                        <th>ID</th>
                                        <th>Gender</th>
                                        <th>DOB</th>
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
										//echo json_encode($finalArray);
                                    for ($j = 0; $j < sizeof($finalArray); $j++){
                                        $count++;
                                        ?>
                                        <tr class="">
                                           <td class="col col-lg-1 "> <?php echo $count; ?></td>
                                             <td class="col col-lg-2 "><?php echo $finalArray[$j]["reg_no"]?></td>
                                           <td class="col col-lg-2 "><?php echo $finalArray[$j]["names"]?></td>
                                            <td class="col col-lg-4 "><?php echo $finalArray[$j]["id_no"]?></td>
                                           <td class="col col-lg-1 "><?php echo $finalArray[$j]["gender"]?></td>
                                           <td class="col col-lg-1 "><?php echo $finalArray[$j]["dob"]?></td>
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
