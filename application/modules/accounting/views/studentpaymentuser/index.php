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
                <h3 class="head-title"><i class="fa fa-calculator"></i><small> <?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('list'); ?> <?php echo $this->lang->line('by'); ?>  <?php echo $this->lang->line('user'); ?></small></h3>
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
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_studentpayment_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('list'); ?> <?php echo $this->lang->line('by'); ?>  <?php echo $this->lang->line('user'); ?></a> </li>
                        <?php if(isset($view) && $view==1){ ?>
                            <li   class="<?php if(isset($view)){ echo 'active'; }?>"><a href="#tab_view_studentpayment"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?> <?php echo $this->lang->line('payment'); ?></a> </li>                          
                        <?php } ?>                      
                    </ul>
                    <br/>                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_studentpayment_list" >
                        <?php echo form_open_multipart(site_url('accounting/studentpaymentuser/index'), array('name' => 'result', 'id' => 'result', 'class' => 'form-horizontal form-label-left'), ''); ?>
                            <div class="row no-print"> 
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <div class="item form-group">       
                                        <div><?php echo $this->lang->line('user'); ?>  <span class="required">*</span></div>
                                        <select  class="form-control col-md-7 col-xs-12 select2" name="user" id="user"  required="required">
                                            <option value="999999">All Users</option>
                                            <?php foreach ($allusers as $obj) { ?>
                                            <option value="<?php echo $obj->id; ?>" <?php if(isset($user) && $user == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->id; ?> <?php echo $obj->username; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-3">
                                    <div class="item form-group">       
                                        <div><?php echo $this->lang->line('from'); ?> <?php echo $this->lang->line('date'); ?></div>
                                        <input  class="form-control col-md-7 col-xs-12" name="start_date" id="start_date"  required="required"  value="<?php if(isset($start_date)){ echo $start_date;}else { echo date('Y-m-d');} ?>">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-3">
                                    <div class="item form-group">       
                                        <div><?php echo $this->lang->line('to'); ?> <?php echo $this->lang->line('date'); ?></div>
                                        <input  class="form-control col-md-7 col-xs-12" name="end_date" id="end_date"  required="required" value="<?php if(isset($end_date)){ echo $end_date;}else { echo date('Y-m-d');} ?>">
                                    </div>
                                </div>                                                 
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group"><br/>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button>
                                    </div>
                                </div>                                    
                            </div>
                            <?php echo form_close(); ?>                           
                            <div class="x_content">
                                <?php  if (isset($all_student_payment) && !empty($all_student_payment)) { ?>
                                    <table width="100%">
                                        <tr>
                                            <td colspan="2"><img src="<?php echo site_url('assets/uploads/logo/'.$schoolinfo[0]->logo); ?>" alt="" width='100'></td>
                                        </tr>
                                        <tr>
                                            <td width="60%"><?php echo $schoolinfo[0]->school_name; ?></td>
                                            <td width="40%"class="text-center background_title" >Operator: <strong><?php echo $username; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">TIN:<?php echo $schoolinfo[0]->school_fax; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">STREET:<?php echo $schoolinfo[0]->address; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Phone:<?php echo $schoolinfo[0]->phone; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Email:<?php echo $schoolinfo[0]->email; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">&nbsp;</td>
                                        </tr>
                                        <tr class="table-bordered text-center background_title">
                                            <td colspan="2" style="padding:10px;"><?php echo $this->lang->line('from'); ?> : <strong><?php echo $start_date; ?></strong>
                                            <?php echo $this->lang->line('to'); ?>: <strong><?php echo $end_date; ?></strong></td>
                                        </tr>
                                    </table>
                                <?php } ?>
                                <table class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center no-print"><?php echo $this->lang->line('action'); ?></th> 
                                            <th class="text-center"><?php echo $this->lang->line('no'); ?></th>   
                                            <th class="text-center"><?php echo $this->lang->line('pay'); ?> <?php echo $this->lang->line('day'); ?></th>                                     
                                            <th class="text-center"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('name'); ?></th>
                                            <th class="text-center"><?php echo $this->lang->line('description'); ?></th>
                                            <th class="text-center"><?php echo $this->lang->line('bank'); ?> <?php echo $this->lang->line('name'); ?></th>
                                            <th class="text-center"><?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('type'); ?></th>
                                            <th class="text-center" ><?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('reference'); ?></th>
                                            <th class="text-center"><?php echo $this->lang->line('total'); ?> <?php echo $this->lang->line('paid'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>   
                                        <?php $count = 0;  $sum_total=0; if(isset($all_student_payment) && !empty($all_student_payment)){ ?>
                                            <?php foreach($all_student_payment as $obj){  $count++;  $sum_total+=$obj->alltotal; ?>
                                            <tr>
                                                <td class="text-center no-print">    
                                                    <?php if($this->session->userdata('role_id')=='1'){ ?>                                            
                                                        <?php if(has_permission(DELETE, 'accounting', 'studentpayment')){ ?>
                                                            <a style="margin-right:10px"  href="<?php echo site_url('accounting/studentpaymentuser/delete?id='.$obj->id.'&f='.$start_date.'&t='.$end_date); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" ><i class="fa fa-trash-o" style="color:red"></i>&nbsp;</a>
                                                        <?php } ?>    
                                                    <?php } ?>   
                                                    <?php if(has_permission(VIEW, 'accounting', 'studentpayment')){ ?>
                                                        <a href="<?php echo site_url('accounting/studentpaymentuser/view?id='.$obj->id.'&f='.$start_date.'&t='.$end_date); ?>" onclick="javascript:void(0);" ><i class="fa fa-print" style="color:#0d0ae6"></i>&nbsp;</a>
                                                    <?php } ?>                              
                                                </td>
                                                <td class="text-center"><?php echo $obj->idx; ?></td>
                                                <td class="text-center"><?php echo $obj->pay_day; ?></td>
                                                <td class="text-center"><?php echo $obj->student_name; ?></td>   
                                                <td class="text-center"><?php echo $obj->item_name; ?></td>                                        
                                                <td class="text-center"><?php echo $obj->bank_sub_title; ?></td>
                                                <td class="text-center"><?php echo $obj->payment_type; ?></td>
                                                <td class="text-center"><?php echo $obj->payment_reference; ?></td>
                                                <td class="text-right"><?php echo $obj->alltotal; ?></td>

                                            </tr>
                                            <?php } ?>
                                        <?php }else{ ?>
                                                <tr>
                                                    <td colspan="9"><?php echo $this->lang->line('no_data_found'); ?></td>

                                                </tr>
                                            <?php } ?>
                                    </tbody>
                                </table>
                                <?php  if (isset($all_student_payment) && !empty($all_student_payment)) { ?>
                                    <table width="100%">                                       
                                        <tr>
                                            <td width="70%">&nbsp;</td>
                                            <td width="15%"class="text-right  background_title" >Total Records: </td>
                                            <td width="15%"class="text-right  background_title" ><strong><?php echo $count; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td width="70%">&nbsp;</td>
                                            <td width="15%"class="text-right  background_title" >Total: </td>
                                            <td width="15%"class="text-right  background_title" ><strong><?php echo $sum_total; ?></strong></td>
                                        </tr>                                       
                                    </table>
                                    <div class="row text-center no-print" style='border-top:1px solid #f5f5f5;padding-top:20px;'>
                                        <button class='btn btn-success' type='button' onclick='window.print();'><i class='fa fa-print' style='color:#fff'></i>&nbsp;<?php echo $this->lang->line('print'); ?></button>
                                    </div> 
                                <?php } ?>
                              
                            </div>
                        </div>
                        <!--  -->
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
                                <table width="1200px" height="" border="0" cellpadding="12" cellspacing="" class="" style="margin-right:10px;">
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
                                                                    <td>www.wiliete.com</td>
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
                                                                                    <td width="12%" height="35" id="factuurinhoud"><?php echo str_pad($studentinfo[0]->registration_no, 9, "0", STR_PAD_LEFT); ?>
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
                                                                                    <tr>
                                                                                        <td class="text-center"><?php echo $obj->pay_day; ?></td>
                                                                                        <td class="text-center"><?php echo $obj->item_name; ?></td>
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
                                                        <td width="50%" align="center"  colspan="6" >&nbsp;</td>
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
                                                            <em style="text-align:center  ">
                                                                <h6>SchoolON - MACTSYSTEM, Tecnologias e Serviços - 917254932</h6>
                                                            </em> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" align="center">
                                                            ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                                                        </td>
                                                    </tr>
                                                </table>
                                            </center>
                                        </td>
                                    </tr>
                                </table>
                                <table width="1200px" height="" border="0" cellpadding="12" cellspacing="" class="">
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
                                                                    <td>www.wiliete.com</td>
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
                                                                                    <td width="12%" height="35" id="factuurinhoud"><?php echo str_pad($studentinfo[0]->registration_no, 9, "0", STR_PAD_LEFT); ?>
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
                                                                                    <tr>
                                                                                        <td class="text-center"><?php echo $obj->pay_day; ?></td>
                                                                                        <td class="text-center"><?php echo $obj->item_name; ?></td>
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
                                                        <td width="50%" align="center"  colspan="6" >&nbsp;</td>
                                                        <td width="30%" align="right">
                                                        <?php
                                                                // $aux = 'qr_img0.50j/php/qr_img.php?';
                                                                // $aux .= "d=$mes_pagamento_pegado - $nome_aluno&";
                                                                // $aux .= 'e=H&';
                                                                // $aux .= 's=2&';
                                                                // $aux .= 't=J';
                                                        ?>
                                                        <!-- <div style="float: right; border: 1px solid #000;"> <img src="<?php echo $aux; ?>" /> </div> -->
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="30%" align="center" class="background_title">Selo Pago Por Guia Dec. 18/92</td>
                                                        <td width="40%" align="center" height="86" colspan="6" rowspan="2">&nbsp;</td>
                                                        <td width="30%" align="right">
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" align="center">
                                                            <em style="text-align:center  ">
                                                                <h6>SchoolON - MACTSYSTEM, Tecnologias e Serviços - 917254932</h6>
                                                            </em> 
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
<link href="<?php echo VENDOR_URL; ?>select2/select2.min.css" rel="stylesheet">
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
<script src="<?php echo VENDOR_URL; ?>select2/select2.full.min.js"></script>
<script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
<script type="text/javascript">
$("document").ready(function() { 
    $(".select2").select2({ width: '100%' });
    $('#start_date').datepicker({
        format: "yyyy-mm-dd",
    }); 
    $('#end_date').datepicker({
        format: "yyyy-mm-dd",
    });   
        
    function clear(){
        $("#paylist_tbody").html('');
        $("#month_payable").val('');
        $('#alltotal').val('0')
        $('tfoot tr th:nth-child(2)').text('0');
    }
});
</script>
<!-- datatable with buttons -->
 <script type="text/javascript">        
    $("#add").validate();     
    $("#edit").validate();
</script>