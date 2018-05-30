<?php
//header('Content-Type: application/json');
require_once '../dbconnect.php';

ob_start();
session_start();
 $user = $_SESSION['user'];

$from = htmlspecialchars(strip_tags(trim($_POST['from'])));
$to = htmlspecialchars(strip_tags(trim($_POST['to'])));

if(!empty($username)) {
    $res = mysqli_query($dbc, "SELECT * FROM wallet_history WHERE receiver_id='$myid' OR sender_id='$myid' AND Date between '$from' AND '$to'");
    $row = mysqli_fetch_array($res);
    $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row

    if ($count == 1) {
        echo $row['firstName'] . ' ' . $row['lastName'];
    }
    else {
        echo {};
    }

}
else {
    echo "0";
}


?>