<?php
session_start();
if ($_SESSION['user']!="" ) {
    if ($_SESSION['userType'] == 1){
        //login to the seleected user account 
        require_once 'dbconnect.php';

        // prevent sql injections
        $user = trim($_GET['user']);
        $user = strip_tags($user);
        $user = htmlspecialchars($user);

        //log into the selected username account with only the username
        $res=mysqli_query($dbc,"SELECT * FROM user_table WHERE userName='$user'");
        $row=mysqli_fetch_array($res);
        $count = mysqli_num_rows($res);

        if( $count == 1 && $row['block']=='No') {
            $_SESSION['user'] = $row['email'];
            $_SESSION['userType'] = $row['userType'];
            header("Location: dashboard.php");
        }
        elseif( $count == 1 && $row['block']=='Yes')
            $errMSG = "You have been blocked. Please contact Admin.";
        else {
            $error = true;
            $errMSG = "Incorrect Credentials, Try again...";
        }
    }
    else{
        header("Location: dashboard.php");
    }

}
else{
    header("Location: index.php");
}
?>