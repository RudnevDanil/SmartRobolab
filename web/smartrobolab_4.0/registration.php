<div class="other_pages">
<link href="css/style.css" rel="stylesheet" type="text/css"/>
<?php
    require_once("head.php");
    ?><div class="border"><?php
    session_start();
    if(isset($_POST["do_registration"]))
    {
        $errors = array();
        $login = trim($_POST["login"]);
        $email = trim($_POST["email"]);
        $password = $_POST["password"];
        $password_2 = $_POST["password_2"];
        
        if(($login == '')||($email == '')||($password == '')||($password_2 == ''))
        {
            $errors[] = 'Fill all lines!';
        }
        else if (strlen($password) < 6)
        {
            $errors[] = 'Password must have more than 6 symbols!';
			unset($password,$password_2);
        }
        else if ($password != $password_2)
        {
            $errors[] = 'Password must be the same!';
            unset($password,$password_2);
        }        
        else 
        {
        	unset($_POST["login"],$_POST["email"],$_POST["password"],$_POST["password_2"]);
            include("dbconnect.php");
			$no_sql_injection_login = mysqli_real_escape_string($connection, $login);
			$no_sql_injection_email = mysqli_real_escape_string($connection, $email);
			$no_sql_injection_password = mysqli_real_escape_string($connection, $password);
            $users_with_that_data = mysqli_query($connection,"SELECT COUNT(id) AS `total_count` FROM `users_list` WHERE `login` = '$no_sql_injection_login' OR `email` = '$no_sql_injection_email'");
            $users_with_that_data_result = mysqli_fetch_assoc($users_with_that_data);
            if($users_with_that_data_result['total_count'] == 0)
            {
                $no_sql_injection_password = md5($no_sql_injection_password);
                $result_of_insert = mysqli_query($connection,"INSERT INTO `users_list` (`login` , `email` , `password`) VALUES ('$no_sql_injection_login','$no_sql_injection_email','$no_sql_injection_password')");
                if($result_of_insert)
                {
                    echo '<div style="color: green;">You are successfully registrated!</div>';
                    $_SESSION['logged_user_login'] = $login;
                    unset($_POST["do_registration"]);
                    mysqli_query($connection,"INSERT INTO `list_of_url` (`user_login` , `url_1` , `url_2`) VALUES ('$login','nothing','nothing')");
                    $file = fopen("commands/".$login."_commands.txt", "w");
                    fclose($file);
                }
                else
                {
                    $errors[] = 'Registration error!';
                }
            }
            else
            {
                $errors[] = 'User with this data already exists!';
            }
            mysqli_close($connection);
        }
        if(!empty($errors))
        {
            echo '<div style="color: red;">'.array_shift($errors).'</div>';
        }
        unset($errors);
    } 

	if(!isset($_SESSION['logged_user_login']))
	{ ?>
	<form action="/registration.php" method="POST">
		<p>
			<input type="text" name="login" placeholder="Login" value="<?php echo @$login; ?>">
		
			<input type="email" name="email" placeholder="Email" value="<?php echo @$email; ?>">
		</p>

		<p>
			<input type="password" name="password" placeholder="Password" value="<?php echo @$password; ?>">
		
			<input type="password" name="password_2" placeholder="Confirm password"value="<?php echo @$password_2; ?>">
		</p>

		<p>
			<button class="control_block form_button" type="submit" name="do_registration">Register right now!</button>
		</p>
    </form>
	<?php } 
	?></div><?php
	require_once("foot.php");
?>
</div>