<?php
require("config/database.php");

function is_in_db($title, $date) {
    $obj_arr = select_query("title, article_date", "mschaefer_posts WHERE article_date=\"{$date}\" AND title=\"{$title}\"");
    if(is_array($obj_arr)) {
        if(count($obj_arr) >= 1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function prepare_get_string($str) {
    $new_str = str_replace(' ', '%20', $str);
    return $new_str;
}

function project_refresh($project_keyword, $pid) {
    $json = file_get_contents('https://newsapi.org/v2/everything?q='. prepare_get_string($project_keyword) . '&apiKey=4c5c8c29454c45c898f8fd3a11f2e707&language=en&pageSize=50&page=1');
    $obj = (array) json_decode($json);
    $articles = $obj["articles"];
    #console_log($articles);
    for ($i=0; $i < count($articles); $i++) { 
        $current_article = (array) $articles[$i];
        $current_date = substr($current_article["publishedAt"], 0, 10);
        if ((! is_in_db($current_article["title"], $current_date)) && (strpos($current_article["title"], $project_keyword) !== false)) {
            insert_post($pid, $current_date, $current_article["title"], $current_article["description"], $current_article["urlToImage"], $current_article["url"]);
        } else {

        }
    }
}

function refresh_all() {
    $projects = select_query("name, pid", "mschaefer_projects");
    #console_log($projects);
    foreach ($projects as $key => $value) {
        project_refresh($value["name"], $value["pid"]);
        #console_log("project refreshed");
    }
}

refresh_all();
?>