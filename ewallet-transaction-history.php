
<?php include('head.php'); ?>
<?php
if (isset($_POST['userN'])) {
    $userN = trim($_POST['userN']);

    $query= mysqli_query($dbc,"SELECT * FROM `user_table` WHERE `userName`='$userN'");
    $row = mysqli_fetch_array($query);
    $ref_id =  $row['myid'];
    $query= mysqli_query($dbc,"SELECT * FROM wallet_history WHERE receiver_id='$ref_id' OR sender_id='$ref_id' order by id desc");
    
    $row = mysqli_fetch_all($query);
    $total = mysqli_num_rows($query);
    echo 'a';

} elseif ($_POST['from'] != '' && $_POST['to'] != '' ) {
    $from = date('Y-m-d H:i:s', strtotime(trim($_POST['from'])));
    // $from = $from->format('Y-m-d H:i:s');
    $to = date('Y-m-d H:i:s', strtotime(trim($_POST['to'])));
    // $to = $to->format('Y-m-d H:i:s');
    $from = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $from)));
    $to = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $to)));
    //$query= mysqli_query($dbc,"SELECT * FROM wallet_history WHERE receiver_id='$ref_id' OR sender_id='$ref_id' OR receiver_id='$ref_id' OR sender_id='$ref_id' order by id desc");
    $query = mysqli_query($dbc, "SELECT * FROM wallet_history WHERE receiver_id='$myid' OR sender_id='$myid' AND Date between '$from' AND '$to' order by date desc");
    $row = mysqli_fetch_all($query);
    $total = mysqli_num_rows($query);
    echo 'b';
} else {

    if(isset($_GET['page'])){
        if(is_numeric($_GET['page'])){
            $page=max(intval($_GET['page']),1); // assuming there is a parameter 'page'
        }else{
            $page = 1;
        }
    }else{
        $page = 1;
    }
    $query=mysqli_query($dbc,"SELECT * FROM wallet_history WHERE receiver_id='$myid' OR sender_id='$myid' order by date desc");
    $pagerow = mysqli_fetch_array($query);
    $total = mysqli_num_rows($query);
   

}


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
                    <div class="dataTables_length" id="DataTables_Table_0_length"> 
                    <form id="maxdisplay" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                    <label>Show 
                    <select  id="itemsperpage" onchange="getState(this.value)"  name="itemsperpage" aria-controls="DataTables_Table_0" class="">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select> entries</label></div> </form>
                    <form id="search" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"> 
                    <div id="DataTables_Table_0_filter" class="dataTables_filter">
                    <label>Search:<input name="userN" type="text"></input> 
                    </label></div></form>
                    <form id="datesearch" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"> 
                    <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                    <br/>
                    <div class="input-group input-daterange">
                        <div class="input-group-addon">from</div>
                        <input type="text" class="form-control" name="from" id="fromperiod" value="<?=$_POST['from'] ?>">
                        <div class="input-group-addon">to</div>
                        <input type="text" id="toperiod" name="to" class="form-control" value="<?=$_POST['to'] ?>">
                    </div>
                     <br/>
                    </div>
                    </div>
                    </form>
                  <table class="table datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                    <thead>
                      <tr role="row"><th >#</th><th >Sender Name</th><th>Receiver Name</th><th>Credit</th><th>Debit</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 456px;" aria-label="Remark: activate to sort column ascending">Remark</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 78px;" aria-label="Date: activate to sort column ascending">Date</th><th>Status</th></tr>
                    </thead>

                            <?php if(isset($_POST['userN']) || ( $_POST['from'] != '' && $_POST['to'] != '' ) ) {
                               
                                ?>

                                <tbody>

                        <?php if ($total < 1 ) { ?>
                            <tr class="odd"><td colspan="7" class="dataTables_empty" valign="top">No matching records found</td></tr>

                        <?php } else{
                                $i = 0;
                                while ($i < $total) {
                            ?>
                                
                                <tr role="row" class="odd">

                                    <th scope="row" class="sorting_1"><?php echo ($i + 1 );?></th>
                                    <td><?php echo $row[$i][3];?></td>
                                    <td><?php echo $row[$i][4];?></td>                                
                                    <td><?php echo $row[$i][5];?></td> 
                                    <td><?php echo $row[$i][6];?></td>
                                    <td><?php echo $row[$i][7];?></td>
                                    <td><?php echo $row[$i][8];?></td>                                
                                    <td><?php echo $row[$i][9];?></td> 
                                    </tr>

                        <?php $i= $i+1; 
                            } 
                         } ?>
                                </tbody>

                            <?php } else{ ?>
                    <tbody>
                     
            	          <?php
                            $me= $userRow['email'];
                            $query=mysqli_query($dbc,"SELECT * FROM wallet_history WHERE receiver_id='$myid' OR sender_id='$myid' order by date desc LIMIT ".(($page-1)*$itemsperpage).','.$itemsperpage."  ");
                            
                            $i= 1;
                          $start_count = ($page-1)*$itemsperpage;
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
                                $start_count++;
                              // if ($i == 10){continue;}
                            ?>         
                                <tr role="row" class="odd">
                                
                        <th scope="row" class="sorting_1"><?php echo $start_count;?></th>
                                
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

    <link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" rel="stylesheet"/>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<table>
<script type="text/javascript">
    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };

    //check if user transaction history
    var getHistory = debounce(function() {
        let from = $('#fromperiod').val();
        let to = $('#toperiod').val();
        if(from != '' && to != ''){
            $.post("includes/transaction_search.php", { from: from, to: to }, function(data){
            alert(data)

            });
        }
    }, 500);

    $("#fromperiod").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function(selectedDate) {
                
            //   $("#toperiod").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#toperiod").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function(selectedDate) {
            //   $("#fromperiod").datepicker("option", "maxDate", selectedDate);
                //update search table
                document.getElementById("datesearch").submit()
            }
        });

    function getState(city_id)
    {
        

        document.getElementById('maxdisplay').submit()
    }
</script>
<?php
include('footer.php'); ?>