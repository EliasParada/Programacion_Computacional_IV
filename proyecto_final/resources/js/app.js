/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
window.openNav = (nav) => {
    for (let key in app.navs) {
        app.navs[key].open = key === nav;
    }
}
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('camera-component', require('./components/CameraComponent.vue').default);
Vue.component('notes-component', require('./components/NotesComponent.vue').default);
Vue.component('profiles-component', require('./components/UsersComponent.vue').default);

window.queries = async (method = 'POST', url = '', data = null) => {
    const response = await axios({
        method,
        url,
        data,
    })
    .then(response => {
        return response.data;
    })
    .catch(error => {
        console.log(error);
        return {err: error.response.data, status: 'error'};
    });
    return response;
};
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        dark: false,
        navs: {
            notes: {open: false},
            profiles: {open: false},
        },
    },
    methods: {
        
    },
    // watch: {
    //     dark: (val) => {
    //     }
    // }
});
