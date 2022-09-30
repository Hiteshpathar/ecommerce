const getDefaultState = () => {
    return {
        isLoaded: false,
        users: [],
        errors: [],
        message: null
    }
};

const state = getDefaultState();

const getters = {
    getUsers: (state) => {
        return state.users;
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
    setUsers(state, data) {
        state.users = data;
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
            let {data} = await axios.get('/admin/api-users', {params: requestData});
            commit('setUsers', data);
        } catch ({response}) {
            console.log(response.data.message);
        }
        commit('stopLoading');
    },
    async loadUser({commit, dispatch, state}, requestData) {
        try {
            return await axios.get('/admin/api-users/' + requestData);
        } catch ({response}) {
            return response.data.message;
        }
    },
    async userCreateUpdate({commit, dispatch, state}, requestData) {
        commit('setLoading');
        try {
            let url = requestData.id ? '/admin/api-users/' + requestData.id : '/admin/api-users';
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
            return await axios.delete('/admin/api-users/' + requestData.id);
        } catch ({response}) {
            return {data: {error: response.data.message}};
        }
    },
    async sendMail({commit, dispatch, state}, requestData) {
        try {
            return await axios.get('/admin/send-credentials-mail/' + requestData.id);
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
