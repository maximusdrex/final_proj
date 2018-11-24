<?php
require("../config/database.php");

function json_response($output) {
    header('Content-Type: application/json');
    echo json_encode(array("projects" => $output));
}

json_response(select_query("*", "mschaefer_projects"));

?>  