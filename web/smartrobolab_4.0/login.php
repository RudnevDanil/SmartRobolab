<?php session_start();?>
<div class="other_pages">
<link href="css/style.css" rel="stylesheet" type="text/css"/>
    <?php
    require_once("head.php");
    ?><div class="border"><?php
    if(isset($_POST["do_login"]))
    {
        $errors = array();
        $login = trim($_POST["login"]);
        $password = trim($_POST["password"]);
        if(($login == '')||($password == ''))
        {
            $errors[] = 'Fill all lines!';
        }
        else if (strlen($password) < 6)
        {
            $errors[] = 'Password must have more than 6 symbols!';
        }
        else
        {
			unset($_POST["login"],$_POST["password"]);
            include("dbconnect.php");
			$no_sql_injection_login = mysqli_real_escape_string($connection, $login);
			$no_sql_injection_password = mysqli_real_escape_string($connection, $password);
            $no_sql_injection_password = md5($no_sql_injection_password);
            $count_of_matches = mysqli_query($connection, "SELECT COUNT(id) AS `total_count` FROM `users_list` WHERE `login` = '$no_sql_injection_login' AND `password` = '$no_sql_injection_password'");
            $count_of_matches_result = mysqli_fetch_assoc($count_of_matches);
            if($count_of_matches_result['total_count'] == 1)
            {
                $_SESSION['logged_user_login'] = $login;
                unset($_POST["do_login"]);
				echo '<div style="color: green;">You are successfully authorized!</div>';
				$file_name = "commands/".$login.'_commands.txt';
                $file = fopen($file_name, 'w');
                fclose($file);
                include("dbconnect.php");
                $now = date('Y-m-d H:i:s', time() - 28800);
                mysqli_query($connection, "UPDATE `list_of_url` SET `last_add_date` = '$now' WHERE `user_login`='$login'");
                mysqli_close($connection); 
            }
            else
            {
                $errors[] = 'Wrong login or password!';
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
        <form action="/login.php" method="POST">
            <p>
                <input type="text" name="login" placeholder="Login" value="<?php echo @$login; ?>">
            
                <input type="password" name="password" placeholder="Password" value="<?php echo @$password; ?>">
            </p>
            <p>
                <button class="control_block form_button" type="submit" name="do_login">Sign in</button>
            </p>
        </form>
    <?php }
    ?></div><?php
    require_once("foot.php");
?>
</div>