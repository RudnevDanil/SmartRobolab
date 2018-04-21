$( document ).ready(function() 
{
    $(".SWITCH_1").click(
		function()
		{
		    b01 = ((b01 == 'NO')?'YES':'NO');
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 1);
			return false; 
		}
	);
    $("#SWITCH_2").click(
		function()
		{
		    b02 = ((b02 == 'NO')?'YES':'NO');
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 2);
			return false; 
		}
	);
    $("#SWITCH_3").click(
		function()
		{
		    b03 = ((b03 == 'NO')?'YES':'NO');
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 3);
			return false; 
		}
	);
    $("#SWITCH_4").click(
		function()
		{
		    b04 = ((b04 == 'NO')?'YES':'NO');
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 4);
			return false; 
		}
	);
    $("#SWITCH_5").click(
		function()
		{
		    b05 = ((b05 == 'NO')?'YES':'NO');
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 5);
			return false; 
		}
	);
    $("#SWITCH_6").click(
		function()
		{
		    b06 = ((b06 == 'NO')?'YES':'NO');
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 6);
			return false; 
		}
	);
    $("#SWITCH_7").click(
		function()
		{
		    b07 = ((b07 == 'NO')?'YES':'NO');
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 7);
			return false; 
		}
	);
    $("#SWITCH_8").click(
		function()
		{
		    b08 = ((b08 == 'NO')?'YES':'NO');
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 8);
			return false; 
		}
	);
    $("#SWITCH_ALL").click(
		function()
		{
		    b01 = ((b01 == 'NO')?'YES':'NO');
		    b02 = ((b02 == 'NO')?'YES':'NO');
		    b03 = ((b03 == 'NO')?'YES':'NO');
		    b04 = ((b04 == 'NO')?'YES':'NO');
		    b05 = ((b05 == 'NO')?'YES':'NO');
		    b06 = ((b06 == 'NO')?'YES':'NO');
		    b07 = ((b07 == 'NO')?'YES':'NO');
		    b08 = ((b08 == 'NO')?'YES':'NO');
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 9);
			return false; 
		}
	);
    $("#SWITCH_ALL_OFF").click(
		function()
		{
		    b01 = 'NO';b02 = 'NO';b03 = 'NO';b04 = 'NO';
		    b05 = 'NO';b06 = 'NO';b07 = 'NO';b08 = 'NO';
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 10);
			return false; 
		}
	);
    $("#SWITCH_ALL_ON").click(
		function()
		{
		    b01 = 'YES';b02 = 'YES';b03 = 'YES';b04 = 'YES';
		    b05 = 'YES';b06 = 'YES';b07 = 'YES';b08 = 'YES';
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 11);
			return false; 
		}
	);
    /*$("#REBOOT_RELAY").click(
		function()
		{
			sendAjaxForm('send_button', 'send_button.php', 12);
			return false; 
		}
	);*/
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
	$("#CLEAR_COMMANDS_LIST").click(
		function()
		{
			sendAjaxForm('send_button', 'send_button.php', 17);
			return false; 
		}
	);
	$("#REL_2_SWITCH_1").click(
		function()
		{
		    b18 = ((b18 == 'NO')?'YES':'NO');
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 18);
			return false; 
		}
	);
	$("#REL_2_SWITCH_2").click(
		function()
		{
		    b19 = ((b19 == 'NO')?'YES':'NO');
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 19);
			return false; 
		}
	);
	$("#REL_2_SWITCH_3").click(
		function()
		{
		    b20 = ((b20 == 'NO')?'YES':'NO');
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 20);
			return false; 
		}
	);
	$("#REL_2_SWITCH_4").click(
		function()
		{
		    b21 = ((b21 == 'NO')?'YES':'NO');
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 21);
			return false; 
		}
	);
	$("#REL_2_SWITCH_5").click(
		function()
		{
		    b22 = ((b22 == 'NO')?'YES':'NO');
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 22);
			return false; 
		}
	);
	$("#REL_2_SWITCH_6").click(
		function()
		{
		    b23 = ((b23 == 'NO')?'YES':'NO');
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 23);
			return false; 
		}
	);
	$("#REL_2_SWITCH_7").click(
		function()
		{
		    b24 = ((b24 == 'NO')?'YES':'NO');
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 24);
			return false; 
		}
	);
	$("#REL_2_SWITCH_8").click(
		function()
		{
		    b25 = ((b25 == 'NO')?'YES':'NO');
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 25);
			return false; 
		}
	);
	$("#REL_2_SWITCH_f").click(
		function()
		{
		    b18 = 'NO';b19 = 'NO';b20 = 'NO';b21 = 'NO';
		    b22 = 'NO';b23 = 'NO';b24 = 'NO';b25 = 'NO';
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 26);
			return false; 
		}
	);
	$("#REL_2_SWITCH_n").click(
		function()
		{
		    b18 = 'YES';b19 = 'YES';b20 = 'YES';b21 = 'YES';
		    b22 = 'YES';b23 = 'YES';b24 = 'YES';b25 = 'YES';
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 27);
			return false; 
		}
	);
	$("#REL_2_SWITCH_s").click(
		function()
		{
		    b18 = ((b18 == 'NO')?'YES':'NO');
		    b19 = ((b19 == 'NO')?'YES':'NO');
		    b20 = ((b20 == 'NO')?'YES':'NO');
		    b21 = ((b21 == 'NO')?'YES':'NO');
		    b22 = ((b22 == 'NO')?'YES':'NO');
		    b23 = ((b23 == 'NO')?'YES':'NO');
		    b24 = ((b24 == 'NO')?'YES':'NO');
		    b25 = ((b25 == 'NO')?'YES':'NO');
		    update_buttons();
			sendAjaxForm('send_button', 'send_button.php', 28);
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