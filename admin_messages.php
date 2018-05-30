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
if( isset($_POST['userN']) ) {
    $userN = trim($_POST['userN']);

    $query = "SELECT * FROM `user_table` WHERE `userName` = '$userN'";
    $res = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($res);
    $userN = $row['email'];
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
$query=mysqli_query($dbc,"SELECT * FROM msg");
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
                  <h4 class="panel-title">Support Messages From Members</h4>
                </header>
                <div class="panel-body">


                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"><div class="dataTables_length" id="DataTables_Table_0_length"> <form id="maxdisplay" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"><label>Show <select  id="itemsperpage" onchange="getState(this.value)"  name="itemsperpage" aria-controls="DataTables_Table_0" class=""><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div> </form> <form id="search" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"> <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input name="userN" type="text"></input> </label></div></form>
                  <table class="table datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                    <thead>
                      <tr><th>S.No</th><th>Category</th><th>From</th><th>Message</th><th>Image</th><th><div class='noPrint'>action</div></th><th>Reply</th></tr>
                    </thead>

<?php if( isset($_POST['userN']) ) {
    $i = 0;

    $query= mysqli_query($dbc,"SELECT * FROM `msg` WHERE `email`='$userN'");
    $srow =  mysqli_fetch_array($query);
    ?>

    <?php if(count($srow) < 1) { ?>
        <tr class="odd"><td colspan="7" class="dataTables_empty" valign="top">No matching records found</td></tr>

    <?php } ?>
    <?php
    while ($row = mysqli_fetch_array($query)) {
        $paidto[$i] =  $row['email'];
        $user1[$i]= $row['mes'];

        $category[$i] =  $row['category'];
        $img[$i]= $row['img'];
        $mes_id[$i]= $row['id'];
        $date[$i]= $row['date'];
        $reply[$i]= $row['reply'];
        ?>
        <tr>

            <td><?php echo $i;?></td>

            <td><?php echo $category[$i];?></td>
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
                        <button  style="color:white;background-color:#daa520 !important;" type="send" name="send" class="btn btn-primary">Submit</button>
                    </form>
                <?php } else{
                    echo $reply[$i];
                } ?>
            </td>

        </tr>

        <?php $i= $i+1; } ?>
    <?php $i= 0; ?>

    </tbody>
    <?php }else{ ?>

                    <tbody>
                     
                     
            	    <?php
                            $query=mysqli_query($dbc,"SELECT * FROM msg LIMIT ".(($page-1)*$itemsperpage).','.$itemsperpage);
                            $i= 1;
                            $start_count = ($page-1)*$itemsperpage;
                            while ($row = mysqli_fetch_array($query)) {
                                $paidto[$i] =  $row['email'];                               
                                $user1[$i]= $row['mes']; 
                                   
                                $category[$i] =  $row['category']; 
                                $img[$i]= $row['img']; 
                                $mes_id[$i]= $row['id']; 
                                $date[$i]= $row['date']; 
                                $reply[$i]= $row['reply'];
                                $start_count++;
                               
                            ?>
                            <tr>

                                <td><?php echo $start_count;?></td>
                                
                                <td><?php echo $category[$i];?></td>
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
										<button  style="color:white;background-color:#daa520 !important;" type="send" name="send" class="btn btn-primary">Submit</button>
                            </form>
                            <?php } else{
                                echo $reply[$i];
                            } ?>
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