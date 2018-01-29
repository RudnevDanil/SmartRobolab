<form method = "POST" action = "/handle.php">
    <input type="text" placeholder="Ваш логин" name="login">
    <input type="text" placeholder="Ваш пароль" name="password">
    <hr><!-- просто отчерк -->
    <input type="submit" value="Отправить">
</form>
<!-- 
    POST можно заменить на GET если небольшой объем передается
    управление перейдет в файл /handle.php, там будут переменные $_POST[login]  и  $_POST[password]
-->