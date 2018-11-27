<?php
require("../config/database.php");

function json_response($output) {
    header('Content-Type: application/json');
    echo json_encode(array("projects" => $output));
}

if(isset($_GET["pid"])) {
    json_response(select_project($_GET["pid"]));
} elseif (isset($_GET["uid"])) {
    json_response(select_user_project($_GET["uid"]));
} else {
    json_response(select_query("*", "mschaefer_projects"));
}

?>