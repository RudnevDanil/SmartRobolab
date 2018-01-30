 <?php
    $x = 1;
    switch($x)
    {
        case 0 : echo "  0  "; break;
        case 1 : echo "  1  "; break;
        default : echo "  default  ";
    }
    //$x = 0;
    switch($x = 0)
    {
        case 0 : echo "  0  "; break;
        case 1 : echo "  1  "; break;
        default : echo "  default  ";
    }
?>