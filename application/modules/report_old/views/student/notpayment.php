<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-bar-chart"></i><small> <?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('not'); ?> <?php echo $this->lang->line('payment'); ?></small></h3>                
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            
            <?php $this->load->view('quick_report'); ?> 
            
            
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
                                <h4 class="text-center">Unpaid Tuition Listing</h4>
                                <div class="text-center">De:<?php echo $start_date; ?>&nbsp;&nbsp;a:<?php echo $end_date;?></div>
                            <div class="x_content">
                            <table id="datatable-keytable" class="datatable-responsive table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <th><?php echo $this->lang->line('student'); ?></th>
                                        <th><?php echo $this->lang->line('telephone'); ?></th>
                                        <th><?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('course'); ?></th>
                                        <th><?php echo $this->lang->line('academic'); ?> <?php echo $this->lang->line('year'); ?></th>
                                        <th><?php echo $this->lang->line('last'); ?> <?php echo $this->lang->line('month'); ?> <?php echo $this->lang->line('paid'); ?></th>
                                        <th><?php echo $this->lang->line('value'); ?></th>
                                        <th>+<?php echo $this->lang->line('fine'); ?></th>
                                        <th><?php echo $this->lang->line('delay'); ?> <?php echo $this->lang->line('month'); ?>s</th>                                        
                                        <th><?php echo $this->lang->line('total'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php 
                                    $total_balance = 0;
                                    $total_find=0;
                                    $count = 1; if(isset($allnotpaymentlist) && !empty($allnotpaymentlist)){?>
                                        <?php foreach($allnotpaymentlist as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>  
                                            <td><?php echo $obj->student_name; ?></td>
                                            <td><?php echo $obj->phone; ?></td>
                                            <td><?php echo $obj->class_name; ?></td>
                                            <td><?php echo $obj->course_name; ?></td>
                                            <td><?php echo $obj->session_year; ?></td>
                                            <td><?php echo $obj->last_mon; ?></td>
                                            <td><?php echo $obj->last_pay; ?></td>
                                            <td><?php echo $obj->mulct; $total_find+=$obj->mulct;  ?></td>
                                            <td><?php echo $obj->monpay; ?></td>
                                            <td><?php echo number_format($obj->mon_total,2); $total_balance+=$obj->mon_total;?></td>
                                        </tr>
                                        <?php } ?>                                        
                                    <?php }else{ ?>
                                        <tr><td colspan="11" class="text-center"><?php echo $this->lang->line('no_data_found'); ?></td></tr>
                                    <?php } ?>
                                        
                                </tbody>
                            </table>
                            </div>
                            <div class="row">
                                <div class="col-md-8" style="width:66.6%" >&nbsp;</div>
                                <div class="col-md-4" style="width:33.3%">
                                    <table  class="" cellspacing="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td class="text-right" width="50%"><strong><?php echo $this->lang->line('total'); ?> <?php echo $this->lang->line('student'); ?>s:</strong></td>
                                                    <td  width="50%" class="text-center " style="background-color:#f5f5f5"><strong><?php echo $count-1; ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td  width="50%" class="text-right red"><strong><?php echo $this->lang->line('unpaid'); ?> <?php echo $this->lang->line('total'); ?>:</strong></td>
                                                    <td  width="50%" class="text-center " style="background-color:#f5f5f5"><strong><?php echo number_format($total_balance,2); ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right red"><strong><?php echo $this->lang->line('total'); ?> + <?php echo $this->lang->line('fine'); ?>s:</strong></td>
                                                    <td  width="50%" class="text-center " style="background-color:#f5f5f5"><strong><?php echo number_format($total_balance+$total_find,2); ?></strong></td>
                                                </tr>
                                            </tbody>
                                    </table>
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

    $("#sbalance").validate(); 
    
    $('#start_date').datepicker({
            format: "yyyy-mm-dd",
        });
    $('#end_date').datepicker({
        format: "yyyy-mm-dd",
    });
    
    
       
</script>

