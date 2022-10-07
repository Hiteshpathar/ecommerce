const initialState = {
    authenticated: false,
};

const getters = {
    authenticated(state) {
        return state.authenticated
    },
};
const mutations = {
    SET_AUTHENTICATED(state, value) {
        state.authenticated = value
    },
};


const actions = {
    isLoggedIn: async ({state, commit, dispatch, getters}) => {

        if (!state.authenticated) {
            let {data} = await axios.get('/admin/is-admin-login',{email:state.email});

            if (data>0){
                return 200;
            } else {
                return 400;
            }
        } else {
            return 200;
        }
    },
    login({commit}) {
        commit('SET_AUTHENTICATED', true)
    },
    async unsetAdmin({state,commit}) {
        await axios.post('/admin/logout',{email:state.email});
        commit('SET_AUTHENTICATED', false);
        // router.push({name:"logout"})
    }
    // logout({commit}) {
    //     commit('SET_USER', {})
    //     commit('SET_AUTHENTICATED', false)
    //     commit('SET_VERIFIED', false)
    // },
};

export default {
    state: initialState,
    mutations,
    actions,
    getters
}
