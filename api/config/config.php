<?php
    $GLOBALS["dbhostname"] = "localhost";
    $GLOBALS["dbusername"] = "root";
    $GLOBALS["dbpassword"] = "root";
    $GLOBALS["dbdatabase"] = "1819playground";


    function console_log($data){
        echo '<script>';
        echo 'console.log('. json_encode($data) .')';
        echo '</script>';
    }
?>