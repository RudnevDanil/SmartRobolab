<?php
    $string = 'abcdefghklmnopqrst';
        
    $short_string = substr($string,0,7);//обрезали строку
    /* mb_substr 
        0 это сдвиг
        7 длинна
    */

    echo $short_string;
?>