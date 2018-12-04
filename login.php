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

            echo "<script> window.location = \"index.php\" </script>";
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

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
                    <a v-if="is_logged_in" class="navbar-item" href="add.php">
                        <i class="fas fa-plus"></i>
                    </a>
                    <div class="navbar-item">
                        <form id="search-form" method="GET" action="search.php">
                            <div class="field has-addons">
                                <input name="q" class="control input" type="text" placeholder="Search" />
                                <button type="submit" form="search-form" class="button"><i class="fas fa-search"></i>
                            </div>
                        </form>
                    </div>
                    <div v-if="is_logged_in"class="navbar-item">
                        <div v-bind:class="[{ 'is-active': dropdown }, 'dropdown']">
                            <div class="dropdown-trigger">
                                <button class="button" onclick="app.dropdown = !app.dropdown">
                                <span>{{ username }}</span>
                                <span class="icon is-small">
                                    <i class="fas fa-angle-down" aria-hidden="true"></i>
                                </span>
                                </button>
                            </div>
                            <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                <div class="dropdown-content">
                                    <a href="logout.php" class="dropdown-item">Log Out</a>
                                </div>
                            </div>
                        </div>
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
                <form id="user_form" method="POST" action="login.php">
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