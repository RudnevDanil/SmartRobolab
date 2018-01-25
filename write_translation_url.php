<?php
    //Запускаем сессию
    session_start();
    //Добавляем файл подключения к БД
    require_once("dbconnect.php");
    //Обращение к форме админа
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$address_site."/form_admin.php");     
    if (isset($_POST["btn_submit_new_url"]))
    {
        //Работа если ввели новый URL    НЕ СТАВИТЬ ПУСТЫЕ СТРОКИ!!!
        $NEW_URL=$_POST["url"];
        $NEW_URL=substr($NEW_URL, -11); //забираем из ссылки только последние 11 символов - они нам и нужны
        $NEW_URL = htmlspecialchars($NEW_URL, ENT_QUOTES);//Не знаю на сколько необходимо, и без этого работает на этом этапе, но пусть будет
        //Запрос на обращение к БД
        $result_query_insert = $mysqli->query("INSERT INTO `list_of_url` (url) VALUES ('".$NEW_URL."')");
        //Закрываем подключение к БД
        $mysqli->close();  
        $_SESSION['url']=$NEW_URL;
        //$_SESSION["error_messages"] .= "<p class='mesage_error'>$NEW_URL</p>";
        //Отправляем пользователя на страницу авторизации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$address_site."/index.php");  
    }
    //Останавливаем  скрипт
    exit();
?>



