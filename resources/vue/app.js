require('../js/bootstrap');
import router from "./routes";
import store from "./store"

import Vue from 'vue';
import Pagination from "./components/Pagination";
import moment from 'moment';
import PolarisVue from '@hulkapps/polaris-vue';
import '@hulkapps/polaris-vue/dist/polaris-vue.min.css';

Vue.component('Pagination', Pagination);

window.moment = moment;

Vue.use(PolarisVue);

const app = new Vue({
    router,
    store,
    el: '#app',
});
