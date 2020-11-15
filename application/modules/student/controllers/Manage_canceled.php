<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Student.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Student
 * @description     : Manage students imformation of the school.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Manage_canceled extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();      
        
        $this->load->model('Student_Model', 'student', true);       
    }

    
    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Student List" user interface                 
    *                    with class wise listing    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function index($class_id = null) {

        check_permission(VIEW);
        if(isset($class_id) && !is_numeric($class_id)){
            error($this->lang->line('unexpected_error'));
            redirect('academic/classes/index');
        }
        // for super admin 
        $school_id = 1;
        if($_POST){
            $class_id  = $this->input->post('class_id');           
        }  
        if(!$school_id && $this->session->userdata('role_id') != SUPER_ADMIN){
            $school_id = $this->session->userdata('school_id');
        }
        if($class_id && !$school_id){
            $class = $this->student->get_single('classes', array('id'=>$class_id));
            $school_id = $class->school_id;
        }
        $school = $this->student->get_school_by_id($school_id);        
        if($this->session->userdata('role_id') == STUDENT){
          $class_id =  $this->session->userdata('class_id');
        }        
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id;
        if($school_id){
            $this->data['students'] = $this->student->get_student_list_canceled($class_id, $school_id, $school->academic_year_id);
        }      
        $this->data['roles'] = $this->student->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC'); 
        $condition = array();
        $condition['status'] = 1;
        $condition['school_id'] = $school_id; 
        $this->data['class_list'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');       
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['guardians'] = $this->student->get_list('guardians', $condition, '','', '', 'id', 'ASC');
            $this->data['class_list'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['types']      = $this->student->get_list('student_types', $condition, '','', '', 'id', 'ASC'); 
            $this->data['provincialsectors'] = $this->student->get_provinciallist(); 

        }
        $this->data['provincialsectors'] = $this->student->get_provinciallist(); 
        $this->data['schools'] = $this->schools;
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage') . '  ' . $this->lang->line('canceled') . ' | ' . SMS);
        $this->layout->view('student/manage_canceled', $this->data);
    }
  
 
 

        
  
        
    
    /*****************Function view omit **********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific Student data                 
    *                       
    * @param           : $student_id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($student_id = null) {

        check_permission(VIEW);

        if(!is_numeric($student_id)){
             error($this->lang->line('unexpected_error'));
              redirect('student/index');
        }
        
        $this->data['student'] = $this->student->get_single_student($student_id);        
        $class_id = $this->data['student']->class_id;
        
        $this->data['students'] = $this->student->get_student_list($class_id);
        $this->data['roles'] = $this->student->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['guardians'] = $this->student->get_list('guardians', $condition, '','', '', 'id', 'ASC');
        }
        $this->data['class_list'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
        
        $this->data['class_id'] = $class_id;  
        
        $this->data['schools'] = $this->schools;
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('view') . ' ' . $this->lang->line('student') . ' | ' . SMS);
        $this->layout->view('student/index', $this->data);
    }
   
    
    public function get_single_student_print(){
        
        $this->load->helper('report');
        $student_id = $this->input->post('student_id');
        
        $student = $this->student->get_single('students', array('id'=>$student_id));
               
        $school = $this->student->get_school_by_id($student->school_id);
        
        $this->data['student'] = $this->student->get_single_student($student_id, $school->academic_year_id);                       
        $this->data['guardian'] = $this->student->get_single_guardian($this->data['student']->guardian_id);
        
        $this->data['academic_year_id'] = $school->academic_year_id;
        $this->data['class_id'] = $this->data['student']->class_id;
        $this->data['section_id'] = $this->data['student']->section_id;
        $this->data['student_id'] = $student_id;
        $this->data['school_id'] = $student->school_id;
        $this->data['school'] = $this->student->get_single('schools', array('id'=>$student->school_id));
        
        echo $this->load->view('get-single-student_print', $this->data);
    }
     /*****************Function get_single_student**********************************
     * @type            : Function
     * @function name   : get_single_student
     * @description     : "Load single student information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_student(){
        
        $this->load->helper('report');
        $student_id = $this->input->post('student_id');        
        $student = $this->student->get_single('students', array('id'=>$student_id));               
        $school = $this->student->get_school_by_id($student->school_id);        
        $this->data['student'] = $this->student->get_single_student($student_id, $school->academic_year_id);                       
        $this->data['guardian'] = $this->student->get_single_guardian($this->data['student']->guardian_id);
        
        $this->data['days'] = 31;
        $this->data['academic_year_id'] = $school->academic_year_id;
        $this->data['class_id'] = $this->data['student']->class_id;
        $this->data['section_id'] = $this->data['student']->section_id;
        $this->data['student_id'] = $student_id;
        $this->data['school_id'] = $student->school_id;
        
        $this->data['exams'] = $this->student->get_list('exams', array('status' => 1, 'school_id'=>$student->school_id, 'academic_year_id' => $school->academic_year_id), '', '', '', 'id', 'ASC');
        $this->data['invoices'] = $this->student->get_invoice_list($student_id);  
        $this->data['activity'] = $this->student->get_activity_list($student_id);  
        
        echo $this->load->view('get-single-student', $this->data);
    }
    
    public function student_activity() {

        $id = $this->input->post('student_id');
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
              redirect('student/index');
        }
        
        $student = $this->student->get_single('students', array('id' => $id));
        if (!empty($student)) {

            // delete student data
            $this->student->update('students',array('status' => 1), array('id' => $id));

            // delete student login data
            $this->student->update('users', array('status' => 1),array('id' => $student->user_id));

            // delete student enrollments
            $this->student->update('enrollments',array('status' => 1),  array('student_id' => $student->id));

            // delete student hostel_members
            $this->student->update('hostel_members',array('status' => 1), array('user_id' => $student->user_id));

            // delete student transport_members
            $this->student->update('transport_members',array('status' => 1), array('user_id' => $student->user_id));

            // delete student library_members
            $this->student->update('library_members',array('status' => 1), array('user_id' => $student->user_id));           

            success('Anulado Com Sucesso!');
            return true;
        } else {
            error('Sem Permisão para anular');
        }
            return false;
        // redirect('student/index/');
    }

   
}