<?php

	error_reporting( ~E_DEPRECATED & ~E_NOTICE );
$db_host='localhost';

// $db_user='guthkppn_user';

// $db_password='Zp2omG10t1';

$database='guthkppn_user2';

$db_password='jboy01';

$db_user='root';

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
  <p> <br/>
  '.$message.'

</p>
  <p>
Thank you for choosing Uplinks!

Best regards,

Admin,

Uplinks Global Concept,

#YourWorldofFinancialFreedom.

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
$headers .= 'From: Uplinks <support@uplinks.biz>' . "\r\n";


// Mail it

$send_am = mail($to, $subject, $msg, $headers);
if($send_am){
return 1;
}else{
return 0;
}
}
