<?php $this->layout('admin/wrapper', ['title' => 'Login']) ?>

<?php $this->start('sidebar'); ?>
<!--  -->
<?php $this->stop(); ?>

<?php $this->start('main-content'); ?>
    <div class="login-container">
        <div class="login-form">
            <form id="login-form">
                <input type="text" name="username" placeholder="Username" data-rule-required="true">
                <input type="password" name="password" placeholder="Password" data-rule-required="true">
                <input type="submit" value="Login">
                <div class="errors"></div>
            </form>
        </div>
    </div>
<?php $this->stop();
