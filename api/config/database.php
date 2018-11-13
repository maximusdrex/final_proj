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
        $statement = $db->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll();
        return $results;
    } catch (PDOException $ex) {
        print("Database error: " . $ex->getMessage());
    }
        return false;
}


?>