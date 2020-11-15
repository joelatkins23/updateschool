<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Finalresult.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Finalresult
 * @description     : Manage exam final result and prepare promotion to next class.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Finalresult extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Finalresult_Model', 'result', true);
    }

    
        
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Exam final result sheet" user interface                 
    *                    with class/section wise filtering option    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {

        check_permission(VIEW);
        
        $final_result_type = '';
        
        if ($_POST) {

            $school_id = 1;
            $exam_id = $this->input->post('exam_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');

            $school = $this->result->get_school_by_id($school_id);
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/finalresult');
            }
            
            $final_result_type = $school->final_result_type;
            
            $this->data['students'] = $this->result->get_student_list($school_id, $class_id, $section_id, $school->academic_year_id);

                       
            $condition = array(       
                'school_id' => $school_id,
                'class_id' => $class_id,
                'academic_year_id' => $school->academic_year_id
            );
            if($section_id){
                $condition['section_id'] = $section_id;
            }
            
            $data = $condition;
            
            if (!empty($this->data['students'])) {

                foreach ($this->data['students'] as $obj) {

                    $condition['student_id'] = $obj->id;
                    $result = $this->result->get_single('final_results', $condition);

                    if (empty($result)) {
                        $data['school_id'] = $school_id;
                        $data['student_id'] = $obj->id;
                        $data['class_id'] = $class_id;
                        $data['section_id'] = $obj->section_id;
                        $data['academic_year_id'] = $school->academic_year_id;
                        $data['status'] = 1;
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['created_by'] = logged_in_user_id();
                        $this->result->insert('final_results', $data);
                    }
                }
            }

            if($exam_id){
                $this->data['exams'] = $this->result->get_single('exams', array('id'=>$exam_id, 'status' => 1, 'school_id'=>$school_id, 'academic_year_id'=> $school->academic_year_id));
            }else{
                $this->data['exams'] = $this->result->get_list('exams', array('status' => 1, 'school_id'=>$school_id), '', '', '', 'id', 'ASC');
            }
            
            $this->data['grades'] = $this->result->get_list('grades', array('status' => 1, 'school_id'=>$school_id), '', '', '', 'id', 'ASC');
            
            $this->data['school_id'] = $school_id;
            $this->data['exam_id'] = $exam_id;
            $this->data['class_id'] = $class_id;
            $this->data['section_id'] = $section_id;
            $this->data['academic_year_id'] = $school->academic_year_id;;
            
            $class = $this->result->get_single('classes', array('id'=>$class_id));
            create_log('Has been process exam final result for class: '. $class->name);
        }
     
        $condition = array();
        $condition['status'] = 1;  
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $school = $this->result->get_school_by_id($this->session->userdata('school_id'));
            $condition['school_id'] = $this->session->userdata('school_id');
            
            $this->data['classes'] = $this->result->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $condition['academic_year_id'] = $school->academic_year_id;
            $this->data['exams'] = $this->result->get_list('exams', $condition, '', '', '', 'id', 'ASC');
        }
        

        // this is for which school result based on final exam
        
        $this->layout->title($this->lang->line('exam') . ' ' . $this->lang->line('result') . ' | ' . SMS);
        
        if($final_result_type){
            $this->layout->view('final_result/final_exam', $this->data);
        }else{
            $this->layout->view('final_result/avg_all_exam', $this->data);
        }        
    }

    
    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Process exam result and save into database                  
    *                    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');

            $school = $this->result->get_school_by_id($school_id);
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/finalresult');
            }
            
            $condition = array(
                'school_id' => $school_id,
                'class_id' => $class_id,               
                'academic_year_id' => $school->academic_year_id,
            );
            
            if($section_id){
                $condition['section_id'] = $section_id;
            }
            
            $data = $condition;

            if (count($_POST['students']) > 0) {

                foreach ($_POST['students'] as $key => $value) {

                    $condition['student_id'] = $value;
                    
                    $data['total_subject'] = $_POST['total_subject'][$value];
                    $data['total_mark'] = $_POST['total_mark'][$value];
                    $data['total_obtain_mark'] = $_POST['total_obtain_mark'][$value];
                    $data['avg_grade_point'] = $_POST['avg_grade_point'][$value];
                    $data['grade_id'] = $_POST['grade_id'][$value];
                    $data['remark'] = $_POST['remark'][$value];
                    $data['status'] = 1;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['created_by'] = logged_in_user_id();
                    
                    // process result status
                    $grade = $this->result->get_single('grades', array('id'=>$data['grade_id']));
                    if($grade->point <= 0){                        
                        $data['result_status'] = 'failed';
                    }else{
                        $data['result_status'] = 'passed'; 
                    }
                    
                    $this->result->update('final_results', $data, $condition);
                }
            }
            
            success($this->lang->line('insert_success'));
            $class = $this->result->get_single('classes', array('id'=>$class_id));
            create_log('Has been process and save exam final result for class: '. $class->name);
        }
        
       redirect('exam/finalresult');
    }

}
