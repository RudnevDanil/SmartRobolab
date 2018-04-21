<?php
    include("dbconnect.php");
    $login = mysqli_real_escape_string($connection,trim($_GET['login']));
    $pass = md5(mysqli_real_escape_string($connection, trim($_GET['pass'])));
    $count_of_matches = mysqli_query($connection, "SELECT COUNT(id) AS `total_count` FROM `users_list` WHERE `login` = '$login' AND `password` = '$pass'");
    $count_of_matches_result = mysqli_fetch_assoc($count_of_matches);
    mysqli_close($connection);
    if($count_of_matches_result['total_count'] == 1)
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $login . '_commands.txt');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize("commands/".$login."_commands.txt"));
        // читаем файл и отправляем его пользователю
        readfile("commands/".$login."_commands.txt");
    }
    else
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . 'wrong_login_or_password.txt');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize("commands/wrong_login_or_password.txt"));
        // читаем файл и отправляем его пользователю
        readfile("commands/wrong_login_or_password.txt");
    }
    

?>