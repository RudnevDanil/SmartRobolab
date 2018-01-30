<?php

/*
-- last_id = -1
-- обновлять раз в пол секунды и если последний id в таблице > last_id то читать WHERE id > last_id , открыть файл на запись в конец, это записать в файл по типу _`id`_`nom_but` yfghbvth _3_12\n гдде 3 это id, а 12 номер кнопки, закрыть файл.


*/
    $serever_adres = '127.0.0.1';
    $dbuser = 'root';
    $dbpassword = '';
    $dbname = 'h96046yr__base';
    $connection = mysqli_connect($serever_adres,$dbuser,$dbpassword,$dbname);//сервер, имя пользователя, пароль, название БД
    if($connection == false) //ошибка подключения
    {
        echo 'db connect error!    ';
        echo mysqli_connect_error();//выведет ошибку
        exit();//убиваем скрипт
    }

    $file_name = 'commands_stack';
    
/*  r – открытие файла только для чтения.
    r+ - открытие файла одновременно на чтение и запись.
    w – создание нового пустого файла. Если на момент вызова уже существует такой файл, то он уничтожается.
    w+ - аналогичен r+, только если на момент вызова фай такой существует, его содержимое удаляется.
    a – открывает существующий файл в  режиме записи, при этом указатель сдвигается на  последний байт файла (на конец файла).
    a+ - открывает файл в режиме чтения и записи при этом указатель сдвигается на последний байт файла (на конец файла). Содержимое файла не удаляется.
*/

    /*$result = mysqli_query($connection, "SELECT `nom_but` FROM `buttons_log`");//запрос

    $text_to_file = '';

    while($record = mysqli_fetch_assoc($result))//пока можно вычленять информацию, достаем. assoc вернет false (оно же пустая строка) когда доставать будет нечего
    {
        $text_to_file = $text_to_file . '_' . $record['nom_but']; // выведем имя категории (типа Спорт) 
        
    }

    $test = fwrite($fp, $text_to_file); // Запись в файл
    if ($test) echo 'data write OK';
    else echo 'data write NOT OK';*/
    
    $last_id = -1;
    $fp = fopen($file_name, 'w');//создали файл
    fclose($fp); //Закрытие файла

    while(true)//программа работает бесконечно
    {
		// $result это колличество новых записей
        $count_new_records = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(id) AS `total_count` FROM `buttons_log` WHERE id > " . $last_id))['total_count'];//запрос
		if($count_new_records)//появилось что-то новое
        {
            $query_new_records = mysqli_query($connection, "SELECT * FROM `buttons_log`WHERE id > " . $last_id);//запрос
            $text_to_file = '';
            while($result_query_new_records = mysqli_fetch_assoc($query_new_records))//пока можно вычленять информацию, достаем. assoc вернет false (оно же пустая строка) когда доставать будет нечего
            {
                $text_to_file = $text_to_file . '_' . $result_query_new_records['id'] . '_' . $result_query_new_records['nom_but'] . "\n";
                $last_id = $result_query_new_records['id'];
            }
                
            $fp = fopen($file_name, 'a');//открыли на запись в конец
            $is_writing_OK = fwrite($fp, $text_to_file); // Запись в файл
            /*$test_str = '' . $last_id;
            fwrite($fp, $test_str); */
            fclose($fp); //Закрытие файла
        }
    }


    mysqli_close($connection);// закрыли соединение
?>