<html>
<head>

</head>
<body>
	
<form method="POST" action="insertdata.php" onsubmit="return checkall();">
 <input type="text" name="username" id="UserName" onkeyup="checkname();">
 <span id="name_status"></span>
 <br>
 <input type="text" name="useremail" id="UserEmail" onkeyup="checkemail();">
 <span id="email_status"></span>
 <br>
 <input type="password" name="userpass" id="UserPassword">
 <br>
 <input type="submit" name="submit_form" value="Submit">
</form>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.js"></script>
<script type="text/javascript">

function checkname()
{
 var name=document.getElementById( "UserName" ).value;
	
 if(name)
 {
  $.ajax({
  type: 'post',
  url: 'checkuserapi.php',
  data: {
   user_name:name,
  },
  success: function (response) {
   $( '#name_status' ).html(response);
   if(response=="OK")	
   {
    return true;	
   }
   else
   {
    return false;	
   }
  }
  });
 }
 else
 {
  $( '#name_status' ).html("");
  return false;
 }
}

function checkemail()
{
 var email=document.getElementById( "UserEmail" ).value;
	
 if(email)
 {
  $.ajax({
  type: 'post',
  url: 'checkuserapi.php',
  data: {
   user_email:email,
  },
  success: function (response) {
   $( '#email_status' ).html(response);
   if(response=="OK")	
   {
    return true;	
   }
   else
   {
    return false;	
   }
  }
  });
 }
 else
 {
  $( '#email_status' ).html("");
  return false;
 }
}

function checkall()
{
 var namehtml=document.getElementById("name_status").innerHTML;
 var emailhtml=document.getElementById("email_status").innerHTML;

 if((namehtml && emailhtml)=="OK")
 {
  return true;
 }
 else
 {
  return false;
 }
}

</script>	
</body>
</html>