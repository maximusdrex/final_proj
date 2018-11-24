<?php
    require_once('utils.php');
    session_start();
    if(isset($_SESSION["uid"])) {
        exec_script("app.userid = {$_SESSION["uid"]}");
        exec_script("app.username = \"{$_SESSION["username"]}\"");
        exec_script("app.is_logged_in = true");
        console_log("App.uid set to uid");
    } else {
        console_log("No ID set");
        exec_script("app.is_logged_in = false");
    }
?>