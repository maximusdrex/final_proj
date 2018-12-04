Vue.component('project', {
    props: ["project"],
    template: `
    <article class="media">
        <figure class="media-left">
            <a v-bind:href="'http://www.1819.lakeside-cs.org/Schaefer/final_proj/project.php?pid=' + project.pid"><p class="image is-64x64">
                <img v-bind:src="project.img">
            </p></a>
        </figure>
        <div class="media-content">
            <p>
                <a v-bind:href="'http://www.1819.lakeside-cs.org/Schaefer/final_proj/project.php?pid=' + project.pid"><strong>{{ project.name }}</strong></a> 
                <br />
                {{ project.description }}
            </p>
        </div>
</article>
    `
})

var app = new Vue({
    el: '#app',
    data: {
        username: null,
        userid: null,
        is_logged_in: null,
        dropdown: false,
        search: "",
        projects: null,
    },
    mounted() {
        axios
            .get('http://www.1819.lakeside-cs.org/Schaefer/final_proj/api/items/projects.php')
            .then(response => (this.projects = response.data.projects))
    },
    computed: {
        filtered: function() {
            if(this.projects == null) {
                return null 
            }
            filteredList = []
            for (var i = 0; i < this.projects.length; i++) {
                if(this.projects[i].name.toUpperCase().includes(this.search.toUpperCase())) {
                    filteredList.push(this.projects[i])
                }
            }
            return filteredList
        }
    }
})