<?php include('head.php'); ?>
      <?php 
      $message = "";
    if( isset($_POST['btn-fund']) ) {
             $amount_in_d = $_POST['amount_in_d'];
        $amount_in_n = $_POST['amount_in_n'];
        echo "<script>alert('Transaction successful ')</script>";
        $message = "<small><br>SUCCESS!!! REQUEST TO ADD FUND IN WALLET HAS BEEN SENT TO ADMIN <br>  <br/> KINDLY PAY TO OUR ACCOUNT <br/> 
        AMOUNT: ".html_entity_decode('&#8358;')."$amount_in_n <br>  <br>ACCOUNT NAME:......... <br> <br> ACCOUNT NUMBER: ............ <br> <br> BANK NAME: G.T. BANK (Guaranty Trust Bank) <br> <br> WE'LL ADD
         $amount_in_d USD TO YOUR WALLET AS SOON AS YOUR PAYMENT IS CONFIRM.<br> <br> <div style=\"color:red;\" >NB: (KINDLY RAISE A TICKET AND UPLOAD YOUR PAYMENT DETAILS) OR SCAN YOUR TELLER/ TRANSACTION NUMBER/ TELLER NUMBER/ PAYMENT DETAILS TO E-MAIL : dollarrequest@uplinks.biz FOR CONFIRMATION </div> <br></small>";
   
        
    mysqli_query($dbc, "INSERT INTO add_fund_request(`amount_in_n`,`amount_in_d`, `email`, `user_id`) VALUES($amount_in_n,$amount_in_d,'$emai', '$myid')");
      
    
    
    }
    ?>
<section id="page-title" class="row">

          <div class="col-md-8 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
            <h1>Add Fund </h1>
            <p></p><div style="color:#900;font-weight:bold;" align="center"></div><p></p>
          </div>

             
             
          <div class="col-md-4 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
          

          </div>
        </section>
        
        <div class="container-fluid">
          <div class="row">
       
            <div class="col-md-6 animateme scrollme" style="float:none; margin-left:auto; margin-right:auto;" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">

           <form name="bankinfo" method="post" action="add_fund_wallet.php">
              <section class="panel">

                <header class="panel-heading">
                  <h3 class="panel-title">Generate Request to add fund in wallet</h3>
                </header>
                <header class="panel-heading">
                 <br> 
                       </header>
                <div class="panel-body">
<input name="wallet" id="wallet" tabindex="1" required="" class="" style="width:4%;" value="final_e_wallet" checked="checked" type="hidden">
            <h2>  <?php echo $message; ?></h2>

                  <?php  if( !isset($_POST['btn-fund']) ) { ?>
           <div class="form-group">
                      <label for="exampleInputAddress">Enter Amount to Add (USD)</label>
                      <div class="input-group">
                        <span class="input-group-addon"></span>
                        <input name="amounts" required="" value="" class="form-control" id="exampleInputAddress" type="number">
                      </div>
                    </div>
                         
                 <div class="row">
            <div class="col-md-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
              <div class="panel">
                
          <input style="background-color:#daa520 !important; " type="button" class="btn btn-fill btn-danger btn-wd" value="Continue" onclick="confirmpay()" id="but" />
                    
							<div style="display: none;" class="panel-body" id="sub">
                                   <div class="col-md-12">
                                    <strong>Add funds to wallet</strong>
                                    <div class="pull-right"><span>&#8358;</span><span id="fund_added" ></span></div>
                                </div>
                                <div  class="col-md-12">
                                    <small>Token charges on Payment </small> 
                                    <div class="pull-right"><span></span><span class="form-errors" id="error_charges"></span><span id="charge" ></span></div>
                                </div>
                                
                                <div class="col-md-12">
                                    <strong>Total to be paid</strong>
                                    <div class="pull-right"><span>&#8358;</span><span id="total_payment"  ></span></div>
                                    <hr>
                                </div>
                        <input name="amount_in_d" required="" value="" class="form-control" id="amount_in_d" type="text">
                        
                        <input name="amount_in_n" required="" value="" class="form-control" id="amount_in_n" type="number">
                        
                 <input  style="background-color:#daa520 !important; " name="btn-fund" id="btn-fund" value="Submit" class="btn btn-primary" type="submit">
               
                        </div>
                                     
                 
              </div>
            </div>
          </div>

              </div>
              <?php } ?>
              </section>

</form>

            </div> <!-- / col-md-6 -->

          

          </div> <!-- / row -->

         

        </div>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        
        <script>

function confirmpay() {
   
			amount_d = $("input[name='amounts']").val();
            amount_n = amount_d * 165;
            token = 1;
			payment_method = $("#payment_method").val(); 
            $("#charge").html(token);
            total = parseInt(amount_n) + parseInt(token);
    
            $("#fund_added").html(amount_n);
            $("#total_payment").html(total);
            document.getElementById("amount_in_n").value = total;
            document.getElementById("amount_in_d").value = amount_d;
            
        document.getElementById("sub").style.display = "block";
        
        

}  
$('#btn-fund').click(function(){
              
})
</script>

<?php include('footer.php'); ?>