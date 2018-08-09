<?php

    include('head.php');


    require_once 'app/init.php';
//    require_once 'includes/Tree.php';
    require_once 'includes/TranversalTree.php';

    $user = new User();
//    $tree = new Tree();
    $tree = new TranversalTree();


    $username = $_SESSION['user'];
    $user = User::where('email', $username)->first();


    if(isset($_POST['submit'])){
        //get the id of the user name
        $userName = trim($_POST['userN']); // Username from post
        $searchId = User::where('userName', $userName)->pluck('myid');

        //check if id exist in downlink of user
        if(sizeof($searchId) > 0){
            if(in_array($searchId[0], $tree->DownLinkArray($user->myid))){
                $userTree = $tree->DisplayTranversalTree($searchId[0]);
            }
            else {
                $userTree= "Username name does not exist in your downlink";
            }
        }
        else {
            $userTree= "Username does not exist";
        }

    //        dd($tree->DownLinkArray($user->myid));
    }
    else {
    //        dd($tree->DownLinkArray($user->myid));
        $userTree = $tree->DisplayTranversalTree($user->myid, 1);
    }

?>


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

				</div>
					<div class="clearfix"></div>
            	<div class="col-md-10 center-block animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">

                        <div class="table-responsive">
                        	<div class="content">

							</div>
                        </div>
                        
                    </div>
            <div class="tree" style="padding-left: 300px; height:500px;">
                <?php echo $userTree ?>
            
            </div>
            

          </div> <!-- / row -->


        </div> <!-- / container-fluid -->


    </div>
<?php include('footer.php'); ?>