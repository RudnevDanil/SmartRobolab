<div class="other_pages">
<link href="css/style.css" rel="stylesheet" type="text/css"/>
<?php
    require_once("head.php");
    ?><div class="border"><?php
    $url_1 = "sl_pxCAcJz4";
    $url_2 = "1ugivNRYfjc";
    if(isset($_POST["do_open_translation"]))
    {
        unset($_SESSION['translation_opened']);
        $errors = array();
        $login = trim($_POST["login"]);
        if($login == '')
        {
            $errors[] = 'Fill the line!';
        }
        else
        {
			unset($_POST["login"]);
            include("dbconnect.php");
			$no_sql_injection_login = mysqli_real_escape_string($connection, $login);
			$count_of_matches = mysqli_query($connection, "SELECT COUNT(id) AS `total_count` FROM `list_of_url` WHERE `user_login` = '$no_sql_injection_login'");
            $count_of_matches_result = mysqli_fetch_assoc($count_of_matches);
            if($count_of_matches_result['total_count'] == 1)
            {
                //we find, lets check when it was last added
                $line = mysqli_query($connection, "SELECT * FROM `list_of_url` WHERE `user_login` = '$no_sql_injection_login'");
                $line_result = mysqli_fetch_assoc($line);
                $now = time();
                $last_add_date = strtotime($line_result['last_add_date']);
                if(($now - $last_add_date) > 28800) // 8 hours is a 28800 seconds
                {
                    $errors[] = 'This user was online more than 8 hours ago!';
                }
                else
                {
                    if($line_result['url_1'] != 'nothing')
                        $url_1 = $line_result['url_1'];
                    else
                        $url_1 = "sl_pxCAcJz4";
                    if($line_result['url_2'] != 'nothing')
                        $url_2 = $line_result['url_2'];
                    else
                        $url_2 = "1ugivNRYfjc";
                    //when will be success
                    $_SESSION['translation_opened'] = $login;
                    unset($_POST["do_open_translation"]);
                }
            }
            else
            {
                $errors[] = 'This user does not exist!';
            }
			mysqli_close($connection);       
        }
        if(!empty($errors))
        {
            echo '<div style="color: red;">'.array_shift($errors).'</div>';
        }       
        unset($errors);
    }?>
    <div id="videos">
        <div id="video_1">
            <iframe src="https://www.youtube.com/embed/<?php echo $url_1; ?>" frameborder="0" allowfullscreen></iframe>
        </div>
        <div id="video_2">
            <iframe src="https://www.youtube.com/embed/<?php echo $url_2; ?>" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
    <form action="/open_translation.php" method="POST">
        <p>
            <input type="text" name="login" placeholder="Login" value="<?php echo @$login; ?>">
            <button class="control_block form_button" type="submit" name="do_open_translation">Open</button>
        </p>
    </form>
    </div>
    <?php
    require_once("foot.php");
?>
</div>
