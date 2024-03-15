</div>
<!-- END CONTENT -->

<!-- BEGIN FOOTER -->
<div class="footer">
    <div>
        <?php echo $this->lang->line('common_powered_by') . " " . $this->config->item('application_version'); ?>
    </div>
</div>
<!-- BEGIN FOOTER -->
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="config_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="print_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->




</body>
</html>


<!-- Custom and plugin javascript -->
<script src="js/main.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.niftymodals/js/jquery.modalEffects.js"></script>
<script>
    $(document).ready(function () {
        $('.md-trigger').modalEffects();
    });
</script>
