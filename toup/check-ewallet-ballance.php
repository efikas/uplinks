<?php include('head.php'); ?>
        <!-- PAGE TITLE -->
<section id="page-title" class="row">

          <div class="col-md-8 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
            <h1>E-WALLET Ballance</h1>
            <p></p><div style="color:#900;font-weight:bold;" align="center"></div><p></p>
          </div>

             
             
          <div class="col-md-4 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">

            <ol class="breadcrumb pull-right no-margin-bottom">
              <li><a href="#">E-WALLET Ballance</a></li>
              <li><a href="#">E-WALLET Ballance</a></li>
            </ol>

          </div>
        </section> <!-- / PAGE TITLE -->
<div class="container-fluid">
          <div class="row">
       
            <div class="col-md-6 animateme scrollme" style="float:none; margin-left:auto; margin-right:auto;" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">

           <form name="bankinfo" method="post">
              <section class="panel">

               <?php
               $query=mysqli_query($dbc,"SELECT * FROM user_rank WHERE myid='$myid'");
               $row = mysqli_fetch_array($query);
               $balance =  $row['balance'];    
               ?>
                <header class="panel-heading">
                 <br> <h3 class="panel-title">Ballance in your E-WALLET  :  <strong><?php echo $balance; ?>&nbsp;USD</strong></h3>
                <br></header>
                <div class="panel-body">


              </div></section>

</form>

            </div> <!-- / col-md-6 -->

          

          </div> <!-- / row -->

         

        </div>


<?php include('footer.php'); ?>