<?php

	error_reporting( ~E_DEPRECATED & ~E_NOTICE );
$db_host='localhost';

$db_user='admin2';

$db_password='admin2';

$database='uplinks';

$dbc = mysqli_connect("$db_host","$db_user","$db_password","$database") or die ('Error connecting to Database');

$url = "http://uplinks.biz";



function mail_user($user,$name,$subject,$message){

//refer user to email
	$to  = $user;

// subject
$subject = $subject;

// message
$msg = '
<html>
<head>
<title>'.$subject.'</title>
</head>
<body>
  <p>Hello '.$name.' <br/>
  '.$message.'

</p>
  Please <a href="'.$url.'/contact_us.php">contact us</a> if you have further questions
  <p>
  Warm regards<br/>
  Uplinks International<br/>
  <a href="http://uplinks.biz">www.uplinks.biz</a><br/>
  Find Uplinks on Facebook | Twitter | Google+ | Skype !!!<br/>
  
  <br/>
  </p>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: The Connector <support@uplinks.biz>' . "\r\n";
$headers .= 'Cc: support@uplinks.biz' . "\r\n";


// Mail it

$send_am = mail($to, $subject, $msg, $headers);
if($send_am){
return 1;
}else{
return 0;
}
}
