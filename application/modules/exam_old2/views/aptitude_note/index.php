<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-file-text-o"></i><small> <?php echo $this->lang->line('manage'); ?> <?php echo $this->lang->line('aptitude'); ?> <?php echo $this->lang->line('note'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <style>
                .text_blue{
                    color:blue;
                }
                .text_red{
                    color:red;
                }
                @media print {
                    .text_blue{
                    color:blue !important;
                    }
                    .text_red{
                        color:red  !important;
                    }
                }
            </style>
              
            <div class="x_content quick-link no-print">
                 <span><?php echo $this->lang->line('quick_link'); ?>:</span>
                <?php if(has_permission(VIEW, 'exam', 'mark')){ ?>
                    <a href="<?php echo site_url('exam/mark/index'); ?>"><?php echo $this->lang->line('manage_mark'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'exam', 'examresult')){ ?>
                   | <a href="<?php echo site_url('exam/examresult/index'); ?>"><?php echo $this->lang->line('exam_term'); ?> <?php echo $this->lang->line('result'); ?></a>                 
                <?php } ?>
                <?php if(has_permission(VIEW, 'exam', 'finalresult')){ ?>
                   | <a href="<?php echo site_url('exam/finalresult/index'); ?>"><?php echo $this->lang->line('exam_final_result'); ?></a>                 
                <?php } ?>
                <?php if(has_permission(VIEW, 'exam', 'meritlist')){ ?>
                   | <a href="<?php echo site_url('exam/meritlist/index'); ?>"><?php echo $this->lang->line('merit_list'); ?></a>                 
                <?php } ?>   
                <?php if(has_permission(VIEW, 'exam', 'marksheet')){ ?>
                   | <a href="<?php echo site_url('exam/marksheet/index'); ?>"><?php echo $this->lang->line('mark_sheet'); ?></a>
                <?php } ?>
                 <?php if(has_permission(VIEW, 'exam', 'resultcard')){ ?>
                   | <a href="<?php echo site_url('exam/resultcard/index'); ?>"><?php echo $this->lang->line('result_card'); ?></a>
                <?php } ?>   
                <?php if(has_permission(VIEW, 'exam', 'resultcard')){ ?>
                   | <a href="<?php echo site_url('exam/resultcard/all'); ?>"><?php echo $this->lang->line('all'); ?> <?php echo $this->lang->line('result_card'); ?></a>
                <?php } ?>     
                <?php if(has_permission(VIEW, 'exam', 'mail')){ ?>
                   | <a href="<?php echo site_url('exam/mail/index'); ?>"><?php echo $this->lang->line('mark_send_by_email'); ?></a>                    
                <?php } ?>
                <?php if(has_permission(VIEW, 'exam', 'text')){ ?>
                   | <a href="<?php echo site_url('exam/text/index'); ?>"><?php echo $this->lang->line('mark_send_by_sms'); ?></a>                  
                <?php } ?>
                <?php if(has_permission(VIEW, 'exam', 'resultemail')){ ?>
                   | <a href="<?php echo site_url('exam/resultemail/index'); ?>"> <?php echo $this->lang->line('result'); ?> <?php echo $this->lang->line('email'); ?></a>                    
                <?php } ?>
                <?php if(has_permission(VIEW, 'exam', 'resultsms')){ ?>
                   | <a href="<?php echo site_url('exam/resultsms/index'); ?>"> <?php echo $this->lang->line('result'); ?> <?php echo $this->lang->line('sms'); ?></a>                  
                <?php } ?>
            </div>      
            
            <div class="x_content  no-print"> 
                <?php echo form_open_multipart(site_url('exam/aptitudenote/index'), array('name' => 'result', 'id' => 'result', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row"> 
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('exam'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="exam_id" id="exam_id"  required="required">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($exams as $obj) { ?>
                                <option value="<?php echo $obj->id; ?>" <?php if(isset($exam_id) && $exam_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->title; ?></option>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('exam_id'); ?></div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('course'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="course_id" id="course_id"  required="required">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($courses as $obj) { ?>
                                <option value="<?php echo $obj->id; ?>" <?php if(isset($course_id) && $course_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('course_id'); ?></div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('class'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="class_id" id="class_id"  required="required" onchange="get_section_by_class(this.value, '');">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($classes as $obj) { ?>
                                <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('class_id'); ?></div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('section'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="section_id" id="section_id"  required="required">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('period'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="period_id" id="period_id">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php $periods = get_period(); ?>
                                    <?php foreach($periods as $key=>$value){ ?>
                                        <option value="<?php echo $key; ?>" <?php echo isset($period_id) && $period_id == $key ?  'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                                    <?php } ?>                            
                            </select>
                        </div>
                    </div>                 
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="form-group"><br/>
                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
           <?php  if (isset($students) && !empty($students)) { ?>
            <div class="x_content  no-print">             
                <div class="row">
                    <div class="col-sm-4  col-sm-offset-4 layout-box">
                        <p>
                            <h4><?php echo $this->lang->line('exam_term'); ?> <?php echo $this->lang->line('result'); ?></h4>                            
                            <?php if(isset($academic_year)){ ?>
                            <div class="clearfix">&nbsp;</div>
                            <div><?php echo $this->lang->line('academic_year'); ?>: <?php echo $academic_year; ?></div>
                            <?php } ?>
                            <div><?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('title'); ?>: <?php echo $exam->title; ?></div>
                            <div><strong style="color:red"><?php echo $this->lang->line('class'); ?>:</strong><?php echo $class_name; ?> &nbsp;&nbsp;&nbsp;<strong style="color:red"><?php echo $this->lang->line('section'); ?>:</strong><?php echo $section_name; ?>&nbsp;&nbsp;&nbsp;<strong style="color:red"><?php echo $this->lang->line('period'); ?>:</strong><?php echo $this->lang->line($period_id); ?></div>
                        </p>
                    </div>
                </div>            
            </div>
            <?php } ?>
            
            <div class="x_content ">
                 <?php echo form_open(site_url('exam/aptitudenote/add'), array('name' => 'add', 'id' => 'add', 'class'=>' no-print form-horizontal form-label-left'), ''); ?>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo $this->lang->line('roll_no'); ?></th>
                            <th><?php echo $this->lang->line('name'); ?></th>
                            <th><?php echo $this->lang->line('photo'); ?></th>  
                            <th><?php echo $this->lang->line('course'); ?></th>                            
                            <th> <?php echo $this->lang->line('grade'); ?></th>                                            
                            <th><?php echo $this->lang->line('grade'); ?> <?php echo $this->lang->line('type'); ?></th>                                            
                            <th><?php echo $this->lang->line('remark'); ?></th>                                            
                        </tr>
                    </thead>
                    <tbody id="fn_result">   
                        <?php
                        $count = 1;
                        if (isset($students) && !empty($students)) {
                            ?>
                            <?php foreach ($students as $obj) { ?>                           
                            <?php  
                            $result = get_exam_result($school_id, $exam_id, $obj->id, $academic_year_id,  $class_id, $section_id ); 
                            $mark = get_exam_total_mark($school_id, $exam->id, $obj->id, $academic_year_id,  $class_id, $section_id );
                            ?>
                                <tr>
                                    <td><?php echo $obj->roll_no; ?></td>
                                    <td><?php echo ucfirst($obj->name); ?></td>
                                    <td>
                                        <?php if ($obj->photo != '') { ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $obj->photo; ?>" alt="" width="45" /> 
                                        <?php } else { ?>
                                            <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="45" /> 
                                        <?php } ?>
                                        <input type="hidden" value="<?php echo $obj->id; ?>"  name="students[]" />       
                                    </td>  
                                    <td> 
                                        <?php echo $obj->course_name; ?>
                                    </td>                                   
                                    <td>
                                        <input class="form-control col-md-7 col-xs-12 " type="text" name="avg_grade_point[<?php echo $obj->id; ?>]" value="<?php echo @number_format($mark->total_point/$mark->total_subject,2); ?>" style="width: 60px;"  autocomplete="off"/>
                                    </td>  
                                    <td>
                                        <select class="form-control col-md-7 col-xs-12" name="grade_id[<?php echo $obj->id; ?>]"  required="required">                                
                                             <?php foreach ($grades as $grade) { ?>
                                            <option value="<?php echo $grade->id; ?>" selected><?php echo $grade->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>   
                                    <td><input type="text" value="<?php if(isset($result) && $result->remark != ''){ echo $result->remark; } ?>"  name="remark[<?php echo $obj->id; ?>]" class="form-control col-md-7 col-xs-12"  autocomplete="off"/></td>
                                </tr>
                            <?php } ?>
                        <?php }else{ ?>
                                <tr>
                                    <td colspan="7" align="center"><?php echo $this->lang->line('no_data_found'); ?></td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-5">
                        <input type="hidden" value="<?php echo isset($school_id) ? $school_id : ''; ?>"  name="school_id" />
                        <input type="hidden" value="<?php echo isset($exam_id) ? $exam_id : ''; ?>"  name="exam_id" />
                        <input type="hidden" value="<?php echo isset($course_id) ? $course_id : ''; ?>"  name="course_id" />
                        <input type="hidden" value="<?php echo isset($class_id) ? $class_id : ''; ?>"  name="class_id" />
                        <input type="hidden" value="<?php echo isset($section_id) ? $section_id : ''; ?>"  name="section_id" />
                        <input type="hidden" value="<?php echo isset($period_id) ? $period_id : ''; ?>"  name="period_id" />
                        <?php  if (isset($students) && !empty($students)) { ?>
                         <a href="<?php echo site_url('exam/aptitudenote'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                         <?php   if($this->session->userdata('role_id') == '1'){ ?>
                         <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                         <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                 <?php echo form_close(); ?>
                
                <div class="col-md-12 col-sm-12 col-xs-12  no-print">
                    <div class="instructions"><strong><?php echo $this->lang->line('instruction'); ?>: </strong> <?php echo $this->lang->line('exam_result_instruction'); ?></div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 report_html">
                <?php if(isset($report)){ ?>
                    <div class="x_content" style="margin-top:50px;">
                        <div class="" data-example-id="togglable-tabs">        
                            <?php if(isset($school) && !empty($school)){ ?>
                            <div class="x_content">             
                                <div class="row">
                                    <div class="col-sm-3 col-xs-3">&nbsp;</div>
                                    <div class="col-sm-6  col-xs-6 layout-box">
                                    <div>
                                        <?php if($school->logo){ ?>
                                        <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" width='100'/> 
                                        <?php }else if($school->frontend_logo){ ?>
                                        <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->frontend_logo; ?>" alt=""width='100' /> 
                                        <?php }else{ ?>                                                        
                                        <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->brand_logo; ?>" alt=""width='100'  />
                                        <?php } ?>
                                        <h4><?php echo $school[0]->school_name; ?></h4>
                                        <div><?php echo $school[0]->address; ?></div>
                                        <h3 class="head-title ptint-title" style="width: 100%;"><i class="fa fa-bar-chart"></i><small> <?php echo $this->lang->line('aptitude'); ?> <?php echo $this->lang->line('note'); ?></small></h3>                
                                        <?php if(isset($academic_year)){ ?>
                                        <div class="clearfix">&nbsp;</div>
                                        <div><?php echo $this->lang->line('academic_year'); ?>: <?php echo $academic_year; ?></div>
                                        <?php } ?>
                                        <div><?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('title'); ?>: <?php echo $exam->title; ?></div>
                                        <div><strong style="color:red"><?php echo $this->lang->line('class'); ?>:</strong><?php echo $class_name; ?> &nbsp;&nbsp;&nbsp;<strong style="color:red"><?php echo $this->lang->line('section'); ?>:</strong><?php echo $section_name; ?>&nbsp;&nbsp;&nbsp;<strong style="color:red"><?php echo $this->lang->line('period'); ?>:</strong><?php echo $this->lang->line($period_id); ?></div>
                                        <div class="clearfix">&nbsp;</div>
                                    </div>
                                    </div>
                                    <div class="col-sm-3  col-xs-3">&nbsp;</div>
                                </div>            
                            </div>
                            <?php } ?> 
                                                            
                            <div class="tab-content" >
                                <div  class="tab-pane fade in active" id="tab_tabular" >
                                    <div class="x_content" style='padding-top:50px;'>
                                        <?php $i=1; ?>
                                        <?php if(isset($alldata) && !empty($alldata)){ ?>
                                        <?php foreach ($alldata as $data){ ?>
                                            <hr>
                                            <h3 ><?php echo $i++; ?>º Prova </h3>
                                            <table id="datatable-keytable" class="datatable-responsive table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                                        <th><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('name'); ?></th>
                                                        <th><?php echo $this->lang->line('course'); ?> <?php echo $this->lang->line('name'); ?></th>
                                                        <th><?php echo $this->lang->line('class'); ?></th>
                                                        <th><?php echo $this->lang->line('section'); ?></th>
                                                        <th><?php echo $this->lang->line('period'); ?></th>
                                                        <th><?php echo $this->lang->line('grade'); ?></th>
                                                        <th><?php echo $this->lang->line('remark'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>   
                                                    <?php 
                                                    $total_balance = 0;                                  
                                                    $count = 1; if(isset($data) && !empty($data)){ ?>
                                                        <?php foreach($data as $obj){ ?>                                                        
                                                            <?php $class = ($obj->avg_grade_point>=9.5) ? 'text_blue': 'text_red';   ?>
                                                            <td><?php echo $count++; ?></td>  
                                                            <td><?php echo $obj->student_name; ?></td>
                                                            <td><?php echo $obj->course_name; ?></td>
                                                            <td><?php echo $obj->class_name; ?></td>
                                                            <td><?php echo $obj->section_name; ?></td>
                                                            <td><?php echo $this->lang->line($obj->period); ?></td>
                                                            <td class='<?php echo $class ?>'><?php echo $obj->avg_grade_point; ?></td>
                                                            <td class='<?php echo $class ?>'><?php echo $this->lang->line($obj->result_status); ?></td>                                                          
                                                            <input type="hidden" value="<?php echo $obj->student_id; ?>">
                                                            <input type="hidden" value="<?php echo $obj->grade_id; ?>">
                                                        </tr>
                                                        <?php } ?>                                        
                                                    <?php }else{ ?>
                                                        <tr><td colspan="6" class="text-center"><?php echo $this->lang->line('no_data_found'); ?></td></tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>                        
                            </div>
                            <div class="row no-print">
                                <div class="col-xs-12 text-right">
                                    <button class="btn btn-default " onclick="window.print();"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
                                </div>
                            </div>
                        </div>
                  <?php } ?>
                </div>
            </div> 
            
        </div>
    </div>
</div>


<!-- Super admin js START  -->
 <script >
     $("document").ready(function() {
         <?php if(isset($class_id) && !empty($section_id)){ ?>
            get_section_by_class('<?php echo $class_id; ?>', '<?php echo $section_id; ?>');
         <?php } ?>
    });

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
                $('#section_id').html(response);                 
               }
            }
        });  
                     
        
   }
    $("#admitted_action").change(function() {
        if(this.checked) {
           var student_id=$(this).parent().parent()[0].children[6].value;
           var grade_id=$(this).parent().parent()[0].children[7].value;
           var avg_grade_point=$(this).parent().parent()[0].children[3].innerText;
           var remark="Approved";
           var exam_id=$("#exam_id").val();
           $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('exam/aptitudenote/student_add'); ?>",
            data   : { 
                student_id:student_id, 
                exam_id:exam_id,
                grade_id:grade_id,
                avg_grade_point:avg_grade_point,
                remark:remark
                },               
            async  : false,
            success: function(response){      
                   if(response)
                   { 
                        window.open("../../student/edit/"+response);
                   }
            }
            });
        }
    });
    school_change(1);
    function school_change(school_id){
        var school_id = 1;
        var exam_id = '';
        var class_id = '';
        <?php if(isset($school_id) && !empty($school_id)){ ?>
            exam_id =  '<?php echo $exam_id; ?>';           
            class_id =  '<?php echo $class_id; ?>';           
         <?php } ?> 
           
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>');
           return false;
        }       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_exam_by_school'); ?>",
            data   : { school_id:school_id, exam_id:exam_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                    $('#exam_id').html(response);  
                   get_class_by_school(school_id,class_id); 
               }
            }
        });
    }

  

   function get_class_by_school(school_id, class_id){       
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:1, class_id:class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                    $('#class_id').html(response); 
               }
            }
        }); 
   }       
  
    <?php if(isset($class_id) && isset($section_id)){ ?>
        get_section_by_class('<?php echo $class_id; ?>', '<?php echo $section_id; ?>');
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
            data   : {school_id:school_id, class_id : class_id , section_id: section_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#section_id').html(response);
               }
            }
        });         
    } 
    $("#result").validate(); 
    $("#add").validate(); 
</script>
<style>
#datatable-responsive label.error{display: none !important;}
</style>


