$( document ).ready(function() 
{
    $("#SWITCH_1").click(
		function()
		{
			sendAjaxForm('send_button', 'send_button.php', 1);
			return false; 
		}
	);
    $("#SWITCH_2").click(
		function()
		{
			sendAjaxForm('send_button', 'send_button.php', 2);
			return false; 
		}
	);
    $("#SWITCH_3").click(
		function()
		{
			sendAjaxForm('send_button', 'send_button.php', 3);
			return false; 
		}
	);
    $("#SWITCH_4").click(
		function()
		{
			sendAjaxForm('send_button', 'send_button.php', 4);
			return false; 
		}
	);
    $("#SWITCH_5").click(
		function()
		{
			sendAjaxForm('send_button', 'send_button.php', 5);
			return false; 
		}
	);
    $("#SWITCH_6").click(
		function()
		{
			sendAjaxForm('send_button', 'send_button.php', 6);
			return false; 
		}
	);
    $("#SWITCH_7").click(
		function()
		{
			sendAjaxForm('send_button', 'send_button.php', 7);
			return false; 
		}
	);
    $("#SWITCH_8").click(
		function()
		{
			sendAjaxForm('send_button', 'send_button.php', 8);
			return false; 
		}
	);
    $("#SWITCH_ALL").click(
		function()
		{
			sendAjaxForm('send_button', 'send_button.php', 9);
			return false; 
		}
	);
    $("#SWITCH_ALL_OFF").click(
		function()
		{
			sendAjaxForm('send_button', 'send_button.php', 10);
			return false; 
		}
	);
    $("#SWITCH_ALL_ON").click(
		function()
		{
			sendAjaxForm('send_button', 'send_button.php', 11);
			return false; 
		}
	);
    $("#REBOOT_RELE").click(
		function()
		{
			sendAjaxForm('send_button', 'send_button.php', 12);
			return false; 
		}
	);
    $("#MOVE_LEFT_5").click(
		function()
		{
			sendAjaxForm('send_button', 'send_button.php', 13);
			return false; 
		}
	);
    $("#MOVE_RIGHT_5").click(
		function()
		{
			sendAjaxForm('send_button', 'send_button.php', 14);
			return false; 
		}
	);
    $("#MOVE_LEFT_20").click(
		function()
		{
			sendAjaxForm('send_button', 'send_button.php', 15);
			return false; 
		}
	);
    $("#MOVE_RIGHT_20").click(
		function()
		{
			sendAjaxForm('send_button', 'send_button.php', 16);
			return false; 
		}
	);
});
 
function sendAjaxForm( send_button, url, nom) 
{
    var byf = 'nom_last_but='+nom.toString();
    jQuery.ajax({
        url:     url, //url страницы (action_ajax_form.php)
        type:     "POST", //метод отправки
        data: byf,
        success: function(response) { /*Данные отправлены успешно*/ },
    	error: function(response) { /* Данные не отправлены*/ 	}
 	});
}
/*В файле ajax.js есть два метода: $("#btn").click и sendAjaxForm. 
Первый метод - это слушатель событий кнопки. 
То есть, когда мы нажимаем на кнопку Отправить, слушатель срабатывает и 
вызывает второй метод sendAjaxForm. 

В метод sendAjaxForm(result_form, ajax_form, url) передаются 
поля: result_form - это div в который будут рендерится данные, 
ajax_form - это id формы отправки сообщения 
и url - это местоположение файла action_ajax_form.php который 
отвечает за серверную часть (обработка формы).

index.php - это главная страница с формой
ajax_form - форма
ajax.js - это javascript файл с логикой ajax обработки формы
action_ajax_form.php - это серверная часть нашего проекта, обрабатывает данные полученные из формы и возвращает результат в формате JSON

 */