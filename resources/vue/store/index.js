/* Vendor */
import Vue from 'vue';
import Vuex from 'vuex';
import users from "./modules/admin/users";

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

    },
    state,
    mutations,
    strict: true
});
