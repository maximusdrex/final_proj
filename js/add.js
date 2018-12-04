var app = new Vue({
    el: '#app',
    data: {
        username: null,
        userid: null,
        is_logged_in: null,
        dropdown: false,
        imgURL: "",
    },
    computed: {
        isVerified: function() {
            return (this.imgURL.match(/\.(jpeg|jpg|gif|png)$/) != null)
        }
    }
})