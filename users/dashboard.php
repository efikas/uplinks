
<?php include('head.php'); ?>

      <?php 
    if( isset($_POST['btn-approve']) ) {
        
        if($my_balance >= 40){
            $newbalance = $my_balance - 40;
            $ema = trim($_POST['email']);    
            mysqli_query($dbc, "UPDATE user_table SET `status`= 'paid' WHERE email='$ema'");
            mysqli_query($dbc, "UPDATE user_rank SET `status`= 'paid' WHERE email='$ema'");
            
            mysqli_query($dbc, "UPDATE user_rank SET  `balance`= '$newbalance' WHERE email='$ema'");
                unset($ema);  
            
        }
    }
    
    if( isset($_POST['btn-approve_me']) ) {
        
        if($my_balance >= 40){
            $newbalance = $my_balance - 40;
            mysqli_query($dbc, "UPDATE user_table SET `status`= 'paid' WHERE email='$emai'");
            mysqli_query($dbc, "UPDATE user_rank SET `status`= 'paid' WHERE email='$emai'");
            mysqli_query($dbc, "UPDATE user_rank SET  `balance`= '$newbalance' WHERE email='$emai'");       
        }else{
            $pay_error = "insufficient fund";
        }
        
    }
    ?>
<style>
.green{color:green;}
 
h3{
    font-size:1em;
    font-weight:bold;
    font-family:Arial, Helvetica, sans-serif;
}
 
</style>

        <!-- PAGE TITLE -->
        <section id="page-title" class="row">

          <div class="col-md-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
            <h1> Your User Id : <?php echo $myid; ?> <span style="float:right;"><img src="assets/img/logo/uplinkslogo_3D.png" style="height:80px; width: 150px; margin-top:-15px;"></span></h1> 
           
          </div>

        
        </section> <!-- / PAGE TITLE -->
        
        
        <div class="container-fluid"><div class="row">
                <div class="col-md-6 no-left-padding animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5"><header class="panel-heading" style="background:#daa520 !important;color:#fff;">
                      <h4 class="panel-title">My Profile</h4>
                    </header>
                  <section class="card hovercard">
                    <div class="cardheader"></div>
                    <div class="avatar">
                        <img alt="" src="dashboard_files/male.htm">
                    </div>

                    <div class="info">
                        <div class="title">
                            <a href="#"> <?php echo $name; ?></a>
                        </div>
                        <div class="desc">Username : <?php echo $my_userName; ?> </div>
                        <div class="desc">Nigeria</div>
                        <!-- <div class="desc">Oyo, Ibadan </div> -->
                        <div class="desc">Stage Name : Stage<?php echo $my_stage; echo '('.getstage_name($my_stage).')'; ?> </div>
                        <div class="desc">Balance : $<?php echo $my_balance; ?> </div>
                        <div class="desc">Stage Completed Date : <?php echo $my_dor; ?> </div>
                    </div>
                    <!--<div class="bottom">
                        <a class="btn btn-primary btn-twitter btn-sm" href="#"><i class="ti-twitter"></i></a>
                        <a class="btn btn-danger btn-sm" rel="publisher" href="#"><i class="ti-google"></i></a>
                        <a class="btn btn-primary btn-sm" rel="publisher" href="#"><i class="ti-facebook"></i></a>
                         </div>-->
                  </section>
                </div>
                <div class="col-md-6 no-right-padding animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
                  <section class="panel widget-carousel panel-primary">
                    <header class="panel-heading" style="background:#daa520 !important;color:#fff;">
                      <h4 class="panel-title">Official Announcement</h4>
                    </header>
                    <div class="panel-body">

                      <div class="carousel slide" data-ride="carousel" id="quote-carousel-2">
                        <!-- Bottom Carousel Indicators -->
                       
                        <!-- Carousel Slides / Quotes -->
                        <div class="carousel-inner">
                        
                         <div >
        
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-14">
                        <div class="card">
                            <div class="header text-success">
                                 <h3>The following people are directly under you:</h3>
                                 <p>Kindly note that, for each member you register, $40 will be deducted from your wallet.</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                            
                                <table class="table table-striped">
                                    <thead>
                                <tr>
                                    <th>s.no</th>
                                    <th>name</th>
                                    <th>phone</th>
                                    <th>date</th>
                                    <th><div hidden class='noPrint'>action</div></th>
                                </tr>
                            </thead>
                            <?php
                            $me = $userRow['email'];
                            $myid = $userRow['myid'];
                            $query = "SELECT * FROM user_rank WHERE superior_id='$myid' ";
                            $query=mysqli_query($dbc, $query) or die('error selecting user');
                            $i = 1;
                            while ($row = mysqli_fetch_array($query)) {
                                if($i > 2) break;

                                $under_meid[$i] =  $row['myid'];
                                $quer=mysqli_query($dbc, "SELECT * FROM user_table WHERE myid='$under_meid[$i]'");
                                $ron = mysqli_fetch_array($quer);
                                $email[$i] =  $ron['email'];                               
                                $pn[$i]= $ron['phoneNo']; 
                                $nam[$i]= $ron['firstName'].' '.$ron['lastName'];
                                $date[$i] =  $ron['added'];
                                $status[$i] =  $ron['status'];
                               
                              
                            ?>
                                    <tbody>
                         
                            <tr>
                                
                                <td><?php echo $i;?></td>
                                <td><?php echo $nam[$i];?></td>
                                <td><?php echo $pn[$i];?></td>
                                <td><?php echo $date[$i];?></td>

                                <td> 
                                 
                                <?php if($status[$i] == "paid"){ ?>
                                    <div hidden>
                                    <button  hidden style="background:#daa520 !important;color:#fff;" type="submit" class="btn btn-block" name="btn">Paid and Approved</button>
                                    </div>
                                        <?php
                                }
                                else{ ?>
                                <form hidden method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                                    <div hidden  class="form-group">
                                    <input type="hidden" name="email" value="<?php echo $email[$i]; ?>" />
                                    <button style=" background-color: greenyellow;" type="submit" class="btn btn-block" name="btn-approve">Approve</button>
                                    </div> 
                                </form> 
                            <?php } ?>
                            </td>
  
                            </tr>
            
                            <?php $i= $i+1; } ?>
                            <?php $i= 0; ?>
                            	
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    </div>
</div>
              
        </div>
                         
                        </div>
                      </div>         

                    </div>
                  </section>     </div>     </div></div> <!-- / container-fluid -->

<?php include('footer.php'); ?>