<?php
/**
 * @author Akintola Oluwaseun
 * @copyright 2017
 */

//ob_start();
session_start();
if(!isset($_SESSION['user'])) { ?>

    <script type="text/javascript">
        document.location.href="index.php?msg=Thank you ! You are now logged out!";
    </script>

<?php

    die();

}
else {

    /**
     * To work on this page, you need to have a goo knowledge og laravel eleoquent
     * This page was modified to use eloquent for easier management
     */

    require_once 'app/init.php';
    require_once 'includes/TranversalTree.php';

    $user = new User();
    $tree = new TranversalTree();

    $username = $_SESSION['user'];
    $user = User::where('email', $username)->first();
//    dd($tree->compute($user->myid));
    $userTree = $tree->DisplayTranversalTree($user->myid);
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
<div class="tree text-center" style="overflow: visible; width: 2000px !important">
<?php echo $userTree ?>
</div>

<!--<div style="margin-top: 150px; height:5px; background-color: #1f77b4"></div>-->
    <table style="" width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
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