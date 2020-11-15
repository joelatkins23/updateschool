<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Teacher.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Teacher
 * @description     : Manage teacers information of the school.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Course extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        // $this->load->model('Teacher_Model', 'teacher', true);
        $this->load->library('form_validation');
        $this->load->model('Course_Model', 'course', true);
        
    }

        
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Teacher List" user interface                 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {

        check_permission(VIEW);

        $this->data['teachers'] = $this->teacher->get_teacher_list($school_id);
        $this->data['roles'] = $this->teacher->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            
            $condition = array();
            $condition['status'] = 1;
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['grades'] = $this->teacher->get_list('salary_grades', $condition, '', '', '', 'id', 'ASC');
        }
        
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('course') . ' | ' . SMS);
        $this->layout->view('teacher/course', $this->data);
    }

    
    public function course_add() {
       
        check_permission(ADD);
        if ($_POST) {
            $this->_prepare_course_validation();
            // print("adsasdasdas");
            // if ($this->form_validation->run() === TRUE) {
            //     print("bbbbbbbbbbbbbb");
                $data = $this->_get_posted_course_data(); 
                print(json_encode($data));              
                $insert_id = $this->course->insert('courses', $data);
                print(json_encode($insert_id));
                // if ($insert_id) {                    
                //     create_log('Has been created a Course :'.$data['name']);                    
                //     success($this->lang->line('insert_success'));
                //     $this->__create_default_section($insert_id);
                //     redirect('teacher/course');
                // } else {
                //     error($this->lang->line('insert_failed'));
                //     redirect('teacher/course_add');
                // }
            // } else {
            //     print("flase");
            //     $this->data['post'] = $_POST;
            // }
        }

        // $this->data['classes'] = $this->classes->get_class_list();      
        
        // $condition = array();
        // $condition['status'] = 1;        
        // if($this->session->userdata('role_id') != SUPER_ADMIN){            
        //     $condition['school_id'] = $this->session->userdata('school_id');        
        //     $this->data['teachers'] = $this->classes->get_list('teachers', $condition, '','', '', 'id', 'ASC');
        // }        
        // $this->data['schools'] = $this->schools;
        
        // $this->data['add'] = TRUE;
        // $this->layout->title($this->lang->line('add'). ' ' . $this->lang->line('course'). ' | ' . SMS);
        // $this->layout->view('teacher/course', $this->data);
    }
    private function _prepare_course_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school'), 'trim|required');   
        $this->form_validation->set_rules('mulct', $this->lang->line('mulct'), 'trim|required|callback_name');  
        $this->form_validation->set_rules('available_vacancies', $this->lang->line('available_vacancies'), 'trim|required|callback_name');  
        $this->form_validation->set_rules('course_fee', $this->lang->line('course') . ' ' . $this->lang->line('fee'), 'trim|required|callback_name');     
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|callback_name');
    }
    private function _get_posted_course_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'name';      
        $items[] = 'course_fee';
        $items[] = 'mulct';
        $items[] = 'available_vacancies';        
        $items[] = 'note';
        $data = elements($items, $_POST);        
        
        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
                       
        }

        return $data;
    }
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Teacer" user interface                 
    *                    and process to store "Teacer" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_teacher_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_teacher_data();

                $insert_id = $this->teacher->insert('teachers', $data);
                if ($insert_id) {
                    success($this->lang->line('insert_success'));
                    redirect('teacher/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('teacher/add');
                }
            } else {
                $this->data['post'] = $_POST;
            }
        }

        $this->data['teachers'] = $this->teacher->get_teacher_list();
        $this->data['roles'] = $this->teacher->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');

        if($this->session->userdata('role_id') != SUPER_ADMIN){
            
            $condition = array();
            $condition['status'] = 1;
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['grades'] = $this->teacher->get_list('salary_grades', $condition, '', '', '', 'id', 'ASC');
        }
        
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' ' . $this->lang->line('teacher') . ' | ' . SMS);
        $this->layout->view('teacher/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Teacer" user interface                 
    *                    with populate "Teacher" data/value 
    *                    and process to update "Teacher" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_teacher_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_teacher_data();
                $updated = $this->teacher->update('teachers', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    success($this->lang->line('update_success'));
                    redirect('teacher/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('teacher/edit/' . $this->input->post('id'));
                }
            } else {
                
                $this->data['teacher'] = $this->teacher->get_single_teacher($this->input->post('id'));
            }
        }

        if ($id) {
            $this->data['teacher'] = $this->teacher->get_single_teacher($id);

            if (!$this->data['teacher']) {
                redirect('teacher/index');
            }
        }

        $this->data['teachers'] = $this->teacher->get_teacher_list($this->data['teacher']->school_id);
        $this->data['roles'] = $this->teacher->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
         
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            
            $condition = array();
            $condition['status'] = 1;
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['grades'] = $this->teacher->get_list('salary_grades', $condition, '', '', '', 'id', 'ASC');
        }
        
        $this->data['school_id'] = $this->data['teacher']->school_id;
        $this->data['filter_school_id'] = $this->data['teacher']->school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' ' . $this->lang->line('teacher') . ' | ' . SMS);
        $this->layout->view('teacher/index', $this->data);
    }

        
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific Teacher data                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($id = null) {

        check_permission(VIEW);

        $this->data['teachers'] = $this->teacher->get_teacher_list();
        $this->data['roles'] = $this->teacher->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        $this->data['teacher'] = $this->teacher->get_single_teacher($id);

        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition = array();
            $condition['status'] = 1;
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['grades'] = $this->teacher->get_list('salary_grades', $condition, '', '', '', 'id', 'ASC');
        }
        
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('view') . ' ' . $this->lang->line('teacher') . ' | ' . SMS);
        $this->layout->view('teacher/index', $this->data);
    }

    
            
        
     /*****************Function get_single_teacher**********************************
     * @type            : Function
     * @function name   : get_single_teacher
     * @description     : "Load single teacher information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_teacher(){
        
       $teacher_id = $this->input->post('teacher_id');
       
       $this->data['teacher'] = $this->teacher->get_single_teacher($teacher_id);
       echo $this->load->view('teacher/get-single-teacher', $this->data);
    }
    
        
    /*****************Function _prepare_teacher_validation**********************************
    * @type            : Function
    * @function name   : _prepare_teacher_validation
    * @description     : Process "Teacher" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_teacher_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        if (!$this->input->post('id')) {   
            $this->form_validation->set_rules('username', $this->lang->line('username'), 'trim|required|callback_username');
            $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required');
        }
        
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|valid_email');
        $this->form_validation->set_rules('role_id', $this->lang->line('role'), 'trim|required');
        $this->form_validation->set_rules('school_id', $this->lang->line('school'), 'trim|required');

        $this->form_validation->set_rules('responsibility', $this->lang->line('responsibility'), 'trim|required');
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim|required');
        $this->form_validation->set_rules('present_address', $this->lang->line('present') . ' ' . $this->lang->line('address'), 'trim');
        $this->form_validation->set_rules('permanent_address', $this->lang->line('permanent') . ' ' . $this->lang->line('address'), 'trim');
        $this->form_validation->set_rules('gender', $this->lang->line('gender'), 'trim|required');
        $this->form_validation->set_rules('blood_group', $this->lang->line('blood_group'), 'trim');
        $this->form_validation->set_rules('religion', $this->lang->line('religion'), 'trim');
        $this->form_validation->set_rules('dob', $this->lang->line('birth_date'), 'trim|required');
        $this->form_validation->set_rules('joining_date', $this->lang->line('join_date'), 'trim|required');
        $this->form_validation->set_rules('salary_grade_id', $this->lang->line('salary_grade'), 'trim|required');
        $this->form_validation->set_rules('salary_type', $this->lang->line('salary_type'), 'trim|required');
        $this->form_validation->set_rules('facebook_url', $this->lang->line('facebook_url'), 'trim');
        $this->form_validation->set_rules('linkedin_url', $this->lang->line('linkedin_url'), 'trim');
        $this->form_validation->set_rules('google_plus_url', $this->lang->line('google_plus_url'), 'trim');
        $this->form_validation->set_rules('instagram_url', $this->lang->line('instagram_url'), 'trim');
        $this->form_validation->set_rules('pinterest_url', $this->lang->line('pinterest_url'), 'trim');
        $this->form_validation->set_rules('twitter_url', $this->lang->line('twitter_url'), 'trim');
        $this->form_validation->set_rules('youtube_url', $this->lang->line('youtube_url'), 'trim');
        $this->form_validation->set_rules('other_info', $this->lang->line('other_info'), 'trim');
    }

        
                    
    /*****************Function username**********************************
    * @type            : Function
    * @function name   : username
    * @description     : Unique check for "Teacher username" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function username() {
        if ($this->input->post('id') == '') {
            $username = $this->teacher->duplicate_check($this->input->post('username'));
            if ($username) {
                $this->form_validation->set_message('username', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $username = $this->teacher->duplicate_check($this->input->post('username'), $this->input->post('id'));
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
   
    /*****************Function _get_posted_teacher_data**********************************
    * @type            : Function
    * @function name   : _get_posted_teacher_data
    * @description     : Prepare "Teacher" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_teacher_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'name';
        $items[] = 'email';
        $items[] = 'national_id';
        $items[] = 'responsibility';
        $items[] = 'phone';
        $items[] = 'present_address';
        $items[] = 'permanent_address';
        $items[] = 'gender';
        $items[] = 'blood_group';
        $items[] = 'religion';
        $items[] = 'other_info';
        $items[] = 'salary_grade_id';
        $items[] = 'salary_type';
        $items[] = 'facebook_url';
        $items[] = 'linkedin_url';
        $items[] = 'google_plus_url';
        $items[] = 'instagram_url';
        $items[] = 'pinterest_url';
        $items[] = 'twitter_url';
        $items[] = 'youtube_url';
        $items[] = 'is_view_on_web';
        
        $data = elements($items, $_POST);

        $data['dob'] = date('Y-m-d', strtotime($this->input->post('dob')));
        $data['joining_date'] = date('Y-m-d', strtotime($this->input->post('joining_date')));

        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['status'] = 1;
            // create user 
            $data['user_id'] = $this->teacher->create_user();
            
        }

        if($_FILES['photo']['name']) {
            $data['photo'] = $this->_upload_photo();
        }
        if($_FILES['resume']['name']) {
            $data['resume'] = $this->_upload_resume();
        }  
      
        return $data;
    }

       
    /*****************Function _upload_photo**********************************
    * @type            : Function
    * @function name   : _upload_photo
    * @description     : process to upload teacher profile photo in the server                  
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

                $destination = 'assets/uploads/teacher-photo/';

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
    
           
    /*****************Function _upload_resume**********************************
    * @type            : Function
    * @function name   : _upload_resume
    * @description     : process to upload teacher profile resume in the server                  
    *                     and return resume file name  
    * @param           : null
    * @return          : $return_resume string value 
    * ********************************************************** */
    private function _upload_resume() {
        $prev_resume = $this->input->post('prev_resume');
        $resume = $_FILES['resume']['name'];
        $resume_type = $_FILES['resume']['type'];
        $return_resume = '';

        if ($resume != "") {
            if ($resume_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
                    $resume_type == 'application/msword' || $resume_type == 'text/plain' ||
                    $resume_type == 'application/vnd.ms-office' || $resume_type == 'application/pdf') {

                $destination = 'assets/uploads/teacher-resume/';

                $file_type = explode(".", $resume);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $resume_path = 'resume-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['resume']['tmp_name'], $destination . $resume_path);

                // need to unlink previous photo
                if ($prev_resume != "") {
                    if (file_exists($destination . $prev_resume)) {
                        @unlink($destination . $prev_resume);
                    }
                }

                $return_resume = $resume_path;
            }
        } else {
            $return_resume = $prev_resume;
        }

        return $return_resume;
    }

    
        
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Teacher" data from database                  
    *                    also unlink teacher profile photo & resume from server   
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('teacher');       
        }
        
        $teacher = $this->teacher->get_single('teachers', array('id' => $id));
        if (!empty($teacher)) {

            // delete teacher data
            $this->teacher->delete('teachers', array('id' => $id));
            // delete teacher login data
            $this->teacher->delete('users', array('id' => $teacher->user_id));

            // delete teacher resume and photo
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/teacher-resume/' . $teacher->resume)) {
                @unlink($destination . '/teacher-resume/' . $teacher->resume);
            }
            if (file_exists($destination . '/teacher-photo/' . $teacher->photo)) {
                @unlink($destination . '/teacher-photo/' . $teacher->photo);
            }

            success($this->lang->line('delete_success'));
            redirect('teacher/index/'.$teacher->school_id);
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('teacher/index');
    }

}
