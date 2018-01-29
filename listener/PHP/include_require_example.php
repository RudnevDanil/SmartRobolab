<?php
    include('includes/db_connect.php');
    include_once('includes/db_connect.php');
    require 'includes/db_connect.php';
    require_once 'includes/db_connect.php';
    /*
        once означает, что если уже было подключено, то повторно не будет
        include в случае ошибки выдаст false и продолжит работу
        reauire в случае ошибке выдаст fatal error
    */
?>