<?php
        //Запускаем сессию
        session_start();
 
        //Добавляем файл подключения к БД
        require_once("dbconnect.php");

        //Объявляем ячейку для добавления ошибок, которые могут возникнуть при обработке формы.
        $_SESSION["error_messages"] = '';

        //Объявляем ячейку для добавления успешных сообщений
        $_SESSION["success_messages"] = '';

        /*
            Проверяем была ли отправлена форма, то есть была ли нажата кнопка Войти. Если да, то идём дальше, если нет, то выведем пользователю сообщение об ошибке, о том что он зашёл на эту страницу напрямую.
        */
        if(isset($_POST["btn_submit_auth"]) && !empty($_POST["btn_submit_auth"])){

            //      ------------------------------------------------------------------ОБРАБОТКА КАПЧИ
            //Проверяем полученную капчу
        if(isset($_POST["captcha"])){

            //Обрезаем пробелы с начала и с конца строки
            $captcha = trim($_POST["captcha"]);

            if(!empty($captcha)){

                //Сравниваем полученное значение с значением из сессии. 
                if(($_SESSION["rand"] != $captcha) && ($_SESSION["rand"] != "")){

                    // Если капча не верна, то возвращаем пользователя на страницу авторизации, и там выведем ему сообщение об ошибке что он ввёл неправильную капчу.

                    $error_message = "<p class='mesage_error'><strong>Error!</strong> You entered an invalid captcha </p>";

                    // Сохраняем в сессию сообщение об ошибке. 
                    $_SESSION["error_messages"] = $error_message;

                    //Возвращаем пользователя на страницу авторизации
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: ".$address_site."/form_auth.php");

                    //Останавливаем скрипт
                    exit();
                }

            }else{

                $error_message = "<p class='mesage_error'><strong>Error!</strong> The box for captcha input must not be empty. </p>";

                // Сохраняем в сессию сообщение об ошибке. 
                $_SESSION["error_messages"] = $error_message;

                //Возвращаем пользователя на страницу авторизации
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."/form_auth.php");

                //Останавливаем скрипт
                exit();

            }

            //      ------------------------------------------------------------------ОБРАБОТКА ПОЧТОВОГО АДРЕСА 

            //Обрезаем пробелы с начала и с конца строки
        $email = trim($_POST["email"]);
        if(isset($_POST["email"])){

            if(!empty($email)){
                $email = htmlspecialchars($email, ENT_QUOTES);

                //Проверяем формат полученного почтового адреса с помощью регулярного выражения
                $reg_email = "/^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i";

                //Если формат полученного почтового адреса не соответствует регулярному выражению
                if( !preg_match($reg_email, $email)){
                    // Сохраняем в сессию сообщение об ошибке. 
                    $_SESSION["error_messages"] .= "<p class='mesage_error' >You entered an incorrect email</p>";

                    //Возвращаем пользователя на страницу авторизации
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: ".$address_site."/form_auth.php");

                    //Останавливаем скрипт
                    exit();
                }
            }else{
                // Сохраняем в сессию сообщение об ошибке. 
                $_SESSION["error_messages"] .= "<p class='mesage_error' >The box for entering the email address (email) can not be empty.</p>";

                //Возвращаем пользователя на страницу регистрации
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."/form_register.php");

                //Останавливаем скрипт
                exit();
            }


        }else{
            // Сохраняем в сессию сообщение об ошибке. 
            $_SESSION["error_messages"] .= "<p class='mesage_error' > Missing input box Email</p>";

            //Возвращаем пользователя на страницу авторизации
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$address_site."/form_auth.php");

            //Останавливаем скрипт
            exit();
        }

            //      ------------------------------------------------------------------ОБРАБОТКА ПАРОЛЯ

        if(isset($_POST["password"])){

            //Обрезаем пробелы с начала и с конца строки
            $password = trim($_POST["password"]);

            if(!empty($password)){
                $password = htmlspecialchars($password, ENT_QUOTES);

                //Шифруем пароль
                $password = md5($password."top_secret");
            }else{
                // Сохраняем в сессию сообщение об ошибке. 
                $_SESSION["error_messages"] .= "<p class='mesage_error' >Enter your password</p>";

                //Возвращаем пользователя на страницу регистрации
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."/form_auth.php");

                //Останавливаем скрипт
                exit();
            }

        }else{
            // Сохраняем в сессию сообщение об ошибке. 
            $_SESSION["error_messages"] .= "<p class='mesage_error' >Missing password entry box</p>";

            //Возвращаем пользователя на страницу регистрации
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$address_site."/form_auth.php");

            //Останавливаем скрипт
            exit();
        }


            //      ------------------------------------------------------------------ОБРАБОТКА СОСТАВЛЕНИЯ ЗАПРОСА К БД
        //Запрос в БД на выборке пользователя.
        $result_query_select = $mysqli->query("SELECT * FROM `users_list` WHERE email = '".$email."' AND password = '".$password."'");

        if(!$result_query_select){
            // Сохраняем в сессию сообщение об ошибке. 
            $_SESSION["error_messages"] .= "<p class='mesage_error' >A query failed to query the user from the database</p>";

            //Возвращаем пользователя на страницу регистрации
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$address_site."/form_auth.php");

            //Останавливаем скрипт
            exit();
        }else{

            //Проверяем, если в базе нет пользователя с такими данными, то выводим сообщение об ошибке
            if($result_query_select->num_rows == 1){

                // Если введенные данные совпадают с данными из базы, то сохраняем логин и пароль в массив сессий.
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;

                //Возвращаем пользователя на главную страницу
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."/index.php");

            }else{

                // Сохраняем в сессию сообщение об ошибке. 
                $_SESSION["error_messages"] .= "<p class='mesage_error' >Incorrect login / password</p>";

                //Возвращаем пользователя на страницу авторизации
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."/form_auth.php");

                //Останавливаем скрипт
                exit();
            }
        }


        }else{
            //Если капча не передана
            exit("<p><strong>Ошибка!</strong> There is no verification code, that is, a CAPTCHA code. You can go to  <a href=".$address_site."> main page</a>.</p>");
        }

        }else{
            exit("<p><strong>Ошибка!</strong>You have come directly to this page, so there is no data to process. You can go to <a href=".$address_site."> main page </a>.</p>");
        }