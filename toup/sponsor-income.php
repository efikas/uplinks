
<?php include('head.php');

if( isset($_POST['userN']) ) {
        $userN = trim($_POST['userN']);    
        
         $query= mysqli_query($dbc,"SELECT * FROM `user_table` WHERE `userName`='$userN'"); 
       $row = mysqli_fetch_array($query); 
       $ref_id =  $row['myid']; 
       $query= mysqli_query($dbc,"SELECT * FROM income_history WHERE receiver_id='$ref_id' AND `remark`='Payment for a new member you refered'"); 
       $row = mysqli_fetch_array($query);
    } ?>


        <!-- PAGE TITLE -->
        <section id="page-title" class="row">

          <div class="col-md-8 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">

            <!--<p><a href="#" target="_blank" class="btn btn-danger btn-sm">DataTables documentation</a></p>-->
          </div>

          <div class="col-md-4 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">

            <ol class="breadcrumb pull-right no-margin-bottom">


            </ol>

          </div>
        </section> <!-- / PAGE TITLE -->

        <div class="container-fluid">
          <div class="row">

            <div class="col-md-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">

              <section class="panel panel-primary">
                <header class="panel-heading">
                  <h4 class="panel-title">Referral Bonus Report</h4>
                </header>
                <div class="panel-body">

                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"><div class="dataTables_length" id="DataTables_Table_0_length"> <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"><label>Show <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class=""><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div><div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input name="userN" type="text"></input> </label></div></form>
                  <table class="table datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                    <thead>
                      <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 31px;" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 182px;" aria-label="Downline Name: activate to sort column ascending">Downline Name</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 178px;" aria-label="Downline Id: activate to sort column ascending">Downline Id</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 141px;" aria-label="Commission: activate to sort column ascending">Commission</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 174px;" aria-label="Remark: activate to sort column ascending">Remark</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 138px;" aria-label="Date: activate to sort column ascending">Date</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 79px;" aria-label="Status: activate to sort column ascending">Status</th></tr>
                    </thead>
                    
                             
                    <?php if( isset($_POST['userN']) ) { 
                        $i = 0;
                           $ref_id[$i] =  $row['ref_id'];   
                                $ref_name[$i]= $row['ref_name'];  
                                $Amount[$i]= $row['Amount'];
                                $Remark[$i]= $row['Remark']; 
                                $Date[$i]= $row['Date']; 
                                $Status[$i]= $row['Status']; 
                              
                              ?>
                    
                    <tbody>
                                   
                                <tr role="row" class="odd">
                                
                        <th scope="row" class="sorting_1"><?php echo $i;?></th>
                                
                                <td><?php echo $ref_name[$i];?></td>
                                <td><?php echo $ref_id[$i];?></td>
                                <td><?php echo $Amount[$i];?></td>
                                <td><?php echo $Remark[$i];?></td>                                
                                <td><?php echo $Date[$i];?></td> 
                                <td><?php echo $Status[$i];?></td>
                            </tr>
            
            
                      </tbody>
                     
                    <?php } else{ ?>
                    <tbody>
                          	          <?php
                            $me= $userRow['email'];
                            $query=mysqli_query($dbc,"SELECT * FROM income_history WHERE receiver_id='$myid' AND `remark`='Payment for a new member you refered'");
                            $i= 1;
                            while ($row = mysqli_fetch_array($query)) {
                                $ref_id[$i] =  $row['ref_id'];   
                                $ref_name[$i]= $row['ref_name'];  
                                $Amount[$i]= $row['Amount'];
                                $Remark[$i]= $row['Remark']; 
                                $Date[$i]= $row['Date']; 
                                $Status[$i]= $row['Status']; 
                              
                            ?>         
                                <tr role="row" class="odd">
                                
                        <th scope="row" class="sorting_1"><?php echo $i;?></th>
                                
                                <td><?php echo $ref_name[$i];?></td>
                                <td><?php echo $ref_id[$i];?></td>
                                <td><?php echo $Amount[$i];?></td>
                                <td><?php echo $Remark[$i];?></td>                                
                                <td><?php echo $Date[$i];?></td> 
                                <td><?php echo $Status[$i];?></td>
                            </tr>
            
                            <?php $i= $i+1; } ?>
                            <?php $i= 0; ?>
                   </tbody>
                   
                      <?php } ?>
                  </table>
                </div>


                </div>
              </section>
            

            </div> <!-- /col-md-6 -->

  

          </div>

      
        </div> <!-- / container-fluid -->


        

<?php include('footer.php'); ?>