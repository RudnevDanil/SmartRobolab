<?php session_start();?>
<div id="head">
    <a href="index.php" id="logo_link"><img src="images/SR-logo.png" id="logo_img"></a>
    <div id="proj_name_line">SMARTROBOLAB</div>
    <div id="auth_block">
        <?php
        if(isset($_SESSION['logged_user_login']))
        {?>
            <div class="auth_buttons">Hello, <?php echo $_SESSION['logged_user_login']; ?> !</div>
            <div class="auth_buttons"><a href="logout.php">Exit</a></div>
        <?php }
        else
        {?>
            <div class="auth_buttons"><a href="login.php">Login</a></div>
            <div class="auth_buttons"><a href="registration.php">Registration</a></div>
        <?php }
        ?>
    </div>
</div>