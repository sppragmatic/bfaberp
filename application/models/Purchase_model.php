<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_model extends CI_Model
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

function get_fyr(){
			$data =  $this->db->get_where('year',array('status'=>1))->row_array();
		    return $data['id'];
		}


function create_sales($data){
			$this->db->insert('sales', $data);
			$sales_id = $this->db->insert_id();
			return $sales_id;
}

function create_payment($data){
			$this->db->insert('sales_account', $data);
			$sales_id = $this->db->insert_id();
			return $sales_id;
}


function create_customer($data){
			$this->db->insert('customer', $data);
			$customer_id = $this->db->insert_id();
			return $customer_id;
}


function get_details($invid){
//  $invid = $_REQUEST['invid'];
	$query  = $this->db->get_where('sales',array('sl_no =' => $invid))->row_array();
	$id = $query['id'];
	$this->db->select('sales_item.*,product.name');
	$this->db->from('sales_item');
	$this->db->join('product','sales_item.product_id=product.id');
	$this->db->where('sales_item.sales_id',$id);
	$result =  $this->db->get()->result_array();
$html = '';
foreach ($result as  $rs) {
if($rs['stock']>0){
	$html = $html."<p> SIZE : ".$rs['name']."<b>(".$rs['stock'].")</b> </p>";
}
}
return $html;
}


	function get_proditem($id){
		$this->db->select('sales_item.*,product.name');
		$this->db->from('sales_item');
		$this->db->join('product','sales_item.product_id=product.id');
		$this->db->where('sales_item.sales_id',$id);
		return $this->db->get()->result_array();
		}



function  print_sales($id){
		$year_id = $this->get_fyr();
		$this->db->select('sales.*,customer.name as customername');
		$this->db->from('sales');
		$this->db->join('customer','sales.customer_id=customer.id');
		//$this->db->where('year_id',$year_id);
		$this->db->where('sales.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	 }


	function  get_allsales($branch_id){
		$year_id = $this->get_fyr();
		$this->db->select('sales.*,customer.name as customername');
		$this->db->from('sales');
		$this->db->join('customer','sales.customer_id=customer.id');
		$this->db->where('sales.branch_id',$branch_id);
		$this->db->order_by('sales.bill_date',"DESC");
		$query = $this->db->get();
		return $query->result_array();
	 }



	 function  get_allsalespage($id,$branch_id){
		 $year_id = $this->get_fyr();

		 if($id<=1 && $id==""){
	 		$ids=0;
	 	}else{
	 	$ids = $id-1;
	 	}
	 	//echo $ids;


		 $this->db->select('sales.*,customer.name as customername');
		 $this->db->from('sales');
		 $this->db->join('customer','sales.customer_id=customer.id');
		 $this->db->limit(20,$ids*20);
		 $this->db->ORDER_BY('sales.id','DESC');
		 $this->db->where('sales.branch_id',$branch_id);
		 $this->db->order_by('sales.bill_date',"DESC");
		 $query = $this->db->get();
		 return $query->result_array();
		}




	 function  get_allpayments($branch_id){
		 $year_id = $this->get_fyr();
		 $this->db->select('sales_account.*,customer.name as customername');
		 $this->db->from('sales_account');
		 $this->db->join('customer','sales_account.customer_id=customer.id');
		 //$this->db->where('year_id',$year_id);
		 $this->db->where('sales_account.branch_id',$branch_id);
		 $this->db->limit('50');
		 $this->db->order_by('id',"DESC");
		 $query = $this->db->get();
		 return $query->result_array();
		}
		
			 function  get_allpayments_page($id, $branch_id){
	
	
	
		 if($id<=1 && $id==""){
			$ids=0;
		}else{
		$ids = $id-1;
		}

		$year_id = $this->get_fyr();
// 		$this->db->select('sales.*,customer.name as customername');
// 		$this->db->from('sales');
// 		$this->db->join('customer','sales.customer_id=customer.id');
// 		$this->db->limit(20,$ids*20);
// 		$this->db->ORDER_BY('sales.id','DESC');
// 		//$this->db->where('year_id',$year_id);
// 	//	$this->db->order_by('sales.bill_date');
// 		//$this->db->limit('50');
// 		$this->db->order_by('sales.bill_date',"DESC");
// 		$query = $this->db->get();
// 		return $query->result_array();
		
		
	
	
		 $year_id = $this->get_fyr();
		 $this->db->select('sales_account.*,customer.name as customername');
		 $this->db->from('sales_account');
		 $this->db->join('customer','sales_account.customer_id=customer.id');
		 //$this->db->where('year_id',$year_id);
		 $this->db->where('sales_account.branch_id',$branch_id);
		$this->db->limit(20,$ids*20);
		$this->db->ORDER_BY('sales_account.id','DESC');
		 $query = $this->db->get();
		 return $query->result_array();
		}
		
		
	 function  get_allopening($branch_id){
		 $year_id = $this->get_fyr();
		 $this->db->select('sales_account.*,customer.name as customername');
		 $this->db->from('sales_account');
		 $this->db->join('customer','sales_account.customer_id=customer.id');
		 //$this->db->where('year_id',$year_id);
		 $this->db->where('sales_account.opening',1);
		 $this->db->where('sales_account.branch_id',$branch_id);
		 $this->db->limit('50');
		 $this->db->order_by('id',"DESC");
		 $query = $this->db->get();
		  return $query->result_array();
		  //echo $this->db->last_query();exit;
		}

	 function  admin_allsales($id,$branch_id){

		 if($id<=1 && $id==""){
			$ids=0;
		}else{
		$ids = $id-1;
		}

		$year_id = $this->get_fyr();
		$this->db->select('sales.*,customer.name as customername');
		$this->db->from('sales');
		$this->db->join('customer','sales.customer_id=customer.id');
		$this->db->limit(20,$ids*20);
		$this->db->ORDER_BY('sales.id','DESC');
		//$this->db->where('year_id',$year_id);
	//	$this->db->order_by('sales.bill_date');
		//$this->db->limit('50');
		$this->db->order_by('sales.bill_date',"DESC");
		$query = $this->db->get();
		return $query->result_array();
	 }


	 function get_uncustomersales($code){
		$res = $this->db->query("SELECT sales.* , customer.name as pnme, customer.contact_no FROM `sales`,`customer` WHERE sales.customer_name=customer.code AND sales.customer_name='$code' ");
		$customer = $res->result_array();
	return $customer;

	 }

	 function get_receipt($code){
		$res = $this->db->query("SELECT sales.* , customer.name as pnme, customer.contact_no,branch.code as br_code  FROM `sales`,`customer`,`branch` WHERE  sales.branch_id=branch.id AND  sales.customer_name=customer.code AND sales.id='$code' ");
		$customer = $res->row_array();
		return $customer;
	 }


	function  get_allcustomersales(){
	$all_p = array();
		$res = $this->db->query("SELECT DISTINCT(sales.customer_name) as p_c, customer.name as pnme FROM `sales`,`customer` WHERE sales.customer_name=customer.code");
		$customer = $res->result_array();

		foreach($customer as $pr){

			$res1 = $this->db->query("SELECT SUM(amount) as credit FROM `sales`  WHERE sales.type=1 AND sales.customer_name='{$pr['p_c']}'");
			$credit = $res1->row_array();
		if($credit['credit'] !=''){

			$pr['credit'] = $credit['credit'];
		}else{

			$pr['credit'] = 0;
		}


			$res2 = $this->db->query("SELECT SUM(amount) as debit FROM `sales`  WHERE sales.type=2 AND sales.customer_name='{$pr['p_c']}'");
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



function get_customer(){
		$this->db->select('*');
		$this->db->from('customer');
		$this->db->order_by('id',"DESC");
		$query = $this->db->get();
		return $query->result_array();
}
function get_branch(){
		$this->db->select('*');
		$this->db->from('branch');
		$this->db->order_by('id',"DESC");
		$query = $this->db->get();
		return $query->result_array();
}

	function  get_allcustomer(){
		$this->db->select('*');
		$this->db->from('customer');
		//$this->db->limit('50');
		$this->db->order_by('id',"DESC");
		$query = $this->db->get();
		return $query->result_array();
	 }


	public function edit_sales($id = NULL)
	{
		$query  = $this->db->get_where('sales',array('id =' => $id))->row_array();
		return $query;
	}


	public function edit_payment($id = NULL)
	{
		$query  = $this->db->get_where('sales_account',array('id =' => $id))->row_array();
		return $query;
	}

function edit_customer($id){
		$query  = $this->db->get_where('customer',array('id =' => $id))->row_array();
		return $query;
}



public function update_payment($id, $data){
 $res = $this->db->update('sales_account', $data, array('id' => $id));
 return $res;

}

	 public function update_sales($id, $data){
	 	$res = $this->db->update('sales', $data, array('id' => $id));
		return $res;

	 }



	 public function update_customer($id, $data){
	 	$res = $this->db->update('customer', $data, array('id' => $id));
		return $res;

	 }


	public function delete_sales($id){
			$delete  = $this->db->delete('sales', array('id' => $id));
			return $delete;
	}

	// Product Type management
		function get_brcode($id){
			$data['id'] = $id;
			$code =  $this->db->get_where('branch',$data)->row_array();
			return $code['code'];
		}



	function get_br($branch_id){
			$sql = "SELECT COUNT(id) AS c_id FROM sales WHERE branch_id={$branch_id}";
			$res = $this->db->query($sql);
			$count = $res->row_array();
			return $count['c_id']+1;

		}


		function get_pr(){
			$sql = "SELECT COUNT(id) AS c_id FROM customer";
			$res = $this->db->query($sql);
			$count = $res->row_array();
			return $count['c_id']+1;

		}


	function view_details($entry_date){
		$this->db->select('sales.*');
		$this->db->from('sales');
		$this->db->where('entry_date',$entry_date);
		$this->db->order_by('id',"DESC");
		$query = $this->db->get();
		return $query->result_array();
	}



	function get_report($start_date, $end_date){

	$sql = "SELECT entry_date FROM `sales` WHERE `entry_date` > '$start_date' AND  `entry_date` < '$end_date' GROUP BY entry_date";
		$res = $this->db->query($sql);
			$p_d = $res->result_array();

$all_data = array();
	foreach($p_d as $pp){
	$edd= $pp['entry_date'];
	$sql1 = "SELECT SUM(amount) AS credit FROM `sales` WHERE `entry_date` = '$edd' AND `type`=1";
	$res1 = $this->db->query($sql1);
	$credit = $res1->row_array();


	$sql2 = "SELECT SUM(amount) AS debit FROM `sales` WHERE `entry_date` = '$edd' AND `type`=2";
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




	function  get_sales_report($start_date, $end_date, $type, $customer_id, $year_id){

		$this->db->select('*');
		$this->db->from('sales');
		$this->db->where("year_id",$year_id);
		if($type!='0'){
			$this->db->where('type', $type);
		}
		if($customer_id != '0'){
			$this->db->where('customer_name', $customer_id);

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



	function get_student_report($start_date, $end_date, $year_id){
		$this->db->select("SUM(amt_paid) as a_p, paid_date");
		$this->db->from('student_payment');
		$this->db->where("year_id",$year_id);
		$this->db->where( "`paid_date` >= '$start_date' AND  `paid_date` <= '$end_date'");
		$this->db->group_by('paid_date');
		return $this->db->get()->result_array();
	}




	function get_misc($start_date, $end_date,$year_id){

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
		$this->db->where( "year_id",$year_id);
		$paid =  $this->db->get()->row_array();



		$this->db->select("SUM(amt_paid) as a_p");
		$this->db->from('student_payment');
		$this->db->where( "year_id",$year_id);
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



			function get_interview($start_date, $end_date){

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
		$this->db->where( "status",6);
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




function get_misc_otr($start_date, $end_date,$year_id){

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
		$this->db->where( "year_id",$year_id);
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




		function get_interview_otr($start_date, $end_date){
          $all_data = array();
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
// start of the moth repor



	function get_mon_misc_details($start_date,$end_date,$year_id){

		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "student_payment.paid_date > '$start_date' AND  student_payment.paid_date < '$end_date'");
		$this->db->where( "student_payment.year_id",$year_id);
		$this->db->where( "student_payment.oth_br",0);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();
		//echo $this->db->last_query();exit;
		return $s_p;
	}



	function get_mon_miscadmin_details($start_date,$end_date,$year_id){

		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "student_payment.paid_date > '$start_date' AND  student_payment.paid_date < '$end_date'");
		$this->db->where( "student_payment.oth_br",0);
		$status = array('1', '2');
		$this->db->where_in('student_payment.status', $status);
		$this->db->where( "student_payment.year_id",$year_id);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();
		return $s_p;
	}



		function get_mon_miscmon_details($start_date,$end_date,$year_id){

		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "student_payment.paid_date > '$start_date' AND  student_payment.paid_date < '$end_date'");
		$this->db->where( "student_payment.oth_br",0);
		$status = array('3', '4');
		$this->db->where_in('student_payment.status', $status);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();
		return $s_p;
	}



	function get_mon_miscmisc_details($start_date,$end_date,$year_id){

		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "student_payment.paid_date > '$start_date' AND  student_payment.paid_date < '$end_date'");
		$this->db->where( "student_payment.oth_br",0);
		$status = array('5');
		$this->db->where_in('student_payment.status', $status);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();
		return $s_p;
	}


	function get_mon_misinter_details($start_date,$end_date,$year_id){

		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "student_payment.paid_date > '$start_date' AND  student_payment.paid_date < '$end_date'");
		$this->db->where( "student_payment.oth_br",0);
		$status = array('6');
		$this->db->where_in('student_payment.status', $status);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();
		return $s_p;
	}

	function get_monrejoin_other_details($start_date,$end_date,$year_id){

		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "student_payment.paid_date > '$start_date' AND  student_payment.paid_date < '$end_date'");
		$this->db->where( "student_payment.oth_br",0);
		$this->db->where( "student_payment.status",7);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();
		return $s_p;
	}



		function get_mon_other_details($start_date,$end_date,$year_id){

		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "student_payment.paid_date > '$start_date' AND  student_payment.paid_date < '$end_date'");
		$this->db->where( "student_payment.oth_br",0);
		$this->db->where( "student_payment.status",5);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();
		return $s_p;
	}




			function get_mon_interview_details($start_date,$end_date,$year_id){

		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "student_payment.paid_date > '$start_date' AND  student_payment.paid_date < '$end_date'");
		$this->db->where( "student_payment.oth_br",0);
		$this->db->where( "student_payment.status",6);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();
		return $s_p;
	}




		function get_mon_misc_details_otr($start_date,$end_date,$year_id){

		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "student_payment.paid_date > '$start_date' AND  student_payment.paid_date < '$end_date'");
		$this->db->where( "student_payment.oth_br",1);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();
		return $s_p;
	}


	function get_mon_other_details_otr($start_date,$end_date,$year_id){

		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "student_payment.paid_date > '$start_date' AND  student_payment.paid_date < '$end_date'");
		$this->db->where( "student_payment.oth_br",1);
		$this->db->where( "student_payment.status",5);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();
		return $s_p;
	}

// end of month report

	function get_misc_details($dt,$year_id){

		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "`paid_date` = '$dt'");
		$this->db->where( "student_payment.year_id",$year_id);
		$this->db->where( "student_payment.oth_br",0);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();
		//echo $this->db->last_query();exit;
		return $s_p;
	}



	function get_rejoinprice_details($dt,$year_id){


		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "`paid_date` = '$dt'");
		$this->db->where( "student_payment.oth_br",0);
		$status = array('7');
		$this->db->where_in('student_payment.status', $status);
		$this->db->where( "student_payment.year_id",$year_id);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();
		return $s_p;
	}


	function get_miscadmin_details($dt,$year_id){

		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "`paid_date` = '$dt'");
		$this->db->where( "student_payment.oth_br",0);
		$status = array('1', '2');
		$this->db->where_in('student_payment.status', $status);
		$this->db->where( "student_payment.year_id",$year_id);
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



	function get_miscmisc_details($dt){

		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "`paid_date` = '$dt'");
		$this->db->where( "student_payment.oth_br",0);
		$status = array('5');
		$this->db->where_in('student_payment.status', $status);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();
		return $s_p;
	}


	function get_misinter_details($dt){

		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "`paid_date` = '$dt'");
		$this->db->where( "student_payment.oth_br",0);
		$status = array('6');
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
		$this->db->where( "student_payment.paid_date = '$dt'");
		$this->db->where( "student_payment.oth_br",0);
		$this->db->where( "student_payment.status",5);
		$this->db->order_by('student_payment.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();
		return $s_p;
	}




			function get_interview_details($dt){

		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "student_payment.paid_date = '$dt'");
		$this->db->where( "student_payment.oth_br",0);
		$this->db->where( "student_payment.status",6);
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


	function get_interview_details_otr($dt){

		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where( "`paid_date` = '$dt'");
		$this->db->where( "student_payment.oth_br",1);
		$this->db->where( "student_payment.status",6);
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






	function get_accmisc($start_date, $end_date, $year_id){

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
			$this->db->from('sales');
			$this->db->where( "`entry_date` = '$edt'");
			$this->db->where( "`type` = 1");
			$this->db->where("year_id",$year_id);
			$credit = $this->db->get()->row_array();


			$this->db->select("SUM(amount) as a_p");
			$this->db->from('sales');
			$this->db->where( "`entry_date` = '$edt'");
			$this->db->where("year_id",$year_id);
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
		$this->db->where("year_id",$year_id);
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

		$this->db->select('sales.*,sales.id as s_id,customer.*,branch.code as br_code');
		$this->db->from('sales');
		$this->db->join('customer','sales.customer_name = customer.code');
		$this->db->join('branch','sales.branch_id = branch.id');
		$this->db->where( "sales.entry_date = '$dt'");
		$this->db->order_by('sales.id','DESC');
		$query = $this->db->get();
		$s_p =  $query->result_array();
		return $s_p;



	}





	}
