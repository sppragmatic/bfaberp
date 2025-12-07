<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Labour_group_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all labour groups for dropdown
     */
    public function get_labour_groups() {
        $this->db->select('id, name, description');
        $this->db->from('labour_groups');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }

    /**
     * Get labour group by ID
     */
    public function get_labour_group($id) {
        $this->db->select('*');
        $this->db->from('labour_groups');
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->row_array();
    }

    /**
     * Get labour group by ID (alias method for controller compatibility)
     */
    public function get_labour_group_by_id($id) {
        return $this->get_labour_group($id);
    }

    /**
     * Get all labour groups with pagination
     */
    public function get_all_labour_groups($limit = null, $offset = null) {
        $this->db->select('*');
        $this->db->from('labour_groups');
        $this->db->order_by('name', 'ASC');
        
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Count total labour groups
     */
    public function count_labour_groups() {
        return $this->db->count_all('labour_groups');
    }

    /**
     * Insert new labour group
     */
    public function insert_labour_group($data) {
        return $this->db->insert('labour_groups', $data);
    }

    /**
     * Update labour group
     */
    public function update_labour_group($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('labour_groups', $data);
    }

    /**
     * Delete labour group
     */
    public function delete_labour_group($id) {
        $this->db->where('id', $id);
        return $this->db->delete('labour_groups');
    }
}
?>