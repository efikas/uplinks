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
             if($to_pay_balance < 40){
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
			
			$query = "INSERT INTO user_table(userName,firstName,lastName,myid,superior_id,occupation,address,city,state,phoneNo,bankName,accName,accNo,email,password,added) VALUES('$username','$firstname','$lastname','$myid','$superior_id','$occupation','$address','$city','$state','$phone','$bankname','$accname','$accno','$email','$password','$added')";
			$res = mysqli_query($dbc,$query);
		            
			if ($res) {
                
        	$query2 = "INSERT INTO user_rank(email,myid,superior_id) VALUES('$email','$myid','$superior_id')";
			$res2 = mysqli_query($dbc,$query2);

                mysqli_query($dbc, "UPDATE user_table SET `status`= 'paid' WHERE `myid`='$myid'");
                mysqli_query($dbc, "UPDATE user_rank SET `status`= 'paid' WHERE `myid`='$myid'");
                $newbalance = $to_pay_balance - 40;
                mysqli_query($dbc, "UPDATE user_rank SET  `balance`= '$newbalance' WHERE `myid`='$to_pay'");
            
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
				unset($city);
				unset($state);
				unset($phone);
				unset($bankname);
				unset($accname);
				unset($accno);
				unset($username);
                
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
            	<input type="text" name="city" class="form-control" placeholder="Enter City" maxlength="50" value="<?php echo $city ?>" />
                </div>
                <span class="text-danger"><?php echo $cityError; ?></span>
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