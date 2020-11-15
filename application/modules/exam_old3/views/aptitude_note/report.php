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
                    <table id="datatable-keytable" class="datatable-responsive table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><?php echo $this->lang->line('sl_no'); ?></th>
                                <th><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('name'); ?></th>
                                <th><?php echo $this->lang->line('course'); ?> <?php echo $this->lang->line('name'); ?></th>
                                <th><?php echo $this->lang->line('grade'); ?></th>
                                <th><?php echo $this->lang->line('remark'); ?></th>
                                <th  class='text-center'><?php echo $this->lang->line('action'); ?></th>                                        
                            </tr>
                        </thead>
                        <tbody>   
                            <?php 
                            $total_balance = 0;                                  
                            $count = 1; if(isset($data) && !empty($data)){ ?>
                                <?php foreach($data as $obj){ ?>
                                
                                    <?php $style= ($obj['grade']>=10) ? 'color:blue': 'color:red';   ?>
                                    <td><?php echo $count++; ?></td>  
                                    <td><?php echo $obj['name']; ?></td>
                                    <td><?php echo $obj['course']; ?></td>
                                    <td style='<?php echo $style ?>'><?php echo $obj['grade']; ?></td>
                                    <td style='<?php echo $style ?>'><?php echo $obj['status']; ?></td>
                                    <td class='text-center'>
                                    <?php if($obj['grade']>=10) {  ?>
                                        <input type="checkbox" class='text-center' id="admitted_action" >
                                    <?php }?>
                                    </td>
                                    <input type="hidden" value="<?php echo $obj['student_id']; ?>">
                                    <input type="hidden" value="<?php echo $obj['grade_id']; ?>">
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
        <div class="row no-print">
            <div class="col-xs-12 text-right">
                <button class="btn btn-default " onclick="window.print();"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
            </div>
        </div>