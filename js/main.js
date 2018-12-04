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
        last_page: 1,
    },
    mounted() {
        this.scroll()
    },
    watch: {
        userid: function (val) {
            axios
                .get('http://www.1819.lakeside-cs.org/Schaefer/final_proj/api/items/posts.php', {
                    params: {
                        uid: this.userid,
                        page: 1,
                        pagesize: 12
                    }
                })
                .then(response => (this.posts = response.data.posts))
            axios
                .get('http://www.1819.lakeside-cs.org/Schaefer/final_proj/api/items/projects.php', {
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
                .get('http://www.1819.lakeside-cs.org/Schaefer/final_proj/api/items/update.php', {
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
                .get('http://www.1819.lakeside-cs.org/Schaefer/final_proj/api/items/posts.php', {
                    params: {
                        uid: this.userid,
                        page: 1,
                        pagesize: 12
                    }
                })
                .then(response => (this.posts = response.data.posts))
            axios
                .get('http://www.1819.lakeside-cs.org/Schaefer/final_proj/api/items/projects.php', {
                    params: {
                        uid: this.userid
                    }
                })
                .then(response => (this.projects = response.data.projects))
        },
        scroll: function() {
            window.onscroll = () => {
                var bottomOfWindow = document.documentElement.scrollTop + window.innerHeight === document.documentElement.offsetHeight;

                if(bottomOfWindow) {
                    axios
                        .get('http://www.1819.lakeside-cs.org/Schaefer/final_proj/api/items/posts.php', {
                            params: {
                                uid: this.userid,
                                page: this.last_page + 1,
                                pagesize: 12
                            }
                        })
                        .then(response => (this.addPosts(response)))
                        /*.then(response => (this.posts.concat(response.data.posts)))*/
                    this.last_page += 1
                }
            }
            
        },
        addPosts: function(response) {
            /*console.log(response.data.posts)*/
            this.posts = this.posts.concat(response.data.posts)
        }
    }
  })

