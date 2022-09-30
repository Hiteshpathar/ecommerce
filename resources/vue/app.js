require('../js/bootstrap');
import router from "./routes";
import store from "./store"

import Vue from 'vue';

import moment from 'moment';

window.moment = moment;

import PolarisVue from '@hulkapps/polaris-vue';
import '@hulkapps/polaris-vue/dist/polaris-vue.min.css';
Vue.use(PolarisVue);


const app = new Vue({
    router,
    store,
    el: '#app',
});
