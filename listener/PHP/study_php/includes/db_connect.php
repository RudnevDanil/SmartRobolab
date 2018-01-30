<?php
    $serever_adres = '127.0.0.1';
    $dbuser = 'root';
    $dbpassword = '';
    $dbname = 'test_db';
    $connection = mysqli_connect($serever_adres,$dbuser,$dbpassword,$dbname);//сервер, имя пользователя, пароль, название БД
    if($connection == false) //ошибка подключения
    {
        echo 'db connect error!    ';
        echo mysqli_connect_error();//выведет ошибку
        exit();//убиваем скрипт
    }
?>