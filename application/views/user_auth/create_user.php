    <!-- PAGE LEVEL STYLES -->

    

 <link href="assets/css/jquery-ui.css" rel="stylesheet" />

<link rel="stylesheet" href="assets/plugins/uniform/themes/default/css/uniform.default.css" />

<link rel="stylesheet" href="assets/plugins/inputlimiter/jquery.inputlimiter.1.0.css" />

<link rel="stylesheet" href="assets/plugins/chosen/chosen.min.css" />

<link rel="stylesheet" href="assets/plugins/colorpicker/css/colorpicker.css" />

<link rel="stylesheet" href="assets/plugins/tagsinput/jquery.tagsinput.css" />

<link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker-bs3.css" />

<link rel="stylesheet" href="assets/plugins/datepicker/css/datepicker.css" />

<link rel="stylesheet" href="assets/plugins/timepicker/css/bootstrap-timepicker.min.css" />

<link rel="stylesheet" href="assets/plugins/switch/static/stylesheets/bootstrap-switch.css" />





    <!-- END PAGE LEVEL  STYLES -->

     <!--PAGE CONTENT --> 

    <div id="content">

                <div class="inner">

               <div class="row">

               <div class="col-lg-12">

                    <h1 class="page-header">Add User</h1>

                </div>

            </div>

                     

<div class="row">

<div class="col-lg-8" align="center">







<h1><?php echo lang('create_user_heading');?></h1>

<p><?php echo lang('create_user_subheading');?></p>



<div id="infoMessage"><?php echo $message;?></div>

   <div>

            

   

<?php echo form_open("admin/auth/create_user");?>



    

    

    <div class="form-group">

                    <label for="text1" class="control-label col-lg-4">First Name</label>



                    <div class="col-lg-8">

                       <?php echo form_input($first_name);?><br>

                    </div>

     </div>

     

     <div class="form-group">

                       <label for="text1" class="control-label col-lg-4">Last Name</label>

                    <div class="col-lg-8">

                       <?php echo form_input($last_name);?><br>

                    </div>

     </div>

     <div class="form-group">

                  <label for="text1" class="control-label col-lg-4">Company</label>

            

                    <div class="col-lg-8">

            <?php echo form_input($company);?><br>

                    </div>

     </div>

     <div class="form-group">

                    <label for="text1" class="control-label col-lg-4">Email</label>

                    <div class="col-lg-8">

                       <?php echo form_input($email);?><br>

                    </div>

     </div>

    

    <div class="form-group">

                    <label for="text1" class="control-label col-lg-4">Contact No</label>

                    <div class="col-lg-8">

                       <?php echo form_input($phone);?><br>

                    </div>

     </div>

    

    <div class="form-group">

                   

            <label for="text1" class="control-label col-lg-4">Password</label><br>

          

                    <div class="col-lg-8">

                        <?php echo form_input($password);?><br>

                    </div>

     </div>

    

 <div class="form-group">

                   

           <label for="text1" class="control-label col-lg-4">Confirm Password</label><br>

          

                    <div class="col-lg-8">

                        <?php echo form_input($password_confirm);?><br>

                    </div>

     </div>

 



      <p><?php echo form_submit('submit', lang('create_user_submit_btn'));?></p>



<?php echo form_close();?>

    </div>



</div>

   

    </div>



           </div>

              </div>

                    <!-- END PAGE CONTENT -->