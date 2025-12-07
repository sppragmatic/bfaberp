<?php defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{
    /**
     * Product model
     *
     * @var object
     */
    public $product_model;

    /**
     * Common model
     *
     * @var object
     */
    public $common_model;

    public function __construct()
    {

        parent::__construct();
        $this->load->database();

        $this->load->library('session');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('admin/product_model');
        $this->load->model('common_model');
        $this->load->database();
        $this->lang->load('auth');
        $this->load->helper('language');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

    }

    //redirect if needed, otherwise display the user list

    public function index()
    {

        $this->data['product'] = $this->product_model->get_allproduct();

        $this->load->view("common/header");
        $this->load->view("admin/product/listing_product", $this->data);
        $this->load->view("common/footer");

    }

    public function create_product()
    {

        $this->form_validation->set_rules('product[name]', 'Name', 'required');
        $this->form_validation->set_rules('product[address]', 'Description', 'required');
        $this->form_validation->set_rules('product[code]', 'Description', 'required');

        if ($this->form_validation->run() == false) {

            $data = $this->input->post('product');

            if ( isset($data['name'] ) && $data['name'] !== "") {
                $this->data['name'] = $data['name'];
            } else {
                $this->data['name'] = "";
            }
            if (isset($data['address'] )  && $data['address'] !== "") {
                $this->data['address'] = $data['address'];
            } else {
                $this->data['address'] = "";
            }

            if (isset($data['code'] )  && $data['code'] !== "") {
                $this->data['code'] = $data['code'];
            } else {
                $this->data['code'] = "";
            }

            $this->load->view("common/header");
            $this->load->view('admin/product/create_product', $this->data);
            $this->load->view("common/footer");

        } else {

            $name = $this->input->post('product');

            $insert = $this->product_model->insert_product($name);
            if ($insert !== "") {
                redirect('admin/product/edit_product/' . $insert);
            } else {
                redirect('admin/product/');
            }
        }
    }

    public function edit_product($id = null)
    {

        $this->data['product'] = $this->product_model->get_product($id);

        $this->form_validation->set_rules('product[name]', 'Name', 'required');
        $this->form_validation->set_rules('product[address]', 'Address', 'required');
        $this->form_validation->set_rules('product[code]', 'Address', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view("common/header");
            $this->load->view('admin/product/edit_product', $this->data);
            $this->load->view("common/footer");

        } else {

            $data = $this->input->post('product');

            $update = $this->product_model->update_product($data, $id);
            redirect('admin/product/edit_product/' . $id);

        }

    }

    public function delete_product($id = null)
    {
        // Validate product ID
        if (empty($id) || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Invalid product ID');
            redirect("admin/product");
            return;
        }
        
        // Check if product exists
        $product = $this->db->get_where('product', ['id' => $id])->row_array();
        if (empty($product)) {
            $this->session->set_flashdata('error', 'Product not found');
            redirect("admin/product");
            return;
        }
        
        // Check if product is used in prod_item table
        $prod_item_usage = $this->db->select('COUNT(*) as count')
                                   ->from('prod_item')
                                   ->where('product_id', $id)
                                   ->where('is_deleted', 0)
                                   ->get()
                                   ->row_array();
        
        if ($prod_item_usage['count'] > 0) {
            $this->session->set_flashdata('error', 'Cannot delete product "' . $product['name'] . '". It is being used in ' . $prod_item_usage['count'] . ' production record(s).');
            redirect("admin/product");
            return;
        }
        
        // Check if product is used in sales_item table
        $sales_item_usage = $this->db->select('COUNT(*) as count')
                                    ->from('sales_item')
                                    ->where('product_id', $id)
                                    ->where('is_deleted', 0)
                                    ->get()
                                    ->row_array();
        
        if ($sales_item_usage['count'] > 0) {
            $this->session->set_flashdata('error', 'Cannot delete product "' . $product['name'] . '". It is being used in ' . $sales_item_usage['count'] . ' sales record(s).');
            redirect("admin/product");
            return;
        }
        
        // If no usage found, proceed with deletion
        try {
            $cond['id'] = $id;
            $this->db->delete("product", $cond);
            $this->session->set_flashdata('success', 'Product "' . $product['name'] . '" deleted successfully');
        } catch (Exception $e) {
            log_message('error', 'Product deletion failed: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Failed to delete product. Please try again.');
        }
        
        redirect("admin/product");
    }

}
