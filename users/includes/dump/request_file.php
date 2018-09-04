<?php
/**
 * Created by IntelliJ IDEA.
 * User: latyf
 * Date: 6/4/18
 * Time: 4:02 PM
 */

require_once 'app/init.php';

$user = new User();
$username = $_SESSION['user'];


/**
 * Create a new contextual binding builder.
 *
 * @return void
 */
public function get_user(){
    $username = htmlspecialchars(strip_tags(trim($_POST['username'])));
    if(!empty($username)){
        $request = User::where('userName', $username)->first();
        if($request){
            echo $request->firstName . ' ' . $request->lastName;
        }
        else {
            echo '0';
        }
    }
    else {
        echo '0';
    }
}
