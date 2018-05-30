 
 <?php

/**
 * @author Akintola Oluwaseun 
 * @copyright 2017
 */
 // reference http://www.niksofteng.com/2013/07/draw-hierarchical-tree-in-html-using.html
 // reference https://developers.google.com/chart/interactive/docs/gallery/orgchart
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	require_once 'functions.php';
	
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: index.php");
		exit;
	}
	// select loggedin users detail
    $ses = $_SESSION['user'];
    
	$ut = $_SESSION['userType'];
	$res=mysqli_query($dbc,"SELECT * FROM user_table WHERE email='$ses'");
	$userRow=mysqli_fetch_array($res);
        $myid = $userRow['myid'];
        $emai = $userRow['email'];
        $my_userName = $userRow['userName'];
        $my_firstName = $userRow['firstName'];
        $my_lastName = $userRow['lastName'];
        $my_occupation = $userRow['occupation'];
        $my_address = $userRow['address'];
        $my_city = $userRow['city'];
        $my_state = $userRow['state'];
        $my_phoneNo = $userRow['phoneNo'];
        $my_bankName = $userRow['bankName'];
        $my_accNo = $userRow['accNo'];
        $my_accName = $userRow['accName'];
        $my_urltoimg = $userRow['urltoimg'];
        $my_dob = $userRow['dob'];
        $my_dor = $userRow['added'];
        $my_marital = $userRow['marital'];
        $my_gender = $userRow['gender'];
        $my_status = $userRow['status'];
        $name = $userRow['lastName'].' '.$userRow['firstName'];


$query2 = "SELECT * FROM `user_rank` WHERE `superior_id` = '$myid'";
$res2 = mysqli_query($dbc, $query2);
$row2 = mysqli_fetch_array($res2);
//$number = mysqli_result($res2);
$number = count($row2);

$query = "SELECT * FROM `user_rank` WHERE `email` = '$emai'";
$res = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($res);

$my_balance = $row[balance];
$my_stage = $row[stage];
$my_level = $row[level];

$desc1 = $row[desc_1];
$desc2 = $row[desc_2];
$desc3 = $row[desc_3];
$desc4 = $row[desc_4];
$desc5 = $row[desc_5];
$desc6 = $row[desc_6];
$desc = array($desc1,$desc2,$desc3,$desc4,$desc5,$desc6);


$query = "SELECT * FROM `user_table` WHERE `myid` = '$desc1'";
$res = mysqli_query($dbc, $query);
$user_row = mysqli_fetch_array($res);
 $desc1 =   $user_row[email]."<br> ".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];
  

$query = "SELECT * FROM `user_table` WHERE `myid` = '$desc2'";
$res = mysqli_query($dbc, $query);
$user_row = mysqli_fetch_array($res);
 $desc2 =   $user_row[email]." <br>".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];
  

$query = "SELECT * FROM `user_table` WHERE `myid` = '$desc3'";
$res = mysqli_query($dbc, $query);
$user_row = mysqli_fetch_array($res);
 $desc3 =   $user_row[email]."<br> ".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];
  

$query = "SELECT * FROM `user_table` WHERE `myid` = '$desc4'";
$res = mysqli_query($dbc, $query);
$user_row = mysqli_fetch_array($res);
 $desc4 =   $user_row[email]."<br> ".$user_row[firstName]." ".$user_row[lastName]." <br>".$user_row[myid];
  

$query = "SELECT * FROM `user_table` WHERE `myid` = '$desc5'";
$res = mysqli_query($dbc, $query);
$user_row = mysqli_fetch_array($res);
 $desc5 =   $user_row[email]."<br> ".$user_row[firstName]." ".$user_row[lastName]." <br>".$user_row[myid];
  

$query = "SELECT * FROM `user_table` WHERE `myid` = '$desc6'";
$res = mysqli_query($dbc, $query);
$user_row = mysqli_fetch_array($res);
 $desc6 =   $user_row[email]."<br> ".$user_row[firstName]." ".$user_row[lastName]." <br>".$user_row[myid];
    
    if( isset($_POST['btn-paid']) ) {
    $ema = trim($_POST['email']);    
    mysqli_query($dbc, "DELETE FROM pending WHERE email='$ema'");
    mysqli_query($dbc, "INSERT INTO to_receive(userName,firstName,lastName,phoneNo,accName,accNo,email,bankName,package) SELECT userName,firstName,lastName,phoneNo,accName,accNo,email,bankName,package FROM user_table WHERE email='$ema'");
        unset($ema);  
    
    }

    if( isset($_POST['spack']) ) {
    $mine= $userRow['email'];
    $q1 = "SELECT * FROM pending WHERE payto='$mine' AND topurge='0'";
    $q=mysqli_query($dbc, $q1);
    if(mysqli_num_rows($q)<1){
    $sp = trim($_POST['sp']);    
    mysqli_query($dbc, "INSERT INTO to_pay(userName,firstName,lastName,phoneNo,bankName,accName,accNo,email) SELECT userName,firstName,lastName,phoneNo,bankName,accName,accNo,email FROM user_table WHERE email='$mine'");
    mysqli_query($dbc, "UPDATE to_pay SET package='$sp' WHERE email='$mine'");
    mysqli_query($dbc, "UPDATE user_table SET package='$sp' WHERE email='$mine'");
    }
            unset($sp);  
    }


	if( isset($_POST['btn-purge']) ) {
        $email = trim($_POST['email']);    
    mysqli_query($dbc,"UPDATE pending SET topurge='1' WHERE email='$email'"); 
        unset($email);  
    }      
    
    
    function generatePageTree($datas, $parent= '0', $depth=0){
    $ni=count($datas);
    if($ni == 0 || $depth > 2000) return ''; // Make sure not to have an endless recursion
    $tree = '<ul>';
    for($i=0; $i < $ni; $i++){
        if($datas[$i]['parent'] == $parent){
            $tree .= '<li>';
            $tree .= $datas[$i]['name'];
            $tree .= generatePageTree($datas, $datas[$i]['id'], $depth+1);
            $tree .= '</li>';
        }
    }
    $tree .= '</ul>';
    return $tree;
}

?>
<!DOCTYPE html>
<html class=" js csstransforms3d csstransitions csstransformspreserve3d" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Welcome to Uplinks Member Dashboard</title>  
    
    <!-- Fonts -->

    <link href="dashboard_files/style.css" rel="stylesheet" type="text/css">
    
    <link href="dashboard_files/verticalbargraph.css" rel="stylesheet" type="text/css">
</head>
<body style="width: auto !important;">
<?php

if( isset($_POST['submit']) ) {
        $userN = trim($_POST['userN']);    
         $query= mysqli_query($dbc,"SELECT * FROM `user_table` WHERE `userName`='$userN'"); 
       $row = mysqli_fetch_array($query);
       $user_todisplay = $row['myid'];
       
 $datas = array();
  getmym($myid);
 //print_r($datas);
     //  $key = array_search('1509227175-1630127167', $array);
      if (in_array($user_todisplay, array_column($datas, 'id'))){echo "Success!! User found";
      
 $datas = array();
  getmym($user_todisplay);
  print_r($datas);
      ?>
      <table style="width:100%;text-align:center;border:2px solid #000;">
<tr><td><img src="dashboard_files/logo-inverse.png" style="width:300px;"></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><h3>Downline Member Genealogy of  <?php echo $myid; ?></h3></td></tr>
</table>
<form name="info" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
<input type="hidden" name="url" value="metrixlevel.php">
<table style="width:100%;text-align:center;border:2px solid #000;">

<tr><td>Search a downline member : <input name="userN" type="text"/>&nbsp;&nbsp;<input type="submit" name="submit" value="Search"></td></tr>
</table></form>

 
<div class="tree" style="height:auto ;width:3000px !important">
<?php 
echo(generatePageTree($datas));
            ?>
            
            </div>    
     <?php 
      
      
      
      }else {echo "Sorry, this user is not in your downliine link";
      
      ?>
       <div> <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"></div><div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input name="userN" type="text"></input> </label></div></form>
       <?php
      }
    }else{ 

 $datas = array();
 
 
 getmym($myid);


?>
<table style="width:100%;text-align:center;border:2px solid #000;">
<tr><td><img src="dashboard_files/logo-inverse.png" style="width:300px;"></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><h3>Downline Member Genealogy of <?php echo $myid; ?></h3></td></tr>
</table>
<form name="info" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
<input type="hidden" name="url" value="metrixlevel.php">
<table style="width:100%;text-align:center;border:2px solid #000;">

<tr><td>Search a downline member : <input name="userN" type="text"/>&nbsp;&nbsp;<input type="submit" name="submit" value="Search"></td></tr>
</table></form>
<div class="tree" style="height:auto;width:3000px !important">
<?php 
echo(generatePageTree($datas));
?>

   </div>

<?php }
            ?>
            
         
            
                   
                      <table style="margin-top: 30px;" width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
                                    <tr>
                                      <td><div align="center"><strong>Blank</strong></div></td>
                                      <td ><div align="center"><strong>Associate Member</strong></div></td>
                                      <td ><div align="center"><strong>Master Member</strong></div></td>
                                      <td ><div align="center"><strong>Super Master</strong></div></td>
                                      <td ><div align="center"><strong>Minister</strong></div></td>
									  <td ><div align="center"><strong>Prime Minister</strong></div></td>
                                     
                                      
                                    </tr>
                                    <tr>
                                    <td align="center"><img src="http://helpinghandsintl.biz/userpaneluser/images/empty.gif" width="32" height="42" /></td>
                                    <td align="center"><img src="http://helpinghandsintl.biz/userpaneluser/images/affil.png" width="32" height="42" /></td>
                                      <td align="center"><img src="http://helpinghandsintl.biz/userpaneluser/images/represent.png" width="32" height="42" /></td>
                                       <td align="center"><img src="http://helpinghandsintl.biz/userpaneluser/images/sm3.gif" width="32" height="42" /></td>
                                   <td align="center"><img src="http://helpinghandsintl.biz/userpaneluser/images/sm2.gif" width="32" height="42" /></td>
                                       <td align="center" ><img src="http://helpinghandsintl.biz/userpaneluser/images/director1.png" width="32" height="42" /></td>
                                       
                                     
                                      
                                    </tr>
                                    
                                  </table>
                      
   </body>
      
      </html>