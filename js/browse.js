Vue.component('project', {
    props: ["project"],
    template: `
    <article class="media">
        <figure class="media-left">
            <a v-bind:href="'http://localhost/final_proj/project.php?pid=' + project.pid"><p class="image is-64x64">
                <img v-bind:src="project.img">
            </p></a>
        </figure>
        <div class="media-content">
            <p>
                <a v-bind:href="'http://localhost/final_proj/project.php?pid=' + project.pid"><strong>{{ project.name }}</strong></a> 
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
        projects: null,
        username: null,
        userid: null,
        is_logged_in: null,
        dropdown: false,
    },
    mounted() {
        axios
            .get('http://localhost/final_proj/api/items/projects.php')
            .then(response => (this.projects = response.data.projects))
    },
})