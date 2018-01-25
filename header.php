<?php
    //Запускаем сессию
    session_start();
?>
 
<!DOCTYPE html>
<html>
    <head>
        <title>Smart RoboLab</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><!-- для проверки на валидность имэйла подключаем jQuery от JavaScript-->
        <script src="ajax.js"></script> <!-- ajax.js это это javascript файл с логикой ajax обработки формы -->
        <script type="text/javascript">
    $(document).ready(function(){
        "use strict";
        //================ Проверка email ==================
 
        //регулярное выражение для проверки email
        var pattern = /^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i;
        var mail = $('input[name=email]');
         
        mail.blur(function(){
            if(mail.val() != ''){
 
                // Проверяем, если введенный email соответствует регулярному выражению
                if(mail.val().search(pattern) == 0){
                    // Убираем сообщение об ошибке
                    $('#valid_email_message').text('');
 
                    //Активируем кнопку отправки
                    $('input[type=submit]').attr('Disabled', false);
                }else{
                    //Выводим сообщение об ошибке
                    $('#valid_email_message').text('Wrong email');
 
                    // Дезактивируем кнопку отправки
                    $('input[type=submit]').attr('Disabled', true);
                }
            }else{
                $('#valid_email_message').text('Enter your email');
            }
        });
 
        //================ Проверка длины пароля ==================
        var password = $('input[name=password]');
         
        password.blur(function(){
            if(password.val() != ''){
 
                //Если длина введенного пароля меньше шести символов, то выводим сообщение об ошибке
                if(password.val().length < 6){
                    //Выводим сообщение об ошибке
                    $('#valid_password_message').text('6 symbols minimum');
 
                    // Дезактивируем кнопку отправки
                    $('input[type=submit]').attr('disabled', true);
                     
                }else{
                    // Убираем сообщение об ошибке
                    $('#valid_password_message').text('');
 
                    //Активируем кнопку отправки
                    $('input[type=submit]').attr('disabled', false);
                }
            }else{
                $('#valid_password_message').text('Enter password');
            }
        });
    });
</script>
        <meta charset="utf-8">
        <link rel="icon" href="logotype.png" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <style>
            body {
                background-image: url(background_2.jpg); /* Путь к фоновому изображению */
            }
        </style>
    </head>
    <body>
 
        <div id="header" style="white-space: nowrap;">
            
                <a id="logo_on_header" href="/index.php" style="display: inline-block;"><img src="logotype.png" width="100" height="100" alt="Main" ></a>

                <h1 style="display: inline-block;">Make RoboLab smarter!</h1>
            
                <div id="auth_block" style="display: inline-block;">
                <?php
                    //Проверяем авторизован ли пользователь
                    if(!isset($_SESSION['email']) && !isset($_SESSION['password'])){
                        // если нет, то выводим блок с ссылками на страницу регистрации и авторизации
                ?>
                        <div id="link_register">
                            <a href="/form_register.php">Registration</a>
                        </div>
                    
                        <div id="link_auth">
                            <a href="/form_auth.php">Authorization</a>
                        </div>
                <?php
                    }else{
                        //Если пользователь авторизован, то выводим ссылку Выход
                ?> 
                        <div id="link_logout">
                            <a href="/logout.php">Exit</a>
                        </div>
                        
                <?php
                    //Если пользователь обладает правами администратора
                    if($_SESSION['email'] == 'danil.160398@yandex.ru'){ 
                ?>
                        <div id="link_write_url_of_translation">
                            <a style="background: #000" text-align: center; href="/write_translation_url.php">Admin</a>
                        </div>
                <?php
                    }
                ?>    

                <?php
                    }
                ?>
                </div>
            
             <div class="clear"></div>
        </div>