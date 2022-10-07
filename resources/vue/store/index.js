/* Vendor */
import Vue from 'vue';
import Vuex from 'vuex';
import users from "./modules/admin/users";
import products from "./modules/admin/products"
import orders from "./modules/admin/orders"
import adminAuth from './modules/admin/auth'
import analytics from "./modules/admin/analytics"

Vue.use(Vuex);
const state = {
    title: null
};
const mutations = {
    setTitle(state, title) {
        this.state.title = title;
    }
}
export default new Vuex.Store({
    modules: {
        users,
        products,
        orders,
        adminAuth,
        analytics
    },
    state,
    mutations,
    strict: true
});
