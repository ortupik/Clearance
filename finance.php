<?php
  require_once __DIR__ . '/db/core.php';
  require_once __DIR__ . '/db/db_connect.php';

  $user_id = $_SESSION['user_id'];
  if(!isset($_SESSION['user_id'])){
      $user_id = $_SESSION['user_id'];
      header("location:login.php");
  }
  
  $balance  = 0;
  $hasBalance = "You have cleared balance !!";
    
  
  $db = new DB_CONNECT();
  
  $finalArray = array();
  
  $total_amount = 0;
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
                             <li class="active">
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
                                 <a href="./damages.php">
                                    <i class="icon-anchor"></i>
                                    <span>Damages</span>
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
                    <div class="col-md-12">
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
                                            <div class="label label-warning">
                                               <?php echo $hasBalance ?>;;
                                            </div>
                                            </td>
                                        </tr>
                                        <tr><td><h2>Balance</h2></td><td><span id="Main_lblBal"><h2 class="balance"><?php echo $balance ?></h2></span></td><td><div class="field">
                                        <label for="username">Enter Check ref number to Pay:</label>
                                                <input type="text" id="ref_no" name="reg_no" value="" placeholder="Check ref number" class="form-control input-md username-field" />
                                                <br><button class="login-action btn btn-primary" id="pay_fees">Pay</button>
                                            </div> <!-- /field -->
                                        </td></tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                                
                            </div> <!-- /widget-content -->
                    </div>
                    <div class="col-md-12">	
                        <div class="widget widget-nopad stacked">
						
                            <div class="widget-header">
                                    <i class="icon-book"></i>
                                    <h3>Financial Information</h3>
                            </div> <!-- /widget-header -->
			   <div class="widget-content">
                                <table cellspacing="1" cellpadding="2" id="Main_gvFees" style="color:#333333;background-color:#E6D9BD;font-size:X-Small;width:100%;">
		<tr style="color:White;background-color:#507CD1;font-weight:bold;">
			<th scope="col"><a href="javascript:__doPostBack(&#39;ctl00$Main$gvFees&#39;,&#39;Sort$Posting Date&#39;)" style="color:White;">Date</a></th><th align="left" scope="col"><a href="javascript:__doPostBack(&#39;ctl00$Main$gvFees&#39;,&#39;Sort$Document No_&#39;)" style="color:White;">Ref #</a></th><th align="left" scope="col"><a href="javascript:__doPostBack(&#39;ctl00$Main$gvFees&#39;,&#39;Sort$Description&#39;)" style="color:White;">Description</a></th><th align="right" scope="col"><a href="javascript:__doPostBack(&#39;ctl00$Main$gvFees&#39;,&#39;Sort$Debit Amount&#39;)" style="color:White;">Debit Amount</a></th><th align="right" scope="col"><a href="javascript:__doPostBack(&#39;ctl00$Main$gvFees&#39;,&#39;Sort$Credit Amount&#39;)" style="color:White;">Credit Amount</a></th>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        01/09/2014
                     </td><td style="width:120px;">
                         TR-422845
                     </td><td>
                         Fees for C026-Y1S1
                     </td><td align="right" style="width:110px;">
                         8,000.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        01/09/2014
                     </td><td style="width:120px;">
                         TR-422846
                     </td><td>
                         Activity Fee
                     </td><td align="right" style="width:110px;">
                         1,160.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        01/09/2014
                     </td><td style="width:120px;">
                         TR-422847
                     </td><td>
                         Computer Fee
                     </td><td align="right" style="width:110px;">
                         1,740.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        01/09/2014
                     </td><td style="width:120px;">
                         TR-422848
                     </td><td>
                         Examination
                     </td><td align="right" style="width:110px;">
                         2,953.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        01/09/2014
                     </td><td style="width:120px;">
                         TR-422849
                     </td><td>
                         Library Fee
                     </td><td align="right" style="width:110px;">
                         580.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        01/09/2014
                     </td><td style="width:120px;">
                         TR-422850
                     </td><td>
                         Medical Fee
                     </td><td align="right" style="width:110px;">
                         1,737.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        01/09/2014
                     </td><td style="width:120px;">
                         TR-422851
                     </td><td>
                         Registration
                     </td><td align="right" style="width:110px;">
                         580.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        01/09/2014
                     </td><td style="width:120px;">
                         TR-422852
                     </td><td>
                         Student ID
                     </td><td align="right" style="width:110px;">
                         233.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        01/09/2014
                     </td><td style="width:120px;">
                         TR-422853
                     </td><td>
                         Student Union
                     </td><td align="right" style="width:110px;">
                         300.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        01/09/2014
                     </td><td style="width:120px;">
                         REC-0109611
                     </td><td>
                         ANTONY NGANGA WANJIRU
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         17,283.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        09/10/2014
                     </td><td style="width:120px;">
                         CHARGES
                     </td><td>
                         Damages and fines
                     </td><td align="right" style="width:110px;">
                         300.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        10/10/2014
                     </td><td style="width:120px;">
                         REC-0114267
                     </td><td>
                         ANTONY NGANGA WANJIRU
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         300.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        20/11/2014
                     </td><td style="width:120px;">
                         CHARGES
                     </td><td>
                         Damages and fines
                     </td><td align="right" style="width:110px;">
                         550.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        25/11/2014
                     </td><td style="width:120px;">
                         REC-0121421
                     </td><td>
                        ANTONY NGANGA WANJIRU
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         550.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        20/02/2015
                     </td><td style="width:120px;">
                         TR-474156
                     </td><td>
                         Fees for C026-Y1S2 SEM2 14/15
                     </td><td align="right" style="width:110px;">
                         8,000.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        20/02/2015
                     </td><td style="width:120px;">
                         TR-474157
                     </td><td>
                         Activity Fee SEM2 14/15
                     </td><td align="right" style="width:110px;">
                         1,160.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        20/02/2015
                     </td><td style="width:120px;">
                         TR-474158
                     </td><td>
                         Computer Fee SEM2 14/15
                     </td><td align="right" style="width:110px;">
                         1,740.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        20/02/2015
                     </td><td style="width:120px;">
                         TR-474159
                     </td><td>
                         Examination SEM2 14/15
                     </td><td align="right" style="width:110px;">
                         2,953.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        20/02/2015
                     </td><td style="width:120px;">
                         TR-474160
                     </td><td>
                         Library Fee SEM2 14/15
                     </td><td align="right" style="width:110px;">
                         580.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        20/02/2015
                     </td><td style="width:120px;">
                         TR-474161
                     </td><td>
                         Medical Fee SEM2 14/15
                     </td><td align="right" style="width:110px;">
                         1,737.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        18/05/2015
                     </td><td style="width:120px;">
                         REC-0135665
                     </td><td>
                        ANTONY NGANGA WANJIRU
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         16,300.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        02/06/2015
                     </td><td style="width:120px;">
                         TR-506847
                     </td><td>
                         Fees for C026-Y2S1 SEM1 15/16
                     </td><td align="right" style="width:110px;">
                         8,000.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        02/06/2015
                     </td><td style="width:120px;">
                         TR-506848
                     </td><td>
                         Activity Fee SEM1 15/16
                     </td><td align="right" style="width:110px;">
                         1,160.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        02/06/2015
                     </td><td style="width:120px;">
                         TR-506849
                     </td><td>
                         Computer Fee SEM1 15/16
                     </td><td align="right" style="width:110px;">
                         1,740.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        02/06/2015
                     </td><td style="width:120px;">
                         TR-506850
                     </td><td>
                         Examination SEM1 15/16
                     </td><td align="right" style="width:110px;">
                         2,953.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        02/06/2015
                     </td><td style="width:120px;">
                         TR-506851
                     </td><td>
                         Library Fee SEM1 15/16
                     </td><td align="right" style="width:110px;">
                         580.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        02/06/2015
                     </td><td style="width:120px;">
                         TR-506852
                     </td><td>
                         Medical Fee SEM1 15/16
                     </td><td align="right" style="width:110px;">
                         1,737.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        02/06/2015
                     </td><td style="width:120px;">
                         TR-506853
                     </td><td>
                         Registration SEM1 15/16
                     </td><td align="right" style="width:110px;">
                         580.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        02/06/2015
                     </td><td style="width:120px;">
                         TR-506854
                     </td><td>
                         Student Union SEM1 15/16
                     </td><td align="right" style="width:110px;">
                         300.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        24/08/2015
                     </td><td style="width:120px;">
                         REC-0144271
                     </td><td>
                         Bank Slip - 
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         16,800.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        01/09/2015
                     </td><td style="width:120px;">
                         REC-0146462
                     </td><td>
                         Bank Slip - 
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         120.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        14/09/2015
                     </td><td style="width:120px;">
                         TR-551221
                     </td><td>
                         Fees for C026-Y2S2 SEM2 15/16
                     </td><td align="right" style="width:110px;">
                         8,000.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        14/09/2015
                     </td><td style="width:120px;">
                         TR-551222
                     </td><td>
                         Activity Fee SEM2 15/16
                     </td><td align="right" style="width:110px;">
                         1,160.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        14/09/2015
                     </td><td style="width:120px;">
                         TR-551223
                     </td><td>
                         Attachment Fee SEM2 15/16
                     </td><td align="right" style="width:110px;">
                         2,895.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        14/09/2015
                     </td><td style="width:120px;">
                         TR-551224
                     </td><td>
                         Computer Fee SEM2 15/16
                     </td><td align="right" style="width:110px;">
                         1,740.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        14/09/2015
                     </td><td style="width:120px;">
                         TR-551225
                     </td><td>
                         Examination SEM2 15/16
                     </td><td align="right" style="width:110px;">
                         2,952.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        14/09/2015
                     </td><td style="width:120px;">
                         TR-551226
                     </td><td>
                         Library Fee SEM2 15/16
                     </td><td align="right" style="width:110px;">
                         580.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        14/09/2015
                     </td><td style="width:120px;">
                         TR-551227
                     </td><td>
                         Medical Fee SEM2 15/16
                     </td><td align="right" style="width:110px;">
                         1,737.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        21/09/2015
                     </td><td style="width:120px;">
                         REC-0148412
                     </td><td>
                         Bank Slip - 055BPCH152640116
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         1,400.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        21/09/2015
                     </td><td style="width:120px;">
                         TR-577583
                     </td><td>
                         supplimentary
                     </td><td align="right" style="width:110px;">
                         800.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        21/09/2015
                     </td><td style="width:120px;">
                         TR-577583
                     </td><td>
                         supplimentary
                     </td><td align="right" style="width:110px;">
                         -800.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        21/09/2015
                     </td><td style="width:120px;">
                         TR-577584
                     </td><td>
                         supplimentary
                     </td><td align="right" style="width:110px;">
                         1,600.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        22/09/2015
                     </td><td style="width:120px;">
                         REC-0148507
                     </td><td>
                         Bank Slip - 
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         1,400.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        22/09/2015
                     </td><td style="width:120px;">
                         REC-0148507
                     </td><td>
                         Bank Slip - 
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         -1,400.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        22/09/2015
                     </td><td style="width:120px;">
                         REC-0148508
                     </td><td>
                         Bank Slip - 
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         200.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        06/11/2015
                     </td><td style="width:120px;">
                         REC-0153255
                     </td><td>
                         Bank Slip - 
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         300.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        10/11/2015
                     </td><td style="width:120px;">
                         TR-584751
                     </td><td>
                         Student ID
                     </td><td align="right" style="width:110px;">
                         233.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        14/12/2015
                     </td><td style="width:120px;">
                         REC-0158360
                     </td><td>
                         Bank Slip - 46/291/34
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         19,600.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        08/02/2016
                     </td><td style="width:120px;">
                         TCRE-0065726
                     </td><td>
                         HELB SEM2 2015/2016
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         4,000.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        09/02/2016
                     </td><td style="width:120px;">
                         TCRE-0065726
                     </td><td>
                         HELB SEM 1 15/16
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         4,000.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        07/03/2016
                     </td><td style="width:120px;">
                         TR-603674
                     </td><td>
                         supplimentary
                     </td><td align="right" style="width:110px;">
                         1,600.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        04/05/2016
                     </td><td style="width:120px;">
                         TR-625978
                     </td><td>
                         Fees for C026-Y3S1 SEM1 16/17
                     </td><td align="right" style="width:110px;">
                         8,000.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        04/05/2016
                     </td><td style="width:120px;">
                         TR-625979
                     </td><td>
                         Activity Fee SEM1 16/17
                     </td><td align="right" style="width:110px;">
                         1,160.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        04/05/2016
                     </td><td style="width:120px;">
                         TR-625980
                     </td><td>
                         Computer Fee SEM1 16/17
                     </td><td align="right" style="width:110px;">
                         1,740.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        04/05/2016
                     </td><td style="width:120px;">
                         TR-625981
                     </td><td>
                         Examination SEM1 16/17
                     </td><td align="right" style="width:110px;">
                         2,953.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        04/05/2016
                     </td><td style="width:120px;">
                         TR-625982
                     </td><td>
                         Library Fee SEM1 16/17
                     </td><td align="right" style="width:110px;">
                         580.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        04/05/2016
                     </td><td style="width:120px;">
                         TR-625983
                     </td><td>
                         Medical Fee SEM1 16/17
                     </td><td align="right" style="width:110px;">
                         1,737.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        04/05/2016
                     </td><td style="width:120px;">
                         TR-625984
                     </td><td>
                         Registration SEM1 16/17
                     </td><td align="right" style="width:110px;">
                         580.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        04/05/2016
                     </td><td style="width:120px;">
                         TR-625985
                     </td><td>
                         Student Union SEM1 16/17
                     </td><td align="right" style="width:110px;">
                         300.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        02/06/2016
                     </td><td style="width:120px;">
                         REC-0170095
                     </td><td>
                         Bank Slip - 055BPCH161540118
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         240.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        03/06/2016
                     </td><td style="width:120px;">
                         TR-647706
                     </td><td>
                         Student ID
                     </td><td align="right" style="width:110px;">
                         233.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        21/07/2016
                     </td><td style="width:120px;">
                         TCRE-0065726
                     </td><td>
                         Helb Tuition Sem1 2016/2017
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         4,000.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        04/08/2016
                     </td><td style="width:120px;">
                         REC-0176156
                     </td><td>
                         Bank Slip - 
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         6,100.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        08/09/2016
                     </td><td style="width:120px;">
                         TR-671931
                     </td><td>
                         Fees for C026-Y3S2 SEM2 16/17
                     </td><td align="right" style="width:110px;">
                         8,000.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        08/09/2016
                     </td><td style="width:120px;">
                         TR-671932
                     </td><td>
                         Activity Fee SEM2 16/17
                     </td><td align="right" style="width:110px;">
                         1,160.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        08/09/2016
                     </td><td style="width:120px;">
                         TR-671933
                     </td><td>
                         Attachment Fee SEM2 16/17
                     </td><td align="right" style="width:110px;">
                         2,895.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        08/09/2016
                     </td><td style="width:120px;">
                         TR-671934
                     </td><td>
                         Computer Fee SEM2 16/17
                     </td><td align="right" style="width:110px;">
                         1,740.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        08/09/2016
                     </td><td style="width:120px;">
                         TR-671935
                     </td><td>
                         Examination SEM2 16/17
                     </td><td align="right" style="width:110px;">
                         2,952.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        08/09/2016
                     </td><td style="width:120px;">
                         TR-671936
                     </td><td>
                         Library Fee SEM2 16/17
                     </td><td align="right" style="width:110px;">
                         580.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        08/09/2016
                     </td><td style="width:120px;">
                         TR-671937
                     </td><td>
                         Medical Fee SEM2 16/17
                     </td><td align="right" style="width:110px;">
                         1,737.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        17/11/2016
                     </td><td style="width:120px;">
                         REC-0183474
                     </td><td>
                         Bank Slip - 
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         11,000.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        06/12/2016
                     </td><td style="width:120px;">
                         TCRE-0065726
                     </td><td>
                         Helb Tuition Sem2 2016/2017
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         4,000.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        08/12/2016
                     </td><td style="width:120px;">
                         REC-0188107
                     </td><td>
                         Bank Slip - 77/236/61
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         4,000.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        08/12/2016
                     </td><td style="width:120px;">
                         REC-0188156
                     </td><td>
                         Bank Slip - N14876110076
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         4.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        08/12/2016
                     </td><td style="width:120px;">
                         REC-0188156
                     </td><td>
                         Bank Slip - N14876110076
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         -4.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        08/12/2016
                     </td><td style="width:120px;">
                         REC-0189326
                     </td><td>
                         Bank Slip - N14876110076
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         10.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        07/03/2017
                     </td><td style="width:120px;">
                         TR-724222
                     </td><td>
                         Supplimentary
                     </td><td align="right" style="width:110px;">
                         800.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        28/03/2017
                     </td><td style="width:120px;">
                         REC-0193899
                     </td><td>
                         Bank Slip - 
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         800.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        02/05/2017
                     </td><td style="width:120px;">
                         TR-739778
                     </td><td>
                         Fees for C026-Y4S1 SEM1 17/18
                     </td><td align="right" style="width:110px;">
                         8,000.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        02/05/2017
                     </td><td style="width:120px;">
                         TR-739779
                     </td><td>
                         Activity Fee SEM1 17/18
                     </td><td align="right" style="width:110px;">
                         1,160.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        02/05/2017
                     </td><td style="width:120px;">
                         TR-739780
                     </td><td>
                         Computer Fee SEM1 17/18
                     </td><td align="right" style="width:110px;">
                         1,740.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        02/05/2017
                     </td><td style="width:120px;">
                         TR-739781
                     </td><td>
                         Examination SEM1 17/18
                     </td><td align="right" style="width:110px;">
                         2,953.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        02/05/2017
                     </td><td style="width:120px;">
                         TR-739782
                     </td><td>
                         Library Fee SEM1 17/18
                     </td><td align="right" style="width:110px;">
                         580.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        02/05/2017
                     </td><td style="width:120px;">
                         TR-739783
                     </td><td>
                         Medical Fee SEM1 17/18
                     </td><td align="right" style="width:110px;">
                         1,737.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        02/05/2017
                     </td><td style="width:120px;">
                         TR-739784
                     </td><td>
                         Registration SEM1 17/18
                     </td><td align="right" style="width:110px;">
                         580.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        02/05/2017
                     </td><td style="width:120px;">
                         TR-739785
                     </td><td>
                         Student Union SEM1 17/18
                     </td><td align="right" style="width:110px;">
                         300.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        17/08/2017
                     </td><td style="width:120px;">
                         REC-0206125
                     </td><td>
                         Bank Slip - 
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         13,050.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        18/08/2017
                     </td><td style="width:120px;">
                         TCRE-0065726
                     </td><td>
                         Helb Tuition Sem1 2017/2018
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td><td align="right" style="width:110px;">
                         4,000.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        11/09/2017
                     </td><td style="width:120px;">
                         TR-807402
                     </td><td>
                         Fees for C026-Y4S2 SEM2 17/18
                     </td><td align="right" style="width:110px;">
                         8,000.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        11/09/2017
                     </td><td style="width:120px;">
                         TR-807403
                     </td><td>
                         Activity Fee SEM2 17/18
                     </td><td align="right" style="width:110px;">
                         1,160.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        11/09/2017
                     </td><td style="width:120px;">
                         TR-807404
                     </td><td>
                         Computer Fee SEM2 17/18
                     </td><td align="right" style="width:110px;">
                         1,740.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        11/09/2017
                     </td><td style="width:120px;">
                         TR-807405
                     </td><td>
                         Examination SEM2 17/18
                     </td><td align="right" style="width:110px;">
                         2,952.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:#EFF3FB;">
			<td align="center" style="width:110px;">
                        11/09/2017
                     </td><td style="width:120px;">
                         TR-807406
                     </td><td>
                         Library Fee SEM2 17/18
                     </td><td align="right" style="width:110px;">
                         580.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr onmouseover="this.originalstyle=this.style.backgroundColor;this.style.backgroundColor=&#39;#EEFFAA&#39;" onmouseout="this.style.backgroundColor=this.originalstyle;" style="background-color:White;">
			<td align="center" style="width:110px;">
                        11/09/2017
                     </td><td style="width:120px;">
                         TR-807407
                     </td><td>
                         Medical Fee SEM2 17/18
                     </td><td align="right" style="width:110px;">
                         1,737.00
                     </td><td align="right" style="width:110px;">
                         0.00
                     </td>
		</tr><tr style="color:White;background-color:#507CD1;font-weight:bold;">
			<td>&nbsp;</td><td>&nbsp;</td><td align="right" class="balance"><?php echo 'Balance: '. $balance ?>;</td><td align="right">144,216.00</td><td align="right">128,053.00</td>
		</tr>
	</table>
                            </div>
			
			</div> <!-- /widget -->	
	              
                    </div>
                   
                    
                       

                </div> <!-- /row -->

            </div> <!-- /container -->

       
        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="js/libs/jquery-3.2.1.min.js"></script>
        <script src="./js/libs/bootstrap.min.js"></script>

        <script src="./js/finance_payment.js"></script>

    </body>
</html>
