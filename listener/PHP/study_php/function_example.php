 <?php
    function myprint ($x,$y)
    {
        echo sum($x,$y);
    }
    function sum ($x,$y)
    {
        return $x+$y;
    }
    $a = 1;
    $b = 2;
    myprint($a,$b);
?>