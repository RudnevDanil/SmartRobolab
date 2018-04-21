<?php session_start();?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="js/update_buttons.js"></script>
<script src="js/ajax.js"></script>
<script type="text/javascript">jQuery('document').ready(function(){update_buttons();});</script>
<div class="other_pages">
<link href="css/style.css" rel="stylesheet" type="text/css"/>


<?php
    require_once("head.php");
    if(!isset($_SESSION['logged_user_login']))
    {
        ?><div class='some_information'>To manage the studio you need to login or register</div><?php
    }
    else
    { // build array of states
        $states = array(
            '01' => 'NO', '02' => 'NO', '03' => 'NO', '04' => 'NO', '05' => 'NO', '06' => 'NO', '07' => 'NO', '08' => 'NO', '09' => 'NO', '10' => 'NO', '11' => 'NO',
            '13' => 'NO', '14' => 'NO', '15' => 'NO', '16' => 'NO',
            '18' => 'NO', '19' => 'NO', '20' => 'NO', '21' => 'NO', '22' => 'NO', '23' => 'NO', '24' => 'NO', '25' => 'NO', '26' => 'NO', '27' => 'NO', '28' => 'NO');
        
        $fd = fopen('commands/'.$_SESSION['logged_user_login'].'_commands.txt', 'r');
        while(!feof($fd))
        {
            $number = fgetc($fd).fgetc($fd);
            fgetc($fd);
            if($number == '09')// switcher 1 awitch all
            {
                $states['01'] = ($states['01'] == 'NO')?'YES':'NO'; 
                $states['02'] = ($states['02'] == 'NO')?'YES':'NO'; 
                $states['03'] = ($states['03'] == 'NO')?'YES':'NO'; 
                $states['04'] = ($states['04'] == 'NO')?'YES':'NO'; 
                $states['05'] = ($states['05'] == 'NO')?'YES':'NO'; 
                $states['06'] = ($states['06'] == 'NO')?'YES':'NO'; 
                $states['07'] = ($states['07'] == 'NO')?'YES':'NO'; 
                $states['08'] = ($states['08'] == 'NO')?'YES':'NO'; 
            }
            else if($number == '10')// switcher 1 awitch all off
            {
                $states['01'] = 'NO';
                $states['02'] = 'NO';
                $states['03'] = 'NO';
                $states['04'] = 'NO';
                $states['05'] = 'NO';
                $states['06'] = 'NO';
                $states['07'] = 'NO';
                $states['08'] = 'NO';
            }
            else if($number == '11')// switcher 1 awitch all on
            {
                $states['01'] = 'YES';
                $states['02'] = 'YES';
                $states['03'] = 'YES';
                $states['04'] = 'YES';
                $states['05'] = 'YES';
                $states['06'] = 'YES';
                $states['07'] = 'YES';
                $states['08'] = 'YES';
            }
            else if($number == '28')// switcher 2 awitch all
            {
                $states['18'] = ($states['18'] == 'NO')?'YES':'NO'; 
                $states['19'] = ($states['19'] == 'NO')?'YES':'NO'; 
                $states['20'] = ($states['20'] == 'NO')?'YES':'NO'; 
                $states['21'] = ($states['21'] == 'NO')?'YES':'NO'; 
                $states['22'] = ($states['22'] == 'NO')?'YES':'NO'; 
                $states['23'] = ($states['23'] == 'NO')?'YES':'NO'; 
                $states['24'] = ($states['24'] == 'NO')?'YES':'NO'; 
                $states['25'] = ($states['25'] == 'NO')?'YES':'NO'; 
            }
            else if($number == '26')// switcher 2 awitch all off
            {
                $states['18'] = 'NO';
                $states['19'] = 'NO';
                $states['20'] = 'NO';
                $states['21'] = 'NO';
                $states['22'] = 'NO';
                $states['23'] = 'NO';
                $states['24'] = 'NO';
                $states['25'] = 'NO';
            }
            else if($number == '27')// switcher 2 awitch all on
            {
                $states['18'] = 'YES';
                $states['19'] = 'YES';
                $states['20'] = 'YES';
                $states['21'] = 'YES';
                $states['22'] = 'YES';
                $states['23'] = 'YES';
                $states['24'] = 'YES';
                $states['25'] = 'YES';
            }
            $states[$number] = !$states[$number];
            
        }
        fclose($fd);
    ?>         
        <script type="text/javascript"> 
        	var b01 = '<?php echo $states["01"] ?>';
        	var b02 = '<?php echo $states["02"] ?>';
        	var b03 = '<?php echo $states["03"] ?>';
        	var b04 = '<?php echo $states["04"] ?>';
        	var b05 = '<?php echo $states["05"] ?>';
        	var b06 = '<?php echo $states["06"] ?>';
        	var b07 = '<?php echo $states["07"] ?>';
        	var b08 = '<?php echo $states["08"] ?>';
        	
        	var b18 = '<?php echo $states["18"] ?>';
        	var b19 = '<?php echo $states["19"] ?>';
        	var b20 = '<?php echo $states["20"] ?>';
        	var b21 = '<?php echo $states["21"] ?>';
        	var b22 = '<?php echo $states["22"] ?>';
        	var b23 = '<?php echo $states["23"] ?>';
        	var b24 = '<?php echo $states["24"] ?>';
        	var b25 = '<?php echo $states["25"] ?>';
        </script>
        <div id="main_content">
            <div id="videos">
                <?php
                include("dbconnect.php");
                $user = $_SESSION['logged_user_login'];
                $query = mysqli_query($connection, "SELECT * FROM `list_of_url` WHERE user_login='$user' LIMIT 1");
                $query_result = mysqli_fetch_assoc($query);
                $url_1 = $query_result['url_1'];
                $url_2 = $query_result['url_2'];
                mysqli_close($connection); 
                if($url_1 == 'nothing')
                    $url_1 = "sl_pxCAcJz4";
                if($url_2 == 'nothing')
                    $url_2 = "1ugivNRYfjc";
                ?>
                <div id="video_1">
                    <iframe src="https://www.youtube.com/embed/<?php echo $url_1; ?>" frameborder="0" allowfullscreen></iframe>
                </div>
                <div id="video_2">
                    <iframe src="https://www.youtube.com/embed/<?php echo $url_2; ?>" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            
            <div id="buttons" style="text-align: center;">
                <form method="post" id="buttons" action="" > 
                    <p></p><p></p>
                    
                    <div class="buttons_block"><div id="relay_1_block">
                        <div class="control_block">RELAY 1</div>
                        <button type="button" class="SWITCH_1" value="SWITCH_1">
                            <img class="button_img sw1" src="/images/off.jpg" alt="SWITCH 1" />
                        </button>
                        <button type="button" id="SWITCH_2" value="SWITCH_2">
                            <img class="button_img sw2" src="/images/off.jpg" alt="SWITCH 2" />
                        </button>
                        <button type="button" id="SWITCH_3" value="SWITCH_3">
                            <img class="button_img sw3" src="/images/off.jpg" alt="SWITCH 3" />
                        </button>
                        <button type="button" id="SWITCH_4" value="SWITCH_4">
                            <img class="button_img sw4" src="/images/off.jpg" alt="SWITCH 4" />
                        </button>
                        <button type="button" id="SWITCH_5" value="SWITCH_5">
                            <img class="button_img sw5" src="/images/off.jpg" alt="SWITCH 5" />
                        </button>
                        <button type="button" id="SWITCH_6" value="SWITCH_6">
                            <img class="button_img sw6 " src="/images/off.jpg" alt="SWITCH 6" />
                        </button>
                        <button type="button" id="SWITCH_7" value="SWITCH_7">
                            <img class="button_img sw7" src="/images/off.jpg" alt="SWITCH 7" />
                        </button>
                        <button type="button" id="SWITCH_8" value="SWITCH_8">
                            <img class="button_img sw8" src="/images/off.jpg" alt="SWITCH 8" />
                        </button>
                        <input type="button" id="SWITCH_ALL_OFF" value="ALL OFF" />
                        <input type="button" id="SWITCH_ALL_ON" value="ALL ON" />
                        <input type="button" id="SWITCH_ALL" value="SWITCH ALL" />
                    </div></div>
                    
                    <div class="buttons_block camera_block">
                        <div class="control_block">CAMERA </div>
                        <input type="button" id="MOVE_LEFT_5" value="MOVE LEFT 5" />
                        <input type="button" id="MOVE_RIGHT_5" value="MOVE RIGHT 5" />
                        <input type="button" id="MOVE_LEFT_20" value="MOVE LEFT 20" />
                        <input type="button" id="MOVE_RIGHT_20" value="MOVE RIGHT 20" />
                        <input type="button" id="CLEAR_COMMANDS_LIST" value="CLEAR COMMANDS LIST" />
                        <a class='some_reference form_button' href='add_url.php'>Translation</a>
                    </div>
                    
                    <div class="buttons_block">
                        <div class="control_block">RELAY 2</div>
                        <button type="button" id="REL_2_SWITCH_1" value="SWITCH_1">
                            <img class="button_img sw18" src="/images/off.jpg" alt="SWITCH 1" />
                        </button>
                        <button type="button" id="REL_2_SWITCH_2" value="SWITCH_2">
                            <img class="button_img sw19" src="/images/off.jpg" alt="SWITCH 2" />
                        </button>
                        <button type="button" id="REL_2_SWITCH_3" value="SWITCH_3">
                            <img class="button_img sw20" src="/images/off.jpg" alt="SWITCH 3" />
                        </button>
                        <button type="button" id="REL_2_SWITCH_4" value="SWITCH_4">
                            <img class="button_img sw21" src="/images/off.jpg" alt="SWITCH 4" />
                        </button>
                        <button type="button" id="REL_2_SWITCH_5" value="SWITCH_5">
                            <img class="button_img sw22" src="/images/off.jpg" alt="SWITCH 5" />
                        </button>
                        <button type="button" id="REL_2_SWITCH_6" value="SWITCH_6">
                            <img class="button_img sw23" src="/images/off.jpg" alt="SWITCH 6" />
                        </button>
                        <button type="button" id="REL_2_SWITCH_7" value="SWITCH_7">
                            <img class="button_img sw24" src="/images/off.jpg" alt="SWITCH 7" />
                        </button>
                        <button type="button" id="REL_2_SWITCH_8" value="SWITCH_8">
                            <img class="button_img sw25" src="/images/off.jpg" alt="SWITCH 8" />
                        </button>
                        <input type="button" id="REL_2_SWITCH_f" value="ALL OFF" />
                        <input type="button" id="REL_2_SWITCH_n" value="ALL ON" />
                        <input type="button" id="REL_2_SWITCH_s" value="SWITCH ALL" />
                    </div>
             </form>
            </div>
        </div>
    <?php
    }
    require_once("foot.php");
?>
</div>
