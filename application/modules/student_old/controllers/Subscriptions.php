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

class Subscriptions extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();      
        
        $this->load->model('Student_Model', 'student', true);       
        $this->load->model('Subscriptions_Model');         
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
            $this->data['students'] = $this->Subscriptions_Model->get_student_list($class_id, $school_id, $school->academic_year_id);
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
            $this->data['provincialsectors'] = $this->Subscriptions_Model->get_list(); 
        }
        $this->data['provincialsectors'] = $this->Subscriptions_Model->get_list(); 
        $this->data['schools'] = $this->schools;
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage').' '.$this->lang->line('subscriptions') . ' | ' . SMS);
        $this->layout->view('student/subscriptions', $this->data);
    }
  
    /*****************Function exam**********************************
    * @type            : Function
    * @function name   : exam
    * @description     : Load "Student exam" user interface                 
    *                    with class wise listing    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
 
    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Student" user interface                 
    *                    and process to store "Student" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {
        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_subscriptions_validation();
                $data = $this->_get_posted_subscriptions_data();
                $insert_id = $this->Subscriptions_Model->insert($data);
                if ($insert_id) {
                    $this->__insert_enrollment($insert_id);
                    create_log('Has been added a srtudent studdent : '. $data['name']);    
                    success($this->lang->line('insert_success'));
                    redirect('student/subscriptions/index/'.$this->input->post('class_id'));
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('student/subscriptions/add/'.$this->input->post('class_id'));
                }            
        }
        
        $class_id = $this->uri->segment(4);
        if(!$class_id){
          $class_id = $this->input->post('class_id');
        }

        $this->data['class_id'] = $class_id;
        $this->data['students'] = $this->Subscriptions_Model->get_student_list($class_id);
        $this->data['roles'] = $this->student->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
         
        $condition = array();
        $school_id=1;
        $condition['status'] = 1;
        $condition['school_id'] = $school_id; 
        $this->data['class_list'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');        
        if($this->session->userdata('role_id') != SUPER_ADMIN){  
            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['discounts'] = $this->student->get_list('discounts', $condition, '','', '', 'id', 'ASC');
            $this->data['guardians'] = $this->student->get_list('guardians', $condition, '','', '', 'id', 'ASC');
            $this->data['class_list'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['types']      = $this->student->get_list('student_types', $condition, '','', '', 'id', 'ASC');
            $this->data['provincialsectors'] = $this->Subscriptions_Model->get_list(); 

            

        }
        $this->data['provincialsectors'] = $this->Subscriptions_Model->get_list(); 
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' ' . $this->lang->line('subscriptions') . ' | ' . SMS);
        $this->layout->view('student/subscriptions', $this->data);
    }

        
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Student" user interface                 
    *                    with populate "Student" value 
    *                    and process to update "Student" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('student/subscriptions');     
        }

        $student = $this->student->get_single('students_subscription', array('id'=>$id));        
        $school = $this->student->get_school_by_id($student->school_id);
        
        if ($_POST) {
            $this->_prepare_subscriptions_validation();
                $data = $this->_get_posted_subscriptions_data();
                $updated = $this->student->update('students_subscription', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    $this->__update_enrollment();
                    create_log('Has been updated a srtudent studdent : '. $data['name']);  
                    success($this->lang->line('update_success'));
                    redirect('student/subscriptions/index/'.$this->input->post('class_id'));
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('student/subscriptions/edit/' . $this->input->post('id'));
                }
           
        }

        if ($id) {            
            
            $this->data['student'] = $this->Subscriptions_Model->get_single_student($id, $school->academic_year_id);

            if (!$this->data['student']) {
                redirect('student/subscriptions');
            }
        }
        
        $class_id = $this->data['student']->class_id;
        if(!$class_id){
          $class_id = $this->input->post('class_id');
        } 

        $school = $this->student->get_school_by_id($this->data['student']->school_id);

        $this->data['class_id'] = $class_id;
        $this->data['students'] = $this->Subscriptions_Model->get_student_list($class_id, $school->id, $school->academic_year_id);
        $this->data['roles'] = $this->student->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        $condition = array();
        $school_id=1;
        $condition['status'] = 1;
        $condition['school_id'] = $school_id; 
        $this->data['class_list'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');    
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
        }else{
            $condition['school_id'] = $this->data['student']->school_id;
            
        }
        
        $this->data['discounts'] = $this->student->get_list('discounts', $condition, '','', '', 'id', 'ASC');
        $this->data['classes'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
        $this->data['guardians'] = $this->student->get_list('guardians', $condition, '','', '', 'id', 'ASC');
        $this->data['class_list'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
        $this->data['types']      = $this->student->get_list('student_types', $condition, '','', '', 'id', 'ASC');
        $this->data['provincialsectors'] = $this->Subscriptions_Model->get_list(); 
        $this->data['school_id'] = $this->data['student']->school_id;
        $this->data['filter_school_id'] = $this->data['student']->school_id;
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' ' . $this->lang->line('subscriptions') . ' | ' . SMS);
        $this->layout->view('student/subscriptions', $this->data);
    }

    /*****************Function  move to Admint student**********************************
    * @type            : Function
    * @function name   : approved
    * @description     : Load Update "Admission admission" user interface                 
    *                    with populate "Admission" value 
    *                    and process to update "Admission" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */        
    public function move_admint_student() {
        $student_id = $this->input->post("student_id");
        $student_insertid=$this->Subscriptions_Model->student_insertid($student_id);
        $school_id=1;
        if($student_insertid){
            $this->student->delete('students_subscription', array('id' => $student_id));   
            $school = $this->student->get_school_by_id($school_id);
            $enrollmentsinfo = $this->student->get_list('enrollments_subscription', array('student_id' => $student_id), '', '', '', 'id', 'ASC');
            $insertdata['school_id']=1;
            $insertdata['student_id']=$student_insertid;
            $insertdata['class_id']=$enrollmentsinfo[0]->class_id;
            $insertdata['section_id']=$enrollmentsinfo[0]->section_id;
            $insertdata['academic_year_id']=$enrollmentsinfo[0]->academic_year_id;
            $insertdata['roll_no']=$enrollmentsinfo[0]->roll_no;
            $insertdata['status']=$enrollmentsinfo[0]->status;
            $insertdata['created_at']=$enrollmentsinfo[0]->created_at;
            $insertdata['modified_at']=$enrollmentsinfo[0]->modified_at;
            $insertdata['created_by']=$enrollmentsinfo[0]->created_by;
            $insertdata['modified_by']=$enrollmentsinfo[0]->modified_by;
            $insert_enrollments =$this->student->insert('enrollments', $insertdata);
            if($insert_enrollments){
                $this->student->delete('enrollments_subscription', array('student_id' => $student_id));  
                $this->student->update('student_payment', array('student_id' => $student_insertid,'student_type' => 'admitted'), array('student_id' => $student_id));
            }
            $exam_history_data=$this->Subscriptions_Model->exam_history_data($student_id);
            $exam_results['school_id'] = 1;
            $exam_results['student_id'] = $student_insertid;
            $exam_results['exam_id'] = $exam_history_data[0]->exam_id;
            $exam_results['class_id'] = $exam_history_data[0]->class_id;
            $exam_results['section_id'] = $exam_history_data[0]->section_id;
            $exam_results['academic_year_id'] = $exam_history_data[0]->academic_year_id;                  
            $exam_results['avg_grade_point'] = $exam_history_data[0]->avg_grade_point;
            $exam_results['grade_id'] = $exam_history_data[0]->grade_id;
            $exam_results['result_status'] = "passed";
            $exam_results['status'] = 1;
            $exam_results['created_at'] = date('Y-m-d H:i:s');
            $exam_results['created_by'] = logged_in_user_id();
            $this->student->insert('exam_results', $exam_results);
            $this->student->delete('exam_history', array('student_id' => $student_id));

            $data['meassage']="sucess";
            $data['student_id']=$student_insertid;
        }else{
            $data['meassage']="error";
            $data['student_id']=$student_insertid;           
        }   
        echo json_encode($data);  
    }
    
     /*****************Function get_single_admission**********************************
     * @type            : Function
     * @function name   : get_single_admission
     * @description     : "Load single admission information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_admission(){
        
        $admission_id = $this->input->post('admission_id');        
        $this->data['admission'] = $this->admission->get_single_admission($admission_id);          
        echo $this->load->view('admission/get-single-admission', $this->data);
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
              redirect('subscriptions/index');
        }
        // $Guardianinfo= $this->student->get_list('students_subscription', array('id' => $student_id), '', '', '', 'id', 'ASC');
        // if($Guardianinfo[0]->guardian_id=='10000'){
            $this->data['student'] = $this->Subscriptions_Model->get_single_student_by_myself($student_id);   
        // }else{
            $this->data['student'] = $this->Subscriptions_Model->get_single_student($student_id);   
        // }
            
        $class_id = $this->data['student']->class_id;
        
        $this->data['students'] = $this->Subscriptions_Model->get_student_list($class_id);
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
        $this->layout->view('subscriptions/index', $this->data);
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
        
        $student = $this->Subscriptions_Model->get_single('students_subscription', array('id'=>$student_id));
         $Guardianinfo= $this->student->get_list('students_subscription', array('id' => $student_id), '', '', '', 'id', 'ASC');
        if($Guardianinfo[0]->guardian_id=='10000'){   
            $this->data['guardian'] = $this->Subscriptions_Model->get_single_guardian_myself($student_id); 
        }else{
            $this->data['guardian'] = $this->Subscriptions_Model->get_single_guardian($this->data['student']->guardian_id);
        }
        $school = $this->student->get_school_by_id($student->school_id);
        
        $this->data['student'] = $this->Subscriptions_Model->get_single_student($student_id, $school->academic_year_id);                       
        $this->data['CheckGuardian'] = $Guardianinfo[0]->guardian_id;
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
    public function get_single_student_print(){
        
        $this->load->helper('report');
        $student_id = $this->input->post('student_id');        
        $student = $this->Subscriptions_Model->get_single('students_subscription', array('id'=>$student_id));
    
        $school = $this->student->get_school_by_id($student->school_id);
        $this->data['student'] = $this->Subscriptions_Model->get_single_student($student_id, $school->academic_year_id);   
        $Guardianinfo= $this->student->get_list('students_subscription', array('id' => $student_id), '', '', '', 'id', 'ASC');
        if($Guardianinfo[0]->guardian_id=='10000'){   
            $this->data['guardian'] = $this->Subscriptions_Model->get_single_guardian_myself($student_id); 
        }else{
            $this->data['guardian'] = $this->Subscriptions_Model->get_single_guardian($this->data['student']->guardian_id);
        }
        $this->data['academic_year_id'] = $school->academic_year_id;
        $this->data['class_id'] = $this->data['student']->class_id;
        $this->data['section_id'] = $this->data['student']->section_id;
        $this->data['student_id'] = $student_id;
        $this->data['school_id'] = $student->school_id;
        $this->data['school'] = $this->student->get_single('schools', array('id'=>$student->school_id));
        echo $this->load->view('get-single-student_print', $this->data);
    }
    
    
        
    /*****************Function _prepare_subscriptions_validation**********************************
    * @type            : Function
    * @function name   : _prepare_subscriptions_validation
    * @description     : Process "Student" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_subscriptions_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        if (!$this->input->post('id')) {
            // $this->form_validation->set_rules('username', $this->lang->line('username'), 'trim|required|callback_username');
            // $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required');
            $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
            // $this->form_validation->set_rules('roll_no', $this->lang->line('roll_no'), 'trim|required');          
        }

        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|valid_email');
        $this->form_validation->set_rules('type_id', $this->lang->line('school'), 'trim|required');
        
        $this->form_validation->set_rules('admission_no', $this->lang->line('admission_no'), 'trim|required');
        $this->form_validation->set_rules('admission_date', $this->lang->line('admission_date'), 'trim|required');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required');
        $this->form_validation->set_rules('provincial_sector', $this->lang->line('provincial'). ' ' . $this->lang->line('sector'), 'trim|required');
        $this->form_validation->set_rules('date_of_national_id', $this->lang->line('date_of_national_id'), 'trim|required');
        $this->form_validation->set_rules('period', $this->lang->line('period'), 'trim|required');
        $this->form_validation->set_rules('course_id', $this->lang->line('course_id'), 'trim|required');
        $this->form_validation->set_rules('guardian_id', $this->lang->line('guardian'), 'trim|required');
        $this->form_validation->set_rules('registration_no', $this->lang->line('registration_no'), 'trim');
        // $this->form_validation->set_rules('group', $this->lang->line('group'), 'trim');
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim|required');
        $this->form_validation->set_rules('dob', $this->lang->line('birth_date'), 'trim|required');
        $this->form_validation->set_rules('gender', $this->lang->line('gender'), 'trim|required');
        $this->form_validation->set_rules('blood_group', $this->lang->line('blood_group'), 'trim');
        $this->form_validation->set_rules('present_address', $this->lang->line('present') . ' ' . $this->lang->line('address'), 'trim');
        $this->form_validation->set_rules('permanent_address', $this->lang->line('permanent') . ' ' . $this->lang->line('address'), 'trim');
        $this->form_validation->set_rules('religion', $this->lang->line('religion'), 'trim');
        $this->form_validation->set_rules('other_info', $this->lang->line('other_info'), 'trim');
        $this->form_validation->set_rules('photo', $this->lang->line('photo'), 'trim|callback_photo');
        
    }
                        
    /*****************Function username**********************************
    * @type            : Function
    * @function name   : username
    * @description     : Unique check for "Student username" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function username() {
        if ($this->input->post('id') == '') {
            $username = $this->student->duplicate_check($this->input->post('username'));
            if ($username) {
                $this->form_validation->set_message('username', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $username = $this->student->duplicate_check($this->input->post('username'), $this->input->post('id'));
            if ($username) {
                $this->form_validation->set_message('username', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
                
    /*****************Function photo**********************************
    * @type            : Function
    * @function name   : photo
    * @description     : validate student profile photo                 
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
    public function photo() {
        if ($_FILES['photo']['name']) {
            $name = $_FILES['photo']['name'];
            $arr = explode('.', $name);
            $ext = end($arr);
            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                return TRUE;
            } else {
                $this->form_validation->set_message('photo', $this->lang->line('select_valid_file_format'));
                return FALSE;
            }
        }
    }

       
    /*****************Function _get_posted_subscriptions_data**********************************
    * @type            : Function
    * @function name   : _get_posted_subscriptions_data
    * @description     : Prepare "Student" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_subscriptions_data() {

        $items = array();

        // $items[] = 'school_id';
        $items[] = 'type_id';
        // $items[] = 'admission_no';
        $items[] = 'guardian_id';
        $items[] = 'relation_with';
        $items[] = 'national_id';
        // $items[] = 'registration_no';
        $items[] = 'group';
        $items[] = 'name';
        $items[] = 'phone';
        $items[] = 'email';
        $items[] = 'provincial_sector';
        // $items[] = 'date_of_national_id';
        $items[] = 'period';
        $items[] = 'course_id';
        $items[] = 'gender';
        $items[] = 'blood_group';
        $items[] = 'present_address';
        $items[] = 'permanent_address';
        $items[] = 'religion';
        $items[] = 'caste';
        $items[] = 'discount_id';
        $items[] = 'second_language';
        $items[] = 'previous_school';
        $items[] = 'previous_class';
        $items[] = 'father_name';
        $items[] = 'father_phone';
        $items[] = 'father_education';
        $items[] = 'father_profession';
        $items[] = 'father_designation';
        $items[] = 'mother_name';
        $items[] = 'mother_phone';
        $items[] = 'mother_education';
        $items[] = 'mother_profession';
        $items[] = 'mother_designation';
        $items[] = 'health_condition';
        $items[] = 'other_info';        
        $data = elements($items, $_POST);
      $data['dob'] = date('Y-m-d', strtotime($this->input->post('dob')));
        $data['date_of_national_id'] = date('Y-m-d', strtotime($this->input->post('date_of_national_id')));
        
        $data['admission_date'] = date('Y-m-d', strtotime($this->input->post('admission_date')));
        $data['age'] = floor((time() - strtotime($data['dob'])) / 31556926);
        $data['school_id']=1;
        $school = $this->student->get_school_by_id($data['school_id']);            
        if(!$school->academic_year_id){
            error($this->lang->line('set_academic_year_for_school'));
            redirect('subscriptions/index');
        }
        
        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
                        
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['status'] = 1;
            // create user 
            $data['user_id'] = $this->student->create_user();
            $admission_nodata=$this->Subscriptions_Model->getmax_admission_no();
            $data['admission_no'] = ($this->input->post('admission_no')) ? $this->input->post('admission_no'):$admission_nodata[0]->admission_no + 1;   

            $registrationdata=$this->Subscriptions_Model->getmax_registration_no();
            $data['registration_no'] = ($this->input->post('registration_no')) ? $this->input->post('registration_no'):$registrationdata[0]->registration_no + 1;   
            
        }

        if ($_FILES['photo']['name']) {
            $data['photo'] = $this->_upload_photo();
        }
        if ($_FILES['transfer_certificate']['name']) {
            $data['transfer_certificate'] = $this->_upload_transfer_certificate();
        }
        if ($_FILES['father_photo']['name']) {
            $data['father_photo'] = $this->_upload_father_photo();
        }
        if ($_FILES['mother_photo']['name']) {
            $data['mother_photo'] = $this->_upload_mother_photo();
        }

        return $data;
    }

           
    /*****************Function _upload_photo**********************************
    * @type            : Function
    * @function name   : _upload_photo
    * @description     : process to upload student profile photo in the server                  
    *                     and return photo file name  
    * @param           : null
    * @return          : $return_photo string value 
    * ********************************************************** */
    private function _upload_photo() {

        $prev_photo = $this->input->post('prev_photo');
        $photo = $_FILES['photo']['name'];
        $photo_type = $_FILES['photo']['type'];
        $return_photo = '';
        if ($photo != "") {
            if ($photo_type == 'image/jpeg' || $photo_type == 'image/pjpeg' ||
                    $photo_type == 'image/jpg' || $photo_type == 'image/png' ||
                    $photo_type == 'image/x-png' || $photo_type == 'image/gif') {

                $destination = 'assets/uploads/student-photo/';

                $file_type = explode(".", $photo);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $photo_path = 'photo-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['photo']['tmp_name'], $destination . $photo_path);

                // need to unlink previous photo
                if ($prev_photo != "") {
                    if (file_exists($destination . $prev_photo)) {
                        @unlink($destination . $prev_photo);
                    }
                }

                $return_photo = $photo_path;
            }
        } else {
            $return_photo = $prev_photo;
        }

        return $return_photo;
    }
    
        /*****************Function _upload_transfer_certificate**********************************
    * @type            : Function
    * @function name   : _upload_transfer_certificate
    * @description     : process to upload student transfer_certificate in the server                  
    *                     and return photo file name  
    * @param           : null
    * @return          : $return_photo string value 
    * ********************************************************** */
    private function _upload_transfer_certificate() {

        $prev_transfer_certificate = $this->input->post('prev_transfer_certificate');
        $transfer_certificate = $_FILES['transfer_certificate']['name'];
        $transfer_certificate_type = $_FILES['transfer_certificate']['type'];
        $return_transfer_certificate = '';
        if ($transfer_certificate != "") {
            if ($transfer_certificate_type == 'image/jpeg' || $transfer_certificate_type == 'image/pjpeg' ||
                    $transfer_certificate_type == 'image/jpg' || $transfer_certificate_type == 'image/png' ||
                    $transfer_certificate_type == 'image/x-png' || $transfer_certificate_type == 'image/gif') {

                $destination = 'assets/uploads/transfer-certificate/';

                $file_type = explode(".", $transfer_certificate);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $transfer_certificate_path = 'tc-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['transfer_certificate']['tmp_name'], $destination . $transfer_certificate_path);

                // need to unlink previous transfer_certificate
                if ($prev_transfer_certificate != "") {
                    if (file_exists($destination . $prev_transfer_certificate)) {
                        @unlink($destination . $prev_transfer_certificate);
                    }
                }

                $return_transfer_certificate = $transfer_certificate_path;
            }
        } else {
            $return_transfer_certificate = $prev_transfer_certificate;
        }

        return $return_transfer_certificate;
    }

    
               
    /*****************Function _upload_father_photo**********************************
    * @type            : Function
    * @function name   : _upload_father_photo
    * @description     : process to upload student profile photo in the server                  
    *                     and return photo file name  
    * @param           : null
    * @return          : $return_father_photo string value 
    * ********************************************************** */
    private function _upload_father_photo() {

        $prev_father_photo = $this->input->post('prev_father_photo');
        $father_photo = $_FILES['father_photo']['name'];
        $father_photo_type = $_FILES['father_photo']['type'];
        $return_father_photo = '';
        if ($father_photo != "") {
            if ($father_photo_type == 'image/jpeg' || $father_photo_type == 'image/pjpeg' ||
                    $father_photo_type == 'image/jpg' || $father_photo_type == 'image/png' ||
                    $father_photo_type == 'image/x-png' || $father_photo_type == 'image/gif') {

                $destination = 'assets/uploads/father-photo/';

                $file_type = explode(".", $father_photo);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $father_photo_path = 'photo-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['father_photo']['tmp_name'], $destination . $father_photo_path);

                // need to unlink previous father_photo
                if ($prev_father_photo != "") {
                    if (file_exists($destination . $prev_father_photo)) {
                        @unlink($destination . $prev_father_photo);
                    }
                }

                $return_father_photo = $father_photo_path;
            }
        } else {
            $return_father_photo = $prev_father_photo;
        }

        return $return_father_photo;
    }
    
    
    
               
    /*****************Function _upload_mother_photo**********************************
    * @type            : Function
    * @function name   : _upload_mother_photo
    * @description     : process to upload mother profile photo in the server                  
    *                     and return photo file name  
    * @param           : null
    * @return          : $return_mother_photo string value 
    * ********************************************************** */
    private function _upload_mother_photo() {

        $prev_mother_photo = $this->input->post('prev_mother_photo');
        $mother_photo = $_FILES['mother_photo']['name'];
        $mother_photo_type = $_FILES['mother_photo']['type'];
        $return_mother_photo = '';
        if ($mother_photo != "") {
            if ($mother_photo_type == 'image/jpeg' || $mother_photo_type == 'image/pjpeg' ||
                    $mother_photo_type == 'image/jpg' || $mother_photo_type == 'image/png' ||
                    $mother_photo_type == 'image/x-png' || $mother_photo_type == 'image/gif') {

                $destination = 'assets/uploads/mother-photo/';

                $file_type = explode(".", $mother_photo);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $mother_photo_path = 'photo-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['mother_photo']['tmp_name'], $destination . $mother_photo_path);

                // need to unlink previous mother_photo
                if ($prev_mother_photo != "") {
                    if (file_exists($destination . $prev_mother_photo)) {
                        @unlink($destination . $prev_mother_photo);
                    }
                }

                $return_mother_photo = $mother_photo_path;
            }
        } else {
            $return_mother_photo = $prev_mother_photo;
        }

        return $return_mother_photo;
    }
    

        
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Student" data from database                  
    *                     also delete all relational data
    *                     and unlink student photo from server   
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
              redirect('subscriptions/index');
        }
        
        $student = $this->student->get_single('students', array('id' => $id));
        if (!empty($student)) {

            // delete student data
            $this->student->delete('students', array('id' => $id));

            // delete student login data
            $this->student->delete('users', array('id' => $student->user_id));

            // delete student enrollments
            $this->student->delete('enrollments', array('student_id' => $student->id));

            // delete student hostel_members
            $this->student->delete('hostel_members', array('user_id' => $student->user_id));

            // delete student transport_members
            $this->student->delete('transport_members', array('user_id' => $student->user_id));

            // delete student library_members
            $this->student->delete('library_members', array('user_id' => $student->user_id));

            // delete student resume and photo
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/student-photo/' . $student->photo)) {
                @unlink($destination . '/student-photo/' . $student->photo);
            }

            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('student/subscriptions/index/');
    }

        
    /*****************Function __insert_enrollment**********************************
    * @type            : Function
    * @function name   : __insert_enrollment
    * @description     : save student info to enrollment while create a new student                  
    * @param           : $insert_id integer value
    * @return          : null 
    * ********************************************************** */
    private function __insert_enrollment($insert_id) {
        $data = array();        
        $school = $this->student->get_school_by_id(1);        
        $data['student_id'] = $insert_id;
        $data['school_id'] = 1;
        $data['class_id'] = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        if(!$this->input->post('id')){
            $rolldata=$this->Subscriptions_Model->getmax_roll_no();
            $data['roll_no'] = ($this->input->post('roll_no')) ? $this->input->post('roll_no'):$rolldata[0]->roll_no + 1;     
        }
        $data['academic_year_id'] = $school->academic_year_id;          
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = logged_in_user_id();
        $data['status'] = 1;
        $this->db->insert('enrollments_subscription', $data);
    }

    /*****************Function __update_enrollment**********************************
    * @type            : Function
    * @function name   : __update_enrollment
    * @description     : update student info to enrollment while update a student                  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function __update_enrollment() {

        $school = $this->student->get_school_by_id(1);
         
        $data = array();
        $data['school_id'] = 1;
        $data['class_id'] = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['roll_no'] = $this->input->post('roll_no');
        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();
        // $this->db->where('student_id', $this->input->post('id'));
        // $this->db->where('academic_year_id', $school->academic_year_id);
        
        $condition = array();
        $condition['student_id'] = $this->input->post('id');
        $condition['academic_year_id'] = $school->academic_year_id;

        $this->db->update('enrollments_subscription', $data, $condition);
               
    }

}