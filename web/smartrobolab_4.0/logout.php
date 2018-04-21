<?php session_start();
    $login = $_SESSION['logged_user_login'];
    $file_name = "commands/".$login.'_commands.txt';
    $file = fopen($file_name, 'w');
    fclose($file);
    include("dbconnect.php");
    $now = date('Y-m-d H:i:s', time() - 28800);
    mysqli_query($connection, "UPDATE `list_of_url` SET `last_add_date` = '$now' WHERE `user_login`='$login'");
    unset($_SESSION['logged_user_login']);
    mysqli_close($connection);   
    header('Location: /');
?>