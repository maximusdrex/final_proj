<?php
require("../config/database.php");

function json_response($output) {
    header('Content-Type: application/json');
    echo json_encode(array("posts" => $output));
}


if($_SERVER["REQUEST_METHOD"] == "GET") {
    $user_id = $_REQUEST["uid"];
    json_response(select_posts_user($user_id));
}

?>