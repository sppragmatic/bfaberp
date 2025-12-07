<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Report extends CI_Controller {

	function __construct()

	{

		parent::__construct();

		$this->load->library('ion_auth');

		$this->load->library('form_validation');

		$this->load->helper('url');
		
		if (!$this->ion_auth->logged_in())
		{
			redirect('admin/auth', 'refresh');
		}
		
		
		$this->load->model('common_model');

		$this->load->model('report_model');	
		$this->load->model('question_model');	
		$this->load->model('admin/admission_model');				

		// Load MongoDB library instead of native db driver if required

		$this->config->item('use_mongodb', 'ion_auth') ?

		$this->load->library('mongo_db') :

		$this->load->database();



		$this->lang->load('auth');

		$this->load->helper('language');

	}



	//redirect if needed, otherwise display the user list

	function manage_rank()

	{
	
	 	$sql = "SELECT * FROM `exams`";
		$query = $this->db->query($sql);
		$exam = $query->result_array();	

		$this->data['exam'] =  $exam;
		$this->load->view("common/header");
		$this->load->view("report/manage_rank",$this->data);
		$this->load->view("common/footer");	
	 
}




function manage_mark(){
	
	
	$sql = "SELECT * FROM `exam_record` WHERE id_exam={$_REQUEST['id_exam']} ORDER BY mark DESC";
	$query = $this->db->query($sql);
	$exam = $query->result_array();	
	
	
		$sql2 = "SELECT esq.* FROM  examsection_questions esq  WHERE esq.id_exam={$_REQUEST['id_exam']}";
	$query2 = $this->db->query($sql2);
	
	
		$qns_no=$query2->num_rows();
		$max_mark=$query2->result_array();
	
		$max_m=array();
		foreach($max_mark as $max){
				$max_m[]=$max['positive_mark'];
		}
		$max_total=0;
		for($l=0;$l<count($max_m);$l++){
				$max_total=$max_total+$max_m[$l];
		}
		
		$t=0;
		$rank=array();
		foreach($exam as $ex){
			$t=$t+1;
			$mark[$t]=$ex['mark'];
			$ids[$t]=$ex['id'];
			if($max_total!=0){
				$percent=($ex['mark']/$max_total)*100;
				$per[$t] = $percent;
			}
			if($t==1){
				$rank[$t]=$t;
				
				
					$sql3= "UPDATE exam_record SET rank={$rank[$t]},percent={$percent},max_mark={$max_total},qns_no={$qns_no} WHERE id_exam={$ex['id_exam']} AND username='{$ex['username']}'";	
	$query3 = $this->db->query($sql3);				
				
				
				}else{
							if($mark[$t]==$mark[$t-1]){
										$rank[$t] = $rk  =$rank[$t-1];
							$sql4="UPDATE exam_record SET rank={$rk},percent={$percent},max_mark={$max_total},qns_no={$qns_no} WHERE id_exam={$ex['id_exam']} AND username='{$ex['username']}'";	
							
							}else{
								$rank[$t] = $rk =$rank[$t-1]+1;


							$sql4="UPDATE exam_record SET max_mark={$max_total},qns_no={$qns_no} WHERE id_exam={$ex['id_exam']} AND username='{$ex['username']}'";	

							}			
				
							
	
	$query4 = $this->db->query($sql4);			
	
					}
			
			}
			
		
			
			$lll=  count($ids);
			for($l=1;$l<=$lll; $l++){
				$sql30= "UPDATE exam_record SET rank={$rank[$l]}, percent={$per[$l]} WHERE id={$ids[$l]}";	
				$query30 = $this->db->query($sql30);	
			
			}
		


		$sql5 ="SELECT id_section FROM exam_sections WHERE id_exam={$_REQUEST['id_exam']}";
		$query5 = $this->db->query($sql5);
		$section=$query5->result_array();
		foreach($section as $sec){
			$new_section[]=$sec['id_section'];
		}

	for($i=0;$i<count($new_section);$i++){


		$sql6 ="SELECT * FROM section_record WHERE id_section={$new_section[$i]} AND id_exam={$_REQUEST['id_exam']} ORDER BY mark  DESC";
		$query6 = $this->db->query($sql6);
		$sections=$query6->result_array();



		$sql7 ="SELECT esq.positive_mark as mark FROM  examsection_questions esq WHERE esq.id_exam={$_REQUEST['id_exam']} AND esq.id_examsection={$new_section[$i]}";
		$query7 = $this->db->query($sql7);
		$sec_max=$query7->result_array();

			$se_max=array();
			foreach($sec_max as $s_max){
				$se_max[]=$s_max['mark'];
				}
			$sec_total=0;
			for($k=0;$k<count($se_max);$k++){
				$sec_total=$sec_total+$se_max[$k];
				}			
			$c=0;
			$rank1=array();
		foreach($sections as $sec){
					$c=$c+1;
					$mark[$c]=$sec['mark'];
				//	echo $sec['mark'];exit;
					if($c==1){
						$rank1[$c]=$c;
						
						
						$sql8 ="UPDATE section_record SET rank={$rank1[$c]} WHERE id_section={$sec['id_section']} AND id_exam={$sec['id_exam']} AND username='{$sec['username']}'";
			$query8 = $this->db->query($sql8);
						
						
					}else{
							if($sec['mark']==$mark[$c-1]){
										$rank1[$c]=$rank1[$c-1];
							}else{
								$rank1[$c]=$rank1[$c-1]+1;
							}			
				$sql9 = "UPDATE section_record SET rank={$rank1[$c]} WHERE id_section={$sec['id_section']} AND id_exam={$sec['id_exam']} AND username='{$sec['username']}'";
				$query9 = $this->db->query($sql9);
					
					}
			
			}
		}
		
			///echo "i am here";exit;	
	
	$sql10 ="SELECT * FROM desc_rank WHERE id_exam={$_REQUEST['id_exam']} ORDER BY mark DESC";
		$query10 = $this->db->query($sql10);
		$descrecords=$query10->result_array();
	
	
	
	
	
	
	$rn =0;
	foreach($descrecords as $dcr){
		$rn = $rn+1;
	
	$sql11 = "UPDATE desc_rank SET rank={$rn} WHERE id ={$dcr['id']}";
$query11 = $this->db->query($sql11);
					
	
	
	}
		
		
		echo "Ranks Updated";
	exit;
	
	
		
}

function get_report(){
		$sql = "SELECT * FROM `exams`";
		$query = $this->db->query($sql);
		$exam = $query->result_array();	

		$this->data['exam'] =  $exam;
		
		
		$this->data['branch'] = $this->report_model->get_allbranch();
		
		$this->load->view("common/header");
		$this->load->view("report/get_report",$this->data);
		$this->load->view("common/footer");	
}



function prepare_report(){

					$sql = "SELECT s.name as section , e.id_section FROM sections s,exam_sections e WHERE s.id=e.id_section AND e.id_exam={$_REQUEST['id_exam']}";
						$query = $this->db->query($sql);
						$section = $query->result_array();

						$e_sec=array();
						foreach($section as $sd){
								$e_sec[]=$sd['id_section'];
								$e_name[]=$sd['section'];
						}
						//echo count($e_sec);exit;
			
					
						$this->data["section_name"]=$e_name;
						$this->data["sec_no"]=count($e_name);
						
						$this->data["sections"]=$e_sec;
						$this->data["sec_c"]= count($e_sec);
						
	
				if($_REQUEST['type']!='0'){
					
				if($_REQUEST['type']==1){
					
	//$sql1 ="SELECT r.* FROM exam_record r WHERE  r.id_exam={$_REQUEST['id_exam']}  ORDER BY r.rank ASC";
	
	if($_REQUEST['branch_id']==0){

	$sql1 = "SELECT r.*,ob.name as batch_name,b.code as br_name FROM all_exam_record r, origin_batch ob, branch b WHERE r.batch_id=ob.id  AND  r.branch_id =b.id AND r.id_exam={$_REQUEST['id_exam']}  ORDER BY r.rank ASC";
	
	}else{
		
			$sql1 = "SELECT r.*,ob.name as batch_name,b.code as br_name FROM all_exam_record r, origin_batch ob, branch b WHERE r.batch_id=ob.id  AND  r.branch_id =b.id AND r.id_exam={$_REQUEST['id_exam']} AND r.branch_id={$_REQUEST['branch_id']}  ORDER BY r.rank ASC";

	}
	
	
	//echo $sql1;exit;
       			
						}else{
	
	if($_REQUEST['branch_id']==0){
	$sql1 = "SELECT r.*,ob.name as batch_name,b.code as br_name FROM all_exam_record r, origin_batch ob, branch b WHERE r.batch_id=ob.id  AND  r.branch_id =b.id AND r.id_exam={$_REQUEST['id_exam']}  ORDER BY r.name ASC";
	
	}else{
		
		$sql1 = "SELECT r.*,ob.name as batch_name,b.code as br_name FROM all_exam_record r, origin_batch ob, branch b WHERE r.batch_id=ob.id  AND  r.branch_id =b.id AND r.id_exam={$_REQUEST['id_exam']} AND r.branch_id={$_REQUEST['branch_id']}   ORDER BY r.name ASC";
	}
	//echo $sql1;exit;
							
							
//$sql1 ="SELECT r.* FROM exam_record r WHERE  r.id_exam={$_REQUEST['id_exam']} ORDER BY r.username ASC";
							
				}
				}else{

//$sql1 ="SELECT r.* FROM exam_record r WHERE  r.id_exam={$_REQUEST['id_exam']} ORDER BY r.username ASC";
if($_REQUEST['branch_id']==0){
$sql1 = "SELECT r.*,ob.name as batch_name,b.code as br_name FROM all_exam_record r, origin_batch ob, branch b WHERE r.batch_id=ob.id  AND  r.branch_id =b.id AND r.id_exam={$_REQUEST['id_exam']}  ORDER BY r.name ASC";
//echo $sql1;exit;
}else{
	$sql1 = "SELECT r.*,ob.name as batch_name,b.code as br_name FROM all_exam_record r, origin_batch ob, branch b WHERE r.batch_id=ob.id  AND  r.branch_id =b.id AND r.id_exam={$_REQUEST['id_exam']} AND r.branch_id={$_REQUEST['branch_id']}  ORDER BY r.name ASC";

	
	
}
								
				}
				$query1 = $this->db->query($sql1);
				$result = $query1->result_array();
				
				//$result=$this->m->getall($res1);
				$user=array();
				foreach($result as $rd){
					$user[]=$rd['username'];
					$name[]=$rd['name'];
					$user_name[]=$rd['username'];
					$batch_name[]=$rd['batch_name'];
					$br_name[]=$rd['br_name'];										
				}
$final_data= array();
				//	print("<pre>");
			for($i=0;$i<count($user);$i++){
						
					//	$res1=$this->m->query("SELECT s.name as section, r.*  FROM sections s,all_section_record r WHERE s.id=r.id_section AND r.id_exam={$_REQUEST['id_exam']} AND r.id_user={$user[$i]}");
				
				
				
				$sql2 ="SELECT * FROM all_section_record WHERE id_exam={$_REQUEST['id_exam']} AND username='{$user[$i]}'";
		$query2 = $this->db->query($sql2);
		$section =$query2->result_array();
				
						
						
						
						
						
						$data['user_id']=$user[$i];
						$data['name']=$name[$i];
						$data['user_name']=$user_name[$i];
						$data['batch_name']=$batch_name[$i];
						$data['br_name']=$br_name[$i];										
						
						
						
						foreach($section as $sec){
							$data['mark'][$sec['id_section']]= $sec['mark'];
							$data['rank'][$sec['id_section']]= $sec['rank'];
							}
						
						
			$sql3 ="SELECT * FROM all_exam_record WHERE id_exam={$_REQUEST['id_exam']} AND username='{$user[$i]}'";
		$query3 = $this->db->query($sql3);
		$exam =$query3->row_array();			
						
						
						
				
						
							$data['total_mark']=$exam['mark'];
							$data['overall_rank']=$exam['rank'];
							$data['percent']=$exam['percent'];
							
						//$res12=$this->m->query($this->create_select("desc_rank","id_exam={$_REQUEST['id_exam']} AND username={$user[$i]}"));
						
					
						$sql4 ="SELECT * FROM all_desc_rank WHERE id_exam={$_REQUEST['id_exam']} AND username='{$user[$i]}'";
		$query4 = $this->db->query($sql4);
		$desc =$query4->row_array();
		$num =$query4->num_rows();
						
						
						//$desc=$this->m->fetch_array($res12);
						//$num =$this->m->num_rows($res12);
						if($num ==0){
							$data['desc_mark']= "";
							$data['desc_rank']= "";
							$data['sum_total'] = $exam['mark'] + 0;
						}else{
							$data['desc_mark']= $desc['mark'];
							$data['desc_rank']= $desc['rank'];
							$data['sum_total'] = $exam['mark'] + $desc['mark'];	
						}
						
						
						//echo $num;exit;
						$final_data[]=$data;	
				}


		//$dat = $this->array_sort($final_data,'sum_total',SORT_DESC);	


$sql5 ="SELECT * FROM exams WHERE id={$_REQUEST['id_exam']}";
			$query5 = $this->db->query($sql5);
			$cur_exam =$query5->row_array();
				$dat = array();
				
			//	echo $_REQUEST['type'];exit;
if($cur_exam['desc_status'] == '1' && $_REQUEST['type']!='2'){
	$dat = $this->array_sort($final_data,'sum_total',SORT_DESC);	
}else{	
	$dat = $final_data;		
}


			
			
			
			
			
			
			
				$this->data["exam_details"]= $cur_exam;
				$this->data["id_exam"]= $_REQUEST['id_exam'];
				$this->data["report"] = $final_data;
			
			
		
			
				if($cur_exam['desc_status'] == '1'){
					$this->load->view("common/header");
					$this->load->view("report/view_descreport",$this->data);
					$this->load->view("common/footer");	
		

				
				}else{
					$this->load->view("common/header");
					$this->load->view("report/view_report",$this->data);
					$this->load->view("common/footer");	
				
				
				}


 


}


function student(){

		$this->data['e_batch'] = $this->admission_model->get_exambatch();
		$this->data['o_batch'] = $this->admission_model->get_originbatch();
		$this->data['branch'] = $this->admission_model->get_allbranch();
		$this->load->view("common/header");
		$this->load->view("report/listing_form",$this->data);
		$this->load->view("common/footer");	
	

}



function search_student(){


	$this->data['e_batch'] = $this->admission_model->get_exambatch();
		$this->data['o_batch'] = $this->admission_model->get_originbatch();
		$this->data['branch'] = $this->admission_model->get_allbranch();
			$this->data['origin_batch_id'] = $this->input->post('origin_batch_id');
			$this->data['exam_batch_id'] = $this->input->post('exam_batch_id');
		$this->data['branch_id'] = $this->input->post('branch_id');
		$this->data['username'] = $this->input->post('username');
		$this->data['name'] = $this->input->post('name');
		if($this->input->post('username')=='' && $this->input->post('name')==''){
				
				if($this->input->post('branch_id')!=0){
									$cond['branch_id'] = $this->input->post('branch_id');
				}


				if($this->input->post('origin_batch_id')!=0){
									$cond['origin_batch_id'] = $this->input->post('origin_batch_id');
				}
				
				
				if($this->input->post('exam_batch_id')!=0){
									$cond['exam_batch_id'] = $this->input->post('exam_batch_id');
				}
				
		
	


			
		$this->data['form'] = $this->admission_model->get_student_sr($cond);
		
		
	//	print("<pre>");
		//print_r($this->data['user_details']);
		//exit;
		
		$this->load->view("common/header");
		$this->load->view("admin/admission/student_pd",$this->data);
		$this->load->view("common/footer");	
				//echo 'hello suirqww';exit;
		}else{
			if($this->input->post('username')!='' && $this->input->post('name')!=''){
				$this->data['username']= $cond['username'] = $this->input->post('username');
				$this->data['name'] = $cond['name'] = $this->input->post('name');
				$this->data['form'] = $this->admission_model->get_student_sr($cond);
				
						$this->load->view("common/header");
						$this->load->view("admin/admission/student_pd",$this->data);
						$this->load->view("common/footer");	
				
			}else{
				if($this->input->post('username')!='' ){
				$this->data['username']= $cond['username'] = $this->input->post('username');
				$this->data['form'] = $this->admission_model->get_student_sr($cond);
					
							$this->load->view("common/header");
							$this->load->view("admin/admission/student_pd",$this->data);
								$this->load->view("common/footer");	
					
				}

				if($this->input->post('name')!='' ){
				//	echo "i am here";exit;
					$this->data['name'] = $cond['name'] = $this->input->post('name');
					$this->data['form'] = $this->admission_model->get_student_sr($cond);
					//echo $this->db->last_query();exit;
							$this->load->view("common/header");
							$this->load->view("admin/admission/student_pd",$this->data);
							$this->load->view("common/footer");	
				}


						
			}
	
}

		
		




}





public function export(){
		header('Content-type: application/vnd.ms-excel');

		header("Content-Disposition: attachment; filename=Report.xls");

		header("Pragma: no-cache");

		header("Expires: 0"); 

		echo $_REQUEST['hiddenExportText'];
		exit;
	
}
/// start of the code for branch report

function manage_brrank()

	{
	
	 	$sql = "SELECT * FROM `exams`";
		$query = $this->db->query($sql);
		$exam = $query->result_array();	

		$this->data['exam'] =  $exam;
		$this->load->view("common/header");
		$this->load->view("report/manage_brrank",$this->data);
		$this->load->view("common/footer");	
	 
}




function manage_brmark(){
	
	
	$sql = "SELECT * FROM `exam_record` WHERE id_exam={$_REQUEST['id_exam']} ORDER BY mark DESC";
	$query = $this->db->query($sql);
	$exam = $query->result_array();	
	
	
		$sql2 = "SELECT esq.* FROM  examsection_questions esq  WHERE esq.id_exam={$_REQUEST['id_exam']}";
	$query2 = $this->db->query($sql2);
	
	
		$qns_no=$query2->num_rows();
		$max_mark=$query2->result_array();
	
		$max_m=array();
		foreach($max_mark as $max){
				$max_m[]=$max['positive_mark'];
		}
		$max_total=0;
		for($l=0;$l<count($max_m);$l++){
				$max_total=$max_total+$max_m[$l];
		}
		
		$t=0;
		$rank=array();
		foreach($exam as $ex){
			$t=$t+1;
			$mark[$t]=$ex['mark'];
			$ids[$t]=$ex['id'];
			if($max_total!=0){
				$percent=($ex['mark']/$max_total)*100;
				$per[$t] = $percent;
			}
			if($t==1){
				$rank[$t]=$t;
				
				
					$sql3= "UPDATE exam_record SET rank={$rank[$t]},percent={$percent},max_mark={$max_total},qns_no={$qns_no} WHERE id_exam={$ex['id_exam']} AND username='{$ex['username']}'";	
	$query3 = $this->db->query($sql3);				
				
				
				}else{
							if($mark[$t]==$mark[$t-1]){
										$rank[$t] = $rk  =$rank[$t-1];
							$sql4="UPDATE exam_record SET rank={$rk},percent={$percent},max_mark={$max_total},qns_no={$qns_no} WHERE id_exam={$ex['id_exam']} AND username='{$ex['username']}'";	
							
							}else{
								$rank[$t] = $rk =$rank[$t-1]+1;


							$sql4="UPDATE exam_record SET max_mark={$max_total},qns_no={$qns_no} WHERE id_exam={$ex['id_exam']} AND username='{$ex['username']}'";	

							}			
				
							
	
	$query4 = $this->db->query($sql4);			
	
					}
			
			}
			
		
			
			$lll=  count($ids);
			for($l=1;$l<=$lll; $l++){
				$sql30= "UPDATE exam_record SET rank={$rank[$l]}, percent={$per[$l]} WHERE id={$ids[$l]}";	
				$query30 = $this->db->query($sql30);	
			
			}
		


		$sql5 ="SELECT id_section FROM exam_sections WHERE id_exam={$_REQUEST['id_exam']}";
		$query5 = $this->db->query($sql5);
		$section=$query5->result_array();
		foreach($section as $sec){
			$new_section[]=$sec['id_section'];
		}

	for($i=0;$i<count($new_section);$i++){


		$sql6 ="SELECT * FROM section_record WHERE id_section={$new_section[$i]} AND id_exam={$_REQUEST['id_exam']} ORDER BY mark  DESC";
		$query6 = $this->db->query($sql6);
		$sections=$query6->result_array();



		$sql7 ="SELECT esq.positive_mark as mark FROM  examsection_questions esq WHERE esq.id_exam={$_REQUEST['id_exam']} AND esq.id_examsection={$new_section[$i]}";
		$query7 = $this->db->query($sql7);
		$sec_max=$query7->result_array();

			$se_max=array();
			foreach($sec_max as $s_max){
				$se_max[]=$s_max['mark'];
				}
			$sec_total=0;
			for($k=0;$k<count($se_max);$k++){
				$sec_total=$sec_total+$se_max[$k];
				}			
			$c=0;
			$rank1=array();
		foreach($sections as $sec){
					$c=$c+1;
					$mark[$c]=$sec['mark'];
				//	echo $sec['mark'];exit;
					if($c==1){
						$rank1[$c]=$c;
						
						
						$sql8 ="UPDATE section_record SET rank={$rank1[$c]} WHERE id_section={$sec['id_section']} AND id_exam={$sec['id_exam']} AND username='{$sec['username']}'";
			$query8 = $this->db->query($sql8);
						
						
					}else{
							if($sec['mark']==$mark[$c-1]){
										$rank1[$c]=$rank1[$c-1];
							}else{
								$rank1[$c]=$rank1[$c-1]+1;
							}			
				$sql9 = "UPDATE section_record SET rank={$rank1[$c]} WHERE id_section={$sec['id_section']} AND id_exam={$sec['id_exam']} AND username='{$sec['username']}'";
				$query9 = $this->db->query($sql9);
					
					}
			
			}
		}
		
			///echo "i am here";exit;	
	
	$sql10 ="SELECT * FROM desc_rank WHERE id_exam={$_REQUEST['id_exam']} ORDER BY mark DESC";
		$query10 = $this->db->query($sql10);
		$descrecords=$query10->result_array();
	
	
	
	
	
	
	$rn =0;
	foreach($descrecords as $dcr){
		$rn = $rn+1;
	
	$sql11 = "UPDATE desc_rank SET rank={$rn} WHERE id ={$dcr['id']}";
$query11 = $this->db->query($sql11);
					
	
	
	}
		
		
		echo "Ranks Updated";
	exit;
	
	
		
}

function get_brreport(){
		$sql = "SELECT * FROM `exams`";
		$query = $this->db->query($sql);
		$exam = $query->result_array();	

		$this->data['exam'] =  $exam;
		$this->load->view("common/header");
		$this->load->view("report/get_brreport",$this->data);
		$this->load->view("common/footer");	
}



function prepare_brreport($id_exam=NULL){
	
		if(!isset($_REQUEST['type'])){
			$_REQUEST['type'] =  1;
		}

		if(!isset($_REQUEST['id_exam'])){
			
			$_REQUEST['id_exam'] =  $id_exam;
		}
		
		
					$sql = "SELECT s.name as section , e.id_section FROM sections s,exam_sections e WHERE s.id=e.id_section AND e.id_exam={$_REQUEST['id_exam']}";
						$query = $this->db->query($sql);
						$section = $query->result_array();

						$e_sec=array();
						foreach($section as $sd){
								$e_sec[]=$sd['id_section'];
								$e_name[]=$sd['section'];
						}
						//echo count($e_sec);exit;
			
					
						$this->data["section_name"]=$e_name;
						$this->data["sec_no"]=count($e_name);
						
						$this->data["sections"]=$e_sec;
						$this->data["sec_c"]= count($e_sec);
						
	
				if($_REQUEST['type']!='0'){
					
				if($_REQUEST['type']==1){
	
	
	$sql1 = "SELECT r.*,ob.name as batch_name,b.code as br_name FROM exam_record r, origin_batch ob, branch b WHERE r.batch_id=ob.id  AND  r.branch_id =b.id AND r.id_exam={$_REQUEST['id_exam']}  ORDER BY r.rank ASC";
       			
						}else{
	
	$sql1 = "SELECT r.*,ob.name as batch_name,b.code as br_name FROM exam_record r, origin_batch ob, branch b WHERE r.batch_id=ob.id  AND  r.branch_id =b.id AND r.id_exam={$_REQUEST['id_exam']}  ORDER BY r.name ASC";
				}
				}else{


$sql1 = "SELECT r.*,ob.name as batch_name,b.code as br_name FROM exam_record r, origin_batch ob, branch b WHERE r.batch_id=ob.id  AND  r.branch_id =b.id AND r.id_exam={$_REQUEST['id_exam']}  ORDER BY r.name ASC";
				}
				$query1 = $this->db->query($sql1);
				$result = $query1->result_array();
				
				//$result=$this->m->getall($res1);
				$user=array();
				foreach($result as $rd){
					$user[]=$rd['username'];
					$user_id[]=$rd['id_user'];
					$name[]=$rd['name'];
					$user_name[]=$rd['username'];
					$batch_name[]=$rd['batch_name'];
					$br_name[]=$rd['br_name'];										
				}
$final_data= array();
				//	print("<pre>");
			for($i=0;$i<count($user);$i++){
				$sql2 ="SELECT * FROM section_record WHERE id_exam={$_REQUEST['id_exam']} AND username='{$user[$i]}'";
		$query2 = $this->db->query($sql2);
		$section =$query2->result_array();
				
						$data['id']=$user_id[$i];
						$data['user_id']=$user[$i];
						$data['name']=$name[$i];
						$data['user_name']=$user_name[$i];
						$data['batch_name']=$batch_name[$i];
						$data['br_name']=$br_name[$i];										
						
						
						
						foreach($section as $sec){
							$data['mark'][$sec['id_section']]= $sec['mark'];
							$data['rank'][$sec['id_section']]= $sec['rank'];
							}
						
						
			$sql3 ="SELECT * FROM exam_record WHERE id_exam={$_REQUEST['id_exam']} AND username='{$user[$i]}'";
		$query3 = $this->db->query($sql3);
		$exam =$query3->row_array();			
						
						
						
				
						
							$data['total_mark']=$exam['mark'];
							$data['overall_rank']=$exam['rank'];
							$data['percent']=$exam['percent'];
							
						//$res12=$this->m->query($this->create_select("desc_rank","id_exam={$_REQUEST['id_exam']} AND username={$user[$i]}"));
						
					
						$sql4 ="SELECT * FROM desc_rank WHERE id_exam={$_REQUEST['id_exam']} AND username='{$user[$i]}'";
		$query4 = $this->db->query($sql4);
		$desc =$query4->row_array();
		$num =$query4->num_rows();
						
						
						//$desc=$this->m->fetch_array($res12);
						//$num =$this->m->num_rows($res12);
						if($num ==0){
							$data['desc_mark']= "";
							$data['desc_rank']= "";
							$data['sum_total'] = $exam['mark'] + 0;
						}else{
							$data['desc_mark']= $desc['mark'];
							$data['desc_rank']= $desc['rank'];
							$data['sum_total'] = $exam['mark'] + $desc['mark'];	
						}
						
						
						//echo $num;exit;
						$final_data[]=$data;	
				}
				
				
				
				
			$sql5 ="SELECT * FROM exams WHERE id={$_REQUEST['id_exam']}";
			$query5 = $this->db->query($sql5);
			$cur_exam =$query5->row_array();	
				
				$dat = array();
				
			//	echo $_REQUEST['type'];exit;
if($cur_exam['desc_status'] == '1' && $_REQUEST['type']!='2'){
	$dat = $this->array_sort($final_data,'sum_total',SORT_DESC);	
}else{	
	$dat = $final_data;		
}



			
			
			
			
			
			
			
			
			//print("<pre>");
			//print_r($final_data);
			//exit;
			
			
				$this->data["exam_details"]= $cur_exam;
				$this->data["id_exam"]= $_REQUEST['id_exam'];
				$this->data["report"] = $dat;
			
		
		
			
				if($cur_exam['desc_status'] == '1'){
					$this->load->view("common/header");
					$this->load->view("report/view_brdescreport",$this->data);
					$this->load->view("common/footer");	
		

				
				}else{
					$this->load->view("common/header");
					$this->load->view("report/view_brreport",$this->data);
					$this->load->view("common/footer");	
				
				
				}


 


}




/// array sorting staert



function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}










/// array sorting end




function vrify_desc($id_exam, $username, $id){
	$da['id_exam'] = $data['desc_record.id_exam'] = $id_exam;
	$da['username'] = $data['desc_record.username'] = $username;
	$da['id_user'] = $data['desc_record.id_user'] = $id;
	
	
	$nm = $this->db->get_where("desc_rank",$da)->num_rows();
	if($nm==0){
		$this->data['total_mark'] = 0 ;
		
	}else{
		$tnm = $this->db->get_where("desc_rank",$da)->row_array();
		$this->data['total_mark']=  $tnm['mark'];
	}
	
	
	$this->db->select("desc_record.*, descques.question");
	$this->db->from("desc_record");
	$this->db->join("descques","desc_record.id_question=descques.id");
	$this->db->where($data);
	
	
			$sql5 ="SELECT * FROM exams WHERE id=$id_exam";
			$query5 = $this->db->query($sql5);
			$cur_exam =$query5->row_array();
			$this->data["exam_details"]= $cur_exam;
	
	
	
	$this->data['desc'] = $this->db->get()->result_array();
	
		$this->data['id_user'] = $id;
		$this->data['id_exam'] = $id_exam;
		$data['id_exam'] = $id_exam;
		$this->data['username'] = $username;
	    $this->data["data"]=  $data;
		$this->load->view("common/header");
		$this->load->view("report/verify_desc",$this->data);
		$this->load->view("common/footer");		
	
}

function insert_descrank(){
	$data = $_REQUEST['ex'];
	
	
	$nm = $this->db->get_where("desc_rank",$data)->num_rows();
	if($nm==0){
	
		$mak = $_REQUEST['mak'];
		$data['mark'] =  $mak;
		$res11=$this->db->insert("desc_rank",$data);
	
	}else{
		$mak = $_REQUEST['mak'];
		$up_dt['mark'] =  $mak;	
		$res11=$this->db->update("desc_rank",$up_dt,$data);
		
	}
	
	
	
	redirect("admin/report/prepare_brreport/".$data['id_exam']);
	
}




function update_descmark(){
	$id = $_REQUEST['id'];
	$mark = $_REQUEST['mark'];
	$res33=$this->db->query("UPDATE desc_record SET mark={$mark} WHERE id={$id}");
	echo 1;exit;
}



////// view report deails
function view_deatils($user_id, $id_exam){
			$sql5 ="SELECT * FROM exams WHERE id=$id_exam";
			$query5 = $this->db->query($sql5);
			$result  =$query5->row_array();


			$sql6 ="SELECT * FROM online_user WHERE username='$user_id'";
			$query6 = $this->db->query($sql6);
			$this->data['first_part'] =$query6->row_array();

	$sql7="SELECT section_record.mark,sections.name as section FROM section_record,sections WHERE section_record.id_section=sections.id AND section_record.username='$user_id' AND section_record.id_exam=$id_exam";
			$query7 = $this->db->query($sql7);
			$section =$query7->result_array();



	
			if($result['desc_type']!='0'){
		
				$e_name[] = "Descriptive";
			}

			
			
			$sql9="SELECT * FROM exam_record WHERE username='$user_id' AND id_exam=$id_exam";
			$query9 = $this->db->query($sql9);
			$exam =$query9->row_array();		
			$data['total_mark']=$exam['mark'];
			$data['overall_rank']=$exam['rank'];
			$sql10="SELECT publish_date FROM exams WHERE id=$id_exam";
			$query10 = $this->db->query($sql10);
			$exam_date =$query10->row_array();
			$exam['publish_date']=$exam_date['publish_date'];

			$sql11="SELECT id_user,rank,username FROM exam_record WHERE id_exam=$id_exam ORDER BY rank ASC LIMIT 3";
			$query11 = $this->db->query($sql11);
			$toppers =$query11->result_array();



	$sql16="SELECT e .*, s.name AS section FROM examsection_questions e,sections s WHERE e.id_exam=$id_exam AND e.id_section=s.id  ORDER BY e.id_section ASC ";
			$query16 = $this->db->query($sql16);
		$qns =$query16->result_array();
		
		$c=0;
		$questions=array();
		foreach($qns as $q){
			$c=$c+1;
			$number[]=$c;	
			$questions[]=$q['id_question'];
		}
	




	$final_wrong=$exam['doubt'];
	$this->data["doubt"]=$final_wrong;


	$final_skipped=$exam['skipped'];
	$this->data["skipped"]=$final_skipped;


	$final_answered=$exam['answered'];
	$this->data["answered"]=$final_answered;




	


//print_r($topper);exit;








	if($result['desc_type']!='0'){
		
		$sql18="SELECT * FROM desc_rank WHERE id_exam =$id_exam AND username=$user_id";
	$query18 = $this->db->query($sql18);
		$desc =$query18->row_array();


	$mark[] = $desc['mark'];
	$rank[] = $desc['rank'];

	
	
			$sql19="SELECT * FROM desc_record WHERE id_exam =$id_exam AND username=$user_id";
	$query19 = $this->db->query($sql19);
		$descp =$query19->result_array();
	
	

$answered = 0;
$notanswered = 0;
$cnt=0;
foreach($descp as $des){
$cnt = $cnt+1;
	if($des['length'] =='0'){
		$notanswered=$notanswered+1;
	}else{
		$answered = $answered+1;		
	}	
}




$ddssc['total'] = $cnt;
$ddssc['answered'] = $answered;
$ddssc['notanswered'] = $notanswered;
$ddssc['mark'] = $desc['mark'];
$ddssc['rank'] = $desc['rank'];
$this->data["descriptive"]=$ddssc;






	}



		$sql20="SELECT * FROM exams WHERE id =$id_exam";
		$query20 = $this->db->query($sql20);
		$this->data['exam_details'] =$query20->row_array();







$this->data["data"]=$data;
$this->data["username"]=$user_id;
$this->data["data1"]=$exam;
$this->data["second_part"]=$exam;

$this->data['to_q'] = $c;
$this->data["section"] = $section;



if($result['desc_type']!='0'){
//echo "i m ahre";exit;


		$this->load->view("common/header");
		$this->load->view("report/uniqe_report",$this->data);
		$this->load->view("common/footer");


}else{
//echo "i m ahre";exit;

		$this->load->view("common/header");
		$this->load->view("report/uniqe_report",$this->data);
		$this->load->view("common/footer");
	
}



	
	
}

}