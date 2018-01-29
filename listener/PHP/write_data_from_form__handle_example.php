<?php
/*
    Пусть есть таблица `users`
    id          INT     11  A/I PRIMARY
    login       VARCHAR 255
    password    VARCHAR 255
*/
    include('includes/db_connect.php');
    /*
        Подключили файл вместо того чтобы копипастить код. Вот он если что:
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
    */
    // if(isset($_POST['login'])) {}// если определена переменная
    $login = $_POST['login'];
    $password = $_POST['password'];
    $count = mysqli_query("SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
    if(mysqli_num_rows($count) == 0)
    {
        echo 'Вы не зарегестрированы!';
    }
    else
    {
        echo 'Привет, ' . $login . ' !';
    }
?>