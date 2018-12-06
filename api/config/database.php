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

function select_project($pid) {
    try {
        $db = get_db();

        $query = "SELECT * FROM `mschaefer_projects` WHERE pid=:projectid";

        $statement = $db->prepare($query);
        $statement->execute(array("projectid"=>$pid));
        $results = $statement->fetchAll();
        if(empty($results)) {
            return false;
        } else {
            return $results[0];
        }
    } catch(PDOException $ex) {
        print("Database error: " . $ex->getMessage());
    }
}

function select_user_project($uid) {
    try {
        $db = get_db();

        $query = "SELECT `mschaefer_projects`.pid, `mschaefer_projects`.name, `mschaefer_projects`.dev_id, `mschaefer_projects`.img, `mschaefer_projects`.description, `mschaefer_projects`.twitter 
            FROM `mschaefer_projects` INNER JOIN `mschaefer_user_projects` ON `mschaefer_user_projects`.pid=`mschaefer_projects`.pid WHERE `mschaefer_user_projects`.uuid=:userid";

        $statement = $db->prepare($query);
        $statement->execute(array("userid"=>$uid));
        $results = $statement->fetchAll();
        if(empty($results)) {
            return false;
        } else {
            return $results;
        }
    } catch(PDOException $ex) {
        print("Database error: " . $ex->getMessage());
    }
}


function select_posts_user($uid) {
    $db = get_db();

    $query ='SELECT mschaefer_posts.pid, mschaefer_posts.article_date, mschaefer_posts.title, mschaefer_posts.article_desc, mschaefer_posts.img_src, mschaefer_posts.article_src, mschaefer_posts.likes 
        FROM `mschaefer_posts` INNER JOIN mschaefer_user_projects WHERE mschaefer_posts.pid=mschaefer_user_projects.pid 
        AND mschaefer_user_projects.uuid=:userid ORDER BY mschaefer_posts.article_date DESC;';
    $statement = $db->prepare($query);
    $statement->execute(array("userid"=>$uid));
    $results = $statement->fetchAll();
    return $results;
}

function select_posts_user_paged($uid, $page, $page_size) {
    try {
        $db = get_db();

        $page = (int) $page;
        $page_size = (int) $page_size;
        $pagelim = (int) $page * $page_size;
        $query ="SELECT bottom_10.pid, bottom_10.article_date, bottom_10.title, bottom_10.article_desc, bottom_10.article_src, bottom_10.img_src, bottom_10.likes FROM (SELECT * FROM 
            (SELECT mschaefer_posts.pid, mschaefer_posts.article_date, mschaefer_posts.title, mschaefer_posts.article_desc, mschaefer_posts.img_src, mschaefer_posts.article_src, mschaefer_posts.likes FROM `mschaefer_posts` INNER JOIN mschaefer_user_projects WHERE mschaefer_posts.pid=mschaefer_user_projects.pid AND mschaefer_user_projects.uuid=:userid ORDER BY mschaefer_posts.article_date DESC LIMIT {$pagelim}) AS topx
            ORDER BY topx.article_date ASC LIMIT {$page_size}) AS bottom_10
            ORDER BY bottom_10.article_date DESC";
        $statement = $db->prepare($query);
        $statement->execute(array("userid"=>$uid));
        $results = $statement->fetchAll();
        return $results;
    }
    catch(Exception $ex) {
	    echo $ex->getMessage();
    }
    return null;
}



function user_posts_count($uid) {
    $db = get_db();

    $query ='SELECT COUNT(*) 
        FROM `mschaefer_posts` INNER JOIN mschaefer_user_projects WHERE mschaefer_posts.pid=mschaefer_user_projects.pid 
        AND mschaefer_user_projects.uuid=:userid ORDER BY mschaefer_posts.article_date DESC;';
    $statement = $db->prepare($query);
    $statement->execute(array("userid"=>$uid));
    $results = $statement->fetchAll();
    return $results[0][0];
}

function insert_post($pid, $article_date, $title, $article_desc, $img_src, $article_src) {
    try {
        $db = get_db();

        $query = "INSERT INTO mschaefer_posts VALUES (:projectid, :art_date, :art_title, :art_desc, :art_img_src, :art_src, 0);";
        /*$query = "SELECT * FROM mschaefer_posts";*/
        $statement = $db->prepare($query);
        $statement->execute(array("projectid"=>$pid, "art_date"=>$article_date, "art_title"=>$title, "art_desc"=>$article_desc, "art_img_src"=>$img_src, "art_src"=>$article_src));
        #console_log("insertion completed");
    } catch (PDOException $ex) {

    }
    return false;
}

function insert_project($proj_name, $proj_img, $desc, $twitter) {
    try {
        $db = get_db();

        $query = "INSERT INTO `mschaefer_projects`(`name`, `img`, `description`, `twitter`) VALUES (:projname, :projimg, :projdesc, :projtwitter)";
        $statement = $db->prepare($query);
        $statement->execute(array("projname"=>$proj_name, "projimg"=>$proj_img, "projdesc"=>$desc, "projtwitter"=>$twitter));
    } catch(PDOException $ex) {
        console_log("Database error: " . $ex->getMessage());
    }
}

function get_featured() {
    try {
        $db = get_db();

        $query = "SELECT `mschaefer_projects`.`pid`, `mschaefer_projects`.`name`, `mschaefer_projects`.`dev_id`, `mschaefer_projects`.`img`, `mschaefer_projects`.`description`, `mschaefer_projects`.`twitter` FROM `mschaefer_featured` INNER JOIN `mschaefer_projects` ON `mschaefer_featured`.`pid`=`mschaefer_projects`.`pid`";
        $statement = $db->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll();
        return $results[0];
    } catch(PDOException $ex) {
        console_log("DB err");
    }
}

?>
