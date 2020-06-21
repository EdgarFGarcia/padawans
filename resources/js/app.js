require('./bootstrap');

import Vue from 'vue';
import axios from 'vue-axios';

import Navigation from '../js/pages/Navigation/Nav';
import Routes from '../js/routes.js';
import App from '../js/views/Start';


Vue.use(axios, axios);
Vue.component('nav2', Navigation);

const app = new Vue({
    el: '#app',
    router: Routes,
    render: h => h(App),
});