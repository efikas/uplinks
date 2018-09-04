<?php include('head.php');


if( isset($_POST['userN']) ) {
    $userN = trim($_POST['userN']);

    $query= mysqli_query($dbc,"SELECT * FROM `user_table` WHERE `userName`='$userN'");
    $row = mysqli_fetch_array($query);
    $ref_id =  $row['myid'];
    $query= mysqli_query($dbc,"SELECT * FROM msg WHERE `email`='$ref_id'");
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
$query=mysqli_query($dbc,"SELECT * FROM msg WHERE `email`='$emai'");
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

                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"><div class="dataTables_length" id="DataTables_Table_0_length"> <form id="maxdisplay" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"><label>Show <select  id="itemsperpage" onchange="getState(this.value)"  name="itemsperpage" aria-controls="DataTables_Table_0" class=""><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div> </form> <form id="search" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"> <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input name="userN" type="text"></input> </label></div></form>
                  <table class="table datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                    <thead>
                      <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 49px;" aria-sort="ascending" aria-label="S.No: activate to sort column descending">S.No</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 99px;" aria-label="Ticket No.: activate to sort column ascending">Ticket No.</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 91px;" aria-label="Category: activate to sort column ascending">Category</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 75px;" aria-label="Subject: activate to sort column ascending">Subject</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 131px;" aria-label="Request Date: activate to sort column ascending">Message</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 65px;" aria-label="Status: activate to sort column ascending">Request Date</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 96px;" aria-label="Response: activate to sort column ascending">Image</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 96px;" aria-label="Response: activate to sort column ascending">Response</th></tr>
                    </thead>

                    <?php if( isset($_POST['userN']) ) {
                        $i = 0;
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

                    <tbody>

                        <?php if(count($row) < 1){ ?>
                            <tr class="odd"><td colspan="7" class="dataTables_empty" valign="top">No matching records found</td></tr>

                        <?php } else{?>
                                <tr role="row" class="odd">

                        <th scope="row" class="sorting_1"><?php echo $i;?></th>


                                    <td><?php echo $start_count;?></td>
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

                        <?php } ?>

                      </tbody>

                    <?php } else{ ?>
                    <tbody>

                      <?php
                            $query=mysqli_query($dbc,"SELECT * FROM msg WHERE `email`='$emai'  LIMIT ".(($page-1)*$itemsperpage).','.$itemsperpage);
                            $i= 1;
                            $start_count = ($page-1)*$itemsperpage;
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
                                $start_count++;
                               
                            ?>
                            <tr>
                                
                                <td><?php echo $start_count;?></td>
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