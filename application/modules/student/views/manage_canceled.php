<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-users"></i><small> <?php echo $this->lang->line('manage'); ?> <?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('canceled'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content quick-link no-print">
                <span><?php echo $this->lang->line('quick_link'); ?>:</span>
                <?php if(has_permission(ADD, 'student', 'type')){ ?>
                    <a href="<?php echo site_url('student/type/index'); ?>"> <?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('type'); ?></a>
                 <?php } ?>
                <?php if(has_permission(ADD, 'student', 'student')){ ?>
                   | <a href="<?php echo site_url('student/add/'); ?>"><?php echo $this->lang->line('admit'); ?> <?php echo $this->lang->line('student'); ?></a>
                 <?php } ?>
                 <?php if(has_permission(ADD, 'student', 'manage_canceled')){ ?>
                   | <a href="<?php echo site_url('student/manage_canceled/indx'); ?>"><?php echo $this->lang->line('manage'); ?> <?php echo $this->lang->line('canceled'); ?></a>
                 <?php } ?>
                <?php if(has_permission(VIEW, 'student', 'student')){ ?>
                   | <a href="<?php echo site_url('student/index'); ?>"><?php echo $this->lang->line('manage_student'); ?></a>                    
                 <?php } ?>
                <?php if(has_permission(VIEW, 'student', 'bulk')){ ?>
                   | <a href="<?php echo site_url('student/bulk/add'); ?>"><?php echo $this->lang->line('bulk'); ?> <?php echo $this->lang->line('admission'); ?></a>                    
                 <?php } ?>
                 <?php if(has_permission(VIEW, 'student', 'admission')){ ?>
                   | <a href="<?php echo site_url('student/admission/index'); ?>"><?php echo $this->lang->line('online'); ?> <?php echo $this->lang->line('admission'); ?></a>                    
                 <?php } ?>   
                <?php if(has_permission(VIEW, 'student', 'activity')){ ?>
                   | <a href="<?php echo site_url('student/activity/index'); ?>"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('activity'); ?></a>                    
                 <?php } ?>
            </div>
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs bordered no-print">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_student_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('list'); ?></a> </li>
                                               
                        <li class="li-class-list">
                            <?php echo form_open(site_url('student/manage_canceled/index'), array('name' => 'filter', 'id' => 'filter', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <select  class="form-control col-md-7 col-xs-12" id="filter_class_id" name="class_id"  style="width:auto;" onchange="this.form.submit();">
                                        <option value="">--<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('class'); ?>--</option> 
                                    <?php if(isset($class_list) && !empty($class_list)){ ?>
                                        <?php foreach($class_list as $obj ){ ?>
                                            <option value="<?php echo $obj->id; ?>"><?php echo $obj->name; ?></option> 
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            <?php echo form_close(); ?>
                        </li>
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_student_list" >
                            <div class="x_content no-print">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>                                        
                                        <th><?php echo $this->lang->line('photo'); ?></th>
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('Telefone'); ?></th>
                                        <th><?php echo $this->lang->line('course'); ?></th>
                                        <th><?php echo $this->lang->line('period'); ?></th>
                                        <th><?php echo $this->lang->line('section'); ?></th>
                                        <th><?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('year'); ?></th>
                                        <th><?php echo "Matr." ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>  
                                    <?php $guardian_student_data = get_guardian_access_data('student'); ?> 
                                    <?php  $count = 1; if(isset($students) && !empty($students)){ ?>
                                        <?php foreach($students as $obj){ ?>
                                        <?php 
                                            if($this->session->userdata('role_id') == GUARDIAN){
                                                if (!in_array($obj->id, $guardian_student_data)) { continue; }
                                            }elseif($this->session->userdata('role_id') == TEACHER){
                                                if (!in_array($obj->class_id, $teacher_student_data)) { continue; }
                                            }
                                        ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>                                          
                                            <td>
                                                <?php  if($obj->photo != ''){ ?>
                                                <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $obj->photo; ?>" alt="" width="20" /> 
                                                <?php }else{ ?>
                                                <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="20" /> 
                                                <?php } ?>
                                            </td>
                                            <td><?php echo ucfirst($obj->name); ?></td>
                                            <td><?php echo $obj->phone; ?></td>
                                            <td><?php echo $obj->course_name; ?></td>
                                            <td><?php echo $this->lang->line($obj->period); ?></td>
                                            <td><?php echo $obj->section; ?></td>
                                            <td><?php echo $obj->class_name; ?></td>
                                            <td><?php echo $obj->academic_year; ?></td>
                                            <td><?php echo $obj->id; ?></td>
                                            <td width="100" nowrap="nowrap">  
                                                <?php if(has_permission(VIEW, 'student', 'student')){ ?>
                                                    <a href="javascript:void(0);" onclick="student_activity(<?php echo $obj->id; ?>);" class="btn btn-default btn-xs"><i class="fa fa-check" style="color:black"></i>  </a> 
                                                <?php } ?>                                             
                                               <?php if(has_permission(VIEW, 'student', 'student')){ ?>
                                                        <a href="javascript:void(0);" onclick="get_student_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-student-modal-lg" class="btn btn-success btn-xs"><i class="fa fa-eye"></i>  </a>
                                                <?php } ?>
                                                
                                                <?php if(has_permission(VIEW, 'student', 'student')){ ?>
                                                    <a href="javascript:void(0);" onclick="get_print_modal(<?php echo $obj->id; ?>);" class="btn btn-default btn-xs"><i class="fa fa-print"></i>  </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                            <div class="subscription_print">                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade bs-student-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('information'); ?></h4>
        </div>
        <div class="modal-body fn_student_data">
            
        </div>       
      </div>
    </div>
</div>
<script type="text/javascript">
         
    function get_student_modal(student_id){
         
        $('.fn_student_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('student/manage_canceled/get_single_student'); ?>",
          data   : {student_id : student_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_student_data').html(response);
             }
          }
       });
    }
</script>


<div class="modal fade bs-activity-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('activity'); ?> <?php echo $this->lang->line('information'); ?></h4>
        </div>
        <div class="modal-body fn_activity_data">
            
        </div>       
      </div>
    </div>
</div>
<script type="text/javascript">
         
    function get_activity_modal(activity_id){
         
        $('.fn_activity_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('student/activity/get_single_activity'); ?>",
          data   : {activity_id : activity_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_activity_data').html(response);
             }
          }
       });
    }
    function get_print_modal(student_id){         
         $('.fn_student_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
         $.ajax({       
           type   : "POST",
           url    : "<?php echo site_url('student/manage_canceled/get_single_student_print'); ?>",
           data   : {student_id : student_id},  
           success: function(response){                                                   
              if(response)
              {
                 $('.subscription_print').html(response);
              }
           }
        });
     }
     function student_activity(student_id){         
         $('.fn_student_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
         $.ajax({       
           type   : "POST",
           url    : "<?php echo site_url('student/manage_canceled/student_activity'); ?>",
           data   : {student_id : student_id},  
           success: function(response){ 
               
            location.reload(response);
              
           }
        });
     }
     
</script>

  
  <!-- bootstrap-datetimepicker -->
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
<script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
<!-- Super admin js START  -->
 <script type="text/javascript">
     
    var edit = false;
         
    $("document").ready(function() {
         <?php if(isset($edit) && !empty($edit)){ ?>
            $("#edit_school_id").trigger('change');            
         <?php } ?>
    });
     
    <?php if(isset($student) && !empty($student)){ ?>
          edit = true; 
    <?php } ?>
     school_change();
     function school_change(){
        var school_id = 1;        
        var class_id = '';
        var guardian_id = '';       
        var discount_id = ''; 
        var type_id = ''; 
        var course_id = ''; 
        
        <?php if(isset($edit) && !empty($edit)){ ?>
            class_id =  '<?php echo $student->class_id; ?>';
            guardian_id =  '<?php echo $student->guardian_id; ?>';
            discount_id =  '<?php echo $student->discount_id; ?>';
            type_id =  '<?php echo $student->type_id; ?>';
            course_id =  '<?php echo $student->course_id; ?>';
         <?php } ?> 
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>');
           return false;
        }
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:school_id, class_id:class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                   if(edit){
                       $('#edit_class_id').html(response);   
                   }else{
                       $('#add_class_id').html(response);   
                   }
                                    
                   get_guardian_by_school(school_id, guardian_id);
                   get_discount_by_school(school_id, discount_id);
                   get_student_type_by_school(school_id, type_id);
                   get_course_by_school(school_id, course_id);
                   $('#add_date_of_national_id').datepicker();
                    $('#edit_date_of_national_id').datepicker();
               }
            }
        });
     }    
     function get_course_by_school(school_id, course_id){
    
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_course_by_school'); ?>",
            data   : { school_id:school_id, course_id: course_id},               
            async  : false,
            success: function(response){                                                   
            if(response)
            {    
                if(edit){
                    $('#edit_course_id').html(response);
                }else{
                    $('#add_course_id').html(response); 
                }
            }
            }
        });
    }
    function get_guardian_by_school(school_id, guardian_id){
    
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_guardian_by_school'); ?>",
            data   : { school_id:school_id, guardian_id: guardian_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {    
                   if(edit){
                       $('#edit_guardian_id').html(response);
                   }else{
                       $('#add_guardian_id').html(response); 
                   }
               }
            }
        });
    }
        
    function get_discount_by_school(school_id, discount_id){
    
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_discount_by_school'); ?>",
            data   : { school_id:school_id, discount_id: discount_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {    
                   if(edit){
                       $('#edit_discount_id').html(response);
                   }else{
                       $('#add_discount_id').html(response); 
                   }
               }
            }
        });
    }
    
    function get_student_type_by_school(school_id, type_id){
    
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_student_type_by_school'); ?>",
            data   : { school_id:school_id, type_id: type_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {    
                   if(edit){
                       $('#edit_type_id').html(response);
                   }else{
                       $('#add_type_id').html(response); 
                   }
               }
            }
        });
    }
    
     
    $('#add_admission_date').datepicker();
    $('#edit_admission_date').datepicker();
    $('#add_dob').datepicker();
    $('#edit_dob').datepicker();
  
  <?php if(isset($edit)){ ?>
        get_section_by_class('<?php echo $student->class_id; ?>', '<?php echo $student->section_id; ?>');
    <?php } ?>
    
    function get_section_by_class(class_id, section_id){       
        
        var school_id = 1;       
             
       if(!school_id){
           toastr.error('<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>');
           return false;
        }
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_section_by_class'); ?>",
            data   : { school_id:school_id, class_id : class_id , section_id: section_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   if(edit){
                       $('#edit_section_id').html(response);
                   }else{
                       $('#add_section_id').html(response);
                   }
               }
            }
        });  
                     
        
   }
  </script>
  
  <!-- datatable with buttons -->
 <script type="text/javascript">
        $(document).ready(function() {
          $('#datatable-responsive').DataTable( {
              dom: 'Bfrtip',
              iDisplayLength: 15,
              buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdfHtml5',
                  'pageLength'
              ],
              search: true,              
              responsive: true
          });
        });
        
        
        function get_guardian_by_id(guardian_id){
            
            $.ajax({       
            type   : "POST",
            dataType: "json",
            url    : "<?php echo site_url('ajax/get_guardian_by_id'); ?>",
            data   : { guardian_id : guardian_id},               
            async  : true,
            success: function(response){ 
               if(response)
               {
                $('#add_phone').val(response.phone);  
                $('#add_present_address').val(response.present_address);  
                $('#add_permanent_address').val(response.permanent_address);  
                $('#add_religion').val(response.religion);  
               }else{
                    $('#add_phone').val('');  
                    $('#add_present_address').val('');  
                    $('#add_permanent_address').val('');  
                    $('#add_religion').val(''); 
               }
            }
        });  
        }
        
     /* Menu Filter Start */   
    function get_student_by_class(url){          
        if(url){
            window.location.href = url; 
        }
    }         
       
        
    <?php if(isset($filter_class_id)){ ?>
        get_class_by_school('1', '<?php echo $filter_class_id; ?>');
    <?php } ?>
    
    function get_class_by_school(school_id, class_id){
        
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id : school_id, class_id : class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                    $('#filter_class_id').html(response);                     
               }
            }
        });
    }    
    

         
    $("#add").validate();     
    $("#edit").validate();   
    
</script>