<?php include('head.php'); ?>

<section id="page-title" class="row">

          <div class="col-md-8 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">
           <h1>My Referral Tree</h1>
          </div>

          <div class="col-md-4 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">

            <ol class="breadcrumb pull-right no-margin-bottom">
                        <!--<li><a href="#">Genealogy</a></li>
              <li class="active">Direct Sponsors</li>-->
            </ol>

          </div>
        </section>
        <div class="container-fluid white-bg">

          <div class="row">

			<div class="col-md-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">

            
            
         
				
				<div class="col-md-3 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">
				<!--<form name="tree" method="post" action="direct-member-tree.php">
  <input type="text" name="id" style="width:150px;" value="" paceholder="Enter Userid">&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="submit" name="submit" value="Search"><br/>
 <input type="button" value="Back" name="backs"> </a> 
</form><br />-->

				</div>

				
					<div class="clearfix"></div>
		   
            
            	<div class="col-md-10 center-block animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">
				
                    
                        <div class="table-responsive">
                        
                        	<div class="content">

							 							
							</div>
                        
                        </div>
                        
                    </div>
            
            
            
            
            
            <?php 
            /**
            $datas = array(
    array('id' => $desc1, 'parent' => $emai, 'name' => $desc1),
    array('id' => $desc2, 'parent' => $emai, 'name' => $desc2),
    array('id' => $desc3, 'parent' => $desc1, 'name' => $desc3),
    array('id' => $desc4, 'parent' => $desc1, 'name' => $desc4),
    array('id' => $desc5, 'parent' => $desc2, 'name' => $desc5),
    array('id' => $desc6, 'parent' => $desc2, 'name' => $desc6),
    );
    

            $wer = "12uts";
            $datas = array( );

    $dat = array('id' => $desc1, 'parent' => '$emai', 'name' => $desc1);
    array_push($datas,$dat);
    $dat = array('id' => $desc2, 'parent' => '$emai', 'name' => $desc2);
    array_push($datas,$dat);
    
    $dat = array('id' => $desc3, 'parent' => $desc1, 'name' => $desc3);
    array_push($datas,$dat);
    $dat = array('id' => $desc4, 'parent' => $desc1, 'name' => $desc4);
    array_push($datas,$dat);
    $dat = array('id' => $desc5, 'parent' => $desc2, 'name' => $desc5);
    array_push($datas,$dat);
    $dat = array('id' => $desc6, 'parent' => $desc2, 'name' => $desc6);
    array_push($datas,$dat);
    //$datas = $dat+ $datas;
    //var_dump($datas);
    //$datas = array_merge($datas,$dat);

             *
             *
             **/
 $datas = array();


            getmym_direct($myid);
function generatePageTree($datas, $parent= '0', $depth=0){
    $ni=count($datas);
    if($ni == 0 || $depth > 2000) return ''; // Make sure not to have an endless recursion
    $tree = '<ul>';
    for($i=0; $i < $ni; $i++){
        if($datas[$i]['parent'] == $parent){
            $tree .= '<li>';
            $tree .= $datas[$i]['name'];
            $tree .= generatePageTree($datas, $datas[$i]['id'], $depth+1);
            $tree .= '</li>';
        }
    }
    $tree .= '</ul>';
    return $tree;
}


            ?>
<div class="tree" style="margin-left: 40%; height:500px;">
<?php 
echo(generatePageTree($datas));

            ?>
            
            </div>
            

          </div> <!-- / row -->


        </div> <!-- / container-fluid -->


    </div>
<?php include('footer.php'); ?>