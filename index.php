<?php

    //ЗАПУСК EXE !!!!!!
//exec('start C:\\Windows\\notepad.exe ');

    //Подключение шапки
    require_once("header.php");

    //подключение к БД
    $mysqli = new mysqli("localhost", "root", "", "h96046yr__base");

    // Проверка соединения 
    if (mysqli_connect_errno()) 
    {
        echo '<h1>"Connect failed</h1>';
        exit();
    }
    
    //составление запроса на поле url при максимальном id
    $query = "SELECT url FROM `list_of_url` WHERE id=(SELECT MAX(id) FROM  `list_of_url`)";
    $query_2 = "SELECT url FROM `list_of_url` WHERE id=(SELECT MAX(id)-1 FROM  `list_of_url`)";
    
    if ($stmt = $mysqli->prepare($query)) 
    {

        // выполнение запроса 
        $stmt->execute();

        // привязка переменных к запросу.  bind_result($id,$url) пернет всю строчку к примеру
        $stmt->bind_result($url);

        // выборка значений
        while ($stmt->fetch()) {
            //echo '<h1>'.$url.'</h1>';
            $_SESSION['url']=$url;
        }
        // закрыли соединение
        $stmt->close();
    }
    if ($stmt_2 = $mysqli->prepare($query_2)) 
    {

        // выполнение запроса 
        $stmt_2->execute();

        // привязка переменных к запросу.  bind_result($id,$url) пернет всю строчку к примеру
        $stmt_2->bind_result($url_2);

        // выборка значений
        while ($stmt_2->fetch()) {
            //echo '<h1>'.$url.'</h1>';
            $_SESSION['url_2']=$url_2;
        }
        // закрыли соединение
        $stmt_2->close();
    }
    // закрыли БД
    $mysqli->close();
?>
 
<div id="content">
    <!-- <h2>Main page content</h2>-->
    <?php    
    if (isset($_SESSION['url_2']) && isset($_SESSION['url']) && $_SESSION['url']!='8IQbF0IK-f4')
    {
        $new_url = $_SESSION['url'];//новая ссылка
        $new_url_2 = $_SESSION['url_2'];//новая ссылка
        //echo $new_url; //нужно было чтобы смотреть что там в $_SESSION['url']
        ?>
        <table style="margin:auto;width=100%">
            <tr>
                <td colspan="1">
                    <div id="video_1" style="text-align: center;">
                        <?php echo'<iframe width="100%" height="480" src="https://www.youtube.com/embed/'.$new_url.'" frameborder="0" allowfullscreen></iframe>' ?>
                    </div>
                </td>
                <td colspan="1">            
                    <div id="video_2" style="text-align: center;">
                          <?php echo'<iframe width="100%" height="480" src="https://www.youtube.com/embed/'.$new_url_2.'" frameborder="0" allowfullscreen></iframe>' //width="854" height="480"?>
                    </div>
                </td>
            </tr>
                <?php
                //Подключение кнопок
                //Если пользователь обладает правами администратора
                
                ?>
                    <tr><td colspan="2"><?php require_once("buttons.php") ;?></td></tr>
                <?php
                ?>
            </table>
        <?php
    }
    else //на случай косяков с БД и прочих ошибок
    {
        ?>
        <h2>Admin don't upload new reference, so you can watch this funny video</h2>
        <div id="video" style="text-align: center;"><iframe width="854" height="480" src="https://www.youtube.com/embed/8IQbF0IK-f4?list=LLQskfkuDIDKnAr90SdCEuMw" frameborder="0" allowfullscreen></iframe>
        <?php
        //https://www.youtube.com/embed/8IQbF0IK-f4 //видос для образца dude perfect
        //https://youtu.be/1ugivNRYfjc в питере пить
    }
    ?>
</div>
 
<?php


    //Подключение подвала
    require_once("footer.php");

//https://www.youtube.com/embed/vUsWZ9aA3mI //это ссылка на само видео
//https://youtu.be/vUsWZ9aA3mI              //это если скопировать URL
//
//https://www.youtube.com/embed/K59KKnIbIaM //тоже самое но от прямой трансляции
//https://youtu.be/K59KKnIbIaM              //видим что по сути разницы нет - видео или трансляция
?>