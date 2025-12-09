<div class="extra">

  <div class="extra-inner">

    <div class="container">
    </div>
  </div>


</div>

<!-- Footer Section -->
<!-- Decent Footer Design -->
<div class="footer">
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span12"> &copy; 2017 <a href="http://praits.org" style="color:#fff;">Pragmatic Infosystems</a>. </div>
      </div>
    </div>
  </div>
</div>
<style>
  .footer {
    background: linear-gradient(90deg, #1976d2 0%, #64b5f6 100%) !important;
    color: #fff !important;
  }
  .footer a { color: #fff !important; }
</style>

<script src="<?php echo base_url()?>assets/validate/dist/jquery.validate.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/ui/jquery-ui.css" />
<script src="<?php echo base_url()?>assets/ui/jquery-ui.js"></script>
<script src="<?php echo base_url();?>assets/chosen/chosen.jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>

<!-- JavaScript Libraries -->
<script src="<?= base_url();?>assets/js/bootstrap.js"></script>
<?php if (isset($load_datatables) && $load_datatables): ?>
  <script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url();?>assets/datatable/dataTables.buttons.min.js"></script>
  <script src="<?php echo base_url();?>assets/datatable/buttons.html5.min.js"></script>
  <script src="<?php echo base_url();?>assets/datatable/buttons.print.min.js"></script>
  <script src="<?php echo base_url();?>assets/datatable/jszip.min.js"></script>
  <script src="<?php echo base_url();?>assets/datatable/pdfmake.min.js"></script>
  <script src="<?php echo base_url();?>assets/datatable/vfs_fonts.js"></script>
  <script>window.dataTablesLoaded = true;</script>
<?php endif; ?>
<?php if (isset($load_jquery_ui) && $load_jquery_ui): ?>
  <script src="<?php echo base_url();?>assets/ui/jquery-ui.js"></script>
<?php endif; ?>
<?php if (isset($load_jquery_validate) && $load_jquery_validate): ?>
  <script src="<?php echo base_url();?>assets/validate/dist/jquery.validate.js"></script>
<?php endif; ?>
<?php if (isset($load_chosen) && $load_chosen): ?>
  <script src="<?php echo base_url();?>assets/chosen/chosen.jquery.min.js"></script>
<?php endif; ?>

<script>
$(document).ready(function() {
        // Initialize Chosen Select (after DOM and Chosen JS loaded)
       var config = {
    '.chosen-select': { width: "100%" },
    '.chosen-select-deselect': { allow_single_deselect: true },
    '.chosen-select-no-single': { disable_search_threshold: 10 },
    '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
    '.chosen-select-width': { width: "95%" }
  };
  for (var selector in config) {
    $(selector).chosen(config[selector]);
  }
    });
    </script>

</body>
</html>

