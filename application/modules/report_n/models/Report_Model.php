<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }  
    public function get_student_daily_report($start_date,$end_date){
        $sql="select  w.course_name,sum(w.month_totoal)tuition,sum(w.product_totoal)other_product,sum(if(w.registration>0,'1',w.registration))registration_qty,sum(w.registration)registration,sum(if(w.admit>0,'1',w.admit))admit_qty,sum(w.admit)admit,(sum(w.month_totoal)+sum(w.product_totoal)+sum(w.registration)+sum(w.admit))total
        from (select a.id , a.student_id, sum(ifnull(b.month_totoal,'0'))month_totoal, sum(ifnull(c.product_totoal,'0'))product_totoal, e.name as student_name, h.name as course_name, sum(ifnull(br.registration,'0'))registration ,sum(ifnull(ba.admit,'0'))admit  from 
        (select * from student_payment where student_type='admitted') a 
        left join (select studentpayment_id ,sum(item_price)month_totoal from(
select r.pay_day,q.* from student_payment_details q
inner join student_payment r on (q.studentpayment_id=r.id)) w where  pay_day BETWEEN date_format('".$start_date."','%Y-%m-%d') and date_format('".$end_date."','%Y-%m-%d') and type='month'  group by studentpayment_id) b
        on (a.id=b.studentpayment_id)
        left join (select studentpayment_id ,sum(item_price)product_totoal from(
select r.pay_day,q.* from student_payment_details q
inner join student_payment r on (q.studentpayment_id=r.id)) w where  pay_day BETWEEN date_format('".$start_date."','%Y-%m-%d') and date_format('".$end_date."','%Y-%m-%d') and type='product' and item_name<>'Inscrição' and item_name<>'Matriculas' group by studentpayment_id) c
        on (a.id =c.studentpayment_id)
        left join (select *,sum(item_price)registration  from(
select r.pay_day,q.* from student_payment_details q
inner join student_payment r on (q.studentpayment_id=r.id)) w where  pay_day BETWEEN  date_format('".$start_date."','%Y-%m-%d') and date_format('".$end_date."','%Y-%m-%d')  and type='product' and item_name='Inscrição'  group by studentpayment_id) br
        on (a.id =br.studentpayment_id)
        left join (select *,sum(item_price)admit  from(
select r.pay_day,q.* from student_payment_details q
inner join student_payment r on (q.studentpayment_id=r.id)) w where  pay_day BETWEEN date_format('".$start_date."','%Y-%m-%d') and date_format('".$end_date."','%Y-%m-%d') and type='product' and item_name='Matriculas'  group by studentpayment_id) ba
        on (a.id =ba.studentpayment_id)
        left join students AS e on (a.student_id=e.id)
        left join courses h on (e.course_id=h.id) GROUP BY id
        union
        select a.id , a.student_id, sum(ifnull(b.month_totoal,'0'))month_totoal, sum(ifnull(c.product_totoal,'0'))product_totoal, e.name as student_name, h.name as course_name, sum(ifnull(br.registration,'0'))registration ,sum(ifnull(ba.admit,'0'))admit  from 
        (select * from student_payment where student_type='subscription') a 
        left join (select studentpayment_id ,sum(item_price)month_totoal from(
select r.pay_day,q.* from student_payment_details q
inner join student_payment r on (q.studentpayment_id=r.id)) w where  pay_day BETWEEN date_format('".$start_date."','%Y-%m-%d') and date_format('".$end_date."','%Y-%m-%d') and type='month'  group by studentpayment_id) b
        on (a.id=b.studentpayment_id)
        left join (select studentpayment_id ,sum(item_price)product_totoal from(
select r.pay_day,q.* from student_payment_details q
inner join student_payment r on (q.studentpayment_id=r.id)) w where  pay_day BETWEEN date_format('".$start_date."','%Y-%m-%d') and date_format('".$end_date."','%Y-%m-%d') and type='product' and item_name<>'Inscrição' and item_name<>'Matriculas' group by studentpayment_id) c
        on (a.id =c.studentpayment_id)
        left join (select *,sum(item_price)registration from(
select r.pay_day,q.* from student_payment_details q
inner join student_payment r on (q.studentpayment_id=r.id)) w where  pay_day BETWEEN  date_format('".$start_date."','%Y-%m-%d') and date_format('".$end_date."','%Y-%m-%d')  and type='product' and item_name='Inscrição'  group by studentpayment_id) br
        on (a.id =br.studentpayment_id)
        left join (select *,sum(item_price)admit from(
select r.pay_day,q.* from student_payment_details q
inner join student_payment r on (q.studentpayment_id=r.id)) w where  pay_day BETWEEN date_format('".$start_date."','%Y-%m-%d') and date_format('".$end_date."','%Y-%m-%d') and type='product' and item_name='Matriculas'  group by studentpayment_id) ba
        on (a.id =ba.studentpayment_id)
        left join students_subscription AS e on (a.student_id=e.id)
        left join courses h on (e.course_id=h.id) GROUP BY id) w group by course_name order by course_name";
        return $this->db->query($sql)->result();
    }
    public function get_student_not_report($start_date,$end_date){
        $sql="select * ,(h.course_fee*monpay)mon_total
        from (select a.name as student_name,a.id,a.phone,c.name as class_name,d.name as course_name,d.course_fee,d.mulct, e.session_year, (date_format('".$end_date."','%m')-date_format('".$start_date."','%m')+1-ifnull(ww.monpay,'0'))monpay,ifnull(ww.last_mon,' ')last_mon,ifnull(ww.last_pay,' ')last_pay from students a
        left join enrollments b on (a.id=b.student_id)
        left join classes c on (b.class_id=c.id)
        left join courses d on (a.course_id=d.id)
        left join (select * from academic_years where start_year=date_format('".$start_date."','%Y'))e on (a.school_id=e.school_id)
        left join (select w.student_id,q.monpay,(p.item_name)last_mon,(p.item_price)last_pay
        from (select studentpayment_id, count(studentpayment_id)monpay from student_payment_details where paymonth BETWEEN date_format('".$start_date."','%Y-%m-01') and date_format('".$end_date."','%Y-%m-%d') and type='month'  group by studentpayment_id) q
        join student_payment w on (q.studentpayment_id=w.id)
        left join (select * from (select * from student_payment_details where paymonth BETWEEN date_format('".$start_date."','%Y-%m-01') and date_format('".$end_date."','%Y-%m-%d') and type='month' order by id desc)w group by w.studentpayment_id) p
        on (q.studentpayment_id=p.studentpayment_id)
        ) ww on (a.id=ww.student_id)) h where h.monpay<>0 order by class_name";
        return $this->db->query($sql)->result();
    }
    public function allpaymentagelist($year =null,$class_id = null, $age = null){
        $sql="select w.student_name,w.course_name,w.gender, sum(item_price)total_price,age
        from (select a.id,b.name as student_name,b. gender,a.alltotal,(".$year." -date_format(b.dob,'%Y'))age,cc.class_id, c.name as bank_name,d.name as payment_type, payment_reference,pay_day,item_price,e.name as course_name,a.student_id
        from student_payment AS a 
        left join students AS b on (a.student_id=b.id)
        left join banks AS c on (a.bank_id=c.id) 
        left join payment_type AS d on (a.payment_type=d.id) 
        left join courses e on (b.course_id=e.id)
        left join student_payment_details bb on (a.id=bb.studentpayment_id)
        join enrollments cc on (b.id=cc.student_id)
        where student_type='admitted' and date_format(pay_day, '%Y')='".$year."') w ";
        if($class_id){
            $sql.=" where w.class_id='".$class_id."'";
        }
        if($age){
            $sql.=" and w.age='".$age."'";
        }
        $sql.=" group by student_id";
        $sql.=" union select w.student_name,w.course_name,w.gender, sum(item_price)total_price,age
        from (select a.id,b.name as student_name,b. gender,a.alltotal,(".$year." -date_format(b.dob,'%Y'))age,cc.class_id, c.name as bank_name,d.name as payment_type, payment_reference,pay_day,item_price,e.name as course_name,a.student_id
        from student_payment AS a 
        left join students_subscription AS b on (a.student_id=b.id)
        left join banks AS c on (a.bank_id=c.id) 
        left join payment_type AS d on (a.payment_type=d.id) 
        left join courses e on (b.course_id=e.id)
        left join student_payment_details bb on (a.id=bb.studentpayment_id)
        join enrollments_subscription cc on (b.id=cc.student_id)
        where student_type='subscription' and date_format(pay_day, '%Y')='".$year."') w ";
        if($class_id){
            $sql.=" where w.class_id='".$class_id."'";
        }
        if($age){
            $sql.=" and w.age='".$age."'";
        }
        $sql.=" group by student_id";
        return $this->db->query($sql)->result();
    }
    
   
    public function get_income_report($school_id, $academic_year_id, $group_by, $date_from, $date_to){
        
        $group_by_sql = '';
        $group_by_field = '';
       if($group_by && $group_by == 'income_head'){           
           $group_by_sql .= " GROUP BY H.title ORDER BY H.title ASC";
           $group_by_field .= ", H.title AS group_by_field";
           
       }elseif($group_by && $group_by == 'daily'){           
           $group_by_sql .= " GROUP BY T.payment_date ORDER BY T.payment_date ASC";
           $group_by_field .= ", DATE_FORMAT(T.payment_date, '%b %d, %Y') AS group_by_field";
           
       }elseif($group_by && $group_by == 'monthly'){           
           $group_by_sql .= " GROUP BY MONTH(T.payment_date), YEAR(I.date) ORDER BY I.date ASC";
           $group_by_field .= ", DATE_FORMAT(T.payment_date, '%M, %Y') AS group_by_field";
           
       }elseif($group_by && $group_by == 'yearly'){           
           $group_by_sql .= " GROUP BY I.academic_year_id ORDER BY I.academic_year_id ASC";
           $group_by_field .= ", DATE_FORMAT(T.payment_date, '%Y') AS group_by_field";
           
       }elseif($group_by && $group_by == 'income_by'){           
           $group_by_sql .= " GROUP BY T.payment_method ORDER BY T.payment_method ASC";
           $group_by_field .= ", T.payment_method AS group_by_field";
           
       } 
       
        $sql = "SELECT I.*, SUM(T.amount) AS total_amount, T.payment_date, H.title AS head, AY.session_year $group_by_field 
                FROM invoices AS I                
                LEFT JOIN income_heads AS H ON H.id = I.income_head_id 
                LEFT JOIN transactions AS T ON T.invoice_id = I.id 
                LEFT JOIN academic_years AS AY ON AY.id = I.academic_year_id 
                WHERE I.status = 1 AND T.amount > 0";
        
       if($date_from != '' && $date_to != ''){
           $sql .= " AND I.date >= '$date_from' AND I.date <= '$date_to' ";
       }
       if($date_from != '' && $date_to == ''){
           $sql .= "I.date >= '$date_from'";
       }
       if($academic_year_id){
           $sql .= " AND I.academic_year_id = '$academic_year_id'";
       }
       if($school_id){
           $sql .= " AND I.school_id = '$school_id'";
       }
       
       
       $sql .= $group_by_sql;
        
       return $this->db->query($sql)->result();
    }
    public function get_age_by_year_class($year = null, $class_id = null, $age = null){
        $sql="select name from (
            select (c.start_year-date_format(b.dob,'%Y'))name
            from enrollments a
            left join students b on (a.student_id=b.id)
            left join academic_years c on (a.academic_year_id=c.id)
            where a.academic_year_id='".$year."' and a.class_id='".$class_id."' 
            union
            select (c.start_year-date_format(b.dob,'%Y'))name
            from enrollments_subscription a
            left join students_subscription b on (a.student_id=b.id)
            left join academic_years c on (a.academic_year_id=c.id)
            where a.academic_year_id='".$year."' and a.class_id='".$class_id."' 
            ) b group by name order by name";
        return $this->db->query($sql)->result();
    }
    public function get_expenditure_report($school_id, $academic_year_id, $group_by, $date_from, $date_to){
        
        $group_by_sql = '';
        $group_by_field = '';
       if($group_by && $group_by == 'expenditure_head'){           
           $group_by_sql .= " GROUP BY H.title ORDER BY H.title ASC";
           $group_by_field .= ", H.title AS group_by_field";
       }elseif($group_by && $group_by == 'daily'){           
           $group_by_sql .= " GROUP BY E.date ORDER BY E.date ASC";
           $group_by_field .= ", DATE_FORMAT(E.date, '%b %d, %Y') AS group_by_field";
       }elseif($group_by && $group_by == 'monthly'){           
           $group_by_sql .= " GROUP BY MONTH(E.date), YEAR(E.date) ORDER BY E.date ASC";
           $group_by_field .= ", DATE_FORMAT(E.date, '%M, %Y') AS group_by_field";
       }elseif($group_by && $group_by == 'yearly'){           
           $group_by_sql .= " GROUP BY E.academic_year_id ORDER BY E.academic_year_id ASC";
           $group_by_field .= ", DATE_FORMAT(E.date, '%Y') AS group_by_field";
       }elseif($group_by && $group_by == 'expenditure_by'){           
           $group_by_sql .= " GROUP BY E.expenditure_via ORDER BY E.expenditure_via ASC";
           $group_by_field .= ", E.expenditure_via AS group_by_field";
       } 
       
        $sql = "SELECT E.*, SUM(E.amount) AS total_amount, H.title AS head, AY.session_year $group_by_field 
                FROM expenditures AS E 
                LEFT JOIN expenditure_heads AS H ON H.id = E.expenditure_head_id 
                LEFT JOIN academic_years AS AY ON AY.id = E.academic_year_id 
                WHERE E.status = 1 ";
       if($date_from != '' && $date_to != ''){
           $sql .= " AND E.date >= '$date_from' AND E.date <= '$date_to' ";
       }
       if($date_from != '' && $date_to == ''){
           $sql .= "E.date >= '$date_from'";
       }
       if($academic_year_id){
           $sql .= " AND E.academic_year_id = '$academic_year_id'";
       }
       if($school_id){
           $sql .= " AND E.school_id = '$school_id'";
       }
       
       
       $sql .= $group_by_sql;
        
       return $this->db->query($sql)->result();
    }
    
    public function get_invoice_report($school_id, $academic_year_id, $group_by, $date_from, $date_to){
        
        $group_by_sql = '';
        $group_by_field = '';
        
       if($group_by && $group_by == 'fee_head'){           
           $group_by_sql .= " GROUP BY H.title ORDER BY H.title ASC";
           $group_by_field .= ", H.title AS group_by_field";
           
       }elseif($group_by && $group_by == 'daily'){           
           $group_by_sql .= " GROUP BY I.date ORDER BY I.date ASC";
           $group_by_field .= ", DATE_FORMAT(I.date, '%b %d, %Y') AS group_by_field";
           
       }elseif($group_by && $group_by == 'monthly'){           
           $group_by_sql .= " GROUP BY MONTH(I.date), YEAR(I.date) ORDER BY I.date ASC";
           $group_by_field .= ", DATE_FORMAT(I.date, '%b, %Y') AS group_by_field";
           
       }elseif($group_by && $group_by == 'yearly'){           
           $group_by_sql .= " GROUP BY I.academic_year_id ORDER BY I.academic_year_id ASC";
           $group_by_field .= ", DATE_FORMAT(I.date, '%Y') AS group_by_field";
           
       }elseif($group_by && $group_by == 'class'){           
           $group_by_sql .= " GROUP BY I.class_id ORDER BY I.class_id ASC";
           $group_by_field .= ", C.name AS group_by_field";
           
       }elseif($group_by && $group_by == 'paid_status'){           
           $group_by_sql .= " GROUP BY I.paid_status ORDER BY I.paid_status ASC";
           $group_by_field .= ", I.paid_status AS group_by_field";
       } 
       
        $sql = "SELECT I.*, SUM(I.net_amount) AS total_amount, SUM(I.discount) AS total_discount, H.title AS head, AY.session_year $group_by_field 
                FROM invoices AS I               
                LEFT JOIN income_heads AS H ON H.id = I.income_head_id 
                LEFT JOIN academic_years AS AY ON AY.id = I.academic_year_id 
                LEFT JOIN classes AS C ON C.id = I.class_id 
                WHERE I.status = 1 AND I.invoice_type != 'income'";
        
       if($date_from != '' && $date_to != ''){
           $sql .= " AND I.date >= '$date_from' AND I.date <= '$date_to' ";
       }
       if($date_from != '' && $date_to == ''){
           $sql .= "I.date >= '$date_from'";
       }
       if($academic_year_id){
           $sql .= " AND I.academic_year_id = '$academic_year_id'";
       }
       if($school_id){
           $sql .= " AND I.school_id = '$school_id'";
       }      
       
       $sql .= $group_by_sql;
        
       return $this->db->query($sql)->result();
    }
    public function get_student_course_report($school_id = null, $academic_year_id = null, $course_id = null, $period = null,$class_id = null,$section_id = null){       
        $sql = "select c.name as student_name, c.admission_no as admission, e.name as course_name, w.name as class_name, q.name as section_name, c.period  from (select * from student_payment_details where item_name='Inscrição') a
                    inner join  (select * from  student_payment where student_type='subscription') b on (a.studentpayment_id=b.id)
                    left join students_subscription c on (b.student_id=c.id)
                    left join enrollments_subscription d on (c.id=d.student_id)
                    left join classes w on (d.class_id=w.id)
                    left join sections q on (d.section_id=q.id)
                    left join courses e on (c.course_id=e.id) where c.school_id='".$school_id."' and d.academic_year_id='".$academic_year_id."'";
       if($course_id){
           $sql.="and c.course_id='".$course_id."'";
       }
       if($period){
            $sql.="and c.period='".$period."'";
       }
       if($class_id){
        $sql.="and d.class_id='".$class_id."'";
        }
        if($section_id){
            $sql.="and d.section_id='".$section_id."'";
        }
        
       return $this->db->query($sql)->result();
    }
    public function get_admit_student_course_report($school_id = null, $academic_year_id = null, $course_id = null, $period = null){       
        $sql = "SELECT a.name AS student_name, c.name as course_name,a.period,d.name as class_name, e.name as section_name from students a left join enrollments as b on (a.id=b.student_id) left join courses as c on (a.course_id=c.id) left join classes d on (b.class_id=d.id) left join sections e on (b.section_id=e.id) where a.school_id='".$school_id."' and b.academic_year_id='".$academic_year_id."'";
       if($course_id){
           $sql.="and a.course_id='".$course_id."'";
       }
       if($period){
            $sql.="and a.period='".$period."'";
       }
        
       return $this->db->query($sql)->result();
    }
    
    public function get_expenditure_by_date($school_id, $date){
        $sql = "SELECT  SUM(E.amount) AS total_amount
                FROM expenditures AS E                
                WHERE E.date = '$date' AND E.school_id = '$school_id' GROUP BY E.date ASC";
        
        $exp = $this->db->query($sql)->row();
        return isset($exp->total_amount) ? $exp->total_amount: 0;
    }
           
    public function get_income_by_date($school_id, $date){
        
        $sql = "SELECT  SUM(I.net_amount) AS total_amount
                FROM invoices AS I                
                WHERE I.date = '$date' AND I.school_id = '$school_id' GROUP BY I.date ASC";
        
        $income= $this->db->query($sql)->row();
        return isset($income->total_amount) ? $income->total_amount: 0;
    }
    
    
      public function get_library_report($school_id, $academic_year_id, $group_by, $date_from, $date_to){
        
        $group_by_sql = '';
        $group_by_field = '';
       if($group_by && $group_by == 'daily'){           
           $group_by_sql .= " GROUP BY BI.issue_date ORDER BY BI.issue_date ASC";
           $group_by_field .= ", DATE_FORMAT(BI.issue_date, '%b %d, %Y') AS group_by_field";
           
       }elseif($group_by && $group_by == 'monthly'){           
           $group_by_sql .= " GROUP BY MONTH(BI.issue_date), YEAR(BI.issue_date) ORDER BY BI.issue_date ASC";
           $group_by_field .= ", DATE_FORMAT(BI.issue_date, '%M, %Y') AS group_by_field";
           
       }elseif($group_by && $group_by == 'yearly'){           
           $group_by_sql .= " GROUP BY BI.academic_year_id ORDER BY BI.academic_year_id ASC";
           $group_by_field .= ", DATE_FORMAT(BI.issue_date, '%Y') AS group_by_field";
           
       }elseif($group_by && $group_by == 'class'){           
           $group_by_sql .= " GROUP BY C.name ORDER BY C.name ASC";
           $group_by_field .= ", C.name AS group_by_field";
           
       } 
       
        $sql = "SELECT BI.*, COUNT(BI.id) AS total_issue, SUM(BI.is_returned) AS total_returned, AY.session_year $group_by_field 
                FROM book_issues AS BI 
                LEFT JOIN library_members AS LM ON LM.id = BI.library_member_id 
                LEFT JOIN students AS S ON S.user_id = LM.user_id 
                LEFT JOIN enrollments AS E ON E.student_id = S.id 
                LEFT JOIN classes AS C ON C.id = E.class_id 
                LEFT JOIN academic_years AS AY ON AY.id = BI.academic_year_id 
                WHERE BI.status = 1 ";
        
       if($date_from != '' && $date_to != ''){
           $sql .= " AND BI.issue_date >= '$date_from' AND BI.return_date <= '$date_to' ";
       }
       if($date_from != '' && $date_to == ''){
           $sql .= "BI.issue_date >= '$date_from'";
       }
       
       if($academic_year_id){
           $sql .= " AND BI.academic_year_id = '$academic_year_id'";
       }
       
       if($academic_year_id){           
                      
           $sql .= " AND E.academic_year_id = '$academic_year_id'";
       }
       
       if($school_id){
           $sql .= " AND BI.school_id = '$school_id'";
       }
       
       
       $sql .= $group_by_sql;
        
       return $this->db->query($sql)->result();
    }
    
  
     public function get_student_list($school_id, $academic_year_id, $class_id, $section_id){
         
        $this->db->select('E.roll_no,  S.id, S.name');
        $this->db->from('enrollments AS E');        
        $this->db->join('students AS S', 'S.id = E.student_id', 'left');
        $this->db->where('E.academic_year_id', $academic_year_id);       
        $this->db->where('E.class_id', $class_id);       
        $this->db->where('E.section_id', $section_id);       
        $this->db->where('E.school_id', $school_id);       
        return $this->db->get()->result();    
    } 
    
    
    public function get_student_report($school_id, $academic_year_id, $group_by){
        
        $group_by_sql = '';
        $group_by_field = '';
        $sql_plus = '';
        
       if($group_by && $group_by == 'gender'){           
           $group_by_sql .= " GROUP BY C.name ORDER BY C.id ASC";
           $group_by_field .= ", C.name AS group_by_field";
           
       }elseif($group_by && $group_by == 'vehicle'){           
           $group_by_sql .= " GROUP BY C.name ORDER BY C.id ASC";
           $group_by_field .= ", C.name AS group_by_field";
           $sql_plus .= " AND S.is_transport_member = '1'";
           
       }elseif($group_by && $group_by == 'library'){           
           $group_by_sql .= " GROUP BY C.name ORDER BY C.id ASC";
           $group_by_field .= ", C.name AS group_by_field";
           $sql_plus .= " AND S.is_library_member = '1'";
           
       }elseif($group_by && $group_by == 'hostel'){           
           $group_by_sql .= " GROUP BY C.name ORDER BY C.id ASC";
           $group_by_field .= ", C.name AS group_by_field";
           $sql_plus .= " AND S.is_hostel_member = '1'";
           
       }elseif($group_by && $group_by == 'class'){           
           $group_by_sql .= " GROUP BY C.name ORDER BY C.id ASC";
           $group_by_field .= ", C.name AS group_by_field";
       } 
       
        $sql = "SELECT S.id, COUNT(S.id) AS total, C.id as class_id, E.academic_year_id, AY.session_year $group_by_field 
                FROM students AS S 
                LEFT JOIN enrollments AS E ON E.student_id = S.id 
                LEFT JOIN classes AS C ON C.id = E.class_id 
                LEFT JOIN academic_years AS AY ON AY.id = E.academic_year_id 
                WHERE S.status = 1 ";
             
       if($academic_year_id){
           $sql_plus .= " AND E.academic_year_id = '$academic_year_id'";
       }
       if($school_id){
           $sql_plus .= " AND E.school_id = '$school_id'";
       }
       
       $sql .= $sql_plus;
       $sql .= $group_by_sql;
        
       return $this->db->query($sql)->result();
    }
    
    public function get_student_by_gender($school_id, $group_by, $class_id, $academic_year_id, $gender){
        
        $extra = '';
        if($group_by == 'vehicle'){
            $extra = "AND S.is_transport_member = '1'"; 
        }
        if($group_by == 'library'){
            $extra = "AND S.is_library_member = '1'"; 
        }
        if($group_by == 'hostel'){
            $extra = "AND S.is_hostel_member = '1'"; 
        }
        
        $sql = "SELECT COUNT(S.id) AS total
                FROM students AS S 
                LEFT JOIN enrollments AS E ON E.student_id = S.id 
                LEFT JOIN classes AS C ON C.id = E.class_id 
                WHERE S.status = 1  AND S.gender = '$gender'
                AND E.class_id = '$class_id'
                AND E.school_id = '$school_id'                
                $extra
                AND E.academic_year_id = '$academic_year_id'";
         return $this->db->query($sql)->row()->total;
    }
    
    
    
    
    public function get_student_invoice_report($school_id, $academic_year_id, $class_id, $student_id){
        
        $this->db->select('I.*, SUM(T.amount) AS paid_amount, IH.title AS head, C.name AS class_name, ST.name AS student,  AY.session_year');
        $this->db->from('invoices AS I');   
        $this->db->join('transactions AS T', 'T.invoice_id = I.id', 'left');
        $this->db->join('students AS ST', 'ST.id = I.student_id', 'left');
        $this->db->join('classes AS C', 'C.id = I.class_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = I.academic_year_id', 'left');
        $this->db->join('income_heads AS IH', 'IH.id = I.income_head_id', 'left');
        
        if($school_id != ''){
           $this->db->where('I.school_id', $school_id);
        }  
        
        if($class_id != ''){
           $this->db->where('I.class_id', $class_id);
        }      
        
        if($student_id != ''){
           $this->db->where('I.student_id', $student_id);
        }
       
        if($academic_year_id){
            $this->db->where('I.academic_year_id', $academic_year_id);
        }       
        
        $this->db->group_by('I.id', 'DESC'); 
              
        return $this->db->get()->result();  
       
    } 
    
    
        
    public function get_student_activity_report($school_id, $academic_year_id, $class_id, $student_id){
        
        $this->db->select('SA.*, C.name AS class_name, ST.name, S.name AS section, AY.session_year');
        $this->db->from('student_activities AS SA');   
        $this->db->join('students AS ST', 'ST.id = SA.student_id', 'left');
        $this->db->join('classes AS C', 'C.id = SA.class_id', 'left');
        $this->db->join('sections AS S', 'S.id = SA.section_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = SA.academic_year_id', 'left');
        
        if($school_id != ''){
           $this->db->where('SA.school_id', $school_id);
        } 
        
        if($class_id != ''){
           $this->db->where('SA.class_id', $class_id);
        }      
        
        if($student_id != ''){
           $this->db->where('SA.student_id', $student_id);
        }
       
        if($academic_year_id){
            $this->db->where('SA.academic_year_id', $academic_year_id);
        }    
              
        return $this->db->get()->result();   
       
    }    
   
  
    
    
    public function get_payroll_report($school_id,$academic_year_id, $group_by, $payment_to, $month){
        
        $group_by_sql = '';
        $group_by_field = '';
        
       if($group_by && $group_by == 'salary_type'){           
           $group_by_sql .= " GROUP BY SP.salary_type ORDER BY SP.salary_type ASC";
           $group_by_field .= ", SP.salary_type AS group_by_field";
       }elseif($group_by && $group_by == 'payment_to'){           
           $group_by_sql .= " GROUP BY SP.payment_to ORDER BY SP.payment_to ASC";
           $group_by_field .= ", SP.payment_to AS group_by_field";
           $group_by_field .= ", SP.payment_to AS group_by_field";
       }elseif($group_by && $group_by == 'month'){           
           $group_by_sql .= " GROUP BY SP.salary_month ORDER BY SP.salary_month ASC";
           $group_by_field .= ", SP.salary_month AS group_by_field";
       }elseif($group_by && $group_by == 'yearly'){           
           $group_by_sql .= " GROUP BY SP.academic_year_id ORDER BY SP.academic_year_id ASC";
           $group_by_field .= ", DATE_FORMAT(SP.salary_month, '%Y') AS group_by_field";
       }elseif($group_by && $group_by == 'expenditure_by'){           
           $group_by_sql .= " GROUP BY SP.payment_method ORDER BY SP.payment_method ASC";
           $group_by_field .= ", SP.payment_method AS group_by_field";
       } 
       
        $sql = "SELECT SP.id, SUM(SP.net_salary) AS total_amount, AY.session_year $group_by_field
                FROM salary_payments AS SP 
                LEFT JOIN academic_years AS AY ON AY.id = SP.academic_year_id 
                WHERE SP.status = 1 ";
                  
       if($academic_year_id){
           $sql .= " AND SP.academic_year_id = '$academic_year_id'";
       }       
       if($month){
           $sql .= " AND SP.salary_month = '$month'";
       }
       if($school_id){
           $sql .= " AND SP.school_id = '$school_id'";
       }
       
       
       $sql .= $group_by_sql;
        
       return $this->db->query($sql)->result();
    }
    
        public function get_student_due_fee_report($school_id, $academic_year_id, $class_id, $student_id){
        
        $this->db->select('I.*, SUM(T.amount) AS paid_amount, IH.title AS head, C.name AS class_name, ST.name AS student,  AY.session_year');
        $this->db->from('invoices AS I');   
        $this->db->join('transactions AS T', 'T.invoice_id = I.id', 'left');
        $this->db->join('students AS ST', 'ST.id = I.student_id', 'left');
        $this->db->join('classes AS C', 'C.id = I.class_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = I.academic_year_id', 'left');
        $this->db->join('income_heads AS IH', 'IH.id = I.income_head_id', 'left');
        
        if($school_id != ''){
           $this->db->where('I.school_id', $school_id);
        } 
        
        if($class_id != ''){
           $this->db->where('I.class_id', $class_id);
        }      
        
        if($student_id != ''){
           $this->db->where('I.student_id', $student_id);
        }
       
        if($academic_year_id){
            $this->db->where('I.academic_year_id', $academic_year_id);
        }       
        
        
        $this->db->where('I.paid_status !=', 'paid');
        $this->db->group_by('I.id', 'DESC'); 
              
        return $this->db->get()->result();  
       
    }  
    
    public function get_student_fee_collection_report($school_id, $academic_year_id, $class_id, $student_id, $fee_type, $date_from, $date_to){
        
        $this->db->select('T.*, T.note,ST.name AS student, C.name AS class_name, IH.title AS head, AY.session_year');
        $this->db->from('transactions AS T');   
        $this->db->join('invoices AS I', 'I.id = T.invoice_id', 'left');
        $this->db->join('students AS ST', 'ST.id = I.student_id', 'left');
        $this->db->join('classes AS C', 'C.id = I.class_id', 'left');
        $this->db->join('income_heads AS IH', 'IH.id = I.income_head_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = T.academic_year_id', 'left');
        
        if($school_id){
            $this->db->where('T.school_id', $school_id);
        }  
        
        if($date_from != '' && $date_to != ''){
           $this->db->where('T.payment_date >=', $date_from);
           $this->db->where('T.payment_date <=', $date_to);
        }      
        
        if($date_from != '' && $date_to == ''){
           $this->db->where('T.payment_date >=', $date_from);
        }
       
        if($academic_year_id){
            $this->db->where('T.academic_year_id', $academic_year_id);
        }       
       
        if($class_id != ''){
           $this->db->where('I.class_id', $class_id);
        } 
        if($student_id != ''){
           $this->db->where('I.student_id', $student_id);
        }
        if($fee_type != ''){
           $this->db->where('I.income_head_id', $fee_type);
        }        
              
        return $this->db->get()->result();   
       
    }    
  
      
    public function get_transaction_report($school_id, $academic_year_id, $date_from, $date_to){
        
        $this->db->select('T.*, T.note, IH.title AS head, AY.session_year');
        $this->db->from('transactions AS T');   
        $this->db->join('invoices AS I', 'I.id = T.invoice_id', 'left');
        $this->db->join('income_heads AS IH', 'IH.id = I.income_head_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = T.academic_year_id', 'left');
                
        if($school_id){
            $this->db->where('T.school_id', $school_id);
        } 
        
        if($date_from != '' && $date_to != ''){
           $this->db->where('T.payment_date >=', $date_from);
           $this->db->where('T.payment_date <=', $date_to);
        }      
        
        if($date_from != '' && $date_to == ''){
           $this->db->where('T.payment_date >=', $date_from);
        }
       
        if($academic_year_id){
            $this->db->where('T.academic_year_id', $academic_year_id);
        }     
        
        $this->db->order_by('T.payment_date', 'ASC');
        return $this->db->get()->result();  
       
    } 
    
    
     
    public function get_debit_by_date($school_id, $date){
        
        $this->db->select('E.amount AS debit, E.note, E.note, H.title AS head');
        $this->db->from('expenditures AS E');        
        $this->db->join('expenditure_heads AS H', 'H.id = E.expenditure_head_id', 'left');
        $this->db->where('E.school_id', $school_id); 
        $this->db->where('E.date', $date); 
        return $this->db->get()->result();       
    }
           
    public function get_credit_by_date($school_id, $date){
        
        $this->db->select('T.amount as credit, T.note, IH.title AS head');
        $this->db->from('transactions AS T');   
        $this->db->join('invoices AS I', 'I.id = T.invoice_id', 'left');
        $this->db->join('income_heads AS IH', 'IH.id = I.income_head_id', 'left');
        $this->db->where('T.school_id', $school_id);              
        $this->db->where('T.payment_date', $date);              
        return $this->db->get()->result();   
       
    }   
    
      
    public function get_student_examresult_report($school_id, $academic_year_id, $class_id, $section_id){
        
        $this->db->select('FR.*, G.name AS grade, E.roll_no, ST.name AS student, C.name AS class_name, S.name AS section, AY.session_year');
        $this->db->from('final_results AS FR');   
        $this->db->join('enrollments AS E', 'E.student_id = FR.student_id', 'left');
        $this->db->join('students AS ST', 'ST.id = E.student_id', 'left');
        $this->db->join('classes AS C', 'C.id = E.class_id', 'left');
        $this->db->join('sections AS S', 'S.id = E.section_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = E.academic_year_id', 'left');
        $this->db->join('grades AS G', 'G.id = FR.grade_id', 'left');
              
       
        if($school_id){
            $this->db->where('E.school_id', $school_id);
        }  
        
        if($academic_year_id){
            $this->db->where('E.academic_year_id', $academic_year_id);
        }       
        
        if($class_id != ''){
           $this->db->where('E.class_id', $class_id);
        } 
        if($section_id != ''){
           $this->db->where('E.section_id', $section_id);
        } 
        
         $this->db->order_by('FR.avg_grade_point', 'DESC');
              
        return $this->db->get()->result();   
       
    }    
  
  
}
