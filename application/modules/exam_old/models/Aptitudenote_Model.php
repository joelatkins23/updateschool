<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aptitudenote_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_student_list($school_id = null, $academic_year_id = null,$student_id=null, $exam_id = null, $course_id = null){
        // echo $course_id;
        $sql = "select * from (select c.id, c.name,c.photo,c.school_id,c.course_id, d.roll_no, e.name as course_name, d.class_id, d.section_id, ifnull(f.avg_grade_point,'0')avg_grade_point_val from (select * from student_payment_details where item_name='Inscrição') a
                    inner join  (select * from  student_payment where student_type='subscription') b on (a.studentpayment_id=b.id)
                    inner join students_subscription c on (b.student_id=c.id)
                    left join enrollments_subscription d on (c.id=d.student_id)
                    left join courses e on (c.course_id=e.id)
                    left join ( select * from (select * from exam_history where exam_id='".$exam_id."' order by id desc) w group by student_id ) f on (b.student_id=f.student_id)
                    where c.school_id='".$school_id."' and c.course_id='".$course_id."' and d.academic_year_id='".$academic_year_id."')  ww where avg_grade_point_val<10 ";
       
       if($student_id){
           $sql.="and id='".$student_id."'";
       }
       $sql.="order by roll_no ";
                return $this->db->query($sql)->result();     
    }
    public function student_insertid($student_id){
        $query="insert into students(school_id,user_id,type_id,admission_no,admission_date,guardian_id,relation_with,registration_no,`group`,`name`,phone,email,present_address,permanent_address,gender,blood_group,religion,caste,dob,age,photo,other_info,is_library_member,is_hostel_member,is_transport_member,discount_id,previous_school,previous_class,transfer_certificate,health_condition,national_id,provincial_sector,date_of_national_id,period,second_language,father_name,father_phone,father_education,father_profession,father_designation,father_photo,mother_name,mother_phone,mother_education,mother_profession,mother_designation,mother_photo,`status`,created_at,modified_at,created_by,modified_by,course_id) select school_id,user_id,type_id,admission_no,admission_date,guardian_id,relation_with,registration_no,`group`,`name`,phone,email,present_address,permanent_address,gender,blood_group,religion,caste,dob,age,photo,other_info,is_library_member,is_hostel_member,is_transport_member,discount_id,previous_school,previous_class,transfer_certificate,health_condition,national_id,provincial_sector,date_of_national_id,period,second_language,father_name,father_phone,father_education,father_profession,father_designation,father_photo,mother_name,mother_phone,mother_education,mother_profession,mother_designation,mother_photo,`status`,created_at,modified_at,created_by,modified_by,course_id from students_subscription where id='".$student_id."'";
        $this->db->query($query);
        return $this->db->insert_id();   
    }

    public function get_exam_history($school_id = null, $academic_year_id = null, $exam_id = null, $course_id = null){

        $exam_group=$this->db->query("select created_at from exam_history  where exam_id='".$exam_id."' and school_id='".$school_id."' and academic_year_id='".$academic_year_id."'  group by created_at order by created_at")->result(); 
        $allgroup=[];
        // echo json_encode($exam_group);
        foreach ($exam_group as $exam){
          $sub_group=$this->db->query("select a.id,b.name as student_name, d.name as course_name, a.avg_grade_point,a.result_status,a.student_id ,a.grade_id,a.student_id
                    from exam_history AS a
                    left join students_subscription AS b on a.student_id=b.id
                    left join courses AS d on b.course_id=d.id
                    where a.exam_id='".$exam_id."' and a.school_id='".$school_id."' and b.course_id='".$course_id."' and a.academic_year_id='".$academic_year_id."' and a.created_at='".$exam->created_at."' order by a.id,a.student_id")->result();
                    array_push($allgroup,$sub_group);
                } 
        
         return  $allgroup; 
    }
}
