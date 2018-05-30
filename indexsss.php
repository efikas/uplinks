<?php
/**
 * Created by PhpStorm.
 * User: latyf
 * Date: 4/21/18
 * Time: 11:31 AM
 * 
 * @category: aa
 * @version:  3637
 * @author:   dff
 * @package:  dsss
 * @license:  wsss
 * @link:     http://www.aaa.com
 */

ob_start();
session_start();
require_once 'dbconnect.php';



// it will never let you open index(login) page if session is set
if (isset($_SESSION['user']) != "") {
    header("Location: dashboard.php");
    exit;
}

$error = false;
$error_msg = [];

if (isset($_GET['msg'])) {
    $log_msg = $_GET['msg'];
}
if (isset($_POST['login'])) {
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
        array_push($error_msg, "Wrong credential detail!");
    }


    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['password']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    // prevent sql injections / clear user invalid inputs

    if (empty($email)) {
        $error = true;
        array_push($error_msg, "Please enter your username.");
    }

    if (empty($pass)) {
        $error = true;
        array_push($error_msg, "Please enter your password.");
    }

    // if there's no error, continue to login
    if (!$error) {

        $password = hash('sha256', $pass); // password hashing using SHA256

        $res = mysqli_query($dbc, "SELECT * FROM user_table WHERE userName='$email'");
        $row = mysqli_fetch_array($res);
        $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row

        if ($count == 1 && $row['password'] == $password && $row['userType'] == '1' && $row['block'] == 'No') {
            $_SESSION['user'] = $row['email'];
            $_SESSION['userType'] = $row['userType'];
            $_SESSION['user-power'] = $row['power'];
            header("Location: dashboard.php");
        } else if ($count == 1 && $row['password'] == $password && $row['block'] == 'No') {
            $_SESSION['user'] = $row['email'];
            $_SESSION['userType'] = $row['userType'];
            $_SESSION['user-power'] = $row['power'];
            header("Location: dashboard.php");
        } else {
            $error = true;
            array_push($error_msg, "Incorrect Credentials, Try again...");

            if ($row['block'] == 'Yes')
                array_push($error_msg, "You have been blocked. Please contact Admin.");
        }

    }

} elseif (isset($_POST['register'])) {
    // prevent sql injections/ clear user invalid inputs
    $firstname = htmlspecialchars(strip_tags(trim($_POST['firstname'])));
    $lastname = htmlspecialchars(strip_tags(trim($_POST['lastname'])));
    $email = htmlspecialchars(strip_tags(trim($_POST['email'])));
    $dob = htmlspecialchars(strip_tags(trim($_POST['dob'])));
    $gender = htmlspecialchars(strip_tags(trim($_POST['gender'])));
    // $superior_id = htmlspecialchars(strip_tags(trim($_POST['superior_id'])));
    $occupation = htmlspecialchars(strip_tags(trim($_POST['occupation'])));
    $address = htmlspecialchars(strip_tags(trim($_POST['address'])));
    $country = htmlspecialchars(strip_tags(trim($_POST['country'])));
    $state = htmlspecialchars(strip_tags(trim($_POST['state'])));
    $city = htmlspecialchars(strip_tags(trim($_POST['city'])));
    $phone = htmlspecialchars(strip_tags(trim($_POST['phone'])));
    $username = htmlspecialchars(strip_tags(trim($_POST['username'])));
    $pass = htmlspecialchars(strip_tags(trim($_POST['pass'])));
    $pass2 = htmlspecialchars(strip_tags(trim($_POST['pass2'])));
    $bankname = htmlspecialchars(strip_tags(trim($_POST['bankname'])));
    $accname = htmlspecialchars(strip_tags(trim($_POST['accname'])));
    $accno = htmlspecialchars(strip_tags(trim($_POST['accno'])));
    $ref_username = htmlspecialchars(strip_tags(trim($_POST['ref_username'])));

    //checking for errors
    if (empty($firstname)) { 
        $error = true; 
        $error_firstName = "Please enter your Firstname."; 
    }
    if (empty($lastname)) { 
        $error = true; $error_lastname = "Please enter your Lastname."; 
    }
    if (empty($email)) { 
        $error = true; $error_email = "Please enter your Email."; 
    }

    if (empty($dob)) { 
        $error = true; $error_dob = "Please enter your Date of Birth."; 
    }

    // if (empty($superior_id)) {
    //     $error = true; $error_superior_id = "Please enter your referer id.";
    // } 
    // else {
    //     $res = mysqli_query($dbc, "SELECT * FROM user_table WHERE userName='$ref_username'");
    //     $row = mysqli_fetch_array($res);
    //     $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
    //     $referer_id = '';
    //     if ($count == 1) {
    //         $referer_id = $row['myid'];
    //     } else {
    //         $error = true; $error_superior_id = "Please enter a correct referer id.";
    //     }
    // }

    if ($gender == "") { 
        $error = true; $error_gender = "Please enter your Gender."; 
    }
    if (empty($occupation)) { 
        $error = true; $error_occupation = "Please enter your Email."; 
    }
    if (empty($address)) { 
        $error = true; $error_address = "Please enter your Address."; 
    }
    if ($country == "") { 
        $error = true; $error_country = "Please enter your Country."; 
    }
    if (empty($city)) { 
        $error = true; $error_city = "Please enter your City."; 
    }
    if (empty($state)) { 
        $error = true; $error_state = "Please enter your State."; 
    }
    if (empty($phone)) { 
        $error = true; $error_phone = "Please enter your Pnone Number."; 
    }
    if (empty($username)) { 
        $error = true; $error_username = "Please enter your Username."; 
    }
    if (empty($pass)) { 
        $error = true; $error_pass = "Please enter your password."; 
    }
    if (empty($pass2)) { 
        $error = true; $error_pass = "Please enter the confirmation password."; 
    }

    if (!empty($pass) && !empty($pass2) && $pass != $pass2) {
        $error = true;
        $error_pass2 = "Please re enter your the same password.";
    }


    if (empty($bankname)) { 
        $error = true; $error_bankname = "Please enter your Bank Name."; 
    }
    if (empty($accname)) { 
        $error = true; $error_accname = "Please enter your Account Name."; 
    }
    if (empty($accno)) { 
        $error = true; $error_accno = "Please enter your Account Number."; 
    }
    if (empty($ref_username)) { 
        $error = true; $error_ref_username = "Please enter your Referer Username."; 
    }

    if (!$error) {

        $password = hash('sha256', $pass);
        $added = date("Y-m-d h:i:s a");
        $myId = uniqid(). '-' . md5(uniqid(mt_rand(), true).microtime(true));
        $sql = "INSERT INTO user_table (userName, firstName, lastName, gender, occupation, dob, country, address, city, state, zipcode, phoneNo, bankName, accName, accNo, email, password, myid, superior_id) 
                VALUES ('$username', '$firstname', '$lastname', '$gender', '$occupation', '$dob', '$country', '$address', '$city', '$state', '$zipcode', '$phoneNo', '$bankname', '$accname', '$accno', '$email', '$password', '$myId', '$superior_id')";
        if (mysqli_query($dbc, $sql)) {
            echo "Records added successfully.";
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($dbc);
        }

        // close connection
        mysqli_close($dbc);
    }


} elseif (isset($_POST['recover-pass'])) {

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
        <!--        <link href="Font-Awesome/css/font-awesome.min.css" rel="stylesheet">-->

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
        <style type="text/css">.jqstooltip {
                position: absolute;
                left: 0px;
                top: 0px;
                visibility: hidden;
                background: rgb(0, 0, 0) transparent;
                background-color: rgba(0, 0, 0, 0.6);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);
                -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";
                color: white;
                font: 10px arial, san serif;
                text-align: left;
                white-space: nowrap;
                padding: 5px;
                border: 1px solid white;
                z-index: 10000;
            }

            .jqsfield {
                color: white;
                font: 10px arial, san serif;
                text-align: left;
            }</style>

        <style type="text/css">
            .percentbar {
                background: #CCCCCC;
                border: 1px solid #666666;
                height: 30px;
                margin: 10px 0px 0px 10px;
                border-radius: 7px;
                border: none;
            }

            .percentbar div {
                background: #daa520;
                height: 30px;
                border-radius: 7px;
                border: medium none;
            }

            .panel-heading {
                color: white;
                background-color: #daa520 !important;
            }

            .my-btn {
                color: white;
                background-color: #daa520 !important;
                border-radius: 10px
            }

            .my-btn:hover {
                color: white;
                background-color: #da8332 !important;
                border-radius: 10px
            }
            .social-login > p > a {
                    width: 45px !important;
                    height: 45px !important;
            }

            .error_msg {
                font-weight: bold;
                color: red;
                margin-top: 5px;
            }
        </style>

        <!-- base css -->
        <script src="assets/jquery-1.11.3-jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    </head>

    <body class="login-page">
    <div class="animsition" style="animation-duration: 1.5s; opacity: 1;">

        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-md-offset-3 text-center" style="height: 80px; margin-top: 50px;">
                    <img src="dashboard_files/logo-inverse.png" class="big-logo" style="width:250px;">
                </div>

            </div>
            <div id="loginbox" style="margin-top:50px;"
                 class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">Sign In</div>
                    </div>

                    <div style="padding-top:30px" class="panel-body">

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                        <form id="loginform" class="form-horizontal" role="form" method="POST">

                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="login-username" type="text" class="form-control" name="email" value="<?php echo $email; ?>"
                                       placeholder="Your Username">
                            </div>

                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="login-password" type="password" class="form-control" name="password"
                                       placeholder="Your Password">
                            </div>

                            <div class="form-group">
                                <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
                                <input type="text" name="captcha_code" size="10" maxlength="6" />

                                <a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
                            </div>


<!--                            <div class="input-group">-->
<!--                                <div class="checkbox">-->
<!--                                    <label>-->
<!--                                        <input id="login-remember" type="checkbox" name="remember" value="1"> Remember-->
<!--                                        me-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                            </div>-->


                            <div style="margin-top:10px" class="form-group">
                                <!-- Button -->
                                <div class="col-sm-8 col-sm-offset-2 controls">
                                    <input type="submit" id="btn-login" value="Login" class="btn btn-block my-btn"
                                           name="login">
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-12 control">
                                    <div style="border-top: 1px solid #888; padding-top:15px; font-size:85%">
                                        Don't have an account!
                                        <a href="#" onClick="$('#loginbox').hide(); $('#forgetpass').hide(); $('#signupbox').show()">
                                            <strong>&nbsp;Sign Up Here</strong>
                                        </a>
                                    </div>
                                    <div style="padding-top:15px; font-size:85%">
                                        Cant remember my password!
                                        <a href="#" onClick="$('#loginbox').hide(); $('#signupbox').hide(); $('#forgetpass').show();">
                                            <strong>&nbsp;Forgot Password</strong>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="social-login">
                                <p class="text-center">Connect with us on social media
                                </p>
                                <p class="text-center">
                                    <a class="img-rounded"  style="background-color: #daa520; width: 50px !important; height: 25px"  href="https://www.facebook.com/uplinksbiz" target="_blank"><i class="ti-facebook"></i></a>
                                    <a class="img-rounded"  style="background-color: #daa520;"  href="https://chat.whatsapp.com/A3zyeEThvLC3iKmVu5q4te" target="_blank"><img style="margin-bottom: 10%;" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE2cHgiIGhlaWdodD0iMTZweCIgdmlld0JveD0iMCAwIDkwIDkwIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA5MCA5MDsiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8Zz4KCTxwYXRoIGlkPSJXaGF0c0FwcCIgZD0iTTkwLDQzLjg0MWMwLDI0LjIxMy0xOS43NzksNDMuODQxLTQ0LjE4Miw0My44NDFjLTcuNzQ3LDAtMTUuMDI1LTEuOTgtMjEuMzU3LTUuNDU1TDAsOTBsNy45NzUtMjMuNTIyICAgYy00LjAyMy02LjYwNi02LjM0LTE0LjM1NC02LjM0LTIyLjYzN0MxLjYzNSwxOS42MjgsMjEuNDE2LDAsNDUuODE4LDBDNzAuMjIzLDAsOTAsMTkuNjI4LDkwLDQzLjg0MXogTTQ1LjgxOCw2Ljk4MiAgIGMtMjAuNDg0LDAtMzcuMTQ2LDE2LjUzNS0zNy4xNDYsMzYuODU5YzAsOC4wNjUsMi42MjksMTUuNTM0LDcuMDc2LDIxLjYxTDExLjEwNyw3OS4xNGwxNC4yNzUtNC41MzcgICBjNS44NjUsMy44NTEsMTIuODkxLDYuMDk3LDIwLjQzNyw2LjA5N2MyMC40ODEsMCwzNy4xNDYtMTYuNTMzLDM3LjE0Ni0zNi44NTdTNjYuMzAxLDYuOTgyLDQ1LjgxOCw2Ljk4MnogTTY4LjEyOSw1My45MzggICBjLTAuMjczLTAuNDQ3LTAuOTk0LTAuNzE3LTIuMDc2LTEuMjU0Yy0xLjA4NC0wLjUzNy02LjQxLTMuMTM4LTcuNC0zLjQ5NWMtMC45OTMtMC4zNTgtMS43MTctMC41MzgtMi40MzgsMC41MzcgICBjLTAuNzIxLDEuMDc2LTIuNzk3LDMuNDk1LTMuNDMsNC4yMTJjLTAuNjMyLDAuNzE5LTEuMjYzLDAuODA5LTIuMzQ3LDAuMjcxYy0xLjA4Mi0wLjUzNy00LjU3MS0xLjY3My04LjcwOC01LjMzMyAgIGMtMy4yMTktMi44NDgtNS4zOTMtNi4zNjQtNi4wMjUtNy40NDFjLTAuNjMxLTEuMDc1LTAuMDY2LTEuNjU2LDAuNDc1LTIuMTkxYzAuNDg4LTAuNDgyLDEuMDg0LTEuMjU1LDEuNjI1LTEuODgyICAgYzAuNTQzLTAuNjI4LDAuNzIzLTEuMDc1LDEuMDgyLTEuNzkzYzAuMzYzLTAuNzE3LDAuMTgyLTEuMzQ0LTAuMDktMS44ODNjLTAuMjctMC41MzctMi40MzgtNS44MjUtMy4zNC03Ljk3NyAgIGMtMC45MDItMi4xNS0xLjgwMy0xLjc5Mi0yLjQzNi0xLjc5MmMtMC42MzEsMC0xLjM1NC0wLjA5LTIuMDc2LTAuMDljLTAuNzIyLDAtMS44OTYsMC4yNjktMi44ODksMS4zNDQgICBjLTAuOTkyLDEuMDc2LTMuNzg5LDMuNjc2LTMuNzg5LDguOTYzYzAsNS4yODgsMy44NzksMTAuMzk3LDQuNDIyLDExLjExM2MwLjU0MSwwLjcxNiw3LjQ5LDExLjkyLDE4LjUsMTYuMjIzICAgQzU4LjIsNjUuNzcxLDU4LjIsNjQuMzM2LDYwLjE4Niw2NC4xNTZjMS45ODQtMC4xNzksNi40MDYtMi41OTksNy4zMTItNS4xMDdDNjguMzk4LDU2LjUzNyw2OC4zOTgsNTQuMzg2LDY4LjEyOSw1My45Mzh6IiBmaWxsPSIjRkZGRkZGIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" /></a>
                                    <a class="img-rounded"  style="background-color: #daa520;"  href="https://www.instagram.com/uplinksbiz" target="_blank"><i class="ti-instagram"></i></a>
                                    <a class="img-rounded"  style="background-color: #daa520;"  href="https://www.twitter.com/uplinksbiz" target="_blank"><i class="ti-twitter"></i></a>
                                    <a class="img-rounded"  style="background-color: #daa520;"  href="http://www.youtube.com/playlist?list=PLTDwP0gFbqmzgIUibwJvDExpCb0HgXwPT" target="_blank"><i class="ti-youtube"></i></a>
                                </p>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
            <div id="forgetpass" style="display:none; margin-top:50px;"
                 class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">FORGOT PASSWORD</div>
                    </div>

                    <div style="padding-top:30px" class="panel-body">

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                        <form id="forgetpassform" class="form-horizontal" role="form" method="POST" autocomplete="off">

                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input id="forgot_email" type="text" class="form-control" name="forgot_email" value=""
                                       placeholder="Your Email">
                                       <br/><label class="error_msg"><?php echo $error_email ?></label>
                            </div>

                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="forgot_username" type="text" class="form-control" name="forgot_username"
                                       placeholder="Your Username">
                                       <br/><label class="error_username"><?php echo $error_username ?></label>
                            </div>

                            <div style="margin-top:10px" class="form-group">
                                <!-- Button -->
                                <div class="col-sm-8 col-sm-offset-2 controls">
                                    <input type="submit" id="btn-login" value="Send" class="btn btn-block my-btn"
                                           name="retrieve_pass">
                                           
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-12 control">
                                    <div style="border-top: 1px solid #888; padding-top:15px; font-size:85%">
                                        Don't have an account!
                                        <a href="#" onClick="$('#loginbox').hide(); $('#forgetpass').hide(); $('#signupbox').show()">
                                            <strong>&nbsp;Sign Up Here</strong>
                                        </a>
                                    </div>
                                    <div style="padding-top:15px; font-size:85%">
                                        I already have an account!
                                        <a href="#" onClick="$('#signupbox').hide(); $('#forgetpass').hide(); $('#loginbox').show()">
                                            <strong>&nbsp; Sign In Here</strong>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </form>


                    </div>
                </div>
            </div>
            <div id="signupbox" style="display:none; margin-top:50px"
                 class="mainbox col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">Sign Up</div>
                    </div>
                    <div class="panel-body">
                        <form id="signupform" class="form-horizontal" role="form" method="POST">

                            <div id="signupalert" style="display:none" class="alert alert-danger">
                                <p>Error:</p>
                                <span></span>
                            </div>

                            <div class="form-group">
                                <label for="firstname" class="col-md-3 control-label">First Name</label>
                                <div class="col-md-9">
                                    <input name="firstname" id="firstname" class="form-control"
                                           placeholder="Enter First Name" maxlength="50" value="<?=$firstname ?>" type="text">
                                </div>
                                <label class="error_msg text-left"><?php echo $error_firstName ?></label>
                            </div>
                            <div class="form-group">
                                <label for="lastname" class="col-md-3 control-label">Last Name</label>
                                <div class="col-md-9">
                                    <input name="lastname" id="lastname" class="form-control"
                                           placeholder="Enter Last Name" maxlength="50" value="<?=$lastname ?>" type="text">
                                </div>
                                <label class="error_msg text-left"><?php echo $error_lastname ?></label>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-md-3 control-label">Email</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="email" id="email" maxlength="40"
                                           placeholder="Email Address" value="<?=$email ?>">
                                </div>
                                <label class="error_msg"><?php echo $error_email ?></label>
                            </div>
                            <div class="form-group">
                                <label for="dob" class="col-md-3 control-label">Date Of Birth</label>
                                <div class="col-md-9">
                                    <input type="date" name="dob" id="dob" value="<?=$dob ?>" class="form-control">
                                </div>
                                <label class="error_msg"><?php echo $error_dob ?></label>
                                
                            </div>
                            <div class="form-group">
                                <label for="gender" class="col-md-3 control-label">Gender</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="gender" id="gender">
                                        <option value="">Select Gender</option>
                                        <option value="Male" <?php if ($gender == 'Male') echo 'selected' ?>>Male</option>
                                        <option value="Female" <?php if ($gender == 'Female') echo 'selected' ?>>Female</option>
                                    </select>
                                </div>
                                <label class="error_msg"><?php echo $error_gender ?></label>
                            </div>
                            <div class="form-group">
                                <label for="occupation" class="col-md-3 control-label">Occupation</label>
                                <div class="col-md-9">
                                    <input name="occupation" id="occupation" class="form-control"
                                           placeholder="Enter occupation" maxlength="50" value="<?=$occupation ?>" type="text">
                                </div>
                                <label class="error_msg"><?php echo $error_occupation ?></label>
                            </div>
                            <div class="form-group">
                                <label for="address" class="col-md-3 control-label">Address</label>
                                <div class="col-md-9">
                                    <input name="address" id="address" class="form-control" placeholder="Enter Address"
                                           maxlength="200" value="<?=$address ?>" type="text">
                                </div>
                                <label class="error_msg"><?php echo $error_address ?></label>
                            </div>
                            <div class="form-group">
                                <label for="country" class="col-md-3 control-label">Country</label>
                                <div class="col-md-9">
                                    <select name="country" id="Country" class="form-control" value="">
                                        <option value="">Select Country</option>
                                        <option value="Afghanistan">Afghanistan</option>
                                        <option value="Albania">Albania</option>
                                        <option value="Algeria">Algeria</option>
                                        <option value="American Samoa">American Samoa</option>
                                        <option value="Andorra">Andorra</option>
                                        <option value="Angola">Angola</option>
                                        <option value="Anguilla">Anguilla</option>
                                        <option value="Antartica">Antarctica</option>
                                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Armenia">Armenia</option>
                                        <option value="Aruba">Aruba</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Austria">Austria</option>
                                        <option value="Azerbaijan">Azerbaijan</option>
                                        <option value="Bahamas">Bahamas</option>
                                        <option value="Bahrain">Bahrain</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Barbados">Barbados</option>
                                        <option value="Belarus">Belarus</option>
                                        <option value="Belgium">Belgium</option>
                                        <option value="Belize">Belize</option>
                                        <option value="Benin">Benin</option>
                                        <option value="Bermuda">Bermuda</option>
                                        <option value="Bhutan">Bhutan</option>
                                        <option value="Bolivia">Bolivia</option>
                                        <option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
                                        <option value="Botswana">Botswana</option>
                                        <option value="Bouvet Island">Bouvet Island</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="British Indian Ocean Territory">British Indian Ocean Territory
                                        </option>
                                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                                        <option value="Bulgaria">Bulgaria</option>
                                        <option value="Burkina Faso">Burkina Faso</option>
                                        <option value="Burundi">Burundi</option>
                                        <option value="Cambodia">Cambodia</option>
                                        <option value="Cameroon">Cameroon</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Cape Verde">Cape Verde</option>
                                        <option value="Cayman Islands">Cayman Islands</option>
                                        <option value="Central African Republic">Central African Republic</option>
                                        <option value="Chad">Chad</option>
                                        <option value="Chile">Chile</option>
                                        <option value="China">China</option>
                                        <option value="Christmas Island">Christmas Island</option>
                                        <option value="Cocos Islands">Cocos (Keeling) Islands</option>
                                        <option value="Colombia">Colombia</option>
                                        <option value="Comoros">Comoros</option>
                                        <option value="Congo">Congo</option>
                                        <option value="Congo">Congo, the Democratic Republic of the</option>
                                        <option value="Cook Islands">Cook Islands</option>
                                        <option value="Costa Rica">Costa Rica</option>
                                        <option value="Cota D'Ivoire">Cote d'Ivoire</option>
                                        <option value="Croatia">Croatia (Hrvatska)</option>
                                        <option value="Cuba">Cuba</option>
                                        <option value="Cyprus">Cyprus</option>
                                        <option value="Czech Republic">Czech Republic</option>
                                        <option value="Denmark">Denmark</option>
                                        <option value="Djibouti">Djibouti</option>
                                        <option value="Dominica">Dominica</option>
                                        <option value="Dominican Republic">Dominican Republic</option>
                                        <option value="East Timor">East Timor</option>
                                        <option value="Ecuador">Ecuador</option>
                                        <option value="Egypt">Egypt</option>
                                        <option value="El Salvador">El Salvador</option>
                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                        <option value="Eritrea">Eritrea</option>
                                        <option value="Estonia">Estonia</option>
                                        <option value="Ethiopia">Ethiopia</option>
                                        <option value="Falkland Islands">Falkland Islands (Malvinas)</option>
                                        <option value="Faroe Islands">Faroe Islands</option>
                                        <option value="Fiji">Fiji</option>
                                        <option value="Finland">Finland</option>
                                        <option value="France">France</option>
                                        <option value="France Metropolitan">France, Metropolitan</option>
                                        <option value="French Guiana">French Guiana</option>
                                        <option value="French Polynesia">French Polynesia</option>
                                        <option value="French Southern Territories">French Southern Territories</option>
                                        <option value="Gabon">Gabon</option>
                                        <option value="Gambia">Gambia</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Gibraltar">Gibraltar</option>
                                        <option value="Greece">Greece</option>
                                        <option value="Greenland">Greenland</option>
                                        <option value="Grenada">Grenada</option>
                                        <option value="Guadeloupe">Guadeloupe</option>
                                        <option value="Guam">Guam</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Guinea">Guinea</option>
                                        <option value="Guinea-Bissau">Guinea-Bissau</option>
                                        <option value="Guyana">Guyana</option>
                                        <option value="Haiti">Haiti</option>
                                        <option value="Heard and McDonald Islands">Heard and Mc Donald Islands</option>
                                        <option value="Holy See">Holy See (Vatican City State)</option>
                                        <option value="Honduras">Honduras</option>
                                        <option value="Hong Kong">Hong Kong</option>
                                        <option value="Hungary">Hungary</option>
                                        <option value="Iceland">Iceland</option>
                                        <option value="India">India</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="Iran">Iran (Islamic Republic of)</option>
                                        <option value="Iraq">Iraq</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Jordan">Jordan</option>
                                        <option value="Kazakhstan">Kazakhstan</option>
                                        <option value="Kenya">Kenya</option>
                                        <option value="Kiribati">Kiribati</option>
                                        <option value="Democratic People's Republic of Korea">Korea, Democratic People's
                                            Republic of
                                        </option>
                                        <option value="Korea">Korea, Republic of</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                        <option value="Lao">Lao People's Democratic Republic</option>
                                        <option value="Latvia">Latvia</option>
                                        <option value="Lebanon">Lebanon</option>
                                        <option value="Lesotho">Lesotho</option>
                                        <option value="Liberia">Liberia</option>
                                        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Lithuania">Lithuania</option>
                                        <option value="Luxembourg">Luxembourg</option>
                                        <option value="Macau">Macau</option>
                                        <option value="Macedonia">Macedonia, The Former Yugoslav Republic of</option>
                                        <option value="Madagascar">Madagascar</option>
                                        <option value="Malawi">Malawi</option>
                                        <option value="Malaysia">Malaysia</option>
                                        <option value="Maldives">Maldives</option>
                                        <option value="Mali">Mali</option>
                                        <option value="Malta">Malta</option>
                                        <option value="Marshall Islands">Marshall Islands</option>
                                        <option value="Martinique">Martinique</option>
                                        <option value="Mauritania">Mauritania</option>
                                        <option value="Mauritius">Mauritius</option>
                                        <option value="Mayotte">Mayotte</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Micronesia">Micronesia, Federated States of</option>
                                        <option value="Moldova">Moldova, Republic of</option>
                                        <option value="Monaco">Monaco</option>
                                        <option value="Mongolia">Mongolia</option>
                                        <option value="Montserrat">Montserrat</option>
                                        <option value="Morocco">Morocco</option>
                                        <option value="Mozambique">Mozambique</option>
                                        <option value="Myanmar">Myanmar</option>
                                        <option value="Namibia">Namibia</option>
                                        <option value="Nauru">Nauru</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Netherlands">Netherlands</option>
                                        <option value="Netherlands Antilles">Netherlands Antilles</option>
                                        <option value="New Caledonia">New Caledonia</option>
                                        <option value="New Zealand">New Zealand</option>
                                        <option value="Nicaragua">Nicaragua</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Nigeria">Nigeria</option>
                                        <option value="Niue">Niue</option>
                                        <option value="Norfolk Island">Norfolk Island</option>
                                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                        <option value="Norway">Norway</option>
                                        <option value="Oman">Oman</option>
                                        <option value="Pakistan">Pakistan</option>
                                        <option value="Palau">Palau</option>
                                        <option value="Panama">Panama</option>
                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                        <option value="Paraguay">Paraguay</option>
                                        <option value="Peru">Peru</option>
                                        <option value="Philippines">Philippines</option>
                                        <option value="Pitcairn">Pitcairn</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Puerto Rico">Puerto Rico</option>
                                        <option value="Qatar">Qatar</option>
                                        <option value="Reunion">Reunion</option>
                                        <option value="Romania">Romania</option>
                                        <option value="Russia">Russian Federation</option>
                                        <option value="Rwanda">Rwanda</option>
                                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                        <option value="Saint LUCIA">Saint LUCIA</option>
                                        <option value="Saint Vincent">Saint Vincent and the Grenadines</option>
                                        <option value="Samoa">Samoa</option>
                                        <option value="San Marino">San Marino</option>
                                        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Seychelles">Seychelles</option>
                                        <option value="Sierra">Sierra Leone</option>
                                        <option value="Singapore">Singapore</option>
                                        <option value="Slovakia">Slovakia (Slovak Republic)</option>
                                        <option value="Slovenia">Slovenia</option>
                                        <option value="Solomon Islands">Solomon Islands</option>
                                        <option value="Somalia">Somalia</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="South Georgia">South Georgia and the South Sandwich Islands
                                        </option>
                                        <option value="Span">Spain</option>
                                        <option value="SriLanka">Sri Lanka</option>
                                        <option value="St. Helena">St. Helena</option>
                                        <option value="St. Pierre and Miguelon">St. Pierre and Miquelon</option>
                                        <option value="Sudan">Sudan</option>
                                        <option value="Suriname">Suriname</option>
                                        <option value="Svalbard">Svalbard and Jan Mayen Islands</option>
                                        <option value="Swaziland">Swaziland</option>
                                        <option value="Sweden">Sweden</option>
                                        <option value="Switzerland">Switzerland</option>
                                        <option value="Syria">Syrian Arab Republic</option>
                                        <option value="Taiwan">Taiwan, Province of China</option>
                                        <option value="Tajikistan">Tajikistan</option>
                                        <option value="Tanzania">Tanzania, United Republic of</option>
                                        <option value="Thailand">Thailand</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Tokelau">Tokelau</option>
                                        <option value="Tonga">Tonga</option>
                                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                        <option value="Tunisia">Tunisia</option>
                                        <option value="Turkey">Turkey</option>
                                        <option value="Turkmenistan">Turkmenistan</option>
                                        <option value="Turks and Caicos">Turks and Caicos Islands</option>
                                        <option value="Tuvalu">Tuvalu</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="United States">United States</option>
                                        <option value="United States Minor Outlying Islands">United States Minor
                                            Outlying Islands
                                        </option>
                                        <option value="Uruguay">Uruguay</option>
                                        <option value="Uzbekistan">Uzbekistan</option>
                                        <option value="Vanuatu">Vanuatu</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Vietnam">Viet Nam</option>
                                        <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                                        <option value="Virgin Islands (U.S)">Virgin Islands (U.S.)</option>
                                        <option value="Wallis and Futana Islands">Wallis and Futuna Islands</option>
                                        <option value="Western Sahara">Western Sahara</option>
                                        <option value="Yemen">Yemen</option>
                                        <option value="Yugoslavia">Yugoslavia</option>
                                        <option value="Zambia">Zambia</option>
                                        <option value="Zimbabwe">Zimbabwe</option>
                                    </select>
                                </div>
                                <label class="error_msg"><?php echo $error_country ?></label>
                            </div>
                            <div class="form-group">
                                <label for="state" class="col-md-3 control-label">State</label>
                                <div class="col-md-9">
                                    <input name="state" id="state" class="form-control" placeholder="Enter State"
                                           maxlength="50" value="<?=$state ?>" type="text">
                                </div>
                                <label class="error_msg"><?php echo $error_state ?></label>
                            </div>
                            <div class="form-group">
                                <label for="city" class="col-md-3 control-label">City</label>
                                <div class="col-md-9">
                                    <input name="city" id="city" class="form-control" placeholder="Enter City"
                                           maxlength="50" value="<?=$city ?>" type="text">
                                </div>
                                <label class="error_msg"><?php echo $error_city ?></label>
                            </div>

                            <div class="form-group">
                                <label for="phone" class="col-md-3 control-label">Phone</label>
                                <div class="col-md-9">
                                    <input name="phone" class="form-control" placeholder="Enter phone number"
                                           maxlength="50" value="<?=$phone ?>" type="text">
                                </div>
                                <label class="error_msg"><?php echo $error_phone ?></label>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-md-3 control-label">Username</label>
                                <div class="col-md-9">
                                    <input name="username" class="form-control" placeholder="Enter Username"
                                           maxlength="50" value="<?=$username ?>" type="text">
                                </div>
                                <label class="error_msg"><?php echo $error_username ?></label>
                            </div>

                            <div class="form-group">
                                <label for="pass" class="col-md-3 control-label">Password</label>
                                <div class="col-md-9">
                                    <input name="pass" class="form-control" placeholder="Enter Password" maxlength="15"
                                           type="password">
                                </div>
                                <label class="error_msg"><?php echo $error_pass ?></label>
                            </div>
                            <div class="form-group">
                                <label for="pass" class="col-md-3 control-label">Confirm Password</label>
                                <div class="col-md-9">
                                    <input name="pass2" class="form-control" placeholder="Confirm Password"
                                           maxlength="15" type="password">
                                </div>
                                <label class="error_msg"><?php echo $error_pass2 ?></label>
                            </div>


                            <hr>
                            <h3 style="color:red;" class="text-left">Account Information</h3>
                            <div class="form-group">
                                <label for="bankname" class="col-md-3 control-label">Bank Name</label>
                                <div class="col-md-9">
                                    <input name="bankname" id="bankname" class="form-control"
                                           placeholder="Enter Name of Bank" maxlength="50" value="<?=$bankname ?>" type="text">
                                </div>
                                <label class="error_msg"><?php echo $error_bankname ?></label>
                            </div>

                            <div class="form-group">
                                <label for="accname" class="col-md-3 control-label">Account Name</label>
                                <div class="col-md-9">
                                    <input name="accname" class="form-control" placeholder="Enter Account Name"
                                           maxlength="50" value="<?=$accname ?>" type="text">
                                </div>
                                <label class="error_msg"><?php echo $error_accname ?></label>
                            </div>

                            <div class="form-group">
                                <label for="accno" class="col-md-3 control-label">Account Number</label>
                                <div class="col-md-9">
                                    <input name="accno" class="form-control" placeholder="Enter Account Number"
                                           maxlength="50" value="<?=$accno ?>" type="text">
                                </div>
                                <label class="error_msg"><?php echo $error_accno ?></label>
                            </div>

                            <hr>
                            <h3 style="color:red;" class="text-left">Account to debit</h3>

                            <div class="form-group">
                                <label for="ref_username" class="col-md-3 control-label">Ref Username</label>
                                <div class="col-md-8">
                                    <input name="ref_username" id="ref_username" class="form-control"
                                           placeholder="Enter Referrer Username" maxlength="50" value="<?=$ref_username ?>" type="text">
                                </div>
                                <div class="col-md-1" style="padding-top: 10px; padding-left: 0px">
                                    <span id="referer_success" class="glyphicon glyphicon-ok success" style="color: rgba(46,148,15,0.99); display: none"></span>
                                    <span class="glyphicon glyphicon-remove referer_error" style="color: red; display: none;"></span>
                                </div>
                                <label class="error_msg"><?php echo $error_ref_username ?></label>
                            </div>
                            <div class="form-group">
                                <label for="a" class="col-md-3 control-label">&nbsp;</label>
                                <div class="col-md-9">
                                    <label id="referer_msg" style="color: rgba(46,148,15,0.99); font-weight: bold"></label>
                                    <label class="referer_error" style="color: red; font-weight: bold; display: none">Username does not exist</label>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top:30px">
                                <!-- Button -->
                                <div class="col-md-offset-2 col-md-8">
                                    <button id="btn-signup" type="submit" class="btn btn-info btn-block my-btn"
                                            name="register"><i
                                                class="icon-hand-right"></i> &nbsp Sign Up
                                    </button>
                                    <!--input type="submit" name="register" value="Signup" class=""-->

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12 control">
                                    <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%">
                                        I already have an account!
                                        <a href="#" onClick="$('#signupbox').hide(); $('#loginbox').show()">
                                            <strong>&nbsp; Sign In Here</strong>
                                        </a>
                                    </div>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>


            </div>
        </div>


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="User%20Back%20Office%20Login%20Panel_files/jquery-1.js"></script>
        <script src="User%20Back%20Office%20Login%20Panel_files/bootstrap.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="User%20Back%20Office%20Login%20Panel_files/jquery.js"></script>
        <script src="User%20Back%20Office%20Login%20Panel_files/login.js"></script>
        <script>
            // Returns a function, that, as long as it continues to be invoked, will not
            // be triggered. The function will be called after it stops being called for
            // N milliseconds. If `immediate` is passed, trigger the function on the
            // leading edge, instead of the trailing.
            function debounce(func, wait, immediate) {
                var timeout;
                return function() {
                    var context = this, args = arguments;
                    var later = function() {
                        timeout = null;
                        if (!immediate) func.apply(context, args);
                    };
                    var callNow = immediate && !timeout;
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                    if (callNow) func.apply(context, args);
                };
            };

            //check if referrer username
            var myEfficientFn = debounce(function() {
                let username = $('#ref_username').val();
                $.post("includes/getuser.php", { username: username}, function(data){
                    if(data == 0){
                        $('#referer_success').hide();
                        $('.referer_error').show();
                        $('#referer_msg').html('');
                    }
                    else{
                        $('#referer_msg').html(data);
                        $('.referer_error').hide();
                        $('#referer_success').show();
                    }

                });
            }, 1000);

            $('#ref_username').on('focusout', myEfficientFn);


            $('#ref_username').on('focus', function(){
                $('#referer_success').hide();
                $('.referer_error').hide();
                $('#referer_msg').html('');
            });

            $('#dob').datepicker({
                format: 'd/M/yyyy'
            });
        </script>

    </div>

<?php if (isset($_POST['login'])) { ?>
   <script>
       $('#signupbox').hide(); $('#loginbox').show()
   </script>
<?php } if (isset($_POST['register'])) { ?>
    <script>
       $('#signupbox').show(); $('#loginbox').hide()
   </script>
<?php } ?>
?>

    </body>
    </html>
<?php ob_end_flush(); ?>