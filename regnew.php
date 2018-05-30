<?php

/**
 * @author Akintola Oluwaseun 
 * @copyright 2017
 */
 
	require_once 'functions.php';
 
$query = "SELECT * FROM `user_rank` WHERE `myid` = '$superior_id'";
$res = mysqli_query($dbc, $query) or die('Error, SELECT query failed');
$row = mysqli_fetch_array($res);
$superior = $row[myid];



		$myid = $myid2;
$desc1 = $row[desc_1];
$desc2 = $row[desc_2];
$desc3 = $row[desc_3];
$desc4 = $row[desc_4];
$desc5 = $row[desc_5];
$desc6 = $row[desc_6];

if ($superior != null || $superior != ''){

   // get user stage
$stage = $row[stage];

   // get user level
$level = $row[level];

   // get user balnce
$balance = $row[balance];

   // get user balnce
$desc_count = $row[desc_count];

   // get user id
//$myid = $row[myid];

if($stage == 1){
    if($level == 0){
     $newlevel = $level +1;
     $newbalance = $balance +8;
     $newdesc_count = $desc_count +1;
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance', `desc_1` = '$myid', `desc_count` = '$newdesc_count' WHERE `myid` = '$superior'";
    $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');
   
   
   
    $receiver_name = get_fullname($superior_id);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior_id','$Amount','Referral bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT IN INCOME HISTORY query failed');
     }
    elseif($level == 1){
     $newlevel = $level +1;
     $newbalance = $balance +8;
     $newdesc_count = $desc_count +1;
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance', `desc_2` = '$myid', `desc_count` = '$newdesc_count' WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');    
     
     
    $receiver_name = get_fullname($superior_id);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior_id','$Amount','Referral bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT IN INCOME HISTORY query failed');
    }
    elseif($level == 2){
     $newlevel = $level +1;
     $newbalance = $balance +8;
     $newdesc_count = $desc_count +1;
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance', `desc_3` = '$myid', `desc_count` = '$newdesc_count' WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');  
     
     
    $receiver_name = get_fullname($superior_id);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior_id','$Amount','Referral bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT IN INCOME HISTORY query failed');   
    }
    elseif($level == 3){
     $newlevel = $level +1;
     $newbalance = $balance +8;
     $newdesc_count = $desc_count +1;
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance', `desc_4` = '$myid', `desc_count` = '$newdesc_count' WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');  
     
     
    $receiver_name = get_fullname($superior_id);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior_id','$Amount','Referral bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT IN INCOME HISTORY query failed'); 
    }
    elseif($level == 4){
     $newlevel = $level +1;
     $newbalance = $balance +8;
     $newdesc_count = $desc_count +1;
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance', `desc_5` = '$myid', `desc_count` = '$newdesc_count' WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');  
     
     
    $receiver_name = get_fullname($superior_id);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior_id','$Amount','Referral bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT IN INCOME HISTORY query failed');  
    }
    elseif($level == 5){
     $newlevel = $level +1;
     $newbalance = $balance + 18;
     // get all direct superior of 5 descendants, if supeior = superior, add 10 to balance
     $newdesc_count = $desc_count +1;
     $newstage = $stage + 1;
     $uplevel_query = "UPDATE user_rank SET `level`= '0', `balance` = '$newbalance', `stage` = '$newstage', `desc_6` = '$myid', `desc_count` = '$newdesc_count' WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');
     
     
    $receiver_name = get_fullname($superior_id);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - ($balance + 10);
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior_id','$Amount','Referral bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT IN INCOME HISTORY query failed');
     
     
    $receiver_name = get_fullname($superior_id);
    $ref_name = get_fullname($myid);
    $Amount = 10;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior_id','$Amount','Bonus for completing stage 1', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT IN INCOME HISTORY query failed');     
    }    
    
}
   //increase user level
   // increase usser stage if needful
   // increase user user balance if needful 
}

$count =1;

  
// consider adding && $count < bla bla bla to each level 
while ($superior != null && $superior != '' ){
    
$query = "SELECT * FROM `user_rank` WHERE `myid` = '$superior'";
$row = mysqli_query($dbc, $query) or die('Error, SELECT query failed');
$row = mysqli_fetch_array($row);
$superior = $row[superior_id];   
    
$query2 = "SELECT * FROM `user_rank` WHERE `myid` = '$superior'";
$row = mysqli_query($dbc, $query2) or die('Error, SELECT query failed');
$row = mysqli_fetch_array($row);

$stage = $row[stage];
$level = $row[level];
$balance = $row[balance];
//$myid = $row[myid];

   // get number of direct descendants
$desc_count = $row[desc_count];

   // get all direct descendants
$desc1 = $row[desc_1];
$desc2 = $row[desc_2];
$desc3 = $row[desc_3];
$desc4 = $row[desc_4];
$desc5 = $row[desc_5];
$desc6 = $row[desc_6];



// for stage 1
if($stage == 1){
    if($level == 2){
     $newlevel = $level +1;
     $newbalance = $balance +8;
     $newdesc_count = $desc_count +1;
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance', `desc_3` = '$myid', `desc_count` = '$newdesc_count' WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');    
     
      
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT IN INCOME HISTORY query failed');
    }
    elseif($level == 3){
     $newlevel = $level +1;
     $newbalance = $balance +8;
     $newdesc_count = $desc_count +1;
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance', `desc_4` = '$myid', `desc_count` = '$newdesc_count' WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');   
     
      
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT IN INCOME HISTORY query failed');  
    }
    elseif($level == 4){
     $newlevel = $level +1;
     $newbalance = $balance +8;
     $newdesc_count = $desc_count +1;
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance', `desc_5` = '$myid', `desc_count` = '$newdesc_count' WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');     
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT IN INCOME HISTORY query failed'); 
    }
    elseif($level == 5){
     $newlevel = $level +1;
     $newbalance = $balance + 18;
     $newdesc_count = $desc_count +1;
     $newstage = $stage + 1;
     $uplevel_query = "UPDATE user_rank SET `level`= '0', `balance` = '$newbalance', `stage` = '$newstage', `desc_6` = '$myid', `desc_count` = '$newdesc_count' WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');     
     
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - ($balance + 10);
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT IN INCOME HISTORY query failed');
     
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = 10;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Bonus for completing stage 1', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT IN INCOME HISTORY query failed');     
     
    }    
    
} 

// for stage 2
elseif($stage == 2){
    if($level == 0){
        if(checkdesc_stage1($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage) == 1){
     $newlevel = $level +1;
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel' WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');
     
         
        }
     }    elseif($level == 1){
        
        if(checkdesc_stage2($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage) == 1){
     $newlevel = $level +1;
     $newbalance = $balance +100;
     
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance'  WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');      
     
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT IN INCOME HISTORY query failed'); 
        }
     } elseif($level == 2){
          
        if(checkdesc_stage3($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage) == 1){
     $newlevel = $level +1;
     $newbalance = $balance +200;
     
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance'  WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');    
     
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT IN INCOME HISTORY query failed');   
        }
    } elseif($level == 3){
          
        if(checkdesc_stage4($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage) == 1){
     $newlevel = $level +1;
     $newbalance = $balance +300;
     
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance'  WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');  
     
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT IN INCOME HISTORY query failed');     
        }
    } elseif($level == 4){
        
    
        if(checkdesc_stage5($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage) == 1){
     $newlevel = $level +1;
     $newbalance = $balance +400;
     $newstage = $stage + 1;
     $uplevel_query = "UPDATE user_rank SET `level`= '0', `balance` = '$newbalance', `stage` = '$newstage'  WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');  
     
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT INTO INCOME HISTORY query failed');     
        }  
    } 
} 

// for stage 3

elseif($stage == 3){
    if($level == 0){
        if(checkdesc_stage1($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage) == 1){
     $newlevel = $level +1;
     $newbalance = $balance +200;
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance'  WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query);
     
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT INTO INCOME HISTORY query failed'); 
     }
     }
      elseif($level == 1){
        
        if(checkdesc_stage2($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage) == 1){
     $newlevel = $level +1;
     $newbalance = $balance +300;
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance'  WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');      
     
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT INTO INCOME HISTORY query failed'); 
        }
     } elseif($level == 2){
          
        if(checkdesc_stage3($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage) == 1){
     $newlevel = $level +1;
     $newbalance = $balance +500;
     
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance'  WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');      
     
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT INTO INCOME HISTORY query failed'); 
        }
    } elseif($level == 3){
          
        if(checkdesc_stage4($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage) == 1){
     $newlevel = $level +1;
     $newbalance = $balance +500;
     
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance'  WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');      
     
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT INTO INCOME HISTORY query failed'); 
        }
    } elseif($level == 4){
        
    
        if(checkdesc_stage5($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage) == 1){
     $newlevel = $level +1;
     $newbalance = $balance +1500;
     $newstage = $stage + 1;
     $uplevel_query = "UPDATE user_rank SET `level`= '0', `balance` = '$newbalance', `stage` = '$newstage'  WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');      
     
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT INTO INCOME HISTORY query failed'); 
        }  
    } 
} 

// for stage 4

elseif($stage == 4){
    if($level == 0){
        if(checkdesc_stage1($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage) == 1){
     $newlevel = $level +1;
     $newbalance = $balance +300;
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance'  WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');    
     
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT INTO INCOME HISTORY query failed');   
        }
     }    elseif($level == 1){
        
        if(checkdesc_stage2($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage) == 1){
     $newlevel = $level +1;
     $newbalance = $balance +300;
     
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance'  WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');      
     
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT INTO INCOME HISTORY query failed'); 
        }
     } elseif($level == 2){
          
        if(checkdesc_stage3($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage) == 1){
     $newlevel = $level +1;
     $newbalance = $balance +500;
     
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance'  WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');   
     
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT INTO INCOME HISTORY query failed');    
        }
    } elseif($level == 3){
          
        if(checkdesc_stage4($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage) == 1){
     $newlevel = $level +1;
     $newbalance = $balance +900;
     
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance'  WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');      
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT INTO INCOME HISTORY query failed'); 
        }
    } elseif($level == 4){
        
    
        if(checkdesc_stage5($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage) == 1){
     $newlevel = $level +1;
     $newbalance = $balance +4000;
     $newstage = $stage + 1;
     $uplevel_query = "UPDATE user_rank SET `level`= '0', `balance` = '$newbalance', `stage` = '$newstage'  WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');      
     
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT INTO INCOME HISTORY query failed'); 
        }  
    } 
}

// for stage 5

elseif($stage == 5){
    if($level == 0){
        if(checkdesc_stage1($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage) == 1){
     $newlevel = $level +1;
     $newbalance = $balance +2000;
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance'  WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');      
     
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT INTO INCOME HISTORY query failed'); 
        }
     }    elseif($level == 1){
        
        if(checkdesc_stage2($desc1,$desc2,$desc3,$desc4,$desc5,$desc6, $stage) == 1){
     $newlevel = $level +1;
     $newbalance = $balance +10000;
     
     $uplevel_query = "UPDATE user_rank SET `level`= '$newlevel', `balance` = '$newbalance'  WHERE `myid` = '$superior'";
     $row_uplevel_query = mysqli_query($dbc, $uplevel_query) or die('Error, UPDATE query failed');      
     
     
    $receiver_name = get_fullname($superior);
    $ref_name = get_fullname($myid);
    $Amount = $newbalance - $balance;
   	$history_query = "INSERT INTO income_history(ref_name, ref_id, receiver_name, receiver_id,Amount, Remark, Status ) 
       VALUES('$ref_name','$myid','$receiver_name','$superior','$Amount','Matrix bonus', 'Paid')";
    $row_history_query = mysqli_query($dbc, $history_query) or die('Error, INSERT INTO INCOME HISTORY query failed'); 
        }
     } 
}


$count ++;
}

?>