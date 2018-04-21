<?php
    $serever_adres = 'localhost';
    $dbuser = 'h96046yr__base';
    $dbpassword = 'HeL1UVYS';
    $dbname = 'h96046yr__base';
    $address_site = "http://h96046yr.beget.tech/";
    $connection = mysqli_connect($serever_adres,$dbuser,$dbpassword,$dbname);//сервер, имя пользователя, пароль, название БД
    if($connection == false) //ошибка подключения
    {
        echo 'db connect error!    ';
        echo mysqli_connect_error();//выведет ошибку
        exit();//убиваем скрипт
    }
?>