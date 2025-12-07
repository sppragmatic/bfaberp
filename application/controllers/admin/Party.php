

<?php defined('BASEPATH') or exit('No direct script access allowed');

class Party extends CI_Controller
{
    public $data = array();
    public function __construct()
    {
        parent::__construct();
        $this->load->model('account_model');
        $this->load->library('ion_auth');
    }

    public function trash()
    {
        $branch_id = $this->session->userdata('branch_id');
        // Get only deleted parties (trash = 1)
        $this->data['party'] = $this->account_model->get_allparty($branch_id, true);
        $this->data['title'] = 'Deleted Parties (Trash)';
        $this->_loadView('account/trash_party');
    }

    public function restore($id)
    {
        if (empty($id)) {
            show_404();
        }
        $branch_id = $this->session->userdata('branch_id');
        // Only allow admin to restore
        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('error', 'Only admin can restore deleted parties.');
            redirect('admin/party/trash');
        }
        $update_data = [
            'trash' => 0,
            'is_deleted' => 0,
            'deleted_at' => null,
            'deleted_by' => null
        ];
        $this->db->update('party', $update_data, ['id' => $id, 'branch_id' => $branch_id]);
        $this->session->set_flashdata('success', 'Party restored successfully.');
        redirect('admin/party/trash');
    }

    private function _loadView($view, $data = [])
    {
        $view_data = array_merge($this->data, $data);
        $this->load->view('common/header', $view_data);
        $this->load->view($view, $view_data);
        $this->load->view('common/footer', $view_data);
    }
}
