
<?php include('head.php'); ?>
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
            <h1> Dashboard  (Your User Id : <?php echo $myid;?>) <span style="float:right;"><img src="assets/img/logo/uplinkslogo_3D.png" style="height:80px;width:200px;margin-top:-15px;"></span></h1> 
           
          </div>

          <div class="col-md-8 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">

            <!--<ol class="breadcrumb pull-right no-margin-bottom">
          
              <li class="active"><h3> Your rank bonus will expire in <span class="green"> </span> days</h3> </li>
            </ol>-->

           <!-- <ol class="breadcrumb pull-right no-margin-bottom">
          
              <li class="active"><h3> Your current position status is <span class="green">  Module  Level  </span></h3> </li>
            </ol>-->

          </div>
        </section> <!-- / PAGE TITLE -->
        
        
        <div class="container-fluid">
          <div class="row">
          
          
          
          	<div class="row row-stat">
                            <div  class="col-md-4 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
                                <div style="background-color:#daa520 !important; "  class="panel panel-success-alt noborder">
                                    <div style="background-color:#daa520 !important; "  class="panel-heading noborder">
                                        <div class="panel-btns" style="display: none;">
                                            <a title="" data-toggle="tooltip" class="panel-close tooltips" href="#" data-original-title="Close Panel"><i class="fa fa-times"></i></a>
                                        </div><!-- panel-btns -->
                                        <div class="panel-icon"><i class="fa fa-dollar"></i></div>
                                        <div class="media-body">
                                            <h5 class="md-title nomargin white">My Total Bonus</h5>
                                            <h1 class="mt5 white">USD <?php echo $my_balance; ?> </h1>
                                        </div><!-- media-body -->
                                        <hr>
                                        <div class="clearfix mt20">
                                            <div class="pull-left">
                                                <h5 class="md-title nomargin white">Last Week Bonus</h5>
                                                <h4 class="nomargin white">USD <?php echo $last_total; ?>
                                                </h4>
                                            </div>
                                            <div class="pull-right">
                                                <h5 class="md-title nomargin white">This Week Bonus</h5>
                                                <h4 class="nomargin white">USD <?php echo $this_total; ?>  </h4>
                                            </div>
                                        </div>
                                        
                                    </div><!-- panel-body -->
                                </div><!-- panel -->
                            </div><!-- col-md-4 -->
                            
                            <div class="col-md-4 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
                                <div class="panel panel-primary noborder">
                                    <div class="panel-heading noborder">
                                        <div class="panel-btns" style="display: none;">
                                            <a title="" data-toggle="tooltip" class="panel-close tooltips" href="#" data-original-title="Close Panel"><i class="fa fa-times"></i></a>
                                        </div><!-- panel-btns -->
                                        <div class="panel-icon"><i class="fa fa-users"></i></div>
                                        <div class="media-body">
                                            <h5 class="md-title nomargin white">Total Referral Bonus</h5>
                                            <h1 class="mt5 white"> <?php echo $referral_total; ?>  </h1>
                                        </div><!-- media-body -->
                                        <hr>
                                        <div class="clearfix mt20">
                                            <div class="pull-left">
                                                <h5 class="md-title nomargin white">Total Matrix Bonus</h5>
                                                <h4 class="nomargin white">USD <?php echo $Matrix_total; ?>    </h4>
                                            </div>
                                            
                                        </div>
                                        
                                    </div><!-- panel-body -->
                                </div><!-- panel -->
                            </div><!-- col-md-4 -->
                            
                            <div class="col-md-4 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
                                <div style="background-color:#daa520 !important; " class="panel panel-dark noborder">
                                    <div  style="background-color:#daa520 !important; "class="panel-heading noborder">
                                        <div class="panel-btns" style="display: none;">
                                            <a title="" data-placement="left" data-toggle="tooltip" class="panel-close tooltips" href="#" data-original-title="Close Panel"><i class="fa fa-times"></i></a>
                                        </div><!-- panel-btns -->
                                        <div class="panel-icon"><i class="fa fa-pencil"></i></div>
                                        <div class="media-body">
                                            <h5 class="md-title nomargin white">My Current Stage</h5>
                                            <h1 class="mt5 white"> Stage <?php echo $my_stage.' ('.getstage_name($my_stage).')'; ?> </h1>
                                        </div><!-- media-body -->
                                        <!-- <hr style="color:#fff;">
                                        <div class="clearfix mt20">
                                            <div class="pull-left">
                                                <h5 class="md-title nomargin white">My Current Stage</h5>
                                                <h4 class="nomargin white"></h4>
                                            </div>
                                           <div class="pull-right">
                                                <h5 class="md-title nomargin white">Total Level 2 Member</h5>
                                                <h4 class="nomargin white"></h4>
                                            </div>
                                        </div>-->
                                        
                                    </div><!-- panel-body -->
                                </div><!-- panel -->
                            </div><!-- col-md-4 -->
                        </div>
                        
                        
                        
       
            <div class="col-md-6 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
             <div>
               <!--  <p style="background-color:#ebebeb;padding:10px;">  <button data-dismiss="alert" class="close close-sm" type="button">
                      <i class="ti-close"></i>
                  </button>
                  <strong>Dear ,</strong>
                  <p style="background-color:#ebebeb;padding:10px;"></p></p>-->
             


<!-- 
             
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
       
        <script type="text/javascript" src="inc/TimeCircles.js"></script>
        <link rel="stylesheet" href="inc/TimeCircles.css" />
            <section class="panel panel-danger">
                <header class="panel-heading">
                  <h3 class="panel-title">REMAINING DAYS FOR UPGRADE / PAY OUT</h3>
                </header>

             
                    
                  <div id="DateCountdown" data-date=" 00:00:00" style="width: 515px; height: 120px; padding: 0px; box-sizing: border-box; background-color: #E0E8EF"></div>
           
          
        <script>
            $("#DateCountdown").TimeCircles();
            $("#CountDownTimer").TimeCircles({ time: { Days: { show: false }, Hours: { show: false } }});
            $("#PageOpenTimer").TimeCircles();
            
            var updateTime = function(){
                var date = $("#date").val();
                var time = $("#time").val();
                var datetime = date + ' ' + time + ':00';
                $("#DateCountdown").data('date', datetime).TimeCircles().start();
            }
            $("#date").change(updateTime).keyup(updateTime);
            $("#time").change(updateTime).keyup(updateTime);
            
            // Start and stop are methods applied on the public TimeCircles instance
            $(".startTimer").click(function() {
                $("#CountDownTimer").TimeCircles().start();
            });
            $(".stopTimer").click(function() {
                $("#CountDownTimer").TimeCircles().stop();
            });

            // Fade in and fade out are examples of how chaining can be done with TimeCircles
            $(".fadeIn").click(function() {
                $("#PageOpenTimer").fadeIn();
            });
            $(".fadeOut").click(function() {
                $("#PageOpenTimer").fadeOut();
            });

        </script>     
                    
                  
                
       
              -->
   </div> 

              <div class="row">
                <div class="col-md-6 no-left-padding animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5"><header class="panel-heading" style="background:#daa520;color:#fff;">
                      <h4 class="panel-title">My Profile</h4>
                    </header>
                  <section class="card hovercard">
                    <div class="cardheader"></div>
                    <div class="avatar">
                        <img alt="" src="images/male.jpg">
                    </div>

                    <div class="info">
                        <div class="title">
                            <a href="#"><?php echo $name; ?></a>
                        </div>
                        <div class="desc">Username : <?php echo $my_userName; ?></div>
                        <div class="desc">Country  : <?php echo 'Nigeria'; ?></div>
                        <div class="desc">Register Date : <?php echo $my_dor; ?></div> 
                        <div class="desc">Stage Name : Stage <?php echo $my_stage;  echo '('.getstage_name($my_stage).')'; ?> </div>

<br>
 <div class="desc">Stage Complete Date : 2017-10-20</div> 
                      


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
                    <header class="panel-heading" style="background:#daa520 !important;color:#fff;" >
                      <h4 class="panel-title" >Official Announcement</h4>
                    </header>
                    <div class="panel-body">

                      <div class="carousel slide" data-ride="carousel" id="quote-carousel-2">
                        <!-- Bottom Carousel Indicators -->
                       
                        <!-- Carousel Slides / Quotes -->
                        <div class="carousel-inner">
                        
                                                   <!-- Quote 1 -->
                          <div class="item active">
                            <blockquote>
                              <div class="row">
                                <div class="col-sm-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">
                                 <a href="announcemnet-detail.php?id=12"> <p>NEWS UPDATE- FINAL EXTENSION NOTICE</p>
                                </a></div><a href="announcemnet-detail.php?id=12">
                              </a></div><a href="announcemnet-detail.php?id=12">
                            </a></blockquote><a href="announcemnet-detail.php?id=12">
                          </a></div><a href="announcemnet-detail.php?id=12">
                                                   <!-- Quote 1 -->
                          </a><div class="item active"><a href="announcemnet-detail.php?id=12">
                            </a><blockquote><a href="announcemnet-detail.php?id=12">
                              </a><div class="row"><a href="announcemnet-detail.php?id=12">
                                </a><div class="col-sm-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);"><a href="announcemnet-detail.php?id=12">
                                 </a><a href="announcemnet-detail.php?id=11"> <p>NEWS UPDATE- FINAL EXTENSION NOTICE</p>
                                </a></div><a href="announcemnet-detail.php?id=11">
                              </a></div><a href="announcemnet-detail.php?id=11">
                            </a></blockquote><a href="announcemnet-detail.php?id=11">
                          </a></div><a href="announcemnet-detail.php?id=11">
                                                   <!-- Quote 1 -->
                          </a><div class="item active"><a href="announcemnet-detail.php?id=11">
                            </a><blockquote><a href="announcemnet-detail.php?id=11">
                              </a><div class="row"><a href="announcemnet-detail.php?id=11">
                                </a><div class="col-sm-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);"><a href="announcemnet-detail.php?id=11">
                                 </a><a href="announcemnet-detail.php?id=10"> <p>NEWS UPDATE:</p>
                                </a></div><a href="announcemnet-detail.php?id=10">
                              </a></div><a href="announcemnet-detail.php?id=10">
                            </a></blockquote><a href="announcemnet-detail.php?id=10">
                          </a></div><a href="announcemnet-detail.php?id=10">
                                                  
                        </a></div><a href="announcemnet-detail.php?id=10">
                      </a></div><a href="announcemnet-detail.php?id=10">         

                    </a></div><a href="announcemnet-detail.php?id=10">
                  </a></section><a href="announcemnet-detail.php?id=10">     </a></div><a href="announcemnet-detail.php?id=10">     </a></div><a href="announcemnet-detail.php?id=10">
                   </a><section class="panel panel-danger"><a href="announcemnet-detail.php?id=10">
                <header class="panel-heading" style="background:#daa520 !important;color:#fff;">
                  <h3 class="panel-title">Last 10 Referral Member</h3>
                </header>


                  <table class="table table-hover table-condensed">
                      
                    <tbody>
    <?php
                            $me = $userRow['email'];
                            $myid = $userRow['myid'];
                            $query = "SELECT * FROM user_rank WHERE superior_id='$myid' ";
                            $query=mysqli_query($dbc, $query) or die('error selecting user');
                            $i= 1;
                            while ($row = mysqli_fetch_array($query)) {
                                $under_meid[$i] =  $row['myid'];
                             $quer=mysqli_query($dbc, "SELECT * FROM user_table WHERE myid='$under_meid[$i]'");
                            $ron = mysqli_fetch_array($quer);
                            $userName[$i] =  $ron['userName'];  
                            $nam[$i]= $ron['firstName'];
                            $date[$i] =  $ron['added'];
                            $status[$i] =  $ron['status'];
                               if ($i == 10){continue;} 
                              
                            ?>
                                          <tr>
                        <th scope="row"> <?php echo $i; ?> </th>
                        <td><?php echo $userName[$i]; ?></td>
                        <td><?php echo $nam[$i]; ?>  </td>
                        <td><?php echo $date[$i]; ?> </td>
                      </tr>
                                    
                            <?php $i= $i+1; } ?>
                                         </tbody>
                                         
                  </table>


                </a><div class="panel-footer text-right"><a href="direct-sponsor-member-report.php" class="btn btn-primary" style="background:#daa520 !important;color:#fff;">View All</a>
                </div>
              </section>
           
         
        
            </div> <!-- / col-md-6 -->

            <div class="col-md-6 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">

              <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 no-left-padding animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
                  <a href="#" class="text-widget color-1" style="background:#daa520 !important;color:#fff;">
                    <header style="background:#daa520 !important;color:#fff;">Referral:
                    <br><?php echo $number; ?></header>
                   
                  </a>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 no-right-padding animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
                  <a href="#" class="text-widget color-2" style="background:#daa520 !important;color:#fff;">
                    <header style="background:#daa520 !important;color:#fff;">E-Wallet:<br>
                    USD <?php echo $my_balance; ?></header>
           
                  </a>
                </div>
              </div>

              <!--<section class="panel">
                <header class="panel-heading">
                  <h4 class="panel-title">This Month Bonus Summary</h4>
                </header>
                <div class="panel-body">
                  
                  	
                    <div class="bargraph">
                    <ul class="bars">

                                            <li class="bar1 bluebar" style="height: 0px;"></li>
                        <li class="bar2 bluebar" style="height: 0px;"></li>
                          <li class="bar3 bluebar" style="height: 0px;"></li>
                        <li class="bar4 bluebar" style="height: 0px;"></li>
                       
             
                      
                    </ul>
                
                	<ul class="y-axis"><li></li><li></li><li>Price</li><li></li><li></li></ul>
                	<p>1)Referral &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2)Level &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3)Stage &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3)Total Bonus</p>
                    
                </div>
                    
                  
                </div>
              </section>--> <section class="panel panel-danger">
                <header class="panel-heading" style="background:#daa520;color:#fff;">
                  <h3 class="panel-title">Recent Transactions</h3>
                </header>

                  <div class="list-group">
                   
            	          <?php
                            $me= $userRow['email'];
                            $query=mysqli_query($dbc,"SELECT * FROM wallet_history WHERE receiver_id='$myid' OR sender_id='$myid'");
                            $i= 1;
                            while ($row = mysqli_fetch_array($query)) {
                                $sender_id[$i] =  $row['sender_id'];                               
                                $receiver_id[$i]= $row['receiver_id']; 
                                $sender_name[$i]= $row['sender_name']; 
                                $receiver_name[$i]= $row['receiver_name']; 
                                $Credit[$i]= $row['Credit'];                            
                                $Debit[$i]= $row['Debit']; 
                                $Remark[$i]= $row['Remark']; 
                                $Date[$i]= $row['Date']; 
                                $Status[$i]= $row['Status']; 
                                
                               if ($i == 10){continue;} 
                              
                            ?>  
                    <a href="#" class="list-group-item">

                        <div class="col-md-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
                         <?php echo $Remark[$i]; ?> with 0% admin charge <!--<span style="float:right;"> <button disabled="disabled" class="btn btn-success"> <?php echo $Date[$i]; ?></button></span>-->
                        </div>

                      

                        <div class="clearfix"></div>
                    </a>
                          
                            <?php $i= $i+1; } ?>
                            <?php $i= 0; ?>
                                   </div>
                  <div class="panel-footer text-right">
                    <a href="ewallet-transaction-history.php" class="btn btn-primary" style="background:#daa520 !important;color:#fff;">View All</a>
                  </div>
              </section>

             

             

            </div> <!-- / col-md-6 -->

            <div class="row row-stat">
                        </div>
          </div> <!-- / row -->

        </div> <!-- / container-fluid -->

<?php include('footer.php'); ?>