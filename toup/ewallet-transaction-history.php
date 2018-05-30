
<?php include('head.php'); ?>
        <!-- PAGE TITLE -->
        <section id="page-title" class="row">

          <div class="col-md-8 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">
            <!--<h1>Ewallet Transaction History</h1>-->
            <!--<p><a href="#" target="_blank" class="btn btn-danger btn-sm">DataTables documentation</a></p>-->
          </div>

          <div class="col-md-4 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">

            <ol class="breadcrumb pull-right no-margin-bottom">
              <!--<li><a href="#">Ewallet</a></li>
              <li><a href="#">Ewallet Transaction History</a></li>-->
             
            </ol>

          </div>
        </section> <!-- / PAGE TITLE -->

        <div class="container-fluid">
          <div class="row">

            <div class="col-md-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">

              <section class="panel panel-primary">
                <header class="panel-heading">
                  <h4 class="panel-title">E-WALLET Transaction History</h4>
                </header>
                <div class="panel-body">

                  <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                  <table class="table datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                    <thead>
                      <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 21px;" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 119px;" aria-label="Sender Name: activate to sort column ascending">Sender Name</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 98px;" aria-label="Receiver Name: activate to sort column ascending">Receiver Name</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 41px;" aria-label="Credit: activate to sort column ascending">Credit</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 37px;" aria-label="Debit: activate to sort column ascending">Debit</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 456px;" aria-label="Remark: activate to sort column ascending">Remark</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 78px;" aria-label="Date: activate to sort column ascending">Date</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 42px;" aria-label="Status: activate to sort column ascending">Status</th></tr>
                    </thead>
                    <tbody>
                     
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
                                <tr role="row" class="odd">
                                
                        <th scope="row" class="sorting_1"><?php echo $i;?></th>
                                
                                <td><?php echo $sender_id[$i];?></td>
                                <td><?php echo $receiver_id[$i];?></td>
                                <td><?php echo $sender_name[$i];?></td>
                                <td><?php echo $receiver_name[$i];?></td>                                
                                <td><?php echo $Credit[$i];?></td> 
                                <td><?php echo $Debit[$i];?></td>
                                <td><?php echo $Remark[$i];?></td>
                                <td><?php echo $Date[$i];?></td>                                
                                <td><?php echo $Status[$i];?></td> 
                            </tr>
            
                            <?php $i= $i+1; } ?>
                            <?php $i= 0; ?>
                   
                      
                      </tbody>
                  </table>


                </div>


                </div>
              </section>
            

            </div> <!-- /col-md-6 -->

  

          </div>

      
        </div> <!-- / container-fluid -->

<?php include('footer.php'); ?>