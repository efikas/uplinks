
<?php include('head.php'); ?>

<?php

/**
 * @author Akintola Oluwaseun Jeremiah
 * @copyright 2017
 */
    $transfer_error = '';
	if ( isset($_POST['update']) ) {
	   
		$amounts = trim($_POST['amounts']);
		$myid = trim($_POST['myid']);
		$to_receive = trim($_POST['to_receive']);
        
        // get balnce of user receiving transfer
        $query_getreceiver = "SELECT * FROM `wallet` WHERE `owner`='$to_receive'";        
		$res = mysqli_query($dbc,$query_getreceiver);
        $receiverRow=mysqli_fetch_array($res);
        $rec_balance = $receiverRow['balance'];
        $rec_balance = $rec_balance + $amounts;
        
        
        // get balance of user making transfer
        $query_getmyrow = "SELECT * FROM `wallet` WHERE `owner`='$myid'";        
		$res = mysqli_query($dbc,$query_getmyrow);
        $myRow=mysqli_fetch_array($res);
        $my_balance = $myRow['balance'];
        if($my_balance>=$amounts){
        $my_balance = $my_balance - $amounts;
      
        // get full name of user to receive transfer
        
	   $res=mysqli_query($dbc,"SELECT * FROM user_table WHERE myid='$to_receive'");
	   $receiverRow=mysqli_fetch_array($res);
        $rec_name = $receiverRow['lastName'].' '.$userRow['firstName'];

        
		$query1 = "UPDATE `wallet` SET `balance`='$my_balance' WHERE `owner`='$myid'";
		$res1 = mysqli_query($dbc,$query1);
        
		$query2 = "UPDATE `wallet` SET `balance`='$rec_balance' WHERE `owner`='$to_receive'";
		$res2 = mysqli_query($dbc,$query2);
        
			if ($res1 && $res2) {
                
        	$query2 = "INSERT INTO wallet_history(sender_id,receiver_id,sender_name,receiver_name,Credit,Debit,Remark,Status) VALUES('$myid','$to_receive','$name','$rec_name','$amounts','0','Transfer from $$my_name','Paid')";
			$res2 = mysqli_query($dbc,$query2);
            }
            
		    }   else{
         $transfer_error = "Sorry, insuficient balance to make this transfer";   
        }    
	   
	}
?>

<section id="page-title" class="row">

          <div class="col-md-8 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
            <h1>Fund Transfer</h1>
            <p></p><div style="color:#900;font-weight:bold;" align="center"></div><p></p>
          </div>

             
             
          <div class="col-md-4 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
  <a href="external-fund-transfer-list.php"><input name="updates1" value="View Transaction" class="btn btn-primary" type="submit"></a>   
           

          </div>
        </section>
        <div class="container-fluid">
          <div class="row">
       
            <div class="col-md-6 animateme scrollme" style="float:none; margin-left:auto; margin-right:auto;" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">

           <form name="bankinfo" method="post" action="external-fund-transfer-confirm.php">
              <section class="panel">

                <header class="panel-heading">
                  <h3 class="panel-title">e-Wallet fund transfer</h3>
                </header>
                <header class="panel-heading">
                  <h3 class="panel-title"></h3>
                </header>
                <header class="panel-heading">
                 <br> <h3 class="panel-title">e-Wallet Ballance :  <strong>0.00</strong> USD</h3>
                <br> IF YOUR EMAIL ID IS NOT VALID/ ACTIVE, YOU WILL NOT BE ABLE TO TRANSFER FUNDS. <br><br>
NOTE: KINDLY CHECK YOUR INBOX AND SPAM/JUNK FOLDERS ON YOUR EMAIL PLATFORM TO GET YOUR OTP.
THE OTP IS SENT TO YOUR EMAIL AS SOON AS THE TRANSACTION IS INITIATED.
FILL THE REQUEST DETAILS BELOW AND CLICK �TRANSFER�.  <br>
                </header>

               
                

                <div class="panel-body">
<input name="myid" id="myid" tabindex="1" required="" class="" style="width:14%;" value="<?php echo $myid;?>"  type="hidden">
            
           <div class="form-group">
                      <label for="exampleInputAddress">Enter Recipient User ID</label>
                      <div class="input-group">
                        <span class="input-group-addon"></span>
                        <input name="to_receive" required="" value="" class="form-control" id="usernameQ" type="text">
                      </div>
                      <div id="fullname" style="font-size:14px;color:green;font-weight:bold;"></div>
                    </div>
                     <div class="form-group">
                      <label for="exampleInputAddress">Confirm Email</label>
                      <div class="input-group">
                        <span class="input-group-addon"></span>
                        <input name="email" required="" value="<?php echo $emai;?>" readonly="" class="form-control" type="text">
                      </div>
                     
                    </div>

           <div class="form-group">
                      <label for="exampleInputAddress">Enter Amount to Transfer</label>
                      <div class="input-group">
                        <span class="input-group-addon"></span>
                        <input name="amounts" required="" value="" class="form-control" id="exampleInputAddress" type="text">
                      </div>
                    </div>
                         <div class="form-group">
                      <label for="exampleInputAddress">Enter Transaction Password</label>
                      <div class="input-group">
                        <span class="input-group-addon"></span>
                        <input name="t_password" required="" value="" class="form-control" id="exampleInputAddress" type="password">
                      </div>
                    </div>
                 <div class="row">
            <div class="col-md-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
              <div class="panel">
                <div class="panel-body">
                  <input name="update" value="Transfer" class="btn btn-primary" type="submit">             
                  </div>
              </div>
            </div>
          </div>

              </div></section>

</form>
            </div> <!-- / col-md-6 -->

          

          </div> <!-- / row -->

         

        </div>

<?php include('footer.php'); ?>