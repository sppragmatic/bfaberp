<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends CI_Model
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

	public function create_section($data)
	{
			$this->db->insert('sections', $data);
			$section_id = $this->db->insert_id();
			return $section_id;
	}
	
	
	function  get_section(){
		$this->db->select('sections.*');
		$this->db->from('sections');
		$query = $this->db->get();
		return $query->result();	
	 }

	
	public function edit_section($id = NULL)
	{
		$query  = $this->db->get_where('sections',array('id =' => $id))->row_array();		  
		return $query;
	}

	 

	 public function update_section($id, $data){
	 	$res = $this->db->update('sections', $data, array('id' => $id));
		return $res;

	 }
	

	public function delete_section($id){
			$delete  = $this->db->delete('sections', array('id' => $id)); 
			return $delete;
	}

	
	// Product Type management
	
	function get_student($cond){
		$cond['admission_form.year_id'] = $this->get_fyr(); 
		$this->db->select('admission_form.*');
		$this->db->from('admission_form');
		$this->db->where($cond);
		$this->db->order_by('name','ASC');
		$query = $this->db->get();
		return $query->result();	
	}
	
	
	
	
	
		
	function get_student_mon($cond){
		$cond['admission_form.year_id'] = $this->get_fyr(); 
		$this->db->select('admission_form.*');
		$this->db->from('admission_form');
		//$this->db->join('student_price','admission_form.username=student_price.user_id');
		//$this->db->where('student_price.type',1);
		$this->db->where($cond);
		$this->db->order_by('name','ASC');
		$query = $this->db->get();
		return $query->result();	
	}
	
	
	
	function get_student_pt($cond){
		$cond['admission_form.year_id'] = $this->get_fyr(); 
		$this->db->select('admission_form.*');
		$this->db->from('admission_form');
		$this->db->where($cond);
		$query = $this->db->get();
		return $query->result_array();	
	}
	
	function get_student_payment($cond){
		$cond['student_payment.year_id'] = $this->get_fyr(); 
		$this->db->select('student_payment.*');
		$this->db->from('student_payment');
		$this->db->where($cond);
		$query = $this->db->get();
		$s_p =  $query->result_array();	
		return $s_p;
	}
	
	
	
	
	function get_student_payment_mt($cond){
		//$year_id = $this->get_fyr(); 
		$user_id = $cond['user_id'];
		$this->db->select('student_payment.*');
		$this->db->from('student_payment');
		$this->db->where('user_id',$user_id);
		//$this->db->where('year_id',$year_id);  // edited /commented on dated 11 april 7 Am
		//$this->db->where('status !=',3); commented on dated 7 juky 2017
		
		$status = array('1','2');
		$this->db->where_in('student_payment.status ', $status);
		
		$query = $this->db->get();
		$s_p =  $query->result_array();	
		return $s_p;
	}
	
	
	
	function get_student_details($id){
		$year_id = $this->get_fyr();
		$this->db->select('admission_form.*,origin_batch.name as ob_name,batch.name as e_name,branch.name as br_naame');
		$this->db->from('admission_form');
		$this->db->join('origin_batch','admission_form.origin_batch_id=origin_batch.id');
		$this->db->join('batch','admission_form.exam_batch_id=batch.id');
		$this->db->join('branch','admission_form.branch_id=branch.id');
		$this->db->where('admission_form.username',$id);
		$this->db->where('admission_form.year_id',$year_id);
		$query = $this->db->get();
		$s_d =  $query->row_array();	
		return $s_d;
	
	}
	
	
	function insert_student_payment($data){
			$sql = $this->db->insert('student_payment',$data);
			return $this->db->insert_id();
	}
	function update_student($data, $cond){
		$sql = $this->db->update('admission_form',$data, $cond);
		return $sql;		
	}
	
	



	function get_interview_monpayment($cond){
        $cond['year_id'] = $this->get_fyr();
		$cond['status'] =6;   // interview payment
		$this->db->select('student_payment.*');
		$this->db->from('student_payment');
		$this->db->where($cond);
		$query = $this->db->get();
		$s_p =  $query->result_array();	
		return $s_p;
	}


	
	function get_student_monpayment($cond){
//$cond['year_id'] = $this->get_fyr();
		//$cond['status'] =3;
		$this->db->select('student_payment.*');
		$this->db->from('student_payment');
			$status = array('3', '7');       
		$this->db->where_in('student_payment.status', $status);
		
		$this->db->where($cond);
		$query = $this->db->get();
		$s_p =  $query->result_array();	
		return $s_p;
	}
	
	function get_student_fn_monpayment($cond){
$cond['year_id'] = $this->get_fyr();
		//$cond['status'] =3;
		$this->db->select('student_payment.*');
		$this->db->from('student_payment');
			$status = array('3', '7');
		$this->db->where_in('student_payment.status', $status);
		
		$this->db->where($cond);
		$query = $this->db->get();
		$s_p =  $query->result_array();	
		return $s_p;
	}
	
	
	function get_course_price($cond, $branch_id){
		$this->db->select('student_price.*,course_fee.part_fee');
		$this->db->from('student_price');
		$this->db->join('course_fee','student_price.course_ctgy_id=course_fee.course_ctgy_id');
		$this->db->where($cond);
		$this->db->where("course_fee.branch_id", $branch_id);
		$this->db->order_by('student_price.id','DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		$s_p =  $query->row_array();	
		return $s_p;
	}
	
	function get_print($id){
		$year_id = $this->get_fyr();
		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.name,admission_form.username,admission_form.doj,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where('student_payment.id',$id);
		$this->db->where('student_payment.year_id',$year_id);
		$this->db->where('admission_form.year_id',$year_id);
		$query = $this->db->get();
		$s_p =  $query->row_array();	
		

		
		return $s_p;
		//echo $this->db->last_query();exit;
		//return $s_p;
	}
	
	
		function get_print_ad($id){
		$year_id = $this->get_fyr();
		$this->db->select('student_payment.*,student_payment.id as s_id,admission_form.name,admission_form.username,admission_form.doj,branch.code as br_code,origin_batch.name as ob_name');
		$this->db->from('student_payment');
		$this->db->join('admission_form','student_payment.user_id = admission_form.username');
		$this->db->join('branch','student_payment.branch_id = branch.id');
		$this->db->join('origin_batch','admission_form.origin_batch_id = origin_batch.id');
		$this->db->where('student_payment.id',$id);
		$this->db->where('student_payment.year_id',$year_id);
		$this->db->where('admission_form.year_id',$year_id);
		$query = $this->db->get();
		$s_p =  $query->row_array();	
		

		
		return $s_p;
		//echo $this->db->last_query();exit;
		//return $s_p;
	}
	
	
	
	


function convertNumber($number)
{
	// Indian Numbering System
	$no = round($number);
	$point = ($number - $no) * 100;
	$hundred = null;
	$digits_1 = strlen($no);
	$i = 0;
	$str = array();
	$words = array(
		'0' => '',
		'1' => 'One',
		'2' => 'Two',
		'3' => 'Three',
		'4' => 'Four',
		'5' => 'Five',
		'6' => 'Six',
		'7' => 'Seven',
		'8' => 'Eight',
		'9' => 'Nine',
		'10' => 'Ten',
		'11' => 'Eleven',
		'12' => 'Twelve',
		'13' => 'Thirteen',
		'14' => 'Fourteen',
		'15' => 'Fifteen',
		'16' => 'Sixteen',
		'17' => 'Seventeen',
		'18' => 'Eighteen',
		'19' => 'Nineteen',
		'20' => 'Twenty',
		'30' => 'Thirty',
		'40' => 'Forty',
		'50' => 'Fifty',
		'60' => 'Sixty',
		'70' => 'Seventy',
		'80' => 'Eighty',
		'90' => 'Ninety'
	);
	$digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
	while ($i < $digits_1) {
		$divider = ($i == 2) ? 10 : 100;
		$number = floor($no % $divider);
		$no = floor($no / $divider);
		$i += ($divider == 10) ? 1 : 2;
		if ($number) {
			$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
			$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
			if ($number < 21) {
				$str[] = $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred;
			} else {
				$str[] = $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[$counter] . $plural . " " . $hundred;
			}
		} else {
			$str[] = null;
		}
	}
	$str = array_reverse($str);
	$result = implode(' ', array_filter($str));
	$result = preg_replace('/\s+/', ' ', $result);
	$result = trim($result);
	// Remove any duplicate 'Only /-'
	$result = preg_replace('/(Only \/-)+$/', 'Only /-', $result);
	echo $result . " Only /-";
}

function convertGroup($index)
{
    switch ($index)
    {
        case 11:
            return " Decillion";
        case 10:
            return " Nonillion";
        case 9:
            return " Octillion";
        case 8:
            return " Septillion";
        case 7:
            return " Sextillion";
        case 6:
            return " Quintrillion";
        case 5:
            return " Quadrillion";
        case 4:
            return " Trillion";
        case 3:
            return " Billion";
        case 2:
            return " Million";
        case 1:
            return " Thousand";
        case 0:
            return "";
    }
}

function convertThreeDigit($digit1, $digit2, $digit3)
{
    $buffer = "";

    if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0")
    {
        return "";
    }

    if ($digit1 != "0")
    {
        $buffer .= $this->convertDigit($digit1) . " Hundred";
        if ($digit2 != "0" || $digit3 != "0")
        {
            $buffer .= " and ";
        }
    }

    if ($digit2 != "0")
    {
        $buffer .= $this->convertTwoDigit($digit2, $digit3);
    }
    else if ($digit3 != "0")
    {
        $buffer .= $this->convertDigit($digit3);
    }

    return $buffer;
}

function convertTwoDigit($digit1, $digit2)
{
    if ($digit2 == "0")
    {
        switch ($digit1)
        {
            case "1":
                return "Ten";
            case "2":
                return "Twenty";
            case "3":
                return "Thirty";
            case "4":
                return "Forty";
            case "5":
                return "Fifty";
            case "6":
                return "Sixty";
            case "7":
                return "Seventy";
            case "8":
                return "Eighty";
            case "9":
                return "Ninety";
        }
    } else if ($digit1 == "1")
    {
        switch ($digit2)
        {
            case "1":
                return "Eleven";
            case "2":
                return "Twelve";
            case "3":
                return "Thirteen";
            case "4":
                return "Fourteen";
            case "5":
                return "Fifteen";
            case "6":
                return "Sixteen";
            case "7":
                return "Seventeen";
            case "8":
                return "Eighteen";
            case "9":
                return "Nineteen";
        }
    } else
    {
        $temp = $this->convertDigit($digit2);
        switch ($digit1)
        {
            case "2":
                return "Twenty-$temp";
            case "3":
                return "Thirty-$temp";
            case "4":
                return "Forty-$temp";
            case "5":
                return "Fifty-$temp";
            case "6":
                return "Sixty-$temp";
            case "7":
                return "Seventy-$temp";
            case "8":
                return "Eighty-$temp";
            case "9":
                return "Ninety-$temp";
        }
    }
}

function convertDigit($digit)
{
    switch ($digit)
    {
        case "0":
            return "Zero";
        case "1":
            return "One";
        case "2":
            return "Two";
        case "3":
            return "Three";
        case "4":
            return "Four";
        case "5":
            return "Five";
        case "6":
            return "Six";
        case "7":
            return "Seven";
        case "8":
            return "Eight";
        case "9":
            return "Nine";
    }
}


	
function get_student_miscpayment($cond){
$cond['year_id'] = $this->get_fyr();
		$cond['status'] =5;
		$this->db->select('student_payment.*');
		$this->db->from('student_payment');
		$this->db->where($cond);
		$query = $this->db->get();
		$s_p =  $query->result_array();	
		return $s_p;
	}
	
	
	
function get_stmonp($user_id){
	$cond['year_id'] = $this->get_fyr();
		$cond['status'] =3;
		$cond['user_id'] =$user_id;
		$this->db->select('SUM(`amt_paid`) AS sm_p');
		$this->db->from('student_payment');
		$this->db->where($cond);
		$query = $this->db->get();
		$s_p =  $query->row_array();	
		return $s_p['sm_p'];

	
}

function get_due($user_id){
	$cond['year_id'] = $this->get_fyr();
		$cond['username'] =$user_id;
		$this->db->select('next_date');
		$this->db->from('online_user');
		$this->db->where($cond);
		$query = $this->db->get();
		$s_p =  $query->row_array();	
		return $s_p['next_date'];

	
}



function get_ob($id){
		$cond['id'] =$id;
		$this->db->select('name');
		$this->db->from('origin_batch');
		$this->db->where($cond);
		$query = $this->db->get();
		$s_p =  $query->row_array();	
		return $s_p['name'];

	
}


	
	
	}