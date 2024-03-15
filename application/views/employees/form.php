<?php $this->load->view("partial/header"); ?>
<link href="css/plugins/iCheck/custom.css" rel="stylesheet">

<?php echo form_open('employees/save/' . $person_info->person_id, array('id' => 'employee_form', 'class' => 'form-horizontal')); ?>
<input type="hidden" id="person_id" value="<?= $person_info->person_id ?>" />


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
                    <?php echo $this->lang->line("employees_basic_information"); ?>
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
                </div>
                <?php $this->load->view("people/form_basic_info"); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title">
                <h5>
                    <?php echo $this->lang->line("employees_login_info"); ?>
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
                <br/>
                <div class="form-group"><label class="col-sm-2 control-label"><?php echo form_label($this->lang->line('employees_username') . ':', 'username'); ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo form_input(
                                array(
                                    'name' => 'username',
                                    'id' => 'username',
                                    'class' => 'form-control',
                                    'value' => $person_info->username
                                )
                        );
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <?php
                $password_label_attributes = $person_info->person_id == "" ? array('class' => 'required') : array();
                ?>

                <div class="form-group"><label class="col-sm-2 control-label"><?php echo form_label($this->lang->line('employees_password') . ':', 'password', $password_label_attributes); ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo form_password(array(
                            'name' => 'password',
                            'id' => 'password',
                            'class' => 'form-control'
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group"><label class="col-sm-2 control-label"><?php echo form_label($this->lang->line('employees_repeat_password') . ':', 'repeat_password', $password_label_attributes); ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo form_password(array(
                            'name' => 'repeat_password',
                            'id' => 'repeat_password',
                            'class' => 'form-control'
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" style="color:red">
                        Role
                    </label>
                    <div class="col-sm-10">
                        <select class="form-control" name="role_id" id="role_id">
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role->role_id; ?>" <?= ($role->role_id === $person_info->role_id) ? "selected='selected'" : ""; ?>><?= $role->name; ?></option>
                            <?php endforeach; ?>
                        </select>
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
            <?php
            echo form_submit(array(
                'name' => 'submit',
                'id' => 'submit',
                'value' => $this->lang->line('common_submit'),
                'class' => 'btn btn-primary')
            );
            ?>
        </div>
    </div>

</div>


<?php
echo form_close();
?>

<div id="feedback_bar"></div>

<?php $this->load->view("partial/footer"); ?>

<script src="js/plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo base_url(); ?>js/people.js?v=<?= time(); ?>"></script>

<script>
    $(document).ready(function () {
        var person_id = $("#person_id").val();
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });
        var settings = {
            submitHandler: function (form) {
                $("#submit").prop("disabled", true);
                $(form).ajaxSubmit({
                    success: function (response)
                    {
                        post_person_form_submit(response);
                        $("#submit").prop("disabled", false);
                    },
                    dataType: 'json',
                    type: 'post'
                });
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") === "grants[]")
                {
                    error.appendTo('#error_message_box');
                } else
                {
                    error.insertAfter(element);
                }
            },
            rules: {
                first_name: "required",
                last_name: "required",
                username: {
                    required: true,
                    minlength: 5
                },
                password: {
                    required: true,
                    minlength: 8
                },
                repeat_password: {
                    equalTo: "#password"
                },
                email: "email", "grants[]": {
                    required: function (element) {
                        var checked = false;
                        $("ul#permission_list > li > input:checkbox").each(function () {
                            if ($(this).is(":checked"))
                            {
                                var has_children = false;
                                $("ul > li > input:checkbox", $(this).parent()).each(function ()
                                {
                                    has_children = true;
                                    checked |= $(this).is(":checked");
                                });
                                if (has_children && !checked)
                                {
                                    return false;
                                }
                            }
                        });
                        return !checked;
                    },
                    minlength: 1
                }
            },
            messages: {
                first_name: "<?php echo $this->lang->line('common_first_name_required'); ?>",
                last_name: "<?php echo $this->lang->line('common_last_name_required'); ?>",
                email: "<?php echo $this->lang->line('common_email_invalid_format'); ?>",
                username: {
                    required: "<?php echo $this->lang->line('employees_username_required'); ?>",
                    minlength: "<?php echo $this->lang->line('employees_username_minlength'); ?>"
                },
                password: {
                    required: "<?php echo $this->lang->line('employees_password_required'); ?>",
                    minlength: "<?php echo $this->lang->line('employees_password_minlength'); ?>"
                },
                repeat_password: {
                    equalTo: "<?php echo $this->lang->line('employees_password_must_match'); ?>"
                },
                "grants[]": "<?php echo $this->lang->line('employees_grants_required'); ?>"
            }
        };

        if (person_id !== "")
        {
            settings["rules"]["password"]["required"] = false;
        }

        // Validation 
        $('#employee_form').validate(settings);

        function post_person_form_submit(response)
        {
            if (!response.success)
            {
                set_feedback(response.message, 'error_message', true);
            } else
            {
                set_feedback(response.message, 'success_message', false);
            }

            $("#employee_form").attr("action", "<?= site_url(); ?>employees/save/" + response.person_id);
        }
    });
</script>
