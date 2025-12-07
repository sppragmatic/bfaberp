<?php defined('BASEPATH') or exit('No direct script access allowed');

class Material extends CI_Controller
{
    /**
     * Material model
     *
     * @var object
     */
    public $material_model;

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
        $this->load->model('admin/material_model');
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

        $this->data['material'] = $this->material_model->get_allmaterial();

        $this->load->view("common/header");
        $this->load->view("admin/material/listing_material", $this->data);
        $this->load->view("common/footer");

    }

    public function create_material()
    {

        $this->form_validation->set_rules('material[name]', 'Name', 'required');
        $this->form_validation->set_rules('material[address]', 'Description', 'required');

        if ($this->form_validation->run() == false) {

            $data = $this->input->post('material');

            if (isset($data['name']) && $data['name'] !== "") {
                $this->data['name'] = $data['name'];
            } else {
                $this->data['name'] = "";
            }
            if (isset($data['address']) &&  $data['address'] !== "") {
                $this->data['address'] = $data['address'];
            } else {
                $this->data['address'] = "";
            }

            $this->load->view("common/header");
            $this->load->view('admin/material/create_material', $this->data);
            $this->load->view("common/footer");

        } else {

            $name = $this->input->post('material');

            $insert = $this->material_model->insert_material($name);
            if ($insert !== "") {
                redirect('admin/material/edit_material/' . $insert);
            } else {
                redirect('admin/material/');
            }
        }
    }

    public function edit_material($id = null)
    {

        $this->data['material'] = $this->material_model->get_material($id);

        $this->form_validation->set_rules('material[name]', 'Name', 'required');
        $this->form_validation->set_rules('material[address]', 'Address', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view("common/header");
            $this->load->view('admin/material/edit_material', $this->data);
            $this->load->view("common/footer");

        } else {

            $data = $this->input->post('material');

            $update = $this->material_model->update_material($data, $id);
            redirect('admin/material/edit_material/' . $id);

        }

    }

    public function delete_material($id = null)
    {
        // Validate material ID
        if (empty($id) || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Invalid material ID');
            redirect("admin/material");
            return;
        }
        
        // Check if material exists
        $material = $this->db->get_where('material', ['id' => $id])->row_array();
        if (empty($material)) {
            $this->session->set_flashdata('error', 'Material not found');
            redirect("admin/material");
            return;
        }
        
        // Check if material is used in material_stock table
        $material_stock_usage = $this->db->select('COUNT(*) as count, SUM(stock) as total_stock')
                                       ->from('material_stock')
                                       ->where('material_id', $id)
                                       ->get()
                                       ->row_array();
        
        if ($material_stock_usage['count'] > 0) {
            $stock_info = '';
            if ($material_stock_usage['total_stock'] > 0) {
                $stock_info = ' (Total Stock: ' . $material_stock_usage['total_stock'] . ')';
            }
            
            $this->session->set_flashdata('error', 'Cannot delete material "' . $material['name'] . '". It has ' . $material_stock_usage['count'] . ' stock entry/entries' . $stock_info . '. Please clear all stock entries before deletion.');
            redirect("admin/material");
            return;
        }
        
        // Check if material is used in account table (material transactions)
        $account_usage = $this->db->select('COUNT(*) as count')
                                 ->from('account')
                                 ->where('material_id', $id)
                                 ->where('trash', 0)
                                 ->get()
                                 ->row_array();
        
        if ($account_usage['count'] > 0) {
            $this->session->set_flashdata('error', 'Cannot delete material "' . $material['name'] . '". It is being used in ' . $account_usage['count'] . ' transaction record(s). Please remove all transactions before deletion.');
            redirect("admin/material");
            return;
        }
        
        // If no usage found, proceed with deletion
        try {
            $cond['id'] = $id;
            $this->db->delete("material", $cond);
            $this->session->set_flashdata('success', 'Material "' . $material['name'] . '" deleted successfully');
        } catch (Exception $e) {
            log_message('error', 'Material deletion failed: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Failed to delete material. Please try again.');
        }
        
        redirect("admin/material");
    }

}
