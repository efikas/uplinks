
<?php include('head.php'); ?>

<?php
$passError = "";
$t_passError = "";

			$error = false;
    if( isset($_POST['updateprofile']) ) {
        
        
        
		// clean user inputs to prevent sql injections
        if(!empty($_POST['firstname'])){
		$firstname = trim($_POST['firstname']);
		$firstname = strip_tags($firstname);
		$firstname = htmlspecialchars($firstname);
		
		
           $my_firstName  = $firstname;
        }else{
            $firstname = $my_firstName;
        }
        
        if(!empty($_POST['lastname'])){
        $lastname = trim($_POST['lastname']);
		$lastname = strip_tags($lastname);
		$lastname = htmlspecialchars($lastname);
        $my_lastName =  $lastname;
        }else{
            $lastname = $my_lastName;
        }
        
        
        if(!empty($_POST['dob'])){
        $dob = trim($_POST['dob']);
		$dob = strip_tags($dob);
		$dob = htmlspecialchars($dob);
        
            $my_dob = $dob;
        }else{
            $dob = $my_dob;
        }

        
        if(!empty($_POST['marital'])){		  
		$marital = trim($_POST['marital']);
		
            $my_marital = $marital;
		
		
        }else{
            $marital = $my_marital;
        }
        
		$pass = trim($_POST['password1']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		$pass = hash('sha256', $pass);
		
		$pass2 = trim($_POST['password2']);
		$pass2 = strip_tags($pass2);
		$pass2 = htmlspecialchars($pass2);
		$pass2 = hash('sha256', $pass2);
			if (!empty($pass)){
		if($pass2 != $pass){
			$error = true;
			$passError = "Both Passwords must match";
		  
		}else if(strlen($pass) < 6) {
			$error = true;
			$passError = "Password must have atleast 6 characters.";
		}else{
		  
		  
    $re1s = mysqli_query($dbc,"UPDATE `user_table` SET `password` = '$pass' WHERE `email`='$emai'");
		  
		}
        }
         
              
		$t_pass = trim($_POST['t_password1']);
		$t_pass = strip_tags($t_pass);
		$t_pass = htmlspecialchars($t_pass);
		$t_pass = hash('sha256', $t_pass);
		
		$t_pass2 = trim($_POST['t_password2']);
		$t_pass2 = strip_tags($t_pass2);
		$t_pass2 = htmlspecialchars($t_pass2);
		$t_pass2 = hash('sha256', $t_pass2);
			if (!empty($t_pass)){
		if($t_pass2 != $t_pass){
			$error = true;
			$t_passError = "Both Passwords must match";
		  
		}else if(strlen($pass) < 6) {
			$error = true;
			$t_passError = "Password must have atleast 6 characters.";
		}else{
		  
		  
    $re1s = mysqli_query($dbc,"UPDATE `user_table` SET `t_password` = '$t_pass' WHERE `email`='$emai'");
		  
		}
        }
         
        
        
        if(!empty($_POST['gend'])){
        $gender = trim($_POST['gend']);
		$gender = strip_tags($gender);
		$gender = htmlspecialchars($gender);
        $my_gender  =  $gender;
        }else{
            $gender = $my_gender;
        }
        
        
        if(!empty($_POST['phone'])){
        $phone = trim($_POST['phone']);
		$phone = strip_tags($phone);
		$phone = htmlspecialchars($phone);
  
            $my_phone = $phone;
        }else{
            $phone = $my_phone;
        }
        
        
        if(!empty($_POST['myaddress'])){
        $address = trim($_POST['myaddress']);
		$address = strip_tags($address);
		$address = htmlspecialchars($address);
        
            $my_address = $address;
        }else{
            $address = $my_address;
        }
        
        
        
        if(!empty($_POST['city'])){
        $city = trim($_POST['city']);
		$city = strip_tags($city);
		$city = htmlspecialchars($city);
        
            $my_city = $city;
        }else{
            $city = $my_city;
        }
        
        
        if(!empty($_POST['country'])){
        $my_country = trim($_POST['country']);
		$my_country = strip_tags($my_country);
		$my_country = htmlspecialchars($my_country);
        
        }else{
            $my_country = $my_country;
        }
        
        
        if(!empty($_POST['state'])){
        $state = trim($_POST['state']);
		$state = strip_tags($state);
		$state = htmlspecialchars($state);
        
            $my_state = $state;
        }else{
            $state = $my_state;
        }
        
        
        if(!empty($_POST['zip'])){
        $my_zipcode = trim($_POST['zip']);
		$my_zipcode = strip_tags($my_zipcode);
		$my_zipcode = htmlspecialchars($my_zipcode);
        
        }else{
            $my_zipcode = $my_zipcode;
        }
        
        
        
 if( !$error )   {
   
    $res = mysqli_query($dbc,"UPDATE `user_table` SET `firstName` = '$firstname',`lastName` = '$lastname', `state` = '$state',`city` = '$city',`phoneNo` = '$phone',`dob` = '$dob',`marital` = '$marital',`zipcode` = '$my_zipcode',`country` = '$my_country', `address` = '$address' WHERE `email`='$emai'");
        
        if($res){
            
		header("Location: update-profile.php");
        }
        
        }
        }
        
    if( isset($_POST['updatebank']) ) {
        $error = false;
        
        
        $accname = trim($_POST['Account1']);
		$accname = strip_tags($accname);
		$accname = htmlspecialchars($accname);
        
        $accno = trim($_POST['Account2']);
		$accno = strip_tags($accno);
		$accno = htmlspecialchars($accno);
        
        $bankname = trim($_POST['Account3']);
		$bankname = strip_tags($bankname);
		$bankname = htmlspecialchars($bankname);
        
    if( !$error )   {
   
         
    $res = mysqli_query($dbc,"UPDATE `user_table` SET `bankName` = '$bankname',`accName` = '$accname',`accNo` = '$accno' WHERE `email`='$emai'");
       
		header("Location: update-profile.php");
        }
       
       } 
    if( isset($_POST['updatepic']) ) {
    
    $added=date("Ymd his");
    $img = $emai.$added.basename( $_FILES["fileToUpload"]["name"]); 
    $res = mysqli_query($dbc,"UPDATE `user_table` SET `urltoimg` = '$img' WHERE `email`='$emai'");
    
        
        $target_dir = "uploads/profilepic/".$emai.$added;
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Your proof ". basename( $_FILES["fileToUpload"]["name"]). " has been sent to admin.";
        } else {
        echo "Sorry, there was an error uploading your file.";
                }
    
    }
        
?>

        <!-- PAGE TITLE -->
        <section id="page-title" class="row">

          <div class="col-md-8 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="background:#daa520 !important;color:#fff;">
            <h1>Update Profile</h1>
            <p></p><div style="color:#900;font-weight:bold;" align="center"></div><p></p>
          </div>

             
             
          <div class="col-md-4 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">

          

          </div>
        </section> <!-- / PAGE TITLE -->
        <br><!--<p style="color:red;margin-left:20px;">Note :  You can update your profile after 30 days only from the day you registered. After that it will be lock.</p><br/><br/>-->

        <div class="container-fluid">
          <div class="row">
       
            <div class="col-md-6 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">

              <section class="panel">
                <header class="panel-heading">
                  <h3 class="panel-title">Personal Information</h3>
                </header>
                <div class="panel-body">
                  <form name="input" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                  
                  
                <input name="updateprofile" id="updateprofile" hidden="hidden" />
                  <div class="form-group">
                      <label for="exampleInputName">Username:</label>
                      <input readonly="" name="username" class="form-control" id="exampleInputName" value="<?php echo $my_userName; ?>" disabled=""type="text"/>
                      
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName">First Name:</label>
                      <input name="firstname" class="form-control" id="exampleInputName" value="<?php echo $my_firstName; ?>" type="text">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputLName">Last Name:</label>
                      <input name="lastname" class="form-control" id="exampleInputLName" value="<?php echo $my_lastName; ?>" type="text">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="ti-email"></i></span>
                        <input name="email" class="form-control" id="exampleInputEmail1"  value="<?php echo $emai; ?>"  type="email">
                      </div>
                    </div>

                    <div class="form-group col-md-6 no-left-padding">
                      <label for="exampleInputPassword1">Password:</label>

                      <input name="password1" class="form-control" id="exampleInputPassword1" value="" type="password">
                    
                <span class="text-danger"><?php echo $passError; ?></span>
                    </div>
                    <div class="form-group col-md-6 no-right-padding">
                      <label for="exampleInputPassword2">Confirm Password:</label>
                      <input name="password2" class="form-control" id="exampleInputPassword2" value="" type="password">
                    </div>
                   <div class="form-group col-md-6 no-left-padding">
                      <label for="exampleInputPassword3">Transaction Pass:</label>
                      <input name="t_password1" class="form-control" id="exampleInputPassword3" value="" type="password">
                    
                <span class="text-danger"><?php echo $t_passError; ?></span>
                    </div>

                    <div class="form-group col-md-6 no-right-padding">
                      <label for="exampleInputPassword4">Confirm Password:</label>
                      <input name="t_password2" class="form-control" id="exampleInputPassword4" value="" type="password">
                    </div>
                     <br/>
                      <div class="form-group col-md-12 no-left-padding">
                      <label for="exampleInputAddress">Address:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="ti-home"></i></span>
                        <input name="myaddress" class="form-control" id="exampleInputAddress" value="<?php echo $my_address; ?>" type="text">
                      </div>
                    </div>



                    <div class="form-group col-md-6 no-right-padding">
                      <label>Country</label>
                      <select class="form-control" name="country" readonly="">
                      <option value="<?php echo $my_country; ?>"><?php echo $my_country; ?></option>
                      <option value="Singapore">Singapore</option>
                      <option value="Hong Kong">Hong Kong</option>
                      <option value="China">China</option>
                      <option value="Malaysia">Malaysia</option>
                      <option value="Myanmar">Myanmar</option>
                      <option value="Indonesia">Indonesia</option>
                      <option value="Thailand">Thailand</option>
                      <option value="Vietnam">Vietnam</option>
                      <option disabled="disabled">---------------------------</option>
                      <option value="United States">United States</option> 
                      <option value="United Kingdom">United Kingdom</option> 
                      <option value="Afghanistan">Afghanistan</option>
                      <option value="Albania">Albania</option> 
                      <option value="Algeria">Algeria</option> 
                      <option value="American Samoa">American Samoa</option> 
                      <option value="Andorra">Andorra</option> 
                      <option value="Angola">Angola</option> 
                      <option value="Anguilla">Anguilla</option> 
                      <option value="Antarctica">Antarctica</option> 
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
                      <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option> 
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
                      <option value="Christmas Island">Christmas Island</option>
                      <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option> 
                      <option value="Colombia">Colombia</option> 
                      <option value="Comoros">Comoros</option> 
                      <option value="Congo">Congo</option> 
                      <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option> 
                      <option value="Cook Islands">Cook Islands</option> 
                      <option value="Costa Rica">Costa Rica</option> 
                      <option value="Cote D'ivoire">Cote D'ivoire</option> 
                      <option value="Croatia">Croatia</option> 
                      <option value="Cuba">Cuba</option> 
                      <option value="Cyprus">Cyprus</option> 
                      <option value="Czech Republic">Czech Republic</option> 
                      <option value="Denmark">Denmark</option> 
                      <option value="Djibouti">Djibouti</option> 
                      <option value="Dominica">Dominica</option> 
                      <option value="Dominican Republic">Dominican Republic</option> 
                      <option value="Ecuador">Ecuador</option> 
                      <option value="Egypt">Egypt</option> 
                      <option value="El Salvador">El Salvador</option> 
                      <option value="Equatorial Guinea">Equatorial Guinea</option> 
                      <option value="Eritrea">Eritrea</option> 
                      <option value="Estonia">Estonia</option> 
                      <option value="Ethiopia">Ethiopia</option> 
                      <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option> 
                      <option value="Faroe Islands">Faroe Islands</option> 
                      <option value="Fiji">Fiji</option> 
                      <option value="Finland">Finland</option> 
                      <option value="France">France</option> 
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
                      <option value="Guinea-bissau">Guinea-bissau</option> 
                      <option value="Guyana">Guyana</option> 
                      <option value="Haiti">Haiti</option> 
                      <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option> 
                      <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option> 
                      <option value="Honduras">Honduras</option>
                      <option value="Hungary">Hungary</option>
                      <option value="Iceland">Iceland</option> 
                      <option value="India">India</option> 
                      <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
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
                      <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option> 
                      <option value="Korea, Republic of">Korea, Republic of</option> 
                      <option value="Kuwait">Kuwait</option> 
                      <option value="Kyrgyzstan">Kyrgyzstan</option> 
                      <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option> 
                      <option value="Latvia">Latvia</option> 
                      <option value="Lebanon">Lebanon</option> 
                      <option value="Lesotho">Lesotho</option> 
                      <option value="Liberia">Liberia</option> 
                      <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option> 
                      <option value="Liechtenstein">Liechtenstein</option> 
                      <option value="Lithuania">Lithuania</option> 
                      <option value="Luxembourg">Luxembourg</option> 
                      <option value="Macao">Macao</option> 
                      <option value="Macedonia">Macedonia</option> 
                      <option value="Madagascar">Madagascar</option> 
                      <option value="Malawi">Malawi</option>
                      <option value="Maldives">Maldives</option>
                      <option value="Mali">Mali</option> 
                      <option value="Malta">Malta</option> 
                      <option value="Marshall Islands">Marshall Islands</option> 
                      <option value="Martinique">Martinique</option> 
                      <option value="Mauritania">Mauritania</option> 
                      <option value="Mauritius">Mauritius</option> 
                      <option value="Mayotte">Mayotte</option> 
                      <option value="Mexico">Mexico</option> 
                      <option value="Micronesia, Federated States of">Micronesia, Federated States of</option> 
                      <option value="Moldova, Republic of">Moldova, Republic of</option> 
                      <option value="Monaco">Monaco</option> 
                      <option value="Mongolia">Mongolia</option> 
                      <option value="Montserrat">Montserrat</option> 
                      <option value="Morocco">Morocco</option> 
                      <option value="Mozambique">Mozambique</option>
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
                      <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option> 
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
                      <option value="Russian Federation">Russian Federation</option> 
                      <option value="Rwanda">Rwanda</option> 
                      <option value="Saint Helena">Saint Helena</option> 
                      <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
                      <option value="Saint Lucia">Saint Lucia</option> 
                      <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option> 
                      <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option> 
                      <option value="Samoa">Samoa</option> 
                      <option value="San Marino">San Marino</option> 
                      <option value="Sao Tome and Principe">Sao Tome and Principe</option> 
                      <option value="Saudi Arabia">Saudi Arabia</option> 
                      <option value="Senegal">Senegal</option> 
                      <option value="Serbia and Montenegro">Serbia and Montenegro</option> 
                      <option value="Seychelles">Seychelles</option> 
                      <option value="Sierra Leone">Sierra Leone</option>
                      <option value="Slovakia">Slovakia</option>
                      <option value="Slovenia">Slovenia</option> 
                      <option value="Solomon Islands">Solomon Islands</option> 
                      <option value="Somalia">Somalia</option> 
                      <option value="South Africa">South Africa</option> 
                      <option value="South Georgia">South Georgia</option> 
                      <option value="Spain">Spain</option> 
                      <option value="Sri Lanka">Sri Lanka</option> 
                      <option value="Sudan">Sudan</option> 
                      <option value="Suriname">Suriname</option> 
                      <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option> 
                      <option value="Swaziland">Swaziland</option> 
                      <option value="Sweden">Sweden</option> 
                      <option value="Switzerland">Switzerland</option> 
                      <option value="Syrian Arab Republic">Syrian Arab Republic</option> 
                      <option value="Taiwan, Province of China">Taiwan, Province of China</option> 
                      <option value="Tajikistan">Tajikistan</option> 
                      <option value="Tanzania, United Republic of">Tanzania, United Republic of</option> 
                      <option value="Timor-leste">Timor-leste</option>
                      <option value="Togo">Togo</option>
                      <option value="Tokelau">Tokelau</option>
                      <option value="Tonga">Tonga</option> 
                      <option value="Trinidad and Tobago">Trinidad and Tobago</option> 
                      <option value="Tunisia">Tunisia</option> 
                      <option value="Turkey">Turkey</option> 
                      <option value="Turkmenistan">Turkmenistan</option> 
                      <option value="Turks and Caicos Islands">Turks and Caicos Islands</option> 
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
                      <option value="Virgin Islands, British">Virgin Islands, British</option>
                      <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option> 
                      <option value="Wallis and Futuna">Wallis and Futuna</option> 
                      <option value="Western Sahara">Western Sahara</option> 
                      <option value="Yemen">Yemen</option> 
                      <option value="Zambia">Zambia</option> 
                      <option value="Zimbabwe">Zimbabwe</option>
                      </select>
                    </div>

                     <div class="form-group col-md-6 no-left-padding">
                      <label for="exampleInputUrl">State:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="ti-world"></i></span>
                        <input name="state" class="form-control" id="exampleInputUrl" value="<?php echo $my_state; ?>" type="text">
                      </div>
                    </div>

                    <div class="form-group col-md-6 no-left-padding">
                      <label for="exampleInputCity">City:</label>
                      <input name="city" value="<?php echo $my_city; ?> " class="form-control" id="exampleInputCity" type="text">
                    </div>

                    <div class="form-group col-md-6 no-right-padding">
                      <label for="exampleInputZip">Zip Code / Postal Code:</label>
                      <input name="zip" value="<? echo $my_zipcode; ?>" class="form-control" id="exampleInputZip" type="text">
                    </div>

                     <div class="form-group col-md-6 no-left-padding">
                      <label for="exampleInputCity">Contact Number: (Example : 234808080808)</label>
                      <input name="phone" value="<?php echo $my_phoneNo; ?>" readonly="" class="form-control" id="exampleInputCity" type="text">
                    </div>

                    <div class="form-group col-md-6 no-right-padding">
                      <label for="exampleInputZip">Date Of Birth (yyyy-mm-dd):</label>
                      <input name="dob" value="<?php echo $my_dob; ?>" class="form-control" id="exampleInputZip" type="text">
                    </div>
                    <br>
                    <div class="form-group col-md-12 no-left-padding">
                      <label for="exampleInputState">Gender:</label>
                      <select class="form-control" disabled="disabled" name="gend" id="exampleInputState">
                        <option value="<?php  echo $my_gender; ?>"><?php  echo $my_gender; ?></option>
                      </select>       
                    </div>

                     <div class="form-group col-md-12 no-right-padding" style="margin-left:1px ">
                      <label for="exampleInputState">Marital Status:</label>
                      <select class="form-control" name="marital" id="exampleInputState">
                        <option value="<?php echo $my_marital; ?>"><?php echo $my_marital; ?></option>
                         <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Other">Other</option>
                      </select>       
                    </div>
                   
<div class="form-group col-md-6 no-left-padding">
                      <label for="exampleInputCity">Nominee Name:</label>
                      <input name="nf1" value="" class="form-control" id="exampleInputCity" type="text">
                    </div>
<div class="form-group col-md-6 no-left-padding">
                      <label for="exampleInputCity">Relationship Relation:</label>
                      <input name="nf2" value="" class="form-control" id="exampleInputCity" type="text">
                    </div>

<div class="form-group col-md-6 no-left-padding">
                      <label for="exampleInputCity">Nominee Date of Birth:</label>
                      <input name="nf3" value="" class="form-control" id="exampleInputCity" type="text">
                    </div>
<div class="form-group col-md-6 no-left-padding">
                      <label for="exampleInputCity">Nominee Contact:</label>
                      <input name="nf4" value="" class="form-control" id="exampleInputCity" type="text">
                    </div>

            <div class="row">
            <div class="col-md-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
              <div class="panel">
                <div class="panel-body">
                  <input name="submit" value="Update" class="btn btn-primary" type="submit" style="background:#daa520 !important;color:#fff;">
                </div>
              </div>
            </div>
          </div>

                            </form>
                </div>
              </section>

            </div> <!-- / col-md-6 -->

            <div class="col-md-6 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
         
         <form name="bankinfo1" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                  
                  
                <input name="updatebank" id="updatebank" hidden="hidden" />

                <header class="panel-heading">
                  <h3 class="panel-title">Update Bank Information</h3>
                </header>
                <div class="panel-body">

           <div class="form-group">
                      <label for="exampleInputAddress">Account Name</label>
                      <div class="input-group">
                        <span class="input-group-addon"></span>
                        <input name="Account1" value="<?php echo $my_accName; ?>" class="form-control" id="exampleInputAddress" type="text">
                      </div>
                    </div>

           <div class="form-group">
                      <label for="exampleInputAddress">Account Number</label>
                      <div class="input-group">
                        <span class="input-group-addon"></span>
                        <input name="Account2" value="<?php echo $my_accNo; ?>" class="form-control" id="exampleInputAddress" type="text">
                      </div>
                    </div>
                <div class="form-group">
                      <label for="exampleInputAddress">Bank Name</label>
                      <div class="input-group">
                        <span class="input-group-addon"></span>
                        <input name="Account3" value="<?php echo $my_bankName; ?>" class="form-control" id="exampleInputAddress" type="text">
                      </div>
                    </div>
              
                <div class="form-group">
                      <label for="exampleInputAddress">Branch Name</label>
                      <div class="input-group">
                        <span class="input-group-addon"></span>
                        <input name="Account4" value="" class="form-control" id="exampleInputAddress" type="text">
                      </div>
                    </div>
              
                <div class="form-group">
                      <label for="exampleInputAddressI">Ifsc / Swift Code</label>
                      <div class="input-group">
                        <span class="input-group-addon"></span>
                        <input name="Account5" value="" class="form-control" id="exampleInputAddressI" type="text">
                      </div>
                    </div>
              

                </div>
                 <div class="row">
            <div class="col-md-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
              <div class="panel">
                <div class="panel-body">
                  <input name="update" value="Update" class="btn btn-primary" type="submit" style="background:#daa520 !important;color:#fff;">             </div>
              </div>
            </div>
          </div>

              </section>

</form>

              <form name="image"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
              <section class="panel">
<input name="updatepic" id="updatepic" hidden="hidden" />
                <header class="panel-heading">
                  <h3 class="panel-title">Change Profile Photo</h3>
                </header>
                <header class="panel-heading">
                  <h3 class="panel-title">Note : Image size should not be more than 200 kb</h3>
                </header>
                <div class="panel-body">

                            <div style="text-align:center;"> <img src="uploads/profilepic/<?php echo $my_urltoimg;?>" style="border:2px solid #000; width:200px;"></div><br>
            <div class="form-group">
                      <label for="exampleInputFile">Picture</label>
                      <input name="fileToUpload" id="exampleInputFile" required="" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);" tabindex="-1" type="file"><div class="bootstrap-filestyle input-group"></div>
                    </div>
              

                </div>
                
                 <div class="row">
            <div class="col-md-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
              <div class="panel">
                <div class="panel-body">
                  <input name="modify" value="Upload" class="btn btn-primary" type="submit" style="background:#daa520 !important;color:#fff;">
                </div>
              </div>
            </div>
          </div> 
              </section>

</form>
              <!-- / section -->

            </div>

          </div> <!-- / row -->

         

        </div> <!-- / container-fluid -->


<?php include('footer.php'); ?>