<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Studentpaymentuser_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
     
    public function all_student_payment_user($user = null,$start_date = null,$end_date = null){
       $query="select w.id as idx, a.id,b.name as student_name, w.item_price as alltotal,w.item_name, a.created_by, c.name as bank_name, c.sub_title as bank_sub_title,  d.name as payment_type, payment_reference,pay_day  
                from student_payment_details w
                left join  student_payment AS a  on (a.id=w.studentpayment_id)
                left join students AS b on (a.student_id=b.id) 
                left join banks AS c on (a.bank_id=c.id) 
                left join payment_type AS d on (a.payment_type=d.id) 
                where a.student_type='admitted'";       
       if($user<>"999999"){
           $query.="and a.created_by='".$user."'";
       }
       if($start_date && $end_date){
            $query.=" and a.pay_day BETWEEN '".$start_date."' and '".$end_date."'";
        }
        $query.="union 
                    select w.id as idx, a.id,b.name as student_name, w.item_price as alltotal,w.item_name, a.created_by, c.name as bank_name, c.sub_title as bank_sub_title,  d.name as payment_type, payment_reference,pay_day  
                    from student_payment_details w
                    left join  student_payment AS a  on (a.id=w.studentpayment_id)
                    left join students_subscription AS b on (a.student_id=b.id) 
                    left join banks AS c on (a.bank_id=c.id) 
                    left join payment_type AS d on (a.payment_type=d.id) 
                    where a.student_type='subscription'  ";
        if($user!="999999"){
            $query.="and a.created_by='".$user."'";
        }
        if($start_date && $end_date){
                $query.=" and a.pay_day BETWEEN '".$start_date."' and '".$end_date."'";
            }
            $query.=" order by idx";
       return $this->db->query($query)->result();  
    }
    public function all_users(){
        $query="select * from users order by id";       
        return $this->db->query($query)->result();  
    }
    
    public function viewdata($id = null, $student_type = null){
        $query="select b.pay_day,a.item_name,a.item_price, c.sub_title as bank_sub_title, c.name as bank_name,d.name as payment_type,b.payment_reference from student_payment_details a left join student_payment b on (a.studentpayment_id=b.id) left join banks c on (b.bank_id=c.id) left join payment_type d on (b.payment_type=d.id)  where b.id= '".$id."'";       
        return $this->db->query($query)->result();  
    }
   
}
