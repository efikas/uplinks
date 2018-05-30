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
	
	if( isset($_POST['btn-login']) ) {

        include_once 'securimage/securimage.php';
        $securimage = new Securimage();
        if ($securimage->check($_POST['captcha_code']) == false) {
            // the code was incorrect
            // you should handle the error so that the form processor doesn't continue

            // or you can use the following code if there is no validation or you do not know how
            echo "The security code entered was incorrect.<br /><br />";
            echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
            exit;
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
			
			if( $count == 1 && $row['password']==$password && $row['userType']=='1') {
				$_SESSION['user'] = $row['email'];
                $_SESSION['userType'] = $row['userType'];
				header("Location: dashboard.php");
			} else if( $count == 1 && $row['password']==$password) {
				$_SESSION['user'] = $row['email'];
                $_SESSION['userType'] = $row['userType'];
				header("Location: dashboard.php");
			} else {
				$errMSG = "Incorrect Credentials, Try again...";
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Uplinks Login Panel </title>

    <!-- Bootstrap -->
    <link href="User%20Back%20Office%20Login%20Panel_files/bootstrap.css" rel="stylesheet">
    <link href="User%20Back%20Office%20Login%20Panel_files/css.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="themify-icons/themify-icons.css">
    <link rel="stylesheet" href="securimage/securimage.css">
    <link href="User%20Back%20Office%20Login%20Panel_files/style.css" rel="stylesheet" type="text/css">
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">div.image {max-width: 256px;max-height: 256px;background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE2cHgiIGhlaWdodD0iMTZweCIgdmlld0JveD0iMCAwIDkwIDkwIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA5MCA5MDsiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8Zz4KCTxwYXRoIGlkPSJXaGF0c0FwcCIgZD0iTTkwLDQzLjg0MWMwLDI0LjIxMy0xOS43NzksNDMuODQxLTQ0LjE4Miw0My44NDFjLTcuNzQ3LDAtMTUuMDI1LTEuOTgtMjEuMzU3LTUuNDU1TDAsOTBsNy45NzUtMjMuNTIyICAgYy00LjAyMy02LjYwNi02LjM0LTE0LjM1NC02LjM0LTIyLjYzN0MxLjYzNSwxOS42MjgsMjEuNDE2LDAsNDUuODE4LDBDNzAuMjIzLDAsOTAsMTkuNjI4LDkwLDQzLjg0MXogTTQ1LjgxOCw2Ljk4MiAgIGMtMjAuNDg0LDAtMzcuMTQ2LDE2LjUzNS0zNy4xNDYsMzYuODU5YzAsOC4wNjUsMi42MjksMTUuNTM0LDcuMDc2LDIxLjYxTDExLjEwNyw3OS4xNGwxNC4yNzUtNC41MzcgICBjNS44NjUsMy44NTEsMTIuODkxLDYuMDk3LDIwLjQzNyw2LjA5N2MyMC40ODEsMCwzNy4xNDYtMTYuNTMzLDM3LjE0Ni0zNi44NTdTNjYuMzAxLDYuOTgyLDQ1LjgxOCw2Ljk4MnogTTY4LjEyOSw1My45MzggICBjLTAuMjczLTAuNDQ3LTAuOTk0LTAuNzE3LTIuMDc2LTEuMjU0Yy0xLjA4NC0wLjUzNy02LjQxLTMuMTM4LTcuNC0zLjQ5NWMtMC45OTMtMC4zNTgtMS43MTctMC41MzgtMi40MzgsMC41MzcgICBjLTAuNzIxLDEuMDc2LTIuNzk3LDMuNDk1LTMuNDMsNC4yMTJjLTAuNjMyLDAuNzE5LTEuMjYzLDAuODA5LTIuMzQ3LDAuMjcxYy0xLjA4Mi0wLjUzNy00LjU3MS0xLjY3My04LjcwOC01LjMzMyAgIGMtMy4yMTktMi44NDgtNS4zOTMtNi4zNjQtNi4wMjUtNy40NDFjLTAuNjMxLTEuMDc1LTAuMDY2LTEuNjU2LDAuNDc1LTIuMTkxYzAuNDg4LTAuNDgyLDEuMDg0LTEuMjU1LDEuNjI1LTEuODgyICAgYzAuNTQzLTAuNjI4LDAuNzIzLTEuMDc1LDEuMDgyLTEuNzkzYzAuMzYzLTAuNzE3LDAuMTgyLTEuMzQ0LTAuMDktMS44ODNjLTAuMjctMC41MzctMi40MzgtNS44MjUtMy4zNC03Ljk3NyAgIGMtMC45MDItMi4xNS0xLjgwMy0xLjc5Mi0yLjQzNi0xLjc5MmMtMC42MzEsMC0xLjM1NC0wLjA5LTIuMDc2LTAuMDljLTAuNzIyLDAtMS44OTYsMC4yNjktMi44ODksMS4zNDQgICBjLTAuOTkyLDEuMDc2LTMuNzg5LDMuNjc2LTMuNzg5LDguOTYzYzAsNS4yODgsMy44NzksMTAuMzk3LDQuNDIyLDExLjExM2MwLjU0MSwwLjcxNiw3LjQ5LDExLjkyLDE4LjUsMTYuMjIzICAgQzU4LjIsNjUuNzcxLDU4LjIsNjQuMzM2LDYwLjE4Niw2NC4xNTZjMS45ODQtMC4xNzksNi40MDYtMi41OTksNy4zMTItNS4xMDdDNjguMzk4LDU2LjUzNyw2OC4zOTgsNTQuMzg2LDY4LjEyOSw1My45Mzh6IiBmaWxsPSIjRkZGRkZGIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==)}</style>    <script type="text/javascript">

    function refreshCaptcha()
    { 
     var img = document.images['captchaimg'];
     img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
    
    }
    </script>
  </head>

<body class="login-page">
    <div class="animsition" style="animation-duration: 1.5s; opacity: 1;">

      <main class="login-container">

        <div class="panel-container">
          <section class="panel" style="width:333px !important;">
            <header class="panel-heading">
             <img src="dashboard_files/logo-inverse.png" class="big-logo" style="width:250px;">
              <h2>User Login Panel</h2>
            </header>
            <div class="panel-body">
              <!--<form action="../post-action.php" method="post">-->
              <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
               <input name="action" value="loginuser" type="hidden">
               <p class="text-center"></p><div style="color:red; font-size:14px; font-weight:bold;"><span style="color:#F00;padding-left:10px;"></span></div><p></p>
                                 <div class="form-group">
                  <label for="username">Email</label>
                  
            	<div class="input-group">
                 <input type="text" name="email" class="form-control" placeholder="Your Username" value="<?php echo $email; ?>" maxlength="40" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
                </div>

                <div class="form-group">
                
            	<div class="input-group">
                  <label for="password">Password</label> 
                  <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
                  </div>
                <span class="text-danger"><?php echo $passError; ?></span>
                </div>

                  <div class="form-group">
                      <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
                      <input type="text" name="captcha_code" size="10" maxlength="6" />

                      <a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
                  </div>
                

                <div class="form-group text-center">
                  <button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
                </div>

              <hr>
                <div class="social-login">
                  <p class="text-center">Connect with us on social media
              </p>
                 <p class="text-center"><a href="https://www.facebook.com/uplinksbiz" target="_blank"><i class="ti-facebook"></i></a>
                     <a  href="https://chat.whatsapp.com/A3zyeEThvLC3iKmVu5q4te" target="_blank"><img style="margin-bottom: 10%;" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE2cHgiIGhlaWdodD0iMTZweCIgdmlld0JveD0iMCAwIDkwIDkwIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA5MCA5MDsiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8Zz4KCTxwYXRoIGlkPSJXaGF0c0FwcCIgZD0iTTkwLDQzLjg0MWMwLDI0LjIxMy0xOS43NzksNDMuODQxLTQ0LjE4Miw0My44NDFjLTcuNzQ3LDAtMTUuMDI1LTEuOTgtMjEuMzU3LTUuNDU1TDAsOTBsNy45NzUtMjMuNTIyICAgYy00LjAyMy02LjYwNi02LjM0LTE0LjM1NC02LjM0LTIyLjYzN0MxLjYzNSwxOS42MjgsMjEuNDE2LDAsNDUuODE4LDBDNzAuMjIzLDAsOTAsMTkuNjI4LDkwLDQzLjg0MXogTTQ1LjgxOCw2Ljk4MiAgIGMtMjAuNDg0LDAtMzcuMTQ2LDE2LjUzNS0zNy4xNDYsMzYuODU5YzAsOC4wNjUsMi42MjksMTUuNTM0LDcuMDc2LDIxLjYxTDExLjEwNyw3OS4xNGwxNC4yNzUtNC41MzcgICBjNS44NjUsMy44NTEsMTIuODkxLDYuMDk3LDIwLjQzNyw2LjA5N2MyMC40ODEsMCwzNy4xNDYtMTYuNTMzLDM3LjE0Ni0zNi44NTdTNjYuMzAxLDYuOTgyLDQ1LjgxOCw2Ljk4MnogTTY4LjEyOSw1My45MzggICBjLTAuMjczLTAuNDQ3LTAuOTk0LTAuNzE3LTIuMDc2LTEuMjU0Yy0xLjA4NC0wLjUzNy02LjQxLTMuMTM4LTcuNC0zLjQ5NWMtMC45OTMtMC4zNTgtMS43MTctMC41MzgtMi40MzgsMC41MzcgICBjLTAuNzIxLDEuMDc2LTIuNzk3LDMuNDk1LTMuNDMsNC4yMTJjLTAuNjMyLDAuNzE5LTEuMjYzLDAuODA5LTIuMzQ3LDAuMjcxYy0xLjA4Mi0wLjUzNy00LjU3MS0xLjY3My04LjcwOC01LjMzMyAgIGMtMy4yMTktMi44NDgtNS4zOTMtNi4zNjQtNi4wMjUtNy40NDFjLTAuNjMxLTEuMDc1LTAuMDY2LTEuNjU2LDAuNDc1LTIuMTkxYzAuNDg4LTAuNDgyLDEuMDg0LTEuMjU1LDEuNjI1LTEuODgyICAgYzAuNTQzLTAuNjI4LDAuNzIzLTEuMDc1LDEuMDgyLTEuNzkzYzAuMzYzLTAuNzE3LDAuMTgyLTEuMzQ0LTAuMDktMS44ODNjLTAuMjctMC41MzctMi40MzgtNS44MjUtMy4zNC03Ljk3NyAgIGMtMC45MDItMi4xNS0xLjgwMy0xLjc5Mi0yLjQzNi0xLjc5MmMtMC42MzEsMC0xLjM1NC0wLjA5LTIuMDc2LTAuMDljLTAuNzIyLDAtMS44OTYsMC4yNjktMi44ODksMS4zNDQgICBjLTAuOTkyLDEuMDc2LTMuNzg5LDMuNjc2LTMuNzg5LDguOTYzYzAsNS4yODgsMy44NzksMTAuMzk3LDQuNDIyLDExLjExM2MwLjU0MSwwLjcxNiw3LjQ5LDExLjkyLDE4LjUsMTYuMjIzICAgQzU4LjIsNjUuNzcxLDU4LjIsNjQuMzM2LDYwLjE4Niw2NC4xNTZjMS45ODQtMC4xNzksNi40MDYtMi41OTksNy4zMTItNS4xMDdDNjguMzk4LDU2LjUzNyw2OC4zOTgsNTQuMzg2LDY4LjEyOSw1My45Mzh6IiBmaWxsPSIjRkZGRkZGIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" /></a>
                     <a  href="https://www.instagram.com/uplinksbiz" target="_blank"><i class="ti-instagram"></i></a>
                     <a  href="https://www.twitter.com/uplinksbiz" target="_blank"><i class="ti-twitter"></i></a>
                     <a  href="http://www.youtube.com/playlist?list=PLTDwP0gFbqmzgIUibwJvDExpCb0HgXwPT" target="_blank"><i class="ti-youtube"></i></a>
                 </p>
                </div>
              </form><!--Site under maintenance due to heavy traffic and load currently we will resume soon.-->
              <hr>
              <div class="register-now">
                Not registered? <a href="https://uplinks.biz/users/reg.php">Register now</a>
              </div>
            </div>
          </section>
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