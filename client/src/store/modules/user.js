import axios from "axios";

const state = {
    users: [],
    total: 0,
    user: null,
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
                    commit("UPDATE_TOTAL", res.data.total);
                    resolve(res.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    downloadUser({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.get('users/'+payload)
                .then(res => {
                    commit("UPDATE_USER", res.data.user);
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
    UPDATE_USER (state, user) {
        state.user = user;
    },
    UPDATE_TOTAL (state, total) {
        state.total = total;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}