<?php include('head.php'); ?>
<?php
	if( isset($_POST['btn-paid']) ) {
        $user_id = trim($_POST['user_id']); 
        $amount = trim($_POST['amount']);  
        $fund_id = trim($_POST['fund_id']);    
    mysqli_query($dbc, "UPDATE `add_fund_request` SET `status`= 'paid' WHERE `id`='$fund_id'");
      
    

$query = "SELECT * FROM `user_rank` WHERE `myid` = '$user_id'";
$res = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($res);

$bal = $row[balance];  
$newbalance = $bal + $amount;

 mysqli_query($dbc, "UPDATE `user_rank` SET `balance`=$newbalance WHERE `myid`='$user_id'");
      
    }
if( isset($_POST['userN']) ) {
    $userN = trim($_POST['userN']);

    $query = "SELECT * FROM `user_table` WHERE `userName` = '$userN'";
    $res = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($res);
    $userN = $row['myid'];
    $query= mysqli_query($dbc,"SELECT * FROM `add_fund_request` WHERE `user_id`='$userN'");
    $row = mysqli_fetch_array($query);
}

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
                  <h4 class="panel-title">View Members to Fund</h4>
                </header>
                <div class="panel-body">


                      <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"><div class="dataTables_length" id="DataTables_Table_0_length"> <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"><label>Show <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class=""><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div><div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input name="userN" type="text"></input> </label></div></form>
                    <table class="table datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                          <thead>
                      <tr><th >S/No.</th> <th >User Id</th>  <th >Amount in Dollar</th>   <th >Amount in Naira</th> <th >Date Raised</th> <th >Status/Action</th></tr>
                    </thead>

                    <?php if( isset($_POST['userN']) ) {
                        $i =0;

                        $query= mysqli_query($dbc,"SELECT * FROM `add_fund_request` WHERE `user_id`='$userN'");
                        while ($row = mysqli_fetch_array($query)) {
                        $ref_email[$i] =  $row['email'];
                        $fund_id[$i] =  $row['id'];
                        $ref_amount_in_n[$i] =  $row['amount_in_n'];
                        $ref_amount_in_d[$i]= $row['amount_in_d'];
                        $ref_user_id[$i]= $row['user_id'];
                        $ref_date[$i]= $row['date'];
                        $ref_status[$i]= $row['status'];


                        ?>

                          <tbody>

                          <tr role="row" class="odd">

                              <th scope="row" class="sorting_1"><?php echo $i;?></th>

                              <td><?php echo $ref_user_id[$i];?></td>
                              <td><?php echo $ref_amount_in_d[$i];?></td>
                              <td><?php echo $ref_amount_in_n[$i];?></td>
                              <td><?php echo $ref_date[$i];?></td>
                              <td>
                                  <?php $email[$i] =  $row['email'];  if($ref_status[$i]=="Not Paid"){?>

                                      <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                                          <div class="form-group">
                                              <input type="hidden" name="user_id" value="<?php echo $ref_user_id[$i]; ?>" />
                                              <input type="hidden" name="amount" value="<?php echo $ref_amount_in_d[$i]; ?>" />
                                              <input type="hidden" name="fund_id" value="<?php echo $fund_id[$i]; ?>" />
                                              <button type="submit" class="btn btn-block btn-primary" name="btn-paid">Paid</button>
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

                          <?php
                    } else{
                    ?>


                    <tbody>
                     
                     
            	          <?php
                            $me= $userRow['email'];
                            $query=mysqli_query($dbc,"SELECT * FROM `add_fund_request` ");
                            $i= 1;
                            while ($row = mysqli_fetch_array($query)) {
                                $ref_email[$i] =  $row['email']; 
                                $fund_id[$i] =  $row['id']; 
                                $ref_amount_in_n[$i] =  $row['amount_in_n'];                               
                                $ref_amount_in_d[$i]= $row['amount_in_d']; 
                                $ref_user_id[$i]= $row['user_id']; 
                                $ref_date[$i]= $row['date'];  
                                $ref_status[$i]= $row['status'];
                              
                            ?>         
                                <tr role="row" class="odd">
                                
                        <th scope="row" class="sorting_1"><?php echo $i;?></th>
                                
                                <td><?php echo $ref_user_id[$i];?></td>
                                <td><?php echo $ref_amount_in_d[$i];?></td>                      
                                <td><?php echo $ref_amount_in_n[$i];?></td> 
                                <td><?php echo $ref_date[$i];?></td>
                                       <td>
                                <?php $email[$i] =  $row['email'];  if($ref_status[$i]=="Not Paid"){?>  
                                
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                                <div class="form-group">
                                <input type="hidden" name="user_id" value="<?php echo $ref_user_id[$i]; ?>" />
                                <input type="hidden" name="amount" value="<?php echo $ref_amount_in_d[$i]; ?>" />
                                <input type="hidden" name="fund_id" value="<?php echo $fund_id[$i]; ?>" />
                                <button type="submit" class="btn btn-block btn-primary" name="btn-paid">Paid</button>
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

                    <?php } ?>          </table>


                </div>


                </div>
              </section>
            

            </div> <!-- /col-md-6 -->

  

          </div>

      
        </div>

<?php include('footer.php'); ?>