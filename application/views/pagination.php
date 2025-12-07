    <link href="<?= base_url();?>/assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
	
    <script src="<?= base_url();?>/assets/plugins/dataTables/jquery.dataTables.js"></script>

    <script src="<?= base_url();?>/assets/plugins/dataTables/dataTables.bootstrap.js"></script>

<script type="text/javascript">
<!--
	  $(document).ready(function() {
	     $('#fileData1').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
					"sPaginationType": "full_numbers",	
                    "aaSorting": [[ 0, "desc" ]],
                    "iDisplayLength": 25,
					"bJQueryUI": true,
					"sDom": '<"H"frlT><"clear">t<"clear"><"F"ip>',
					'bProcessing'    : true,
					'bServerSide'    : true,
					'sAjaxSource'    : '<?php echo site_url(); ?>/admin/pagination/view_content',
					'fnServerData': function(sSource, aoData, fnCallback)
					{
					  $.ajax
					  ({
						'dataType': 'json',
						'type'    : 'POST',
						'url'     : sSource,
						'data'    : aoData,
						'success' : fnCallback
					  });
					},	
						
					"oTableTools": {
						
						"aButtons": [
								// "copy",
								"csv",
								"xls",
								{
									"sExtends": "pdf",
									"sPdfOrientation": "landscape",
									"sPdfMessage": ""
								},
								"print"
						]
					},
					"oLanguage": {
					  "sSearch": "Filter: "
					},
					"aoColumns": [ 
					   null,null,null,
					  { "bSortable": false }
					]
					
                } );
	  })
//-->
</script>





<div class="content">
	<div class="container-fluid">
            <div class="row-fluid">
                    
<br>
<br><br><br>

<div class="row-fluid">
<table   id="fileData1" cellpadding=0 cellspacing=10 width="100%" class="table table-bordered dataTables_wrapper odia-fo">
<thead>
<tr>

<th>Sl No</th>
<th><img src="<?= base_url();?>/assets/page-icon/grvno.png" /></th>
<th><img src="<?= base_url();?>/assets/page-icon/grv.png" /></th>
<th><img src="<?= base_url();?>/assets/page-icon/action.png" /></th>

</tr>
</thead>
<tbody>
			<tr>
            	<td colspan="7" class="dataTables_empty">Loading data from server</td>
			</tr>
        </tbody>
</table>
</div>
<div class="row-fluid"><div id="chart_div" style="width: 900px; height: 500px;"></div>
</div>





</div>
