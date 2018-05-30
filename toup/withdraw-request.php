
<?php include('head.php'); ?>



<?php
$request_error = "";
if( isset($_POST['btn-request']) ) {

    $amount = $_POST['amount'];
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
    if($my_balance >= $amount && $my_balance - $amount >= $min_acc_bal){
        $newbalance = $my_balance - $amount;
        $trans_id = rand(992,7887778);
        $trans_id = $trans_id.rand(992,7887778);
        $trans_id = $emai.$trans_id;



        $rw = mysqli_query($dbc, "SELECT * FROM `user_table` WHERE `email`='$emai'");
        $row = mysqli_fetch_array($rw);

        $user_userName = $row['userName'];
        $user_firstName = $row['firstName'];
        $user_lastName = $row['lastName'];
        $user_phoneNo = $row['phoneNo'];
        $user_accName = $row['accName'];
        $user_accNo = $row['accNo'];
        $user_email = $row['email'];
        $user_bankName = $row['bankName'];
        $user_myid = $row['myid'];

        mysqli_query($dbc, "INSERT INTO  `pending`(`amount`,`amount_in_n`,`trans_id`) VALUES('$amount','$amount_in_n','$trans_id')");
        mysqli_query($dbc, "UPDATE pending SET `userName`='$user_userName',firstName='$user_firstName',lastName='$user_lastName',phoneNo='$user_phoneNo',accName='$user_accName',
          accNo='$user_accNo',email='$user_email',bankName='$user_bankName', user_id='$user_myid' WHERE `trans_id`='$trans_id'");
// mysqli_query($dbc, "UPDATE `user_rank` SET `balance`= '$newbalance' WHERE `email`='$emai'");
    $request_error = "Your withdrawal request has been succesfully submited";
        }else{

        $request_error = "Error!!!.....insufficient fund to cash out";
    }
}

?>
<section id="page-title" class="row">

    <div class="col-md-8 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
        <!--<h1>Withdrawal Request</h1>-->
        <p></p><div style="color:#900;font-weight:bold;" align="center"></div><p></p>
    </div>



    <div class="col-md-4 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">

        <ol class="breadcrumb pull-right no-margin-bottom">
            <!--<li><a href="#">e-Wallet</a></li>
            <li><a href="#">e-Wallet Withdrawal Request</a></li>-->
        </ol>

    </div>
</section>

<div class="container-fluid">
    <div class="row">

        <div class="col-md-6 animateme scrollme" style="float:none; margin-left:auto; margin-right:auto;" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">

            <div><h1 style="color: red;"> <?php echo $request_error; ?></h1> </div>

            <form name="bankinfo" method="post" action="withdraw-request.php">
                <section class="panel">

                    <header class="panel-heading">
                        <h3 class="panel-title">Withdrawal Request Form</h3>
                    </header>
                    <header class="panel-heading">
                        <br> <h3 class="panel-title">e-Wallet Balance :  <strong><?php echo $my_balance; ?> </strong> USD<br><br>NOTE : Admin Charge of 4% will be levied for all Withdrawals<br><br>NOTE : Minimum Withdrawal is 50 USD<br><br>Note :  If you have not a valid phone number then you are not able to transfer  <br>
                            <br>Note :  0.06 USD will be charge from your account for otp sms.</h3>
                        <br></header>
                    <div class="panel-body">
                        <input name="wallet" id="wallet" tabindex="1" required="" class="" style="width:4%;" value="final_e_wallet" checked="checked" type="hidden">

                        <div class="form-group">
                            <label for="exampleInputAddress">First Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"></span>
                                <input name="fn" tabindex="1" value="<?php echo $my_firstName; ?> " style="width:100%; border:1px solid #ebebeb; padding:5px;" class="form-control" id="exampleInputAddress" required="" type="text">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputAddress">Last Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"></span>
                                <input name="ln" tabindex="1" value="<?php echo $my_lastName; ?> " style="width:100%; border:1px solid #ebebeb; padding:5px;" class="form-control" id="exampleInputAddress" required="" type="text">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputAddress">Account Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"></span>
                                <input name="acna" tabindex="1" value="<?php echo $my_accName; ?>" style="width:100%; border:1px solid #ebebeb; padding:5px;" class="form-control" id="exampleInputAddress" required="" type="text">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputAddress">Account Number</label>
                            <div class="input-group">
                                <span class="input-group-addon"></span>
                                <input name="acnu" tabindex="1" value="<?php echo $my_accNo; ?> " style="width:100%; border:1px solid #ebebeb; padding:5px;" class="form-control" id="exampleInputAddress" required="" type="text">

                            </div>
                        </div>


                        <div class="form-group">
                            <label for="exampleInputAddress">Bank Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"></span>
                                <input name="bank_na" tabindex="1" value="<?php echo $my_bankName; ?> " style="width:100%; border:1px solid #ebebeb; padding:5px;" class="form-control" id="exampleInputAddress" required="" type="text">

                            </div>
                        </div>


                        <div class="form-group">
                            <label for="exampleInputAddress">Branch Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"></span>
                                <input name="subject6" tabindex="1" value="" style="width:100%; border:1px solid #ebebeb; padding:5px;" class="form-control" id="exampleInputAddress" required="" type="text">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputAddress">Check Your Phone Number Otp Will Be Send</label>
                            <div class="input-group">
                                <span class="input-group-addon"></span>
                                <input name="phone" required="" value="<?php echo $my_phoneNo; ?> " readonly="" class="form-control" type="text">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="exampleInputAddress">Enter Amount</label>
                            <div class="input-group">
                                <span class="input-group-addon"></span>
                                <input name="amount" tabindex="1" value="" style="width:100%; border:1px solid #ebebeb; padding:5px;" class="form-control" id="exampleInputAddress" required="" type="number">

                            </div>
                        </div>

                        <input name="wallet_from" id="wallet_from" tabindex="1" value="withdrawal" type="hidden">
                        <input id="id" name="id" value="<?php echo $myid; ?> " type="hidden">







                        <div class="row">
                            <div class="col-md-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
                                <div class="panel">
                                    <div class="panel-body">
                                        <input name="btn-request" value="Submit" class="btn btn-primary" type="submit">             </div>
                                </div>
                            </div>
                        </div>

                    </div></section>

            </form>

        </div> <!-- / col-md-6 -->



    </div> <!-- / row -->



</div>
<?php include('footer.php'); ?>