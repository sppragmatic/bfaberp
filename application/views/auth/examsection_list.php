   
   <!-- /subnavbar -->
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
   <div class="span12">
   <p>
	Exam Sections of : <?php echo $exam->name; ?>
   </p>
 <!--<p class="pull-right">  
   						<a href="<?= site_url('admin/exam/create_exam') ?>"><input type="button" value="Create Exam" class="btn btn-primary"> </a></p>
-->
                               <div class="table-responsive">
 <table class="table table-striped table-bordered table-hover" id="dataTables-example">

                                    <thead>

                                        <tr>

                                             <th>Section Name</th>
											 <th>No Of Question</th>
											 <th> Question</th>									
                                        </tr>

                                    </thead>

                                    <tbody>

          <?php foreach ($exam_sections as $ctgy):?>

		<tr class="odd gradeX">
		<td><?php echo $ctgy['subject'];?></td>
			<td><?php echo $ctgy['qns_no'];?></td>
			<td> <a href="<?= site_url('admin/exam/exam_question')."/".$ctgy['id']."/".$ctgy['exam_id'] ;?>">View Question</a> </td>
		</tr>
		<?php endforeach;?>                                
                                    </tbody>
                                </table>
</div>
                            </div>     
                        </div>
                    </div>
                </div>
            </div>