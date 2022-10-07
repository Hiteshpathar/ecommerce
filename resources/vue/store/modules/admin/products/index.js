const getDefaultState = () => {
    return {
        isLoaded: false,
        products: [],
        errors: [],
        message: null
    }
};

const state = getDefaultState();

const getters = {
    getProducts: (state) => {
        return state.products;
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
    setProducts(state, data) {
        state.products = data;
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
            let {data} = await axios.get('/admin/api-products', {params: requestData});
            commit('setProducts', data);
        } catch ({response}) {
            console.log(response.data.message);
        }
        commit('stopLoading');
    },
    async getCategories({commit, dispatch, state}, requestData) {
        commit('setLoading');
        try {
            return await axios.get('/admin/get-categories', {params: requestData});
        } catch ({response}) {
            console.log(response.data.message);
        }
        commit('stopLoading');
    },
    async loadProduct({commit, dispatch, state}, requestData) {
        try {
            return await axios.get('/admin/api-products/' + requestData);
        } catch ({response}) {
            return response.data.message;
        }
    },
    async productCreateUpdate({commit, dispatch, state}, requestData) {
        commit('setLoading');
        try {
            let url = requestData.id ? '/admin/api-products/' + requestData.id : '/admin/api-products';
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
            return await axios.delete('/admin/api-products/' + requestData.id);
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
