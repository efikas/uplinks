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

$error = false;

if( isset($_GET['msg']) ) {
    $log_msg = $_GET['msg'];
}
    if( isset($_POST['btn-login']) ) {
    $errMSG = "";
    include_once 'securimage/securimage.php';
    $securimage = new Securimage();
    if ($securimage->check($_POST['captcha_code']) == false) {
        // the code was incorrect
        // you should handle the error so that the form processor doesn't continue

        // or you can use the following code if there is no validation or you do not know how
        // echo "The security code entered was incorrect.<br /><br />";
        //echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
        //exit;
        $error = true;
        $errMSG = "Wrong credential detail!";
    }


    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    // prevent sql injections / clear user invalid inputs

    if(empty($email)){
        $error = true;
        $emailError = "Please enter your username.";
    }

    if(empty($pass)){
        $error = true;
        $passError = "Please enter your password.";
    }

    // if there's no error, continue to login
    if (!$error) {

        $password = hash('sha256', $pass); // password hashing using SHA256

        $res=mysqli_query($dbc,"SELECT * FROM user_table WHERE userName='$email'");
        $row=mysqli_fetch_array($res);
        $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row

        if( $count == 1 && $row['password']==$password && $row['userType']=='1'&& $row['block']=='No') {
            $_SESSION['user'] = $row['email'];
            $_SESSION['userType'] = $row['userType'];
            $_SESSION['user-power'] = $row['power'];
            header("Location: dashboard.php");
        } else if( $count == 1 && $row['password']==$password && $row['block']=='No') {
            $_SESSION['user'] = $row['email'];
            $_SESSION['userType'] = $row['userType'];
            $_SESSION['user-power'] = $row['power'];
            header("Location: dashboard.php");
        } else {
            $error = true;
            $errMSG = "Incorrect Credentials, Try again...";
        if($row['block']=='Yes'){

            $errMSG = "You have been blocked. Please contact Admin.";

        }
        }

    }

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

        <link rel="shortcut icon" href="assets/img/logo/uplinkslogo_3D.png" type="image/x-icon"/>
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
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2" 
                                style="background-color:white; border: 1px solid gray; border-radius: 30px">
                            <div class="panel text-center">
                                <header class="panel-headingg text-center" 
                                    style="background-color: light-gray !important">
                                    <img src="assets/img/logo/uplinkslogo_3D.png" class="big-logo" style="width:250px;">
                                    <h2 style="background-color: #CCCCCC; height: 80px; padding-top: 25px;">
                                        User Login Panel</h2>
                                </header>
                                <div class="panel-body" style="padding-top: 0px !important">
                                    <!--<form action="../post-action.php" method="post">-->
                                    <form method="post"
                                    action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                                        <input name="action" value="loginuser" type="hidden">
                                        <p class="text-center"></p><div style="color:red; font-size:14px; font-weight:bold;"><span style="color:#F00;padding-left:10px;"></span></div>

                                        <?php if($error == true){ ?>
                                            <div style="color:red; font-size:14px; font-weight:bold; text-align: center;">
                                                <span style="color:#F00;padding-left:0px;"><?php echo $errMSG;?></span><br><br></div>

                                            <?php
                                        } ?>
                                        <p></p>

                                        <div style="color:red; font-size:14px; font-weight:bold; text-align: center;">
                                            <span style="color:#F00;padding-left:0px;"><?php echo $log_msg; ?></span></div>
                                        <div class="form-group">

                                            <div class="input-group">
                                                <label for="email">Username</label>
                                                <input type="text" name="email" class="form-control" placeholder="Your Username" value="<?php echo $email; ?>" maxlength="40" />
                                            </div>
                                            <span class="text-danger"><?php echo $emailError; ?></span>
                                        </div>



                                        <div class="form-group">

                                            <div class="input-group">
                                                <label for="password">Password</label> <a href="forgot.php" class="pull-right forgot-link"><small>Forgot?</small></a>
                                                <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
                                            </div>
                                            <span class="text-danger"><?php echo $passError; ?></span>
                                        </div>

                                        <div class="form-group">
                                            <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
                                            <input type="text" name="captcha_code" size="10" maxlength="6" />

                                            <a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[Different Image]</a>
                                        </div>


                                        <div class="form-group text-center">
                                            <button type="submit" style="color:white;background-color:#daa520 !important;" class="btn btn-login " name="btn-login">Sign In</button>
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
                                    </form><!--Site under maintenance due to heavy traffic and load currently we will resume soon.-->
                                    <hr>
                                    <div class="register-now">
                                        Not registered? <a href="register.php">Register now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </main> <!-- /playground -->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="User%20Back%20Office%20Login%20Panel_files/jquery-1.js"></script>
        <script src="User%20Back%20Office%20Login%20Panel_files/bootstrap.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="User%20Back%20Office%20Login%20Panel_files/jquery.js"></script>
        <script src="User%20Back%20Office%20Login%20Panel_files/login.js"></script>

    </div>


    </body>
    </html>
<?php ob_end_flush(); ?>