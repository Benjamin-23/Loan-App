
<?php $this->load->view("partial/header"); ?>

<div class="row">
    <div class="col-lg-4">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title border-top-primary">
                <span class="label label-primary pull-right">Annual</span>
                <h5><?=$this->lang->line('common_my_wallet'); ?></h5>
            </div>
            <div class="inqbox-content">
                <h1 class="no-margins"><?php echo $my_wallet;?></h1>
                <div class="stat-percent font-bold text-primary">20% <i class="fa fa-level-up"></i></div>
                <small><?=$this->lang->line('common_total_wallet'); ?></small>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title border-top-info">
                <span class="label label-info pull-right">Annual</span>
                <h5><?=$this->lang->line('common_loans'); ?></h5>
            </div>
            <div class="inqbox-content">
                <h1 class="no-margins"><?= $total_loans; ?></h1>
                <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div>
                <small><?=$this->lang->line('common_total_loans'); ?></small>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title border-top-info">
                <span class="label label-info pull-right">Monthly</span>
                <h5><?=$this->lang->line('common_borrowers'); ?></h5>
            </div>
            <div class="inqbox-content">
                <h1 class="no-margins"><?= $total_borrowers; ?></h1>
                <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div>
                <small><?=$this->lang->line('common_borrowers'); ?></small>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("partial/footer"); ?>