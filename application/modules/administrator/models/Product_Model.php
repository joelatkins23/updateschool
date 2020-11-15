<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    function insert($data_array) {        
        $this->db->insert('products', $data_array);
        return $this->db->insert_id();
    }
    function delete($index_array) {
        $this->db->delete('products', $index_array);
        return $this->db->affected_rows();
    }
    function get_single($index_array, $columns = null) {

        if ($columns)
            $this->db->select($columns);

        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $row = $this->db->get_where('products', $index_array)->row();
        return $row;
    }
    function update($data_array, $index_array) {

        $this->db->update('products', $data_array, $index_array);
        return $this->db->affected_rows();
    }
    public function get_product_list($school_id = null){
        
        $this->db->select('AY.*, S.school_name');
        $this->db->from('products AS AY');
        $this->db->join('schools AS S', 'S.id = AY.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('AY.school_id', $this->session->userdata('school_id'));
        }
        
        if($school_id && $this->session->userdata('role_id') == SUPER_ADMIN){
            $this->db->where('AY.school_id', $school_id);
        }
        
        $this->db->order_by('AY.id', 'ASC');
        return $this->db->get()->result();
        
    }
        
    function duplicate_check($session_year, $school_id, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('school_id', $school_id);
        $this->db->where('session_year', $session_year);
        return $this->db->get('academic_years')->num_rows();            
    }
}
