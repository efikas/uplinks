<?php

$firstname = '';
$lastname = '';
$address = '';
$country = '';
$state = '';
$city = '';
$phone = '';
$dob = '';
$gender = '';
$superior_id = '';  // this is the id of the parent of the registering user
// $occupation = htmlspecialchars(strip_tags(trim($_POST['occupation'])));
$username = '';
$email = '';
$pass = '';
$pass2 = '';
$tran_pass = '';
$tran_pass2 = '';
$payer_username = '';
$payer_pass = '';
$payer_tran_pass = '';

$error_array = [];
$top_error = '';

if (isset($_POST['register'])) {

    /**
     * To work on this page, you need to have a goo knowledge og laravel eleoquent
     * This page was modified to use eloquent for easier management
     */

    require_once 'app/init.php';
    require_once 'includes/Payer.php';

    $user = new User();
    $userRank = new User_rank();
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
        array_push($error_array, "Please enter your referer username.");
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
            array_push($error_array, "Please enter a correct referer id.");
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
        array_push($error_array,  "Please enter your Firstname.");
    }
    if (empty($lastname)) { 
        $error = true;
        array_push($error_array, "Please enter your Lastname.");
    }
    if (empty($address)) { 
        $error = true;
        array_push($error_array,"Please enter your Address.");
    }
    if ($country == "") { 
        $error = true;
        array_push($error_array, "Please enter your Country.");
    }
    if (empty($city)) { 
        $error = true;
        array_push($error_array, "Please enter your City.");
    }
    if (empty($state)) { 
        $error = true;
        array_push($error_array, "Please enter your State.");
    }
    if ($gender == "") { 
        $error = true;
        array_push($error_array, "Please enter your Gender.");
    }

    if (empty($phone)) { 
        $error = true;
        array_push($error_array, "Please enter your Phone Number.");
    }
    
    if (empty($dob)) { 
        $error = true;
        array_push($error_array, "Please enter your Date of Birth.");
    }

     if (empty($superior_id)) {
         $error = true;
         array_push($error_array, "Please enter your referer id.");
     }
     else {
         $superior_id = '';

         // check if the referrer exist
         $sup = User::where('userName', $referer)->first();
         if($sup){
             $superior_id = $sup->myid;
         }
         else {
             $error = true;
             array_push($error_array, "Please enter a correct Superior id.");
         }
     }

    
    if (empty($username)) { 
        $error = true;
        array_push($error_array, "Please enter your Username.");
    }
    if (empty($email)) { 
        $error = true;
        array_push($error_array, "Please enter your Email.");
    }
    if (empty($pass)) { 
        $error = true;
        array_push($error_array,"Please enter your password.");
    }
    if (empty($pass2)) { 
        $error = true;
        array_push($error_array, "Please enter the confirmation password.");
    }

    if (!empty($pass) && !empty($pass2) && $pass != $pass2) {
        $error = true;
        array_push($error_array, "Please re enter your the same password.");
    }

    if (empty($tran_pass)) { 
        $error = true;
        array_push($error_array, "Please enter your transaction password.");
    }
    if (empty($tran_pass2)) { 
        $error = true;
        array_push($error_array, "Please enter the confirmation transaction password.");
    }

    if (!empty($tran_pass) && !empty($tran_pass2) && $tran_pass != $tran_pass2) {
        $error = true;
        array_push($error_array, "Please re enter the same transaction password.");
    }


    if (empty($payer_username)) { 
        $error = true;
        array_push($error_array, "Please enter the Payer Username.");
    }
    if (empty($payer_pass)) { 
        $error = true;
        array_push($error_array,"Please enter the Payer password.");
    }

    if (empty($payer_tran_pass)) { 
        $error = true;
        array_push($error_array, "Please enter the transaction Payer password.");
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
        

    if (count($error_array) < 1) {
        //confirmed the payer informations
        $res = User::where('userName', $payer_username)->first();

        if($res && $res->password == hash('sha256', $payer_pass) && $res->t_password == hash('sha256', $payer_tran_pass)) {

            // get the payer id
            $payer_id = $res->myid;

            // check if the payer has enough balance to pay for the registration
            $hasEnoughCash = $payer->userRegFinancialStatus($payer_id);

            if($hasEnoughCash) {

                // Make registration payment
                $payed = $payer->payRegistration($payer_id, $referer);

                if($payed) { //if payment successful
                    //register new user
                    $password = hash('sha256', $pass);
                    $t_password = hash('sha256', $tran_pass);
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
                            'status' => 'paid',
                            't_password' => $t_password,
                    ]);

                    
                    //credit the referrer and record the transaction log

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
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="dashboard_files/logo-inverse2.png" />
	<title>Welcome to Uplinks Member Dashboard</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<!-- CSS Files -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/css/paper-bootstrap-wizard.css" rel="stylesheet" />

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link href="assets/css/demo.css" rel="stylesheet" />

	<!-- Fonts and Icons -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/themify-icons.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
</head>

<body>
<div class="image-container set-full-height">
	<!--   Big container   -->
    <div class="container">
	       <div class="jumbotron">
           <div class="row">
                <div class="col-sm-10">
                    <?php for ($i = 0; $i < sizeof($error_array); $i ++) {?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-info"></i> Alert!</h4>
                            <h3><?php echo $error_array[$i] ?></h3>
                        </div>
                    <?php
                    }
                    if ($top_error) { ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-info"></i> Alert!</h4>
                        <h3><?php echo $top_error ?></h3>
                    </div>
                <?php } ?>
                </div>
            </div>
            <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <!--      Wizard container        -->
                        <div class="wizard-container">

                            <div class="card wizard-card" data-color="orange" id="wizardProfile">
                                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                                    <!--        You can switch " data-color="orange" "  with one of the next bright colors: "blue", "green", "orange", "red", "azure"          -->

                                    <div class="wizard-header text-center">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-md-offset-3 text-center" style="height: 80px; margin-top: 50px; margin-bottom: 80px">
                                                <img src="dashboard_files/logo-inverse.png" class="big-logo" style="width:250px;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="wizard-navigation">
                                        <div class="progress-with-circle">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 21%;"></div>
                                        </div>
                                        <ul>
                                            <li>
                                                <a href="#sponsor" data-toggle="tab">
                                                    <div class="icon-circle">
                                                        <i class="ti-user"></i>
                                                    </div>
                                                    Sponsor
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#registration" data-toggle="tab">
                                                    <div class="icon-circle">
                                                        <i class="ti-settings"></i>
                                                    </div>
                                                    Registration
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#security" data-toggle="tab">
                                                    <div class="icon-circle">
                                                        <i class="ti-map"></i>
                                                    </div>
                                                    Security
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#payment" data-toggle="tab">
                                                    <div class="icon-circle">
                                                        <i class="ti-map"></i>
                                                    </div>
                                                    Payment
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane" id="sponsor">
                                            <div class="row">
                                                <!-- <div class="form-group">
                                                    <h2 class="text-center">Sponsor Details</h2>
                                                </div> -->
                                                <div class="form-group">
                                                    <label class="control-label col-md-10"><h3>Referrer Username</h3></label>
                                                    <label class="control-label col-md-10"><small style=""><strong>Please enter your Referrer Username</strong></small></label>
                                                    <div class="col-md-11">
                                                        <input type="text" required="required" name="ref_username" id="ref_username" class="form-control"
                                                                placeholder="Enter Referrer Username" maxlength="50" value="">
                                                    </div>
                                                    <div class="col-md-1" style="padding-top: 10px; padding-left: 0px">
                                                        <span id="referer_success" class="glyphicon glyphicon-ok success" style="color: rgba(46,148,15,0.99); display: none"></span>
                                                        <span class="glyphicon glyphicon-remove referer_error" style="color: red; display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <br/>
                                                    <label class="col-md-12" id="referer_msg" style="color: rgba(46,148,15,0.99); font-weight: bold"></label>
                                                    <label class="col-md-12 referer_error" style="color: red; font-weight: bold; display: none">Username does not exist</label>
                                                
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-10"><h3>Superior Username</h3></label>
                                                    <label class="control-label col-md-10"><small style=""><strong>Please enter your Superior Username</strong></small></label>
                                                    <div class="col-md-11">
                                                        <input type="text" required="required" name="superior_id" id="superior_id" class="form-control"
                                                            placeholder="Enter Superior Username" maxlength="50" value="">
                                                    </div>
                                                    <div class="col-md-1" style="padding-top: 10px; padding-left: 0px">
                                                        <span id="superior_success" class="glyphicon glyphicon-ok success" style="color: rgba(46,148,15,0.99); display: none"></span>
                                                        <span class="glyphicon glyphicon-remove superior_error" style="color: red; display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <br/>
                                                    <label class="col-md-12" id="superior_msg" style="color: rgba(46,148,15,0.99); font-weight: bold"></label>
                                                    <label class="col-md-12 superior_error" style="color: red; font-weight: bold; display: none">Username does not exist</label>
                                                    <br><br><br>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="registration">
                                            <h5 class="info-text"> What are you doing? (checkboxes) </h5>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="firstname" class="col-md-12 control-label">First Name</label>
                                                    <div class="col-md-12">
                                                        <input name="firstname" required="required" id="firstname" class="form-control"
                                                            placeholder="Enter First Name" maxlength="50" value="<?=$firstname ?>" type="text">
                                                    </div><br><br><br>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="lastname" class="col-md-12 control-label">Last Name</label>
                                                    <div class="col-md-12">
                                                        <input name="lastname" required="required" id="lastname" class="form-control"
                                                            placeholder="Enter Last Name" maxlength="50" value="<?=$lastname ?>" type="text">
                                                    </div><br><br><br>
                                                </div>
                                                <div class="form-group">
                                                    <label for="address" class="col-md-12 control-label">Address</label>
                                                    <div class="col-md-12">
                                                        <textarea name="address" required="required" id="address" class="form-control" placeholder="Enter Address"
                                                        maxlength="200" value="<?=$address ?>"></textarea><br>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-bottom: 50px">
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
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
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="state" class="col-md-12 control-label">State</label>
                                                            <div class="col-md-12">
                                                                <input name="state" required="required" id="state" class="form-control" placeholder="Enter State"
                                                                    maxlength="50" value="<?=$state ?>" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="city" class="col-md-12 control-label">City</label>
                                                            <div>
                                                                <input name="city" required="required" id="city" class="form-control" placeholder="Enter City"
                                                                    maxlength="50" value="<?=$city ?>" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="dob" class="col-md-12 control-label">Date Of Birth</label>
                                                            <div class="col-md-12">
                                                                <input type="date" required="required" name="dob" id="dob" value="<?=$dob ?>" class="form-control">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="gender" class="col-md-12 control-label">Gender</label>
                                                            <div class="col-md-12">
                                                                <select class="form-control" required="required" name="gender" id="gender">
                                                                    <option value="">Select Gender</option>
                                                                    <option value="Male" <?php if ($gender == 'Male') echo 'selected' ?>>Male</option>
                                                                    <option value="Female" <?php if ($gender == 'Female') echo 'selected' ?>>Female</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="phone" class="col-md-12 control-label">Phone</label>
                                                            <div class="col-md-12">
                                                                <input name="phone" required="required" class="form-control" placeholder="Enter phone number"
                                                                    maxlength="50" value="<?=$phone ?>" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="security">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="username" class="col-md-12 control-label">Username</label>
                                                    <div class="col-md-11">
                                                        <input name="username" id="username" class="form-control" placeholder="Enter Username"
                                                                maxlength="50" value="<?=$username ?>" type="text">
                                                    </div>
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
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="payment">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="username" class="col-md-12 control-label">Username</label>
                                                        <div class="col-md-11">
                                                            <input name="payer_username" id="payer_username" class="form-control" placeholder="Enter Username"
                                                                    maxlength="50" value="" type="text">
                                                        </div>
                                                        <div class="form-group" style="height: 10px !important">
                                                            <label class="col-md-12" id="payer_success" style="color: rgba(46,148,15,0.99); font-weight: bold;"></label>
                                                            <label class="col-md-12 payer_error" style="color: red; font-weight: bold; display: none">This User does not exist</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <br/>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="pass" class="col-md-12 control-label">Password</label>
                                                        <div class="col-md-12">
                                                            <input name="payer_pass" id="payer_pass" class="form-control" placeholder="Enter Password" maxlength="15"
                                                                    type="password">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="tran_pass" class="col-md-12 control-label">Transaction Password</label>
                                                        <div class="col-md-12">
                                                            <input name="payer_tran_pass" id="payer_tran_pass" class="form-control" placeholder="Enter Transaction Password" maxlength="15"
                                                                    type="password">
                                                            <input name="register" id="register" type="hidden" value="register">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- </div><br><br> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-footer">
                                        <div class="pull-right">
                                            <input type='button' class='btn btn-next btn-fill btn-warning btn-wd' name='next' value='Next' />
                                            <input type='submit' class='btn btn-finish btn-fill btn-warning btn-wd' name='finish' value='Finish' />
                                        </div>

                                        <div class="pull-left">
                                            <input type='button' class='btn btn-previous btn-default btn-wd' name='previous' value='Previous' />
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- wizard container -->
                    </div>
                </div><!-- end row -->
           </div>
	</div> <!--  big container -->
</div>
</body>
	<!--   Core JS Files   -->
	<script src="assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>

	<!--  Plugin for the Wizard -->
	<script src="assets/js/paper-bootstrap-wizard.js" type="text/javascript"></script>

	<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
	<script src="assets/js/jquery.validate.min.js" type="text/javascript"></script>
<script>
$(document).ready(function () {

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

            $('#payer_username').on('keyup', debounce(function() {
                let username = $('#payer_username').val();
                if(username != ''){
                    $.post("includes/getuser.php", { username: username}, function(data){
                    if(data == 0){
                        $('#payer_success').html('');
                        $('.payer_error').show();
                    }
                    else{
                        $('#payer_success').html('Payer name: ' + data);
                        $('.payer_error').hide();
                    }

                });
                }
            }, 500));


            $('#superior_id').on('keyup', debounce(function() {
                let username = $('#superior_id').val();
                if(username != ''){
                    $.post("includes/getuser.php", { username: username}, function(data){
                        if(data == 0){
                            $('#superior_success').hide();
                            $('#superior_msg').html('');
                            $('.superior_error').show();
                        }
                        else{
                            $('#superior_success').show();
                            $('#superior_msg').html('Success User exists: ' + data);
                            $('.superior_error').hide();
                        }

                    });
                }
            }, 500));


            $('#ref_username').on('keyup', myEfficientFn);
            $('#username').on('keyup', checkUserExist);


            $('#ref_username').on('focus', function(){
                $('#referer_success').hide();
                $('.referer_error').hide();
                $('#referer_msg').html('');
            });

            $('#superior_id').on('focus', function(){
                $('#superior_success').hide();
                $('.superior_error').hide();
                $('#superior_msg').html('');
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


      onsubmit = function(){
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

});
function onSubmit(){
    document.getElementById('FormID').submit();
}
</script>
</html>
