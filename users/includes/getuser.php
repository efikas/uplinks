<?php
//header('Content-Type: application/json');
require_once '../dbconnect.php';
$username = htmlspecialchars(strip_tags(trim($_POST['username'])));

if(!empty($username)) {
    $res = mysqli_query($dbc, "SELECT * FROM user_table WHERE userName='$username'");
    $row = mysqli_fetch_array($res);
    $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row

    if ($count == 1) {
        echo $row['firstName'] . ' ' . $row['lastName'];
    }
    else {
        echo "0";
    }

}
else {
    echo "0";
}


?>