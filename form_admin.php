<?php
    //Подключение шапки
    require_once("header.php");
?>
<!-- Блок для вывода сообщений -->
<div class="block_for_messages">
    <?php
        //Если в сессии существуют сообщения об ошибках, то выводим их
        if(isset($_SESSION["error_messages"]) && !empty($_SESSION["error_messages"])){
            echo $_SESSION["error_messages"];
 
            //Уничтожаем чтобы не выводились заново при обновлении страницы
            unset($_SESSION["error_messages"]);
        }
 
        //Если в сессии существуют радостные сообщения, то выводим их
        if(isset($_SESSION["success_messages"]) && !empty($_SESSION["success_messages"])){
            echo $_SESSION["success_messages"];
             
            //Уничтожаем чтобы не выводились заново при обновлении страницы
            unset($_SESSION["success_messages"]);
        }
    ?>
</div>
 
<?php
    //Проверяем, если пользователь не авторизован, то выводим форму регистрации, 
    //иначе выводим сообщение о том, что он уже зарегистрирован
    if (!isset($_POST["btn_submit_new_url"])){ 
?>
        <div id="form_admin">
            <h2>Admin form</h2>
 
            <form action="write_translation_url.php" method="post" name="form_admin">
                <table>
                    <tbody><tr>
                        <td> New URL </td>
                        <td>
                            <input type="text" name="url" required="required">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="btn_submit_new_url" value="Apply this URL">
                        </td>
                    </tr>
                </tbody></table>
            </form>
        </div>

<?php        
    }else{
?>
        <div id="updated_successfully" style="text-align: center;">
            <h2>Updated successfully!</h2>
        </div>
<?php
    }
    //Подключение подвала
    require_once("footer.php");
?>