/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import VueAxios from 'vue-axios';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import axios from 'axios';
import { library } from '@fortawesome/fontawesome-svg-core'

import { faThumbsUp, faDownload, faMaximize, faMedal} from '@fortawesome/free-solid-svg-icons'

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faThumbsUp,faDownload,faMaximize,faMedal);
// import Router from 'vue-router';
// import { routes } from './routes';
// Vue.use(Router);
Vue.use(VueAxios, axios);
Vue.use(BootstrapVue);
Vue.component(
    'popular-image',require('./components/Image.vue').default
);
Vue.component('font-awesome-icon', FontAwesomeIcon);

// const router = Router({
//     mode: 'history',
//     routes: routes,  
// });

const app = new Vue({
    el: '#app',
    // router: router,
});
