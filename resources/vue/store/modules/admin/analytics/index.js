const getDefaultState = () => {
    return {
        isLoaded: false,
        sales: [],
        errors: [],
        message: null
    }
};

const state = getDefaultState();

const getters = {
    getSales: (state) => {
        return state.sales;
    },
    getErrors: (state) => {
        return state.errors;
    },
    getMessage: (state) => {
        return state.message;
    }
};

const mutations = {
    resetState(state) {
        Object.assign(state, getDefaultState());
    },
    setLoading(state) {
        state.isLoaded = true;
    },
    stopLoading(state) {
        state.isLoaded = false;
    },
    setSales(state, data) {
        state.sales = data;
    },
    setErrors(state, data) {
        state.errors = data.data.errors;
    },
    resetErrors(state) {
        state.errors = [];
    },
    setMessage(state, message) {
        state.message = message;
    }
};

const actions = {
    async resetState({commit, dispatch, state}) {
        commit('resetState');
    },
    resetError({commit, dispatch, state}) {
        commit('resetErrors');
    },
    async loadSales({commit, dispatch, state}, requestData) {
        commit('setLoading');
        try {
            let {data} = await axios.post('/admin/total-sales', {params: requestData});
            commit('setSales', data);
        } catch ({response}) {
            console.log(response.data.message);
        }
        commit('stopLoading');
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
