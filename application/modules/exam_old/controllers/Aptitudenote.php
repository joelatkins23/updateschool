<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Examresult.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Examresult
 * @description     : Manage exam term result and prepare promotion to next class.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Aptitudenote extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Examresult_Model', 'result', true);
        $this->load->model('Aptitudenote_Model');        
    }

    
        
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Exam result sheet" user interface                 
    *                    with class/section wise filtering option    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {

        check_permission(VIEW);
        $school_id=1;
        if ($_POST) {

            $exam_id = $this->input->post('exam_id'); 
            $course_id = $this->input->post('course_id');           
            $school = $this->result->get_school_by_id($school_id);            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/aptitudenote');
            }            
            $this->data['students'] = $this->Aptitudenote_Model->get_student_list($school_id,$school->academic_year_id,$student_id,$exam_id,$course_id);
            // print(json_decode($this->data['students']));
            $this->data['grades'] = $this->result->get_list('grades', array('status' => 1, 'school_id'=>$school_id), '', '', '', 'id', 'ASC');
            $this->data['exam'] =  $this->result->get_single('exams', array('id'=>$exam_id, 'school_id'=>$school_id));
            $this->data['school_id'] = $school_id;
            $this->data['exam_id'] = $exam_id;
            $this->data['course_id'] = $course_id;
            $this->data['academic_year_id'] = $school->academic_year_id;
            
            $class = $this->result->get_single('classes', array('school_id'=>$school_id));
            create_log('Has been process exam result for class: '. $class->name);
            $this->data['report'] = TRUE;
            $this->data['school']=$this->result->get_list('schools', array('id'=>$school_id), '','', '', 'id', 'ASC');
            $this->data['alldata'] = $this->Aptitudenote_Model->get_exam_history($school_id, $school->academic_year_id, $exam_id,$course_id);
        }
        $this->data['courses']=$this->result->get_list('courses', array('school_id'=>$school_id), '','', '', 'id', 'ASC');
        $condition = array();
        $condition['status'] = 1;          
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $school = $this->result->get_school_by_id($this->session->userdata('school_id'));
            $condition['school_id'] = $this->session->userdata('school_id');
            
            // $this->data['classes'] = $this->result->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $condition['academic_year_id'] = $school->academic_year_id;
            $this->data['exams'] = $this->result->get_list('exams', $condition, '', '', '', 'id', 'ASC');
        }

        $this->layout->title($this->lang->line('aptitude') . ' ' . $this->lang->line('note') . ' | ' . SMS);
        $this->layout->view('aptitude_note/index', $this->data);
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
        $school_id=1;
        if ($_POST) {            
            $exam_id = $this->input->post('exam_id');
            $course_id = $this->input->post('course_id');
            $school = $this->result->get_school_by_id($school_id);
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/aptitudenote');
            }
            
            $condition = array(
                'school_id' => $school_id,    
                'academic_year_id' => $school->academic_year_id,
            );           
         
            $data = $condition;            
            if (!empty($_POST['students'])) {

                $this->data['report'] = TRUE;
                $this->data['school']=$this->result->get_list('schools', array('id'=>$school_id), '','', '', 'id', 'ASC');
                $this->data['academic_year'] = $this->db->get_where('academic_years', array('id'=>$school->academic_year_id))->row()->session_year;
                foreach ($_POST['students'] as $key => $value) {            
                    $student_id=$value;
                    $studentinfo = $this->Aptitudenote_Model->get_student_list($school_id,$school->academic_year_id, $student_id, $exam_id,$course_id);
                    $item['school_id']=$school_id;
                    $item['exam_id']=$exam_id;
                    $item['class_id']=$studentinfo[0]->class_id;
                    $item['section_id']=$studentinfo[0]->section_id;
                    $item['academic_year_id']=$school->academic_year_id;
                    $item['student_id']=$studentinfo[0]->id;
                    $item['avg_grade_point']=$_POST['avg_grade_point'][$value];
                    $item['grade_id']=$_POST['grade_id'][$value];
                    $item['result_status']=($_POST['avg_grade_point'][$value]>=10)? 'Approved' : 'No Approved';
                    $item['remark']=$_POST['remark'][$value];
                    $item['status']=1;
                    $item['created_at']=date('Y-m-d H:i:s');
                    $item['created_by']=logged_in_user_id();
                    $this->result->insert('exam_history', $item);                    
                    success($this->lang->line('insert_success'));
                }  
                $this->data['students'] = $this->Aptitudenote_Model->get_student_list($school_id, $school->academic_year_id, "",$exam_id,$course_id);       
            }
            
        }
            $this->data['alldata'] = $this->Aptitudenote_Model->get_exam_history($school_id, $school->academic_year_id, $exam_id,$course_id);
            
            $this->data['grades'] = $this->result->get_list('grades', array('status' => 1, 'school_id'=>$school_id), '', '', '', 'id', 'ASC');
            $this->data['exam'] =  $this->result->get_single('exams', array('id'=>$exam_id, 'school_id'=>$school_id));
            $this->data['school_id'] = $school_id;
            $this->data['exam_id'] = $exam_id;
            $this->data['course_id'] = $course_id;
            $this->data['academic_year_id'] = $school->academic_year_id;
            
            $condition1 = array();
            $condition1['status'] = 1;
            if($this->session->userdata('role_id') != SUPER_ADMIN){
                $school = $this->result->get_school_by_id($this->session->userdata('school_id'));
                $condition1['school_id'] = $this->session->userdata('school_id');
                
                $this->data['classes'] = $this->result->get_list('classes', $condition1, '','', '', 'id', 'ASC');
                $condition1['academic_year_id'] = $school->academic_year_id;
                $this->data['exams'] = $this->result->get_list('exams', $condition1, '', '', '', 'id', 'ASC');
            }

            $this->layout->title($this->lang->line('aptitude') . ' ' . $this->lang->line('note') . ' | ' . SMS);
            $this->layout->view('aptitude_note/index', $this->data);
    }
    public function report() {
        $data=$this->input->post('data');
        $exam_id = $this->input->post('exam_id');
        $school_id=1;
        $school = $this->result->get_school_by_id($school_id);            
        $this->data['school']=$this->result->get_list('schools', array('id'=>$school_id), '','', '', 'id', 'ASC');
        $this->data['academic_year'] = $this->db->get_where('academic_years', array('id'=>$school->academic_year_id))->row()->session_year;
        $array=json_decode($data, true);
        $this->data['data']=array();
        foreach ($array['students'] as $key => $value) {            
            $student_id=$value;
            $studentinfo = $this->Aptitudenote_Model->get_student_list($school_id, $school->academic_year_id, $student_id);
            $item['name']=$studentinfo[0]->name;
            $item['student_id']=$value;
            $item['course']=$studentinfo[0]->course_name;
            $item['grade']=$array['avg_grade_point'][$value];
            $item['grade_id']=$array['grade_id'][$value];
            $item['exam_id']= $exam_id;
            $item['status']= ($array['avg_grade_point'][$value]>=10)? 'Approved' : 'No Approved';
            array_push($this->data['data'],$item);
        }
        echo $this->load->view('aptitude_note/report',$this->data);
    }
    public function student_add() {
        $student_id = $this->input->post("student_id");
        $student_insertid=$this->Aptitudenote_Model->student_insertid($student_id);
        $this->result->delete('students_subscription', array('id' => $student_id));
        $school = $this->result->get_school_by_id($school_id);
        $enrollmentsinfo = $this->result->get_list('enrollments_subscription', array('student_id' => $student_id), '', '', '', 'id', 'ASC');
        $insertdata['school_id']=$enrollmentsinfo[0]->school_id;
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
        $this->result->insert('enrollments', $insertdata);
        $this->result->delete('enrollments_subscription', array('student_id' => $student_id));
        $this->result->update('student_payment', array('student_id' => $student_insertid,'student_type' => 'admitted'), array('student_id' => $student_id));
        $data['school_id'] = 1;
        $data['student_id'] = $this->input->post("student_id");
        $data['exam_id'] = $this->input->post("student_id");
        $data['avg_grade_point'] = $this->input->post("student_id");
        $data['grade_id'] = $this->input->post("student_id");
        $data['remark'] = $this->input->post("student_id");                      
        $data['academic_year_id'] = $school->academic_year_id;
        $data['status'] = 1;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = logged_in_user_id();
        $this->result->insert('exam_results', $data);
        echo $student_insertid;  
    }
}
