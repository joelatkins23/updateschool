<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Year.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Year
 * @description     : Manage academic year.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Course extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
         $this->load->model('Year_Model', 'year', true);
         $this->load->model('Course_Model');
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Academic Year List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
      /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Teacher List" user interface                 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {

        check_permission(VIEW);

        $this->data['courses'] = $this->Course_Model->get_course_list(1);
        // print(json_encode($this->data['courses']));
        // $this->data['roles'] = $this->year->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
       
        $this->data['filter_school_id'] = 1;
        // $this->data['schools'] = $this->schools;
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage'). '  '. $this->lang->line('course'). ' | '. SMS);
        $this->layout->view('course/index', $this->data);    
  
    }
  /*****************Function course_add**********************************
    * @Type            : Function
    * @function name   : add
    * @description     : Load "Add new course" user interface                 
    *                    and process to store "courses" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    
    public function add() {
       
        check_permission(ADD);
        if ($_POST) {
            $this->_prepare_course_validation();
            // if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_course_data(); 
                $insert_id = $this->Course_Model->insert($data);
                if ($insert_id) {
                    success($this->lang->line('insert_success'));
                    redirect('administrator/course');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('administrator/course/add');
                }               
            } else {
                $this->data['post'] = $_POST;
            }
       

        $this->data['courses'] = $this->Course_Model->get_course_list();      
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = 1;        
        }        
        // $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' ' . $this->lang->line('course'). ' | ' . SMS);
        $this->layout->view('course/index', $this->data);
    }
    public function edit($id = null) {       
       
        check_permission(EDIT);
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
           redirect('administrator/course');  
        }
        
        if ($_POST) {
            $this->_prepare_course_validation();
           
               
                $data = $this->_get_posted_course_data();
                $updated = $this->Course_Model->update($data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a class :'.$data['name']);
                    
                    success($this->lang->line('update_success'));
                    redirect('administrator/course');                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('administrator/course/edit' . $this->input->post('id'));
                }
        }
        if ($id) {
            $this->data['course'] = $this->Course_Model->get_single(array('id' => $id));
            
            if (!$this->data['course']) {
                 redirect('administrator/course');
            }
        }

        $this->data['courses'] = $this->Course_Model->get_course_list($this->data['course']->school_id);   
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');        
        } 
        
        $this->data['school_id'] = $this->data['course']->school_id;
        $this->data['filter_school_id'] = $this->data['course']->school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;       
        $this->layout->title($this->lang->line('edit'). ' ' . $this->lang->line('course'). ' | ' . SMS);
        $this->layout->view('course/index', $this->data);
    }
    public function delete($id = null) {
        
        check_permission(DELETE);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('administrator/course');    
        }
        
        $course = $this->Course_Model->get_single(array('id' => $id));
        // print(json_encode($course));
        if ($this->Course_Model->delete(array('id' => $id))) {

            create_log('Has been deleted a class : '. $course->name);            
            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('administrator/course');
    }
    private function _prepare_course_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('mulct', $this->lang->line('mulct'), 'trim|required|callback_name');  
        $this->form_validation->set_rules('available_vacancies', $this->lang->line('available_vacancies'), 'trim|required|callback_name');  
        $this->form_validation->set_rules('course_fee', $this->lang->line('course') . ' ' . $this->lang->line('fee'), 'trim|required|callback_name');     
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|callback_name');
    }
       
           
  
    private function _get_posted_course_data() {
        $items = array();
        $items[] = 'name';      
        $items[] = 'course_fee';
        $items[] = 'mulct';
        $items[] = 'available_vacancies';        
        $items[] = 'note';
        $data = elements($items, $_POST);        
        $data['school_id']=1;
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
}
