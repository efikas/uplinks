<?php include('head.php'); ?>
<?php

    if( isset($_POST['send']) ) {
        
    $mes_id = trim($_POST['id']);
    $mes_reply = trim($_POST['reply']);    
    
    mysqli_query($dbc, "UPDATE `msg` SET `reply`='$mes_reply' WHERE id='$mes_id'");
        
        }
        
    if( isset($_POST['btn-paid']) ) {
    $ema = trim($_POST['email']);    
    mysqli_query($dbc, "DELETE FROM pending WHERE email='$ema'");
    mysqli_query($dbc, "INSERT INTO paid(userName,firstName,lastName,phoneNo,accName,accNo,email,bankName,package) SELECT userName,firstName,lastName,phoneNo,accName,accNo,email,bankName,package FROM user_table WHERE email='$ema'");
        unset($email);  
    
    }

	if( isset($_POST['btn-delete']) ) {
        $email = trim($_POST['email']);    
        mysql_query("DELETE pending WHERE email='$email'"); 
        mysql_query("DELETE user_table WHERE email='$email'"); 
        unset($email);  
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
                  <h4 class="panel-title">Support Messages From Members</h4>
                </header>
                <div class="panel-body">

                  
                  <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"><div class="dataTables_length" id="DataTables_Table_0_length"><label>Show <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class=""><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div><div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input class="" placeholder="" aria-controls="DataTables_Table_0" type="search"></label></div>
                  <table class="table datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                    <thead>
                      <tr><th>S.No</th><th>From</th><th>Message</th><th>Image</th><th><div class='noPrint'>action</div></th><th>Reply</th></tr>
                    </thead>
                    <tbody>
                     
                     
            	    <?php
                            $query=mysqli_query($dbc,"SELECT * FROM msg");
                            $i= 1;
                            while ($row = mysqli_fetch_array($query)) {
                                $paidto[$i] =  $row['email'];                               
                                $user1[$i]= $row['mes']; 
                                $img[$i]= $row['img']; 
                                $mes_id[$i]= $row['id']; 
                                $date[$i]= $row['date']; 
                                $reply[$i]= $row['reply']; 
                               
                            ?>
                            <tr>
                                
                                <td><?php echo $i;?></td>
                                <td><?php echo $paidto[$i];?></td>
                                <td><?php echo $user1[$i];?></td>
                                <td> <img src="support/uploads/<?php echo $img[$i];?> "  height="180" width="242"></td>
                                <td>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                                <div class="form-group">
                                <?php $email[$i] =  $row['email']; ?>  
                                <input type="hidden" name="email" value="<?php echo $email[$i]; ?>" />
                                <button type="submit" class="btn btn-block btn-primary" name="btn-paid">Mark as Paid</button>
                                </div>
                                
                            </form>
                                </td>
                                <td>
                                <?php if($reply[$i]==''){?>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                            	<textarea name="reply" style="width:100%; border:1px solid #ebebeb; padding:5px;" class="form-control" id="exampleInputAddress" cols="50" rows="5" tabindex="5"></textarea>
                                        <input hidden="hidden" name="id"  value="<?php echo $mes_id[$i]; ?>" />
                                        <br>
										<button type="send" name="send" class="btn btn-primary">Submit</button>
                            </form>
                            <?php } else{
                                echo $reply[$i];
                            } ?>
                                </td>
  
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