                       <div class="table-responsive">
 <table class="table table-striped table-bordered table-hover">

									<thead>
									
								
										<tr>
<th>SL No</th>										
<th>User Id</th>										
<th>Name</th>										
<th>Remarks</th>
<th>Type</th>
<th>Total Amount</th>
										
										</tr>
									</thead>

									<tbody>
<?php $sm=1;$tp=0; foreach ($report as $fm){
	
	$tp= $tp+$fm['amt_paid'];
	?>
<tr>
<td>Sl NO : <?php echo  $fm['s_id']; ?></td>
<td> <?php echo  $fm['username']; ?></td>
<td><?php echo  $fm['name']; ?></td>
<td><?php echo $fm['remarks'];?></td><td><?php if($fm['status']==1){  echo "Admision /Installment";  }else if($fm['status']==2){ echo "Monthly Payment";   }else if($fm['status']==3){  echo "Rejoin";  }else{ echo "Other"; } ?></td>
<td><?php echo $fm['amt_paid'];?></td>

</tr>

	
<?php } ?>

	
									</tbody>


</table>

		<div class="pull-right">

<?php 
if($account_count != 0) {
if($prev > -2) {
?>
<a style="cursor: pointer;" onclick="get_next(-1)" ><b> First</b/>&nbsp;&nbsp; </a> ||
<a style="cursor:pointer; text-decoration:none;" onclick="get_next(<?php echo $prev; ?>)" ><b> Previous</b/>&nbsp;&nbsp; </a>  
<?php } ?>

<?php 
$curp=4+$page;
for($i=$page; $i<$curp; $i++){
$cur = $i+1;
$pg_c = $page;
if($i<$num){
?>
<a style="cursor:pointer; text-decoration:none;" onclick="get_next(<?php echo $i-1 ; ?>)" >
<b><?php if($pg_c == $i){ echo '<font color="red">'.$cur."</font>";  }else{ echo $cur;  } ?> </b>&nbsp;&nbsp;
</a> 
<?php } } ?>


<?php
if($page+1 < $num) {	?>
<a style="cursor:pointer; text-decoration:none;" onclick="get_next(<?php echo $next; ?>)" > <b>Next </b/>&nbsp;&nbsp;</a>
<?php } ?>
<!--|| <a style="cursor: pointer;" onclick="get_next(<?php echo $num-2; ?>,<?php echo $category['id']; ?>)" > <b>Last </b>&nbsp;&nbsp;</a>-->
<?php }?>
		
					
					
				</div>