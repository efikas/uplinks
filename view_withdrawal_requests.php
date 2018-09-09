<?php
    include('head.php');

    require_once 'app/init.php';
    require_once 'includes/UserClass.php';
    $userClass = new UserClass();


	if( isset($_POST['btn-paid']) ) {
	    
	    if(($my_userName !='Admin1') && ($my_userName !='Admin2')){
	        echo "<script> alert('Sorry you do not have the administrative priviledge to perform this action') </script>";
	        
	    }else{
        $user_id = trim($_POST['user_id']); 
        $amount = trim($_POST['amount']);  
        $fund_id = trim($_POST['fund_id']);    
        mysqli_query($dbc, "UPDATE `pending` SET `status`= 'paid' WHERE `id`='$fund_id'");



        $query = "SELECT * FROM `user_rank` WHERE `myid` = '$user_id'";
        $res = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($res);

        $bal = $row[balance];
        $newbalance = $bal - $amount;

        mysqli_query($dbc, "UPDATE `user_rank` SET `balance`=$newbalance WHERE `myid`='$user_id'");
 
	}
      
    }
if( isset($_POST['userN']) ) {
    $userN = trim($_POST['userN']);
    $query= mysqli_query($dbc,"SELECT * FROM `pending` WHERE `userName`='$userN'");
    $row = mysqli_fetch_array($query);
}

if(isset($_GET['page'])){
    if(is_numeric($_GET['page'])){
        $page=max(intval($_GET['page']),1); // assuming there is a parameter 'page'
    }else{
        $page = 1;
    }
}else{
    $page = 1;
}
$query=mysqli_query($dbc,"SELECT * FROM `pending`");
$pagerow = mysqli_fetch_array($query);
$total = mysqli_num_rows($query);
$itemsperpage = 10;

if(isset($_POST['itemsperpage'])){

    $itemsperpage = $_POST['itemsperpage'];
}
if(isset($_GET['itp'])){

    $itemsperpage = $_GET['itp'];
}
$totalpages = max(ceil($total/$itemsperpage),1);
?>
<section id="page-title" class="row">

          <div class="col-md-8 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">
            <!--<h1>Referral Member</h1>-->
            <!--<p><a href="#" target="_blank" class="btn btn-danger btn-sm">DataTables documentation</a></p>-->
          </div>

          <div class="col-md-4 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">

            <ol class="breadcrumb pull-right no-margin-bottom">
              <!--<li><a href="#">Team Report</a></li>
              <li><a href="#">Direct Refferal Member</a></li>-->
             
            </ol>

          </div>
        </section>
        
        <div class="container-fluid">
          <div class="row">

            <div class="col-md-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">

              <section class="panel panel-primary">
                <header class="panel-heading">
                  <h4 class="panel-title">View Withdrawal Requests</h4>
                </header>
                <div class="panel-body">


                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"><div class="dataTables_length" id="DataTables_Table_0_length"> <form id="maxdisplay" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"><label>Show <select  id="itemsperpage" onchange="getState(this.value)"  name="itemsperpage" aria-controls="DataTables_Table_0" class=""><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div> </form> <form id="search" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"> <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input name="userN" type="text"></input> </label></div></form>
                  <table class="table datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                    <thead>
                      <tr><th >S/No.</th> <th >Username</th>  <th >Amount in Dollar</th>   <th >Amount in Naira</th>    <th >Bank's Name</th>    <th >Account Number</th> <th >Date Raised</th> <th >Status/Action</th></tr>



<?php if( isset($_POST['userN']) ) {
    $i = 0;

$query= mysqli_query($dbc,"SELECT * FROM `pending` WHERE `userName`='$userN'");


$srow =  mysqli_fetch_array($query);
?>

          <?php if(count($srow) < 1) { ?>
              <tr class="odd"><td colspan="7" class="dataTables_empty" valign="top">No matching records found</td></tr>

          <?php } ?>
          <?php
                while ($row = mysqli_fetch_array($query)) {
                    $ref_email[$i] =  $row['email'];
                    $fund_id[$i] =  $row['id'];
                    $ref_amount_in_n[$i] =  $row['amount_in_n'];
                    $ref_amount_in_d[$i]= $row['amount'];
                    $ref_user_id[$i]= $row['user_id'];
                    $ref_username[$i]= $userClass->getUsername($row['user_id']);
                    $ref_date[$i]= $row['added'];
                    $ref_bankName[$i]= $row['bankName'];
                    $ref_accNo[$i]= $row['accNo'];
                    $ref_status[$i]= $row['status'];

    ?>

    <tbody>
                      <tr role="row" class="odd">

                          <th scope="row" class="sorting_1"><?php echo $i;?></th>

                          <td><?php echo $ref_username[$i];?></td>
                          <td><?php echo $ref_amount_in_d[$i];?></td>
                          <td><?php echo $ref_amount_in_n[$i];?></td>
                          <td><?php echo $ref_bankName[$i];?></td>
                          <td><?php echo $ref_accNo[$i];?></td>
                          <td><?php echo $ref_date[$i];?></td>
                          <td>
                              <?php $email[$i] =  $row['email'];  if($ref_status[$i]=="Not Paid"){?>

                                  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                                      <div class="form-group">
                                          <input type="hidden" name="user_id" value="<?php echo $ref_user_id[$i]; ?>" />
                                          <input type="hidden" name="amount" value="<?php echo $ref_amount_in_d[$i]; ?>" />
                                          <input type="hidden" name="fund_id" value="<?php echo $fund_id[$i]; ?>" />
                                          <button  style="color:white;background-color:#daa520 !important;" type="submit" class="btn btn-block btn-primary" name="btn-paid">Paid</button>
                                      </div>

                                  </form>
                              <?php } else{ ?>

                                  <?php echo $ref_status[$i];?>


                              <?php } ?>
                          </td>

                      </tr>

                      <?php $i= $i+1; } ?>
                      <?php $i= 0; ?>
    </tbody>

<?php } else{ ?>
                    <tbody>
                     
                     
            	          <?php
                            $me= $userRow['email'];
                            $query=mysqli_query($dbc,"SELECT * FROM `pending` LIMIT ".(($page-1)*$itemsperpage).','.$itemsperpage);
                            $i= 1;
                          $start_count = ($page-1)*$itemsperpage;
                            while ($row = mysqli_fetch_array($query)) {
                                $ref_email[$i] =  $row['email']; 
                                $fund_id[$i] =  $row['id']; 
                                $ref_amount_in_n[$i] =  $row['amount_in_n'];                               
                                $ref_amount_in_d[$i]= $row['amount']; 
                                $ref_user_id[$i]= $row['user_id'];
                                $ref_username[$i]= $userClass->getUsername($row['user_id']);
                                $ref_date[$i]= $row['added'];  
                                $ref_bankName[$i]= $row['bankName'];  
                                $ref_accNo[$i]= $row['accNo'];  
                                $ref_status[$i]= $row['status'];
                                $start_count++;
                              
                            ?>         
                                <tr role="row" class="odd">
                                
                        <th scope="row" class="sorting_1"><?php echo $start_count;?></th>
                                
                                <td><?php echo $ref_username[$i];?></td>
                                <td><?php echo $ref_amount_in_d[$i];?></td>                      
                                <td><?php echo $ref_amount_in_n[$i];?></td>                     
                                <td><?php echo $ref_bankName[$i];?></td>                     
                                <td><?php echo $ref_accNo[$i];?></td> 
                                <td><?php echo $ref_date[$i];?></td>
                                       <td>
                                <?php $email[$i] =  $row['email'];  if($ref_status[$i]=="Not Paid"){?>  
                                
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                                <div class="form-group">
                                <input type="hidden" name="user_id" value="<?php echo $ref_user_id[$i]; ?>" />
                                <input type="hidden" name="amount" value="<?php echo $ref_amount_in_d[$i]; ?>" />
                                <input type="hidden" name="fund_id" value="<?php echo $fund_id[$i]; ?>" />
                                <button  style="color:white;background-color:#daa520 !important;" type="submit" class="btn btn-block btn-primary" name="btn-paid">Paid</button>
                                </div>
                                
                            </form>
                            <?php } else{ ?>
                            
                                <?php echo $ref_status[$i];?>
                            
                            
                            <?php } ?>
                                </td>
    
                            </tr>
            
                            <?php $i= $i+1; } ?>
                            <?php $i= 0; ?>
                   
                      
                      </tbody>
    <?php } ?>
                  </table>

                        <?php if( !isset($_POST['userN']) ) { ?>
                            <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                                Showing <?php  $start_n = (($page-1)*$itemsperpage) +1;
                                $stop_n = $start_n+$itemsperpage -1;
                                if($page==$totalpages){
                                    $stop_n = $total;
                                }
                                echo $start_n.' to '.$stop_n.' of '.$total.' entries'; ?></div>
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                <?php
                                if( $page > 1 ) {
                                    $npage = $page + 1;
                                    $last = $page - 1;
                                    echo "<a style=\"color:white;background-color:#daa520 !important;\" class=\"btn btn-login \" href = \"$_PHP_SELF?itp=$itemsperpage&page=$last\">Previous</a>";
                                }
                                ?>
                                <?php for($w=1; $w<$totalpages+1; $w++){
                                    ?>
                                    <a <?php echo " href = \"$_PHP_SELF?itp=$itemsperpage&page=$w\""; ?> style="color:white;background-color:#daa520 !important;" class="btn btn-login " ><?php echo $w;?></a>
                                    <?php

                                }
                                if( $page > 0 && $page<$totalpages ){
                                    $npage = $page + 1;
                                    $last = $page - 1;
                                    echo "<a type=\"submit\" style=\"color:white;background-color:#daa520 !important;\" class=\"btn btn-login \" href = \"$_PHP_SELF?itp=$itemsperpage&page=$npage\">Next</a>";
                                }
                                ?>
                            </div>
                        <?php }?>

                    </div>
              </section>


            </div> <!-- /col-md-6 -->



          </div>


        </div> <!-- / container-fluid -->
    <script type="text/javascript">

        function getState(city_id)
        {

            document.getElementById('maxdisplay').submit()
        }
    </script>
<?php
include('footer.php'); ?>