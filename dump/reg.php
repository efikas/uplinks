<?php
	ob_start();
	session_start();
	if( isset($_SESSION['user'])!="" ){
	//	header("Location: dashboard.php");
	}
	include_once 'dbconnect.php';

	$error = false;

if( isset($_GET['ref']) ) {
    $superior_id = ($_GET['ref']);
    $ref = $_GET['ref'];
    $query = "SELECT * FROM `user_table` WHERE `myid` = '$ref'";
    $res = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($res);
    $ref_name = $row['userName'];
    $ref_username =  $ref_name;
    $ref_msg = "Referal details has been captured <br> Referal Username: ".$ref_name."
                    <br> kindly note that a sum of $40 will be deducted from your wallet ";

}
	if ( isset($_POST['btn-signup']) ) {
		
		// clean user inputs to prevent sql injections
		$firstname = trim($_POST['firstname']);
		$firstname = strip_tags($firstname);
		$firstname = htmlspecialchars($firstname);

		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);
		  
		$superior_id = trim($_POST['superior_id']);
		$superior_id = strip_tags($superior_id);
		$superior_id = htmlspecialchars($superior_id);

        $pass = trim($_POST['pass']);
        $pass = strip_tags($pass);
        $pass = htmlspecialchars($pass);

		
        $lastname = trim($_POST['lastname']);
		$lastname = strip_tags($lastname);
		$lastname = htmlspecialchars($lastname);
        
        $occupation = trim($_POST['occupation']);
		$occupation = strip_tags($occupation);
		$occupation = htmlspecialchars($occupation);
        
        $address = trim($_POST['address']);
		$address = strip_tags($address);
		$address = htmlspecialchars($address);
		
		$country = trim($_POST['country']);
		$country = strip_tags($country);
		$country = htmlspecialchars($country);
        
        $city = trim($_POST['city']);
		$city = strip_tags($city);
		$city = htmlspecialchars($city);
        
        $state = trim($_POST['state']);
		$state = strip_tags($state);
		$state = htmlspecialchars($state);
        
        $gender = trim($_POST['gender']);
		$gender = strip_tags($gender);
		$gender = htmlspecialchars($gender);
        
        $phone = trim($_POST['phone']);
		$phone = strip_tags($phone);
		$phone = htmlspecialchars($phone);
        
        $bankname = trim($_POST['bankname']);
		$bankname = strip_tags($bankname);
		$bankname = htmlspecialchars($bankname);
        
        $accname = trim($_POST['accname']);
		$accname = strip_tags($accname);
		$accname = htmlspecialchars($accname);
        
        $accno = trim($_POST['accno']);
		$accno = strip_tags($accno);
		$accno = htmlspecialchars($accno);

        $username = trim($_POST['username']);
        $username = strip_tags($username);
        $username = htmlspecialchars($username);

        $ref_username = trim($_POST['ref_username']);
        $ref_username = strip_tags($ref_username);
        $ref_username = htmlspecialchars($ref_username);

        $ref_pass = trim($_POST['ref_pass']);
        $ref_pass = strip_tags($ref_pass);
        $ref_pass = htmlspecialchars($ref_pass);

        if (!$error) {

            $password = hash('sha256', $ref_pass); // password hashing using SHA256

            $res=mysqli_query($dbc,"SELECT * FROM user_table WHERE userName='$ref_username'");
            $row=mysqli_fetch_array($res);
            $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
            $to_pay = $row['myid'];
            if( $count == 1 && $row['password']==$password && $row['userType']=='1') {

            } else if( $count == 1 && $row['password']==$password) {
            } else {

                $error = true;
                $ref_usernameError =  "Incorrect Credentials, Try again...";
            }

        }

        // basic name validation
		if (empty($firstname)) {
			$error = true;
			$firstnameError = "Please enter your first name.";
		} else if (strlen($firstname) < 3) {
			$error = true;
			$firstnameError = "Name must have atleat 3 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$firstname)) {
			$error = true;
			$firstnameError = "Name must contain alphabets and space.";
		}
			
		// basic name validation
		if (empty($address)) {
			$error = true;
			$addressError = "Please enter your address.";
		} 
		if (empty($country)) {
			$error = true;
			$countryError = "Please select your country.";
		} 
		 if (empty($lastname)) {
			$error = true;
			$lastnameError = "Please enter your last name.";
		}
		 if (empty($occupation)) {
			$error = true;
			$occupationError = "Please enter your occupation.";
		} 
		 if (empty($city)) {
			$error = true;
			$cityError = "Please enter your city.";
		} 
		 if (empty($state)) {
			$error = true;
			$stateError = "Please enter your state.";
		} 
		 if ($gender == "Select") {
			$error = true;
			$genderError = "Please Select your gender.";
		} 
		 if (empty($phone)) {
			$error = true;
			$phoneError = "Please enter your phone number.";
		} 
		if (empty($bankname)) {
			$error = true;
			$banknameError = "Please enter the name of your bank.";
		} 
		 if (empty($accname)) {
			$error = true;
			$accnameError = "Please enter the name of your account.";
		} 
		 if (empty($accno)) {
			$error = true;
			$accnoError = "Please enter your account number.";
		} 
		 if (empty($username)) {
			$error = true;
			$usernameError = "Please enter your username.";
		} 
		 if (empty($superior_id) ) {
			$error = true;
			$superiorError = "You can not register withour a referal";
		}else{

             $query = "SELECT * FROM `user_rank` WHERE `myid`='$to_pay'";
             $result = mysqli_query($dbc,$query);
             $row=mysqli_fetch_array($result);
             $to_pay_balance = $row['balance'];
             if(!$error && $to_pay_balance < 40){
                 $error = true;
                 $ref_usernameError = "Insufficient fund";

             }

         }
		//basic email validation
		if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Please enter valid email address.";
		} else {
			// check email exist or not
			$query = "SELECT email FROM user_table WHERE email='$email'";
			$result = mysqli_query($dbc,$query);
            $row=mysqli_fetch_array($result);
			$count = mysqli_num_rows($result);
			if($count!=0){
				$error = true;
				$emailError = "Provided Email is already in use.";
			}
		}
		// password validation
		if (empty($pass)){
			$error = true;
			$passError = "Please enter password.";
		} else if(strlen($pass) < 6) {
			$error = true;
			$passError = "Password must have atleast 6 characters.";
		}
		
		// password encrypt using SHA256();
		$password = hash('sha256', $pass);
        $added=date("Y-m-d h:i:s");
        $myid = $uniqueId= time().'-'.mt_rand();

		
		// if there's no error, continue to signup
		if( !$error ) {
			
			$query = "INSERT INTO user_table(userName,firstName,lastName,myid,superior_id,occupation,address,country,city,state,phoneNo,bankName,accName,accNo,email,password,added) VALUES('$username','$firstname','$lastname','$myid','$superior_id','$occupation','$address','$country',$city','$state','$phone','$bankname','$accname','$accno','$email','$password','$added')";
			$res = mysqli_query($dbc,$query);
		           exit(var_dump(mysqli_error($db))); 
			if ($res) {
                
        	$query2 = "INSERT INTO user_rank(email,myid,superior_id) VALUES('$email','$myid','$superior_id')";
			$res2 = mysqli_query($dbc,$query2);

                mysqli_query($dbc, "UPDATE user_table SET `status`= 'paid' WHERE `myid`='$myid'");
                mysqli_query($dbc, "UPDATE user_rank SET `status`= 'paid' WHERE `myid`='$myid'");
                $newbalance = $to_pay_balance - 40;
                mysqli_query($dbc, "UPDATE user_rank SET  `balance`= '$newbalance' WHERE `myid`='$to_pay'");
                
                 $query3 = "INSERT INTO wallet_history(sender_id,receiver_id,sender_name,receiver_name,Credit,Debit,Remark,Status) VALUES('$superior_id','1509227304-526012118','$ref_username','admin','0','40','Registeration payment of $firstname $lastname','Paid')";

                    $res3 = mysqli_query($dbc, $query3);
            
			if ($res2) {
	           require_once 'regnew.php';
               
				$errTyp = "success";
				$errMSG = "Successfully registered, you may login now";

                
				unset($firstname);
                unset($lastname);
				unset($email);
				unset($password);
				unset($occupation);
				unset($address);
				unset($country);
				unset($city);
				unset($state);
				unset($phone);
				unset($bankname);
				unset($accname);
				unset($accno);
				unset($username);
				//send mail to user.
				
				$to      = $email;
                $subject = 'Registeration on user.uplinks.biz';
                $message = '<div style="background-color: #E5E5E5;"><img src="uplinksupper.jpg" alt="Uplinks">
                <br>
                <img src="uplinksup.jpg" alt="Uplinks">
                <br><br><br>
Dear '.$firstname.',
<br><br><br>
Thank you for joining UPLINKS family, your world of financial freedom!
<br><br><br>
Our priority is to put a smile on your face by helping you achieve that which seems impossible so you can live your dreams.
<br><br><br>
Please note: do not share this information with anyone, your username and password is like your ATM pin, please keep it safe and secure
<br><br><br><br><br><br>

<u><b>YOUR Login Details</b></u>
<br><br><br>
User Id :' .$myid.'
<br><br><br>
Username : '.$username.'
<br><br><br>
Password : *********
<br><br><br>
Transaction PIN : *********
<br><br><br><br><br><br>
If you have any questions, please contact our dedicated Customer Care line on 081-5876 7646 or send an email to service@uplinks.biz and we\'ll get back to you.
<br><br><br>
<b>Thank you for choosing Uplinks!</b>
<br><br><br>
Best regards, 
<br><br><br>
Admin,
<br>
Uplinks Global Concept,
<br><br><br>
#YourWorldofFinancialFreedom.
<hr>
<br><br>
<img src="uplinksdown.jpg" alt="Uplinks">
<p style="font-size:9px; text-align: center; background-color: black; color:white;"><br><br> Copyright 2018 Uplinks Global Concept Reg. No. BN 2468056. <br><br><br></p>
<p style="font-size:6px;"> The information in this email is confidential and may be legally privileged. It is intended solely for the addressee. Access to this email by anyone else is unauthorised.<br> 
If you have received this communication in error, please address with the subject heading Received in error, send to the sender, then delete the email and destroy any copies of it.
<br>
If you are not the intended recipient, any disclosure, copying, distribution or any action taken or omitted to be taken in reliance on it, is prohibited and may be unlawful.
<br>
Any opinions or advice or other information contained in this email that do not relate to the official business of the organization are considered void.
<br>
<b>Uplinks</b> cannot guarantee that email communications are secure or error-free, as information could be intercepted, corrupted, amended, lost, destroyed, arrive late 
or incomplete, or contain viruses.<br><br></p></div>
';
                $headers = 'From: @.com' . "\r\n" .
                             'Reply-To: no-reply@uplinks.biz' . "\r\n";

                mail_user($to, $subject, $message, $headers);
                
               }  else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}
                
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
				
		}
		
		
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Uplinks Registration</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div class="container">

	<div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
    	<div class="col-md-12">
        
        	<div class="form-group">
            	<h2 class="">Sign Up.</h2>
                <h3> <?php echo $ref_msg; ?> </h3>
            </div>
        
        	<div class="form-group">
            	<hr />
            </div>
            
            <?php
			if ( isset($errMSG) ) {
				
				?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php
			}
			?>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="firstname" class="form-control" placeholder="Enter First Name" maxlength="50" value="<?php echo $firstname ?>" />
                </div>
                <span class="text-danger"><?php echo $firstnameError; ?></span>
            </div>            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="lastname" class="form-control" placeholder="Enter Last Name" maxlength="50" value="<?php echo $lastname ?>" />
                </div>
                <span class="text-danger"><?php echo $lastnameError; ?></span>
            </div>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            	<input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
                        
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="superior_id" class="form-control" placeholder="Enter ID of referal" maxlength="40" value="<?php echo $superior_id ?>" />
                </div>
                <span class="text-danger"><?php echo $superiorError; ?></span>
            </div>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="occupation" class="form-control" placeholder="Enter occupation" maxlength="50" value="<?php echo $occupation ?>" />
                </div>
                <span class="text-danger"><?php echo $occupationError; ?></span>
            </div>            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="address" class="form-control" placeholder="Enter Address" maxlength="50" value="<?php echo $address ?>" />
                </div>
                <span class="text-danger"><?php echo $addressError; ?></span>
            </div>  
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
					<select name="country" class="form-control" value="<?php echo $country ?>">
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
						<option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
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
						<option value="Democratic People's Republic of Korea">Korea, Democratic People's Republic of</option>
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
						<option value="South Georgia">South Georgia and the South Sandwich Islands</option>
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
						<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
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
                <span class="text-danger"><?php echo $countryError; ?></span>
            </div>  
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="state" class="form-control" placeholder="Enter State" maxlength="50" value="<?php echo $state ?>" />
                </div>
                <span class="text-danger"><?php echo $stateError; ?></span>
            </div>     
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="city" class="form-control" placeholder="Enter City" maxlength="50" value="<?php echo $city ?>" />
                </div>
                <span class="text-danger"><?php echo $cityError; ?></span>
            </div>            
                   
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	  <select class="form-control"  name="gender" id="gender">
                        <option value="Select">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select>  
                </div>
                <span class="text-danger"><?php echo $genderError; ?></span>
            </div>  
                
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="phone" class="form-control" placeholder="Enter phone number" maxlength="50" value="<?php echo $phone ?>" />
                </div>
                <span class="text-danger"><?php echo $phoneError; ?></span>
            </div>
                   
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="bankname" class="form-control" placeholder="Enter Name of Bank" maxlength="50" value="<?php echo $bankname ?>" />
                </div>
                <span class="text-danger"><?php echo $banknameError; ?></span>
            </div>
                               
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="accname" class="form-control" placeholder="Enter Account Name" maxlength="50" value="<?php echo $accname ?>" />
                </div>
                <span class="text-danger"><?php echo $accnameError; ?></span>
            </div>
                                            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="accno" class="form-control" placeholder="Enter Account Number" maxlength="50" value="<?php echo $accno ?>" />
                </div>
                <span class="text-danger"><?php echo $accnoError; ?></span>
            </div>
                                            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="username" class="form-control" placeholder="Enter User Name" maxlength="50" value="<?php echo $username ?>" />
                </div>
                <span class="text-danger"><?php echo $usernameError; ?></span>
            </div>
                
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            	<input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>

            <div class="form-group">
                <hr />
            </div>
            <div class="form-group">
                <hr />
            </div>
            <h2 style="color:red;">Account to debit</h2>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input type="text" name="ref_username" class="form-control" placeholder="Enter User Name" maxlength="50" value="<?php echo $ref_username ?>" />
                </div>
                <span class="text-danger"><?php echo $ref_usernameError; ?></span>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input type="password" name="ref_pass" class="form-control" placeholder="Enter Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $ref_passError; ?></span>
            </div>

            <div class="form-group">
                <hr />
            </div>
            <div class="form-group">
                <hr />
            </div>
            <div class="form-group">
            	<button  style="background-color: #daa520" type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<a style="color: #daa520" href="index.php">Sign in Here...</a>
            </div>
        
        </div>
   
    </form>
    </div>	

</div>

</body>
</html>
<?php ob_end_flush(); ?>