<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search</title>
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
        <section class="section" id="search-section">
            <div class="container">
                <div class="level">
                    <div class="level-left">
                        <div class="field has-addons">
                            <input v-model="search" class="control input" type="text" placeholder="Search" />
                            <button v-on:click="" class="button"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="level-right">
                        
                    </div>
                </div>
            </div>
        </section>
        <section class="section" id="projects">
            <div class="container">
                <project v-for="project in filtered" v-bind:project="project"></project>
            </div>
        </section>
    </div>
    
    <script src="js/search.js"></script>

    <?php
        require('php/setup.php');

        if($_SERVER["REQUEST_METHOD"] == "GET"){
            if(isset($_GET["q"])) {
                exec_script("app.search = '" . (string) $_GET["q"] . "'");
            }
        }
    ?>
</body>
</html>