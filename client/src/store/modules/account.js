import axios from "axios";

const state = {
    user: JSON.parse(localStorage.getItem('account')) || {},
    works: [],
};

const getters = {
    getAccount: (state) => {
        return state.user
    },
};

const actions = {
    downloadAccount({commit}) {
        return new Promise(((resolve, reject) => {
            axios.get('auth/user')
                .then(res => {
                    commit("UPDATE_ACCOUNT", res.data.user);
                    resolve(res.data.user)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    update({commit},payload) {
        return new Promise(((resolve, reject) => {
            axios.post('auth/user/update',payload)
                .then(res => {
                    commit("UPDATE_ACCOUNT", res.data.user);
                    resolve(res.data.user)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    updatePassword({commit},payload) {
        return new Promise(((resolve, reject) => {
            axios.post('auth/user/change-password',payload)
                .then(res => {
                    commit("UPDATE_ACCOUNT", res.data.user);
                    resolve(res.data.user)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    updatePhoto({commit},payload) {
        return new Promise(((resolve, reject) => {
            axios.post('auth/user/update-photo',payload)
                .then(res => {
                    commit("UPDATE_ACCOUNT", res.data.user);
                    resolve(res.data.user)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    downloadWorks({commit}) {
        return new Promise(((resolve, reject) => {
            axios.get('auth/user/works')
                .then(res => {
                    commit("UPDATE_WORKS", res.data.data);
                    resolve(res.data.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    createWork({commit}) {
        return new Promise(((resolve, reject) => {
            axios.post('auth/user/works')
                .then(res => {
                    commit("ADD_WORK", res.data.work);
                    resolve(res.data.work)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
};

const mutations = {
    UPDATE_ACCOUNT (state, account) {
        state.user = account;
        localStorage.setItem('account', JSON.stringify(account));
    },
    UPDATE_WORKS (state, works) {
        state.works = works;
    },
    ADD_WORK (state, work) {
        state.works.push(work);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}