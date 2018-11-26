Vue.component('post-item', {
    data: function () {
        return {
            css_class: "card post-card",
            img_class: "post-img",
            header_class: "post-title",
            text_class: "content post-content"
        }
    },
    props: ["title", "description", "img_src", "article_src"],
    template: `
    <div v-bind:class="css_class">
        <div class="card-image">
            <figure class="card-image">
                <a v-bind:href="article_src">
                    <img v-bind:src="img_src">
                </a>
            </figure>
        </div>
        <div class="card-content">
            <div class="media">
                <div class="media-content">
                    <a v-bind:href="article_src">
                        <p class="title">{{ title }}</p>
                    </a>
                </div>
            </div>
            <div v-bind:class="text_class">
                <p>{{ description }}</p>
            </div>
        </div>
    </div>
    `    
})

var app = new Vue({
    el: '#app',
    data: {
        seen: true,
        posts: null,
        projects: null,
        username: null,
        userid: null,
        is_logged_in: null,
        dropdown: false,
    },
    mounted() {
        axios
            .get('http://localhost/final_proj/api/items/posts.php', {
                params: {
                    uid: this.userid
                }
            })
            .then(response => (this.posts = response.data.posts))
        axios
            .get('http://localhost/final_proj/api/items/projects.php', {
                params: {
                    uid: this.userid
                }
            })
            .then(response => (this.projects = response.data.projects))
    },
    watch: {
        userid: function (val) {
            axios
                .get('http://localhost/final_proj/api/items/posts.php', {
                    params: {
                        uid: val
                    }
                })
                .then(response => (this.posts = response.data.posts))
            axios
                .get('http://localhost/final_proj/api/items/projects.php', {
                    params: {
                        uid: this.userid
                    }
                })
                .then(response => (this.projects = response.data.projects))
        }
    },
    methods: {
        deleteProj: function(pid) {
            console.log(pid)
            console.log(this.userid)
            axios
                .get('http://localhost/final_proj/api/items/update.php', {
                    params: {
                        uid: this.userid,
                        pid: pid,
                        remove: true
                    }
                })
            location.reload()
        },
        refreshData: function() {
            axios
                .get('http://localhost/final_proj/api/items/posts.php', {
                    params: {
                        uid: this.userid
                    }
                })
                .then(response => (this.posts = response.data.posts))
            axios
                .get('http://localhost/final_proj/api/items/projects.php', {
                    params: {
                        uid: this.userid
                    }
                })
                .then(response => (this.projects = response.data.projects))
        },
    }
  })

