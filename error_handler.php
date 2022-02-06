<?php
function error()
{

        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(0);
        if ($_SESSION['G_Name'] != 'admin')
        {
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
            error_reporting(0);
        }
    


}

