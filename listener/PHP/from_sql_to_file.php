<?php //phpinfo(INFO_MODULES);
	/*		C:/OSPanel/modules/php/PHP-7.1-x64/php.exe from_sql_to_file.php		*/
	echo Hi;
	//подключение к БД
    $mysqli = new mysqli("localhost", "root", "", "h96046yr__base");

    // Проверка соединения 
    if (mysqli_connect_errno()) 
    {
        echo "Connect failed";
        exit();
    }
    
    //составление запроса на поле url при максимальном id
    $query = "SELECT url FROM `list_of_url` WHERE id=(SELECT MAX(id) FROM  `list_of_url`)";
    
    if ($stmt = $mysqli->prepare($query)) 
    {

        // выполнение запроса 
        $stmt->execute();

        // привязка переменных к запросу.  bind_result($id,$url) пернет всю строчку к примеру
        $stmt->bind_result($url);

        // выборка значений
        while ($stmt->fetch()) {
            echo '<h1>'.$url.'</h1>';
            //$_SESSION['url']=$url;
        }
        // закрыли соединение
        $stmt->close();
    }
    
    // закрыли БД
    $mysqli->close();

?>