<?php include('head.php'); ?>

<section id="page-title" class="row">

          <div class="col-md-8 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">
            <!--<h1>My Withdrawal Request</h1>-->
            <!--<p><a href="#" target="_blank" class="btn btn-danger btn-sm">DataTables documentation</a></p>-->
          </div>

          <div class="col-md-4 animateme scrollme" style="float: right; opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">

             <a target="_self" href="withdraw-request.php"><input name="update" value="New Request Click Here" class="btn btn-primary" type="submit"></a>   

          </div>
        </section>
        
        <div class="container-fluid">
          <div class="row">

            <div class="col-md-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">

              <section class="panel panel-primary">
                <header class="panel-heading">
                  <h4 class="panel-title">Withdrawal Request</h4>
                </header>
                <div class="panel-body">

                  <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                  <table class="table datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                    <thead>
                      <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 33px;" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 252px;" aria-label="Requested Amount: activate to sort column ascending">Requested Amount</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 187px;" aria-label="Admin Charge: activate to sort column ascending">Admin Charge</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 178px;" aria-label="Request date : activate to sort column ascending">Request date </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 199px;" aria-label="Payment Mode : activate to sort column ascending">Payment Mode </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 92px;" aria-label="Status: activate to sort column ascending">Status</th></tr>
                    </thead>
                    <tbody>
                     
                                          
                    <tr class="odd"><td colspan="6" class="dataTables_empty" valign="top">No data available in table</td></tr></tbody>
                  </table></div>


                </div>
              </section>
            

            </div> <!-- /col-md-6 -->

  

          </div>

      
        </div>
<?php include('footer.php'); ?>