<?php
require("../config/database.php");

function json_response($output) {
    header('Content-Type: application/json');
    echo json_encode(array("posts" => $output));
}

json_response(select_query("*", "mschaefer_posts"));

?>