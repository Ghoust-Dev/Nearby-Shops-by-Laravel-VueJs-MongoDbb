require('./bootstrap');
import Vuex from 'vuex';

import InfiniteLoading from 'vue-infinite-loading';
import VueObserveVisibility from 'vue-observe-visibility';

window.Vue = require('vue');

Vue.use(InfiniteLoading);
Vue.use(VueObserveVisibility);
Vue.use(Vuex);

import router from './routes';
import store from './store';

import App from "./App.vue";

const app = new Vue({
    el: '#app',
    components:{
        App,
    },
    router,
    store,
});
