<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-bar-chart"></i><small> <?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('daily'); ?> <?php echo $this->lang->line('payment'); ?></small></h3>                
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            
            <?php $this->load->view('quick_report'); ?>   
            
             <div class="x_content filter-box  no-print"> 
                <?php echo form_open_multipart(site_url('report/studentdailypayment'), array('name' => 'sbalance', 'id' => 'sbalance', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row">    
                    
                    
                   <div class="col-md-offset-3 col-md-2 col-sm-offset-3 col-sm-2 col-xs-offset-3 col-xs-12">
                        <div class="item form-group"> 
                            <?php echo $this->lang->line('start_date'); ?> <span class="required">*</span>
                            <input type="text" class="form-control col-md-7 col-xs-12" id="start_date" name="start_date" value="<?php echo $start_date; ?>" placeholder="<?php echo $this->lang->line('start_date'); ?>" autocomplete="off" required="required">
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <?php echo $this->lang->line('end_date'); ?> <span class="required">*</span>
                            <input type="text" class="form-control col-md-7 col-xs-12" id="end_date" name="end_date" value="<?php echo $end_date; ?>" placeholder="<?php echo $this->lang->line('end_date'); ?>" autocomplete="off" required="required">
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
            <?php if(isset($view) && !empty($school)){ ?>
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <?php if(isset($school) && !empty($school)){ ?>
                    <div class="x_content">             
                       <div class="row">
                           <div class="col-sm-6 col-xs-6">
                               <div>
                                   <?php if($school->logo){ ?>
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" width="100" /> 
                                 <?php }else if($school->frontend_logo){ ?>
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->frontend_logo; ?>" alt=""   width="100"/> 
                                 <?php }else{ ?>                                                        
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->brand_logo; ?>" alt=""   width="100" />
                                 <?php } ?>
                                   <h4><?php echo $school->school_name; ?></h4>
                                   <!-- <div><?php echo $school->address; ?></div> -->
                                   <div>Tax ID:<?php echo $school->school_fax; ?></div>
                                    <div>STREET:<?php echo $school->address; ?></div>
                                    <div>Phone:<?php echo $school->phone; ?></div>
                                    <div>Email:<?php echo $school->email; ?></div>
                                    <div><?php echo $school->facebook_url; ?> | <?php echo $school->twitter_url; ?></div>
                                   <div class="clearfix">&nbsp;</div>
                               </div>
                           </div>
                            <div class="col-sm-6  col-xs-6">&nbsp;</div>
                       </div>            
                    </div>
                    <?php } ?>
                                        
                    <div class="tab-content">
                        <div  class="tab-pane fade in active" id="tab_tabular" >
                                <h4 class="text-center">Daily Movement</h4>
                                <div class="text-center">De:<?php echo $start_date; ?>&nbsp;&nbsp;a:<?php echo $end_date;?></div>
                            <div class="x_content">
                            <table id="datatable-keytable" class="datatable-responsive table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <th><?php echo $this->lang->line('course'); ?></th>
                                        <th><?php echo $this->lang->line('other'); ?> <?php echo $this->lang->line('product'); ?>s</th>
                                        <th><?php echo $this->lang->line('tuition'); ?></th>  
                                        <th>Inscrição</th>  
                                        <th><?php echo $this->lang->line('qtd'); ?></th>  
                                        <th>Matriculas</th>  
                                        <th><?php echo $this->lang->line('qtd'); ?></th>                                      
                                        <th><?php echo $this->lang->line('total'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php 
                                    $total_balance = 0;                                  
                                    $total_other_product = 0; 
                                    $total_tuition = 0; 
                                    $total_registration = 0; 
                                    $total_registration_qty = 0; 
                                    $total_admit = 0; 
                                    $total_admit_qty = 0; 
                                    $count = 1; 
                                    if(isset($allpaymentlist) && !empty($allpaymentlist)){ ?>
                                        <?php foreach($allpaymentlist as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>  
                                            <td><?php echo $obj->course_name; ?></td>
                                            <td><?php echo $obj->other_product; $total_other_product += $obj->other_product;  ?></td>
                                            <td><?php echo $obj->tuition; $total_tuition += $obj->tuition; ?></td>
                                            <td><?php echo $obj->registration; $total_registration += $obj->registration; ?></td>
                                            <td><?php echo $obj->registration_qty; $total_registration_qty += $obj->registration_qty; ?></td>
                                            <td class="blue"><?php echo $obj->admit;$total_admit += $obj->admit; ?></td>
                                            <td class="green"><?php echo $obj->admit_qty; $total_admit_qty += $obj->admit_qty;?></td>
                                            <td class="red"><?php echo $obj->total; $total_balance += $obj->total; ?></td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="2"><strong><?php echo $this->lang->line('total'); ?></strong></td>
                                            <td class="red"><strong><?php echo number_format($total_other_product,2); ?></strong></td>  
                                            <td class="red"><strong><?php echo number_format($total_tuition,2); ?></strong></td>  
                                            <td class="red"><strong><?php echo number_format($total_registration,2); ?></strong></td>
                                            <td class="red"><strong><?php echo number_format($total_registration_qty); ?></strong></td>
                                            <td class="red"><strong><?php echo number_format($total_admit,2); ?></strong></td>
                                            <td class="red"><strong><?php echo number_format($total_admit_qty); ?></strong></td>
                                            <td class="red"><strong><?php echo number_format($total_balance,2); ?></strong></td>                                           
                                        </tr>
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
            <?php } ?>
        </div>
    </div>
</div>
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
<script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
 <script type="text/javascript">

    $("#sbalance").validate(); 
    
    $('#start_date').datepicker({
            format: "yyyy-mm-dd",
        });
    $('#end_date').datepicker({
        format: "yyyy-mm-dd",
    });
    function get_academic_year_by_school(school_id, academic_year_id){       
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_academic_year_by_school'); ?>",
            data   : { school_id:school_id, academic_year_id :academic_year_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                    $('#academic_year_id').html(response); 
               }
            }
        });
   }  
      
      
        
    function get_class_by_school(school_id, class_id){       
        
        if(!school_id){
            school_id = $('#school_id').val();
        }
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:school_id, class_id:class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                   $('#class_id').html(response);  
               }
            }
        });         
    }
      
    
    <?php if(isset($class_id) && isset($student_id)){ ?>
        get_student_by_class('<?php echo $school_id; ?>', '<?php echo $class_id; ?>', '<?php echo $student_id; ?>');
    <?php } ?>
        
    function get_student_by_class(school_id, class_id, student_id){       
           
        if(!school_id){
            school_id = $('#school_id').val();
        }
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_student_by_class'); ?>",
            data   : {school_id:school_id, class_id: class_id, student_id:student_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#student_id').html(response);
               }
            }
        });         
    }
    
       
</script>

