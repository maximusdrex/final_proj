<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project</title>
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
    <section class="section">
        <div id="project-header" class="hero is-medium project-bg" v-bind:style="{ 'background-image': 'url(' + projectImg + ')' }">
            <div class="hero-body project-title">
                <h1 v-if="project != null" class="title ">
                    <button class="button" v-on:click="addProject"><i class="far fa-check-circle"></i></button>
                    {{ project.name }}
                </h1>
            </div>
        </div>
        <br />
        <div class="columns">
          <div class="column is-two-thirds">
            <h2 class="subtitle">
                Details
            </h2>
            <p v-if="project != null" class="content">
                {{ project.description }}
            </p>
          </div>
          <div class="column is-one-third">
            <h2 class="subtitle">
                Similar
            </h2>
          </div>
        </div>
    </section>
</div>

<script src="js/project.js"></script>
<?php
    require('php/setup.php');

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        if(isset($_GET["pid"])) {
            $pid = $_GET["pid"];
            exec_script("app.pid = {$pid}");
        }
    }
?>
</body>
</html>