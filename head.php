<?php
/**
 * @author Akintola Oluwaseun
 * @copyright 2017
 */


ob_start();
session_start();
if(!isset($_SESSION['user'])) {
    ?>
    <script type="text/javascript">
        document.location.href="index.php?msg=Thank you ! You are now logged out!";
    </script>

    <?php
    die();
} else {

    ?>


    <?php

    ?>

    <?php
    require_once 'dbconnect.php';
    require_once 'functions.php';
// select loggedin users detail
    $ses = $_SESSION['user'];

    $ut = $_SESSION['userType'];
    $res = mysqli_query($dbc, "SELECT * FROM user_table WHERE email='$ses'");
    $userRow = mysqli_fetch_array($res);
    $myid = $userRow['myid'];
    $emai = $userRow['email'];
    $my_userName = $userRow['userName'];
    $my_firstName = $userRow['firstName'];
    $my_lastName = $userRow['lastName'];
    $my_occupation = $userRow['occupation'];
    $my_address = $userRow['address'];
    $my_city = $userRow['city'];
    $my_country = $userRow['country'];
    $my_zipcode = $userRow['zipcode'];
    $my_state = $userRow['state'];
    $my_phoneNo = $userRow['phoneNo'];
    $my_bankName = $userRow['bankName'];
    $my_accNo = $userRow['accNo'];
    $my_accName = $userRow['accName'];
    $my_urltoimg = $userRow['urltoimg'];
    $my_dob = $userRow['dob'];
    $my_dor = $userRow['added'];
    $my_marital = $userRow['marital'];
    $my_gender = $userRow['gender'];
    $my_status = $userRow['status'];
    $name = $userRow['lastName'] . ' ' . $userRow['firstName'];

// to get this week's Total Bonus

    $query2 = "SELECT * FROM `income_history` WHERE WEEKOFYEAR(date)=WEEKOFYEAR(NOW()) AND `receiver_id` = '$myid'";
    $res2 = mysqli_query($dbc, $query2);
    $this_i = 0;
    $this_total = 0;
    while ($row = mysqli_fetch_array($res2)) {
        $this_total = $this_total + $row['Amount'];


        $this_i++;
    }


    // to get last week's Total Bonus
    $query2 = "SELECT * FROM `income_history` WHERE WEEKOFYEAR(date)=WEEKOFYEAR(NOW())-1 AND `receiver_id` = '$myid'";
    $res2 = mysqli_query($dbc, $query2);
    $last_i = 0;
    $last_total = 0;
    while ($row = mysqli_fetch_array($res2)) {
        $last_total = $last_total + $row['Amount'];


        $last_i++;
    }
    //to get  Total Matrix Bonus Bonus
    $query2 = "SELECT * FROM income_history WHERE receiver_id='$myid' AND `remark`='Matrix bonus'";
    $res2 = mysqli_query($dbc, $query2);
    $Matrix_i = 0;
    $Matrix_total = 0;
    while ($row = mysqli_fetch_array($res2)) {
        $Matrix_total = $Matrix_total + $row['Amount'];


        $Matrix_i++;
    }
    // to get Matching  Bonus
    $query2 = "SELECT * FROM income_history WHERE receiver_id='$myid' AND `remark`='Matching Income'";
    $res2 = mysqli_query($dbc, $query2);
    $Matching_i = 0;
    $Matching_total = 0;
    while ($row = mysqli_fetch_array($res2)) {
        $Matching_total = $Matching_total + $row['Amount'];


        $Matching_i++;
    }


    // to get all referral  Bonus
    $query2 = "SELECT * FROM income_history WHERE receiver_id='$myid' AND `remark`='Matching Income' OR receiver_id='$myid' AND `remark`='Matrix bonus' ";
    $res2 = mysqli_query($dbc, $query2);
    $referral_i = 0;
    $referral_total = 0;
    while ($row = mysqli_fetch_array($res2)) {
        $referral_total = $referral_total + $row['Amount'];


        $referral_i++;
    }


    $query2 = "SELECT * FROM `user_rank` WHERE `superior_id` = '$myid'";
    $res2 = mysqli_query($dbc, $query2);
    $row2 = mysqli_fetch_array($res2);
//$number = mysqli_result($res2);
    $number = count($row2['id']);
    // exit($number);
    
    $query = "SELECT * FROM `user_rank` WHERE `myid` = '$myid'";
    $res = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($res);

    $my_balance = $row[balance];
    $my_stage = $row[stage];
    $my_level = $row[level];

    $desc1 = $row[desc_1];
    $desc2 = $row[desc_2];
    $desc3 = $row[desc_3];
    $desc4 = $row[desc_4];
    $desc5 = $row[desc_5];
    $desc6 = $row[desc_6];
    $desc = array($desc1, $desc2, $desc3, $desc4, $desc5, $desc6);


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc1'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $desc1 = $user_row[email] . "<br> " . $user_row[firstName] . " " . $user_row[lastName] . "<br> " . $user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc2'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $desc2 = $user_row[email] . " <br>" . $user_row[firstName] . " " . $user_row[lastName] . "<br> " . $user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc3'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $desc3 = $user_row[email] . "<br> " . $user_row[firstName] . " " . $user_row[lastName] . "<br> " . $user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc4'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $desc4 = $user_row[email] . "<br> " . $user_row[firstName] . " " . $user_row[lastName] . " <br>" . $user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc5'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $desc5 = $user_row[email] . "<br> " . $user_row[firstName] . " " . $user_row[lastName] . " <br>" . $user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc6'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $desc6 = $user_row[email] . "<br> " . $user_row[firstName] . " " . $user_row[lastName] . " <br>" . $user_row[myid];

    if (isset($_POST['btn-paid'])) {
        $ema = trim($_POST['email']);
        mysqli_query($dbc, "DELETE FROM pending WHERE email='$ema'");
        mysqli_query($dbc, "INSERT INTO to_receive(userName,firstName,lastName,phoneNo,accName,accNo,email,bankName,package) SELECT userName,firstName,lastName,phoneNo,accName,accNo,email,bankName,package FROM user_table WHERE email='$ema'");
        unset($ema);

    }

    if (isset($_POST['spack'])) {
        $mine = $userRow['email'];
        $q1 = "SELECT * FROM pending WHERE payto='$mine' AND topurge='0'";
        $q = mysqli_query($dbc, $q1);
        if (mysqli_num_rows($q) < 1) {
            $sp = trim($_POST['sp']);
            mysqli_query($dbc, "INSERT INTO to_pay(userName,firstName,lastName,phoneNo,bankName,accName,accNo,email) SELECT userName,firstName,lastName,phoneNo,bankName,accName,accNo,email FROM user_table WHERE email='$mine'");
            mysqli_query($dbc, "UPDATE to_pay SET package='$sp' WHERE email='$mine'");
            mysqli_query($dbc, "UPDATE user_table SET package='$sp' WHERE email='$mine'");
        }
        unset($sp);
    }


    if (isset($_POST['btn-purge'])) {
        $email = trim($_POST['email']);
        mysqli_query($dbc, "UPDATE pending SET topurge='1' WHERE email='$email'");
        unset($email);
    }
}
?>


<!DOCTYPE html>
<html class=" js csstransforms3d csstransitions csstransformspreserve3d" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Welcome to Uplinks Member Dashboard</title>    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->

    <link rel="shortcut icon" href="assets/img/logo/uplinkslogo_3D.png" type="image/x-icon"/>
    <link href="https://helpinghandsintl.biz/userpaneluser/css/fontello.css" rel="stylesheet">
    <link href="Font-Awesome/css/font-awesome.min.css" rel="stylesheet">

    <link href="dashboard_files/css.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="themify-icons/themify-icons.css">
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
	
    
    <!-- Fonts -->

    <link href="dashboard_files/epoch.css" rel="stylesheet" type="text/css">
    <link href="dashboard_files/style.css" rel="stylesheet" type="text/css">
    
    <link href="dashboard_files/verticalbargraph.css" rel="stylesheet" type="text/css">

    <!-- SugarRush CSS -->
    <!-- <link href="css/sugarrush.css" rel="stylesheet"> -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style>
  
  <style type="text/css">
  .percentbar { background:#CCCCCC; border:1px solid #666666; height:30px;margin: 10px 0px 0px 10px;border-radius: 7px;border: none; }
.percentbar div { background: #daa520; height: 30px; border-radius: 7px;border: medium none;}

</style>
  
    <!-- base css -->
    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>  
  </head>
  <body class="">

  



    <div class="animsition" style="animation-duration: 1.5s; opacity: 1;">  
          <!-- start of LOGO CONTAINER -->
      <div id="logo-container">
         <a target="_self" href="index2.php" id="logo-img">
          <img src="assets/img/logo/uplinkslogo_3D.png" alt="Home Page" 
          style="margin-top:-10px;" width="100">
          <!-- <img src="assets/img/logo/uplinkslogo_3D.png" data-no-retina   width="20" style="margin-top:-10px;" alt="Home Page"> -->
        </a>
      </div>
      <!-- end of LOGO CONTAINER -->

      <!-- - - - - - - - - - - - - -->
      <!-- start of SIDEBAR        -->
      <!-- - - - - - - - - - - - - -->
      <div id="sidebar" style="position:fixed !important;background:#daa520;">
        <div class="slimScroll" style="display width: 250px; height: 609px;"><div class="sidebar_scroll" style="overflow: hidden; width: 100%; height: 609px;"> <!-- start of slimScroll -->

          <ul class="nav lg-menu" id="main-nav" style="background:#daa520;">
            <li class="sidebar-title">
             <a href="http://uplinks.biz/" target="_blank"> <i class="ti-desktop"></i> <span>Access My Website</span></a> </li>
            <li><a target="_self" href="index2.php"> <i class="ti-dashboard"></i> <span>Main Dashboard</span></a>
            <!-- <li><a target="_self" href="https://www.dropbox.com/sh/us9b9ek5t5o15ti/AABKSheyDdhKktDuIr2kD9Lya?dl=0" target="_blank"> <i class="ti-receipt"></i> <span>Member Resources</span></a>
            </li>-->
             </li><li><a target="_self" href="#"> <i class="ti-user"></i> <span>My Account</span> <i class="pull-right has-submenu ti-angle-right"></i></a>
              <ul class="nav nav-submenu submenu-hidden"> 
                <li><a target="_self" href="update-profile.php">Update Profile</a></li>
               <!-- <li><a target="_self" href="manage_links.php">Manage Videos</a></li>-->
                
</ul></li>
 

          
  <li><a target="_self" href="#"> <i class="ti-receipt"></i> <span>My Income Report </span> <i class="pull-right has-submenu ti-angle-right"></i> </a>
              <ul class="nav nav-submenu submenu-hidden"> 
                <li><a target="_self"  href="sponsor-income.php">My Referral Income Report</a></li>
     
                <li><a target="_self" href="level_income_report.php">My Matrix Income Report</a></li>
     
                <!--<li><a target="_self" href="matching-income-report.php">My Matching Income Report</a></li>-->
     
              </ul>
            </li>

           
          

             <li><a target="_self" href="#"> <i class="ti-wallet"></i> <span>E-Wallet Section </span> <i class="pull-right has-submenu ti-angle-right"></i> </a>
              <ul class="nav nav-submenu submenu-hidden">
                <li><a target="_self" target="_self" href="ewallet-transaction-history.php">Transaction History</a></li>
               <li><a target="_self" href="check-ewallet-ballance.php">E-WALLET Balance</a></li>
            <li><a target="_self" href="external-fund-transfer.php">e-Wallet Fund Transfer</a></li>
               <li><a target="_self" href="withdrawal-section.php">E-WALLET Withdrawal </a></li>
                <li><a target="_self" href="add_fund_wallet.php">Add funds to wallet </a></li>

               
                 
                </ul>
            </li>
  
           <li><a target="_self" href="#"> <i class="ti-user"></i> <span>My Members Report</span> <i class="pull-right has-submenu ti-angle-right"></i> </a>
              <ul class="nav nav-submenu submenu-hidden">
                <li><a target="_self" href="direct-sponsor-member-report.php">Referral Members</a></li>
                <!--  <li><a target="_self" href="downline-member-report.php">Referral Members</a></li>-->
               <!--<li><a target="_self" href="../downline_member.php?downid=247781888636&username=Stick2me1" target="_blank">Team Members</a></li>-->
              </ul>
            </li>

             <li><a target="_self" href="#"> <i class="ti-vector"></i> <span>Genealogy Tree</span> <i class="pull-right has-submenu ti-angle-right"></i> </a>
              <ul class="nav nav-submenu submenu-hidden">
              
              <li><a target="_self" href="direct-member-tree.php">My Direct Member Tree</a></li>
                                      
              <li><a target="_blank" href="downline-member-tree.php">My Downline Tree</a></li>
                                      
                 <!--  <li><a target="_self" href="binary-tree.php">My Downline Tree</a></li> -->
              
               </ul>
            </li>
 
            <li> <a href="new-member-registration.php" target="_blank"> <i class="ti-desktop"></i> <span>Register Member</span></a> </li>

             <li><a target="_self" href="#"> <i class="ti-receipt"></i> <span>Support Management </span> <i class="pull-right has-submenu ti-angle-right"></i> </a>
              <ul class="nav nav-submenu submenu-hidden"> 
                <li><a target="_self" href="support.php">Open A Ticket</a></li>
                <li><a target="_self" href="view_raise_ticket_report.php">View Ticket Response</a></li>
                          
              </ul>
            </li>





              
  <li><a target="_self" href="#"> <i class="ti-user"></i> <span>Marketing Tools</span> <i class="pull-right has-submenu ti-angle-right"></i> </a>
              <ul class="nav nav-submenu submenu-hidden">
                <li><a target="_self" href="referal.php">Referrals Link</a></li>
                 <!--<li><a target="_self" href="social.php">Social Links</a></li>-->
                
              </ul>
            </li>

<!--<li>
             <a href="tell-a-friend.php"> <i class="ti-receipt"></i> <span>Tell A Friend</span></a> </li>-->
           
            
 <!-- <li><a target="_self" href="#"> <i class="ti-user"></i> <span>User Guidelines</span> <i class="pull-right has-submenu ti-angle-right"></i> </a>
              <ul class="nav nav-submenu submenu-hidden"> 
                <li>
             <a href="guidelines.php"> <i class="ti-desktop"></i> <span>User Guideliness</span></a> </li>
              
 <!-- <li>
             <a href="guidelines.php"> <i class="ti-desktop"></i> <span>User Guideliness</span></a> </li>-->
               <!-- </ul>
            </li>-->

           <?php if($ut==1){
            ?>
            

              
  <li><a target="_self" href="#"> <i class="ti-ticket"></i> <span>Administrative Tools</span> <i class="pull-right has-submenu ti-angle-right"></i> </a>
              <ul class="nav nav-submenu submenu-hidden">
              <li> <a href="listmember.php" target="_self"> View all Member</a> </li>
            <li> <a href="admin_messages.php" target="_self"> Members Tickets</a> </li>
            <li> <a href="view_withdrawal_requests.php" target="_self">View Withdrawal Requests</a> </li>
            <li> <a href="view_to_fund.php" target="_self">Fund Members Wallet</a> </li>

              </ul>
            </li>
        
            
            <?php
           }
           ?>
             <li><a target="_self" href="#"> <i class="ti-file"></i> <span>Policy Section</span> <i class="pull-right has-submenu ti-angle-right"></i> </a>
              <ul class="nav nav-submenu submenu-hidden"> 
                <li><a target="_self" href="terms-and-condition.php">Terms &amp; Conditions</a></li>
                <!--<li><a target="_self" href="privacy-policy.php">Privacy Policy</a></li>
                <li><a target="_self" href="refund-policy.php">Refund Policy</a></li>
                <li><a target="_self" href="anti-spam-policy.php">Anti Spam Policy</a></li>-->
              </ul>
            </li>
            
           <li>  <a target="_self" href="logout.php?logout">  <i class="ti-power-off"> </i>  <span>Logout</span> <i class="pull-right" >  </i> </a>  </li>
                    
          </ul>
        </div><div class="slimScrollBar" style="background: rgb(0, 0, 0) none repeat scroll 0% 0%; width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 609px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;"></div></div> <!-- end of slimScroll -->
      </div>
      <!-- - - - - - - - - - - - - -->
      <!-- end of SIDEBAR          -->
      <!-- - - - - - - - - - - - - -->

      <main id="playground">

            
        <!-- - - - - - - - - - - - - -->
        <!-- start of TOP NAVIGATION -->
        <!-- - - - - - - - - - - - - -->
        <nav class="navbar navbar-top navbar-static-top">
          <div class="container-fluid">

            <!-- sidebar collapse and toggle buttons get grouped for better mobile display -->
            <div class="navbar-header nav">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-top">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand show-hide-sidebar hide-sidebar" href="#" style="height:50px;"><i class="fa fa-outdent"></i></a>
              <a class="navbar-brand show-hide-sidebar show-sidebar" href="#" style="height:50px;"><i class="fa fa-indent"></i></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-top">

              <!-- start of SEARCH BLOCK -->
              <div class="navbar-form navbar-left navbar-search-block" style="display:none;">

                <!--<div class="search-field-container">
                  <input type="text" placeholder="View Shortcut" class="search-field">
                  <a href="#"><i class="ti-search"></i></a>
                </div>->

                <!-- start of CLOSE BUTTON -->
                <a href="#" class="btn btn-danger search-close"><i class="ti-close"></i></a>
                <!-- end of CLOSE BUTTON -->

                <div class="container-fluid search-container">
                  <div class="row">

                    <!-- start of CONTACTS COLUMN -->
                    <div class="col-md-4 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
                                           <ul>
                        <li>
                          <a href="update-profile.php">
                            <div class="img-container">
                              <img src="dashboard_files/demoimage.htm" alt="">
                            </div>
                            <span style="color:#000;">Update Profile</span>
                          </a>
                        </li>

                        <li>
                          <a href="sponsor-income.php">
                            <div class="img-container">
                              <img src="dashboard_files/demoimage.htm" alt="">
                            </div>
                            <span style="color:#000;">Sponsor Income</span>
                          </a>
                        </li>

                        <li>
                          <a href="binary-income-report.php">
                            <div class="img-container">
                              <img src="dashboard_files/demoimage.htm" alt="" />
                            </div>
                            <span style="color:#000;">Binary Income</span>
                          </a>
                        </li>

                        <li>
                          <a href="matching-income-report.php">
                            <div class="img-container">
                              <img src="dashboard_files/demoimage.htm" alt="" />
                            </div>
                            <span style="color:#000;">Matching Income</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                    <!-- end of CONTACTS COLUMN -->

                    <!-- start of MESSAGES COLUMN -->
                    <div class="col-md-4 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
              
                      <ul>
                        <li>
                          <a href="binary-bv-report.php">
                            <div class="img-container">
                              <img src="dashboard_files/demoimage.htm" alt="">
                            </div>
                            <span style="color:#000;">Binary BV Report</span>
                          </a>
                        </li>

                        <li>
                          <a href="direct-sponsor-member-report.php">
                            <div class="img-container">
                              <img src="dashboard_files/demoimage.htm" alt="">
                            </div>
                            <span style="color:#000;">Direct Member</span>
                          </a>
                        </li>

                        <li>
                          <a href="downline-member-report.php">
                            <div class="img-container">
                              <img src="dashboard_files/demoimage.htm" alt="">
                            </div>
                            <span style="color:#000;">Downline Member</span>
                          </a>
                        </li>

                        <li>
                          <a href="direct-member-tree.php">
                            <div class="img-container">
                              <img src="dashboard_files/demoimage.htm" alt="">
                            </div>
                            <span style="color:#000;">Direct Member Tree</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                    <!-- end of MESSAGES COLUMN -->

                    <!-- start of RECENT COLUMN -->
                    <div class="col-md-4 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
           
                      <ul>
                        <li>
                          <a href="binary-tree.php">
                            <div class="img-container">
                              <img src="dashboard_files/demoimage.htm" alt="">
                            </div>
                            <span style="color:#000;">Binary Tree</span>
                          </a>
                        </li>

                        <li>
                          <a href="ewallet-transaction-history.php">
                            <div class="img-container">
                              <img src="dashboard_files/demoimage.htm" alt="">
                            </div>
                            <span style="color:#000;">Transaction History</span>
                          </a>
                        </li>

                        <li>
                          <a href="check-ewallet-ballance.php">
                            <div class="img-container">
                              <img src="dashboard_files/demoimage.htm" alt="">
                            </div>
                            <span style="color:#000;">Ewallet Ballance</span>
                          </a>
                        </li>

                        <li>
                          <a href="external-fund-transfer.php">
                            <div class="img-container">
                              <img src="dashboard_files/demoimage.htm" alt="">
                            </div>
                            <span style="color:#000;">Fund Transfer</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                    <!-- end of RECENT COLUMN -->

                  </div>
                </div>

              </div>
              <!-- end of SEARCH BLOCK -->

              <ul class="nav navbar-nav">

                <!-- start of LANGUAGE MENU -->
               <!-- <li class="dropdown language-nav">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><img src="images/United-Kingdom.png" data-no-retina  alt=""> English <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a target="_self" href="#"><img src="images/Spain.png" data-no-retina  alt=""> Spanish</a></li>
                    <li><a target="_self" href="#"><img src="images/France.png" data-no-retina  alt=""> French</a></li>
                    <li><a target="_self" href="#"><img src="images/Germany.png" data-no-retina  alt=""> German</a></li>
                    <li><a target="_self" href="#"><img src="images/Italy.png" data-no-retina  alt=""> Italian</a></li>
                  </ul>
                </li> -->
                <!-- end of LANGUAGE MENU -->
                
                <!-- start of OPEN NOTIFICATION PANEL BUTTON -->
                                <li>
                  <a href="#" class="btn-show-chat" style="height:50px;">
                    <i class="ti-announcement"></i><span class="badge badge-warning">0</span>
                  </a>
                </li>
                <!--<li  data-toggle="tooltip" data-placement="right" title="Check our Online Documentation">
                  <a href="#" class="search-field">
                    <i class="ti-heart" ></i>
                  </a>
                </li>-->
                <!-- end of OPEN NOTIFICATION PANEL BUTTON -->

              </ul>

              <ul class="nav navbar-nav navbar-right">

                <!-- start of USER MENU -->
                <li id="mytopmenu" class="dropdown user-profile">
                  <a target="_self" href="#" onclick="toggleTopMenu()" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true" style="height:50px;">
                    <div class="user-img-container">
                      <!--<img src="images/male.jpg" alt="My Image"> -->

                      <img src="uploads/profilepic/<?php echo $my_urltoimg;?>" alt="My Image">
                    </div> 
                    Welcome <?php echo $my_userName;?>! <span class="chat-status success"></span>
                  </a>

                  <ul class="dropdown-menu" role="menu">
                    <li><a target="_self" target="_blank" href="update-profile.php">My Profile</a></li>
                    <li><a target="_self" href="logout.php?logout">Logout</a></li>
                  </ul>
                </li>
                <!-- end of USER MENU -->

              </ul>
            </div>
            <!-- end of navbar-collapse -->
          </div>
          <!-- end of container-fluid -->
        </nav>
        <!-- - - - - - - - - - - - - -->
        <!-- end of TOP NAVIGATION   -->
        <!-- - - - - - - - - - - - - -->
          <script type="text/javascript">
              function toggleTopMenu() {

                  if (document.getElementById("mytopmenu").classList.contains('open')) {
                      console.log("has open");
                      document.getElementById("mytopmenu").className = "dropdown user-profile";
                  } else {

                      console.log("has no open");

                      document.getElementById("mytopmenu").className = " dropdown user-profile open";
                  }
              }
          </script>