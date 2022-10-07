const getDefaultState = () => {
    return {
        isLoaded: false,
        orders: [],
        errors: [],
        message: null
    }
};

const state = getDefaultState();

const getters = {
    getOrders: (state) => {
        return state.orders;
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
    setOrders(state, data) {
        state.orders = data;
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
    async load({commit, dispatch, state}, requestData) {
        commit('setLoading');
        try {
            let {data} = await axios.get('/admin/api-orders', {params: requestData});
            commit('setOrders', data);
        } catch ({response}) {
            console.log(response.data.message);
        }
        commit('stopLoading');
    },
    async loadOrder({commit, dispatch, state}, requestData) {
        try {
            return await axios.get('/admin/api-orders/' + requestData);
        } catch ({response}) {
            return response.data.message;
        }
    },
    async orderCreateUpdate({commit, dispatch, state}, requestData) {
        commit('setLoading');
        try {
            let url = requestData.id ? '/admin/api-orders/' + requestData.id : '/admin/api-orders';
            let {data} = await axios.post(url, requestData);
            commit('setMessage', data.message);
            commit('resetErrors');
        } catch ({response}) {
            commit('setErrors', response);
        }
        commit('stopLoading');
    },
    async delete({commit, dispatch, state}, requestData) {
        try {
            return await axios.delete('/admin/api-orders/' + requestData.id);
        } catch ({response}) {
            return {data: {error: response.data.message}};
        }
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
