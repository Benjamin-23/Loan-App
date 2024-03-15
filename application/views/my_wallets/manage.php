<?php $this->load->view("partial/header"); ?>
<style>
    table#datatable td:nth-child(6) {
        width: 15%;
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
                <h2>
                    <i class="fa fa-briefcase" style="font-size: 40px; color:#e80a0a"></i> 
                    My Wallet (<span id="wallet_total"><?php echo to_currency($wallet_total); ?></span>)
                    <input type="hidden" id="available_amount" value="<?= $wallet_total ?>" />
                </h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= site_url(); ?>">Home</a>
                    </li>
                    <li>
                        <a>My Wallet</a>
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
                    <?php
                    echo anchor("$controller_name/delete", $this->lang->line("common_delete"), array('id' => 'delete-wallet', 'class' => 'btn btn-primary btn-xs'));
                    echo anchor("$controller_name/view/-1", "<div class='btn btn-primary btn-xs' style='float: left; margin-right:10px;'><span>" . $this->lang->line('my_wallet_new') . "</span></div>", array('class' => 'thickbox none', 'data-toggle' => 'modal', 'data-target' => '#wallet_modal', 'title' => $this->lang->line('my_wallet_new')));
                    ?>
                </div>
            </div>
            <div class="inqbox-content table-responsive">

                <table id="datatable" class="table table-hover table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 1%"><input type="checkbox" class="select_all_" /></th>
                            <th><?= $this->lang->line('common_id') ?></th>
                            <th><?= $this->lang->line('my_wallet_amount') ?></th>
                            <th><?= $this->lang->line('my_wallet_description') ?></th>
                            <th><?= $this->lang->line('my_wallet_type') ?></th>
                            <th><?= $this->lang->line('my_wallet_trans_date') ?></th>                    
                            <th style="text-align: center; width: 1%"><?= $this->lang->line("common_action"); ?></th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
</div>

<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript">
    $(document).ready(function ()
    {
        $("#sel-staff").on("change", function () {
            location.href = "<?= site_url($this->uri->segment(1)) ?>?employee_id=" + $(this).val();
        });

        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });

        $("#datatable").dataTable({
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [0, 6]}
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
                "url": "<?php echo site_url("my_wallets/data") ?>",
                data: {employee_id: '<?= isset($_GET['employee_id']) ? $_GET['employee_id'] : false; ?>'},
                type: 'get'
            },
            "initComplete": function (settings, json) {
                var el = $("#datatable_filter").find('label');
                el.find("input[type='search']").attr("placeholder", "<?= $this->lang->line("common_search") ?>");
                el.append("&nbsp;");                    
                el.append($(".hide-staff").html());
            }
        });

        $(document).on("change", "#sel-staff", function () {
            location.href = "<?= site_url($this->uri->segment(1)) ?>?employee_id=" + $(this).val();
        });

        $('#delete-wallet').click(function (event)
        {
            var $this = $(this);
            event.preventDefault();

            var selected = new Array();
            $('input[name="chk[]"]:checked').each(function () {
                selected.push($(this).val());
            });

            if (selected.length > 0)
            {
                alertify.confirm('<?php echo $this->lang->line("my_wallet_confirm_delete") ?>', function(){                    
                    var row_ids = selected;
                    var url = $this.attr('href');
                    $.post(url, {'ids[]': row_ids, "softtoken": $('#token_hash').val()}, function (response)
                    {
                        //delete was successful, remove checkbox rows
                        if (response.success)
                        {
                            update_sortable_table();
                            $("#wallet_total").html(response.wallet_amount);
                            $("#available_amount").val(response.wallet_total);
                            set_feedback(response.message, 'success_message', false);
                        } else
                        {
                            set_feedback(response.message, 'error_message', true);
                        }

                    }, "json");
                });
            } else
            {
                alertify.alert('<?php echo $this->lang->line("my_wallet_none_selected") ?>');
            }
        });

        $(".select_all_").click(function () {
            if ($(this).is(":checked"))
            {
                $(".select_").prop("checked", true);
            } else
            {
                $(".select_").prop("checked", false);
            }
        });

    });
</script>




























<div id="table_action_header">
    <div class="row">
        <div class="col-xs-3">
            <?php echo anchor("$controller_name/delete", $this->lang->line("common_delete"), array('id' => 'delete-wallet', 'class' => 'btn btn-primary')); ?>
        </div>
        <div class="col-xs-9">
            <div class="pull-right">
                <select class="form-control" id="sel-staff">
                    <option value="0">Select staff</option>
                    <?php foreach ($staffs as $staff): ?>
                        <option value="<?= $staff->person_id; ?>" <?= ((isset($_GET['employee_id'])) && $_GET['employee_id'] === $staff->person_id) ? 'selected="selected"' : ""; ?>><?= $staff->first_name . " " . $staff->last_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="wallet_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


