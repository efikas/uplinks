<?php include('head.php'); ?>

<?php
/**

 * @author Akintola Oluwaseun Jeremiah

 * @copyright 2017

 */

$transfer_error = '';

if ( isset($_POST['update']) ) {
    
            $error = false;
    $amounts = trim($_POST['amounts']);
    $myid = trim($_POST['myid']);
    $to_receive = trim($_POST['to_receive']);
    $t_password = trim($_POST['t_password']);


    $query_grcvr_det = "SELECT * FROM `user_table` WHERE `userName`='$to_receive'";

    $res = mysqli_query($dbc,$query_grcvr_det);
    $r_count = mysqli_num_rows($res);
    if( $r_count == 1 ) {

        $receiverRow=mysqli_fetch_array($res);
        $rec_uname = $receiverRow['userName'];
        $rec_fname = $receiverRow['firstName'].' '.$receiverRow['lastName'];
        $rec_id = $receiverRow['myid'];
        $rec_email = $receiverRow['email'];

    }else {
        
        
        
        ?>
        
            <script type="text/javascript">
        document.location.href="external-fund-transfer.php?msg=Provided user does not exist!";
    </script>
        
        <?php
        die();
        $error = true;
        $errMSG = "Incorrect Credentials, Try again...";
        header("Location: external-fund-transfer.php?msg=Provided user does not exist!");
    }
    // get balnce of user receiving transfer

    $query_getreceiver = "SELECT * FROM `user_rank` WHERE `myid`='$rec_id'";

    $res = mysqli_query($dbc,$query_getreceiver);
    $receiverRow=mysqli_fetch_array($res);
    $rec_balance = $receiverRow['balance'];
    $rec_balance = $rec_balance + $amounts;



    $password = hash('sha256', $t_password); // password hashing using SHA256



    $res=mysqli_query($dbc,"SELECT * FROM user_table WHERE `email`='$emai'");
    $row=mysqli_fetch_array($res);
    $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
    if( $count == 1 && $row['t_password']==$password && $row['userType']=='1') {

    } else if( $count == 1 && $row['t_password']==$password) {
    } else {
        
        
        
         
        
        ?>
        
            <script type="text/javascript">
        document.location.href="external-fund-transfer.php?msg=Wrong Transaction Password!";
    </script>
        
        <?php
        die();
        $error = true;
        $errMSG = "Incorrect Credentials, Try again...";
        header("Location: external-fund-transfer.php?msg=Wrong Transaction Password!");
    }
    // get balance of user making transfer
    $query_getmyrow = "SELECT * FROM `user_rank` WHERE `myid`='$myid'";
    $res = mysqli_query($dbc,$query_getmyrow);
    $myRow=mysqli_fetch_array($res);
    $my_balance = $myRow['balance'];
    if($my_balance>=$amounts){
        // send mail to you
        $subject = "TRANSACTION OTP FROM UPLINKS";
        $OTP = rand(3353, 76836);
        $message = "OTP for the transfer you initiated is $OTP";
        
        
        mail_user($emai,$my_userName,$subject,$message);

    }   else{


        
        ?>
        
            <script type="text/javascript">
        document.location.href="external-fund-transfer.php?msg=Sorry, insuficient balance to make this transfer!";
    </script>
        
        <?php
        die();
        $transfer_error = "Sorry, insuficient balance to make this transfer";

        header("Location: external-fund-transfer.php?msg=Sorry, insuficient balance to make this transfer!");
    }
}

    if ( isset($_POST['submitt']) ) {
        
            $error = false;
        $amounts = trim($_POST['amounts']);
        $myid = trim($_POST['myid']);
        $to_receive = trim($_POST['to_receive']);
        $t_password = trim($_POST['t_password']);
        $t_otp = trim($_POST['otp']);
       // $OTP = trim($_POST['sentotp']);

        // if($OTP == $t_otp){

        // }else {
            
            
               
       
        
    //         <script type="text/javascript">
    //     document.location.href="external-fund-transfer.php?msg=Wrong OTP!";
    // </script>
        
       
        // die();
        //     $error = true;
        //     header("Location: external-fund-transfer.php?msg=Wrong OTP!");
        //     exit;
        // }


        $query_grcvr_det = "SELECT * FROM `user_table` WHERE `userName`='$to_receive'";

        $res = mysqli_query($dbc,$query_grcvr_det);
        $r_count = mysqli_num_rows($res);
        if( $r_count == 1 ) {

            $receiverRow=mysqli_fetch_array($res);
            $rec_uname = $receiverRow['userName'];
            $rec_fname = $receiverRow['firstName'].' '.$receiverRow['lastName'];
            $rec_id = $receiverRow['myid'];
            $rec_email = $receiverRow['email'];

        }else {
            $error = true;
            $errMSG = "Incorrect Credentials, Try again...";
            header("Location: external-fund-transfer.php?msg=Provided user does not exist!");
        }


            if($rec_id == $myid){

?>
        
            <script type="text/javascript">
        document.location.href="external-fund-transfer.php?msg=Sorry, you can not transfer fund to yourself!";
    </script>
        
        <?php
        die();
            $error = true;
                header("Location: external-fund-transfer.php?msg=Sorry, you can not transfer fund to yourself!");
              
            }
    // get balnce of user receiving transfer

    $query_getreceiver = "SELECT * FROM `user_rank` WHERE `myid`='$rec_id'";

    $res = mysqli_query($dbc,$query_getreceiver);

    $receiverRow=mysqli_fetch_array($res);

    $rec_balance = $receiverRow['balance'];

    $rec_balance = $rec_balance + $amounts;

    $password = hash('sha256', $t_password); // password hashing using SHA256

    $res=mysqli_query($dbc,"SELECT * FROM user_table WHERE `email`='$emai'");
    $row=mysqli_fetch_array($res);
    $sender_n  = $row['lastName'] . ' ' . $row['firstName'];
    


    // get balance of user making transfer
    $query_getmyrow = "SELECT * FROM `user_rank` WHERE `myid`='$myid'";
    $res = mysqli_query($dbc,$query_getmyrow);
    $myRow=mysqli_fetch_array($res);
    $my_balance = $myRow['balance'];
        if($error != true) {
            if ($my_balance >= $amounts) {
                $my_balance = $my_balance - $amounts;

                // get full name of user to receive transfer
                $res = mysqli_query($dbc, "SELECT * FROM user_table WHERE myid='$to_receive'");
                $receiverRow = mysqli_fetch_array($res);
                $rec_name = $receiverRow['lastName'] . ' ' . $userRow['firstName'];
                $query1 = "UPDATE `user_rank` SET `balance`='$my_balance' WHERE `myid`='$myid'";
                $res1 = mysqli_query($dbc, $query1);
                $query2 = "UPDATE `user_rank` SET `balance`='$rec_balance' WHERE `myid`='$rec_id'";

                $res2 = mysqli_query($dbc, $query2);

                if ($res1 && $res2) {
                    $query2 = "INSERT INTO wallet_history(sender_id,receiver_id,sender_name,receiver_name,Credit,Debit,Remark,Status) VALUES('$myid','$rec_id','$rec_name','$rec_fname','$amounts','0','Transfer  of $ $amounts from  $sender_n to $rec_fname','Paid')";

                    $res2 = mysqli_query($dbc, $query2);

?>
        
            <script type="text/javascript">
        document.location.href="external-fund-transfer.php?msg=Success!!! You just transferred <?php echo  "$".$amounts  ?> to <?php echo $rec_fname;  ?>"
        alert("Transaction Successful !");
        ;
    </script>
        
        <?php
        die();
                    header("Location: external-fund-transfer.php?msg=Success!!! You just transfered $$amounts to $rec_fname");
                    exit;

                }
            } else {

                $transfer_error = "Sorry, insuficient balance to make this transfer";

            }
        }


}

?>



<!-- PAGE TITLE -->
<section id="page-title" class="row">

    <div class="col-md-8 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
        <h1>Fund Transfer</h1>
        <p></p><div style="color:#900;font-weight:bold;" align="center"></div><p></p>
    </div>



    <div class="col-md-4 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">

        <ol class="breadcrumb pull-right no-margin-bottom">
            <li><a href="#">Fund Transfer</a></li>
            <li><a href="#">Ewallet transfer</a></li>
        </ol>

    </div>
</section> <!-- / PAGE TITLE -->

<div class="container-fluid">
    <div class="row">

        <div class="col-md-6 animateme scrollme" style="float:none; margin-left:auto; margin-right:auto;" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">

            <form name="bankinfo" method="post" id="bankinfo_form" action="external-fund-transfer-confirm.php">
                <section class="panel">

                    <header class="panel-heading">
                        <h3 class="panel-title">e-Wallet fund transfer confirmation</h3>
                    </header>

                    <div class="panel-body">
                        <input name="wallet" id="wallet" tabindex="1" required="" class="" style="width:4%;" value="final_e_wallet" checked="checked" type="hidden">

                       
                         <div class="row">
                             <div class="col-md-12">
                                 <label>Confirm Userid : <span class="text-success"><?php echo $rec_id;?></span>   </label>
                             </div>
                        </div>
                        
                        <div class="row">
                        <div class="col-md-12">
                            <label>Username : <span class="text-success"><?php echo $rec_uname;?></span> </label>
                             </div> 
                        </div>
                        
                        <div class="row">
                             <div class="col-md-12">
                                 <label>Fullname : <span class="text-success"><?php echo $rec_fname;?></span>.
                                </label> 
                             </div>
                       </div>
                            
                            <div class="input-group">



                               
                                <input name="to_receive" required="" value="<?php echo $to_receive;?>" class="form-control" id="usernameQ" type="hidden">
                                <input name="email" required="" value="<?php echo $emai;?>" readonly="" class="form-control" type="hidden">
                                <input name="amounts" required="" value="<?php echo $amounts;?>" class="form-control" id="exampleInputAddress" type="hidden">
                                <input name="myid" id="myid" tabindex="1" required="" class="" style="width:14%;" value="<?php echo $myid;?>"  type="hidden">
                                <!--<input name="sentotp" id="sentotp" tabindex="1" required="" class="" style="width:14%;" value="<?php //echo $OTP;?>"  type="hidden">-->
                            </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5">
                                 <label for="exampleInputAddress">Confirm amount to transfer</label>
                                  <div class="input-group text-success"><?php echo "$".$amounts;?></div>
                            </div>
                        </div>
                        </div>
                        
                         <div class="form-group">
                             <label for="exampleInputAddress"> You are about to transfer a sum of <strong> $<?php echo htmlspecialchars($amounts); ?></strong> to the User with Username/UserId  <strong><?php echo htmlspecialchars($to_receive);  ?></strong>  </label>
                            <div class="input-group"></div>
                        </div>
                    </div>

                       

                        <!--<div class="form-group">-->
                        <!--    <label for="exampleInputAddress">Enter the OTP</label>-->
                        <!--    <div class="input-group">-->


                        <!--        <input name="otp" required="" class="form-control" id="exampleInputAddress" type="text">-->
                        <!--    </div>-->
                        <!--</div>-->
                        
                        <input name="t_password" required="" value="stanley" class="form-control" id="exampleInputAddress" type="hidden">

                        <div class="row">
                            <div class="col-md-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
                                <div class="panel">
                                    <div class="panel-body">
                                         <a href="#" onclick="return doThis();" name="cancel"  class="btn btn-danger"  >
                                         Cancel Transfer
                                         </a>
                                        <button type="button" onclick="return show_alert()" name="submitt"  class="btn btn-success"  >
                                            Click here to complete transfer
                                        </button>
<!--                                        <input name="submitt" id="submit_button" value="Click here to complete transfer" class="btn btn-success" type="submit">             </div>-->
                                </div>
                            </div>
                        </div>

                    </div></section>

            </form>

        </div> <!-- / col-md-6 -->



    </div> <!-- / row -->
<script src="assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="assets/js/bootbox.min.js" type="text/javascript"></script>
<script >
    // $(document).ready(function () {
    //     $('#submit_button')click(function(e) {
    //         // e.preventDefault();
    //         // e.stopPropagation();
    //         // e.stopImmediatePropagation();
    //
    //         bootbox.confirm({
    //             message: "This is a confirm with custom button text and color! Do you like it?",
    //             buttons: {
    //                 confirm: {
    //                     label: 'Yes',
    //                     className: 'btn-success'
    //                 },
    //                 cancel: {
    //                     label: 'No',
    //                     className: 'btn-danger'
    //                 }
    //             },
    //             callback: function (result) {
    //                 if(result == true){
    //                     $("#bankinfo_form").submit();
    //                 }
    //             }
    //         });
    //         return false;
    //     });
    // });
    // //

    function show_alert() {
  // if(confirm("Do you really want to do this?"))
  //   document.getElementById("bankinfo_form").submit();
  // else
  //   return false;
        bootbox.confirm({
            message: "This is a confirm with custom button text and color! Do you like it?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if(result == true){
                   $("#bankinfo_form").submit();
                }
            }
        });
        return false;
    }

    function submit_form() {
          document.getElementById("bankinfo_form").submit();
    }
</script>



</div> <!-- / container-fluid -->
<?php include('footer.php'); ?>
 <script type="text/javascript">
 
 function doThis(){
      document.location.href="external-fund-transfer.php?msg=Transaction Has Been Cancelled!";
 }
       
    </script>
    