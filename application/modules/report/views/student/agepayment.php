<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-bar-chart"></i><small> <?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('age'); ?> <?php echo $this->lang->line('payment'); ?></small></h3>                
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            
            <?php $this->load->view('quick_report'); ?>   
            
             <div class="x_content filter-box  no-print"> 
                <?php echo form_open_multipart(site_url('report/studentagepayment'), array('name' => 'sbalance', 'id' => 'sbalance', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row">
                    <div class="col-md-offset-2 col-md-2  col-sm-offset-2  col-sm-2 col-xs-12">
                        <div class="item form-group">
                            <?php echo $this->lang->line('year'); ?> <span class="required">*</span>
                            <select  class="form-control col-md-7 col-xs-12" name="year" id="year" style='width:100%'>
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                <?php if(isset($academic_year) && !empty($academic_year)){ ?>
                                    <?php foreach($academic_year as $obj){ ?>                                                                                  
                                        <option value="<?php echo $obj->id ?>"  <?php if($year==$obj->id){echo "selected"; } ?>><?php echo $obj->start_year ?></option>                                           
                                        <?php } ?>
                                    <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2  col-sm-2 col-xs-12">
                        <div class="item form-group">
                            <?php echo $this->lang->line('class'); ?> 
                            <select  class="form-control col-md-7 col-xs-12" name="class_id" id="class_id" style='width:100%' onchange="get_age_by_year_class(this.value, '');">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                <?php if(isset($classes) && !empty($classes)){ ?>
                                    <?php foreach($classes as $obj){ ?>                                                                                  
                                        <option value="<?php echo $obj->id ?>" <?php if($class_id==$obj->id){echo "selected"; } ?> ><?php echo $obj->name ?></option>                                           
                                        <?php } ?>
                                    <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2  col-sm-2 col-xs-12">
                        <div class="item form-group">
                            <?php echo $this->lang->line('age'); ?> 
                            <select  class="form-control col-md-7 col-xs-12" name="age" id="age" style='width:100%'>
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                <?php if(isset($ages) && !empty($ages)){ ?>
                                    <?php foreach($ages as $obj){ ?>                                                                                  
                                        <option value="<?php echo $obj->id ?>"  <?php if($age==$obj->id){echo "selected"; } ?> ><?php echo $obj->id ?>(<?php echo $obj->name ?>)</option>                                           
                                        <?php } ?>
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
                                <h4 class="text-center">pedagogical secretariat</h4>
                                <div class="text-center"><strong>Year:</strong> <?php echo $year_date; ?>&nbsp;&nbsp;<strong>class:</strong> <?php echo $classname[0]->name;?>&nbsp;&nbsp;<strong>Age:</strong> <?php echo $age;?></div>
                            <div class="x_content">
                                <table id="datatable-keytable" class="datatable-responsive table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('sl_no'); ?></th>
                                            <th><?php echo $this->lang->line('student'); ?></th>
                                            <th><?php echo $this->lang->line('course'); ?></th>
                                            <th><?php echo $this->lang->line('sex'); ?></th>
                                            <th><?php echo $this->lang->line('age'); ?></th>                                        
                                        </tr>
                                    </thead>
                                    <tbody>   
                                        <?php 
                                        $total_balance = 0;                                  
                                        $maletotal=0;
                                        $femaletotal=0;
                                        $count = 1; if(isset($allpaymentagelist) && !empty($allpaymentagelist)){ ?>
                                            <?php foreach($allpaymentagelist as $obj){ ?>
                                            <?php 
                                                if( $obj->gender=='male'){
                                                    $maletotal++;
                                                }elseif($obj->gender=='female'){
                                                    $femaletotal++;
                                                }
                                                ?>
                                                
                                            <tr>
                                                <td><?php echo $count++; ?></td>  
                                                <td><?php echo $obj->student_name; ?></td>
                                                <td><?php echo $obj->course_name; ?></td>
                                                <td><?php echo $obj->gender; ?></td>
                                                <td><?php echo $obj->age; ?></td>
                                            </tr>
                                            <?php } ?>                                            
                                        <?php }else{ ?>
                                            <tr><td colspan="6" class="text-center"><?php echo $this->lang->line('no_data_found'); ?></td></tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="x_content text-right" >
                                <div class="row">
                                    <div class="col-md-9" style="width:75%">
                                    </div>
                                    <div class="col-md-3" style="width:25%">
                                        <table class="" cellspacing="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td width="50%"><strong> Male:</strong></td>
                                                    <td width="50%" style="background-color:#f5f5f5"><?php echo $maletotal; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong> Feminine:</strong></td>
                                                    <td width="50%" style="background-color:#f5f5f5"><?php echo $femaletotal; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong> Total:</strong></td>
                                                    <td width="50%" style="background-color:#f5f5f5"><?php echo $count-1; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>                                 
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
            
            <div class="row no-print">
                <div class="col-xs-12 text-center">
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

    // $("#sbalance").validate(); 
    
    $('#start_date').datepicker({
            format: "yyyy-mm-dd",
        });
    $('#end_date').datepicker({
        format: "yyyy-mm-dd",
    });
    
    <?php if(isset($year) && isset($class_id)  && isset($age)){ ?>
        get_age_by_year_class('<?php echo $class_id; ?>', '<?php echo $age; ?>');
    <?php } ?>
        
    function get_age_by_year_class(class_id, age){
        var year='';
            year=$("#year").val();
        var age='';
        <?php if(isset($year) && !empty($year)){ ?>
            year =  '<?php echo $year; ?>';          
         <?php } ?>  
         <?php if(isset($age) && !empty($age)){ ?>
            age =  '<?php echo $age; ?>';          
         <?php } ?>  
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('report/get_age_by_year_class'); ?>",
            data   : {year:year, class_id: class_id, age:age},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#age').html(response);
               }
            }
        });         
    }
   
      
   
    
       
</script>

