<?php
/**
 * @author Akintola Oluwaseun
 * @copyright 2017
 */


//ob_start();
session_start();
if(!isset($_SESSION['user'])) {
    ?>
    <script type="text/javascript">
        document.location.href="index.php?msg=Thank you ! You are now logged out!";
    </script>

    <?php
    die();
} else {

    ?>


    <?php

    ?>

    <?php
    require_once 'dbconnect.php';
    require_once 'functions.php';
// select loggedin users detail
    $ses = $_SESSION['user'];

    $ut = $_SESSION['userType'];
    $res = mysqli_query($dbc, "SELECT * FROM user_table WHERE email='$ses'");
    $userRow = mysqli_fetch_array($res);
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
    $name = $userRow['lastName'] . ' ' . $userRow['firstName'];


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
    $desc = array($desc1, $desc2, $desc3, $desc4, $desc5, $desc6);


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc1'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $desc1 = $user_row[email] . "<br> " . $user_row[firstName] . " " . $user_row[lastName] . "<br> " . $user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc2'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $desc2 = $user_row[email] . " <br>" . $user_row[firstName] . " " . $user_row[lastName] . "<br> " . $user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc3'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $desc3 = $user_row[email] . "<br> " . $user_row[firstName] . " " . $user_row[lastName] . "<br> " . $user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc4'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $desc4 = $user_row[email] . "<br> " . $user_row[firstName] . " " . $user_row[lastName] . " <br>" . $user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc5'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $desc5 = $user_row[email] . "<br> " . $user_row[firstName] . " " . $user_row[lastName] . " <br>" . $user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc6'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $desc6 = $user_row[email] . "<br> " . $user_row[firstName] . " " . $user_row[lastName] . " <br>" . $user_row[myid];

    if (isset($_POST['btn-paid'])) {
        $ema = trim($_POST['email']);
        mysqli_query($dbc, "DELETE FROM pending WHERE email='$ema'");
        mysqli_query($dbc, "INSERT INTO to_receive(userName,firstName,lastName,phoneNo,accName,accNo,email,bankName,package) SELECT userName,firstName,lastName,phoneNo,accName,accNo,email,bankName,package FROM user_table WHERE email='$ema'");
        unset($ema);

    }


    function generatePageTree($datas, $parent = '0', $depth = 0)
    {
        $ni = count($datas);
        $haschild = false;
        if ($ni == 0 || $depth > 2000) return ''; // Make sure not to have an endless recursion
        for ($i = 0; $i < $ni; $i++) {
            if ($datas[$i]['parent'] == $parent) {
                $haschild = true;
            }
        }
        if ($haschild == true) {
            $tree = '<ul>';
        }
        for ($i = 0; $i < $ni; $i++) {
            if ($datas[$i]['parent'] == $parent) {
                $tree .= '<li>';
                $tree .= $datas[$i]['name'];
                $tree .= generatePageTree($datas, $datas[$i]['id'], $depth + 1);
                $tree .= '</li>';
            }
        }
        if ($haschild == true) {
            $tree .= '</ul>';
        }
        return $tree;
    }
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
    searchmym($myid);
 //print_r($datas);
     //  $key = array_search('1509227175-1630127167', $array);
      if (in_array($user_todisplay, array_column($datas, 'id'))){echo "Success!! User found";
      
 $datas = array();
  getmym($user_todisplay, 1);
  //print_r($datas);
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

 
<div class="tree" style="height:auto ;width:3000px !important">
<?php 
echo(generatePageTree($datas));
            ?>
            
            </div>    
     <?php 
      
      
      
      }else {echo "Sorry, this user is not in your downliine link";
      
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
       <?php
      }
    }else{ 

 $datas = array();
 
 
 getmym($myid, 1);


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
        <td align="center"><img src="assets/img/stage0.png" width="32" height="42" /></td>
        <td align="center"><img src="assets/img/stage1.png" width="32" height="42" /></td>
            <td align="center"><img src="assets/img/stage2.png" width="32" height="42" /></td>
            <td align="center"><img src="assets/img/stage3.png" width="32" height="42" /></td>
        <td align="center"><img src="assets/img/stage4.png" width="32" height="42" /></td>
            <td align="center" ><img src="assets/img/stage5.png" width="32" height="42" /></td>
            
        </tr>
    </table>
                      
   </body>
      
      </html>