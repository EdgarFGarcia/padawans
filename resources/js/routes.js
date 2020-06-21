import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from '../js/pages/Home';
import About from '../js/pages/About';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/about',
            name: 'about',
            component: About
        }
    ]
});

export default router;