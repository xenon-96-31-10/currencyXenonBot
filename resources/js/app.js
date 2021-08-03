/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import Vuelidate from 'vuelidate';


Vue.use(Vuelidate);
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

Vue.component('login-component', require('./components/auth/LoginComponent.vue').default);
Vue.component('reset-link-component', require('./components/auth/ResetLinkComponent.vue').default);
Vue.component('reset-component', require('./components/auth/ResetComponent.vue').default);
Vue.component('register-component', require('./components/auth/RegisterComponent.vue').default);
Vue.component('list-component', require('./components/ListComponent.vue').default);
Vue.component('Loader', require('./components/LoaderComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
