import axios from "axios";

const state = {
    users: [],
};

const getters = {
    getUsers: (state) => state.users,
};

const actions = {
    downloadAuthors({commit}) {
        return new Promise(((resolve, reject) => {
            axios.get('authors')
                .then(res => {
                    commit("UPDATE_USERS", res.data.data);
                    resolve(res.data.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    downloadUsers ({commit}, payload) {
        return new Promise(((resolve, reject) => {
            let perPage = payload.itemsPerPage?payload.itemsPerPage:10;
            let page = payload.page?payload.page:1;
            let search = `perPage=${perPage}&page=${page}&title=${payload.title}&sortBy=${payload.sortBy}&sortDesc=${payload.sortDesc}`;
            axios.get('users?'+search)
                .then(res => {
                    commit("UPDATE_USERS", res.data.data);
                    resolve(res.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
};

const mutations = {
    UPDATE_USERS (state, users) {
        state.users = users
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}