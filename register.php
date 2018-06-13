<?php

$firstname = '';
$error_firstName = '';
$lastname = '';
$error_lastname = '';
$address = '';
$error_address = '';
$country = '';
$error_country = '';
$state = '';
$error_state = '';
$city = '';
$error_city = '';
$phone = '';
$error_phone = '';
$dob = '';
$error_dob = '';
$gender = '';
$error_gender = '';
$superior_id = '';  // this is the id of the parent of the registering user
$error_superior_id = '';
// $occupation = htmlspecialchars(strip_tags(trim($_POST['occupation'])));
$username = '';
$error_username = '';
$email = '';
$error_email = '';
$pass = '';
$error_pass = '';
$pass2 = '';
$error_pass2 = '';
$tran_pass = '';
$tran_pass2 = '';
$payer_username = '';
$payer_pass = '';
$payer_tran_pass = '';
$error_payer_tran_pass = '';

if (isset($_POST['register'])) {

    /**
     * To work on this page, you need to have a goo knowledge og laravel eleoquent
     * This page was modified to use eloquent for easier management
     */

    require_once 'app/init.php';
    require_once 'includes/Payer.php';

    $user = new User();
    $payer = new Payer();

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
     $superior_id = htmlspecialchars(strip_tags(trim($_POST['superior_id'])));  // this is the id of the parent of the registering user
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
//    require_once 'dbconnect.php';

    if (empty($referer)) { 
        $error = true; 
        $error_referer = "Please enter your referer username."; 
    }
    else {
        $referer_id = '';

        // check if the referrer exist
        $ref = User::where('userName', $referer)->first();
        if($ref){
            $referer_id = $ref->myid;
        }
        else {
            $error = true;
            $error_referer = "Please enter a correct referer id.";
        }

//        $res = mysqli_query($dbc, "//SELECT * FROM user_table WHERE userName='$referer'");
//        $row = mysqli_fetch_array($res);
//        $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
//        $referer_id = '';
//        if ($count == 1) {
//            $referer_id = $row['myid'];
//        } else {
//            $error = true; $error_referer = "Please enter a correct referer id.";
//        }
    }

    if (empty($firstname)) { 
        $error = true; 
        $error_firstName = "Please enter your Firstname."; 
    }
    if (empty($lastname)) { 
        $error = true;
        $error_lastname = "Please enter your Lastname.";
    }
    if (empty($address)) { 
        $error = true;
        $error_address = "Please enter your Address.";
    }
    if ($country == "") { 
        $error = true;
        $error_country = "Please enter your Country.";
    }
    if (empty($city)) { 
        $error = true;
        $error_city = "Please enter your City.";
    }
    if (empty($state)) { 
        $error = true;
        $error_state = "Please enter your State.";
    }
    if ($gender == "") { 
        $error = true;
        $error_gender = "Please enter your Gender.";
    }

    if (empty($phone)) { 
        $error = true;
        $error_phone = "Please enter your Phone Number.";
    }
    
    if (empty($dob)) { 
        $error = true;
        $error_dob = "Please enter your Date of Birth.";
    }

     if (empty($superior_id)) {
         $error = true;
         $error_superior_id = "Please enter your referer id.";
     }
     else {
         $superior_id = '';

         // check if the referrer exist
         $sup = User::where('userName', $ref_username)->first();
         if($ref){
             $superior_id = $sup->myid;
         }
         else {
             $error = true;
             $error_superior_id = "Please enter a correct referer id.";
         }
     }

    
    if (empty($username)) { 
        $error = true;
        $error_username = "Please enter your Username.";
    }
    if (empty($email)) { 
        $error = true;
        $error_email = "Please enter your Email.";
    }
    if (empty($pass)) { 
        $error = true;
        $error_pass = "Please enter your password.";
    }
    if (empty($pass2)) { 
        $error = true;
        $error_pass2 = "Please enter the confirmation password.";
    }

    if (!empty($pass) && !empty($pass2) && $pass != $pass2) {
        $error = true;
        $error_pass2 = "Please re enter your the same password.";
    }

    if (empty($tran_pass)) { 
        $error = true;
        $error_tran_pass = "Please enter your transaction password.";
    }
    if (empty($tran_pass2)) { 
        $error = true;
        $error_tran_pass2 = "Please enter the confirmation transaction password.";
    }

    if (!empty($tran_pass) && !empty($tran_pass2) && $tran_pass != $tran_pass2) {
        $error = true;
        $error_tran_pass2 = "Please re enter the same transaction password.";
    }


    if (empty($payer_username)) { 
        $error = true;
        $error_payer_username = "Please enter the Payer Username.";
    }
    if (empty($payer_pass)) { 
        $error = true;
        $error_payer_pass = "Please enter the Payer password.";
    }

    if (empty($payer_tran_pass)) { 
        $error = true;
        $error_payer_tran_pass = "Please enter the transaction Payer password.";
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
        //confirmed the payer informations
        $res = User::where('userName', $payer_username)->first();

        if($res && $res->password == hash('sha256', $payer_pass) && $res->t_password == hash('sha256', $payer_tran_pass)) {

            // get the payer id
            $payer_id = $res->myid;

            // check if the payer has enough balance to pay for the registration
            $hasEnoughCash = $payer->userRegFinancialStatus($payer_id);

            if($hasEnoughCash) {

                // Make registration payment
                $payed = $payer->payRegistration($payer_id);

                if($payed) { //if payment successful
                    //register new user
                    $password = hash('sha256', $pass);
                    $added = date("Y-m-d h:i:s a");

                    // todo:: change the mode of the $myId to md5($username . $added)
                    $myId = uniqid(). '-' . uniqid();

                    // insert user record on the user_ table
                    $_usertable  = User::create([
                            'myid' => $myId,
                            'superior_id' => $superior_id,
                            'userName' => $username,
                            'firstName' => $firstname,
                            'lastName' => $lastname,
                            'gender' => $gender,
//                            'occupation' => $occupation,
                            'dob' => $dob,
                            'country' => $country,
                            'address' => $address,
                            'city' => $city,
                            'state' => $state,
                            'zipcode' => $zipcode,
                            'phoneNo' => $phone,
                            'email' => $email,
                            'password' => $password,
                    ]);

                    // attach the user id to the referrer ar a reffered

                    $refferedIds = ['desc_1', 'desc_2', 'desc_3', 'desc_4', 'desc_5', 'desc_6'];
                    $_user = User_rank::where('myid', $referer_id)->first();

                    for($i = 0; $i < sizeof($refferedIds); $i++){
                         // get the first column of there reffered memebers that is null, and insert the user id in it
                        if($_user[$refferedIds[$i]] == null){
                            User_rank::where('myid', $referer_id)->update([$refferedIds[$i] => $myId]);
                            break;
                        }
                    }


                    if($_usertable) { // if user record created successfully
                       $user_rank = User_rank::create([
                            'myid' => $myId,
                            'email' => $email,
                            'superior_id' => $superior_id,
                            'status' => 'paid',
                        ]);

                        // create the user information on the stage / payment table
                        $stages_payment = Stages_payment::create(['user_id' => $myId]);

                        if($user_rank && $stages_payment) {
                            header("Location: reg_success.php");
                        }
                        else {
                            $top_error = "Error occur during registration";
                        }
                    }
                    else {
                        $top_error = "Error occur during registration 2";
                    }

                }
                else {
                    $error = true;
                    $top_error = "Payment Transaction not successful.";
                }
            }
            else {
                $error = true;
                $top_error = "The payer does not have sufficient balance to complete this tansaction.";
            }
        }
        else {
            $error = true;
            $top_error = "The payer password or payer tansaction password in incorrect.";
        }

    }
    else {
        $top_error = "Fill all the required fields";
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
 <!-- base css -->
 <script src="assets/jquery-1.11.3-jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    </head>

    <body class="login-page">
    <div class="animsition" style="animation-duration: 1.5s; opacity: 1;  margin-bottom: 100px">

        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-md-offset-3 text-center" style="height: 80px; margin-top: 50px; margin-bottom: 80px">
                    <img src="dashboard_files/logo-inverse.png" class="big-logo" style="width:250px;">
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title" style="">Register</div>
                </div>
                <div style="padding-top:30px" class="panel-body">
            
            <div class="row">
                <div class="col-sm-10">
                        <?php //if ($top_success) { ?>
<!--                        <div class="alert alert-success alert-dismissable">-->
<!--                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
<!--                            <h4><i class="icon fa fa-info"></i> Success!</h4>-->
<!--                            <h3>Registration Successful</h3>-->
<!--                        </div>-->
                    <?php
//                    }
//                    if ($top_error) {
//                    ?>
<!--                    <div class="alert alert-error alert-dismissable">-->
<!--                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
<!--                        <h4><i class="icon fa fa-info"></i> Alert!</h4>-->
<!--                        <h3>--><?php //echo $top_error ?><!--</h3>-->
<!--                    <!--h3>An Error occur during registration</h3-->-->
<!--                    </div>-->
<?php //} ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-10 col-md-offset-1">
                <div class="stepwizard" style="margin-top: 50px;">
                <div class="stepwizard-row setup-panel">
                    <div class="stepwizard-step col-xs-3"> 
                        <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                        <p><small>Sponsor Details</small></p>
                    </div>
                    <div class="stepwizard-step col-xs-3"> 
                        <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                        <p><small>Registration Details</small></p>
                    </div>
                    <div class="stepwizard-step col-xs-3"> 
                        <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                        <p><small>Security Informations</small></p>
                    </div>
                    <div class="stepwizard-step col-xs-3"> 
                        <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
                        <p><small>Payment Details</small></p>
                    </div>
                </div>
            </div>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" id="FormID">
                <div class="panel panel-primary setup-content" id="step-1">
                    <div class="panel-heading">
                        <h3 class="panel-title">Sponsor Details</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label col-md-10"><h3>Sponsor info</h3></label>
                            <label class="control-label col-md-10"><small style=""><strong>Please enter your Sponsor info</strong></small></label>
                            <div class="col-md-11">
                                <input type="text" required="required" name="ref_username" id="ref_username" class="form-control"
                                        placeholder="Enter Referrer Username" maxlength="50" value="">
                            </div>
                            <div class="col-md-1" style="padding-top: 10px; padding-left: 0px">
                                <span id="referer_success" class="glyphicon glyphicon-ok success" style="color: rgba(46,148,15,0.99); display: none"></span>
                                <span class="glyphicon glyphicon-remove referer_error" style="color: red; display: none;"></span>
                            </div>
                            <label class="error_msg"><?php //echo $error_ref_username ?></label>
                        </div>
                        <div class="form-group">
                            <br/>
                            <label class="col-md-12" id="referer_msg" style="color: rgba(46,148,15,0.99); font-weight: bold"></label>
                            <label class="col-md-12 referer_error" style="color: red; font-weight: bold; display: none">Username does not exist</label>
                        
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-10"><h3>Superior User</h3></label>
                            <label class="control-label col-md-10"><small style=""><strong>Please enter your Superior Username</strong></small></label>
                            <div class="col-md-11">
                                <input type="text" required="required" name="superior_id" id="superior_id" class="form-control"
                                       placeholder="Enter Superior Username" maxlength="50" value="">
                            </div>
                            <div class="col-md-1" style="padding-top: 10px; padding-left: 0px">
                                <span id="superior_success" class="glyphicon glyphicon-ok success" style="color: rgba(46,148,15,0.99); display: none"></span>
                                <span class="glyphicon glyphicon-remove superior_error" style="color: red; display: none;"></span>
                            </div>
                            <label class="error_msg"><?php echo $error_superior_id ?></label>
                        </div>
                        <div class="form-group">
                            <br/>
                            <label class="col-md-12" id="superior_msg" style="color: rgba(46,148,15,0.99); font-weight: bold"></label>
                            <label class="col-md-12 superior_error" style="color: red; font-weight: bold; display: none">Username does not exist</label>

                        </div>
                        <br><br><br>
                        <div class="form-group text-center" style="margin-top: 20px;">
                            <button class="btn btn-primary prevBtn pull-left disabled" type="button">Prev</button>
                            <button class="btn btn-primary nextBtn pull-right disabled" id="nextBtn1" type="button">Next</button>
                        </div>
                        
                    </div>
                </div>
                
                <div class="panel panel-primary setup-content" id="step-2">
                    <div class="panel-heading">
                        <h3 class="panel-title">Registration Details</h3>
                    </div>
                    <div class="panel-body">
                    <div class="form-group">
                        <label for="firstname" class="col-md-12 control-label">First Name</label>
                        <div class="col-md-12">
                            <input name="firstname" required="required" id="firstname" class="form-control"
                                    placeholder="Enter First Name" maxlength="50" value="<?=($firstname) ? $firstname : "" ?>" type="text">
                        </div>
                        <label class="error_msg text-left"><?php echo ($error_firstName) ? $error_firstName : "" ?></label>
                    </div><br><br>
                    <div class="form-group ">
                        <label for="lastname" class="col-md-12 control-label">Last Name</label>
                        <div class="col-md-12">
                            <input name="lastname" required="required" id="lastname" class="form-control"
                                    placeholder="Enter Last Name" maxlength="50" value="<?=$lastname ?>" type="text">
                        </div>
                        <label class="error_msg text-left"><?php echo $error_lastname || "" ?></label>
                    </div><br><br>
                    <div class="form-group">
                        <label for="address" class="col-md-12 control-label">Address</label>
                        <div class="col-md-12">
                            <textarea name="address" required="required" id="address" class="form-control" placeholder="Enter Address"
                                    maxlength="200" value="<?=$address ?>"></textarea>
                        </div>
                        <label class="error_msg"><?php echo $error_address || "" ?></label>
                    </div><br><br><br><br>
                    <div>
                    <div class="form-group col-md-4">
                        <label for="country" class="col-md-12 control-label">Country</label>
                        <div class="col-md-12">
                            <select name="country" required="required" id="Country" class="form-control" value="">
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
                    <div class="form-group col-md-4">
                        <label for="state" class="col-md-12 control-label">State</label>
                        <div class="col-md-12">
                            <input name="state" required="required" id="state" class="form-control" placeholder="Enter State"
                                    maxlength="50" value="<?=$state ?>" type="text">
                        </div>
                        <label class="error_msg"><?php echo $error_state ?></label>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="city" class="col-md-12 control-label">City</label>
                        <div class="col-md-12">
                            <input name="city" required="required" id="city" class="form-control" placeholder="Enter City"
                                    maxlength="50" value="<?=$city ?>" type="text">
                        </div>
                        <label class="error_msg"><?php echo $error_city ?></label>
                    </div>
                    </div><br><br>
                    <div>
                        <div class="form-group col-md-4">
                            <label for="dob" class="col-md-12 control-label">Date Of Birth</label>
                            <div class="col-md-12">
                                <input type="date" required="required" name="dob" id="dob" value="<?=$dob ?>" class="form-control">
                            </div>
                            <label class="error_msg"><?php echo $error_dob ?></label>
                            
                        </div>
                        <div class="form-group col-md-4">
                        <label for="gender" class="col-md-12 control-label">Gender</label>
                        <div class="col-md-12">
                            <select class="form-control" required="required" name="gender" id="gender">
                                <option value="">Select Gender</option>
                                <option value="Male" <?php if ($gender == 'Male') echo 'selected' ?>>Male</option>
                                <option value="Female" <?php if ($gender == 'Female') echo 'selected' ?>>Female</option>
                            </select>
                        </div>
                        <label class="error_msg"><?php echo $error_gender ?></label>
                        </div>
                        <div class="form-group col-md-4">
                        <label for="phone" class="col-md-12 control-label">Phone</label>
                        <div class="col-md-12">
                            <input name="phone" required="required" class="form-control" placeholder="Enter phone number"
                                    maxlength="50" value="<?=$phone ?>" type="text">
                        </div>
                        <label class="error_msg"><?php echo $error_phone ?></label>
                    </div>
                    </div>
                    <br><br><br>
                        <div class="form-group text-center" style="margin-top: 20px;">
                            <button class="btn btn-primary prevBtn pull-left" type="button">Prev</button>
                            <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary setup-content" id="step-3">
                    <div class="panel-heading">
                        <h3 class="panel-title">Security Informations</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="username" class="col-md-12 control-label">Username</label>
                            <div class="col-md-11">
                                <input name="username" id="username" class="form-control" placeholder="Enter Username"
                                        maxlength="50" value="<?=$username ?>" type="text">
                            </div>
                            <label class="error_msg"><?php echo $error_username ?></label>
                        </div><br/>
                        <div class="form-group" style="height: 10px !important">
                            <label class="col-md-12" id="user_success" style="color: rgba(46,148,15,0.99); font-weight: bold; display: none">Username Available</label>
                            <label class="col-md-12 user_error" style="color: red; font-weight: bold; display: none">Username already exist</label>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <label for="email" class="col-md-12 control-label">Email</label>
                            <div class="col-md-12">
                                <input type="email" id="email" class="form-control" name="email" id="email" maxlength="40"
                                        placeholder="Email Address" value="<?=$email ?>">
                            </div>
                            <label class="error_msg"><?php echo $error_email ?></label>
                            <div class="form-group" style="height: 10px !important">
                                <label class="col-md-12" id="email_success" style="color: rgba(46,148,15,0.99); font-weight: bold; display: none">Email valid</label>
                                <label class="col-md-12 email_error" style="color: red; font-weight: bold; display: none">Email is not valid</label>
                            </div>
                        </div><br><br><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pass" class="col-md-12 control-label">Choose Password</label>
                                    <div class="col-md-12">
                                        <input name="pass" id="pass" class="form-control" placeholder="Enter Password" maxlength="15"
                                                type="password">
                                    </div>
                                </div>
                                <div class="form-group" style="height: 10px !important">
                                    <label class="col-md-12" id="pass_success" style="color: rgba(46,148,15,0.99); font-weight: bold; display: none">Password requirement satisfied</label>
                                    <label class="col-md-12 pass_error" style="color: red; font-weight: bold; display: none">Password must be more than 6 characters</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pass" class="col-md-12 control-label">Confirm Password</label>
                                    <div class="col-md-12">
                                        <input name="pass2" id="pass2" class="form-control" placeholder="Confirm Password"
                                                maxlength="15" type="password">
                                    </div>
                                </div>
                                <div class="form-group" style="height: 10px !important">
                                    <label class="col-md-12" id="pass2_success" style="color: rgba(46,148,15,0.99); font-weight: bold; display: none">Password Matched</label>
                                    <label class="col-md-12 pass2_error" style="color: red; font-weight: bold; display: none">Password must match the formal</label>
                                </div>
                            </div>
                        </div><br><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tran_pass" class="col-md-12 control-label">Transaction Password</label>
                                    <div class="col-md-12">
                                        <input name="tran_pass" id="tran_pass" class="form-control" placeholder="Enter Transaction Password" maxlength="15"
                                                type="password">
                                    </div>
                                </div>
                                <div class="form-group" style="height: 10px !important">
                                    <label class="col-md-12" id="tran_pass_success" style="color: rgba(46,148,15,0.99); font-weight: bold; display: none">Password requirement satisfied</label>
                                    <label class="col-md-12 tran_pass_error" style="color: red; font-weight: bold; display: none">Password must be more than 6 characters</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tran_pass2" class="col-md-12 control-label">Confirm Transaction Password</label>
                                    <div class="col-md-12">
                                        <input name="tran_pass2" id="tran_pass2" class="form-control" placeholder="Confirm Transaction Password"
                                                maxlength="15" type="password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12" id="tran_pass2_success" style="color: rgba(46,148,15,0.99); font-weight: bold; display: none">Password Matched</label>
                                    <label class="col-md-12 tran_pass2_error" style="color: red; font-weight: bold; display: none">Password must match the formal</label>
                                </div>
                            </div>
                            
                        </div><br><br>
                        <div class="form-group" style="margin-top: 20px;">
                            <button class="btn btn-primary prevBtn pull-left" type="button">Prev</button>
                            <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
                        </div>
                        
                    </div>
                </div>
                <div class="panel panel-primary setup-content" id="step-4">
                    <div class="panel-heading">
                        <h3 class="panel-title">Payment Details</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="username" class="col-md-12 control-label">Username</label>
                            <div class="col-md-11">
                                <input name="payer_username" id="payer_username" class="form-control" placeholder="Enter Username"
                                        maxlength="50" value="<?=$payer_username ?>" type="text">
                            </div>
                            <label class="error_msg"><?php echo $payer_username ?></label>
                            <div class="form-group" style="height: 10px !important">
                                <label class="col-md-12" id="payer_success" style="color: rgba(46,148,15,0.99); font-weight: bold; display: none"></label>
                                <label class="col-md-12 payer_error" style="color: red; font-weight: bold; display: none">This User does not exist</label>
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="pass" class="col-md-12 control-label">Password</label>
                                    <div class="col-md-12">
                                        <input name="payer_pass" id="payer_pass" class="form-control" placeholder="Enter Password" maxlength="15"
                                                type="password">
                                    </div>
                                </div>
                            </div>
                        </div><br><br>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="tran_pass" class="col-md-12 control-label">Transaction Password</label>
                                    <div class="col-md-12">
                                        <input name="payer_tran_pass" id="tran_pass" class="form-control" placeholder="Enter Transaction Password" maxlength="15"
                                                type="password">
                                        <input name="register" id="register" type="hidden" value="register">
                                    </div>
                                </div>
                            </div>
                        </div><br><br>
                        <div class="form-group" style="margin-top: 20px;">
                            <button class="btn btn-primary prevBtn pull-left" type="button">Prev</button>
                            <input type="submit" name="register" value="register">
                            <button class="btn btn-primary prevBtn pull-right" onclick="onSubmit()" type="button">Pay and SignUp</button>
                        </div>
                        
                    </div>
                </div>
            </form>
                </div>
            </div>


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
$(document).ready(function () {

var navListItems = $('div.setup-panel div a'),
    allWells = $('.setup-content'),
    allNextBtn = $('.nextBtn');
    allPrevBtn = $('.prevBtn');

allWells.hide();

navListItems.click(function (e) {
    e.preventDefault();
    var $target = $($(this).attr('href')),
        $item = $(this);

    if (!$item.hasClass('disabled')) {
        navListItems.removeClass('btn-success').addClass('btn-default');
        $item.addClass('btn-success');
        allWells.hide();
        $target.show();
        $target.find('input:eq(0)').focus();
    }
});

allNextBtn.click(function () {
    var curStep = $(this).closest(".setup-content"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
        curInputs = curStep.find("input[type='text'],input[type='url']"),
        isValid = true;

    $(".form-group").removeClass("has-error");
    for (var i = 0; i < curInputs.length; i++) {
        if (!curInputs[i].validity.valid) {
            isValid = false;
            $(curInputs[i]).closest(".form-group").addClass("has-error");
        }
    }

    if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
});

allPrevBtn.click(function () {
    var curStep = $(this).closest(".setup-content"),
        curStepBtn = curStep.attr("id"),
        prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a"),
        curInputs = curStep.find("input[type='text'],input[type='url']"),
        isValid = true;

    $(".form-group").removeClass("has-error");
    for (var i = curInputs.length - 1; i <= 0; i--) {
        if (!curInputs[i].validity.valid) {
            isValid = false;
            $(curInputs[i]).closest(".form-group").addClass("has-error");
        }
    }

    if (isValid) prevStepWizard.removeAttr('disabled').trigger('click');
});

$('div.setup-panel div a.btn-success').trigger('click');



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
                if(username != ''){
                    $.post("includes/getuser.php", { username: username}, function(data){
                    if(data == 0){
                        $('#referer_success').hide();
                        $('.referer_error').show();
                        $('#referer_msg').html('');
                        // $('#nextBtn1').removeClass('disabled');
                    }
                    else{
                        $('#referer_msg').html('Success User exists: ' + data);
                        $('.referer_error').hide();
                        $('#referer_success').show();
                        $('#nextBtn1').removeClass('disabled');
                    }

                });
                }
            }, 500);
            

            //check if username exist
            var checkUserExist = debounce(function() {
                let username = $('#username').val();
                if(username != ''){
                    $.post("includes/getuser.php", { username: username}, function(data){
                    if(data == 0){
                        $('#user_success').show();
                        $('.user_error').hide();
                    }
                    else{
                        $('.user_error').show();
                        $('#user_success').hide();
                    }

                });
                }
            }, 500);

            $('#payer_user').on('keyup', debounce(function() {
                let username = $('#payer_user').val();
                if(username != ''){
                    $.post("includes/getuser.php", { username: username}, function(data){
                    if(data == 0){
                        $('#payer_success').html('');
                        $('.referer_error').show();
                    }
                    else{
                        $('#payer_success').html('Success User exists: ' + data);
                        $('.referer_error').hide();
                    }

                });
                }
            }, 500));

            $('#email').on('keyup', debounce(function() {
                let username = $('#email').val();
                if (validateEmail(email)) {
                    $('#email_success').show();
                    $('.email_error').hide();
                } else {
                    $('#email_success').hide();
                    $('.email_error').show();
                }
            }, 500));


            $('#ref_username').on('keyup', myEfficientFn);
            $('#username').on('keyup', checkUserExist);


            $('#ref_username').on('focus', function(){
                $('#referer_success').hide();
                $('.referer_error').hide();
                $('#referer_msg').html('');
            });

            // $('#dob').datepicker({
            //     format: 'd/M/yyyy'
            // });


            $('#pass').on('keyup', debounce(function(){
                if($('#pass').val().length > 5) {
                    $('#pass_success').show();
                    $('.pass_error').hide();
                }
                else {
                    $('#pass_success').hide();
                    $('.pass_error').show();
                }

                if ($('#pass2').val() != ''){
                    if($('#pass').val() == $('#pass2').val()) {
                        $('#pass2_success').show();
                        $('.pass2_error').hide();
                    }
                    else {
                        $('#pass2_success').hide();
                        $('.pass2_error').show();
                    }
                }

                
            }, 500));

            $('#pass2').on('keyup', debounce(function(){
                if($('#pass').val() == $('#pass2').val()) {
                    $('#pass2_success').show();
                    $('.pass2_error').hide();
                }
                else {
                    $('#pass2_success').hide();
                    $('.pass2_error').show();
                }
                
            }, 500));

            $('#tran_pass').on('keyup', debounce(function(){
                if($('#tran_pass').val().length > 5) {
                    $('#tran_pass_success').show();
                    $('.tran_pass_error').hide();
                }
                else {
                    $('#tran_pass_success').hide();
                    $('.tran_pass_error').show();
                }

                if ($('#tran_pass2').val() != ''){
                    if($('#tran_pass').val() == $('#tran_pass2').val()) {
                    $('#tran_pass2_success').show();
                    $('.tran_pass2_error').hide();
                    }
                    else {
                        $('#tran_pass2_success').hide();
                        $('.tran_pass2_error').show();
                    }
                }
                
            }, 500));

            $('#tran_pass2').on('keyup', debounce(function(){
                if($('#tran_pass').val() == $('#tran_pass2').val()) {
                    $('#tran_pass2_success').show();
                    $('.tran_pass2_error').hide();
                }
                else {
                    $('#tran_pass2_success').hide();
                    $('.tran_pass2_error').show();
                }
                
            }, 500));

            $('#superior_id').on('keyup', debounce(function() {
                let username = $('#superior_id').val();
                if(username != ''){
                    $.post("includes/getuser.php", { username: username}, function(data){
                        if(data == 0){
                            $('#superior_success').html('');
                            $('.superior_error').show();
                        }
                        else{
                            $('#superior_success').html('Success User exists: ' + data);
                            $('.superior_error').hide();
                        }

                    });
                }
            }, 500));


      onscubmit = function(){
          let username = $('#username').val();
          let email = $('#email').val();
          let pass = $('#pass').val();
          let tran_pass = $('#tran_pass').val();
          let city = $('#city').val();
          let country = $('#country').val();
          let state = $('#state').val();
          let firstname = $('#firstname').val();
          let lastname = $('#lastname').val();
          let address = $('#address').val();
          let dob = $('#dob').val();
          let phone = $('#phone').val();
          let gender = $('#gender').val();

          if (validateEmail(email)) {
          } else {
          }

          $.post("includes/registeruser.php", { value: {}}, function(data){
            if(data == 0){
                $('#user_success').show();
                $('.user_error').hide();
            }
            else{
                $('.user_error').show();
                $('#user_success').hide();
            }

        });
      }

      //checkbox label aunty
    //   $(":checkbox").labelauty({ label: false });

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
});

function onSubmit(){
    document.getElementById('FormID').submit();
}
</script>

</body>
</html>
<?php ob_end_flush(); ?>