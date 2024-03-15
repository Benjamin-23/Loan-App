<?php $this->load->view("partial/header"); ?>

<?= form_open('customers/save/' . $person_info->person_id, array('id' => 'customer_form', 'class' => 'form-horizontal')); ?>
<input type="hidden" id="customer_id" value="<?= $customer_id ?>" />
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
                        <a href="<?= site_url("customers"); ?>"><?= ucwords($this->lang->line('module_' . $controller_name)); ?></a>
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
                    <?php echo $this->lang->line("customers_basic_information"); ?>
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
                <div class="tabs-container">

                    <ul class="nav nav-tabs tab-border-top-danger">
                        <li class="active"><a data-toggle="tab" href="#sectionA"><?= $this->lang->line("customers_personal_information"); ?></a></li>
                        <li><a data-toggle="tab" href="#sectionB"><?= $this->lang->line("customers_financial_information"); ?></a></li>
                        <li><a data-toggle="tab" href="#sectionC"><?= $this->lang->line("customers_attachment"); ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="sectionA" class="tab-pane fade in active">

                            <div style="text-align: center">
                                <div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
                                <ul id="error_message_box"></ul>
                            </div>
                            <?php $this->load->view("people/form_basic_info"); ?>

                            <div class="form-group"><label class="col-sm-2 control-label"><?php echo form_label($this->lang->line('customers_account_number') . ':', 'account_number'); ?></label>
                                <div class="col-sm-10">
                                    <?php
                                    echo form_input(
                                            array(
                                                'name' => 'account_number',
                                                'id' => 'account_number',
                                                'value' => $person_info->account_number,
                                                'class' => 'form-control'
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>


                            <div class="form-group"><label class="col-sm-2 control-label"><?php echo form_label($this->lang->line('customers_taxable') . ':', 'taxable'); ?></label>
                                <div class="col-sm-10">
                                    <?php echo form_checkbox('taxable', '1', $person_info->taxable == '' ? TRUE : (boolean) $person_info->taxable); ?>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>



                        </div>
                        <div id="sectionB" class="tab-pane fade">
                            <input type="hidden" name="financial_status_id" value="<?= @$person_info->financial_status_id; ?>" />
                            <table class="table" id="tbl-income-sources">
                                <thead>
                                    <tr>
                                        <th style="text-align: center; width: 1%">
                                            <input type="checkbox" class="select_all_" />
                                        </th>
                                        <th style="text-align: center; width: 80%"><?= $this->lang->line("customers_occupation"); ?></th>
                                        <th style="text-align: center; width: 20%"><?= $this->lang->line("customers_monthly_income"); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($financial_infos as $financial_info): ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="select_" />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="sources[]" value="<?= $financial_info[0]; ?>" />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" step="any" name="values[]" value="<?= $financial_info[1]; ?>" />
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <button class="btn btn-primary" type="button" id="btn-add-row"><?= $this->lang->line('common_add_row'); ?></button>
                            <button class="btn btn-danger" type="button" id="btn-del-row"><?= $this->lang->line('common_delete_row'); ?></button>

                        </div>
                        <div id="sectionC" class="tab-pane fade">
                            <h3><?= $this->lang->line('loans_attachments') ?></h3>
                            <div id="required_fields_message"><?php echo $this->lang->line('loans_attachments_message'); ?></div>

                            <div>
                                <ul class="list-inline" id="filelist_a">
                                    <?php foreach ($attachments as $attachment): ?>
                                        <li>
                                            <a href="uploads/customer-<?= $person_info->person_id; ?>/<?= $attachment['filename']; ?>" target="_blank" title="<?= $attachment['filename']; ?>"><img src="<?= $attachment['icon']; ?>" /></a>
                                            <span class="close remove-file" data-file-id="<?= $attachment['id']; ?>" title="Remove this file"><i class="fa fa-times-circle"></i></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <div id="progress_a" class="overlay"></div>

                            <div class="progress progress-task" style="height: 4px; width: 15%; margin-bottom: 2px; display: none">
                                <div style="width: 0%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" role="progressbar" class="progress-bar progress-bar-info">

                                </div>                                    
                            </div>

                            <div id="container_a">
                                <a id="pickfiles_a" href="javascript:;" class="btn btn-default" data-customer-id="<?= $person_info->person_id; ?>"><?= $this->lang->line('common_browse'); ?></a> 
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-close"><?= $this->lang->line("common_close"); ?></button>
            <?php if ((int) $customer_id > -1) : ?>
                <button type="button" class="btn btn-primary" id="btn-edit"><?= $this->lang->line("common_edit"); ?></button>    
            <?php endif; ?>

            <?php
            $display = '';
            if ($customer_id > -1)
            {
                $display = 'display: none';
            }
            echo form_submit(
                    array(
                        'name' => 'submit',
                        'id' => 'btn-save',
                        'value' => $this->lang->line('common_save'),
                        'class' => 'btn btn-primary',
                        'style' => $display
                    )
            );
            ?>
        </div>
    </div>
</div>


<?= form_close(); ?>

<?php $this->load->view("partial/footer"); ?>

<script src="<?php echo base_url(); ?>js/people.js?v=<?= time(); ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {

        if ($("#customer_id").val() > -1)
        {
            $("#customer_form input, textarea").prop("disabled", true);
            $("#customer_form input[type='hidden']").prop("disabled", false);

            $("#btn-edit").click(function () {
                $("#btn-save").show();
                $(this).hide();
                $("#customer_form input, textarea").prop("disabled", false);
            });
        }
         
        $(document).on("click", ".remove-file", function () {
            var el = $(this);
            $.ajax({
                url: '<?= site_url('customers/remove_file'); ?>',
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

        var settings = {
            submitHandler: function (form) {
                $("#submit").prop("disabled", true);
                $(form).ajaxSubmit({
                    success: function (response) {
                        post_person_form_submit(response);
                        $("#submit").prop("disabled", false);
                    },
                    dataType: 'json',
                    type: 'post'
                });

            },
            rules: {
                first_name: "required",
                last_name: "required",
                email: "email"
            },
            messages: {
                first_name: "<?php echo $this->lang->line('common_first_name_required'); ?>",
                last_name: "<?php echo $this->lang->line('common_last_name_required'); ?>",
                email: "<?php echo $this->lang->line('common_email_invalid_format'); ?>"
            }
        };

        $('#customer_form').validate(settings);

        function post_person_form_submit(response)
        {
            if (!response.success)
            {
                set_feedback(response.message, 'error_message', true);
            }
            else
            {
                set_feedback(response.message, 'success_message', false);
            }
            
            $("#customer_form").attr("action", "<?= site_url(); ?>customers/save/" + response.person_id);
        }
    });
</script>