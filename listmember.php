<?php include('head.php'); ?>
<?php
//set super user
$userType = $_SESSION['user-power'] || 2;
if( isset($_POST['btn-delete']) ) {
    $email = trim($_POST['email']);
    mysqli_query($dbc,"UPDATE `user_table` SET `block`='Yes' WHERE email='$email'");

}if( isset($_POST['btn-undelete']) ) {
    $email = trim($_POST['email']);
    mysqli_query($dbc,"UPDATE `user_table` SET `block`='No' WHERE email='$email'");

}if( isset($_POST['userN']) ) {
        $userN = trim($_POST['userN']);    
        $query= mysqli_query($dbc,"SELECT * FROM `user_table` WHERE `userName`='$userN'"); 
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
$query=mysqli_query($dbc,"SELECT * FROM `user_table`");
$pagerow = mysqli_fetch_array($query);
$total = mysqli_num_rows($query);
$itemsperpage = 10;

if(isset($_POST['itemsperpage'])){

    $itemsperpage = $_POST['itemsperpage'];
}
if(isset($_GET['itp'])){

    $itemsperpage = $_GET['itp'];
}
//$total=100; // total results if you know it already otherwise use another query
$totalpages = max(ceil($total/$itemsperpage),1);
?>
<style>
     .sulogin:hover {
        color: #da8332 !important;
    }
</style>
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


                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"><div class="dataTables_length" id="DataTables_Table_0_length"> <form id="maxdisplay" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"><label>Show <select  id="itemsperpage" onchange="getState(this.value)"  name="itemsperpage" aria-controls="DataTables_Table_0" class=""><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div> </form> <form id="search" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"> <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input name="userN" type="text"></input> </label></div></form>
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
                          <?php if(count($row) < 1){ ?>
                              <tr class="odd"><td colspan="7" class="dataTables_empty" valign="top">No matching records found</td></tr>

                            <?php } else{?>
                            <tr role="row" class="odd">
                                
                        <th scope="row" class="sorting_1"><?php echo $i;?></th>
                                
                                <td><?php echo $ref_userid[$i];?></td>
                                <td><?php echo $ref_userName[$i];?></td>
                                <td><?php echo $ref_firstName[$i].' '.$ref_lastName[$i];?></td>                      
                                <td><?php echo $ref_status[$i];?></td> 
                                <td><?php echo $ref_phoneNo[$i];?></td>
                                <td><?php echo $Date[$i];?></td>
                                    <?php if($block[$i] =="No"){ ?>
                                        <td>
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                                                <div class="form-group">
                                                    <input type="hidden" name="email" value="<?php echo $ref_email[$i]; ?>" />
                                                    <button  style="color:white;background-color:#daa520 !important;" type="submit" class="btn btn-block btn-primary" name="btn-delete">Suspend</button>
                                                </div>

                                            </form>
                                        </td>
                                    <?php } else{?>

                                        <td>
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                                                <div class="form-group">
                                                    <input type="hidden" name="email" value="<?php echo $ref_email[$i]; ?>" />
                                                    <button  style="color:white;background-color:#daa520 !important;" type="submit" class="btn btn-block btn-primary" name="btn-undelete">Un-Suspend</button>
                                                </div>

                                            </form>
                                        </td>


                                    <?php }?>
    
                            </tr>
            <?php }?>
                      </tbody>
                     
                    <?php } else{ ?>
                    <tbody>
                     
                     
            	          <?php
                            $me= $userRow['email'];
                            $query=mysqli_query($dbc,"SELECT * FROM `user_table` LIMIT ".(($page-1)*$itemsperpage).','.$itemsperpage);
                            $i= 1;
                          $start_count = ($page-1)*$itemsperpage;
                            while ($row = mysqli_fetch_array($query)) {
                                $ref_userid[$i] =  $row['myid']; 
                                $ref_email[$i] =  $row['email']; 
                                $ref_userName[$i] =  $row['userName'];                               
                                $ref_firstName[$i]= $row['firstName']; 
                                $ref_lastName[$i]= $row['lastName']; 
                                $ref_phoneNo[$i]= $row['phoneNo'];  
                                $ref_status[$i]= $row['status'];
                                $Date[$i]= $row['added'];
                                $block[$i]= $row['block'];
                                $start_count++;
                              
                            ?>         
                                <tr role="row" class="odd">
                                
                        <th scope="row" class="sorting_1"><?php echo $start_count;?></th>
                                
                                <td><?php echo $ref_userid[$i];?></td>
                                <?php if($userType == 1) {  ?>
                                    <td><a class="sulogin" href="sulogin.php?user=<?=$ref_userName[$i] ?>"><?php echo $ref_userName[$i];?></a></td>
                                <?php } else { ?>
                                    <td><?php echo $ref_userName[$i];?></td>
                                <?php } ?>

                                <td><?php echo $ref_firstName[$i].' '.$ref_lastName[$i];?></td>                      
                                <td><?php echo $ref_status[$i];?></td> 
                                <td><?php echo $ref_phoneNo[$i];?></td>
                                <td><?php echo $Date[$i];?></td>
                                    <?php if($block[$i] =="No"){ ?>
                                  <td>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                                <div class="form-group">
                                <input type="hidden" name="email" value="<?php echo $ref_email[$i]; ?>" />
                                <button  style="color:white;background-color:#daa520 !important;" type="submit" class="btn btn-block btn-primary" name="btn-delete">Suspend</button>
                                </div>
                                
                            </form>
                                </td>
                                <?php } else{?>

                                        <td>
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                                                <div class="form-group">
                                                    <input type="hidden" name="email" value="<?php echo $ref_email[$i]; ?>" />
                                                    <button  style="color:white;background-color:#daa520 !important;" type="submit" class="btn btn-block btn-primary" name="btn-undelete">Un-Suspend</button>
                                                </div>

                                            </form>
                                        </td>


                                    <?php }?>
    
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