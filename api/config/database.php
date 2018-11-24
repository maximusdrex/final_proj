<?php
require("config.php");
    
function get_db() {
    try {
        $db = new PDO(
            "mysql:dbname={$GLOBALS["dbdatabase"]};host={$GLOBALS["dbhostname"]}",
            $GLOBALS["dbusername"], $GLOBALS["dbpassword"]
        );
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $ex) {
        print("Database error: " . $ex->getMessage());
    }
    console_log("DB error");
    return false;
}
    /*
    Runs a SELECT query on the database in the form of SELECT $columns FROM $from;
    */
function select_query($columns, $from) {
    try {
        $db = get_db();

        $query = 'SELECT ' . $columns . ' FROM ' . $from .';';
        /*$query = "SELECT * FROM mschaefer_posts";*/
        $statement = $db->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll();
        return $results;
    } catch (PDOException $ex) {
        print("Database error: " . $ex->getMessage());
    }
        return false;
}

function select_posts_user($uid) {
    $db = get_db();

    $query ='SELECT mschaefer_posts.pid, mschaefer_posts.article_date, mschaefer_posts.title, mschaefer_posts.article_desc, mschaefer_posts.img_src, mschaefer_posts.article_src, mschaefer_posts.likes 
        FROM `mschaefer_posts` INNER JOIN mschaefer_user_projects WHERE mschaefer_posts.pid=mschaefer_user_projects.pid 
        AND mschaefer_user_projects.uuid=:userid;';
    $statement = $db->prepare($query);
    $statement->execute(array("userid"=>$uid));
    $results = $statement->fetchAll();
    return $results;
}

function insert_post($pid, $article_date, $title, $article_desc, $img_src, $article_src) {
    try {
        $db = get_db();

        $query = "INSERT INTO mschaefer_posts VALUES (:projectid, :art_date, :art_title, :art_desc, :art_img_src, :art_src, 0);";
        /*$query = "SELECT * FROM mschaefer_posts";*/
        $statement = $db->prepare($query);
        $statement->execute(array("projectid"=>$pid, "art_date"=>$article_date, "art_title"=>$title, "art_desc"=>$article_desc, "art_img_src"=>$img_src, "art_src"=>$article_src));
        console_log("insertion completed");
    } catch (PDOException $ex) {
        print("Database error: " . $ex->getMessage());
    }
        return false;

}

?>