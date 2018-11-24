<?php
require_once("api/config/database.php");

function exec_script($js) {
    echo "<script>" . (string) $js . "</script>";
}

?>