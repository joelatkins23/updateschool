<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aptitudenote_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_student_list($school_id = null, $academic_year_id = null,$student_id=null, $exam_id = null, $course_id = null, $class_id = null, $section_id = null, $period = null){
        // echo $course_id;
        $sql = "select * from (select c.id, c.name,c.photo,c.school_id,c.course_id, c.period, d.roll_no, e.name as course_name, d.class_id, d.section_id, ifnull(f.avg_grade_point,'0')avg_grade_point_val from (select * from student_payment_details where item_name='Inscrição') a
                    inner join  (select * from  student_payment where student_type='subscription') b on (a.studentpayment_id=b.id)
                    inner join students_subscription c on (b.student_id=c.id)
                    left join enrollments_subscription d on (c.id=d.student_id)
                    left join courses e on (c.course_id=e.id)              
                    left join ( select * from (select * from exam_history where exam_id='".$exam_id."' order by id desc) w group by student_id ) f on (b.student_id=f.student_id)
                    where c.school_id='".$school_id."' and c.course_id='".$course_id."' and c.period='".$period."' and d.class_id='".$class_id."' and d.section_id='".$section_id."' and d.academic_year_id='".$academic_year_id."')  ww where avg_grade_point_val<10 ";
       
              
       if($student_id){
           $sql.="and id='".$student_id."'";
       }
       $sql.="order by name ASC ";
                return $this->db->query($sql)->result();     
    }
   
    public function get_exam_history($school_id = null, $academic_year_id = null, $exam_id = null, $course_id = null, $class_id = null, $section_id = null, $period = null){

        $exam_group=$this->db->query("select date_format(a.created_at,'%Y-%m-%d %H:%i')created_at from exam_history a
                left join students_subscription b on (a.student_id=b.id) where a.exam_id='".$exam_id."' and a.class_id='".$class_id."' and a.section_id='".$section_id."' and a.school_id='".$school_id."' and b.course_id='".$course_id."' and a.academic_year_id='".$academic_year_id."'  group by date_format(a.created_at,'%Y-%m-%d %H:%i') order by a.created_at")->result(); 
        $allgroup=[];
        // echo json_encode($exam_group);
        foreach ($exam_group as $exam){
          $sub_group=$this->db->query("select a.id,b.name as student_name, w.name as class_name,q.name as section_name, d.name as course_name, a.avg_grade_point,a.result_status,a.student_id ,a.grade_id,a.student_id
                    from exam_history AS a
                    left join students_subscription AS b on a.student_id=b.id
                    left join courses AS d on b.course_id=d.id
                    left join classes AS w on a.class_id=w.id
                    left join sections AS q on a.section_id=q.id
                    where a.exam_id='".$exam_id."' and a.school_id='".$school_id."' and a.class_id='".$class_id."' and a.section_id='".$section_id."' and b.course_id='".$course_id."' and b.period='".$period."'  and a.academic_year_id='".$academic_year_id."' and date_format(a.created_at,'%Y-%m-%d %H:%i')='".$exam->created_at."' order by a.id,a.student_id")->result();
                    array_push($allgroup,$sub_group);
                } 
        
         return  $allgroup; 
    }
}
