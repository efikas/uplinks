<?php

//use \includes\Tree as Tree;
//
//use

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

  require_once 'app/init.php';
  require_once 'includes/Tree.php';
  
  $user = new User();
  $tree = new Tree();
  
  $username = $_SESSION['user'];
  $user = User::where('email', $username)->first();

//   dd($_SESSION['user']);
  $userTree = $tree->DisplayTree($user->myid);

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
 
 
//  getmym($myid, 1);


?>
<table style="width:100%;text-align:center;border:2px solid #000;">
<tr><td><img src="dashboard_files/logo-inverse.png" style="width:300px;"></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><h3>Downline Member Genealogy of <?php echo $user->myid; ?></h3></td></tr>
</table>
<form name="info" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
<input type="hidden" name="url" value="metrixlevel.php">
<table style="width:100%;text-align:center;border:2px solid #000;">

<tr><td>Search a downline member : <input name="userN" type="text"/>&nbsp;&nbsp;<input type="submit" name="submit" value="Search"></td></tr>
</table>
</form>
<div class="tree" style="height:auto; width:auto !important; overflow: visible;">
<?php 
    // echo(generatePageTree($datas));
    echo $userTree
?>
   </div>
<?php } ?>
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