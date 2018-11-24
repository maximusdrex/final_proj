<?php
require_once('php/utils.php');

function get_user($uname) {
    try {
        $db = get_db();

        $query = "SELECT * FROM `mschaefer_users` WHERE username=:uname";

        $statement = $db->prepare($query);
        $statement->execute(array("uname"=>$uname));
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


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"])) || empty(trim($_POST["password"]))) {
        exec_script("alert(\"Error, please make sure to enter a username and password\")");
    } else {
        $username = $_POST["username"];
        $user = get_user($username);
        $hash = $user["password"];

        if(password_verify($_POST["password"], $hash)) {
            session_start();
            $uuid = $user["uuid"];

            $_SESSION["uid"] = $uuid;
            $_SESSION["username"] = $username;

            header("location: index.php");
        }
    }
}
?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.css" />
    
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body>

    <div id="app">
        <nav class="navbar">
            <div class="navbar-brand">
                <a class="navbar-item" href="index.php">
                    Home
                </a>
                <a class="navbar-item" href="browse.php">
                    Browse
                </a>
            </div>
            <div class="navbar-menu">
                <div class="navbar-end">
                    <div v-if="is_logged_in"class="navbar-item">
                        {{ username }}
                    </div>
                    <a v-if="!is_logged_in" class="navbar-item" href="login.php">
                        login
                    </a>
                    <a v-if="!is_logged_in" class="navbar-item" href="register.php">
                        sign up
                    </a>
                </div>
            </div>
        </nav>
        <section class="hero is-primary is-bold">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title">Log In</h1>
                </div>
            </div>
        </section>
        <section class="section is-medium">
            <div class="container box">
                <form id="user_form" method="POST" action="register.php">
                    <div class="field">
                        <label class="label">Username</label>
                        <div class="control">
                            <input class="input" placeholder="username" id="username" name="username" type="text"/>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input class="input" placeholder="password" id="password" name="password" type="password"/>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <input class="button is-primary" id="submit" type="submit" value="submit" />
                        </div>
                    </div>
                </form>
            </div>
        </section>

    </div>

    <script src="js/login.js"></script>

    <?php
        require('php/setup.php');
    ?>    
</body>
</html>