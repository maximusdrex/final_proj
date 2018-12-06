<?php
require("../config/database.php");

function json_response($output) {
    header('Content-Type: application/json');
    echo json_encode($output);
}


if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET["page"]) && isset($_GET["pagesize"])) {
        $user_id = $_GET["uid"];
	# echo "test";
        json_response(array("page" => $_GET["page"], "total" => user_posts_count($user_id), "posts" => select_posts_user_paged($user_id, $_GET["page"], $_GET["pagesize"]) ));    
    	# echo "test 2";
} elseif (isset($_GET["uid"])) {
        $user_id = $_GET["uid"];
        json_response(array("posts" => select_posts_user($user_id), "total" => user_posts_count($user_id)));    
    } else {
        json_response(null);
    }
}

?>
