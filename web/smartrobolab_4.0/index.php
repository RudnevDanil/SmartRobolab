<?php session_start();?>
<!DOCTYPE html>
<html>
    <head>
        <title> Smart Robolab </title>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="js/ajax.js"></script>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <?php require_once("head.php"); ?>
        <div id="main_content">
            <div class="some_information">
                Our project developed for everybody, who want to make their home or laborotary smarter!
            </div>
            <div class="some_reference form_button"><a href="open_translation.php">OPEN TRANSLATION</a></div>
            <?php if(isset($_SESSION['logged_user_login']))
            {
                ?><div class="some_reference form_button"><a href="working_studio.php">WORKING STUDIO</a></div><?php
            }
            else
            {
                ?><div class="some_reference form_button"><a href="login.php">WORKING STUDIO</a></div><?php
            }
            ?>
            <div class="some_reference form_button"><a href="about_project.php">KNOW MORE ABOUT PROJECT</a></div>
        </div>
        <?php require_once("foot.php"); ?>
    </body>
</html>