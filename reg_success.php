<?php

if (isset($_POST['register'])) {

    //declarations
    $registration_charge = 40;

    // prevent sql injections/ clear user invalid inputs
    $referer = htmlspecialchars(strip_tags(trim($_POST['ref_username'])));
    

    $firstname = htmlspecialchars(strip_tags(trim($_POST['firstname'])));
    $lastname = htmlspecialchars(strip_tags(trim($_POST['lastname'])));
    $address = htmlspecialchars(strip_tags(trim($_POST['address'])));

    $country = htmlspecialchars(strip_tags(trim($_POST['country'])));
    $state = htmlspecialchars(strip_tags(trim($_POST['state'])));
    $city = htmlspecialchars(strip_tags(trim($_POST['city'])));

    $phone = htmlspecialchars(strip_tags(trim($_POST['phone'])));
    $dob = htmlspecialchars(strip_tags(trim($_POST['dob'])));
    $gender = htmlspecialchars(strip_tags(trim($_POST['gender'])));
    // $superior_id = htmlspecialchars(strip_tags(trim($_POST['superior_id'])));
    // $occupation = htmlspecialchars(strip_tags(trim($_POST['occupation'])));
    
    $username = htmlspecialchars(strip_tags(trim($_POST['username'])));
    $email = htmlspecialchars(strip_tags(trim($_POST['email'])));
    $pass = htmlspecialchars(strip_tags(trim($_POST['pass'])));
    $pass2 = htmlspecialchars(strip_tags(trim($_POST['pass2'])));
    $tran_pass = htmlspecialchars(strip_tags(trim($_POST['tran_pass'])));
    $tran_pass2 = htmlspecialchars(strip_tags(trim($_POST['tran_pass2'])));
    
    $payer_username = htmlspecialchars(strip_tags(trim($_POST['payer_username'])));
    $payer_pass = htmlspecialchars(strip_tags(trim($_POST['payer_pass'])));
    $payer_tran_pass = htmlspecialchars(strip_tags(trim($_POST['payer_tran_pass'])));
    

    // $bankname = htmlspecialchars(strip_tags(trim($_POST['bankname'])));
    // $accname = htmlspecialchars(strip_tags(trim($_POST['accname'])));
    // $accno = htmlspecialchars(strip_tags(trim($_POST['accno'])));
    // $ref_username = htmlspecialchars(strip_tags(trim($_POST['ref_username'])));

    //checking for errors
    require_once 'dbconnect.php';

    if (empty($referer)) { 
        $error = true; 
        $error_referer = "Please enter your referer username."; 
    } else {
        $res = mysqli_query($dbc, "SELECT * FROM user_table WHERE userName='$referer'");
        $row = mysqli_fetch_array($res);
        $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
        $referer_id = '';
        if ($count == 1) {
            $referer_id = $row['myid'];
        } else {
            $error = true; $error_referer = "Please enter a correct referer id.";
        }
    }

    if (empty($firstname)) { 
        $error = true; 
        $error_firstName = "Please enter your Firstname."; 
    }
    if (empty($lastname)) { 
        $error = true; $error_lastname = "Please enter your Lastname."; 
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
    if ($gender == "") { 
        $error = true; $error_gender = "Please enter your Gender."; 
    }

    if (empty($phone)) { 
        $error = true; $error_phone = "Please enter your Phone Number."; 
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

    
    if (empty($username)) { 
        $error = true; $error_username = "Please enter your Username."; 
    }
    if (empty($email)) { 
        $error = true; $error_email = "Please enter your Email."; 
    }
    if (empty($pass)) { 
        $error = true; $error_pass = "Please enter your password."; 
    }
    if (empty($pass2)) { 
        $error = true; $error_pass2 = "Please enter the confirmation password."; 
    }

    if (!empty($pass) && !empty($pass2) && $pass != $pass2) {
        $error = true;
        $error_pass2 = "Please re enter your the same password.";
    }

    if (empty($tran_pass)) { 
        $error = true; $error_tran_pass = "Please enter your transaction password."; 
    }
    if (empty($tran_pass2)) { 
        $error = true; $error_tran_pass2 = "Please enter the confirmation transaction password."; 
    }

    if (!empty($tran_pass) && !empty($tran_pass2) && $tran_pass != $tran_pass2) {
        $error = true;
        $error_tran_pass2 = "Please re enter the same transaction password.";
    }


    if (empty($payer_username)) { 
        $error = true; $error_payer_username = "Please enter the Payer Username."; 
    }
    if (empty($payer_pass)) { 
        $error = true; $error_payer_pass = "Please enter the Payer password."; 
    }

    if (empty($payer_tran_pass)) { 
        $error = true; $error_payer_tran_pass = "Please enter the transaction Payer password."; 
    }


    // if (empty($bankname)) { 
    //     $error = true; $error_bankname = "Please enter your Bank Name."; 
    // }
    // if (empty($accname)) { 
    //     $error = true; $error_accname = "Please enter your Account Name."; 
    // }
    // if (empty($accno)) { 
    //     $error = true; $error_accno = "Please enter your Account Number."; 
    // }
    // if (empty($ref_username)) { 
    //     $error = true; $error_ref_username = "Please enter your Referer Username."; 
    // }
        

    if (!$error) {
        //get the balance of the payer and confirm if its greater than $40
        $res = mysqli_query($dbc, "SELECT * FROM user_table WHERE userName='$payer_username'");
        $row = mysqli_fetch_array($res);
        $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row

        if ($count == 1 && $row['password'] == hash('sha256', $payer_pass) && $row['t_password'] == hash('sha256', $payer_tran_pass)) {
            $payer_id = $row['myid'];
            $res2 = mysqli_query($dbc, "SELECT * FROM user_rank WHERE myid='$payer_id'");
            $row2 = mysqli_fetch_array($res2);
            $count2 = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
            // echo mysqli_error($dbc);

            if ($count2 == 1 && $row2['balance'] >= $registration_charge ) {

                //deduct 40 dollars from the balance
                $balance = $row2['balance'] - $registration_charge;
                $sql = "UPDATE user_rank SET balance='$balance' WHERE myid='$payer_id'";

                if (mysqli_query($dbc, $sql)) {
                    //register new user
                    $password = hash('sha256', $pass);
                    $added = date("Y-m-d h:i:s a");
                    $myId = uniqid(). '-' . uniqid();
                    // $myId = uniqid(). '-' . md5(uniqid(mt_rand(), true).microtime(true));

                    $sql = "INSERT INTO user_table (userName, firstName, lastName, gender, occupation, dob, country, address, city, state, zipcode, phoneNo, email, password, myid, superior_id) 
                            VALUES ('$username', '$firstname', '$lastname', '$gender', '$occupation', '$dob', '$country', '$address', '$city', '$state', '$zipcode', '$phone', '$email', '$password', '$myId', '$referer_id')";
                     
                    if (mysqli_query($dbc, $sql)) {
                        //add to user_rank table
                        $sql2 = "INSERT INTO user_rank (email, myid, superior_id, status) VALUES ('$email', '$myId', '$referer_id', 'paid')";
                        if (mysqli_query($dbc, $sql2)) {                            
                            $top_success = "Registration successful.";
                        } else {
                            $top_error = "Error occur during registration";
                        } 
                        //$top_success = "Registration successful.";
                    } else {
                        $top_error = "Error occur during registration 2";
                    }
                } else {
                    $error = true;
                    $top_error = "Payment Transaction not successful."; 
                }
            } else {
                $error = true; 
                $top_error = "The payer does not have sufficient balance to complete this tansaction."; 
            }

        } else {
            $error = true; 
            $top_error = "The payer password or payer tansaction password in incorrect."; 
        }        
    }
    else {
        $top_error = "Fill all the required fields";
    }

    // close connection
    mysqli_close($dbc);
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
<style>
    /* Latest compiled and minified CSS included as External Resource*/

/* Optional theme */

/*@import url('//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css');*/
 body {
    margin-top:30px;
}
.stepwizard-step p {
    margin-top: 0px;
    color:#666;
}
.stepwizard-row {
    display: table-row;
}
.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}
.stepwizard-step button[disabled] {
    /*opacity: 1 !important;
    filter: alpha(opacity=100) !important;*/
}
.stepwizard .btn.disabled, .stepwizard .btn[disabled], .stepwizard fieldset[disabled] .btn {
    opacity:1 !important;
    color:#bbb;
}
.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content:" ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-index: 0;
}
.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}
.btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
}
.panel-heading {
    color: white;
    background-color: #daa520 !important;
}
</style>
 
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    </head>

    <body class="login-page">
    <div class="animsition" style="animation-duration: 1.5s; opacity: 1;  margin-bottom: 100px">

        <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default" style="margin-top:30px;">
                    <div class="panel-body" style="padding: 100px 10px;">
                        <div class="text-center">
                                <i class="glyphicon glyphicon-ok text-success" style="font-size: 14em"></i>
                                <div class="text-bold" style="font-size: 2.5em; margin-bottom: 30px;"> Your registration was Successfull.</div>
                                <a class="btn btn-success" href="index.php">Go to Login page</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
   
</body>
</html>
