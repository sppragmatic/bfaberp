<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model
{

	/**

	 * Holds an array of tables used

	 *

	 * @var array

	 **/

	public $tables = array();



	/**

	 * activation code

	 *

	 * @var string

	 **/

	public $activation_code;



	/**

	 * forgotten password key

	 *

	 * @var string

	 **/

	public $forgotten_password_code;



	/**

	 * new password

	 *

	 * @var string

	 **/

	public $new_password;



	/**

	 * Identity

	 *

	 * @var string

	 **/

	public $identity;



	/**

	 * Where

	 *

	 * @var array

	 **/

	public $_ion_where = array();



	/**

	 * Select

	 *

	 * @var array

	 **/

	public $_ion_select = array();



	/**

	 * Like

	 *

	 * @var array

	 **/

	public $_ion_like = array();



	/**

	 * Limit

	 *

	 * @var string

	 **/

	public $_ion_limit = NULL;



	/**

	 * Offset

	 *

	 * @var string

	 **/

	public $_ion_offset = NULL;



	/**

	 * Order By

	 *

	 * @var string

	 **/

	public $_ion_order_by = NULL;



	/**

	 * Order

	 *

	 * @var string

	 **/

	public $_ion_order = NULL;



	/**

	 * Hooks

	 *

	 * @var object

	 **/

	protected $_ion_hooks;



	/**

	 * Response

	 *

	 * @var string

	 **/

	protected $response = NULL;



	/**

	 * message (uses lang file)

	 *

	 * @var string

	 **/

	protected $messages;



	/**

	 * error message (uses lang file)

	 *

	 * @var string

	 **/

	protected $errors;



	/**

	 * error start delimiter

	 *

	 * @var string

	 **/

	protected $error_start_delimiter;



	/**

	 * error end delimiter

	 *

	 * @var string

	 **/

	protected $error_end_delimiter;



	/**

	 * caching of users and their groups

	 *

	 * @var array

	 **/

	public $_cache_user_in_group = array();



	/**

	 * caching of groups

	 *

	 * @var array

	 **/

	protected $_cache_groups = array();



	public function __construct()

	{

		parent::__construct();

		$this->load->database();

		$this->load->config('ion_auth', TRUE);

		$this->load->helper('cookie');

		$this->load->helper('date');

		$this->lang->load('ion_auth');

	

	}

	

	

	public function set_message_delimiters($start_delimiter, $end_delimiter)

	{

		$this->message_start_delimiter = $start_delimiter;

		$this->message_end_delimiter   = $end_delimiter;



		return TRUE;

	}

	public function set_error($error)

	{

		$this->errors[] = $error;



		return $error;

	}

	public function set_message($message)

	{

		$this->messages[] = $message;



		return $message;

	}

/////// end of the package mangement

function create_account($data){
			$this->db->insert('account', $data);
			$account_id = $this->db->insert_id();
			return $account_id;	
}


function create_party($data){
			$this->db->insert('party', $data);
			$party_id = $this->db->insert_id();
			return $party_id;	
}

	
	function  get_allaccount(){
		$this->db->select('account.*');
		$this->db->from('account');
		$this->db->limit('50');
		$this->db->order_by('id',"DESC");
		$query = $this->db->get();
		return $query->result_array();	
	 }

	 
	 function get_unpartyaccount($code){
		$res = $this->db->query("SELECT account.* , party.name as pnme, party.contact_no FROM `account`,`party` WHERE account.party_name=party.code AND account.party_name='$code' ");
		$party = $res->result_array();	 
	return $party;		
		 
	 }
	 
	 function get_receipt($code){
		$res = $this->db->query("SELECT account.* , party.name as pnme, party.contact_no,branch.code as br_code  FROM `account`,`party`,`branch` WHERE  account.branch_id=branch.id AND  account.party_name=party.code AND account.id='$code' ");
		$party = $res->row_array();	 
		return $party;	 
	 }
	 
	 
	function  get_allpartyaccount(){
	$all_p = array();
		$res = $this->db->query("SELECT DISTINCT(account.party_name) as p_c, party.name as pnme FROM `account`,`party` WHERE account.party_name=party.code");
		$party = $res->result_array();
		
		foreach($party as $pr){
			
			$res1 = $this->db->query("SELECT SUM(amount) as credit FROM `account`  WHERE account.type=1 AND account.party_name='{$pr['p_c']}'");
			$credit = $res1->row_array();
		if($credit['credit'] !=''){
			
			$pr['credit'] = $credit['credit'];
		}else{
			
			$pr['credit'] = 0;
		}


			$res2 = $this->db->query("SELECT SUM(amount) as debit FROM `account`  WHERE account.type=2 AND account.party_name='{$pr['p_c']}'");
			$debit = $res2->row_array();

			
			
			
			
			if($debit['debit'] !=''){
			
			$pr['debit'] = $debit['debit'];
		}else{
			
			$pr['debit'] = 0;
		}
			
			
		
	$all_p[] = $pr;
	
		}
		
return $all_p;	
	


	}
	 
	 

function get_party(){
		$this->db->select('*');
		$this->db->from('party');
		$this->db->order_by('id',"DESC");
		$query = $this->db->get();
		return $query->result_array();	
}


	function  get_allparty(){
		$this->db->select('*');
		$this->db->from('party');
		$this->db->limit('50');
		$this->db->order_by('id',"DESC");
		$query = $this->db->get();
		return $query->result_array();	
	 }

	
	public function edit_account($id = NULL)
	{
		$query  = $this->db->get_where('account',array('id =' => $id))->row_array();		  
		return $query;
	}

function edit_party($id){
		$query  = $this->db->get_where('party',array('id =' => $id))->row_array();		  
		return $query;
}
	 




	 public function update_account($id, $data){
	 	$res = $this->db->update('account', $data, array('id' => $id));
		return $res;

	 }



	 public function update_party($id, $data){
	 	$res = $this->db->update('party', $data, array('id' => $id));
		return $res;

	 }
	

	public function delete_account($id){
			$delete  = $this->db->delete('account', array('id' => $id)); 
			return $delete;
	}

	// Product Type management
		function get_brcode($id){
			$data['id'] = $id;	
			$code =  $this->db->get_where('branch',$data)->row_array();
			return $code['code'];
		}
		
		
	
	function get_br($branch_id){
			$sql = "SELECT COUNT(id) AS c_id FROM account WHERE branch_id={$branch_id}";
			$res = $this->db->query($sql);
			$count = $res->row_array();
			return $count['c_id']+1;
			
		}
		
		
		function get_pr(){
			$sql = "SELECT COUNT(id) AS c_id FROM party";
			$res = $this->db->query($sql);
			$count = $res->row_array();
			return $count['c_id']+1;
			
		}	
		
		
	function view_details($entry_date){
		$this->db->select('account.*');
		$this->db->from('account');
		$this->db->where('entry_date',$entry_date);
		$this->db->order_by('id',"DESC");
		$query = $this->db->get();
		return $query->result_array();	
	}	
		
		
		
	function get_report($start_date, $end_date){
	
	$sql = "SELECT entry_date FROM `account` WHERE `entry_date` > '$start_date' AND  `entry_date` < '$end_date' GROUP BY entry_date";
		$res = $this->db->query($sql);
			$p_d = $res->result_array();
	
$all_data = array();
	foreach($p_d as $pp){
	$edd= $pp['entry_date'];
	$sql1 = "SELECT SUM(amount) AS credit FROM `account` WHERE `entry_date` = '$edd' AND `type`=1";
	$res1 = $this->db->query($sql1);
	$credit = $res1->row_array();
	
	
	$sql2 = "SELECT SUM(amount) AS debit FROM `account` WHERE `entry_date` = '$edd' AND `type`=2";
	$res2 = $this->db->query($sql2);
	$debit = $res2->row_array();
	

	
	if(isset($credit['credit'])){
		$pp['credit'] = $credit['credit'];		
	}else{
		$pp['credit'] = 0;		
	}


	if(isset($debit['debit'])){
		$pp['debit'] = $debit['debit'];	
	}else{
		$pp['debit'] = 0;	
	}
		
$all_data[] = $pp;	

			
	}
return $all_data;


	}
	
	
	
	
	function  get_account_report($start_date, $end_date, $type, $party_id){
		
		$this->db->select('*');
		$this->db->from('account');
		if($type!='0'){
			$this->db->where('type', $type);
		}
		if($party_id != '0'){
			$this->db->where('party_name', $party_id);
			
		}
		if($start_date !='0' && $end_date !='0'){
			$this->db->where( "`entry_date` >= '$start_date' AND  `entry_date` <= '$end_date'");
		}	
		
			$p_d = $this->db->get()->result_array();
//echo $this->db->last_query();exit;
		return $p_d;
	
	
	
	}
	
	
	function get_studentprice($branch_id){
	
		$this->db->select('SUM(amt_paid) as a_p');
		$this->db->from("student_payment");
		//$this->db->where('branch_id',$branch_id);
		$stud = $this->db->get()->row_array();
		return $stud;
	
	
	}
	
	
	
	function get_student_report($start_date, $end_date){
		$this->db->select("SUM(amt_paid) as a_p, paid_date");
		$this->db->from('student_payment');
		$this->db->where( "`paid_date` >= '$start_date' AND  `paid_date` <= '$end_date'");
		$this->db->group_by('paid_date');
		return $this->db->get()->result_array();
	}
	
	
	
	
	function get_misc($start_date, $end_date){
		
	$timeDiff = abs(strtotime($end_date) - strtotime($start_date));
	$numberDays = $timeDiff/86400;  // 86400 seconds in one day
	$numberDays = intval($numberDays);

$dd[] = $start_date;
for($i=1;$i<=$numberDays;$i++){
$st = '+'.$i.' day';
$dd[] =  date('Y-m-d', strtotime($st, strtotime($start_date)));



}


	
	
$len = count($dd);
$all_data = array();

for($j=0; $j<$len; $j++){
$dt =  $dd[$j];
$dm = array();

		$this->db->select("SUM(amt_paid) as a_p");
		$this->db->from('student_payment');
		$this->db->where( "paid_date","$dt");
		$this->db->where( "oth_br",0);
		$paid =  $this->db->get()->row_array();
		
		
		
		$this->db->select("SUM(amt_paid) as a_p");
		$this->db->from('student_payment');
		$this->db->where( "paid_date","$dt");
		$this->db->where( "oth_br",1);
		$paid221 =  $this->db->get()->row_array();
		
		
		//$all_data[]['credit'] =  $paid['a_p'];Save

		$this->db->select("SUM(refund_amt) as a_p");
		$this->db->from('refund');
		$this->db->where( "refund_date","$dt");
		$un_paid =  $this->db->get()->row_array();
		
		
		if(isset($paid['a_p'])){
		if($paid['a_p']!=''){
		$dm['credit']= $paid['a_p'];
		}else{
		$dm['credit']= 0;
		}
		}else{
		
		$dm['credit']= 0;
		}
		
		
		
		if(isset($paid221['a_p'])){
		if($paid221['a_p']!=''){
		$dm['credit_otr']= $paid221['a_p'];
		}else{
		$dm['credit_otr']= 0;
		}
		}else{
		
		$dm['credit_otr']= 0;
		}
		
		

if(isset($un_paid['a_p'])){
		if($un_paid['a_p']!=''){
		$dm['debit']= $un_paid['a_p'];
		}else{
		$dm['debit']= 0;
		}
		}else{
		$dm['debit']= 0;	
		
		
		}
		
		$dm['date'] = date('d-m-Y',strtotime($dt));
	
$all_data[] = $dm; 

}
	
	
	return $all_data;
	
	
		
		
	}
	
	
	
	
	
		function get_other($start_date, $end_date){
		
	$timeDiff = abs(strtotime($end_date) - strtotime($start_date));
	$numberDays = $timeDiff/86400;  // 86400 seconds in one day
	$numberDays = intval($numberDays);

$dd[] = $start_date;
for($i=1;$i<=$numberDays;$i++){
$st = '+'.$i.' day';
$dd[] =  date('Y-m-d', strtotime($st, strtotime($start_date)));



}


	
	
$len = count($dd);
$all_data = array();

for($j=0; $j<$len; $j++){
$dt =  $dd[$j];
$dm = array();

		$this->db->select("SUM(amt_paid) as a_p");
		$this->db->from('student_payment');
		$this->db->where( "paid_date","$dt");
		$this->db->where( "oth_br",0);
		$this->db->where( "status",5);
		$paid =  $this->db->get()->row_array();
		
		
		
		$this->db->select("SUM(amt_paid) as a_p");
		$this->db->from('student_payment');
		$this->db->where( "paid_date","$dt");
		$this->db->where( "oth_br",1);
		$this->db->where( "status",5);
		$paid221 =  $this->db->get()->row_array();
		
		
		//$all_data[]['credit'] =  $paid['a_p'];Save

		$this->db->select("SUM(refund_amt) as a_p");
		$this->db->from('refund');
		$this->db->where( "refund_date","$dt");
		$un_paid =  $this->db->get()->row_array();
		
		
		if(isset($paid['a_p'])){
		if($paid['a_p']!=''){
		$dm['credit']= $paid['a_p'];
		}else{
		$dm['credit']= 0;
		}
		}else{
		
		$dm['credit']= 0;
		}
		
		
		
		if(isset($paid221['a_p'])){
		if($paid221['a_p']!=''){
		$dm['credit_otr']= $paid221['a_p'];
		}else{
		$dm['credit_otr']= 0;
		}
		}else{
		
		$dm['credit_otr']= 0;
		}
		
		

if(isset($un_paid['a_p'])){
		if($un_paid['a_p']!=''){
		$dm['debit']= $un_paid['a_p'];
		}else{
		$dm['debit']= 0;
		}
		}else{
		$dm['debit']= 0;	
		
		
		}
		
		$dm['date'] = date('d-m-Y',strtotime($dt));
	
$all_data[] = $dm; 

}
	
	
	return $all_data;
	
	
		
		
	}
	
	
	
	
function get_misc_otr($start_date, $end_date){
		
	$timeDiff = abs(strtotime($end_date) - strtotime($start_date));
	$numberDays = $timeDiff/86400;  // 86400 seconds in one day
	$numberDays = intval($numberDays);

$dd[] = $start_date;
for($i=1;$i<=$numberDays;$i++){
$st = '+'.$i.' day';
$dd[] =  date('Y-m-d', strtotime($st, strtotime($start_date)));



}


	
	
$len = count($dd);
$all_data = array();

for($j=0; $j<$len; $j++){
$dt =  $dd[$j];
$dm = array();

		$this->db->select("SUM(amt_paid) as a_p");
		$this->db->from('student_payment');
		$this->db->where( "paid_date","$dt");
		$this->db->where( "oth_br",1);
		//$this->db->where( "status",5);
		$paid =  $this->db->get()->row_array();
		//$all_data[]['credit'] =  $paid['a_p'];Save

		$this->db->select("SUM(refund_amt) as a_p");
		$this->db->from('refund');
		$this->db->where( "refund_date","$dt");
		$un_paid =  $this->db->get()->row_array();
		
		
		if(isset($paid['a_p'])){
		if($paid['a_p']!=''){
		$dm['credit']= $paid['a_p'];
		}else{
		$dm['credit']= 0;
		}
		}else{
		
		$dm['credit']= 0;
		}


		$dm['debit']= 0;	
		
		
		$dm['date'] = date('d-m-Y',strtotime($dt));
	
$all_data[] = $dm; 

}
	
	
	return $all_data;
	
	
		
		
	}
	
	
	
	
	function get_other_otr($start_date, $end_date){
		
	$timeDiff = abs(strtotime($end_date) - strtotime($start_date));
	$numberDays = $timeDiff/86400;  // 86400 seconds in one day
	$numberDays = intval($numberDays);

$dd[] = $start_date;
for($i=1;$i<=$numberDays;$i++){
$st = '+'.$i.' day';
$dd[] =  date('Y-m-d', strtotime($st, strtotime($start_date)));



}


	
	
$len = count($dd);
$all_data = array();

for($j=0; $j<$len; $j++){
$dt =  $dd[$j];
$dm = array();

		$this->db->select("SUM(amt_paid) as a_p");
		$this->db->from('student_payment');
		$this->db->where( "paid_date","$dt");
		$this->db->where( "oth_br",1);
		$this->db->where( "status",5);
		$paid =  $this->db->get()->row_array();
		//$all_data[]['credit'] =  $paid['a_p'];Save

		$this->db->select("SUM(refund_amt) as a_p");
		$this->db->from('refund');
		$this->db->where( "refund_date","$dt");
		$un_paid =  $this->db->get()->row_array();
		
		
		if(isset($paid['a_p'])){
		if($paid['a_p']!=''){
		$dm['credit']= $paid['a_p'];
		}else{
		$dm['credit']= 0;
		}
		}else{
		
		$dm['credit']= 0;
		}


		$dm['debit']= 0;	
		
		
		$dm['date'] = date('d-m-Y',strtotime($dt));
	
$all_data[] = $dm; 

}
	
	
	return $all_data;
	
	
		
		
	}
	
	
	
	
	function get_misc_details($dt){
		
		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "`paid_date` = '$dt'");
		$this->db->where( "student_payment.oth_br",0);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();	
		return $s_p;	
	}
	
	
	
	function get_miscadmin_details($dt){
		
		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "`paid_date` = '$dt'");
		$this->db->where( "student_payment.oth_br",0);
		$status = array('1', '2');
		$this->db->where_in('student_payment.status', $status);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();	
		return $s_p;	
	}
	
	
	
		function get_miscmon_details($dt){
		
		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "`paid_date` = '$dt'");
		$this->db->where( "student_payment.oth_br",0);
		$status = array('3', '4');
		$this->db->where_in('student_payment.status', $status);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();	
		return $s_p;	
	}
	
	
	
		function get_other_details($dt){
		
		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "`paid_date` = '$dt'");
		$this->db->where( "student_payment.oth_br",0);
		$this->db->where( "student_payment.status",5);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();	
		return $s_p;	
	}
	
	
	
	
		function get_misc_details_otr($dt){
		
		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "`paid_date` = '$dt'");
		$this->db->where( "student_payment.oth_br",1);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();	
		return $s_p;	
	}
	
	
	function get_other_details_otr($dt){
		
		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "`paid_date` = '$dt'");
		$this->db->where( "student_payment.oth_br",1);
		$this->db->where( "student_payment.status",5);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();	
		return $s_p;	
	}
	
	
	
	
		function view_payment(){
		
		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->order_by('student_payment.id','DESC');
		$this->db->limit(50);
		$query = $this->db->get();
		$s_p =  $query->result_array();	
		return $s_p;	
	}
	
	
	
	
	
	
	function get_accmisc($start_date, $end_date){
	
		$timeDiff = abs(strtotime($end_date) - strtotime($start_date));
		$numberDays = $timeDiff/86400;  // 86400 seconds in one day
		$numberDays = intval($numberDays);

		$dd[] = $start_date;
		for($i=1;$i<=$numberDays;$i++){
		$st = '+'.$i.' day';
		$dd[] =  date('Y-m-d', strtotime($st, strtotime($start_date)));
		}

		$len = count($dd);
		$all_data = array();
	
		$all_acc = array();
	for($j=0; $j<$len; $j++){
		$data = array();
		$dt = array();
		$edt =  $dd[$j];
		$dm = array();

		
			$this->db->select("SUM(amount) as a_p");
			$this->db->from('account');
			$this->db->where( "`entry_date` = '$edt'");
			$this->db->where( "`type` = 1");
			$credit = $this->db->get()->row_array();
			

			$this->db->select("SUM(amount) as a_p");
			$this->db->from('account');
			$this->db->where( "`entry_date` = '$edt'");
			$this->db->where( "`type` = 2");
			$debit = $this->db->get()->row_array();
			if($credit['a_p']!=''){
						$dt['credit'] = $credit['a_p'];
			}else{
							$dt['credit'] = 0;
			}


			if($debit['a_p'] !=''){
						$dt['debit'] = $debit['a_p'];				
			}else{
						$dt['debit'] = 0;				
			}





$this->db->select("SUM(amt_paid) as a_p");
		$this->db->from('student_payment');
		$this->db->where( "paid_date","$edt");
		$paid =  $this->db->get()->row_array();
		//$all_data[]['credit'] =  $paid['a_p'];Save

		$this->db->select("SUM(refund_amt) as a_p");
		$this->db->from('refund');
		$this->db->where( "refund_date","$edt");
		$un_paid =  $this->db->get()->row_array();
		
		
		if(isset($paid['a_p'])){
		if($paid['a_p']!=''){
		$dm['credit']= $paid['a_p'];
		}else{
		$dm['credit']= 0;
		}
		}else{
		
		$dm['credit']= 0;
		}

		if(isset($un_paid['a_p'])){
		if($un_paid['a_p']!=''){
		$dm['debit']= $un_paid['a_p'];
		}else{
		$dm['debit']= 0;
		}
		}else{
		$dm['debit']= 0;	
		
		
		}



$data['credit']=  $dt['credit'] + $dm['credit'];

$data['debit'] =  $dt['debit'] + $dm['debit'];
$data['ent'] = date('d-m-Y',strtotime($edt));


			
			$all_acc[] = $data;
		}


		return $all_acc;
	}
	
	function get_misc_accdetails($dt){
		
		$this->db->select('account.*,account.id as s_id,party.*,branch.code as br_code');
		$this->db->from('account');
		$this->db->join('party','account.party_name = party.code');
		$this->db->join('branch','account.branch_id = branch.id');
		$this->db->where( "account.entry_date = '$dt'");
		$this->db->order_by('account.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();	
		return $s_p;	

	

	}
	
	
	
	
	
	}