<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $this->lang->line('login_welcome_message'); ?> <?= APP_NAME . " " . $this->config->item('application_version'); ?></title>


        <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet"></link>
        <link href="<?php echo base_url(); ?>fonts/font-awesome/css/font-awesome.css" rel="stylesheet"></link>

        <link href="<?php echo base_url(); ?>css/animate.css" rel="stylesheet"></link>
        <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet"></link>


        <script src="<?php echo base_url(); ?>js/jquery-2.1.1.js"></script>
        <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>



    </head>
    <body class="gray-bg">
        <div class="loginColumns animated fadeInDown">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="font-bold"><?php echo $this->lang->line('login_welcome_message'); ?> <?= APP_NAME . " " . $this->config->item('application_version'); ?></h2>

                    <div style="text-align: justify">
                        <?php echo $this->lang->line('common_welcome_message'); ?>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="inqbox-content">
                        <?php echo form_open('login', array('class' => 'form-signin')) ?>
                        <span style="color:red"><?php echo validation_errors(); ?></span>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" placeholder="Username" required="" name="username" size="2">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Password" required="" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                        <a href="javascript:void(0)">
                            <small>Forgot password?</small>
                        </a>
                        <!--
                        <p class="text-muted text-center">
                            <small>Do not have an account?</small>
                        </p>
                        
                        <a class="btn btn-sm btn-white btn-block" href="javascript:void(0)" id="btn-create-account">Create an account</a>-->
                        <?php echo form_close(); ?>

                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-6">
                    Copyright <?php echo COMPANY_NAME; ?>
                </div>
                <div class="col-md-6 text-right">
                    <small>© 2015-<?php echo date('Y'); ?></small>
                </div>
            </div>
        </div>


        <div class="modal fade" id="register_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Create an Account</h4>

                    </div>
                    <div class="modal-body clearfix">

                        <div class="row">
                            
                            <?php echo form_open('login/signup', array('class' => 'form-signin', 'id' => 'frmSignup')) ?>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Username *</label>
                                    <input type="text" class="form-control" placeholder="Username" required="" name="reg_username">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                
                            </div>
                            <div class="clearfix"></div>
                            
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Password *</label>
                                    <input type="password" class="form-control" placeholder="Password" required="" name="reg_password">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Re-Type Password *</label>
                                    <input type="password" class="form-control" placeholder="Re-type password" required="" name="reg_repassword">
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>First Name *</label>
                                    <input type="text" class="form-control" placeholder="FirstName" required="" name="reg_first_name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Last Name *</label>
                                    <input type="text" class="form-control" placeholder="LastName" required="" name="reg_last_name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Email *</label>
                                    <input type="email" class="form-control" placeholder="Email" required="" name="reg_email">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input type="text" class="form-control" placeholder="Contact Number" required="" name="reg_contact_number">
                                </div>
                            </div>
                            
                            <?php echo form_close(); ?>
                            
                        </div>



                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-close">Close</button>
                        <button id="btn-signup" class="btn btn-primary" type="button">Submit</button>
                    </div>


                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                $("#btn-create-account").click(function () {
                    $("#register_modal").modal("show");
                });
                
                $("#btn-signup").click(function(){
                    var url = $("#frmSignup").attr("action");
                    var params = $("#frmSignup").serialize();
                    $.post(url, params, function(data){
                        if (data.status == "OK")
                        {
                            alert("Good");
                            $("#register_modal").modal("hide");
                        }
                    }, "json");
                });
            });
        </script>

    </body>
</html>
















