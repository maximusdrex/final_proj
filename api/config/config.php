<?php
    // Database settings
    $GLOBALS["dbhostname"] = "mysql.1819.lakeside-cs.org";
    $GLOBALS["dbusername"] = "student1819";
    $GLOBALS["dbpassword"] = "m760CS4Fall18";
    $GLOBALS["dbdatabase"] = "1819project";

    // Debug function
    function console_log($data){
        echo '<script>';
        echo 'console.log('. json_encode($data) .')';
        echo '</script>';
    }
?>
