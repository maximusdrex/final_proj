var app = new Vue({
    el: '#app',
    data: {
        username: null,
        userid: null,
        is_logged_in: null,
        project: null,
        projectImg: null,
        pid: null,
        dropdown: false,
    },
    watch: {
        project: function (val) {
            this.projectImg = val.img
        },
        pid: function(val) {
            if(val != null) {
                axios
                    .get('http://www.1819.lakeside-cs.org/Schaefer/final_proj/api/items/projects.php', {
                        params: {
                            pid: val
                        }
                    })
                    .then(response => (this.project = response.data.projects))
            }
        }
    },
    methods: {
        addProject: function(event) {
            axios
                .get('http://www.1819.lakeside-cs.org/Schaefer/final_proj/api/items/update.php', {
                    params: {
                        add: true,
                        uid: this.userid,
                        pid: this.pid,
                    }
                })
                .then(console.log("success"))
        },
        deleteProject: function(event) {
            if(confirm("Are you sure you want to delete this project? This deletes it for ALL users")) {
                axios
                    .get('http://www.1819.lakeside-cs.org/Schaefer/final_proj/api/items/update.php', {
                        params: {
                            delete: true,
                            pid: this.pid,
                        }
                    })
                    .then(console.log("success"))
            }
        }
    }
})
