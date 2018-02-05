<div id="buttons" style="text-align: center;">
    <form method="post" id="send_button" action="" > 
        <?php 
        if(!(!isset($_SESSION['email']) && !isset($_SESSION['password'])))//для авторизованных
        { ?>
        <input type="button" id="SWITCH_1" value="SWITCH_1" />
        <input type="button" id="SWITCH_2" value="SWITCH_2" />
        <input type="button" id="SWITCH_3" value="SWITCH_3" />
        <input type="button" id="SWITCH_4" value="SWITCH_4" />
        <input type="button" id="SWITCH_5" value="SWITCH_5" />
        <input type="button" id="SWITCH_6" value="SWITCH_6" />
        <input type="button" id="SWITCH_7" value="SWITCH_7" />
        <input type="button" id="SWITCH_8" value="SWITCH_8" />
        <input type="button" id="SWITCH_ALL" value="SWITCH_ALL" />
        <input type="button" id="SWITCH_ALL_OFF" value="SWITCH_ALL_OFF" />
        <input type="button" id="SWITCH_ALL_ON" value="SWITCH_ALL_ON" />
        <input type="button" id="REBOOT_RELE" value="REBOOT_RELE" />
        <input type="button" id="MOVE_LEFT_5" value="MOVE_LEFT_5" />
        <input type="button" id="MOVE_RIGHT_5" value="MOVE_RIGHT_5" />
        <input type="button" id="MOVE_LEFT_20" value="MOVE_LEFT_20" />
        <input type="button" id="MOVE_RIGHT_20" value="MOVE_RIGHT_20" />
        <?php 
        }
        else
        { ?>
        
            <h1 style="width = 200%">Please, authorize to see the buttons. Unauthorized users can just watch.</h1>
        
        
        <?php
        }
        ?>
     </form>
    <!-- Для добавления новых кнопок :
            1) добавить кнопку с уникальным id в форму
            2) в файле ajax.js внести изменения
                2.1) #тут id кнопки
                2.2) третий аргумент функции - то что запишется в базу как номер команды
    -->
</div>
    