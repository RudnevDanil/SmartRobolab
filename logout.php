<?php
    //Запускаем сессию
    session_start();
    //Добавляем файл подключения к БД
    require_once("dbconnect.php");

    unset($_SESSION["email"]);
    unset($_SESSION["password"]);

    //Запрос на обращение к БД
    $result_query_insert = $mysqli->query("DELETE FROM `list_of_url` WHERE id>2");
    $result_query_insert = $mysqli->query("DELETE FROM `buttons_log` WHERE NOT id=0");
    //Закрываем подключение к БД
    $mysqli->close();  
    
    // Возвращаем пользователя на ту страницу, на которой он нажал на кнопку выход.
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$_SERVER["HTTP_REFERER"]);
?>