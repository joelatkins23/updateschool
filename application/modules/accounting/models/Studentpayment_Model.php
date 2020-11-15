<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Studentpayment_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
     
    public function all_student_payment($school_id = null){
       $query="select *  from (select a.id,b.name as student_name,a.alltotal,c.name as bank_name, c.sub_title as bank_sub_title, d.name as payment_type, payment_reference,pay_day 
                from student_payment AS a 
                left join students AS b on (a.student_id=b.id) 
                left join banks AS c on (a.bank_id=c.id) 
                left join payment_type AS d on (a.payment_type=d.id) 
                where a.student_type='admitted' union select a.id,b.name as student_name,a.alltotal,c.name as bank_name, c.sub_title as bank_sub_title, d.name as payment_type, payment_reference,pay_day from student_payment AS a left join students_subscription AS b on (a.student_id=b.id) left join banks AS c on (a.bank_id=c.id) left join payment_type AS d on (a.payment_type =d.id) where a.student_type='subscription') w order by id desc";       
        return $this->db->query($query)->result();  
    }
    public function get_fee_type($school_id = null){
        
        $this->db->select('IH.*, S.school_name');
        $this->db->from('income_heads AS IH'); 
        $this->db->join('schools AS S', 'S.id = IH.school_id', 'left');
        $this->db->where('IH.head_type !=', 'income'); 
        //$this->db->or_where('IH.head_type', 'hostel'); 
        //$this->db->or_where('IH.head_type', 'transport'); 
       
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('IH.school_id', $this->session->userdata('school_id'));
        } 
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('IH.school_id', $school_id);
        }
        
        $this->db->order_by('IH.id', 'DESC');
        
        return $this->db->get()->result();  
    }
    public function viewdata($id = null, $student_type = null){
        $query="select b.pay_day,a.item_name,a.item_price, a.type, c.sub_title as bank_sub_title, c.name as bank_name,d.name as payment_type,b.payment_reference from student_payment_details a left join student_payment b on (a.studentpayment_id=b.id) left join banks c on (b.bank_id=c.id) left join payment_type d on (b.payment_type=d.id)  where b.id= '".$id."'";       
        return $this->db->query($query)->result();  
    }
    public function month_payable_by_student($id = null,$student_type = null){
      
        $query="select a.item_name from student_payment_details a left join student_payment b on (a.studentpayment_id =b.id) where a.type='month' and b.student_id='".$id."' and b.student_type='".$student_type."' order by a.id";       
        
        return $this->db->query($query)->result();  
    }
    public function operationinfo($id = null){
        $query="select * from users where id='".$id."'";       
        
        return $this->db->query($query)->result(); 
    }
    public function get_alllist(){
        $query="select CONCAT(a.id,'_admitted')id, a.`name`  from students a where a.school_id=1 union select CONCAT(b.id,'_subscription')id, b.`name`  from students_subscription b where b.school_id=1";       
        return $this->db->query($query)->result();  
    }
    public function studentinfo($id = null,$student_type = null){
        if($student_type=='admitted'){
            $query="select a.id, a.name as student_name, a.phone,a.present_address,a.registration_no,d.name as class_name,e.name as course_name,a.period,date_format(a.admission_date,'%m/%d/%y')admission_date,dd.name as section_name from students a    left join student_payment b on  (a.id=b.student_id) left join enrollments c on (a.id=c.student_id) left join classes d on (c.class_id=d.id) left join sections dd on (c.section_id=dd.id) left join courses e on (a.course_id=e.id) where b.id= '".$id."'";       

        }else{
            $query="select  a.id, a.name as student_name, a.phone,a.present_address,a.registration_no,d.name as class_name,e.name as course_name,a.period,date_format(a.admission_date,'%m/%d/%y')admission_date,dd.name as section_name from students_subscription a    left join student_payment b on  (a.id=b.student_id) left join enrollments c on (a.id=c.student_id) left join classes d on (c.class_id=d.id) left join sections dd on (c.section_id=dd.id) left join courses e on (a.course_id=e.id) where b.id= '".$id."'";       

        }
        return $this->db->query($query)->result();  
    }
    public function get_course_fee_by_student($student_id = null,$student_type = null){
        if($student_type=='admitted'){
            $this->db->select('a.id as student_id,a.course_id,b.name,b.course_fee');
            $this->db->from('students AS a'); 
            $this->db->join('courses AS b', 'a.course_id=b.id', 'left');  
            $this->db->where('a.id', $student_id);
        }else{
            $this->db->select('a.id as student_id,a.course_id,b.name,b.course_fee');
            $this->db->from('students_subscription AS a'); 
            $this->db->join('courses AS b', 'a.course_id=b.id', 'left');  
            $this->db->where('a.id', $student_id); 
        }
        
        return $this->db->get()->result();  
    }
    
    public function get_single_feetype($feetype_id){
        
        $this->db->select('IH.*, S.school_name');
        $this->db->from('income_heads AS IH'); 
        $this->db->join('schools AS S', 'S.id = IH.school_id', 'left');        
        $this->db->where('IH.id', $feetype_id);
        return $this->db->get()->row();  
    }
    
            
    function duplicate_check($school_id, $title, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('school_id', $school_id);
        $this->db->where('title', $title);
        return $this->db->get('income_heads')->num_rows();            
    }

}
