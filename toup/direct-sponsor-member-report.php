<?php include('head.php'); ?>
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
                  <h4 class="panel-title">Referral Member</h4>
                </header>
                <div class="panel-body">

                  
                  <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                  <table class="table datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                    <thead>
                      <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 30px;" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 175px;" aria-label="User Id: activate to sort column ascending">User Id</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 125px;" aria-label="UserName: activate to sort column ascending">UserName</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 130px;" aria-label="Full Name: activate to sort column ascending">Full Name</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 134px;" aria-label="Stage: activate to sort column ascending">Stage</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 175px;" aria-label="Contact No.: activate to sort column ascending">Contact No.</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 155px;" aria-label="Register Date: activate to sort column ascending">Register Date</th></tr>
                    </thead>
                    <tbody>
                     
                     
            	          <?php
                            $me= $userRow['email'];
                            $query=mysqli_query($dbc,"SELECT * FROM `user_table` WHERE superior_id='$myid'");
                            $i= 1;
                            while ($row = mysqli_fetch_array($query)) {
                                $ref_userid[$i] =  $row['myid']; 
                                $ref_userName[$i] =  $row['userName'];                               
                                $ref_firstName[$i]= $row['firstName']; 
                                $ref_lastName[$i]= $row['lastName']; 
                                $ref_phoneNo[$i]= $row['phoneNo'];  
                                $ref_status[$i]= get_stage($row['myid']);
                                $Date[$i]= $row['added']; 
                              
                            ?>         
                                <tr role="row" class="odd">
                                
                        <th scope="row" class="sorting_1"><?php echo $i;?></th>
                                
                                <td><?php echo $ref_userid[$i];?></td>
                                <td><?php echo $ref_userName[$i];?></td>
                                <td><?php echo $ref_firstName[$i].' '.$ref_lastName;?></td>                      
                                <td><?php echo $ref_status[$i];?></td> 
                                <td><?php echo $ref_phoneNo[$i];?></td>
                                <td><?php echo $Date[$i];?></td>   
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

      
        </div>

<?php include('footer.php'); ?>