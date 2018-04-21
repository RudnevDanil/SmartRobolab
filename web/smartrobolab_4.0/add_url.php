<?php session_start();?>
<div class="other_pages">
<link href="css/style.css" rel="stylesheet" type="text/css"/>
    <?php
    require_once("head.php");
    if(isset($_SESSION['logged_user_login']))
    {
        if(isset($_POST["do_add_url"]))
        {
            $url = trim($_POST["url"]);
            $user = $_SESSION['logged_user_login'];
            if(($url == ''))
            {
                unset($_POST["url"]);
                include("dbconnect.php");
                if(mysqli_query($connection,"UPDATE `list_of_url` SET `url_1` = 'nothing', `url_2` = 'nothing' WHERE user_login = '$user'"))
                {
                    unset($_POST["do_add_url"]);
                    echo '<div style="color: green;">You are successfully clear URL history!</div>';
                }
                else
                {
                    echo '<div style="color: red;">Delete URL history exception!</div>';
                }            
                mysqli_close($connection);   
            }
            else
            {
                unset($_POST["url"]);
                include("dbconnect.php");
                $now = date('Y-m-d H:i:s', time());
                mysqli_query($connection,"UPDATE `list_of_url` SET `url_2` = `url_1`, `last_add_date` = '$now' WHERE `user_login` = '$user'");
                $no_sql_injection_url = mysqli_real_escape_string($connection, $url);
                $new_url = substr($no_sql_injection_url, -11);
                if(mysqli_query($connection,"UPDATE `list_of_url` SET `url_1` = '$new_url' WHERE user_login = '$user'"))
                {
                    unset($_POST["do_add_url"]);
                    echo '<div style="color: green;">You are successfully add new URL!</div>';
                }
                else
                {
                    echo '<div style="color: red;">Add URL problem!</div>';
                }            
                mysqli_close($connection);       
            }
        }
        { ?>
            <form action="/add_url.php" method="POST">
                <p>
                    <p><strong>Entet new YouTube URL or leave blank to clear history:</strong></p>
                    <input type="text" name="url" placeholder="New URL">
                </p>
                <p><button class="control_block form_button" type="submit" name="do_add_url">Add New URL</button></p>
            </form>
        <?php 
        }
    }
    else
    {
        echo "<div>You aren't authorized!</div>";
    }
    require_once("foot.php");
?>
</div>