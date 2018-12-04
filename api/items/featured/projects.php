<?php
require("../../config/database.php");

function json_response($output) {
    header('Content-Type: application/json');
    echo json_encode($output);
}

json_response(array("featured"=>get_featured()));

?>