<?php include('head.php'); ?>

<section id="page-title" class="row">

          <div class="col-md-8 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">
            <!--<h1>Downline Member Report</h1>-->
            <!--<p><a href="#" target="_blank" class="btn btn-danger btn-sm">DataTables documentation</a></p>-->
          </div>

          <div class="col-md-4 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">

            <ol class="breadcrumb pull-right no-margin-bottom">
              <!--<li><a href="#">Team Report</a></li>
              <li><a href="#">Total Downline Member Report</a></li>-->
             
            </ol>

          </div>
        </section>
        
        <div class="col-lg-12 center-block animateme scrollme" style="float: none; opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
                    
                </div>
                
                <div class="container-fluid">
          <div class="row">

            <div class="col-md-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">

              <section class="panel panel-primary">
                <header class="panel-heading">
                  <h4 class="panel-title">View Ticket Response</h4>
                </header>
                <div class="panel-body">

                  <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                  <table class="table datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                    <thead>
                      <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 49px;" aria-sort="ascending" aria-label="S.No: activate to sort column descending">S.No</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 99px;" aria-label="Ticket No.: activate to sort column ascending">Ticket No.</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 91px;" aria-label="Category: activate to sort column ascending">Category</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 75px;" aria-label="Subject: activate to sort column ascending">Subject</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 131px;" aria-label="Request Date: activate to sort column ascending">Message</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 65px;" aria-label="Status: activate to sort column ascending">Request Date</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 96px;" aria-label="Response: activate to sort column ascending">Image</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 96px;" aria-label="Response: activate to sort column ascending">Response</th></tr>
                    </thead>       	    <?php
                            $query=mysqli_query($dbc,"SELECT * FROM msg WHERE `email`='$emai'");
                            $i= 1;
                            while ($row = mysqli_fetch_array($query)) {
                                $paidto[$i] =  $row['email'];                               
                                $my_message[$i]= $row['mes']; 
                                $img[$i]= $row['img']; 
                                $mes_id[$i]= $row['id']; 
                                $date[$i]= $row['date']; 
                                $ticket[$i]= $row['date']; 
                                $reply[$i]= $row['reply']; 
                                $category[$i]= $row['category']; 
                                $subject[$i]= $row['subject']; 
                               
                            ?>
                            <tr>
                                
                                <td><?php echo $i;?></td>          
                                <td><?php echo $ticket[$i];?></td>
                                <td><?php echo $category[$i];?></td>
                                <td><?php echo $subject[$i];?></td>
                                <td><?php echo $my_message[$i];?></td>
                                <td><?php echo $date[$i];?></td>                                
                                <td> <img src="support/uploads/<?php echo $img[$i];?> "  height="180" width="242"></td>     
                                <td>
                                <?php if($reply[$i]==''){?>
                                
                            <?php } else{
                                echo $reply[$i];
                            } ?>
                                </td>
  
                            </tr>
            
                            <?php $i= $i+1; } ?>
                            <?php $i= 0; ?>
                      
                  </table></div>

                </div>

              </section>
            

            </div> <!-- /col-md-6 -->

  

          </div>

      
        </div>
<?php include('footer.php'); ?>