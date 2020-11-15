<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Assignment_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_assignment_list($class_id = null , $school_id = null, $academic_year_id = null){
         
        $this->db->select('A.*, SC.school_name, C.name AS class_name, W.name as section_name, S.name AS subject, AY.session_year,Ss.name AS course_name');
        $this->db->from('assignments AS A');
        $this->db->join('classes AS C', 'C.id = A.class_id', 'left');
        $this->db->join('sections AS W', 'W.id = A.section_id', 'left');
        $this->db->join('subjects AS S', 'S.id = A.subject_id', 'left');
        $this->db->join('courses AS Ss', 'Ss.id = A.course_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = A.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = A.school_id', 'left');
        
        if($academic_year_id){
            $this->db->where('A.academic_year_id', $academic_year_id);
        }
        if($class_id > 0){
             $this->db->where('A.class_id', $class_id);
        }  
        
        if($school_id && $this->session->userdata('role_id') == SUPER_ADMIN){
            $this->db->where('A.school_id', $school_id); 
        }        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('A.school_id', $this->session->userdata('school_id'));
        }
        $this->db->order_by('A.id', 'DESC');
        
        return $this->db->get()->result();
        
    }
    
    public function get_single_assignment($id){
        
        $this->db->select('A.*,  SC.school_name, C.name AS class_name, W.name as section_name, S.name AS subject,Ss.name AS course_name');
        $this->db->from('assignments AS A');
        $this->db->join('classes AS C', 'C.id = A.class_id', 'left');
        $this->db->join('sections AS W', 'W.id = A.section_id', 'left');
        $this->db->join('subjects AS S', 'S.id = A.subject_id', 'left');
        $this->db->join('courses AS Ss', 'Ss.id = A.course_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = A.school_id', 'left');
        $this->db->where('A.id', $id);
        return $this->db->get()->row();        
    } 
}
