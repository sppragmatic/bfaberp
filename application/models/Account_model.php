<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

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

    public $_ion_limit = null;

    /**

     * Offset

     *

     * @var string

     **/

    public $_ion_offset = null;

    /**

     * Order By

     *

     * @var string

     **/

    public $_ion_order_by = null;

    /**

     * Order

     *

     * @var string

     **/

    public $_ion_order = null;

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

    protected $response = null;

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

        $this->load->config('ion_auth', true);

        $this->load->helper('cookie');

        $this->load->helper('date');

        $this->lang->load('ion_auth');

    }

    public function set_message_delimiters($start_delimiter, $end_delimiter)
    {

        $this->message_start_delimiter = $start_delimiter;

        $this->message_end_delimiter = $end_delimiter;

        return true;

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


// Get all deleted (trashed) payments for a branch and year
    public function get_allpayments_trash($branch_id)
    {
        $year_id = $this->get_fyr();
        $this->db->select('purchase_account.*,party.name as customername');
        $this->db->from('purchase_account');
        $this->db->join('party', 'purchase_account.party_id=party.id');
        $this->db->where('purchase_account.branch_id', $branch_id);
        $this->db->where('purchase_account.trash', 1); // Only trashed
        $this->db->where('purchase_account.year_id', $year_id);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_fyr()
    {
        $data = $this->db->get_where('year', array('status' => 1))->row_array();
        return $data['id'];
    }

    public function create_account($data)
    {

        // print("<pre>");
        // print_r($data);
        //  exit;
        // Ensure unpaid payment status sets paid_amount and paiddetails correctly
        if (isset($data['payment_status'])) {
            $status = strtolower($data['payment_status']);
            if ($status === 'unpaid' || $status === '0' || $data['payment_status'] === 0) {
                $data['paid_amount'] = 0;
                 $data['type'] = 0;
                $data['paiddetails'] = '';
            }
        }
        $this->db->insert('account', $data);

        $account_id = $this->db->insert_id();
        return $account_id;
    }

    public function create_party($data)
    {
        $this->db->insert('party', $data);
        $party_id = $this->db->insert_id();
        return $party_id;
    }

    public function create_payment($data)
    {
        $this->db->insert('purchase_account', $data);
        $sales_id = $this->db->insert_id();
        return $sales_id;
    }

    public function get_allpayments($branch_id)
    {
        $year_id = $this->get_fyr();
        $this->db->select('purchase_account.*,party.name as customername');
        $this->db->from('purchase_account');
        $this->db->join('party', 'purchase_account.party_id=party.id');
        //$this->db->where('year_id',$year_id);
        $this->db->where('purchase_account.branch_id', $branch_id);
        $this->db->limit('50');
        $this->db->order_by('id', "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_allaccount($branch_id)
    {
    $year_id = $this->get_fyr();
    $this->db->select('account.*,material.name as matname, party.name as partyname');
    $this->db->from('account');
    $this->db->join('material', 'account.material_id=material.id');
    $this->db->join('party', 'account.party_id=party.id');
    $this->db->where('account.year_id', $year_id);
    $this->db->where('account.branch_id', $branch_id);
    $this->db->where('account.trash', 0); // Only non-deleted
    $this->db->limit('50');
    $this->db->order_by('id', "DESC");
    $query = $this->db->get();
    return $query->result_array();
    }

    public function get_adminallaccount()
    {
        $year_id = $this->get_fyr();
        $this->db->select('account.*,material.name as matname, party.name as partyname');
        $this->db->from('account');
        $this->db->join('material', 'account.material_id=material.id');
        $this->db->join('party', 'account.party_id=party.id');
        $this->db->where('account.year_id', $year_id);
        //$this->db->limit('50');
        $this->db->order_by('id', "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_unpartyaccount($code)
    {
        $res = $this->db->query("SELECT account.* , party.name as pnme, party.contact_no FROM `account`,`party` WHERE account.party_name=party.code AND account.party_name='$code' ");
        $party = $res->result_array();
        return $party;

    }

    public function get_receipt($code)
    {
        $res = $this->db->query("SELECT account.* , party.name as pnme, party.contact_no,branch.code as br_code  FROM `account`,`party`,`branch` WHERE  account.branch_id=branch.id AND  account.party_name=party.code AND account.id='$code' ");
        $party = $res->row_array();
        return $party;
    }

    public function get_allpartyaccount()
    {
        $all_p = array();
        $res = $this->db->query("SELECT DISTINCT(account.party_name) as p_c, party.name as pnme FROM `account`,`party` WHERE account.party_name=party.code");
        $party = $res->result_array();

        foreach ($party as $pr) {

            $res1 = $this->db->query("SELECT SUM(amount) as credit FROM `account`  WHERE account.type=1 AND account.party_name='{$pr['p_c']}'");
            $credit = $res1->row_array();
            if ($credit['credit'] != '') {

                $pr['credit'] = $credit['credit'];
            } else {

                $pr['credit'] = 0;
            }

            $res2 = $this->db->query("SELECT SUM(amount) as debit FROM `account`  WHERE account.type=2 AND account.party_name='{$pr['p_c']}'");
            $debit = $res2->row_array();

            if ($debit['debit'] != '') {

                $pr['debit'] = $debit['debit'];
            } else {

                $pr['debit'] = 0;
            }

            $all_p[] = $pr;

        }

        return $all_p;

    }

    public function get_matparty($material_id)
    {
        $this->db->select('*');
        $this->db->from('party');
        //$this->db->where('material_id',$material_id);
        //$this->db->order_by('id',"DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_branch()
    {
        $this->db->select('*');
        $this->db->from('branch');
        $this->db->order_by('id', "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_party()
    {
        $this->db->select('*');
        $this->db->from('party');
        $this->db->order_by('id', "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_material()
    {
        $this->db->select('*');
        $this->db->from('material');
        $this->db->order_by('id', "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get all parties, optionally only deleted (trash) or non-deleted
     * @param int $branch_id
     * @param bool $trash_only If true, only trashed; if false, only non-trashed
     * @return array
     */
    public function get_allparty($branch_id, $trash_only = false)
    {
        $this->db->select('*');
        $this->db->from('party');
        $this->db->where('branch_id', $branch_id);
        if ($trash_only) {
            $this->db->where('trash', 1);
        } else {
            $this->db->where('trash', 0);
        }
        $this->db->order_by('id', "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_account($id = null)
    {
        $cond['status'] = 0;
        $cond['id'] = $id;
        $this->db->from("account");
        $this->db->where($cond);
        $res = $this->db->get()->row_array();
        return $res;
    }

    public function edit_account($id = null)
    {
        $query = $this->db->get_where('account', array('id =' => $id))->row_array();
        return $query;
    }

    public function edit_payment($id = null)
    {
        $query = $this->db->get_where('purchase_account', array('id =' => $id))->row_array();
        return $query;
    }

    public function edit_party($id)
    {
        $query = $this->db->get_where('party', array('id =' => $id))->row_array();
        return $query;
    }

    public function update_account($id, $data)
    {
        $res = $this->db->update('account', $data, array('id' => $id));
        return $res;

    }

    public function update_party($id, $data)
    {
        $res = $this->db->update('party', $data, array('id' => $id));
        return $res;

    }

    public function delete_account($id)
    {
        $delete = $this->db->delete('account', array('id' => $id));
        return $delete;
    }

    // Product Type management
    public function get_brcode($id)
    {
        $data['id'] = $id;
        $code = $this->db->get_where('branch', $data)->row_array();
        return $code['code'];
    }

    public function get_br($branch_id)
    {
        $sql = "SELECT COUNT(id) AS c_id FROM account WHERE branch_id={$branch_id}";
        $res = $this->db->query($sql);
        $count = $res->row_array();
        return $count['c_id'] + 1;

    }

    public function get_pr()
    {
        $sql = "SELECT COUNT(id) AS c_id FROM party";
        $res = $this->db->query($sql);
        $count = $res->row_array();
        return $count['c_id'] + 1;

    }

    public function view_details($entry_date)
    {
        $this->db->select('account.*');
        $this->db->from('account');
        $this->db->where('entry_date', $entry_date);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_report($start_date, $end_date)
    {

        $sql = "SELECT entry_date FROM `account` WHERE `entry_date` > '$start_date' AND  `entry_date` < '$end_date' GROUP BY entry_date";
        $res = $this->db->query($sql);
        $p_d = $res->result_array();

        $all_data = array();
        foreach ($p_d as $pp) {
            $edd = $pp['entry_date'];
            $sql1 = "SELECT SUM(amount) AS credit FROM `account` WHERE `entry_date` = '$edd' AND `type`=1";
            $res1 = $this->db->query($sql1);
            $credit = $res1->row_array();

            $sql2 = "SELECT SUM(amount) AS debit FROM `account` WHERE `entry_date` = '$edd' AND `type`=2";
            $res2 = $this->db->query($sql2);
            $debit = $res2->row_array();

            if (isset($credit['credit'])) {
                $pp['credit'] = $credit['credit'];
            } else {
                $pp['credit'] = 0;
            }

            if (isset($debit['debit'])) {
                $pp['debit'] = $debit['debit'];
            } else {
                $pp['debit'] = 0;
            }

            $all_data[] = $pp;

        }
        return $all_data;

    }

    public function get_account_report($start_date, $end_date, $type, $party_id, $year_id)
    {

        $this->db->select('*');
        $this->db->from('account');
        $this->db->where("year_id", $year_id);
        if ($type != '0') {
            $this->db->where('type', $type);
        }
        if ($party_id != '0') {
            $this->db->where('party_name', $party_id);

        }
        if ($start_date != '0' && $end_date != '0') {
            $this->db->where("`entry_date` >= '$start_date' AND  `entry_date` <= '$end_date'");
        }

        $p_d = $this->db->get()->result_array();
//echo $this->db->last_query();exit;
        return $p_d;

    }

    public function get_misc_accdetails($dt)
    {

        $this->db->select('account.*,account.id as s_id,party.*,branch.code as br_code');
        $this->db->from('account');
        $this->db->join('party', 'account.party_name = party.code');
        $this->db->join('branch', 'account.branch_id = branch.id');
        $this->db->where("account.entry_date = '$dt'");
        $this->db->order_by('account.id', 'DESC');
        $query = $this->db->get();
        $s_p = $query->result_array();
        return $s_p;

    }

     public function get_allaccount_trash($branch_id)
    {
        $year_id = $this->get_fyr();
        $this->db->select('account.*,material.name as matname, party.name as partyname');
        $this->db->from('account');
        $this->db->join('material', 'account.material_id=material.id');
        $this->db->join('party', 'account.party_id=party.id');
        $this->db->where('account.year_id', $year_id);
        $this->db->where('account.branch_id', $branch_id);
        $this->db->where('account.trash', 1); // Only trashed
        $this->db->order_by('id', "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }
}
