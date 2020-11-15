<style>
.select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: unset !important;
    user-select: none;
    -webkit-user-select: none;
}
#tab_view_studentpayment{
    color:#000 !important;
}
th, td{
    padding:3px;
}
.background_title {                   
    background: #f5f5f5  !important;    
}
@media print {
        .background_title {                   
            background: #f5f5f5  !important;    
        }
    } 
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title no-print">
                <h3 class="head-title"><i class="fa fa-calculator"></i><small> <?php echo $this->lang->line('manage'); ?> <?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('payment'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content no-print quick-link">
                <span><?php echo $this->lang->line('quick_link'); ?>:</span>
               <?php if(has_permission(VIEW, 'accounting', 'discount')){ ?>
                    <a href="<?php echo site_url('accounting/discount/index'); ?>"><?php echo $this->lang->line('discount'); ?></a>                  
                <?php } ?> 
              
               <?php if(has_permission(VIEW, 'accounting', 'feetype')){ ?>
                  | <a href="<?php echo site_url('accounting/feetype/index'); ?>"><?php echo $this->lang->line('fee_type'); ?></a>                  
                <?php } ?> 
                
                <?php if(has_permission(VIEW, 'accounting', 'invoice')){ ?>
                   
                   <?php if($this->session->userdata('role_id') == STUDENT || $this->session->userdata('role_id') == GUARDIAN){ ?>
                        | <a href="<?php echo site_url('accounting/invoice/due'); ?>"><?php echo $this->lang->line('due_invoice'); ?></a>                    
                   <?php }else{ ?>
                        | <a href="<?php echo site_url('accounting/invoice/add'); ?>"><?php echo $this->lang->line('fee'); ?> <?php echo $this->lang->line('collection'); ?></a>
                        | <a href="<?php echo site_url('accounting/invoice/index'); ?>"><?php echo $this->lang->line('manage_invoice'); ?></a>
                        | <a href="<?php echo site_url('accounting/invoice/due'); ?>"><?php echo $this->lang->line('due_invoice'); ?></a>                    
                    <?php } ?> 
                <?php } ?> 
                  
                <?php if(has_permission(VIEW, 'accounting', 'duefeeemail')){ ?>
                   | <a href="<?php echo site_url('accounting/duefeeemail/index'); ?>"><?php echo $this->lang->line('due_fee'); ?> <?php echo $this->lang->line('email'); ?></a>                  
                <?php } ?>
                 <?php if(has_permission(VIEW, 'accounting', 'duefeesms')){ ?>
                   | <a href="<?php echo site_url('accounting/duefeesms/index'); ?>"><?php echo $this->lang->line('due_fee'); ?> <?php echo $this->lang->line('sms'); ?></a>                  
                <?php } ?>         
                        
                 <?php if(has_permission(VIEW, 'accounting', 'incomehead')){ ?>
                  | <a href="<?php echo site_url('accounting/incomehead/index'); ?>"><?php echo $this->lang->line('income_head'); ?></a>                  
                <?php } ?> 
                 <?php if(has_permission(VIEW, 'accounting', 'income')){ ?>
                   | <a href="<?php echo site_url('accounting/income/index'); ?>"><?php echo $this->lang->line('income'); ?></a>                     
                <?php } ?>  
                <?php if(has_permission(VIEW, 'accounting', 'exphead')){ ?>
                   | <a href="<?php echo site_url('accounting/exphead/index'); ?>"><?php echo $this->lang->line('expenditure_head'); ?></a>                  
                <?php } ?> 
                <?php if(has_permission(VIEW, 'accounting', 'expenditure')){ ?>
                   | <a href="<?php echo site_url('accounting/expenditure/index'); ?>"><?php echo $this->lang->line('expenditure'); ?></a>                  
                <?php } ?> 
            </div>
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs no-print bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_studentpayment_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'accounting', 'studentpayment')){ ?>
                             <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('accounting/studentpayment/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('payment'); ?></a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_studentpayment"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('payment'); ?></a> </li>                          
                            <?php } ?> 
                        <?php } ?>
                        <?php if(isset($view) && $view==1){ ?>
                            <li   class="<?php if(isset($view)){ echo 'active'; }?>"><a href="#tab_view_studentpayment"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> <?php echo $this->lang->line('payment'); ?></a> </li>                          
                        <?php } ?>                      
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_studentpayment_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>                                       
                                        <th><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('total'); ?> <?php echo $this->lang->line('paid'); ?></th>
                                        <th><?php echo $this->lang->line('bank'); ?> <?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('type'); ?></th>
                                        <th><?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('reference'); ?></th>
                                        <th><?php echo $this->lang->line('pay'); ?> <?php echo $this->lang->line('day'); ?></th>                                        
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($all_student_payment) && !empty($all_student_payment)){ ?>
                                        <?php foreach($all_student_payment as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td> 
                                            <td><?php echo $obj->student_name; ?></td>                                           
                                            <td><?php echo $obj->alltotal; ?></td>
                                            <td><?php echo $obj->bank_sub_title; ?></td>
                                            <td><?php echo $obj->payment_type; ?></td>
                                            <td><?php echo $obj->payment_reference; ?></td>
                                            <td><?php echo $obj->pay_day; ?></td>
                                            <td>    
                                                <?php if($this->session->userdata('role_id')=='1'){ ?>                                            
                                                    <?php if(has_permission(DELETE, 'accounting', 'studentpayment')){ ?>
                                                        <a href="<?php echo site_url('accounting/studentpayment/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                    <?php } ?>    
                                                <?php } ?>   
                                                <?php if(has_permission(VIEW, 'accounting', 'studentpayment')){ ?>
                                                    <a href="<?php echo site_url('accounting/studentpayment/view/'.$obj->id); ?>" onclick="javascript:void(0);" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                <?php } ?>                              
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <!--  -->
                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_studentpayment">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('accounting/studentpayment/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <div class="row">
                                    <div class="col-md-6" style="padding:30px 50px;">
                                        <div class="item form-group" style='border-top: 2px solid #eee;padding-top: 15px;'>
                                            <label class="control-label  text-left" for="student_id"><?php echo $this->lang->line('student'); ?> <span class="required">*</span></label>
                                            <select  class="form-control select2" name="student_id" id="student_id" style='width:100%'>
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                                <?php if(isset($studentlist) && !empty($studentlist)){ ?>
                                                    <?php foreach($studentlist as $obj){ ?>                                                                                  
                                                        <option value="<?php echo $obj->id ?>" ><?php echo $obj->name ?></option>                                           
                                                        <?php } ?>
                                                    <?php } ?>
                                            </select>
                                        </div>
                                        <div class="item form-group" id='month_select_form'>
                                            <label class="control-label  text-left" for="title"><?php echo $this->lang->line('month_payable'); ?> <span class="required">*</span></label>
                                            <div class="input-group">  
                                                <div class="input-group-addon" style="background: white;border-left: 1px solid #ccc;">&nbsp;&nbsp;&nbsp;<i class='fa fa-asterisk' style='color:#73879C'></i>&nbsp;&nbsp;&nbsp;</div>                                                  
                                                <input  class="form-control"   id="month_payable" value="<?php echo isset($post['month_payable']) ?  $post['month_payable'] : ''; ?>" placeholder="<?php echo $this->lang->line('month_payable'); ?>" type="text" autocomplete="off">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-info" type="button" id='monpay_btn'>Inserir</button>
                                                </span>
                                            </div>   
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label  text-left" for="sales_price">Artigo </label>
                                            <div class="input-group">                                                    
                                                <select  class="form-control select2"  id="sales_price" style='width:100%'>
                                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                                    <?php if(isset($productlist) && !empty($productlist)){ ?>
                                                        <?php foreach($productlist as $obj){ ?>                                                                                  
                                                            <option value="<?php echo $obj->id ?>" ><?php echo $obj->name ?>/<?php echo $obj->sales_price ?></option>                                           
                                                            <?php } ?>
                                                        <?php } ?>
                                                </select>                                                    
                                                <span class="input-group-btn">
                                                    <button class="btn btn-info" type="button" id='productpay_btn'>Inserir</button>
                                                </span>
                                            </div>                                                
                                        </div>
                                        <div class="item form-group" id="amount_payable_select">
                                            <label class="control-label  text-left" for=""><?php echo $this->lang->line('amount'); ?>  <?php echo $this->lang->line('payable'); ?>  </label>
                                            <div class="">
                                                <input  class="form-control col-md-7 col-xs-12"    id="amount_paypable_course_fee" value="0" placeholder=""  type="text" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                           <div class="row">
                                                <div class="col-md-12">
                                                    <table class='table'  width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th><?php echo $this->lang->line('designation_paid'); ?></th>
                                                                <th><?php echo $this->lang->line('subtotal'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id='paylist_tbody'>                                                           
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan='2'>Total:</th>
                                                                <th>0</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                           </div>
                                        </div>
                                        <input type="hidden" name='jsondata' id='jsondata'>                                        
                                    </div>
                                    <div class="col-md-6 payment_submit" style="padding:30px 50px;" >
                                        <div class="item form-group" style='border-top: 2px solid #eee;padding-top: 15px;'>
                                            <label class="control-label  text-left" for=""><?php echo $this->lang->line('amount'); ?>  <?php echo $this->lang->line('paid'); ?></label>
                                            <div class="input-group">  
                                                <div class="input-group-addon" style="background: white;border-left: 1px solid #ccc;">&nbsp;&nbsp;&nbsp;<i class='fa fa-asterisk' style='color:#73879C'></i>&nbsp;&nbsp;&nbsp;</div>                                                  
                                                
                                                <input  class="form-control col-md-7 col-xs-12"  name='alltotal'   id="alltotal" value="0" placeholder=""  type="text" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label  text-left" for="bank_id"><?php echo $this->lang->line('bank'); ?> <span class="required">*</span></label>
                                            <select  class="form-control col-md-7 col-xs-12" name="bank_id" id="bank_id" style='width:100%' required>
                                                <option value="1">Banco Angolano de Investimentos</option>  
                                                <?php if(isset($banklist) && !empty($banklist)){ ?>
                                                    <?php foreach($banklist as $obj){ ?>                                                                                  
                                                        <option value="<?php echo $obj->id ?>" ><?php echo $obj->sub_title ?>(<?php echo $obj->name ?>)</option>                                           
                                                        <?php } ?>
                                                    <?php } ?>
                                            </select>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label  text-left" for="payment_type"><?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('type'); ?><span class="required">*</span></label>
                                                <select  class="form-control " name="payment_type" id="payment_type" style='width:100%' required>
                                                    <option value="3">Multicaixa</option>  
                                                    <?php if(isset($paymenttypelist) && !empty($paymenttypelist)){ ?>
                                                        <?php foreach($paymenttypelist as $obj){ ?>                                                                                  
                                                            <option value="<?php echo $obj->id ?>" ><?php echo $obj->name ?></option>                                           
                                                            <?php } ?>
                                                        <?php } ?>
                                                </select>
                                        </div> 
                                        <div class="item form-group">
                                            <label class="control-label  text-left" for="payment_reference"><?php echo $this->lang->line('payment'); ?>  <?php echo $this->lang->line('reference'); ?> <span class="required">*</span></label>
                                            <div class="input-group">  
                                                <div class="input-group-addon" style="background: white;border-left: 1px solid #ccc;">&nbsp;&nbsp;&nbsp;<i class='fa fa-asterisk' style='color:#73879C'></i>&nbsp;&nbsp;&nbsp;</div>                                                  
                                                
                                                <input  class="form-control col-md-7 col-xs-12"  name='payment_reference'  id="payment_reference" value="<?php echo isset($post['payment_reference']) ?  $post['payment_reference'] : ''; ?>" placeholder="<?php echo $this->lang->line('payment'); ?>  <?php echo $this->lang->line('reference'); ?>"  required="required" type="text" autocomplete="off" >
                                            </div>  
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label  text-left" for="pay_day"><?php echo $this->lang->line('pay'); ?>  <?php echo $this->lang->line('day'); ?> <span class="required">*</span></label>
                                            <div class="">
                                                <input  class="form-control col-md-7 col-xs-12"  name="pay_day"  id="pay_day" value="<?php echo date('d-m-Y') ?>" placeholder="<?php echo $this->lang->line('pay'); ?> <?php echo $this->lang->line('day'); ?>" required="required" type="text" autocomplete="off">
                                            </div>  
                                        </div>                     
                                        <div class="form-group" style="margin-top:50px;">
                                            <div class="text-right">
                                                <a href="<?php echo site_url('accounting/studentpayment'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                                <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('payment'); ?></button>
                                            </div>
                                        </div>
                                    </div>              
                                </div>
                                <?php echo form_close(); ?>                                                                
                            </div>
                        </div>  
                         <style>                        
                            p {
                                margin: 0 0 5px;
                                color:#000;
                                font-family: 'Raleway', sans-serif;
                            } 
                            .invoice_table tr td, .invoice_table tr th{
                                border:2px solid #fff;
                                background:#f5f5f5 !important;
                                /* border-bottom:1px solid #fff; */
                            }                       
                         </style>                                   
                        <?php if(isset($view) && $view==1){ ?>
                        <div class="tab-pane fade in active" id="tab_view_studentpayment">
                            <div class="x_content"> 
                                <table width="1100px" height="" border="0" cellpadding="12" cellspacing="" class="" style="margin-right:10px;">
                                    <tr>
                                        <td width="100%" bgcolor="#FFFFFF">
                                            <center>
                                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td colspan="8">
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>

                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  colspan="8">
                                                            <table width="98%" border="0" cellspacing="1" cellpadding="1">
                                                                <tr>
                                                                    <td><img src="<?php echo site_url('assets/uploads/logo/'.$schoolinfo[0]->logo); ?>" alt="" width='100'></td>
                                                                    <td width="15%">&nbsp;</td>
                                                                    <td width="28%">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="57%"><?php echo $schoolinfo[0]->school_name; ?></td>
                                                                    <td colspan="2" align="center"><strong>RECIBO PROPINA</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo $schoolinfo[0]->school_fax; ?></td>
                                                                    <td colspan="2" align="center" class="background_title" style="font-size: 24px"><strong>RC
                                                                        001/<?php echo $id; ?></strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo $schoolinfo[0]->address; ?></td>
                                                                    <td colspan="2" class="background_title"  >
                                                                    Estudante:&nbsp;<strong><?php echo $studentinfo[0]->student_name;  ?></strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo $schoolinfo[0]->phone; ?></td>
                                                                    <td colspan="2" class="background_title"  >Telefone:<b><b>&nbsp;</b><?php echo $studentinfo[0]->phone;  ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo $schoolinfo[0]->email; ?></td>
                                                                    <td colspan="2" class="background_title" >Morada:<b>&nbsp;&nbsp;</b><?php echo $studentinfo[0]->present_address;?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>www.ispwiliete.com</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" align="center" valign="middle"> </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" id="factuurinhoud">
                                                            <table width="98%"  border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td >
                                                                        <table width="100%"  class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td width="12%" height="3"  id="factuurinhoud">Nº Matricula</td>
                                                                                    <td width="7%"  id="factuurinhoud">Classe</td>
                                                                                    <td width="23%" align="center" >Curso</td>
                                                                                    <td width="9%" align="center" >Turma</td>
                                                                                    <td width="9%" align="center" >Periodo</td>
                                                                                    <td colspan="2" align="center"  id="factuurinhoud">Data</td>
                                                                                    <td width="21%" align="center"  id="factuurinhoud">Doc.&nbsp;&nbsp;1ªVia</td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr class="bg_det">
                                                                                    <td width="12%" height="35" id="factuurinhoud"><?php echo str_pad($studentinfo[0]->id, 9, "0", STR_PAD_LEFT); ?>
                                                                                    </td>
                                                                                    <td width="7%" height="35" id="factuurinhoud"><?php echo $studentinfo[0]->class_name;  ?></td>
                                                                                    <td align="center" id="factuurinhoud"><?php echo $studentinfo[0]->course_name;  ?></td>
                                                                                    <td align="center" id="factuurinhoud"><?php echo $studentinfo[0]->section_name;  ?></td>
                                                                                    <td align="center" id="factuurinhoud">
                                                                                        <?php  
                                                                                            if ($studentinfo[0]->period == 'morning' ) { 
                                                                                                echo 'Manhã';
                                                                                            } elseif ($studentinfo[0]->period == 'afternoon' ) { 
                                                                                                echo 'Tarde'; 
                                                                                            } elseif  ($studentinfo[0]->period == 'night' ) { 
                                                                                                echo 'Noite';
                                                                                            }
                                                                                        ?>
                                                                                    </td>
                                                                                    <td colspan="2" align="center" id="factuurinhoud"><?php echo date('d/m/y'); ?></td>
                                                                                    <td align="center" id="factuurinhoud">Original</td>
                                                                                </tr>   
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" id="factuurinhoud">
                                                            <table width="98%"  border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td >
                                                                        <table width="100%"  class="table table-bordered" cellpadding="3" cellspacing="1" bordercolor="#000000">
                                                                            <thead>
                                                                                <tr class="background_title">
                                                                                    <td width="15%" class="text-center" >Data Pagamento</td>
                                                                                    <td width="15%" class="text-center">Descrição</td>
                                                                                    <td width="15%" class="text-center">Forma Pgnto</td>
                                                                                    <td width="15%" class="text-center">Banco</td>
                                                                                    <td width="20%" class="text-center">Ref. Pagamento</td>
                                                                                    <td width="20%" class="text-center">Total</td>
                                                                                </tr>
                                                                            </thead>   
                                                                            <tbody>
                                                                                <?php $count = 1; $saldo_acomulado=0; $sumtotal=0; if(isset($viewdata) && !empty($viewdata)){ ?>
                                                                                    <?php foreach($viewdata as $obj){ ?>
                                                                                    <?php 
                                                                                        if($obj->type=="month"){
                                                                                            $string_date= $this->lang->line(strtolower(explode(" ", $obj->item_name)[0])). " ".explode(" ", $obj->item_name)[1];
                                                                                        }else{
                                                                                            $string_date=$obj->item_name;
                                                                                        }
                                                                                        ?>
                                                                                    <tr>
                                                                                        <td class="text-center"><?php echo $obj->pay_day; ?></td>
                                                                                        <td class="text-center"><?php echo $string_date; ?></td>
                                                                                        <td class="text-center"><?php echo $obj->payment_type; ?></td>
                                                                                        <td class="text-center"><?php echo $obj->bank_sub_title; ?></td>
                                                                                        <td class="text-center"><?php echo $obj->payment_reference; ?></td>
                                                                                        <td class="text-center"><?php echo  number_format($obj->item_price,2,",",".")?></td>
                                                                                    </tr>
                                                                                    <?php $sumtotal=$sumtotal+$obj->item_price; $count++; } ?>
                                                                                <?php } ?>
                                                                            </tbody>
                                                                            
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table width="98%" border="0" cellspacing="1" cellpadding="2">
                                                                <tr>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">&nbsp;</td>
                                                                    <td height="11" align="right"  style="font-size: 12px"><b>Subtotal:</b></td>
                                                                    <td align="right"  style="font-size: 12px" class="background_title" ><b>Akz
                                                                        &nbsp;&nbsp;<?php echo  number_format($sumtotal,2,",",".")?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">&nbsp;</td>
                                                                    <td width="10%" height="10" align="right"  style="font-size: 12px"><strong>Saldo
                                                                        Anterior:</strong></td>
                                                                    <td width="12%" align="right"  style="font-size: 12px" class="background_title" ><b>Akz
                                                                        &nbsp;&nbsp;<?php echo  number_format($saldo_acomulado,2,",",".")?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">&nbsp;</td>
                                                                    <td height="1" align="right"  style="font-size: 12px"><b>Total Pago:</b></td>
                                                                    <td align="right"  style="font-size: 12px" class="background_title" ><b>Akz
                                                                        &nbsp;&nbsp;<?php echo  number_format($sumtotal+$saldo_acomulado,2,",",".")?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2"><strong>São:&nbsp; </strong>
                                                                    <?php
                                                                            function extenso($total_g = 0, $maiusculas = false) { 

                                                                                $singular = array("centimos", "Kwanza", "mil", "milhão", "bilhão", "trilhão", "quatrilhão"); 
                                                                                $plural = array("centimos", "Kwanzas", "mil", "milhões", "bilhões", "trilhões", 
                                                                                "quatrilhões"); 

                                                                                $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", 
                                                                                "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"); 
                                                                                $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", 
                                                                                "sessenta", "setenta", "oitenta", "noventa"); 
                                                                                $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", 
                                                                                "dezesseis", "dezesete", "dezoito", "dezenove"); 
                                                                                $u = array("", "um", "dois", "três", "quatro", "cinco", "seis", 
                                                                                "sete", "oito", "nove"); 

                                                                                $z = 0; 
                                                                                $rt = "";

                                                                                $total_g = number_format($total_g, 2, ".", "."); 
                                                                                $inteiro = explode(".", $total_g); 
                                                                                for($i=0;$i<count($inteiro);$i++) 
                                                                                for($ii=strlen($inteiro[$i]);$ii<3;$ii++) 
                                                                                $inteiro[$i] = "0".$inteiro[$i]; 

                                                                                $fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2); 
                                                                                for ($i=0;$i<count($inteiro);$i++) { 
                                                                                    $total_g = $inteiro[$i]; 
                                                                                    $rc = (($total_g > 100) && ($total_g < 200)) ? "cento" : $c[$total_g[0]]; 
                                                                                    $rd = ($total_g[1] < 2) ? "" : $d[$total_g[1]]; 
                                                                                    $ru = ($total_g > 0) ? (($total_g[1] == 1) ? $d10[$total_g[2]] : $u[$total_g[2]]) : ""; 

                                                                                    $r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && 
                                                                                    $ru) ? " e " : "").$ru; 
                                                                                    $t = count($inteiro)-1-$i; 
                                                                                    $r .= $r ? " ".($total_g > 1 ? $plural[$t] : $singular[$t]) : ""; 
                                                                                    if ($total_g == "000")$z++; elseif ($z > 0) $z--; 
                                                                                    if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t]; 
                                                                                    if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && 
                                                                                    ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r; 
                                                                                } 

                                                                                if(!$maiusculas){ 
                                                                                    return($rt ? $rt : "zero"); 
                                                                                } else { 

                                                                                if ($rt) $rt=ereg_replace(" E "," e ",ucwords($rt));
                                                                                    return (($rt) ? ($rt) : "Zero"); 
                                                                                } 

                                                                            } 


                                                                            $dim = extenso($sumtotal);
                                                                            echo $dim;
                                                                            ?>
                                                                    </td>
                                                                    <td height="2" align="right"  style="font-size: 12px"><b>Saldo:</b></td>
                                                                    <td align="right"  style="font-size: 12px" class="background_title" ><b>Akz &nbsp;&nbsp;<?php echo  number_format(0,2,",",".")?></b></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6">O Operador:&nbsp;<strong>:&nbsp;<?php echo $operationinfo; ?></strong></td>
                                                        <td colspan="2">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%" align="center">
                                                            <h1><strong>PAGO</strong></h1>
                                                        </td>
                                                        <td width="50%" align="right"  colspan="6" ><em style="text-align:right ">
                                                                <h7>SchoolON - Mactoscohen, lda - 917254932</h7>
                                                            </em></td>
                                                        <td width="30%" align="right">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="30%" align="center" class="background_title">Selo Pago Por Guia Dec. 18/92</td>
                                                        <td width="40%" align="center" height="86" colspan="6" rowspan="2"></td>
                                                        <td width="30%" align="right">
                                                    </tr>
                                                    <tr>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" align="center">
                                                            -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                                                        </td>
                                                    </tr>
                                                </table>
                                            </center>
                                        </td>
                                    </tr>
                                </table>
                                <table width="1100px" height="" border="0" cellpadding="12" cellspacing="" class="">
                                    <tr>
                                        <td width="100%" bgcolor="#FFFFFF">
                                            <center>
                                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">                                                    
                                                    <tr>
                                                        <td height="75" colspan="8">
                                                            <table width="98%" border="0" cellspacing="1" cellpadding="1">
                                                                <tr>
                                                                    <td><img src="<?php echo site_url('assets/uploads/logo/'.$schoolinfo[0]->logo); ?>" alt="" width='100'></td>
                                                                    <td width="15%">&nbsp;</td>
                                                                    <td width="28%">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="57%"><?php echo $schoolinfo[0]->school_name; ?></td>
                                                                    <td colspan="2" align="center"><strong>RECIBO PROPINA</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo $schoolinfo[0]->school_fax; ?></td>
                                                                    <td colspan="2" align="center" class="background_title" style="font-size: 24px"><strong>RC
                                                                        001/<?php echo $id; ?></strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo $schoolinfo[0]->address; ?></td>
                                                                    <td colspan="2" class="background_title"  >
                                                                    Estudante:&nbsp;<strong><?php echo $studentinfo[0]->student_name;  ?></strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo $schoolinfo[0]->phone; ?></td>
                                                                    <td colspan="2" class="background_title"  >Telefone:<b><b>&nbsp;</b><?php echo $studentinfo[0]->phone;  ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo $schoolinfo[0]->email; ?></td>
                                                                    <td colspan="2" class="background_title" >Morada:<b>&nbsp;&nbsp;</b><?php echo $studentinfo[0]->present_address;?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>www.ispwiliete.com</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" align="center" valign="middle"> </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" id="factuurinhoud">
                                                            <table width="98%"  border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td >
                                                                        <table width="100%"  class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td width="12%" height="3"  id="factuurinhoud">Nº Matricula</td>
                                                                                    <td width="7%"  id="factuurinhoud">Classe</td>
                                                                                    <td width="23%" align="center" >Curso</td>
                                                                                    <td width="9%" align="center" >Turma</td>
                                                                                    <td width="9%" align="center" >Periodo</td>
                                                                                    <td colspan="2" align="center"  id="factuurinhoud">Data</td>
                                                                                    <td width="21%" align="center"  id="factuurinhoud">Doc.&nbsp;&nbsp;2ªVia</td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr class="bg_det">
                                                                                    <td width="12%" height="35" id="factuurinhoud"><?php echo str_pad($studentinfo[0]->id, 9, "0", STR_PAD_LEFT); ?>
                                                                                    </td>
                                                                                    <td width="7%" height="35" id="factuurinhoud"><?php echo $studentinfo[0]->class_name;  ?></td>
                                                                                    <td align="center" id="factuurinhoud"><?php echo $studentinfo[0]->course_name;  ?></td>
                                                                                    <td align="center" id="factuurinhoud"><?php echo $studentinfo[0]->section_name;  ?></td>
                                                                                    <td align="center" id="factuurinhoud">
                                                                                        <?php  
                                                                                            if ($studentinfo[0]->period == 'morning' ) { 
                                                                                                echo 'Manhã';
                                                                                            } elseif ($studentinfo[0]->period == 'afternoon' ) { 
                                                                                                echo 'Tarde'; 
                                                                                            } elseif  ($studentinfo[0]->period == 'night' ) { 
                                                                                                echo 'Noite';
                                                                                            }
                                                                                        ?>
                                                                                    </td>
                                                                                    <td colspan="2" align="center" id="factuurinhoud"><?php echo date('d/m/y'); ?></td>
                                                                                    <td align="center" id="factuurinhoud">Original</td>
                                                                                </tr>   
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" id="factuurinhoud">
                                                            <table width="98%"  border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td >
                                                                        <table width="100%"  class="table table-bordered" cellpadding="3" cellspacing="1" bordercolor="#000000">
                                                                            <thead>
                                                                                <tr class="background_title">
                                                                                    <td width="15%" class="text-center" >Data Pagamento</td>
                                                                                    <td width="15%" class="text-center">Descrição</td>
                                                                                    <td width="15%" class="text-center">Forma Pgnto</td>
                                                                                    <td width="15%" class="text-center">Banco</td>
                                                                                    <td width="20%" class="text-center">Ref. Pagamento</td>
                                                                                    <td width="20%" class="text-center">Total</td>
                                                                                </tr>
                                                                            </thead>   
                                                                            <tbody>
                                                                                <?php $count = 1; $saldo_acomulado=0; $sumtotal=0; if(isset($viewdata) && !empty($viewdata)){ ?>
                                                                                    <?php foreach($viewdata as $obj){ ?>
                                                                                        <?php 
                                                                                        if($obj->type=="month"){
                                                                                            $string_date= $this->lang->line(strtolower(explode(" ", $obj->item_name)[0])). " ".explode(" ", $obj->item_name)[1];
                                                                                        }else{
                                                                                            $string_date=$obj->item_name;
                                                                                        }
                                                                                        ?>
                                                                                    <tr>
                                                                                        <td class="text-center"><?php echo $obj->pay_day; ?></td>
                                                                                        <td class="text-center"><?php echo $string_date; ?></td>
                                                                                        <td class="text-center"><?php echo $obj->payment_type; ?></td>
                                                                                        <td class="text-center"><?php echo $obj->bank_sub_title; ?></td>
                                                                                        <td class="text-center"><?php echo $obj->payment_reference; ?></td>
                                                                                        <td class="text-center"><?php echo  number_format($obj->item_price,2,",",".")?></td>
                                                                                    </tr>
                                                                                    <?php $sumtotal=$sumtotal+$obj->item_price; $count++; } ?>
                                                                                <?php } ?>
                                                                            </tbody>
                                                                            
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table width="98%" border="0" cellspacing="1" cellpadding="2">
                                                                <tr>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">&nbsp;</td>
                                                                    <td height="11" align="right"  style="font-size: 12px"><b>Subtotal:</b></td>
                                                                    <td align="right"  style="font-size: 12px" class="background_title" ><b>Akz
                                                                        &nbsp;&nbsp;<?php echo  number_format($sumtotal,2,",",".")?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">&nbsp;</td>
                                                                    <td width="10%" height="10" align="right"  style="font-size: 12px"><strong>Saldo
                                                                        Anterior:</strong></td>
                                                                    <td width="12%" align="right"  style="font-size: 12px" class="background_title" ><b>Akz
                                                                        &nbsp;&nbsp;<?php echo  number_format($saldo_acomulado,2,",",".")?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">&nbsp;</td>
                                                                    <td height="1" align="right"  style="font-size: 12px"><b>Total Pago:</b></td>
                                                                    <td align="right"  style="font-size: 12px" class="background_title" ><b>Akz
                                                                        &nbsp;&nbsp;<?php echo  number_format($sumtotal+$saldo_acomulado,2,",",".")?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2"><strong>São:&nbsp; </strong>
                                                                         <?php  echo extenso($sumtotal);?>
                                                                    </td>
                                                                    <td height="2" align="right"  style="font-size: 12px"><b>Saldo:</b></td>
                                                                    <td align="right"  style="font-size: 12px" class="background_title" ><b>Akz &nbsp;&nbsp;<?php echo  number_format(0,2,",",".")?></b></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6">O Operador:&nbsp;<strong>:&nbsp;<?php echo $operationinfo; ?></strong></td>
                                                        <td colspan="2">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%" align="center">
                                                            <h1><strong>PAGO</strong></h1>
                                                        </td>
                                                        <td width="50%" align="right"  colspan="6" > <em style="text-align:right  ">
                                                                <h6>SchoolON - Mactoscohen, lda - 917254932</h6>
                                                            </em> </td>
                                                        <td width="30%" align="right">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="30%" align="center" class="background_title">Selo Pago Por Guia Dec. 18/92</td>
                                                        <td width="40%" align="center" height="86" colspan="6" rowspan="2">&nbsp;</td>
                                                        <td width="30%" align="right">
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" align="center">
                                                           
                                                        </td>
                                                    </tr>                                                    
                                                </table>
                                            </center>
                                        </td>
                                    </tr>
                                </table>                                
                                <div class="row text-center no-print" style='border-top:1px solid #f5f5f5;padding-top:20px;'>
                                    <button class='btn btn-success' type='button' onclick='window.print();'><i class='fa fa-print' style='color:#fff'></i>&nbsp;<?php echo $this->lang->line('print'); ?></button>
                                </div> 
                                
                            </div>
                        </div>  
                        <?php } ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.datepicker .month{
    color:red;
}
</style>
<link href="<?php echo VENDOR_URL; ?>select2/select2.min.css" rel="stylesheet">
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
<script src="<?php echo VENDOR_URL; ?>select2/select2.full.min.js"></script>
<script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>

<script type="text/javascript">
    
    
    $("document").ready(function() { 
    $('#pay_day').datepicker();      
    $("#student_id").select2();
    $("#sales_price").select2();
    $("#bank_id").select2();
    $("#payment_type").select2();
         <?php if(isset($school_id) && !empty($school_id)){ ?>
             $("#edit_school_id").trigger('change');
         <?php } ?>
    });   
    var html='';
    var myBadDates =[];
    $('#student_id').on('change', function(){      
      clear();
        var student_id = $(this).val();      
        var check_val=student_id.split('_')[1];
        if(check_val=="admitted"){
            $("#month_select_form").css("display","block");
            $("#amount_payable_select").css("display","block");
            
        }else{
            $("#month_select_form").css("display","none");
            $("#amount_payable_select").css("display","none");
        }
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('accounting/studentpayment/get_fee_head_by_school'); ?>",
            data   : { student_id:student_id},               
            async  : false,  
            success: function(response){  
                data=JSON.parse(response);                                                 
                if(data.length>0)
                {  
                    if(data[0].course_fee){
                        $("#amount_paypable_course_fee").val(data[0].course_fee);                    
                    }                                   
                }
            }
        });
      month_payable_by_student(student_id);
      datepickerchange();
    });
    var dateHash = {
            January : 1,
            February: 2,
            March: 3,
            April: 4,
            May: 5,
            June: 6,
            July: 7,
            August: 8,
            September: 9,
            October: 10,
            November: 11,
            December: 12
    };
   function datepickerchange(){
    var year, month;
    console.log(myBadDates);
    if(myBadDates.length==0){
        var date=new Date();
         year=date.getFullYear();
         month=date.getMonth();
         month=3;
        $('#month_payable').datepicker({
            format: "MM yyyy",
            minViewMode: 1,
            autoclose: true
        });      
            
    }else{
         year=myBadDates[myBadDates.length-1].split(" ")[1];       
         month=dateHash[myBadDates[myBadDates.length-1].split(" ")[0]];
        $('#month_payable').datepicker({
            format: "MM yyyy",
            minViewMode: 1,
            autoclose: true
        });
       
    }
    var picker = $('#month_payable').data('datepicker');
            picker.setStartDate(new Date(year, month));
            picker.setEndDate(new Date(year, month));
            picker.setDate(new Date(year, month));  
   }

  
  function clear(){
    $("#paylist_tbody").html('');
    $("#month_payable").val('');
    $('#alltotal').val('0')
    $('tfoot tr th:nth-child(2)').text('0');
  }

  function month_payable_by_student(student_id){
    $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('accounting/studentpayment/month_payable_by_student'); ?>",
          data   : { student_id:student_id},               
          async  : false,  
          success: function(response){              
            data=JSON.parse(response); 
             if(data.length>0)
             { 
                for (i=0 ; i<data.length;i++){
                    myBadDates.push(data[i]['item_name'])     
                } 
             }else{
                myBadDates=[];
             }
          }
      });
  }
  $("#monpay_btn").on("click", function(e){
      if(!$('#month_payable').val()){
          alert('select Month payable');
        }else{
            html='';
            html+='<tr id="month">';
            html+='<td><i class="fa fa-trash-o" style="color:blue;cursor: pointer"></i></td>';
            html+='<td name="item_name">'+$('#month_payable').val()+'</td>';
            html+='<td name="item_price">'+ $("#amount_paypable_course_fee").val()+'</td>';
            html+='</tr>';
            $("#paylist_tbody").append(html);
                $("#paylist_tbody .fa-trash-o").on("click", function(e){
                    var remove_value=$(this).parent()[0].parentNode.children[1].textContent;
                    if($(this).parent().parent()[0].id=='month'){
                        myBadDates.splice( myBadDates.indexOf('remove_value'), 1 );
                    }
                $(this).parent().parent().remove();
                    desigination_total();
                });
            myBadDates.push($('#month_payable').val());
            $("#month_payable").val('');
            desigination_total();
           
        }
       
  });

  var saleshtml='';
  
  $('#sales_price').on('change', function(){      
      var sales_price = $("#sales_price option:selected").text(); 
            saleshtml='';
            saleshtml+='<tr id="product">';
            saleshtml+='<td><i class="fa fa-trash-o" style="color:blue;cursor: pointer"></i></td>';
            saleshtml+='<td name="item_name">'+sales_price.split('/')[0]+'</td>';
            saleshtml+='<td name="item_price">'+sales_price.split('/')[1]+'</td>';
            saleshtml+='</tr>';
        // myBadDates.push(sales_price.split('/')[0]);
  });
 
    $("#productpay_btn").on("click", function(e){
        if(!$('#sales_price').val()){
            alert('select product sales price');
            }else{
                $("#paylist_tbody").append(saleshtml);
                $("#paylist_tbody .fa-trash-o").on("click", function(e){
                   
                $(this).parent().parent().remove();
                    desigination_total();
                });
                desigination_total();
            }
    });
 

  
    function desigination_total(){
        allitem=[];
            $("#paylist_tbody tr").each(function(index){
                var subitem={};
                subitem['type']=$(this)[0].id;
                subitem['item_name']=$($(this).children('td:nth-child(2)')).text();
                subitem['item_price']=$($(this).children('td:nth-child(3)')).text();
                allitem.push(subitem);
            })
            var jsondata=JSON.stringify(allitem);
            $("#jsondata").val(jsondata);
            var total=0;
            $("#paylist_tbody tr td:nth-child(3)").each(function(index){
                total=total+parseFloat($( this ).text());
            })
        $('tfoot tr th:nth-child(2)').text(total);
        $('#alltotal').val(total);
       datepickerchange();
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
        
    $("#add").validate();     
    $("#edit").validate();
</script>