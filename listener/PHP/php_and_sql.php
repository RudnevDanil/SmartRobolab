<?php
    $serever_adres = '127.0.0.1';
    $dbuser = 'root';
    $dbpassword = '';
    $dbname = 'test_db';
    $connection = mysqli_connect($serever_adres,$dbuser,$dbpassword,$dbname);//сервер, имя пользователя, пароль, название БД
    // сервер если на локальном сайте , то 127.0.0.1 он же localhost
    if($connection == false) //ошибка подключения
    {
        echo 'db connect error!    ';
        echo mysqli_connect_error();//выведет ошибку
        exit();//убиваем скрипт   die() это тоже самое
    }
    //можно просто include('includes/db_connect.php');

    $result = mysqli_query($connection, "SELECT * FROM `articles_categories`");//запрос

    echo 'Колличество записей : ' . mysqli_num_rows($result);

    while($record = mysqli_fetch_assoc($result))//пока можно вычленять информацию, достаем. assoc вернет false (оно же пустая строка) когда доставать будет нечего
    {
        // print_r($record);//распечатываем полученные строки тут будет каждая строка иметь вид  [id]=>3 [title]=Спорт
        echo $record['title']; // выведем имя категории (типа Спорт) 
        //$articles_with_that_categorie = mysqli_query(&connection, "SELECT * FROM 'aricles' WHERE 'categorie_id' = " . record['id']);//проблема с производительностью : получаем ВСЕ записи, а потом просто считаем, лучше использовать COUNT(id)
        //$articles_with_that_categorie = mysqli_query(&connection, "SELECT COUNT(id) FROM 'aricles' WHERE 'categorie_id' = " . record['id']);//ячейка будет называться COUNT(id), чтобы она называлась например total_count нужно использовать AS
        $articles_with_that_categorie = mysqli_query(&connection, "SELECT COUNT(id) AS `total_count` FROM 'aricles' WHERE 'categorie_id' = " . record['id']);
        $articles_with_that_categorie_result = mysqli_fetch_assoc($articles_with_that_categorie);//теперь это массив из одного элемента ['total_count'] => колличество
        
        echo '(' . $articles_with_that_categorie_result['total_count'] . ')' ."\n";//вывели колличество статей в этой категории
    }

    mysqli_close($connection);// закрыли соединение

?>