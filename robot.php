<h1>Hello!</h1>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    while(true) //нас ничто не остановит, всегда слушать
    {
        var req = new XMLHttpRequest();
        req.open("GET", "buttons_log_ask.php", false);
        req.send(null);
        if(req.status == 200) //если удачно
          alert(req.responseText);// ТУТ ДОЛЖЕН БЫТЬ ЗАПУСК SH СЦЕНАРИЯ ДЛЯ РАСБПЕРИ ПИ
    }
</script>