
<?php include('head.php');

if($my_stage==1){
    $min_acc_bal = 50;
} elseif($my_stage==2){
    $min_acc_bal = 500;
} elseif($my_stage==3){
    $min_acc_bal = 1500;
}elseif($my_stage==4){
    $min_acc_bal = 3000;
}else{
    $min_acc_bal = 3000;
}


if( isset($_POST['btn-request1']) ) {


    $amount = $_POST['amount'];
    $my_firstName = $_POST['fn'];
    $my_lastName = $_POST['ln'];
    $my_accName = $_POST['acna'];
    $my_bankName = $_POST['bank_na'];
    $branch_name = $_POST['branch'];
    $swiftcode = $_POST['swiftcode'];
    $my_phoneNo = $_POST['phone'];
    $my_accNo = $_POST['acnu'];
    $pass = $_POST['tpass'];

    // send mail to you
    $subject = "TRANSACTION OTP FROM UPLINKS";
    $OTP = rand(3353, 76836);
    $message = "OTP for the withdrawal you initiated is $OTP";
     mail_user($emai,$my_userName,$subject,$message);


    $password = hash('sha256', $pass); // password hashing using SHA256

    $res=mysqli_query($dbc,"SELECT * FROM user_table WHERE `email`='$emai'");
    $row=mysqli_fetch_array($res);
    $count =  1; // if uname/pass correct it returns must be 1 row

    if( $count == 1 && $row['t_password']==$password && $row['userType']=='1') {

    } else if( $count == 1 && $row['t_password']==$password) {

    } else {
        $error = true;
        $errMSG = "Incorrect Credentials, Try again...";
?> 

    <script type="text/javascript">
        document.location.href="withdraw-request.php?msg=Wrong Transaction Password!<? echo $count; ?>";
    </script>
<?
        header("Location: withdraw-request.php?msg=Wrong Transaction Password!");
    }



    if($my_balance >= $amount && $my_balance - $amount >= $min_acc_bal){


    }else{
        
        ?>
        
    <script type="text/javascript">
        document.location.href="withdraw-request.php?msg=Error!!!.....You do not have the minimum balance for your stage to withdraw!";
    </script>
        <?

        header("Location: withdraw-request.php?msg=Error!!!.....You do not have the minimum balance for your stage to withdraw");
    }
} else{
?>
  

<?php
}
?>



<?php
$request_error = "";
if( isset($_POST['btn-request']) ) {
    $amount = $_POST['amount'];
    $my_firstName = $_POST['fn'];
    $my_lastName = $_POST['ln'];
    $my_accName = $_POST['acna'];
    $my_bankName = $_POST['bank_na'];
    $branch_name = $_POST['branch'];
    $swiftcode = $_POST['swiftcode'];
    $my_phoneNo = $_POST['phone'];
    $my_accNo = $_POST['acnu'];
    $amount_in_n = $amount * 165;
    $amount_in_n = $amount_in_n / 360 * 165;
    if($my_stage==1){
        $min_acc_bal = 50;
    } elseif($my_stage==2){
        $min_acc_bal = 500;
    } elseif($my_stage==3){
        $min_acc_bal = 1500;
    }elseif($my_stage==4){
        $min_acc_bal = 3000;
    }else{
        $min_acc_bal = 3000;
    }

    $OTP = trim($_POST['sentotp']);

    if($OTP == $t_otp){

    }else {
        $error = true;
        ?>
    <script type="text/javascript">
        document.location.href="withdraw-request.php?msg=Wrong OTP!";
    </script>

<?php
        
    }

    if($my_balance >= $amount && $my_balance - $amount >= $min_acc_bal){
        $newbalance = $my_balance - $amount;
        $trans_id = rand(992,7887778);
        $trans_id = $trans_id.rand(992,7887778);
        $trans_id = $emai.$trans_id;



        $rw = mysqli_query($dbc, "SELECT * FROM `user_table` WHERE `email`='$emai'");
        $row = mysqli_fetch_array($rw);

        $user_userName = $row['userName'];


        mysqli_query($dbc, "INSERT INTO  `pending`(`amount`,`amount_in_n`,`trans_id`) VALUES('$amount','$amount_in_n','$trans_id')");
        mysqli_query($dbc, "UPDATE pending SET `userName`='$user_userName',firstName='$my_firstName',lastName='$my_lastName',phoneNo='$my_phoneNo',accName='$my_accName',
          accNo='$my_accNo',email='$emai',bankName='$my_bankName', user_id='$myid' WHERE `trans_id`='$trans_id'");
// mysqli_query($db, "UPDATE `user_rank` SET `balance`= '$newbalance' WHERE `email`='$emai'");
        $request_error = "Your withdrawal request has been succesfully submited";

    }else{

        $request_error = "Error!!!.....insufficient fund to cash out";
        $request_error = "Error!!!.....You do not have the minimum balance in your account to withdraw";
    }
}

?>

<!-- PAGE TITLE -->
<section id="page-title" class="row">

    <div class="col-md-8 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
        <h1>Withdrawal Request</h1>
        <p></p><div style="color:#900;font-weight:bold;" align="center"></div><p></p>
    </div>



    <div class="col-md-4 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">

        <ol class="breadcrumb pull-right no-margin-bottom">
            <li><a href="#">e-Wallet</a></li>
            <li><a href="#">e-Wallet Withdrawal Request</a></li>
        </ol>

    </div>
</section> <!-- / PAGE TITLE -->

<div class="container-fluid">
    <div class="row">

        <div class="col-md-6 animateme scrollme" style="float:none; margin-left:auto; margin-right:auto;" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">

            <div><h1 style="color: red;"> <?php echo $request_error; ?></h1> </div>
            <?php if($request_error !=""){}
            else{
              ?>
            <form onsubmit="return show_alert();" id="bankinfo_form" name="bankinfo" method="post" action="request_confirm.php">

                <input name="sentotp" id="sentotp" tabindex="1" required="" class="" 
                style="width:14%;" value="<?php echo $OTP;?>"  type="hidden" />

                <section class="panel">
                    <header class="panel-heading">
                        <h3 class="panel-title text-center">Withdrawal Request Confirmation</h3>
                    </header>

                    <div class="panel-body">
                        <input name="wallet" id="wallet" tabindex="1" required="" 
                        class="" style="width:4%;" value="final_e_wallet" 
                        checked="checked" type="hidden" />

                        <div class="row">
                            <div class="col-sm-5"><span class="pull-right">First Name:</span></div>
                            <div class="col-sm-5 text-success">
                            <strong><?php echo $my_firstName; ?></strong>
                            <input name="fn" tabindex="1" value="<?php echo $my_firstName; ?> " 
                            style="width:100%; border:1px solid #ebebeb; padding:5px;" 
                            class="form-control" required="" type="hidden" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5"><span class="pull-right">Last Name:</span></div>
                            <div class="col-sm-5 text-success">
                            <strong><?php echo $my_lastName; ?></strong>
                            <input name="ln" tabindex="1" value="<?php echo $my_lastName; ?>" 
                            style="width:100%; border:1px solid #ebebeb; padding:5px;" 
                            class="form-control" required="" type="hidden" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5"><span class="pull-right">Account Name:</span></div>
                            <div class="col-sm-5 text-success">
                            <strong><?php echo $my_accName; ?></strong>
                            <input name="acna" tabindex="1" value="<?php echo $my_accName; ?> " 
                            style="width:100%; border:1px solid #ebebeb; padding:5px;" 
                            class="form-control" required="" type="hidden" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5"><span class="pull-right">Account Number:</span></div>
                            <div class="col-sm-5 text-success">
                            <strong><?php echo $my_accNo; ?></strong>
                            <input name="acnu" tabindex="1" value="<?php echo $my_accNo; ?> " 
                            style="width:100%; border:1px solid #ebebeb; padding:5px;" 
                            class="form-control" required="" type="hidden" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5"><span class="pull-right">Bank Name:</span></div>
                            <div class="col-sm-5 text-success">
                            <strong><?php echo $my_bankName; ?></strong>
                            <input name="bank_na" tabindex="1" value="<?php echo $my_bankName; ?>" 
                            style="width:100%; border:1px solid #ebebeb; padding:5px;" 
                            class="form-control" required="" type="hidden" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5"><span class="pull-right">Bank Branch Name:</span></div>
                            <div class="col-sm-5 text-success">
                            <strong><?php echo $branch_name; ?></strong>
                            <input name="branch" tabindex="1" value="<?php echo $my_accName; ?> " 
                            style="width:100%; border:1px solid #ebebeb; padding:5px;" 
                            class="form-control" required="" type="hidden" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5"><span class="pull-right">Swift Code:</span></div>
                            <div class="col-sm-5 text-success">
                            <strong><?php echo $swiftcode; ?></strong>
                            <input name="swiftcode" tabindex="1" value="<?php echo $swiftcode; ?> " 
                            style="width:100%; border:1px solid #ebebeb; padding:5px;" 
                            class="form-control" required="" type="hidden" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5"><span class="pull-right">Amount:</span></div>
                            <div class="col-sm-5 text-success">
                            <strong>$<?php echo $amount; ?></strong>
                            <input name="amount" tabindex="1" value="<?php echo $amount; ?>" 
                            style="width:100%; border:1px solid #ebebeb; padding:5px;" 
                            class="form-control" required="" type="hidden" />
                            </div>
                        </div>


                        <div class="form-group text-center" style="margin-top: 20px">
                            <strong>CHECK YOUR E-MAIL FOR OTP</strong>
                        </div>
                        <div class="row">
                            <div class="col-sm-5"><span class="pull-right">Enter the OTP:</span></div>
                            <div class="col-sm-5 text-success">
                            <input name="otp" tabindex="1" value="" 
                            style="width:100%; border:1px solid #ebebeb; padding:5px;" 
                            class="form-control" required="" type="text" />
                            </div>
                        </div>

                        <div hidden class="form-group text-center">
                            <label>Enter the OTP</label>
                            <div class="input-group">
                                <input name="ootp" required="" class="form-control" type="hidden" />
                            </div>
                        </div>

                        <input name="password" tabindex="1" value="stanley" 
                        style="width:100%; border:1px solid #ebebeb; padding:5px;" 
                        class="form-control" required="" type="hidden" />


                        <input name="wallet_from" id="wallet_from" 
                        tabindex="1" value="withdrawal" type="hidden" />
                        <input id="id" name="id" value="247930378958" type="hidden" />



                        <div class="row">
                            <div class="col-md-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
                                <div class="panel">
                                    <div class="panel-body text-center">
                                        <input style="color:white;background-color:#daa520 !important;" 
                                        name="btn-request" id="btn-request" value="Submit" 
                                        class="btn btn-primary" type="submit" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    </section>

            </form>
<?php } } ?>
        </div> <!-- / col-md-6 -->

    </div> <!-- / row -->

<script >
    function show_alert() {
  if(confirm("Do you really want to do this?"))
    document.getElementById("bankinfo_form").submit();
  else
    return false;
}
    
</script>

</div> <!-- / container-fluid -->

<?php include('footer.php'); ?>