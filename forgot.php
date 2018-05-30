<?php
/**
 * @author Akintola Oluwaseun 
 * @copyright 2017
 */
 
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// it will never let you open index(login) page if session is set
	if ( isset($_SESSION['user'])!="" ) {
		header("Location: dashboard.php");
		exit;
	}

if(isset($_POST['email'])){
    
$rand = rand(0,9999);
$now = time();
$code = crypt($now,$rand);
$code1 = $code;

//get the parameters for login email and password
$email = $_POST['email'];
$email = mysqli_real_escape_string($dbc,$email);

//check if user email and password is correct and account status is active
$table_users = 'user_table';
$query = "SELECT * FROM `$table_users` WHERE `email`='$email'";
$check_result = mysqli_query($dbc,$query)
or die('Error Querying Database');
$result_num = mysqli_num_rows($check_result);
if($result_num ==0){
//not a valid user 
$data = array('status'=>0,'details'=>"Not a valid user");
$resp = "Email not found in our database!";
//echo $response ;
}else{
    
//user details
$row = mysqli_fetch_array($check_result);
$email = $row['email'];
$name = $row['first_name'].' '.$row['last_name'];
  
$query_add = "INSERT INTO `forgotpass` SET
`email`='$email',
`code`='$code1'";    
 mysqli_query($dbc,$query_add);
    
 //mail user

$subject = "Uplinks Password Reset";
$message = '
Hi '.$name.',
<br/>
<br/>
<a href="'.$site_root.'reset.php?code='.$code1.'&user='.$email.'">Click here to reset your password</a><br/>
or Copy this link into your browser address press enter <br/>
<a href="'.$site_root.'reset.php?code='.$code1.'&user='.$email.'">'.$site_root.'reset.php?code='.$code1.'&user='.$email.'</a>
';
@$send_mail = mail_user($email,$name,$subject,$message);

if($send_mail==1){
$error_details = 'Mail sent!';

}else{
$error_details = 'Mail NOT sent!';

}

$data = array('status'=>1,'details'=>"$error_details"); 
$response = json_encode($data);
//echo $response;

$resp = "Mail sent! KIndly check your mailbox to reset your password. Thank you.";
}
// end if get    
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Welcome to Uplinks Member Dashboard</title>    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->

    <link rel="shortcut icon" href="dashboard_files/logo-inverse2.png" type="image/x-icon"/>
    <link href="https://helpinghandsintl.biz/userpaneluser/css/fontello.css" rel="stylesheet">
    <link href="Font-Awesome/css/font-awesome.min.css" rel="stylesheet">

    <link href="dashboard_files/css.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="themify-icons/themify-icons.css">
	
    
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

<body class="login-page">
    <div class="animsition" style="animation-duration: 1.5s; opacity: 1;">

      <main class="login-container">

        <div class="panel-container">
          <section class="panel" style="width:333px !important;">
            <header class="panel-heading">
             <img src="dashboard_files/logo-inverse.png" class="big-logo" style="width:210px;">
              <h2>Forgot Password</h2>
            </header>
            <div class="panel-body">
             <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
               <input name="action" value="ForgotPassword" type="hidden">
                  <p class="text-center"></p><div style="color:red; font-size:14px; font-weight:bold;"><span style="color:#F00;padding-left:10px;"> <?php echo $resp; ?></span><br><br></div>
              <p></p>                <div class="form-group">
                  <label for="username">Email Id</label>
                  <input class="form-control" id="username" placeholder="Enter your registered email" name="email" required="" type="email">
                </div>

                 <div class="form-group">
                  <label for="username">User Id/Username</label>
                  <input class="form-control" id="userid" placeholder="Enter your user id/username" name="user" required="" type="text">
                </div>

               
                               
                <div class="form-group text-center">
                  <input style="background-color: #daa520;" name="submit" value="Send" class="btn-login btn btn-primary" type="submit">
                </div>

               <hr>
                
                <div class="social-login">
                  <p class="text-center">Connect with us on social media
              </p>
                 <p class="text-center">
                 <a style="background-color: #daa520;"  href="https://www.facebook.com/uplinksbiz" target="_blank"><i class="ti-facebook"></i></a>
                     <a style="background-color: #daa520;"  href="https://chat.whatsapp.com/A3zyeEThvLC3iKmVu5q4te" target="_blank"><img style="margin-bottom: 10%;" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE2cHgiIGhlaWdodD0iMTZweCIgdmlld0JveD0iMCAwIDkwIDkwIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA5MCA5MDsiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8Zz4KCTxwYXRoIGlkPSJXaGF0c0FwcCIgZD0iTTkwLDQzLjg0MWMwLDI0LjIxMy0xOS43NzksNDMuODQxLTQ0LjE4Miw0My44NDFjLTcuNzQ3LDAtMTUuMDI1LTEuOTgtMjEuMzU3LTUuNDU1TDAsOTBsNy45NzUtMjMuNTIyICAgYy00LjAyMy02LjYwNi02LjM0LTE0LjM1NC02LjM0LTIyLjYzN0MxLjYzNSwxOS42MjgsMjEuNDE2LDAsNDUuODE4LDBDNzAuMjIzLDAsOTAsMTkuNjI4LDkwLDQzLjg0MXogTTQ1LjgxOCw2Ljk4MiAgIGMtMjAuNDg0LDAtMzcuMTQ2LDE2LjUzNS0zNy4xNDYsMzYuODU5YzAsOC4wNjUsMi42MjksMTUuNTM0LDcuMDc2LDIxLjYxTDExLjEwNyw3OS4xNGwxNC4yNzUtNC41MzcgICBjNS44NjUsMy44NTEsMTIuODkxLDYuMDk3LDIwLjQzNyw2LjA5N2MyMC40ODEsMCwzNy4xNDYtMTYuNTMzLDM3LjE0Ni0zNi44NTdTNjYuMzAxLDYuOTgyLDQ1LjgxOCw2Ljk4MnogTTY4LjEyOSw1My45MzggICBjLTAuMjczLTAuNDQ3LTAuOTk0LTAuNzE3LTIuMDc2LTEuMjU0Yy0xLjA4NC0wLjUzNy02LjQxLTMuMTM4LTcuNC0zLjQ5NWMtMC45OTMtMC4zNTgtMS43MTctMC41MzgtMi40MzgsMC41MzcgICBjLTAuNzIxLDEuMDc2LTIuNzk3LDMuNDk1LTMuNDMsNC4yMTJjLTAuNjMyLDAuNzE5LTEuMjYzLDAuODA5LTIuMzQ3LDAuMjcxYy0xLjA4Mi0wLjUzNy00LjU3MS0xLjY3My04LjcwOC01LjMzMyAgIGMtMy4yMTktMi44NDgtNS4zOTMtNi4zNjQtNi4wMjUtNy40NDFjLTAuNjMxLTEuMDc1LTAuMDY2LTEuNjU2LDAuNDc1LTIuMTkxYzAuNDg4LTAuNDgyLDEuMDg0LTEuMjU1LDEuNjI1LTEuODgyICAgYzAuNTQzLTAuNjI4LDAuNzIzLTEuMDc1LDEuMDgyLTEuNzkzYzAuMzYzLTAuNzE3LDAuMTgyLTEuMzQ0LTAuMDktMS44ODNjLTAuMjctMC41MzctMi40MzgtNS44MjUtMy4zNC03Ljk3NyAgIGMtMC45MDItMi4xNS0xLjgwMy0xLjc5Mi0yLjQzNi0xLjc5MmMtMC42MzEsMC0xLjM1NC0wLjA5LTIuMDc2LTAuMDljLTAuNzIyLDAtMS44OTYsMC4yNjktMi44ODksMS4zNDQgICBjLTAuOTkyLDEuMDc2LTMuNzg5LDMuNjc2LTMuNzg5LDguOTYzYzAsNS4yODgsMy44NzksMTAuMzk3LDQuNDIyLDExLjExM2MwLjU0MSwwLjcxNiw3LjQ5LDExLjkyLDE4LjUsMTYuMjIzICAgQzU4LjIsNjUuNzcxLDU4LjIsNjQuMzM2LDYwLjE4Niw2NC4xNTZjMS45ODQtMC4xNzksNi40MDYtMi41OTksNy4zMTItNS4xMDdDNjguMzk4LDU2LjUzNyw2OC4zOTgsNTQuMzg2LDY4LjEyOSw1My45Mzh6IiBmaWxsPSIjRkZGRkZGIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" /></a>
                     <a style="background-color: #daa520;"  href="https://www.instagram.com/uplinksbiz" target="_blank"><i class="ti-instagram"></i></a>
                     <a style="background-color: #daa520;"  href="https://www.twitter.com/uplinksbiz" target="_blank"><i class="ti-twitter"></i></a>
                     <a style="background-color: #daa520;"  href="http://www.youtube.com/playlist?list=PLTDwP0gFbqmzgIUibwJvDExpCb0HgXwPT" target="_blank"><i class="ti-youtube"></i></a>
                 </p>
                </div>
              </form>
              <hr>
              <div class="register-now">
                Already registered? <a target="_self" href="http://uplinks.biz/users">Login now</a>
              </div>
            </div>
          </section>
        </div>
      </main> <!-- /playground -->

      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="forgot2_files/jquery-1.js"></script>
      <script src="forgot2_files/bootstrap.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="forgot2_files/jquery.js"></script>
      <script src="forgot2_files/login.js"></script>

    </div>
  
</body>
</html>
<?php ob_end_flush(); ?>