<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Course_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    function insert($data_array) {
        // print("true");
        // print(json_encode($data_array));
        $this->db->insert('courses', $data_array);
        return $this->db->insert_id();
    }
    public function get_course_list($school_id = null){
        
        $this->db->select('T.*, S.school_name');
        $this->db->from('courses AS T');
        $this->db->join('schools AS S', 'S.id = T.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('T.school_id', $this->session->userdata('school_id'));
        }
        
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('T.school_id', $school_id);
        }
        
        $this->db->order_by('T.id', 'DESC');
        
        return $this->db->get()->result();
        
    }
    function delete($index_array) {
        $this->db->delete('courses', $index_array);
        return $this->db->affected_rows();
    }
    
    function update($data_array, $index_array) {

        $this->db->update('courses', $data_array, $index_array);
        return $this->db->affected_rows();
    }

    public function get_list($index_array, $columns = null, $limit = null, $offset = 0, $order_field = null, $order_type = null) {

        if ($columns)
            $this->db->select($columns);

        if ($limit)
            $this->db->limit($limit, $offset);

        if ($order_type) {
            $this->db->order_by($order_field, $order_type);
        } else {
            $this->db->order_by('id', 'DESC');
        }

        return $this->db->get_where('courses', $index_array)->result();
    }
    function get_single($index_array, $columns = null) {

        if ($columns)
            $this->db->select($columns);

        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $row = $this->db->get_where('courses', $index_array)->row();
        return $row;
    }
    public function get_single_teacher($id){
        
        $this->db->select('T.*, S.school_name, U.username, U.role_id, R.name AS role, SG.grade_name');
        $this->db->from('teachers AS T');
        $this->db->join('users AS U', 'U.id = T.user_id', 'left');
        $this->db->join('roles AS R', 'R.id = U.role_id', 'left');
        $this->db->join('salary_grades AS SG', 'SG.id = T.salary_grade_id', 'left');
        $this->db->join('schools AS S', 'S.id = T.school_id', 'left');
        $this->db->where('T.id', $id);
        return $this->db->get()->row();
        
    }
    
        
     function duplicate_check($username, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('username', $username);
        return $this->db->get('users')->num_rows();            
    }
}
