<?php session_start();
    if(isset($_POST["nom_last_but"])) 
    {
        $nom_but = $_POST["nom_last_but"];
        $login = $_SESSION['logged_user_login'];
        $file_name = "commands/".$login.'_commands.txt';
        if($nom_but == 17)
        {
            $fp = fopen($file_name, 'w');// open for rewrite
        }
        else
        {
            $text_to_file = (strlen($nom_but) < 2) ? '0' : '';
            $text_to_file = $text_to_file . $nom_but . ' ';
            $fp = fopen($file_name, 'a');// open for append
            $is_writing_OK = fwrite($fp, $text_to_file);
        }
        fclose($fp);
    }
    include("dbconnect.php");
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$address_site."/index.php");  
    mysqli_close($connection);  
    exit();
?>



