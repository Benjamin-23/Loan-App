<?php $this->load->view("partial/header"); ?>
<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
<?php echo form_open('loans/save/' . $loan_info->loan_id, array('id' => 'loan_form', 'class' => 'form-horizontal')); ?>

<style>
    #drop-target {
        border: 10px dashed #999;
        text-align: center;
        color: #999;
        font-size: 20px;
        width: 600px;
        height: 300px;
        line-height: 300px;
        cursor: pointer;
    }

    #drop-target.dragover {
        background: rgba(255, 255, 255, 0.4);
        border-color: green;
    }
</style>

<input type="hidden" id="loan_id" name="loan_id" value="<?= $loan_info->loan_id; ?>" />
<input type="hidden" id="controller" value="<?= strtolower($this->lang->line('module_' . $controller_name)); ?>" />
<input type="hidden" id="linker" value="<?= random_string('alnum', 16); ?>" />


<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-content">
                <h2><?php echo $this->lang->line('common_list_of') . ' ' . $this->lang->line('module_' . $controller_name); ?></h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= site_url(); ?>">Home</a>
                    </li>
                    <li>
                        <a href="<?= site_url(strtolower($this->lang->line('module_' . $controller_name))); ?>"><?= ucwords($this->lang->line('module_' . $controller_name)); ?></a>
                    </li>
                    <li class="active">
                        <strong>Add</strong>
                    </li>
                </ol>
            </div>
        </div>
    </div>    
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title">
                <h5>
                    <?php echo $this->lang->line("loans_info"); ?>
                </h5>
                <div class="inqbox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#">Config option 1</a>
                        </li>
                        <li><a href="#">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="inqbox-content">
                <div class="tabs-container">
                    <ul class="nav nav-tabs tab-border-top-danger">
                        <li class="active"><a data-toggle="tab" href="#sectionA"><?= $this->lang->line("loans_information"); ?></a></li>
                        <li><a data-toggle="tab" href="#sectionB"><?= $this->lang->line("loans_misc_fees"); ?></a></li>
                        <li><a data-toggle="tab" href="#sectionC"><?= $this->lang->line('loans_attachments') ?></a></li>
                        <li><a data-toggle="tab" href="#sectionE"><?= $this->lang->line('guarantee') ?></a></li>
                        <li><a data-toggle="tab" href="#sectionF">Loan Calculator</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="sectionA" class="tab-pane fade in active">
                            <div style="text-align: center">
                                <h3><?= $this->lang->line("loans_information"); ?></h3>
                                <div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
                                <ul id="error_message_box"></ul>
                            </div>
                            
                            <!--
                            <div class="form-group"><label class="col-sm-2 control-label"><?php echo form_label($this->lang->line('loans_type') . ':', 'loan_type', array('class' => 'wide')); ?></label>
                                <div class="col-sm-10">
                                    <?php echo form_dropdown("loan_type", $loan_types, $loan_info->loan_type_id, "id='loan_type' class='form-control'"); ?>
                                    <input type="hidden" id="loan_type_id" name="loan_type_id" value="<?= $loan_info->loan_type_id; ?>" />
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            -->

                            <div class="form-group"><label class="col-sm-2 control-label"><?php echo form_label($this->lang->line('customers_customer') . ':', 'inp-customer', array('class' => 'wide required')); ?></label>
                                <div class="col-sm-10">
                                    <?php
                                    echo form_input(
                                            array(
                                                'name' => 'inp-customer',
                                                'id' => 'inp-customer',
                                                'value' => $loan_info->customer_name,
                                                'class' => 'form-control',
                                                'placeholder' => $this->lang->line('common_start_typing'),
                                                'style' => 'display:' . ($loan_info->customer_id <= 0 ? "" : "none")
                                            )
                                    );
                                    ?>

                                    <span id="sp-customer" style="display: <?= ($loan_info->customer_id > 0 ? "" : "none") ?>">
                                        <?= $loan_info->customer_name; ?>
                                        <span><a href="javascript:void(0)" title="Remove Customer" class="btn-remove-row"><i class="fa fa-times"></i></a></span>
                                    </span>
                                    <input type="hidden" id="customer" name="customer" value="<?= $loan_info->customer_id; ?>" />

                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label"><?php echo form_label($this->lang->line('loans_account') . ':', 'account', array('class' => 'wide required')); ?></label>
                                <div class="col-sm-10">
                                    <?php
                                    echo form_input(
                                            array(
                                                'name' => 'account',
                                                'id' => 'account',
                                                'value' => $loan_info->account,
                                                'class' => 'form-control'
                                            )
                                    );
                                    ?>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label"><?php echo form_label($this->lang->line('loans_description') . ':', 'description', array('class' => 'wide')); ?></label>
                                <div class="col-sm-10">
                                    <?php
                                    echo form_textarea(
                                            array(
                                                'name' => 'description',
                                                'id' => 'description',
                                                'value' => $loan_info->description,
                                                'rows' => '5',
                                                'cols' => '17',
                                                'class' => 'form-control'
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            <div class="form-group" id="data_1"><label class="col-sm-2 control-label"><?php echo form_label($this->lang->line('loans_apply_date') . ':', 'apply_date', array('class' => 'wide required')); ?></label>
                                <div class="col-sm-10">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <?php
                                        echo form_input(
                                                array(
                                                    'name' => 'apply_date',
                                                    'id' => 'apply_date',
                                                    'value' => (isset($loan_info->loan_applied_date) && $loan_info->loan_applied_date > 0) ? date("m/d/Y", $loan_info->loan_applied_date) : date("m/d/Y"),
                                                    'class' => 'form-control',
                                                    'type' => 'datetime'
                                                )
                                        );
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label"><?php echo form_label($this->lang->line('loans_agent') . ':', 'agent', array('class' => 'wide')); ?></label>
                                <div class="col-sm-10">
                                    <?php if ($user_info->person_id === '1'): ?>
                                        <?php echo form_dropdown("sel_agent", $employees, ($loan_info->loan_agent_id > 0 ? $loan_info->loan_agent_id : $user_info->person_id), "id='sel_agent' class='form-control'"); ?>
                                    <?php else: ?>
                                        <?= ucwords($user_info->first_name . " " . $user_info->last_name); ?>
                                    <?php endif; ?>
                                    <!--
                                    <?php echo isset($loan_info->agent_name) ? ucwords($loan_info->agent_name) : ucwords($user_info->first_name . " " . $user_info->last_name); ?>
                                    -->
                                    <input type="hidden" id="agent" name="agent" value="<?= ($loan_info->loan_agent_id > 0 ? $loan_info->loan_agent_id : $user_info->person_id) ?>" />
                                    <input type="hidden" id="approver" name="approver" value="<?= $loan_info->loan_approved_by_id; ?>" />
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label"><?php echo form_label($this->lang->line('loans_status') . ':', 'status', array('class' => 'wide')); ?></label>
                                <div class="col-sm-10">
                                    <?= $loan_status; ?>
                                    <input type="hidden" id="status" name="status" value="<?= $loan_info->loan_status; ?>" />
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label"><?php echo form_label($this->lang->line('loans_remarks') . ':', 'remarks', array('class' => 'wide')); ?></label>
                                <div class="col-sm-10">
                                    <?php
                                    echo form_textarea(
                                            array(
                                                'name' => 'remarks',
                                                'id' => 'remarks',
                                                'value' => $loan_info->remarks,
                                                'rows' => '5',
                                                'cols' => '17',
                                                'class' => 'form-control'
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div id="sectionB" class="tab-pane fade">
                            <div style="text-align: center">
                                <h3><?= $this->lang->line("loans_misc_fees"); ?></h3>
                            </div>
                            <table class="table" id="tbl-income-sources">
                                <thead>
                                    <tr>
                                        <th style="text-align: center; width: 1%">
                                            <input type="checkbox" class="select_all_" />
                                        </th>
                                        <th style="text-align: center; width: 80%"><?= $this->lang->line("loans_fee"); ?></th>
                                        <th style="text-align: center; width: 20%"><?= $this->lang->line("loans_amount"); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($misc_fees as $misc_fee): ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="select_" />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="fees[]" value="<?= $misc_fee[0]; ?>" />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" step="any" name="amounts[]" value="<?= $misc_fee[1]; ?>" />
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <button class="btn btn-primary" type="button" id="btn-add-row"><?= $this->lang->line("common_add_row"); ?></button>
                            <button class="btn btn-danger" type="button" id="btn-del-row"><?= $this->lang->line("common_delete_row"); ?></button>
                        </div>

                        <div id="sectionC" class="tab-pane fade">
                            <h3><?= $this->lang->line('loans_attachments') ?></h3>
                            <div id="required_fields_message"><?php echo $this->lang->line('loans_attachments_message'); ?></div>
                            <div>
                                <ul class="list-inline" id="filelist">
                                    <?php foreach ($attachments as $attachment): ?>
                                        <li>
                                            <a href="uploads/loan-<?= $loan_info->loan_id; ?>/<?= $attachment['filename']; ?>" target="_blank" title="<?= $attachment['filename']; ?>"><img src="<?= $attachment['icon']; ?>" /></a>
                                            <span class="close remove-file" data-file-id="<?= $attachment['id']; ?>" title="Remove this file"><i class="fa fa-times-circle"></i></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div id="progress" class="overlay"></div>
                            <div class="progress progress-task" style="height: 4px; width: 15%; margin-bottom: 2px; display: none">
                                <div style="width: 0%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" role="progressbar" class="progress-bar progress-bar-info"></div>                                    
                            </div>
                            <div id="container">
                                <a id="pickfiles" href="javascript:;" class="btn btn-default" data-loan-id="<?= $loan_info->loan_id; ?>"><?= $this->lang->line("common_browse"); ?></a> 
                            </div>
                        </div>

                        <div id="sectionE" class="tab-pane fade in">
                            <div style="text-align: center">
                                <h3><?= $this->lang->line("guarantee"); ?></h3>
                                <div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
                                <ul id="error_message_box"></ul>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <?php echo form_label($this->lang->line('guarantee_name') . ':', 'guarantee_name', array('class' => 'wide required')); ?>
                                </label>
                                <div class="col-sm-10">
                                    <?php
                                    echo form_input(
                                            array(
                                                'name' => 'guarantee_name',
                                                'id' => 'guarantee_name',
                                                'value' => $guarantee_info->name,
                                                'class' => 'form-control'
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <?php echo form_label($this->lang->line('guarantee_type') . ':', 'guarantee_type', array('class' => 'wide required')); ?>
                                </label>
                                <div class="col-sm-10">
                                    <?php
                                    echo form_input(
                                            array(
                                                'name' => 'guarantee_type',
                                                'id' => 'guarantee_type',
                                                'value' => $guarantee_info->type,
                                                'class' => 'form-control'
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <?php echo form_label($this->lang->line('guarantee_brand') . ':', 'guarantee_brand', array('class' => 'wide required')); ?>
                                </label>
                                <div class='col-sm-10'>
                                    <?php
                                    echo form_input(
                                            array(
                                                'name' => 'guarantee_brand',
                                                'id' => 'guarantee_brand',
                                                'value' => $guarantee_info->brand,
                                                'class' => 'form-control'
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <?php echo form_label($this->lang->line('guarantee_make') . ':', 'guarantee_make', array('class' => 'wide required')); ?>
                                </label>
                                <div class="col-sm-10">
                                    <?php
                                    echo form_input(
                                            array(
                                                'name' => 'guarantee_make',
                                                'id' => 'guarantee_make',
                                                'value' => $guarantee_info->make,
                                                'class' => 'form-control'
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <?php echo form_label($this->lang->line('guarantee_serial') . ':', 'guarantee_serial', array('class' => 'wide required')); ?>
                                </label>
                                <div class="col-sm-10">
                                    <?php
                                    echo form_input(
                                            array(
                                                'name' => 'guarantee_serial',
                                                'id' => 'guarantee_serial',
                                                'value' => $guarantee_info->serial,
                                                'class' => 'form-control'
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group" id="data_1">
                                <label class="col-sm-2 control-label">
                                    <?php echo form_label($this->lang->line('guarantee_price') . ':', 'guarantee_price', array('class' => 'wide required')); ?>
                                </label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <?php
                                        echo form_input(
                                                array(
                                                    'name' => 'guarantee_price',
                                                    'id' => 'guarantee_price',
                                                    'value' => $guarantee_info->price,
                                                    'class' => 'form-control'
                                                )
                                        );
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <?php echo form_label($this->lang->line('guarantee_proof') . ':', 'guarantee_proof', array('class' => 'wide')); ?>
                                </label>
                                <div class="col-sm-10">
                                    <div class='form_field'>
                                        <ul class="sel-proof">   
                                            <?php if (is_array($proofs)): ?>
                                                <?php foreach ($proofs as $proof): ?>
                                            <li><input type="hidden" name="proofs[]" value="<?= $proof["id"]; ?>" /><a href="<?= getDomain(); ?>uploads/loan-<?= $loan_info->loan_id; ?>/<?= $proof["filename"]; ?>" target="_blank"><?= (trim($proof["descriptions"]) !== "") ? $proof["descriptions"] : $proof["filename"]; ?></a></li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </ul>
                                        <a href="<?=  site_url(); ?>/loans/attachments/<?= $loan_info->loan_id; ?>/proof" data-toggle='modal' data-target='#attachment_modal' >Select from attachment</a>
                                    </div>      
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <?php echo form_label($this->lang->line('guarantee_images') . ':', 'guarantee_images', array('class' => 'wide')); ?>
                                </label>
                                <div class="col-sm-10">
                                    <ul class="sel-images">  
                                        <?php if (is_array($pimages)): ?>
                                            <?php foreach ($pimages as $pimage): ?>
                                                <li><input type="hidden" name="images[]" value="<?= $pimage["id"]; ?>" /><a href="<?= getDomain(); ?>uploads/loan-<?= $loan_info->loan_id; ?>/<?= $pimage["filename"]; ?>" target="_blank"><?= (trim($pimage["descriptions"]) !== "") ? $pimage["descriptions"] : $pimage["filename"]; ?></a></li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                    <a href="<?=  site_url(); ?>/loans/attachments/<?= $loan_info->loan_id; ?>/images" data-toggle='modal' data-target='#attachment_modal'>Select from attachment</a>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <?php echo form_label($this->lang->line('guarantee_observations') . ':', 'guarantee_observations', array('class' => 'wide')); ?>
                                </label>
                                <div class="col-sm-10">
                                    <?php
                                    echo form_textarea(
                                            array(
                                                'name' => 'guarantee_observations',
                                                'id' => 'guarantee_observations',
                                                'value' => $guarantee_info->observations,
                                                'class' => 'form-control'
                                            )
                                    );
                                    ?>
                                </div>
                            </div>

                        </div>


                        <div id="sectionF" class="tab-pane fade in">
                            <?php $this->load->view('loans/tabs/calculator'); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title">
                <h5>
                    <?php echo $this->lang->line("payments_info"); ?>
                </h5>
                <div class="inqbox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="inqbox-content">

                <div style="text-align: center">
                    <div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
                    <ul id="error_message_box"></ul>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        Current Balance:
                    </label>
                    <div class="col-sm-10">
                        <span id="sp-current-balance"><?php echo $loan_info->loan_balance; ?></span>
                        <input type="hidden" id="current_balance" name="current_balance" value="<?= $loan_info->loan_balance; ?>" />
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group" id="data_1"><label class="col-sm-2 control-label"><?php echo form_label($this->lang->line('payments_date') . ':', 'payment_date', array('class' => 'wide required')); ?></label>
                    <div class="col-sm-10">
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <?php
                            echo form_input(
                                    array(
                                        'name' => 'date_paid',
                                        'id' => 'date_paid',
                                        'value' => date("m/d/Y"),
                                        'class' => 'form-control',
                                    )
                            );
                            ?>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group"><label class="col-sm-2 control-label"><?php echo form_label($this->lang->line('payments_amount') . ':', 'teller', array('class' => 'wide')); ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo form_input(
                                array(
                                    'name' => 'paid_amount',
                                    'id' => 'paid_amount',
                                    'value' => '',
                                    'class' => 'form-control',
                                    'type' => 'number',
                                    'step' => 'any',
                                )
                        );
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group"><label class="col-sm-2 control-label"><?php echo form_label($this->lang->line('payments_teller') . ':', 'teller', array('class' => 'wide')); ?></label>
                    <div class="col-sm-10">
                        <?php echo ucwords($user_info->first_name . " " . $user_info->last_name); ?>
                        <input type="hidden" id="teller" name="teller" value="<?= $user_info->person_id; ?>" />
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group"><label class="col-sm-2 control-label"><?php echo form_label($this->lang->line('common_remarks') . ':', 'remarks', array('class' => 'wide')); ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo form_textarea(
                                array(
                                    'name' => 'remarks',
                                    'id' => 'remarks',
                                    'value' => '',
                                    'rows' => '5',
                                    'cols' => '17',
                                    'class' => 'form-control'
                                )
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="form-group">
        <div class="col-sm-offset-2">
            <a class="btn btn-default" id="btn-close" href="<?=site_url("loans"); ?>"><?= $this->lang->line("common_close"); ?></a>
            <button id="btn-approve" class="btn btn-success" type="button"><?= $this->lang->line('loans_approve'); ?></button>
            <?php if ($loan_info->loan_id > 0): ?>
                <a href="<?= site_url("loans/" . ($loan_info->loan_type_id > 0 ? "generate_breakdown" : "fix_breakdown") . "/$loan_info->loan_id"); ?>" target="_blank" id="btn-sched" class="btn btn-warning"><?= $this->lang->line('loans_breakdown'); ?></a>
                <a href="<?= site_url("loans/print_disclosure/$loan_info->loan_id"); ?>" target="_blank" id="btn-break-gen" class="btn btn-primary" type="button"><?= $this->lang->line('loans_disclosure'); ?></a>
            <?php endif; ?>
            <button id="btn-edit" class="btn btn-danger" type="button"><?= $this->lang->line('common_edit'); ?></button>
            <?php
            echo form_submit(
                    array(
                        'name' => 'submit',
                        'id' => 'btn-save',
                        'value' => $this->lang->line('common_save'),
                        'class' => 'btn btn-primary'
                    )
            );
            ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="attachment_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Select an item
            </div>
            <div class="modal-body">
                No records found.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<?php
echo form_close();
?>

<?php $this->load->view("partial/footer"); ?>

<!-- Date picker -->
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>js/loan.js?v=<?= time(); ?>"></script>

<script type='text/javascript'>

    //validation and submit handling
    $(document).ready(function () {
        $('.input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        $(document).on("change, keyup", "#amount", function () {
            $("#sp-current-balance").html($(this).val());
            $("#current_balance").val($(this).val());
        });

        $(document).on("click", ".remove-file", function () {
            var el = $(this);
            $.ajax({
                url: '<?= site_url('loans/remove_file'); ?>',
                data: {
                    file_id: el.data("file-id"), 
                    softtoken: $("input[name='softtoken']").val()
                },
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    $("input[name='softtoken']").val(data.token_hash);
                    el.parent().remove();
                },
                error: function () {
                    ;
                }
            });
        });

        $("#btn-add-row").click(function () {
            $(".select_all_").prop("checked", false);

            var rowCount = $('#tbl-misc-fees tr').length;
            if (rowCount > 1)
            {
                $("#tbl-income-sources tbody").append("<tr>" + $('#tbl-income-sources tr:last').html() + "</tr>");
            }
            else
            {
                $("#tbl-income-sources tbody").append("<tr><td><input type='checkbox' class='select_' /></td><td><input type='text' class='form-control' name='sources[]' /></td><td><input type='number' class='form-control' name='values[]' /></td></tr>");
            }
        });

        $("#btn-del-row").click(function () {
            $('.select_').each(function () {
                if ($(this).is(":checked"))
                {
                    $(this).parent().parent().remove();
                }
            });
        });

        $("#loan_type").change(function () {
            $("#loan_type_id").val($(this).val());
        });

        $("#sel_agent").change(function () {
            $("#agent").val($(this).val());
        });

        $("#btn-approve").click(function () {            
            $("#approver").val('<?=$user_info->person_id;?>');
            $("#loan_form").submit();
        });

        if ($("#agent").val() <= 0)
        {
            $("#agent").val('<?=$user_info->person_id;?>');
        }


        if ($("#loan_id").val() > -1)
        {
            $(".btn-remove-row").hide();
            $(".remove-file").hide();
            $("#loan_form input, textarea").prop("readonly", true);
            $("#loan_form input[type='hidden']").prop("readonly", false);
            $("#loan_form select").prop("disabled", true);
            $("#btn-add-row").prop("disabled", true);
            $("#btn-del-row").prop("disabled", true);
            $("#btn-save").hide();

            if ($("#status").val() !== "approved")
            {
                $("#btn-approve").show();
            }
            else
            {
                $("#btn-approve").hide();
            }

            $("#btn-break-gen").show();
            $("#btn-edit").show();

            $("#btn-edit").click(function () {
                $("#btn-save").show();
                $(this).hide();
                $(".btn-remove-row").show();
                $(".remove-file").show();
                $("#loan_form input, textarea").prop("readonly", false);
                $("#loan_form select").prop("disabled", false);
                $("#btn-add-row").prop("disabled", false);
                $("#btn-del-row").prop("disabled", false);
                $("#btn-save").show();
            });
        }
        else
        {
            $("#btn-approve").hide();
            $("#btn-break-gen").hide();
            $("#btn-edit").hide();
        }

        $(document).on("click", ".btn-remove-row", function () {
            $("#sp-customer").hide();
            $("#sp-customer").html("");
            $("#inp-customer").val("");
            $("#inp-customer").show();
            $("#customer").val("");
        });

        $('#inp-customer').autocomplete({
            serviceUrl: '<?php echo site_url("loans/customer_search"); ?>',
            onSelect: function (suggestion) {
                $("#account").val(suggestion.data);
                $("#customer").val(suggestion.data);
                $("#sp-customer").html(suggestion.value + ' <span><a href="javascript:void(0)" title="Remove Customer" class="btn-remove-row"><i class="fa fa-times"></i></a></span>');
                $("#sp-customer").show();
                $("#inp-customer").hide();
            }
        });

        var settings = {
            ignore: "",
            invalidHandler: function (form, validator) {
                set_feedback("Error: Please correct all the required fields", 'error_message', true);
            },
            submitHandler: function (form) {
                $(form).ajaxSubmit({
                    success: function (response) {
                        post_loan_form_submit(response);

                        if ($("#loan_id").val() > 0)
                        {
                            setTimeout(function () {
                                location.reload()
                            }, 5000);
                        }
                    },
                    dataType: 'json',
                    type: 'post'
                });

            },
            rules: {
                account: "required",
                amount: "required",
                "inp-customer": "required"
            },
            messages: {
                account: "<?php echo $this->lang->line('loans_account_required'); ?>",
                amount: "<?php echo $this->lang->line('loans_amount_required'); ?>",
                "inp-customer": "<?php echo $this->lang->line('loans_customer_required'); ?>"
            }
        };

        $('#loan_form').validate(settings);

        function post_loan_form_submit(response) {
            if (!response.success)
            {
                set_feedback(response.message, 'error_message', true);
            }
            else
            {
                set_feedback(response.message, 'success_message', false);
            }

            $('#loan_form').attr("action", "<?= site_url(); ?>loans/save/" + response.loan_id);
        }

        $("#btn-add-row-payment").click(function () {
            $(".payment_select_all_").prop("checked", false);

            var rowCount = $('#tbl-payment-sched tr').length;
            if (rowCount > 1)
            {
                $("#tbl-payment-sched tbody").append("<tr>" + $('#tbl-payment-sched tr:last').html() + "</tr>");
            }
            else
            {
                $("#tbl-payment-sched tbody").append("<tr><td><input type='checkbox' class='payment_select_' /></td><td><input type='date' class='form-control' name='payment_date[]' /></td><td><input type='number' class='form-control' name='payment_balance[]' /></td><td><input type='number' class='form-control' name='payment_interest[]' /></td><td><input type='number' class='form-control' name='payment_amount[]' /></td></tr>");
            }
            
            $('.input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
        });

        $("#btn-del-row-payment").click(function () {
            $('.payment_select_').each(function () {
                if ($(this).is(":checked"))
                {
                    $(this).parent().parent().remove();
                }
            });
        });
    });
</script>