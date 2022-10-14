const getDefaultState = () => {
    return {
        authenticated: false,
    }
};

const state = getDefaultState();

const getters = {
    authenticated: (state) => {
        return state.authenticated
    },
};
const mutations = {
    SET_AUTHENTICATED(state, value) {
        state.authenticated = value
    },
};


const actions = {
    async isLoggedIn({state}) {
        if (state.authenticated) {
            return true;
        } else {
            let {data} =  await axios.get('/admin/is-admin-login');
            return data;
        }

    },
    async setAdmin({commit}) {
        commit('SET_AUTHENTICATED', true);
    },
    async unsetAdmin({commit}) {
        await axios.post('/admin/logout');
        commit('SET_AUTHENTICATED', false);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
