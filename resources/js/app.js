
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import App from './App.vue';
import Home from './components/Home';
import Quiz from './components/Quiz';
import Pokedex from './components/Pokedex';

Vue.component('lazy-image', require('./components/LazyImage.vue').default);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
        },
        {
            path: '/quiz',
            name: 'quiz',
            component: Quiz,
        },
        {
            path: '/pokedex',
            name: 'pokedex',
            component: Pokedex,
        }
    ]
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: { App, Home },
    router,
});
