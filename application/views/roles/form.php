<?php $this->load->view("partial/header"); ?>

<?php echo form_open($controller_name . '/save/' . $id, array('id' => $controller_name . '_form', 'class' => 'form-horizontal')); ?>

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
                        <a href="<?= site_url("roles"); ?>"><?= ucwords($this->lang->line('module_' . $controller_name)); ?></a>
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
                    <?php echo $this->lang->line("info"); ?>
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
                        <?php echo form_label('Role Name' . ':', 'role_name', array('class' => 'required')); ?>
                    </label>
                    <div class="col-sm-10">
                        <input type="text" name="role_name" value="<?= $info->name; ?>" id="role_name" class="form-control">
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        <?php echo form_label('Lower level' . ':', 'low_level'); ?>
                    </label>
                    <div class="col-sm-10">
                        <ul>
                            <?php foreach ($roles as $role): ?>
                                <li style="list-style: none;">
                                    <label style="width: 100%; line-height: 1">                                
                                        <input type="checkbox" name="low_level[]" value="<?= $role->role_id; ?>" <?= in_array($role->role_id, $low_levels) ? "checked='checked'" : ""; ?> />
                                        <span><?= $role->name; ?></span>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        Permissions
                    </label>
                    <div class="col-sm-10">
                        <fieldset id="access_rights">
                            <div style="color:red"><?php echo $this->lang->line("employees_permission_desc"); ?></div>

                            <ul id="permission_list">
                                <?php foreach ($all_modules->result() as $module) : ?>
                                    <li style="list-style: none;">	
                                        <label style="width: 100%">
                                            <?php $disabled = (!in_array($module->module_id, $permission_ids)) ? "disabled='disabled'" : "";?>
                                            <input type="checkbox" name="rights[]" value="<?= $module->module_id; ?>" <?= in_array($module->module_id, $module_ids) ? "checked='checked'" : ""; ?> <?=$disabled;?>>
                                            <span class="medium"><?php echo $this->lang->line('module_' . $module->module_id); ?>:</span>
                                            <span class="small"><?php echo $this->lang->line('module_' . $module->module_id . '_desc'); ?></span>
                                            <?php if($disabled!=''): ?>
                                            <span class="small" style="color:red">No permission record found.</span>
                                            <?php endif; ?>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                        </fieldset>
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
            echo form_submit(
                    array(
                        'name' => 'submit',
                        'id' => 'submit',
                        'value' => $this->lang->line('common_submit'),
                        'class' => 'btn btn-primary'
                    )
            );
            ?>
        </div>
    </div>
</div>


<?php
echo form_close();
?>

<?php $this->load->view("partial/footer"); ?>

<script type='text/javascript'>

    //validation and submit handling
    $(document).ready(function ()
    {
        $("#div-form").height($(window).height() - 250);

        $('#<?= $controller_name; ?>_form').validate({
            submitHandler: function (form)
            {
                $(form).ajaxSubmit({
                    success: function (response)
                    {
                        if (!response.success)
                        {
                            set_feedback(response.message, 'error_message', true);
                        } else
                        {
                            set_feedback(response.message, 'success_message', false);
                        }

                        $("#roles_form").attr("action", "<?= site_url(); ?>loan_types/save/" + response.role_id);
                    },
                    dataType: 'json'
                });

            },
            errorLabelContainer: "#error_message_box",
            wrapper: "li",
            rules:
                    {
                        name: "required"
                    },
            messages:
                    {
                        name: "<?php echo $this->lang->line($controller_name . '_name_required'); ?>",
                    }
        });
    });
</script>





