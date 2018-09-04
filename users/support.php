<?php include('head.php'); ?>

<?php

    if( isset($_POST['send']) ) {
       
    $category = trim($_POST['category']); 
    $subject = trim($_POST['subject']); 
    $mes = trim($_POST['mes']); 
    $added=time().'-'.mt_rand();;
    
    $uniqueId= time().'-'.mt_rand();
    $img = $emai.$added.basename( $_FILES["img"]["name"]); 
    $support_query = "INSERT INTO msg(email,mes,img,subject,category) VALUES('$emai','$mes','$img','$subject','$category')";
    
    mysqli_query($dbc, $support_query);
         
        
        $target_dir = "support/uploads/".$emai.$added;
        $target_file = $target_dir . basename($_FILES["img"]["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
        echo "Your image ". basename( $_FILES["img"]["name"]). " has been sent to admin.";
        } else {
        echo "Sorry, there was an error uploading your file.";
                }
    unset($emai); 
    }
        
?>

<section id="page-title" class="row">

          <div class="col-md-8 animateme scrollme" style="float: none; color: rgb(153, 0, 0); text-align: center; font-size: 16px; opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5">
            <!--<h1>Downline Member Report</h1>-->
            <!--<p><a href="#" target="_blank" class="btn btn-danger btn-sm">DataTables documentation</a></p>-->
                      </div>

          <!--<div class="col-md-4">

            <ol class="breadcrumb pull-right no-margin-bottom">
              <li><a href="#">Team Report</a></li>
              <li><a href="#">Total Downline Member Report</a></li>
             
            </ol>

          </div>-->
        </section>
        
        <div class="col-lg-12 center-block animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">
                    
                </div>
                
                <div class="container-fluid">
          <div class="row">

            <div class="col-md-12 animateme scrollme" data-when="enter" data-from="0.2" data-to="0" data-crop="false" data-opacity="0" data-scale="0.5" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);">

              <section class="panel panel-primary">
                <header class="panel-heading">
                  <h4 class="panel-title">Raise Ticket</h4>
                </header>
                <div class="panel-body">
    <form action="support.php" method="post" class="form_container left_label" autocomplete="off" enctype="multipart/form-data" >

								<div class="form_grid_12">
									<label class="field_title">Category </label>
									<div class="form_input">
										<select data-placeholder="Category" style="width:100%; border:1px solid #ebebeb; padding:5px;" class="form-control" id="exampleInputAddress" tabindex="13" name="category">
											<optgroup label="Select Category">
											<option value="financial">Financial</option>
											<option value="technical">Technical</option>
											<option value="general">General </option>
											<option value="product">Product </option>
                      <option>Others </option>
											</optgroup>
										</select>
									</div>
								</div>
								<div class="form_grid_12">
									<label class="field_title">Subject</label>
									<div class="form_input">
										<input name="subject" tabindex="1" style="width:100%; border:1px solid #ebebeb; padding:5px;" class="form-control" id="exampleInputAddress" type="text">
									</div>
								</div>
								<div class="form_grid_12">
									<label class="field_title">Message </label>
									<div class="form_input">
										<textarea name="mes" style="width:100%; border:1px solid #ebebeb; padding:5px;" class="form-control" id="exampleInputAddress" cols="50" rows="5" tabindex="5"></textarea>
									</div>
								</div>
                                	<div class="form_grid_12">
				<label for="photo" class="control-label">Proof of Payment</label>
				<div class="controls">
					<input  type="file" name="img" id="img" class="axBlank">
				</div>
			</div>
								<div class="form_grid_12">
									<div class="form_input">
										<button style="color:white;background-color:#daa520 !important;" type="send" name="send" class="btn btn-primary">Submit</button>
										<!--<a href="support.php"><button type="button" class="btn btn-primary">Back</button></a>-->
									</div>
								</div>
						</form>
						</div>
						

              </section>
            

            </div> <!-- /col-md-6 -->

  

          </div>

      
        </div>

<?php include('footer.php'); ?>