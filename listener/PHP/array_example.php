<?php
    $arr = array("a","b","c","d");
    echo "arr[2] = $arr[2] \n";

    $arr = array(
        "name" => "Alex",
        "surname" => "Hoyt",
        "age" => 32,
        "education" => array(2013,2010) 
    );
    echo 'arr["name"] = ' . $arr['name'] . '               arr["education"][1] = ' . $arr['education'][1];
    print_r($arr); //печать массива

    $arr2 = array();
    if(empty($arr2))
        echo 'was empty' . "\n";
    $arr2[] = "Hi!";
    print_r($arr2);
?>