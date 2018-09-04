
<?php
require_once 'dbconnect.php';



if(isset($_POST['user_name']))
{
 $name=$_POST['user_name'];

 $checkdata=" SELECT userName FROM user_table WHERE userName ='$name' ";

 $query=mysqli_query($dbc,$checkdata);

 if(mysqli_num_rows($query)>0)
 {
  echo "Success User exists";
 }
 else
 {
  echo "OK";
 }
 exit();
}

if(isset($_POST['user_email']))
{
 $emailId=$_POST['user_email'];

 $checkdata=" SELECT email FROM user_table WHERE email='$emailId' ";

 $query=mysqli_query($dbc,$checkdata);

 if(mysqli_num_rows($query)>0)
 {
  echo "Email Already Exist";
 }
 else
 {
  echo "OK";
 }
 exit();
}
?>