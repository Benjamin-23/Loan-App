<?php $this->load->view("partial/header"); ?>
<style>
    table#datatable td:nth-child(2),
    td:nth-child(7)
    {
        text-align: center
    }
</style>

<div class="hide-staff" style="display: none;">
    <select class="form-control input-sm hidden-xs" id="sel-staff">
        <option value="0">Select staff</option>
        <?php foreach ($staffs as $staff): ?>
            <option value="<?= $staff->person_id; ?>" <?= ((isset($_GET['employee_id'])) && $_GET['employee_id'] === $staff->person_id) ? 'selected="selected"' : ""; ?>><?= $staff->first_name . " " . $staff->last_name; ?></option>
        <?php endforeach; ?>
    </select>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-content">
                <h2>List of Email Templates</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= site_url(); ?>">Home</a>
                    </li>
                    <li>
                        <a>Email Templates</a>
                    </li>
                    <li class="active">
                        <strong>List</strong>
                    </li>
                </ol>
            </div>
        </div>
    </div>    
</div>

<div class="row">
    <div class="col-lg-12">

        <div class="inqbox float-e-margins">
            <div class="inqbox-title border-top-danger">
                <h5>
                    <?= $this->lang->line('module_' . $controller_name); ?>
                </h5>
                <div class="inqbox-tools">
                    <?= anchor("$controller_name/view/-1", "<div class='btn btn-primary btn-xs' style='float: left; margin-right: 10px'><span>New Template</span></div>"); ?>
                    <?php echo anchor("$controller_name/delete", $this->lang->line("common_delete"), array('id' => 'delete', 'class' => 'btn btn-primary btn-xs')); ?>
                </div>
            </div>
            <div class="inqbox-content table-responsive">

                <table id="datatable" class="table table-hover table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 1%"><input type="checkbox" class="select_all" /></th>
                            <th style="text-align: center"><?= $this->lang->line('common_id') ?></th>
                            <th style="text-align: center">Template Name</th>
                            <th style="text-align: center">Description</th>
                            <th style="text-align: center">Created By</th>                            
                            <th style="text-align: center; width: 1%"><?= $this->lang->line('common_action'); ?></th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
</div>

<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript">
    $(document).ready(function ()
    {
        enable_delete('<?php echo "Are you sure you want to delete this template?" ?>', '<?php echo "Please select a template to delete" ?>');

        $("#datatable").dataTable({
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [0, 5]}
            ],
            "language": {
                "url": "<?php echo base_url($this->config->item('language') . ".json"); ?>"
            },
            "processing": true,
            "serverSide": true,
            "aLengthMenu": [[50, 100, 200, 100000], [50, 100, 200, "<?= $this->lang->line("common_all") ?>"]],
            "iDisplayLength": 50,
            "order": [1, "desc"],
            "ajax": {
                "url": "<?php echo site_url("emails/data") ?>",
                data: {employee_id:'<?=isset($_GET['employee_id'])?$_GET['employee_id']:false;?>'},
                type: 'get'
            },
            "initComplete": function (settings, json) {
                $("#datatable_filter").find("input[type='search']").attr("placeholder", "<?= $this->lang->line("common_search"); ?>");
                
                var el = $(".dataTables_filter").find('label');
                    el.append("&nbsp;");                    
                    el.append($(".hide-staff").html());
            }
        });
        
        $(document).on("change", "#sel-staff", function(){
            location.href = "<?=site_url($this->uri->segment(1))?>?employee_id=" + $(this).val();
        });

        // selecting all
        $(".select_all").click(function () {
            if ($(this).is(":checked"))
            {
                $("input[name='chk[]']").prop("checked", true);
            } else
            {
                $("input[name='chk[]']").prop("checked", false);
            }
        });
    });

</script>