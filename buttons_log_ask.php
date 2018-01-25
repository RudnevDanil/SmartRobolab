<?php
    //подключение к БД
    $mysqli = new mysqli("localhost", "h96046yr__base", "HeL1UVYS", "h96046yr__base");
    // Проверка соединения 
    if (mysqli_connect_errno()) 
    {
        echo '<h1>Connect failed</h1>';
        exit();
    }
    //составление запроса на поле nom при максимальном id
    $query = "SELECT id,nom_but FROM `buttons_log` WHERE id=(SELECT MIN(id) FROM `buttons_log`)";
    if ($stmt = $mysqli->prepare($query)) 
    {
        // выполнение запроса 
        $stmt->execute();
        // привязка переменных к запросу.  bind_result($id,$url) вернет всю строчку к примеру
        $stmt->bind_result($buton_id,$button_nom);
        // выборка значений
        while ($stmt->fetch()) 
        {
            echo $buton_id;
            echo ___№;
            echo $button_nom;
        }
        // закрыли соединение
        $stmt->close();
    }
    //теперь удалим исполненную запись
    $result_query_delete = $mysqli->query("DELETE FROM `buttons_log` WHERE id=".$buton_id."");
    // закрыли БД
    $mysqli->close();
?>