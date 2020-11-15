<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-bar-chart"></i><small> <?php echo $this->lang->line('list'); ?> <?php echo $this->lang->line('subscriptions'); ?> <?php echo $this->lang->line('report'); ?></small></h3>                
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            
            <?php $this->load->view('quick_report'); ?>
             <div class="x_content filter-box  no-print"> 
                <?php echo form_open_multipart(site_url('report/listadmissao'), array('name' => 'sbalance', 'id' => 'sbalance', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row"> 
                   <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <?php echo $this->lang->line('academic_year'); ?>
                            <select  class="form-control col-md-7 col-xs-12" name="academic_year_id" id="academic_year_id">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($academic_years as $obj) { ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($academic_year_id) && $academic_year_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->session_year; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>  
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <?php echo $this->lang->line('course'); ?>
                            <select  class="form-control col-md-7 col-xs-12" name="course_id" id="course_id">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($courses as $obj) { ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($course_id) && $course_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <?php echo $this->lang->line('class'); ?>
                            <select  class="form-control col-md-7 col-xs-12" name="class_id" id="class_id" onchange="get_section_by_class(this.value, '');">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($classes as $obj) { ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <?php echo $this->lang->line('section'); ?>
                            <select  class="form-control col-md-7 col-xs-12" name="section_id" id="section_id">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                               
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <?php echo $this->lang->line('period'); ?>
                            <select  class="form-control col-md-7 col-xs-12" name="period_id" id="period_id">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php $periods = get_period(); ?>
                                    <?php foreach($periods as $key=>$value){ ?>
                                        <option value="<?php echo $key; ?>" <?php echo isset($period) && $period == $key ?  'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                                    <?php } ?>                            
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group"><br/>
                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="x_content">
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
                                   <h4><?php echo $school->school_name; ?></h4>
                                   
                                   <h3 class="head-title ptint-title" style="width: 100%;"><i class="fa fa-bar-chart"></i><small> <?php echo $this->lang->line('list'); ?> de <?php echo $this->lang->line('attendance'); ?> <?php echo $this->lang->line('subscriptions'); ?> </small></h3>                
                                   <?php if(isset($academic_year)){ ?>
                                   <div class="clearfix">&nbsp;</div>
                                   <div><?php echo $this->lang->line('academic_year'); ?>: <?php echo $academic_year; ?>
                                   </div>
                                   <?php } ?>
                                   
                                   <h4></h4>
                                   <div>
                                   <?php if(isset($course_id) && !empty($course_id)){ ?>
                                    <strong><?php echo $this->lang->line('course'); ?>:</strong> <?php echo $course_name; ?>
                                   <?php } ?>&nbsp;&nbsp;
                                   <?php if(isset($class_id) && !empty($class_id)){ ?>
                                    <strong><?php echo $this->lang->line('class'); ?>:</strong> <?php echo $class_name; ?>
                                   <?php } ?> &nbsp;&nbsp;
                                   <?php if(isset($section_id) && !empty($section_id)){ ?>
                                    <strong><?php echo $this->lang->line('section'); ?>:</strong> <?php echo $section_name; ?>
                                   <?php } ?>&nbsp;&nbsp;
                                   <?php if(isset($period) && !empty($period)){ ?>
                                    <strong><?php echo $this->lang->line('period'); ?>:</strong> <?php echo $this->lang->line($period); ?>
                                   <?php } ?>
								   </div>
                                   </h4>
                                   <div class="clearfix">&nbsp;</div>
                               </div>
                           </div>
                            <div class="col-sm-3  col-xs-3">&nbsp;</div>
                       </div>            
                    </div>
                    <?php } ?>
                    
                    
                    <ul  class="nav nav-tabs bordered  no-print">
                        <li class="active"><a href="#tab_tabular"   role="tab" data-toggle="tab"   aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('tabular'); ?> <?php echo $this->lang->line('report'); ?></a> </li>
                    </ul>
                    <br/>
                    
                                        
                    <div class="tab-content">
                        <div  class="tab-pane fade in active" id="tab_tabular" >
                            <div class="x_content">
                            <table  class="datatable-responsive table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
										<th><?php echo 'Nº Inscrição' ?></th>
                                        <th><?php echo $this->lang->line('name'); ?> <?php echo $this->lang->line('student'); ?> </th>
                                        <th><?php echo 'Assin. Estudante' ?> </th>
                                        <th><?php echo 'Nota' ?> </th>
                                                                               
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php 
                                    $total_balance = 0;                                  
                                    
                                    $count = 1; if(isset($subscriptionslist) && !empty($subscriptionslist)){ ?>
                                        <?php foreach($subscriptionslist as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>  
											<td><?php echo $obj->admission; ?></td> 
                                            <td><?php echo $obj->student_name; ?></td>
                                            <td><?php echo '________________________' ?></td>
                                            <td><?php echo '___________' ?></td>
                                            
                                        </tr>
                                        <?php } ?>                                        
                                    <?php }else{ ?>
                                        <tr><td colspan="6" class="text-center"><?php echo $this->lang->line('no_data_found'); ?></td></tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
            
            <div class="row no-print">
                <div class="col-xs-12 text-right">
                    <button class="btn btn-default " onclick="window.print();"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
                </div>
            </div>
            
        </div>
    </div>
</div>
 <script type="text/javascript">

    // $("#sbalance").validate(); 
    
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
     
   
            

       
</script>

