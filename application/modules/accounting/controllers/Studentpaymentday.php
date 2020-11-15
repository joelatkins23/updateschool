<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Feetype.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Feetype
 * @description     : Manage all Feetype as per accounting term.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Studentpaymentday extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
         $this->load->model('Feetype_Model', 'feetype', true);  
         $this->load->model('Studentpayment_Model');  
         $this->load->model('Studentpaymentday_Model');  
         
    }


    public function index($school_id = null) {
        
        check_permission(VIEW);
        
        $condition = array();
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['classes'] = $this->feetype->get_list('classes', $condition, '', '', '', 'id', 'ASC');  
        }
        if ($_POST) {
            $data['student_id']=split('_',$this->input->post('student_id'))[0];
            $data['student_type']=split('_',$this->input->post('student_id'))[1];
            $studentdata=$this->Studentpaymentday_Model->get_student($data['student_id'],$data['student_type']);
            $start_date = $this->input->post('start_date'); 
            $end_date = $this->input->post('end_date'); 
            $this->data['all_student_payment']=$this->Studentpaymentday_Model->all_payment_student($data['student_id'], $data['student_type'], $start_date,$end_date);
            $this->data['student_id']=$this->input->post('student_id');
            if($this->input->post('student_id')=="999999"){
                $this->data['student_name']="All Students";
            }else{
                $this->data['student_name']=$studentdata[0]->name;
            }
            $this->data['start_date']=$start_date;
            $this->data['end_date']=$end_date;          
            $this->data['schoolinfo']=$this->feetype->get_list('schools', array('id' => '1'), '', '', '', 'id', 'ASC');
        }   
        $this->data['studentlist']=$this->Studentpayment_Model->get_alllist();
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('payment').' '.$this->lang->line('list'). ' '.$this->lang->line('by'). ' '.$this->lang->line('student'). ' | ' . SMS);
        $this->layout->view('studentpaymentday/index', $this->data);            
       
    }
    

    public function view() {
        check_permission(VIEW); 
        $id= $this->input->get('id');
        $start_date = $this->input->get('f'); 
        $end_date = $this->input->get('t'); 
        $this->data['start_date']=$start_date;
        $this->data['end_date']=$end_date;
        $paymentinfo=$this->feetype->get_list('student_payment', array('id' => $id), '', '', '', 'id', 'ASC');
        $this->data['studentinfo']=$this->Studentpayment_Model->studentinfo($id, $paymentinfo[0]->student_type);
        $this->data['student_name']=$this->data['studentinfo'][0]->student_name;
        $student_id=$paymentinfo[0]->student_id.'_'.$paymentinfo[0]->student_type;
        $this->data['student_id']=$student_id;
        $student_type=$paymentinfo[0]->student_type;
        $user=$this->Studentpayment_Model->operationinfo($paymentinfo[0]->created_by);
        $this->data['operationinfo']=$user[0]->username;
        $this->data['schoolinfo']=$this->feetype->get_list('schools', array('id' => '1'), '', '', '', 'id', 'ASC');
        $this->data['viewdata']=$this->Studentpayment_Model->viewdata($id);
        $this->data['studentlist']=$this->Studentpayment_Model->get_alllist(); 
        $this->data['id']=$id;
        $this->data['all_student_payment']=$this->Studentpaymentday_Model->all_payment_student($student_id, $student_type, $start_date,$end_date);
        $this->data['view'] = TRUE;
        $this->layout->title($this->lang->line('print').' '.$this->lang->line('payment'). ' | ' . SMS);
        $this->layout->view('studentpaymentday/index', $this->data);        
    }
 
   
    
    

   
    
    /*****************Function delete**********************************
     * @type            : Function
     * @function name   : delete
     * @description     : delete "Income head" from database                  
     *                       
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function delete() {
        $id= $this->input->get('id');
        $start_date = $this->input->get('f'); 
        $end_date = $this->input->get('t'); 
        $this->data['start_date']=$start_date;
        $this->data['end_date']=$end_date;
        $paymentinfo=$this->feetype->get_list('student_payment', array('id' => $id), '', '', '', 'id', 'ASC');
        $this->data['studentinfo']=$this->Studentpayment_Model->studentinfo($id, $paymentinfo[0]->student_type);
        $this->data['student_name']=$this->data['studentinfo'][0]->student_name;
        $student_id=$paymentinfo[0]->student_id.'_'.$paymentinfo[0]->student_type;
        $this->data['student_id']=$student_id;
        
        $student_type=$paymentinfo[0]->student_type;
        $user=$this->Studentpayment_Model->operationinfo($paymentinfo[0]->created_by);
        $this->data['operationinfo']=$user[0]->username;
        $this->data['schoolinfo']=$this->feetype->get_list('schools', array('id' => '1'), '', '', '', 'id', 'ASC');
        check_permission(DELETE);
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('accounting/studentpayment/index');   
        }
        if($id){
            $this->feetype->delete('student_payment', array('id' => $id));
            $this->feetype->delete('student_payment_details', array('studentpayment_id' => $id));            
            create_log('Has been deleted a student payment : ');            
            success($this->lang->line('delete_success'));
        }
        
        $this->data['list'] = TRUE;
        $this->data['studentlist']=$this->Studentpayment_Model->get_alllist(); 
        $this->data['all_student_payment']=$this->Studentpaymentday_Model->all_payment_student($student_id, $student_type, $start_date,$end_date);

        $this->layout->view('studentpaymentday/index', $this->data);
    }
    
    
  
    
    
   

}
