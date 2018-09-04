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
	if ( isset($_POST['_wp_http_referer']) ) {
	  //  echo $_POST['_wp_http_referer'];
	    
	}
	if ( isset($_POST['fld_9118054']) ) {
		
		// clean user inputs to prevent sql injections
		$firstname = trim($_POST['fld_667768']);
		$firstname = strip_tags($firstname);
		$firstname = htmlspecialchars($firstname);

		$email = trim($_POST['fld_6511176']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);
		  
        
		$superior_un = trim($_POST['fld_1906073']);
		$superior_un = strip_tags($superior_un);
		$superior_un = htmlspecialchars($superior_un);


            $res=mysqli_query($dbc,"SELECT * FROM user_table WHERE userName='$superior_un'");
            $row=mysqli_fetch_array($res);
            $superior_id = $row['myid'];
		//$superior_id = trim($_POST['superior_id']);
		//$superior_id = strip_tags($superior_id);
		//$superior_id = htmlspecialchars($superior_id);
        
        $pass = trim($_POST['fld_9376483']);
        $pass = strip_tags($pass);
        $pass = htmlspecialchars($pass);

        $c_pass = trim($_POST['fld_6717911']);
        $c_pass = strip_tags($c_pass);
        $c_pass = htmlspecialchars($c_pass);

        $t_pass = trim($_POST['fld_6192023']);
        $t_pass = strip_tags($t_pass);
        $t_pass = htmlspecialchars($t_pass);

        $c_t_pass = trim($_POST['fld_2191482']);
        $c_t_pass = strip_tags($c_t_pass);
        $c_t_pass = htmlspecialchars($c_t_pass);

		
        $lastname = trim($_POST['fld_1926031']);
		$lastname = strip_tags($lastname);
		$lastname = htmlspecialchars($lastname);

        $address = trim($_POST['fld_194871']);
		$address = strip_tags($address);
		$address = htmlspecialchars($address);
        
        $city = trim($_POST['fld_8519169']);
		$city = strip_tags($city);
		$city = htmlspecialchars($city);
        
        $state = trim($_POST['fld_3371982']);
		$state = strip_tags($state);
		$state = htmlspecialchars($state);
        
        //$gender = trim($_POST['gender']);
		///$gender = strip_tags($gender);
		//$gender = htmlspecialchars($gender);
        
        $phone = trim($_POST['fld_5360918']);
		$phone = strip_tags($phone);
		$phone = htmlspecialchars($phone);
        
        $username = trim($_POST['fld_5552179']);
        $username = strip_tags($username);
        $username = htmlspecialchars($username);

        $ref_username = trim($_POST['fld_1562666']);
        $ref_username = strip_tags($ref_username);
        $ref_username = htmlspecialchars($ref_username);

        $ref_pass = trim($_POST['fld_3613263']);
        $ref_pass = strip_tags($ref_pass);
        $ref_pass = htmlspecialchars($ref_pass);

        $ref_t_pass = trim($_POST['fld_5180770']);
        $ref_t_pass = strip_tags($ref_t_pass);
        $ref_t_pass = htmlspecialchars($ref_t_pass);
        

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
		//	$error = true;
			$firstnameError = "Please enter your first name.";
		} else if (strlen($firstname) < 3) {
		//	$error = true;
			$firstnameError = "Name must have atleat 3 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$firstname)) {
		//	$error = true;
			$firstnameError = "Name must contain alphabets and space.";
		}
		
		
         	if( $error ) {
         	    
     //   echo "got error";
         	    
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
		//	$error = true;
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
		 /**if ($gender == "Select") {
			$error = true;
			$genderError = "Please Select your gender.";
		} 
        **/
		 if (empty($phone)) {
			$error = true;
			$phoneError = "Please enter your phone number.";
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

		
		$myid2 = $myid;
		// if there's no error, continue to signup
		if( !$error ) {
			
			
			$query = "INSERT INTO user_table(userName,firstName,lastName,myid,superior_id,address,city,state,phoneNo,email,password,added) VALUES('$username','$firstname','$lastname','$myid','$superior_id','$address','$city','$state','$phone','$email','$password','$added')";
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
              // echo "tried reg";
				$errTyp = "success";
				$errMSG = "Successfully registered, you may login now";

                			
				$to      = $email;
                $subject = '';
                $message = 'Registeration on Uplinks';
                $headers = '<html>
<body style="text-align: center;"> 
  <div style="background-color: #E5E5E5;"><img src="https://mail.google.com/mail/u/2/?ui=2&ik=e017e70863&view=fimg&th=161b4c5963235d56&attid=0.3&disp=emb&realattid=ii_161b4c47ef4dec3a&attbid=ANGjdJ93ET_76Uyb06T6fvNUd1x7ooCsOx5-jpq6eAfpC-bRBMcmns_6x57kEgZYAxcjw4UqM4ABBzm6NCgsXvJQJYA8e8DNonRnMN7lgw6twGQkSnKBD45-Bdat5dE&sz=w926-h160&ats=1519156328703&rm=161b4c5963235d56&zw&atsh=1" alt="Uplinks">
                <br>
                <img src="https://mail.google.com/mail/u/2/?ui=2&ik=e017e70863&view=fimg&th=161b4c5963235d56&attid=0.2&disp=emb&realattid=ii_161b4c47dce63127&attbid=ANGjdJ_Jeroa24YFjTRlMiJCi-ZQomsvgMLn1VQdGVLpiS3b3s8lX_vnlbV20y4gtzTTpMhKdGjypBG4IENbFFNEr8y4xnIh3EcLar_ywa6VYf1TZGCAgNdwCa2XYog&sz=w926-h322&ats=1519156328703&rm=161b4c5963235d56&zw&atsh=1" alt="Uplinks">
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
User Id : '.$myid.'
<br><br><br>
Username : '.$username.'
<br><br><br>
Password : *********
<br><br><br>
Transaction PIN : *********
<br><br><br>
Click to <a href="http://users.uplinks.biz">LOGIN</a>
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
<img src="https://mail.google.com/mail/u/2/?ui=2&ik=e017e70863&view=fimg&th=161b4c5963235d56&attid=0.1&disp=emb&realattid=ii_161b4c47bec6e405&attbid=ANGjdJ9cVKpHJ3nN9uF6i9cA4A5DwF0MTMRjle_stwD23JYQgKG37ECRJ2qcXf7r4BaElOtMnghsn0d3vRgmOKbS_iJRVZfQ_eSaruR_ATteMwp1TFgf47jdLfThauI&sz=w926-h160&ats=1519156328703&rm=161b4c5963235d56&zw&atsh=1" alt="Uplinks">
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
</body>
</html>';

                mail_user($to, $subject, $message, $headers);
                
                
               }  else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}
                
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
				
		}else{
		    
        echo "error";
		}
		
	echo $errMSG;	
	
	
    header("Location: index.php");
    exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Uplinks Registration</title>
</head>
<body>

<div class="container">

	<div id="login-form">
    
    </div>	

</div>

</body>
</html>
<?php ob_end_flush(); ?>