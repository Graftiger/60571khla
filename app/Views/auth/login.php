<?= $this->extend('templates/layout') ?>
<?= $this->section('content') ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-12 ">

                <h1><?php echo lang('Auth.login_heading');?></h1>
                <p><?php echo lang('Auth.login_subheading');?></p>

                <?php if (isset($message)): ?>
                    <div class="alert alert-danger"><?php echo $message;?></div>
                <?php endif ?>

                <?php echo form_open('auth/login');?>
                <div class="mb-3">
                    <?php echo form_label(lang('Auth.login_identity_label'), 'identity');?>
                    <?php echo form_input($identity, '','class="form-control" value="Mark" required');?>
                </div>
                <div class="mb-3">
                    <?php echo form_label(lang('Auth.login_password_label'), 'password');?>
                    <?php echo form_input($password, '','class="form-control" value="Mark" required');?>
                </div>
                <div class="mb-3">
                    <?php echo form_label(lang('Auth.login_remember_label'), 'remember');?>
                    <?php echo form_checkbox('remember', '1', false, 'id="remember"');?>
                </div>
                <div class="mb-3 row justify-content-center">
                    <?php echo form_submit('submit', lang('Auth.login_submit_btn'), 'class="btn btn-primary"');?>
                </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
    <p class="text-center"><a href="forgot_password"><?php echo lang('Auth.login_forgot_password');?></a>&nbsp<a href="register_user"><?php echo lang('Auth.register_user_link');?></a></p>
    <a href="<?= $authUrl; ?>" class="btn btn-outline-dark" role="button" style="text-transform:none">
        <img width="20px" style="margin-bottom:3px; margin-right:5px" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" />
        <?= lang('Curating.login_with_google') ?>
    </a>
<?= $this->endSection() ?>