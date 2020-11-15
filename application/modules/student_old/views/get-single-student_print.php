<style>
.admission-form-title {
    margin-bottom: 5px;
    margin-top: 10px;
    background-color: #e4e4e4;
    padding-left: 10px;
    font-family: 'Raleway', sans-serif;
    font-size: 14px;
    font-weight: normal;
    letter-spacing: 0;
    line-height: 28px;
    margin: 0;
    margin-right:10px;
}
.form-field {
    margin-bottom: 7px;
    margin-right: 10px;
    margin-top:8px;
}
.field-title {
    float: left;
    margin-right: 8px;
    line-height: 26px;
}
.field-value {
    overflow: hidden;
    border-bottom: 1px dotted #708596;
    min-height: 20px;
}
.student-picture {
    border: 1px solid lightgray;
    height: 120px;
    width: 100px;
    float: right;
    text-align: center;
    line-height: 30px;
}
.admission-address {
    text-align: center;
}
.admission-address h3{
    font-size: 24px;
    line-height: 28px;
    margin-bottom: 0px;
    margin: 0;
    font-family: 'Raleway', sans-serif;
    font-weight: 700;
    color: #000;
    letter-spacing: 0;
}
.admission-address h3{
    font-size: 20px;
    line-height: 24px;
    margin: 0;
    font-family: 'Raleway', sans-serif;
    font-weight: 700;
    color: #000;
    letter-spacing: 0;
}

@media print {
        .admission-form-title {                   
            background: #e4e4e4 !important;    
        }
    } 
</style>
<section class="page-contact-area"> 
    <div class="container">
        <div class="row">
                <div class="admission-form" >
                    <table width="1100px" style="margin:auto;margin-top:80px;">
                        <tr>
                            <td width="20%">&nbsp;</td>
                            <td class="text-center" width="60%">
                                 <?php if($school->logo){ ?>
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" width="100" /> 
                                 <?php }else if($school->frontend_logo){ ?>
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->frontend_logo; ?>" alt=""   width="100"/> 
                                 <?php }else{ ?>                                                        
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->brand_logo; ?>" alt=""   width="100" />
                                 <?php } ?>
                            </td>
                            <td width="20%">&nbsp;</td>
                        </tr>
                        
                        <tr>
                            <td width="20%"></td>
                            <td width="60%" class="text-center">
                                <div><h3><?php echo $school->school_name; ?></h3></div>                                
                                <div><?php echo $school->address; ?></div>
                                <div><?php echo $school->phone; ?></div>
                                <div><?php echo $school->email; ?></div>
                                <div><h4><?php echo $this->lang->line('admission_form'); ?></h4></div>
                            </td>
                            <td width="20%" class="text-right">
                                <span class="student-picture" style="margin-right:30px;">
                                <?php if($student->photo) { ?>
                                <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $student->photo; ?>" alt="" style="height: 120px;width: 100px;" />
                                <?php }else{ ?>
                                    <?php echo $this->lang->line('photo'); ?>
                                <?php } ?>
                                </span>
                            </td>
                        </tr> 
                        <tr>
                            <td colspan="3">
                                <hr style="margin-right:10px;">
                            </td>
                        </tr>                  
                    </table>
                    <table width="1100px" style="margin:auto;margin-bottom: 100px;">
                        <tr  >
                            <td  >
                                <p class="admission-form-title" style="margin-right:0px;"><strong><?php echo $this->lang->line('basic'); ?> <?php echo $this->lang->line('information'); ?>:</strong></p>
                            
                            </td>
                            <td >
                                <p class="admission-form-title text-right" class="text-right" ><strong><?php echo $this->lang->line('subscriptions'); ?> <?php echo $this->lang->line('no'); ?>: &nbsp;<?php echo $student->id; ?>&nbsp;</strong></p>
                            
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('name'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->name; ?></div> 
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('type'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->type; ?></div> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('birth_date'); ?>:</div> 
                                    <div class="field-value"><?php echo date($this->global_setting->date_format, strtotime($student->dob)); ?></div> 
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('gender'); ?>:</div> 
                                    <div class="field-value"><?php echo $this->lang->line($student->gender); ?></div> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('religion'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->religion; ?></div> 
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('caste'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->caste; ?></div> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('provincial'); ?> <?php echo $this->lang->line('sector'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->provincial_sector_name; ?></div> 
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('date_of_national_id'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->date_of_national_id; ?></div> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('blood_group'); ?>:</div> 
                                    <div class="field-value"><?php echo $this->lang->line($student->blood_group); ?></div> 
                                </div>
                            </td>
                            <td width="50%">
                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p class="admission-form-title"><strong><?php echo $this->lang->line('contact'); ?> <?php echo $this->lang->line('information'); ?>:</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('phone'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->phone; ?></div> 
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('national_id'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->national_id; ?></div> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('present'); ?> <?php echo $this->lang->line('address'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->present_address; ?></div> 
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('permanent'); ?> <?php echo $this->lang->line('address'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->permanent_address; ?></div> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p class="admission-form-title">
                                <strong><?php echo $this->lang->line('academic'); ?> <?php echo $this->lang->line('information'); ?>:</strong>
                                
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('class'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->class_name; ?></div> 
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('section'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->section; ?></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('group'); ?>:</div> 
                                    <div class="field-value"><?php echo $this->lang->line($student->group); ?></div> 
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('second'); ?> <?php echo $this->lang->line('language'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->second_language; ?></div> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('period'); ?>:</div> 
                                    <div class="field-value"><?php echo $this->lang->line($student->period); ?></div> 
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('course'); ?> <?php echo $this->lang->line('name'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->course_name; ?></div> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p class="admission-form-title"><strong><?php echo $this->lang->line('previous'); ?> <?php echo $this->lang->line('school'); ?> <?php echo $this->lang->line('information'); ?>:</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('previous'); ?> <?php echo $this->lang->line('school'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->previous_school; ?></div> 
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('previous'); ?> <?php echo $this->lang->line('class'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->previous_class; ?></div> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p class="admission-form-title"><strong><?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('information'); ?>:</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('name'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->father_name; ?></div>
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('phone'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->father_phone; ?></div> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('education'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->father_education; ?></div>
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('profession'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->father_profession; ?></div> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('designation'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->father_designation; ?></div>
                                </div>
                            </td>
                            <td width="50%">
                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p class="admission-form-title"><strong><?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('information'); ?>:</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('name'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->mother_name; ?></div> 
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('phone'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->mother_phone; ?></div> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('education'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->mother_education; ?></div>
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('profession'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->mother_profession; ?></div> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('designation'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->mother_designation; ?></div> 
                                </div>
                            </td>
                            <td width="50%">
                               
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p class="admission-form-title"><strong><?php echo $this->lang->line('other'); ?> <?php echo $this->lang->line('information'); ?>:</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('email'); ?>:</div> 
                                    <div class="field-value"><?php echo $student->email; ?></div> 
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('health_condition'); ?> :</div> 
                                    <div class="field-value"><?php echo $student->health_condition; ?></div> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                <div class="field-title"><?php echo $this->lang->line('other_info'); ?>:</div> 
                                <div class="field-value"><?php echo $student->other_info; ?></div> 
                                </div>
                            </td>
                            <td width="50%">                               
                            </td>
                        </tr> 
                        <tr>
                            <td colspan="2">
                                <p class="admission-form-title"><strong><?php echo $this->lang->line('guardian'); ?> <?php echo $this->lang->line('information'); ?>:</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('guardian'); ?> <?php echo $this->lang->line('name'); ?>:</div> 
                                    <div class="field-value"><?php echo $guardian->name; ?></div>
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('relation_with'); ?> :</div> 
                                    <div class="field-value"><?php echo $this->lang->line($student->relation_with); ?></div> 
                                </div>
                            </td>
                        </tr>  
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('phone'); ?>:</div> 
                                    <div class="field-value"><?php echo $guardian->phone; ?></div> 
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('email'); ?> :</div> 
                                    <div class="field-value"><?php echo $guardian->email; ?></div> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('religion'); ?>:</div> 
                                    <div class="field-value"><?php echo $guardian->religion; ?></div>
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('profession'); ?> :</div> 
                                    <div class="field-value"><?php echo $guardian->profession; ?></div>  
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('national_id'); ?>:</div> 
                                    <div class="field-value"><?php echo $guardian->national_id; ?></div>
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('present'); ?> <?php echo $this->lang->line('address'); ?>:</div> 
                                    <div class="field-value"><?php echo $guardian->present_address; ?></div>   
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('permanent'); ?> <?php echo $this->lang->line('address'); ?>:</div> 
                                    <div class="field-value"><?php echo $guardian->permanent_address; ?></div>
                                </div>
                            </td>
                            <td width="50%">
                                <div class="form-field">
                                    <div class="field-title"><?php echo $this->lang->line('other_info'); ?>:</div> 
                                    <div class="field-value"><?php echo $guardian->other_info; ?></div>   
                                </div>
                            </td>
                        </tr>                                         
                    </table>
                    <div class="row no-print" style="margin-top:50px;">
                        <div class="col-md-12 col-sm-12 text-center">
                            <button class="btn btn-info glbscl-link-btn hvr-bs" onclick="window.print();"><i class="fa fa-print" style="color:#fff"></i> <?php echo $this->lang->line('print'); ?> </button>
                            <a  class="btn btn-info glbscl-link-btn hvr-bs" class="close" data-dismiss="modal"><i class="fa fa-close" style="color: #fff;"></i><?php echo $this->lang->line('close'); ?></a>
                        </div>
                    </div>
                </div>
            </div>         
        
    </div>
</section>