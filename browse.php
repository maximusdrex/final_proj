<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Browse</title>
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
        <section v-if="featured != null" id="featured" class="section">
            <div id="project-header" class="hero is-large project-bg" v-bind:style="{ 'background-image': 'url(' + featured.img + ')' }">
                <div class="hero-body project-title">
                    <h1  class="title ">
                        <a v-bind:href="'http://www.1819.lakeside-cs.org/Schaefer/final_proj/project.php?pid=' + featured.pid">Featured Project: {{ featured.name }}</a>
                    </h1>
                </div>
            </div>
        </section>
        <section class="hero is-dark">
          <div class="hero-body">
            <div class="container">
              <h1 class="title">
                All Projects
              </h1>
            </div>
          </div>
        </section>
        <section id="all" class="section">
            <div class="container">
                <!--<article class="media">
                    <figure class="media-left">
                        <p class="image is-64x64">
                            <img src="https://bulma.io/images/placeholders/128x128.png">
                        </p>
                    </figure>
                    <div class="media-content">
                        <p>
                            <strong>title</strong> 
                            <br />
                            Text Description
                        </p>
                    </div>
                </article> -->
                <project v-for="project in projects" v-bind:project="project">

                </project>
            </div>
        </section>

    </div>
    <script src="js/browse.js"></script>

    <?php
        require('php/setup.php');
    ?>
</body>
</html>