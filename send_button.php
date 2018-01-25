<?php
    //Запускаем сессию
    session_start();
    switch ($_POST["nom_last_but"]) 
    {
    case '1':
      exec('start C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_1.exe ');
      break;
    case '2':
      exec('start C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_2.exe ');
      break;
    case '3':
      exec('start C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_3.exe ');
      break;
    case '4':
      exec('start C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_4.exe ');
      break;
    case '5':
      exec('start C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_5.exe ');
      break;
    case '6':
      exec('start C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_6.exe ');
      break;
    case '7':
      exec('start C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_7.exe ');
      break;
    case '8':
      exec('start C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_8.exe ');
      break;
    case '9':
      exec('start C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_all.exe ');
      break;
    case '10':
      exec('start C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_all_off.exe ');
      break;
    case '11':
      exec('start C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_all_on.exe ');
      break;
    case '12':
      exec('start C:\\OSPanel\\domains\\smartrobolab\\commands\\when_connect.exe ');
      break;
    case '13':
      exec('start C:\\OSPanel\\domains\\smartrobolab\\commands\\init_arduino.exe ');
      break;
    }
    
    //exec('start C:\\Windows\\notepad.exe ');
    //Добавляем файл подключения к БД
    require_once("dbconnect.php");
    //if(isset($_POST["button_1_click"]))
    //Работа если нажали кнопку
    $date_now = date("Y-m-d H:i:s");
    if(isset($_POST["nom_last_but"])) $nom_but = $_POST["nom_last_but"];
    else $nom_but = 0;
    $nom_but = htmlspecialchars($nom_but, ENT_QUOTES);//Не знаю на сколько необходимо, и без этого работает на этом этапе, но пусть будет
    //Запрос на обращение к БД
    $result_query_insert = $mysqli->query("INSERT INTO `buttons_log` (nom_but,date) VALUES ('".$nom_but."', '".$date_now."')");
    //Закрываем подключение к БД
    $mysqli->close();
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$address_site."/index.php");  
    //Останавливаем  скрипт
    exit();
?>



