<div id="buttons" style="text-align: center;">
    <form method="post" id="send_button" action="" >
    <!--<table>
        
        <tr>
            <td colspan="3"><input type="button" id="MOVE" value="MOVE" /></td>
        </tr>
        <tr>
            <td>
                <input type="button" id="LEFT" value="LEFT" />
            </td>
            <td>
                <input type="button" id="STOP" value="STOP" />
            </td>
            <td>
                <input type="button" id="RIGHT" value="RIGHT" />
            </td>
        </tr>
        <tr>
            <td colspan="3"><input type="button" id="DOUN" value="DOUN" /></td>
        </tr>
        
    </table>-->  
        <?php 
        //if($_SESSION['email'] == 'danil.160398@yandex.ru') //для конкретно меня
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
        <input type="button" id="WHEN_CONNECT" value="WHEN_CONNECT" />
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
    