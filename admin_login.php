<?php

 require_once __DIR__ . '/db/core.php';
require_once __DIR__ . '/db/db_connect.php';

$db = new DB_CONNECT();
$response = array();

if (isset($_POST['username']) && isset($_POST['password'])) {
    
    $username = $_POST['username'];
    $password = $_POST['password'];
   
       
    if (!empty($username) && !empty($password)) {
        
        $queryresult = mysqli_query($db->connect(), "SELECT * FROM `admin` WHERE `username`='$username' AND `password`='$password' ");
        
        if ($queryresult) {
            
            if ( mysqli_num_rows($queryresult) <=0) {
                $response['message'] = 'Invalid login credentials';
                $response['success'] = 0;
                
                echo json_encode($response["message"]);
               // header("location:index.php");           
            } else  {

                $row = mysqli_fetch_array($queryresult);
                $_SESSION["admin_user_id"] = $row['id'];
                
                echo $role = $row["role"];
                if($role == "caretaker"){
                    header("location:hostel_manager.php");
                }else if($role == "librarian"){
                     header("location:librarian.php");
                }else if($role == "dean"){
                     header("location:dean.php");
                }else if($role == "registrar"){
                     header("location:registrar.php");
                }else if($role == "admin"){
                     header("location:admin.php");
                }
            
          }
            
        } else {
             $response['message'] = "Database Error in Login";
            $response['success'] = 0;
            echo json_encode($response['message']);
        
        }
    }else{
        $response['success'] = 0;
        $response['message'] = "Some Fields Empty !";
         //  echo json_encode($response['message']);
    }
}else{
     $response['success'] = 0;
      $response['message'] = "Some Fields NOT SET !";
   // echo json_encode($response['message']);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Dekut Clearance</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes"> 

        <link href="./css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="./css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

        <link href="./css/font-awesome.min.css" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">

        <link href="./css/ui-lightness/jquery-ui-1.10.0.custom.min.css" rel="stylesheet">    

        <link href="./css/base-admin-3.css" rel="stylesheet">
        <link href="./css/base-admin-3-responsive.css" rel="stylesheet">

        <link href="./css/pages/signin.css" rel="stylesheet" type="text/css">

        <link href="./css/custom.css" rel="stylesheet">

    </head>

    <body>

        <nav class="navbar navbar-inverse" role="navigation">

            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="./index.php">Dekut Clearance</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav navbar-right">
                       
                        <li class="">

                            <a href="index.php">
                                <i class="icon-chevron-left"></i>&nbsp;&nbsp; 
                                Back to Homepage
                            </a>

                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div> <!-- /.container -->
        </nav>



        <div class="account-container stacked">

            <div class="content clearfix">

                <form action="admin_login.php" method="POST">

                    <h1> Admin Sign In</h1>		

                    <div class="login-fields">

                        <p>Sign in using your registered account:</p>

                        <div class="field">
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" value="" placeholder="username" class="form-control input-lg username-field" />
                        </div> <!-- /field -->

                        <div class="field">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" value="" placeholder="Password" class="form-control input-lg password-field"/>
                        </div> <!-- /password -->

                    </div> <!-- /login-fields -->

                    <div class="login-actions">

                        <span class="login-checkbox">
                            <input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
                            <label class="choice" for="Field">Keep me signed in</label>
                        </span>

                        <button class="login-action btn btn-primary">Sign In</button>

                    </div> <!-- .actions -->



                </form>

            </div> <!-- /content -->

        </div> <!-- /account-container -->


        <!-- Text Under Box -->
        <div class="login-extra">
            Remind <a href="#">Password</a>
        </div> <!-- /login-extra -->



        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="./js/libs/jquery-1.9.1.min.js"></script>
        <script src="./js/libs/jquery-ui-1.10.0.custom.min.js"></script>
        <script src="./js/libs/bootstrap.min.js"></script>

        <script src="./js/Application.js"></script>

        <script src="./js/demo/signin.js"></script>

    </body>
</html>
