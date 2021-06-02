<?= $this->extend('templates/layout'); echo strlen($message)?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-12 ">
            <h1><?php echo lang('Auth.login_heading');?></h1>
            <p><?php echo lang('Auth.login_subheading');?></p>
            <?php if (isset($message)): ?>
                <div class="alert alert-danger">
                    <?php echo $message;?>
                </div>
            <?php endif ?>
            <?php echo form_open('auth/register_user');?>
            <div class="mb-3">
                <?php echo form_label(lang('Auth.create_user_fname_label'), 'first_name');?> <br />
                <?php echo form_input($first_name);?>
            </div>
            <div class="mb-3">
                <?php echo form_label(lang('Auth.create_user_lname_label'), 'last_name');?> <br />
                <?php echo form_input($last_name);?>
            </div>
            <?php
            if ($identity_column !== 'email') {
                echo '<div class="mb-3">';
                echo form_label(lang('Auth.create_user_identity_label'), 'identity');
                echo '<br/>';
                echo \Config\Services::validation()->getError('identity');
                echo form_input($identity);
                echo '</div>';
            }
            ?>
            <div class="mb-3">
                <?php echo form_label(lang('Auth.create_user_company_label'), 'company');?> <br />
                <?php echo form_input($company);?>
            </div>
            <div class="mb-3">
                <?php echo form_label(lang('Auth.create_user_email_label'), 'email');?> <br />
                <?php echo form_input($email);?>
            </div>
            <div class="mb-3">
                <?php echo form_label(lang('Auth.create_user_phone_label'), 'phone');?> <br />
                <?php echo form_input($phone);?>
            </div>
            <div class="mb-3">
                <?php echo form_label(lang('Auth.create_user_password_label'), 'password');?> <br />
                <?php echo form_input($password);?>
            </div>
            <div class="mb-3">
                <?php echo form_label(lang('Auth.create_user_password_confirm_label'), 'password_confirm');?> <br />
                <?php echo form_input($password_confirm);?>
            </div>
            <div class="mb-3">
                <?php echo form_submit('submit', lang('Auth.register_user_submit_btn'));?>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
