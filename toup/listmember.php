<?php include('head.php'); ?>
<?php
	if( isset($_POST['btn-delete']) ) {
        $email = trim($_POST['email']);    
         mysqli_query($dbc,"DELETE FROM `user_table` WHERE email='$email'");
       
    }if( isset($_POST['userN']) ) {
        $userN = trim($_POST['userN']);    
         $query= mysqli_query($dbc,"SELECT * FROM `user_table` WHERE `userName`='$userN'"); 
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
                  <h4 class="panel-title">List of all Members</h4>
                </header>
                <div class="panel-body">

                  
                  <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"><div class="dataTables_length" id="DataTables_Table_0_length"> <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"><label>Show <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class=""><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div><div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input name="userN" type="text"></input> </label></div></form>
                  <table class="table datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                    <thead>
                      <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 30px;" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 175px;" aria-label="User Id: activate to sort column ascending">User Id</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 125px;" aria-label="UserName: activate to sort column ascending">UserName</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 130px;" aria-label="Full Name: activate to sort column ascending">Full Name</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 134px;" aria-label="Status: activate to sort column ascending">Status</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 175px;" aria-label="Contact No.: activate to sort column ascending">Contact No.</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 155px;" aria-label="Register Date: activate to sort column ascending">Register Date</th><th>Action</th></tr>
                    </thead>
                    
                    <?php if( isset($_POST['userN']) ) { 
                        $i = 0;
                           $ref_userid[$i] =  $row['myid']; 
                                $ref_email[$i] =  $row['email']; 
                                $ref_userName[$i] =  $row['userName'];                               
                                $ref_firstName[$i]= $row['firstName']; 
                                $ref_lastName[$i]= $row['lastName']; 
                                $ref_phoneNo[$i]= $row['phoneNo'];  
                                $ref_status[$i]= $row['status']; 
                                $Date[$i]= $row['added']; 
                              
                              ?>
                    
                    <tbody>
                           
                                <tr role="row" class="odd">
                                
                        <th scope="row" class="sorting_1"><?php echo $i;?></th>
                                
                                <td><?php echo $ref_userid[$i];?></td>
                                <td><?php echo $ref_userName[$i];?></td>
                                <td><?php echo $ref_firstName[$i].' '.$ref_lastName;?></td>                      
                                <td><?php echo $ref_status[$i];?></td> 
                                <td><?php echo $ref_phoneNo[$i];?></td>
                                <td><?php echo $Date[$i];?></td>
                                  <td>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                                <div class="form-group">
                                <input type="hidden" name="email" value="<?php echo $ref_email[$i]; ?>" />
                                <button type="submit" class="btn btn-block btn-primary" name="btn-delete">Delete</button>
                                </div>
                                
                            </form>
                                </td>
    
                            </tr>
            
                      </tbody>
                     
                    <?php } else{ ?>
                    <tbody>
                     
                     
            	          <?php
                            $me= $userRow['email'];
                            $query=mysqli_query($dbc,"SELECT * FROM `user_table` ");
                            $i= 1;
                            while ($row = mysqli_fetch_array($query)) {
                                $ref_userid[$i] =  $row['myid']; 
                                $ref_email[$i] =  $row['email']; 
                                $ref_userName[$i] =  $row['userName'];                               
                                $ref_firstName[$i]= $row['firstName']; 
                                $ref_lastName[$i]= $row['lastName']; 
                                $ref_phoneNo[$i]= $row['phoneNo'];  
                                $ref_status[$i]= $row['status']; 
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
                                  <td>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                                <div class="form-group">
                                <input type="hidden" name="email" value="<?php echo $ref_email[$i]; ?>" />
                                <button type="submit" class="btn btn-block btn-primary" name="btn-delete">Delete</button>
                                </div>
                                
                            </form>
                                </td>
    
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

      
        </div>

<?php include('footer.php'); ?>