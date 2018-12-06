<?php
require_once("../config/database.php");

function already_added($pid, $uid) {
    $db = get_db();

    $query = "SELECT COUNT(*) FROM `mschaefer_user_projects` WHERE uuid=:userid AND pid=:projectid";
    $statement = $db->prepare($query);
    $statement->execute(array("userid" => $uid, "projectid" => $pid));    
    $results = $statement->fetchAll();
    return ($results[0][0] > 0);
}

if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET["remove"])) {
        if(isset($_GET["pid"]) && isset($_GET["uid"])) {
            $db = get_db();

            $query = "DELETE FROM `mschaefer_user_projects` WHERE uuid=:userid AND pid=:projectid";
            $statement = $db->prepare($query);
            $statement->execute(array("userid" => $_GET["uid"], "projectid" => $_GET["pid"]));    
        }
    } elseif (isset($_GET["add"])) {
        if((isset($_GET["pid"]) && isset($_GET["uid"])) && !(already_added($_GET["pid"], $_GET["uid"]))) {
            $db = get_db();

            $query = "INSERT INTO `mschaefer_user_projects`(`uuid`, `pid`) VALUES (:userid, :projectid)";
            $statement = $db->prepare($query);
            $statement->execute(array("userid" => $_GET["uid"], "projectid" => $_GET["pid"]));    
        }
    } elseif (isset($_GET["delete"])) {
        if(isset($_GET["pid"])) {
            $db = get_db();

            $query = "DELETE FROM `mschaefer_user_projects` WHERE pid=:projectid";
            $statement = $db->prepare($query);
            $statement->execute(array("projectid" => $_GET["pid"]));

            $query = "DELETE FROM `mschaefer_projects` WHERE pid=:projectid";
            $statement = $db->prepare($query);
            $statement->execute(array("projectid" => $_GET["pid"]));
        }
    }
}
?>