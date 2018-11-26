<?php
require_once("../config/database.php");

if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET["remove"])) {
        if(isset($_GET["pid"]) && isset($_GET["uid"])) {
            $db = get_db();

            $query = "DELETE FROM `mschaefer_user_projects` WHERE uuid=:userid AND pid=:projectid";
            $statement = $db->prepare($query);
            $statement->execute(array("userid" => $_GET["uid"], "projectid" => $_GET["pid"]));    
        }
    } elseif (isset($_GET["add"])) {
        if(isset($_GET["pid"]) && isset($_GET["uid"])) {
            $db = get_db();

            $query = "INSERT INTO `mschaefer_user_projects`(`uuid`, `pid`) VALUES (:userid, :projectid)";
            $statement = $db->prepare($query);
            $statement->execute(array("userid" => $_GET["uid"], "projectid" => $_GET["pid"]));    
        }
    }
}
?>