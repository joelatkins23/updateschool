<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subscriptions_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_list() {
        $this->db->select('S.*');
        $this->db->from('tb_provincias  AS S');
        $this->db->order_by('S.id_p', 'ASC');       
        return $this->db->get()->result();
    }
    function insert($data_array) {
        $this->db->insert('students_subscription', $data_array);
        return $this->db->insert_id();
    }
    function getmax_roll_no() {
        $this->db->select('max(roll_no)roll_no');
        $this->db->from('enrollments_subscription');      
        return $this->db->get()->result();
    }
    function getmax_registration_no() {
        $this->db->select('max(registration_no)registration_no');
        $this->db->from('students_subscription');      
        return $this->db->get()->result();
    }
    function getmax_admission_no() {
        $this->db->select('max(admission_no)admission_no');
        $this->db->from('students_subscription');      
        return $this->db->get()->result();
    }
    
    function exam_history_data($id){
        $query="select * from  exam_history where student_id='".$id."' order by id desc limit 1";
        return $this->db->query($query)->result(); 
    }
    // insert new data

    function insert_batch($table_name, $data_array) {

        $this->db->insert_batch($table_name, $data_array);
        return $this->db->insert_id();
    }

    // update data by index

    function update($table_name, $data_array, $index_array) {

        $this->db->update($table_name, $data_array, $index_array);
        return $this->db->affected_rows();
    }

    // delete data by index

    function delete($table_name, $index_array) {
        $this->db->delete($table_name, $index_array);
        return $this->db->affected_rows();
    }
    public function get_student_list($class_id = null, $school_id = null, $academic_year_id = null){
            
        if(!$class_id){
            return;
        }
        
        $this->db->select('S.*, SC.school_name, E.roll_no, E.class_id, U.username, U.role_id,  C.name AS class_name, SE.name AS section,SS.result_status');
        $this->db->from('enrollments_subscription AS E');
        $this->db->join('students_subscription AS S', 'S.id = E.student_id', 'left');
        $this->db->join('users AS U', 'U.id = S.user_id', 'left');
        $this->db->join('classes AS C', 'C.id = E.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = E.section_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = S.school_id', 'left');
        $this->db->join('exam_history AS SS', 'S.id = SS.student_id', 'left');        
        
        if($academic_year_id){
            $this->db->where('E.academic_year_id', $academic_year_id); 
        }
        if($class_id){
            $this->db->where('E.class_id', $class_id);
        }
                
        if($this->session->userdata('role_id') == GUARDIAN){
           $this->db->where('S.guardian_id', $this->session->userdata('profile_id'));
        }
        
        if($this->session->userdata('role_id') == STUDENT){
           $this->db->where('S.id', $this->session->userdata('profile_id'));
        }
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('S.school_id', $this->session->userdata('school_id'));
        }
        
        if($school_id && $this->session->userdata('role_id') == SUPER_ADMIN){
            $this->db->where('S.school_id', $school_id); 
        } 
        
        $this->db->order_by('E.roll_no', 'ASC');
       
        return $this->db->get()->result();
        
    }
    public function student_insertid($student_id){
        $query="insert into students(school_id,user_id,type_id,admission_no,admission_date,guardian_id,relation_with,registration_no,`group`,`name`,phone,email,present_address,permanent_address,gender,blood_group,religion,caste,dob,age,photo,other_info,is_library_member,is_hostel_member,is_transport_member,discount_id,previous_school,previous_class,transfer_certificate,health_condition,national_id,provincial_sector,date_of_national_id,period,second_language,father_name,father_phone,father_education,father_profession,father_designation,father_photo,mother_name,mother_phone,mother_education,mother_profession,mother_designation,mother_photo,`status`,created_at,modified_at,created_by,modified_by,course_id) select school_id,user_id,type_id,admission_no,admission_date,guardian_id,relation_with,registration_no,`group`,`name`,phone,email,present_address,permanent_address,gender,blood_group,religion,caste,dob,age,photo,other_info,is_library_member,is_hostel_member,is_transport_member,discount_id,previous_school,previous_class,transfer_certificate,health_condition,national_id,provincial_sector,date_of_national_id,period,second_language,father_name,father_phone,father_education,father_profession,father_designation,father_photo,mother_name,mother_phone,mother_education,mother_profession,mother_designation,mother_photo,`status`,created_at,modified_at,created_by,modified_by,course_id from students_subscription where id='".$student_id."'";
        $this->db->query($query);
        return $this->db->insert_id();   
    }

    public function get_single_student($id,  $academic_year_id){
        // 
        $this->db->select('S.*, DE.name AS course_name,  EE.nome_provincias AS provincial_sector_name, SC.school_name, T.type, D.amount, D.title AS discount_title, SC.school_name, G.name as guardian, E.academic_year_id, E.roll_no, E.class_id, E.section_id, U.username, U.role_id, R.name AS role,  C.name AS class_name, SE.name AS section');
        $this->db->from('enrollments_subscription AS E');
        $this->db->join('students_subscription AS S', 'S.id = E.student_id', 'left');
        $this->db->join('users AS U', 'U.id = S.user_id', 'left');
        $this->db->join('roles AS R', 'R.id = U.role_id', 'left');
        $this->db->join('classes AS C', 'C.id = E.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = E.section_id', 'left');
        $this->db->join('guardians AS G', 'G.id = S.guardian_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = S.school_id', 'left');
        $this->db->join('courses AS DE', 'DE.id = S.course_id', 'left');
        $this->db->join('tb_provincias AS EE', 'EE.id_p = S.provincial_sector', 'left');
        $this->db->join('discounts AS D', 'D.id = S.discount_id', 'left');
        $this->db->join('student_types AS T', 'T.id = S.type_id', 'left');
        $this->db->where('S.id', $id);
        $this->db->where('E.academic_year_id', $academic_year_id);        
        return $this->db->get()->row();               
    }
    public function  get_single_guardian_myself($id){

        $this->db->select('("Myself")name, a.phone,a.national_id,a.present_address,a.permanent_address,a.religion,c.name as role,a.email,("")profession,a.photo,a.other_info');
        $this->db->from('students_subscription AS a');
        $this->db->join('users AS b', 'a.user_id=b.id', 'left');
        $this->db->join('roles AS c', 'b.role_id=c.id', 'left');
        $this->db->where('a.id', $id);
        return $this->db->get()->row();       
    }
    public function get_single_guardian($id){
        
        $this->db->select('G.*, U.username, U.role_id, R.name as role');
        $this->db->from('guardians AS G');
        $this->db->join('users AS U', 'U.id = G.user_id', 'left');
        $this->db->join('roles AS R', 'R.id = U.role_id', 'left');
        $this->db->where('G.id', $id);
        return $this->db->get()->row();
        
    }
    
    public function get_invoice_list($student_id, $due = null){

    $this->db->select('I.*, IH.title AS head, S.name AS student_name, AY.session_year, C.name AS class_name');
    $this->db->from('invoices AS I');        
    $this->db->join('classes AS C', 'C.id = I.class_id', 'left');
    $this->db->join('students AS S', 'S.id = I.student_id', 'left');
    $this->db->join('income_heads AS IH', 'IH.id = I.income_head_id', 'left');
    $this->db->join('academic_years AS AY', 'AY.id = I.academic_year_id', 'left');        
    $this->db->where('I.invoice_type !=', 'income'); 
    $this->db->where('I.student_id', $student_id);        

    if($due){
        $this->db->where('I.paid_status !=', 'paid');  
    }        
    if($this->session->userdata('role_id') == STUDENT){
        $this->db->where('I.student_id', $this->session->userdata('profile_id'));
    }        
    $this->db->order_by('I.id', 'DESC');  
    return $this->db->get()->result();  

   // echo $this->db->last_query();
}

    public function get_activity_list($student_id){
        
        $this->db->select('SA.*, ST.name AS student, ST.phone, C.name AS class_name, S.name as section, AY.session_year');
        $this->db->from('student_activities AS SA');
        $this->db->join('students AS ST', 'ST.id = SA.student_id', 'left');
        $this->db->join('classes AS C', 'C.id = SA.class_id', 'left');
        $this->db->join('sections AS S', 'S.id = SA.section_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = SA.academic_year_id', 'left');
        $this->db->where('SA.student_id', $student_id);
        return $this->db->get()->result();
    } 
    
    
    function duplicate_check($username, $id = null) {

        if ($id) {
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('username', $username);
        return $this->db->get('users')->num_rows();
    }
}
