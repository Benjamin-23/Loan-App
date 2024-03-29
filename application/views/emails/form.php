<?php $this->load->view("partial/header"); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>js/plugins/summernote/summernote.css">
<script src="<?= base_url(); ?>js/plugins/summernote/summernote.min.js"></script>

<?php echo form_open('emails/save/' . $email_info->email_id, array('id' => 'email_form', 'class' => 'form-horizontal')); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-content">
                <h2>Email Template</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= site_url(); ?>">Home</a>
                    </li>
                    <li>
                        <a>Email Templates</a>
                    </li>
                    <li class="active">
                        <strong>Create</strong>
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
                    Create Email Template
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
                <div id="sectionA" class="tab-pane fade in active">
                    <div style="text-align: center">
                        <div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
                        <ul id="error_message_box"></ul>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Template Name:
                        </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="template_name" id="template_name" value="<?= $email_info->template_name; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Placeholder:
                        </label>
                        <div class="col-sm-10">
                            &nbsp;{person_name}; {company_name}; {price}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label required">
                            Template:
                        </label>
                        <div class="col-sm-10">
                            <textarea class="form-control template" style="height: 150px" name="template" id="template"><?= $email_info->templates; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label required">
                            Descriptions:
                        </label>
                        <div class="col-sm-10">
                            <textarea class="form-control" style="height: 80px" name="descriptions" id="descriptions"><?= $email_info->descriptions; ?></textarea>
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

<input type="hidden" id="hid-template" name="hid-template" value="" />

<?php
echo form_close();
?>

<?php $this->load->view("partial/footer"); ?>

<script type='text/javascript'>

    //validation and submit handling
    $(document).ready(function () {
        $('.template').summernote({height: 150});
        init_settings();
    });


    function init_settings() {
        var settings = {
            submitHandler: function (form) {
                $("#submit").prop("disabled", true);
                $("#hid-template").val($('.template').val());
                
                $(form).ajaxSubmit({
                    success: function (response) {
                        post_message_form_submit(response);
                        $("#submit").prop("disabled", false);
                    },
                    dataType: 'json',
                    type: 'post'
                });
            },
            rules: {
                template_name: "required",
                template: "required"                
            },
            messages: {
                template_name: "Template name is required!",
                template: "Template is required!",                
            }
        };

        $('#email_form').validate(settings);

        function post_message_form_submit(response) {
            if (!response.success)
            {
                set_feedback(response.message, 'error_message', true);
            }
            else
            {
                set_feedback(response.message, 'success_message', false);
            }

            $("#email_form").attr("action", "<?= site_url(); ?>messages/save/" + response.email_id);
        }
    }

</script>