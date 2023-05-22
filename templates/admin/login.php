<?php $this->layout('admin/wrapper', ['title' => 'Login']) ?>

<?php $this->start('main-content'); ?>
    <div class="login-container">
        <div class="login-form">
            <form>
                <input type="text" placeholder="Username">
                <input type="password" placeholder="Password">
                <input type="submit" value="Login">
            </form>
        </div>
    </div>
<?php $this->stop();
