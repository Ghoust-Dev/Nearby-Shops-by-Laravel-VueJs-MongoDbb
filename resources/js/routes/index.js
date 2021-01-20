import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from '../views/home';
import PreferedShop from '../components/PreferedShop';

Vue.use(VueRouter)

const router = new VueRouter({
    mode:'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
        },
        {
            path: '/prefered-shops',
            name: 'preferedShops',
            component: PreferedShop
        }
    ],
    linkExactActiveClass: 'active'
});

export default router;