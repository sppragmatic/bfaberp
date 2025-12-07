
 <link href="<?= base_url();?>/assets/css/jquery-ui.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url();?>/assets/plugins/uniform/themes/default/css/uniform.default.css" />
<link rel="stylesheet" href="<?= base_url();?>/assets/plugins/inputlimiter/jquery.inputlimiter.1.0.css" />
<link rel="stylesheet" href="<?= base_url();?>/assets/plugins/chosen/chosen.min.css" />
<link rel="stylesheet" href="<?= base_url();?>/assets/plugins/colorpicker/css/colorpicker.css" />
<link rel="stylesheet" href="<?= base_url();?>/assets/plugins/tagsinput/jquery.tagsinput.css" />
<link rel="stylesheet" href="<?= base_url();?>/assets/plugins/daterangepicker/daterangepicker-bs3.css" />
<link rel="stylesheet" href="<?= base_url();?>/assets/plugins/datepicker/css/datepicker.css" />
<link rel="stylesheet" href="<?= base_url();?>/assets/plugins/timepicker/css/bootstrap-timepicker.min.css" />
<link rel="stylesheet" href="<?= base_url();?>/assets/plugins/switch/static/stylesheets/bootstrap-switch.css" />

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
<h1><?php echo lang('edit_user_heading');?></h1>
<p><?php echo lang('edit_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(uri_string());?>

      
          <div class="form-group">
                    <label for="text1" class="control-label col-lg-4">First Name</label>

                    <div class="col-lg-8">
                       <?php echo form_input($first_name);?><br>
                    </div>
   		  </div>
          <div class="form-group">
                    <label for="text1" class="control-label col-lg-4">First Name</label>

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
                    <label for="text1" class="control-label col-lg-4">Contact No</label>

                    <div class="col-lg-8">
                       <?php echo form_input($phone);?><br>
                    </div>
   		  </div>
           <div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Password</label>

                    <div class="col-lg-8">
                      <?php echo form_input($password);?><br>
                    </div>
   		  </div>
          	
           <div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Confirm Password</label>

                    <div class="col-lg-8">
                      <?php echo form_input($password_confirm);?><br>
                    </div>
   		  </div>
            
            
            <div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Member Groups</label>

                    <div class="col-lg-8">
                                <?php foreach ($groups as $group):?>
              <label class="checkbox">
              <?php
                  $gID=$group['id'];
                  $checked = null;
                  $item = null;
                  foreach($currentGroups as $grp) {
                      if ($gID == $grp->id) {
                          $checked= ' checked="checked"';
                      break;
                      }
                  }
              ?>
              <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
              <?php echo $group['name'];?>
              </label>
          <?php endforeach?>
                    </div>
   		  </div>
          	
  
     

      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>

      <p><?php echo form_submit('submit', lang('edit_user_submit_btn'));?></p>

<?php echo form_close();?>
    </div>

</div>
   
    </div>

           </div>
              </div>