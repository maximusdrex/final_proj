<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.css" />
    
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body>
    <?php
        require('php/utils.php');
        session_start();
        if(isset($_SESSION["uid"])) {
            
        }
    ?>
    <div id="app">
        <nav class="navbar is-fixed-top">
            <div class="navbar-brand">
                <a class="navbar-item" href="index.html">
                    Home
                </a>
                <a class="navbar-item" href="browse.html">
                    Browse
                </a>
            </div>
            <div class="navbar-menu">
                <div class="navbar-end">
                    <div class="navbar-item">
                        {{ username }}
                    </div>
                </div>
            </div>
        </nav>
        <section class="section">
            <div class="container">
                <div class="columns">
                    <div id="posts" class="column is-two-thirds">
                        <h1>Main Feed</h1>
                        <div class="post-container">
                            <post-item v-for="post in posts" 
                                v-bind:title="post.title" 
                                v-bind:description="post.article_desc" 
                                v-bind:img_src="post.img_src"
                                v-bind:article_src="post.article_src"></post-item>
                        </div>
                        
                    </div>
                    <div id="projects" class="column is-one-third">
                        <h1>Projects</h1>
                        <ul>
                            <li v-for="project in projects">{{ project.name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
            
    </div>
    <script src="js/main.js"></script>
</body>
</html>