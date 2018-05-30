<?php

/**
 * @author Akintola Oluwaseun
 * @copyright 2017
 */

require_once 'dbconnect.php';

// if session is not set this will redirect to login page
if( !isset($_SESSION['user']) ) {
   // header("Location: index.php");
  //  exit;
  $_SESSION['user'] = "na";
}else{
    
 // select loggedin users detail
$ses = $_SESSION['user'];

$ut = $_SESSION['userType'];
$res=mysqli_query($dbc,"SELECT * FROM user_table WHERE email='$ses'");
$userRow=mysqli_fetch_array($res);
$myid = $userRow['myid'];
   
}

function setvar($var_value, $default = ''){

    global $dbc;
    if ($var_value != null){
        $set_var = $var_value;
    }else{
        $set_var = $default;
    }
    return $set_var;
}

function compare_user($user1, $user2){

    global $dbc;

    $ret = false;
    $query1 = "SELECT * FROM `user_rank` WHERE `myid` = '$user1'";
    $res1= mysqli_query($dbc, $query1);
    $user_row1 = mysqli_fetch_array($res1);
    $stage1 = $user_row1['stage'];


    $query2 = "SELECT * FROM `user_rank` WHERE `myid` = '$user2'";
    $res2 = mysqli_query($dbc, $query2);
    $user_row2 = mysqli_fetch_array($res2);
    $stage2 = $user_row2['stage'];

    if ($stage1 >= $stage2){
        $ret = true;
    }else{
        $ret = false;
    }
    return $ret;
}

function get_stage($user){


    global $dbc;
    $query3 = "SELECT * FROM `user_rank` WHERE `myid` = '$user'";

    $res3 = mysqli_query($dbc, $query3);
    $user_row3 = mysqli_fetch_array($res3);
    $stage = $user_row3['stage'];



    if($stage == 0){
        $stagename= $stage."(Blank)";
    }else if($stage == 1){
        $stagename= $stage."(Associate Member)";
    }else if($stage == 2){
        $stagename= $stage."(Master Member)";
    }else if($stage == 3){
        $stagename= $stage."(Super Master)";
    }else if($stage == 4){
        $stagename= $stage."(Minister)";
    }else if($stage == 5){
        $stagename= $stage."(Prime Minister)";
    }else{
        $stagename= $stage."(Blank)";
    }
    return $stagename;

}

function get_stage_name($user){


    global $dbc;
    $query3 = "SELECT * FROM `user_rank` WHERE `myid` = '$user'";

    $res3 = mysqli_query($dbc, $query3);
    $user_row3 = mysqli_fetch_array($res3);
    $stage = $user_row3['stage'];



    if($stage == 0){
        $stagename= "Blank";
    }else if($stage == 1){
        $stagename= "ASSOCIATE MEMBER";
    }else if($stage == 2){
        $stagename= "MASTER MEMBER";
    }else if($stage == 3){
        $stagename= "SUPER MASTER";
    }else if($stage == 4){
        $stagename= "MINISTER";
    }else if($stage == 5){
        $stagename= "PRIME MINISTER";
    }else{
        $stagename= "BLANK";
    }
    return $stagename;

}

function getstage_name($stage){

    if($stage == 0){
        $stagename= "Blank";
    }else if($stage == 1){
        $stagename= "Associate Member";
    }else if($stage == 2){
        $stagename= "Master Member";
    }else if($stage == 3){
        $stagename= "Super Master";
    }else if($stage == 4){
        $stagename= "Minister";
    }else if($stage == 5){
        $stagename= "Prime Minister";
    }else{
        $stagename= "Blank";
    }
    return $stagename;

}

function getimg($user_toget){

    global $dbc;
    $query3 = "SELECT * FROM `user_rank` WHERE `myid` = '$user_toget'";
    $res3 = mysqli_query($dbc, $query3);
    $user_row3 = mysqli_fetch_array($res3);
    $img_stage = $user_row3['stage'];
    $img_link = "<img width='40px' height='40px' src='assets/img/stage".$img_stage.".png'>";
    return $img_link;
}

function get_fullname($userid){

    global $dbc;

    $quer=mysqli_query($dbc, "SELECT * FROM user_table WHERE myid='$userid'");
    $ron = mysqli_fetch_array($quer);
    $user_name= $ron['firstName'].' '.$ron['lastName'];
    return $user_name;

}

function checkdesc_stage1($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage_tocheck){

    global $dbc;

    $desc = array($desc1, $desc2,$desc3, $desc4,$desc5, $desc6);

    $count = 0;
    while($count < 2){
        $des = $desc[$count];
        $check_query = "SELECT * FROM `user_rank` WHERE `myid` = '$des'";
        //  echo $check_query;

        $row2 = mysqli_query($dbc, $check_query);
        $row2 = mysqli_fetch_array($row2);
        if($row2[stage] == $stage_tocheck){
            $val = 1;
        } else{
            $val = 0;
        }

        if ($val == 0){
            return $val;
        }

        $count = $count +1;

    }

    return $val;
}

function checkdesc_stage2($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage_tocheck){

    global $dbc;

    $desc = array($desc1, $desc2,$desc3, $desc4,$desc5, $desc6);

    $count = 0;
    while($count < 6){
        $check_query = "SELECT * FROM `user_rank` WHERE `myid` = '$desc[$count]'";
        $row = mysqli_query($dbc, $check_query);
        $row = mysqli_fetch_array($row);
        if($row[stage] == $stage_tocheck){
            $val = 1;
        } else{
            $val = 0;
        }
        if ($val == 0){
            return $val;
        }

        $count = $count +1;

    }

    return $val;
}

function checkdesc_stage3($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage_tocheck){

    global $dbc;

    $desc = array($desc1, $desc2,$desc3, $desc4,$desc5, $desc6);

    $count = 0;
    while($count < 2){


        $check_query = "SELECT * FROM `user_rank` WHERE `myid` = '$desc[$count]'";
        $row = mysqli_query($dbc, $check_query);
        $row = mysqli_fetch_array($row);
        $sub_desc1 = $row[desc_1];
        $sub_desc2 = $row[desc_2];
        $sub_desc3 = $row[desc_3];
        $sub_desc4 = $row[desc_4];
        $sub_desc5 = $row[desc_5];
        $sub_desc6 = $row[desc_6];

        if($row[stage] == $stage_tocheck){
            $val = 1;
        } else{
            $val = 0;
        }
        if ($val == 0){
            return $val;
        }

        $val = checkdesc_stage2($sub_desc1,$sub_desc2,$sub_desc3,$sub_desc4,$sub_desc5,$sub_desc6,$stage_tocheck);

        if ($val == 0){
            return $val;
        }

        $count = $count +1;
    }

    return $val;
}

function checkdesc_stage4($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage_tocheck){

    global $dbc;

    $desc = array($desc1, $desc2,$desc3, $desc4,$desc5, $desc6);

    $count = 0;
    while($count < 6){


        $check_query = "SELECT * FROM `user_rank` WHERE `myid` = '$desc[$count]'";
        $row = mysqli_query($dbc, $check_query);
        $row = mysqli_fetch_array($row);
        $sub_desc1 = $row[desc_1];
        $sub_desc2 = $row[desc_2];
        $sub_desc3 = $row[desc_3];
        $sub_desc4 = $row[desc_4];
        $sub_desc5 = $row[desc_5];
        $sub_desc6 = $row[desc_6];

        if($row[stage] == $stage_tocheck){
            $val = 1;
        } else{
            $val = 0;
        }
        if ($val == 0){
            return $val;
        }

        $val = checkdesc_stage2($sub_desc1,$sub_desc2,$sub_desc3,$sub_desc4,$sub_desc5,$sub_desc6,$stage_tocheck);

        if ($val == 0){
            return $val;
        }

        $count = $count +1;
    }

    return $val;
}
function checkdesc_stage5($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage_tocheck){

    global $dbc;

    $desc = array($desc1, $desc2,$desc3, $desc4,$desc5, $desc6);

    $count = 0;
    while($count < 6){


        $check_query = "SELECT * FROM `user_rank` WHERE `myid` = '$desc[$count]'";
        $row = mysqli_query($dbc, $check_query);
        $row = mysqli_fetch_array($row);
        $sub_desc1 = $row[desc_1];
        $sub_desc2 = $row[desc_2];
        $sub_desc3 = $row[desc_3];
        $sub_desc4 = $row[desc_4];
        $sub_desc5 = $row[desc_5];
        $sub_desc6 = $row[desc_6];

        if($row[stage] == $stage_tocheck){
            $val = 1;
        } else{
            $val = 0;
        }
        if ($val == 0){
            return $val;
        }

        $val = checkdesc_stage3($sub_desc1,$sub_desc2,$sub_desc3,$sub_desc4,$sub_desc5,$sub_desc6,$stage_tocheck);

        if ($val == 0){
            return $val;
        }

        $count = $count +1;
    }

    return $val;
}


?>




<?php

function getmym($par, $once=0) {
    global $dbc, $id_toseach;
    $query = "SELECT * FROM `user_rank` WHERE `myid` = '$par'";
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

    $rand = rand(23,438998);
//$rand2 = rand(a,z);

    $img_link0 = "<img style='padding-left:20px;' width='40px' height='40px' src='assets/img/stage0.png'>";
    $my_img = $img_link0;
    $desc01 =   $my_img."<br> ".""." ".""."<br> "." ";
    $desc02 =   $my_img."<br> ".""." ".""."<br> "."  ";
    $desc03 =   $my_img."<br> ".""." ".""."<br> "."   ";
    $desc04=   $my_img."<br> ".""." "." "."<br> "."     ";
    $desc05 =   $my_img."<br> ".""." ".""."<br> "."      ";
    $desc06 =   $my_img."<br> ".""." "." "."<br> "."         ";
    $par0 =   $my_img."<br> ".""." ".""."<br> "."                ";

    $img_link0 = "<img style='padding-left:20px;' width='40px' height='40px' src='assets/img/stage0.png'>";
    $my_img = $img_link0;
    $desc001 =   $my_img."<br> ".""." ".""."<br> "." ".$rand;
    $desc002 =   $my_img."<br> ".""." ".""."<br> "."  ".$rand;
    $desc003 =   $my_img."<br> ".""." ".""."<br> "."   ".$rand;
    $desc004=   $my_img."<br> ".""." "." "."<br> "."     ".$rand;
    $desc005 =   $my_img."<br> ".""." ".""."<br> "."      ".$rand;
    $desc006 =   $my_img."<br> ".""." "." "."<br> "."         ".$rand;
    $par000 =   $my_img."<br> ".""." ".""."<br> "."                ".$rand;


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$par'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($par);
    $par00 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];

    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc1'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc1);
    $desc11 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc2'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc2);
    $desc22 =   $my_img." <br>".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc3'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc3);
    $desc33 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc4'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc4);
    $desc44 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]." <br>".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc5'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc5);
    $desc55 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]." <br>".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc6'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc6);
    $desc66 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]." <br>".$user_row[myid];

    global $datas;
    $data_sofar = count($datas);
    $par2 = $par;
    if($data_sofar==0){
        $dat = array('id' => $par, 'parent' => '0', 'name' => $par00);
        array_push($datas,$dat);
        $id_toseach = $par;

    }

    if($desc1!= null && $desc1!= '' && compare_user($desc1,$par) == true  ){$dat = array('id' => $desc1, 'parent' => $par, 'name' => $desc11);
        array_push($datas,$dat);
    }else{

        $desc1 = null;
            if($once == 0){
            
        }else{
            
        $dat = array('id' => $desc001, 'parent' => $par, 'name' => $desc01);
        array_push($datas,$dat);
        gen_2empty($desc001);
        }
    }
    if($desc2!= null && $desc2!= '' && compare_user($desc2,$par) == true  ){$dat = array('id' => $desc2, 'parent' => $par, 'name' => $desc22);
        array_push($datas,$dat);
    }else{
        $desc2 = null;
        if($once == 0){
            
        $dat = array('id' =>$desc002, 'parent' => $par, 'name' => $desc02);
        if($desc1 != null){
            
       array_push($datas,$dat);
        }
        }else{
            
        $dat = array('id' =>$desc002, 'parent' => $par, 'name' => $desc02);
        array_push($datas,$dat);
        gen_2empty($desc002);
        }
    }
    if($desc3!= null && $desc3!= '' && compare_user($desc3,$par) == true  ){$dat = array('id' => $desc3, 'parent' => $desc1, 'name' => $desc33);
        array_push($datas,$dat);
    }else{
        $desc3 = null;
        
                 if($once == 0){
            
        }else{
            
        $dat = array('id' => $desc003, 'parent' => $desc01, 'name' => $desc03);
        if($desc1!= null && $desc1!= '' && compare_user($desc1,$par) == true  ){array_push($datas,$dat);}
        }
    }
    if($desc4!= null && $desc4!= '' && compare_user($desc4,$par) == true ){$dat = array('id' => $desc4, 'parent' => $desc1, 'name' => $desc44);
        array_push($datas,$dat);
    }else{
        $desc4 = null;
        
               if($once == 0){
            
        }else{
            
        $dat = array('id' => $desc004, 'parent' => $desc01, 'name' => $desc04);
        if($desc1!= null && $desc1!= '' && compare_user($desc1,$par) == true  ){array_push($datas,$dat);}
        }
    }
    if($desc5!= null && $desc5!= '' && compare_user($desc5,$par) == true ){$dat = array('id' => $desc5, 'parent' => $desc2, 'name' => $desc55);
        array_push($datas,$dat);
    }else{
        $desc5 = null;
        
                if($once == 0){
            
        }else{
            
        $dat = array('id' => $desc005, 'parent' => $desc02, 'name' => $desc05);
        if($desc2!= null && $desc2!= '' && compare_user($desc2,$par) == true  ){array_push($datas,$dat);}
        }
    }
    if($desc6!= null && $desc6!= '' && compare_user($desc6,$par) == true  ){$dat = array('id' => $desc6, 'parent' => $desc2, 'name' => $desc66);
        array_push($datas,$dat);
    }else{
        $desc6 = null;
        
                if($once == 0){
            
        }else{
            
        $dat = array('id' => $desc006, 'parent' => $desc02, 'name' => $desc06);

        if($desc2!= null && $desc2!= '' && compare_user($desc2,$par) == true  ){
            array_push($datas,$dat);
            
        }
        }
    }
    $desc = array($desc1,$desc2,$desc3,$desc4,$desc5,$desc6);



//echo "<br> arrar for".$par2.":</br>";
//print_r(($desc));
//echo "<br>".$data_sofar;
    for($i=0; $i<6; $i++){
        $des = $desc[$i];
        if($des){
            if($des !=null && $des !='' ){
         if($once == 1){
            
                getmym($des);
        }else{
            
                //getmym($des);
        }
                //  echo "got here";
            }else return;
        }
    }

    //return   $datas;
}

function gen_2empty($par){
    $rand = rand(23,438998);
//$rand2 = rand(a,z);

    global $dbc;
    global $myid,$id_toseach;


    $query = "SELECT * FROM `user_rank` WHERE `myid` = '$id_toseach'";
    $res = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($res);

    $my_balance = $row[balance];
    $my_stage = $row[stage];
    $img_link0 = "<img style='padding-left:20px;' width='40px' height='40px' src='assets/img/stage0.png'>";
    $my_img = $img_link0;
    $desc01 =   $my_img."<br> ".""." ".""."<br> "." ";
    $desc02 =   $my_img."<br> ".""." ".""."<br> "."  ";
    $desc03 =   $my_img."<br> ".""." ".""."<br> "."   ";
    $desc04=   $my_img."<br> ".""." "." "."<br> "."     ";
    $desc05 =   $my_img."<br> ".""." ".""."<br> "."      ";
    $desc06 =   $my_img."<br> ".""." "." "."<br> "."         ";
    $par0 =   $my_img."<br> ".""." ".""."<br> "."                ";

    $img_link0 = "<img style='padding-left:20px;' width='40px' height='40px' src='assets/img/stage0.png'>";
    $my_img = $img_link0;
    $desc001 =   $my_img."<br> ".""." ".""."<br> "." ".$rand;
    $desc002 =   $my_img."<br> ".""." ".""."<br> "."  ".$rand;
    $desc003 =   $my_img."<br> ".""." ".""."<br> "."   ".$rand;
    $desc004=   $my_img."<br> ".""." "." "."<br> "."     ".$rand;
    $desc005 =   $my_img."<br> ".""." ".""."<br> "."      ".$rand;
    $desc006 =   $my_img."<br> ".""." "." "."<br> "."         ".$rand;
    $par000 =   $my_img."<br> ".""." ".""."<br> "."                ".$rand;


    global $datas;
    $dat = array('id' => $desc001, 'parent' => $par, 'name' => $desc02);
    array_push($datas,$dat);
    if($my_stage=='1'){
     //   gen_4empty($desc001);
    }
    if($my_stage=='2'){
        gen_4empty($desc001);
    }

    elseif($my_stage=='3'){
        gen_4empty($desc001);
    }

    $dat = array('id' =>$desc002, 'parent' => $par, 'name' => $desc02);
    array_push($datas,$dat);
    if($my_stage=='2'){
        gen_4empty($desc002);
    }
    elseif($my_stage=='3'){
        gen_4empty($desc002);
    }
    //echo "my stage".$my_stage;

    return;
}
function gen_3empty($par){
    $rand = rand(213,438998);

//$rand2 = rand(a,z);

    $img_link0 = "<img style='padding-left:20px;' width='40px' height='40px' src='assets/img/stage0.png'>";
    $my_img = $img_link0;
    $desc01 =   $my_img."<br> ".""." ".""."<br> "." ";
    $desc02 =   $my_img."<br> ".""." ".""."<br> "."  ";
    $desc03 =   $my_img."<br> ".""." ".""."<br> "."   ";
    $desc04=   $my_img."<br> ".""." "." "."<br> "."     ";
    $desc05 =   $my_img."<br> ".""." ".""."<br> "."      ";
    $desc06 =   $my_img."<br> ".""." "." "."<br> "."         ";
    $par0 =   $my_img."<br> ".""." ".""."<br> "."                ";

    $img_link0 = "<img style='padding-left:20px;' width='40px' height='40px' src='assets/img/stage0.png'>";
    $my_img = $img_link0;
    $desc001 =   $my_img."<br> ".""." ".""."<br> "." ".$rand;
    $desc002 =   $my_img."<br> ".""." ".""."<br> "."  ".$rand;
    $desc003 =   $my_img."<br> ".""." ".""."<br> "."   ".$rand;
    $desc004=   $my_img."<br> ".""." "." "."<br> "."     ".$rand;
    $desc005 =   $my_img."<br> ".""." ".""."<br> "."      ".$rand;
    $desc006 =   $my_img."<br> ".""." "." "."<br> "."         ".$rand;
    $par000 =   $my_img."<br> ".""." ".""."<br> "."                ".$rand;


    global $datas;
    $dat = array('id' => $desc001, 'parent' => $par, 'name' => $desc01);
    array_push($datas,$dat);

    $dat = array('id' => $desc002, 'parent' => $par, 'name' => $desc02);
    array_push($datas,$dat);


    $dat = array('id' => $desc003, 'parent' => $desc001, 'name' => $desc03);
    array_push($datas,$dat);


    $dat = array('id' => $desc004, 'parent' => $desc001, 'name' => $desc04);
    array_push($datas,$dat);


    $dat = array('id' => $desc005, 'parent' => $desc002, 'name' => $desc05);
    array_push($datas,$dat);


    $dat = array('id' => $desc006, 'parent' => $desc002, 'name' => $desc06);
    array_push($datas,$dat);


    return;
}

function gen_5empty($par){
    $rand = rand(213,438998);

//$rand2 = rand(a,z);

    $img_link0 = "<img style='padding-left:20px;' width='40px' height='40px' src='assets/img/stage0.png'>";
    $my_img = $img_link0;
    $desc01 =   $my_img."<br> ".""." ".""."<br> "." ";
    $desc02 =   $my_img."<br> ".""." ".""."<br> "."  ";
    $desc03 =   $my_img."<br> ".""." ".""."<br> "."   ";
    $desc04=   $my_img."<br> ".""." "." "."<br> "."     ";
    $desc05 =   $my_img."<br> ".""." ".""."<br> "."      ";
    $desc06 =   $my_img."<br> ".""." "." "."<br> "."         ";
    $par0 =   $my_img."<br> ".""." ".""."<br> "."                ";

    $img_link0 = "<img style='padding-left:20px;' width='40px' height='40px' src='assets/img/stage0.png'>";
    $my_img = $img_link0;
    $desc001 =   $my_img."<br> ".""." ".""."<br> "." ".$rand;
    $desc002 =   $my_img."<br> ".""." ".""."<br> "."  ".$rand;
    $desc003 =   $my_img."<br> ".""." ".""."<br> "."   ".$rand;
    $desc004=   $my_img."<br> ".""." "." "."<br> "."     ".$rand;
    $desc005 =   $my_img."<br> ".""." ".""."<br> "."      ".$rand;
    $desc006 =   $my_img."<br> ".""." "." "."<br> "."         ".$rand;
    $par000 =   $my_img."<br> ".""." ".""."<br> "."                ".$rand;


    global $datas;
    $dat = array('id' => $desc001, 'parent' => $par, 'name' => $desc01);
    array_push($datas,$dat);

    $dat = array('id' => $desc002, 'parent' => $par, 'name' => $desc02);
    array_push($datas,$dat);


    $dat = array('id' => $desc003, 'parent' => $desc001, 'name' => $desc03);
    array_push($datas,$dat);

    gen_3empty($desc003);

    $dat = array('id' => $desc004, 'parent' => $desc001, 'name' => $desc04);
    array_push($datas,$dat);


    gen_3empty($desc004);
    $dat = array('id' => $desc005, 'parent' => $desc002, 'name' => $desc05);
    array_push($datas,$dat);

    gen_3empty($desc005);

    $dat = array('id' => $desc006, 'parent' => $desc002, 'name' => $desc06);
    array_push($datas,$dat);

    gen_3empty($desc006);

    return;
}


function gen_4empty($par){
    $rand = rand(213,438998);

//$rand2 = rand(a,z);

    $img_link0 = "<img style='padding-left:20px;' width='40px' height='40px' src='assets/img/stage0.png'>";
    $my_img = $img_link0;
    $desc01 =   $my_img."<br> ".""." ".""."<br> "." ";
    $desc02 =   $my_img."<br> ".""." ".""."<br> "."  ";
    $desc03 =   $my_img."<br> ".""." ".""."<br> "."   ";
    $desc04=   $my_img."<br> ".""." "." "."<br> "."     ";
    $desc05 =   $my_img."<br> ".""." ".""."<br> "."      ";
    $desc06 =   $my_img."<br> ".""." "." "."<br> "."         ";
    $par0 =   $my_img."<br> ".""." ".""."<br> "."                ";

    $img_link0 = "<img style='padding-left:20px;' width='40px' height='40px' src='assets/img/stage0.png'>";
    $my_img = $img_link0;
    $desc001 =   $my_img."<br> ".""." ".""."<br> "." ".$rand;
    $desc002 =   $my_img."<br> ".""." ".""."<br> "."  ".$rand;
    $desc003 =   $my_img."<br> ".""." ".""."<br> "."   ".$rand;
    $desc004=   $my_img."<br> ".""." "." "."<br> "."     ".$rand;
    $desc005 =   $my_img."<br> ".""." ".""."<br> "."      ".$rand;
    $desc006 =   $my_img."<br> ".""." "." "."<br> "."         ".$rand;
    $par000 =   $my_img."<br> ".""." ".""."<br> "."                ".$rand;


    global $datas;
    $dat = array('id' => $desc001, 'parent' => $par, 'name' => $desc01);
    array_push($datas,$dat);

    gen_3empty($desc001);
    $dat = array('id' => $desc002, 'parent' => $par, 'name' => $desc02);
    array_push($datas,$dat);


    gen_3empty($desc002);


    return;
}



function getmym_direct($par) {
    global $dbc;


    $query = "SELECT * FROM `user_rank` WHERE `myid` = '$par'";
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




    $query = "SELECT * FROM `user_table` WHERE `myid` = '$par'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($par);
    $par00 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];

    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc1'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc1);
    $desc11 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc2'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc2);
    $desc22 =   $my_img." <br>".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc3'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc3);
    $desc33 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc4'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc4);
    $desc44 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]." <br>".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc5'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc5);
    $desc55 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]." <br>".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc6'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc6);
    $desc66 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]." <br>".$user_row[myid];

    global $datas;
    $data_sofar = count($datas);
    $par2 = $par;
    if($data_sofar==0){
        $dat = array('id' => $par, 'parent' => '0', 'name' => $par00);
        array_push($datas,$dat);

    }

    if($desc1!= null && $desc1!= '' && compare_user($desc1,$par) == true ){$dat = array('id' => $desc1, 'parent' => $par, 'name' => $desc11);
        array_push($datas,$dat);
    }
    if($desc2!= null && $desc2!= '' && compare_user($desc2,$par) == true){$dat = array('id' => $desc2, 'parent' => $par, 'name' => $desc22);
        array_push($datas,$dat);
    }
    if($desc3!= null && $desc3!= '' && compare_user($desc3,$par) == true){$dat = array('id' => $desc3, 'parent' => $desc1, 'name' => $desc33);
        array_push($datas,$dat);
    }
    if($desc4!= null && $desc4!= '' && compare_user($desc4,$par) == true ){$dat = array('id' => $desc4, 'parent' => $desc1, 'name' => $desc44);
        array_push($datas,$dat);
    }
    if($desc5!= null && $desc5!= '' && compare_user($desc5,$par) == true){$dat = array('id' => $desc5, 'parent' => $desc2, 'name' => $desc55);
        array_push($datas,$dat);
    }
    if($desc6!= null && $desc6!= '' && compare_user($desc6,$par) == true ){$dat = array('id' => $desc6, 'parent' => $desc2, 'name' => $desc66);
        array_push($datas,$dat);
    }
    $desc = array($desc1,$desc2,$desc3,$desc4,$desc5,$desc6);


    //return   $datas;
}








function searchmym($par) {
    global $dbc;
    $query = "SELECT * FROM `user_rank` WHERE `myid` = '$par'";
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

    $query = "SELECT * FROM `user_table` WHERE `myid` = '$par'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($par);
    $par00 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];

    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc1'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc1);
    $desc11 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc2'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc2);
    $desc22 =   $my_img." <br>".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc3'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc3);
    $desc33 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc4'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc4);
    $desc44 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]." <br>".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc5'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc5);
    $desc55 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]." <br>".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc6'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc6);
    $desc66 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]." <br>".$user_row[myid];

    global $datas;
    $data_sofar = count($datas);
    $par2 = $par;
    if($data_sofar==0){
        $dat = array('id' => $par, 'parent' => '0', 'name' => $par00);
        array_push($datas,$dat);

    }

    if($desc1!= null && $desc1!= '' ){$dat = array('id' => $desc1, 'parent' => $par, 'name' => $desc11);
        array_push($datas,$dat);
    }
    if($desc2!= null && $desc2!= '' ){$dat = array('id' => $desc2, 'parent' => $par, 'name' => $desc22);
        array_push($datas,$dat);
    }
    if($desc3!= null && $desc3!= '' ){$dat = array('id' => $desc3, 'parent' => $desc1, 'name' => $desc33);
        array_push($datas,$dat);
    }
    if($desc4!= null && $desc4!= '' ){$dat = array('id' => $desc4, 'parent' => $desc1, 'name' => $desc44);
        array_push($datas,$dat);
    }
    if($desc5!= null && $desc5!= '' ){$dat = array('id' => $desc5, 'parent' => $desc2, 'name' => $desc55);
        array_push($datas,$dat);
    }
    if($desc6!= null && $desc6!= '' ){$dat = array('id' => $desc6, 'parent' => $desc2, 'name' => $desc66);
        array_push($datas,$dat);
    }
    $desc = array($desc1,$desc2,$desc3,$desc4,$desc5,$desc6);

//echo "<br> arrar for".$par2.":</br>";
//print_r(($desc));
//echo "<br>".$data_sofar;
    for($i=2; $i<6; $i++){
        $des = $desc[$i];
        if($des){
            if($des !=null && $des !='' ){

                //  echo "got here";
                searchmym($des);
            }else return;
        }
    }

    //return   $datas;
}







function getmym2($par) {
    global $dbc;
    $query = "SELECT * FROM `user_rank` WHERE `myid` = '$par'";
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

    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc1'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $desc11 =   $user_row[email]."<br> ".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc2'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $desc22 =   $user_row[email]." <br>".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc3'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $desc33 =   $user_row[email]."<br> ".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc4'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $desc44 =   $user_row[email]."<br> ".$user_row[firstName]." ".$user_row[lastName]." <br>".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc5'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $desc55 =   $user_row[email]."<br> ".$user_row[firstName]." ".$user_row[lastName]." <br>".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc6'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $desc66 =   $user_row[email]."<br> ".$user_row[firstName]." ".$user_row[lastName]." <br>".$user_row[myid];

    global $datas;
    $data_sofar = count($datas);

    if($data_sofar==0 || $data_sofar==1 ){
        $par = '0';

    }
    if($desc1!= null && $desc1!= '' ){$dat = array('id' => $desc1, 'parent' => $par, 'name' => $desc11);
        array_push($datas,$dat);
    }
    if($desc2!= null && $desc2!= '' ){$dat = array('id' => $desc2, 'parent' => $par, 'name' => $desc22);
        array_push($datas,$dat);
    }
    if($desc3!= null && $desc3!= '' ){$dat = array('id' => $desc3, 'parent' => $desc1, 'name' => $desc33);
        array_push($datas,$dat);
    }
    if($desc4!= null && $desc4!= '' ){$dat = array('id' => $desc4, 'parent' => $desc1, 'name' => $desc44);
        array_push($datas,$dat);
    }
    if($desc5!= null && $desc5!= '' ){$dat = array('id' => $desc5, 'parent' => $desc2, 'name' => $desc55);
        array_push($datas,$dat);
    }
    if($desc6!= null && $desc6!= '' ){$dat = array('id' => $desc6, 'parent' => $desc2, 'name' => $desc66);
        array_push($datas,$dat);
    }
    $desc = array($desc1,$desc2,$desc3,$desc4,$desc5,$desc6);

    print_r(($desc));

    return;
}













function getmym_dir($par) {
    global $dbc;
    $query = "SELECT * FROM `user_rank` WHERE `myid` = '$par'";
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



    $img_link0 = "<img style='padding-left:20px;' width='40px' height='40px' src='assets/img/stage0.png'>";
    $my_img = $img_link0;
    $desc01 =   $my_img."<br> ".""." ".""."<br> "." ";
    $desc02 =   $my_img."<br> ".""." ".""."<br> "."  ";
    $desc03 =   $my_img."<br> ".""." ".""."<br> "."   ";
    $desc04=   $my_img."<br> ".""." "." "."<br> "."     ";
    $desc05 =   $my_img."<br> ".""." ".""."<br> "."      ";
    $desc06 =   $my_img."<br> ".""." "." "."<br> "."         ";
    $par0 =   $my_img."<br> ".""." ".""."<br> "."                ";


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$par'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($par);
    $par00 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];

    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc1'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc1);
    $desc11 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc2'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc2);
    $desc22 =   $my_img." <br>".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc3'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc3);
    $desc33 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]."<br> ".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc4'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc4);
    $desc44 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]." <br>".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc5'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc5);
    $desc55 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]." <br>".$user_row[myid];


    $query = "SELECT * FROM `user_table` WHERE `myid` = '$desc6'";
    $res = mysqli_query($dbc, $query);
    $user_row = mysqli_fetch_array($res);
    $my_img = getimg($desc6);
    $desc66 =   $my_img."<br> ".$user_row[firstName]." ".$user_row[lastName]." <br>".$user_row[myid];

    global $datas;
    $data_sofar = count($datas);
    $par2 = $par;
    if($data_sofar==0){
        $dat = array('id' => $par, 'parent' => '0', 'name' => $par00);
        array_push($datas,$dat);

    }

    if($desc1!= null && $desc1!= '' ){$dat = array('id' => $desc1, 'parent' => $par, 'name' => $desc11);
        array_push($datas,$dat);
    }else{

        $dat = array('id' => $desc01, 'parent' => $par, 'name' => $desc01);
        array_push($datas,$dat);
    }
    if($desc2!= null && $desc2!= '' ){$dat = array('id' => $desc2, 'parent' => $par, 'name' => $desc22);
        array_push($datas,$dat);
    }else{

        $dat = array('id' =>$desc02, 'parent' => $par, 'name' => $desc02);
        array_push($datas,$dat);
    }
    if($desc3!= null && $desc3!= '' ){$dat = array('id' => $desc3, 'parent' => $par, 'name' => $desc33);
        array_push($datas,$dat);
    }else{

        $dat = array('id' => $desc03, 'parent' => $par, 'name' => $desc03);
        array_push($datas,$dat);
    }
    if($desc4!= null && $desc4!= '' ){$dat = array('id' => $desc4, 'parent' => $par, 'name' => $desc44);
        array_push($datas,$dat);
    }else{

        $dat = array('id' => $desc04, 'parent' => $par, 'name' => $desc04);
        array_push($datas,$dat);
    }
    if($desc5!= null && $desc5!= '' ){$dat = array('id' => $desc5, 'parent' => $par, 'name' => $desc55);
        array_push($datas,$dat);
    }else{

        $dat = array('id' => $desc05, 'parent' => $par, 'name' => $desc05);
        array_push($datas,$dat);
    }
    if($desc6!= null && $desc6!= '' ){$dat = array('id' => $desc6, 'parent' => $par, 'name' => $desc66);
        array_push($datas,$dat);
    }else{

        $dat = array('id' => $desc06, 'parent' => $par, 'name' => $desc06);
        array_push($datas,$dat);
    }


}
?>