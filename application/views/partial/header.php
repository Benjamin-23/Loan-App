<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <base href="<?php echo base_url(); ?>" />
        <title><?php echo $this->config->item('company') . ' -- ' . $this->lang->line('common_powered_by'); ?></title>

        <script>
            BASE_URL = '<?php echo base_url(); ?>';
            TOKEN_HASH = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>

        <!-- Toastr style -->
        <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet"></link>

        <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet"></link>
        <link href="<?php echo base_url(); ?>fonts/font-awesome/css/font-awesome.css" rel="stylesheet"></link>

        <link href="<?php echo base_url(); ?>css/animate.css" rel="stylesheet"></link>
        <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet"></link>
        <link href="<?php echo base_url(); ?>css/forms/kforms.css" rel="stylesheet"></link>

        <!-- Data Tables -->
        <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet"></link>
        <link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet"></link>
        <link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet"></link>
        <link href="js/alertifyjs/css/alertify.css" rel="stylesheet"></link>

        <style type="text/css">
            html {
                overflow: auto;
            }
        </style>

        <!-- Mainly scripts -->
        <script src="<?php echo base_url(); ?>js/jquery-2.1.1.js"></script>
        <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="<?php echo base_url(); ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Data Tables -->
        <script src="<?php echo base_url(); ?>js/plugins/dataTables/jquery.dataTables.js?v=1"></script>
        <script src="<?php echo base_url(); ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>js/plugins/dataTables/dataTables.responsive.js"></script>
        <script src="<?php echo base_url(); ?>js/plugins/dataTables/dataTables.tableTools.min.js"></script>
        <!-- Data Tables -->
        
        <!-- datatable editor bootstrap setup - start -->
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>js/plugins/dataTables/editor/js/dataTables.editor.js"></script>
        <script type="text/javascript" charset="utf-8" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>

        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.bootstrap.min.js"></script>

        <script type="text/javascript" language="javascript" src="https://editor.datatables.net/extensions/Editor/js/editor.bootstrap.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://editor.datatables.net/extensions/Editor/css/editor.bootstrap.min.css" />
        <!-- datatable editor bootstrap setup - end -->
        

        <script src="<?php echo base_url(); ?>js/manage_tables.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery.form.min.js"></script>

        <!-- Jquery Validate -->
        <script src="<?php echo base_url(); ?>js/plugins/validate/jquery.validate.min.js"></script>

        <!-- Toastr script -->
        <script src="<?php echo base_url(); ?>js/plugins/toastr/toastr.min.js"></script>

        <script src="<?php echo base_url(); ?>js/jquery.autocomplete/dist/jquery.autocomplete.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo base_url(); ?>js/jquery.datatables/plugins/fnReloadAjax.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo base_url(); ?>js/plupload/plupload.full.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo base_url(); ?>js/alertifyjs/alertify.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery-migrate-1.2.1.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery.blockUI.js"></script>
        <script src="<?php echo base_url(); ?>js/common.js?v=<?=APP_VERSION; ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>

        <!-- Date picker -->
        <script src="<?=base_url('js/plugins/datapicker/bootstrap-datepicker.js')?>"></script>

    </head>
    <body>

        <input type="hidden" id="token_hash" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <input type="hidden" id="site_url" value="<?php echo site_url() ?>" />

        <div id="wrapper">
            <nav class="navbar-default navbar-static-side fixed-menu" role="navigation">
                <div class="sidebar-collapse">
                    <div id="hover-menu"></div>
                    <ul class="nav metismenu" id="side-menu">
                        <li>
                            <div class="logopanel" style="margin-left: 0px; z-index: 99999">
                                <div class="profile-element"> 
                                    <h2><a href="/"><?php echo APP_NAME; ?></a></h2>
                                </div>
                                <div class="logo-element">
                                    KL
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="leftpanel-profile">
                                <div class="media-left">
                                    <a href="#">
                                        <?php if (trim($user_info->photo_url) !== "" && file_exists( FCPATH  .  "/uploads/profile-" . $user_info->person_id . "/" . $user_info->photo_url ) ):  ?>
                                        <img src="<?= base_url("uploads/profile-" . $user_info->person_id . "/" . $user_info->photo_url); ?>" style="width:50px;height:50px" alt="" class="media-object img-circle" />
                                        <?php else: ?>
                                        <img src="http://via.placeholder.com/80x80" alt="" class="media-object img-circle" />
                                        <?php endif; ?>
                                    </a>
                                </div>
                                <div class="media-body profile-name" style="white-space: nowrap;">
                                    <h4 class="media-heading"><?= ucwords($user_info->first_name); ?> <a data-toggle="collapse" data-target="#loguserinfo" class="pull-right"><i class="fa fa-angle-down"></i></a></h4>
                                    <span><?= $user_info->email; ?></span>
                                </div>
                            </div>

                            <div class="leftpanel-userinfo collapse" id="loguserinfo" style="position: absolute; background: #3b4354!important">
                                <h5 class="sidebar-title">Address</h5>
                                <address>
                                    <?php echo $user_info->address_1; ?>
                                </address>
                                <h5 class="sidebar-title">Contact</h5>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <label class="pull-left">Email</label>
                                        <span class="pull-right"><?php echo $user_info->email; ?></span>
                                    </li>                                    
                                    <li class="list-group-item">
                                        <label class="pull-left">Social</label>
                                        <div class="social-icons pull-right">
                                            <a href="#"><i class="fa fa-facebook-official"></i></a>
                                            <a href="#"><i class="fa fa-twitter"></i></a>
                                            <a href="#"><i class="fa fa-pinterest"></i></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li>

                            <!-- START : Left sidebar -->
                            <div class="nano left-sidebar">
                                <div class="nano-content">
                                    <ul class="nav nav-pills nav-stacked nav-inq">
                                        <?php $selected = (strpos(strtolower(substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1)), strtolower($this->lang->line("common_home"))) !== FALSE) ? "active" : ""; ?>
                                        <li class="<?= $selected; ?>">
                                            <a href="<?=  site_url("home")?>"><i class="fa fa-home"></i> <span class="nav-label"><?= $this->lang->line("common_home"); ?></span></a>
                                        </li>
                                        <?php foreach ($allowed_modules->result() as $module) : ?>

                                            <?php
                                            $select_list = ($this->uri->segment(1) === $module->module_id && $this->uri->segment(2) !== "view") ? "active" : "";
                                            $select_new = ($this->uri->segment(1) === $module->module_id && $this->uri->segment(2) === "view") ? "active" : "";
                                            ?>

                                            <?php if (!in_array($module->module_id, ["config", "plugins", "overdues", "my_wallets"])): ?>
                                                <?php if($module->module_id !== "loan_types"): // hide loan types temporarilhy ?>
                                                <li class="nav-parent <?= ($select_new !== "") ? $select_new : $select_list; ?>">
                                                    <a href="<?php echo site_url("$module->module_id"); ?>" title="<?php echo $this->lang->line('module_' . $module->module_id . '_desc'); ?>">
                                                        <i><?= str_replace("font-size: 50px", "font-size: 16px", $module->icons); ?></i>
                                                        <span class="nav-label"><?php echo $this->lang->line("module_" . $module->module_id) ?></span>
                                                    </a>
                                                    <ul class="children nav">
                                                        <?php if ($module->module_id !== "messages"): ?>
                                                            <li><a href="<?php echo site_url("$module->module_id"); ?>/view/-1" class="<?= $select_new; ?>">New</a></li>
                                                            <li><a href="<?php echo site_url("$module->module_id"); ?>" class="<?= $select_list; ?>">List</a></li>
                                                        <?php elseif ($module->module_id === "messages"): ?>                                                            
                                                            <li><a href="<?php echo site_url("$module->module_id"); ?>/view/-1" class="<?= ($this->uri->segment(1) === "messages" && $this->uri->segment(2) === "view" ? "active" : ""); ?>">New</a></li>
                                                            <li><a href="<?php echo site_url("messages/inbox"); ?>" class="<?= ($this->uri->segment(2) === "inbox" ? "active" : ""); ?>">Inbox</a></li>
                                                            <li><a href="<?php echo site_url("messages/outbox"); ?>" class="<?= ($this->uri->segment(2) === "outbox" ? "active" : ""); ?>">Outbox</a></li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </li>
                                                <?php endif;?>
                                            <?php else: ?>
                                                <?php $selected = ($this->uri->segment(1) === site_url("$module->module_id")) ? "active" : ""; ?>
                                                <li class="<?= $selected; ?>">
                                                    <a href="<?php echo site_url("$module->module_id"); ?>"><i><?= str_replace("font-size: 50px", "font-size: 16px", $module->icons); ?></i> <span class="nav-label"><?= $this->lang->line("module_" . $module->module_id); ?></span></a>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?> 
                                    </ul>
                                </div>
                            </div>
                            <!-- END : Left sidebar -->

                        </li>
                    </ul>
                </div>
            </nav>

            <div id="page-wrapper" class="gray-bg">
                <!-- BEGIN HEADER -->
                <div id="header">
                    <nav class="navbar navbar-fixed-top white-bg show-menu-full" id="nav" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn" href="javascript:void(0)"><i class="fa fa-bars" style="font-size:27px;"></i> </a>
                            <form role="search" class="navbar-form-custom">
                                <div class="form-group">
                                    <div class="kform theme-primary">
                                        <div>
                                            <label class="field append-icon">
                                                <input type="text" name="search" id="search" class="gui-input" placeholder="Type your search here..." />
                                                <label for="search" class="field-icon">
                                                    <i class="fa fa-search"></i>
                                                </label>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li class="dropdown hidden-xs">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    <i class="fa fa-envelope"></i>  
                                    <?php if (count($messages) > 0): ?>
                                        <span class="label label-danger"><?= count($messages); ?></span>
                                    <?php endif; ?>
                                </a>
                                <ul class="dropdown-menu dropdown-messages">
                                    <?php foreach ($messages as $message): ?>
                                        <li>
                                            <div class="dropdown-messages-box">
                                                <a href="<?= $message->profile_url; ?>" class="pull-left animated animated-short fadeInUp">
                                                    <img alt="image" class="img-circle" src="<?= $message->profile_pic; ?>" />
                                                </a>
                                                <div class="animated animated-short fadeInUp">
                                                    <small class="pull-right"><?= $message->hours_ago; ?></small>
                                                    <strong><?= $message->sender_name; ?></strong> sent you a message. <strong><?= $message->header; ?></strong><br />
                                                    <small class="text-muted"><?= $message->str_timestamp; ?></small>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="divider"></li>
                                    <?php endforeach; ?>
                                    <li>
                                        <div class="text-center link-block">
                                            <a href="<?= site_url("messages/inbox"); ?>" class="animated animated-short fadeInUp">
                                                <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown hidden-xs">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    <i class="fa fa-bell"></i>  
                                    <?php if (count($alerts) > 0): ?>
                                        <span class="label label-danger"><?= count($alerts); ?></span>
                                    <?php endif; ?>
                                </a>
                                <ul class="dropdown-menu dropdown-alerts">
                                    <?php foreach ($alerts as $alert): ?>
                                        <li>
                                            <a href="<?= $alert->alert_url; ?>" class="animated animated-short fadeInUp">
                                                <div>
                                                    <i class="fa fa-envelope fa-fw"></i> <?= $alert->subject; ?>
                                                    <span class="pull-right text-muted small"><?= $alert->hours_ago; ?></span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                    <?php endforeach; ?>

                                    <li>
                                        <div class="text-center link-block">
                                            <a href="javascript:void(0)" class="animated animated-short fadeInUp">
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    <span class="pl15"> <?= ucwords($user_info->first_name . " " . $user_info->last_name); ?> </span>
                                    <span class="caret caret-tp"></span>
                                </a>

                                <ul class="dropdown-menu animated m-t-xs">
                                    <li><a href="<?= site_url("employees/view/" . $user_info->person_id); ?>" class="animated animated-short fadeInUp"><i class="fa fa-user"></i> Profile</a></li>
                                    <li><a href="<?= site_url("customers"); ?>" class="animated animated-short fadeInUp"><i class="fa fa-group"></i> Contacts</a></li>
                                    <li><a href="<?= site_url("messages/inbox") ?>" class="animated animated-short fadeInUp"><i class="fa fa-inbox"></i> Mailbox</a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?= site_url("home/logout")?>" class="animated animated-short fadeInUp"><i class="fa fa-sign-out"></i> Logout</a></li>
                                </ul>

                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- END HEADER -->

                <div style="clear: both; height: 61px;"></div>





                <!-- BEGIN CONTENT -->
                <div class="wrapper wrapper-content">
