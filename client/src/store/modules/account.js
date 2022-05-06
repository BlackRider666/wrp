import axios from "axios";

const state = {
    user: JSON.parse(localStorage.getItem('account')) || {},
    works: [],
    total:0,
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
    downloadWorks({commit}, payload) {
        return new Promise(((resolve, reject) => {
            let perPage = payload.itemsPerPage?payload.itemsPerPage:10;
            let page = payload.page?payload.page:1;
            let search = `perPage=${perPage}&page=${page}`;
            axios.get('auth/user/works?'+search)
                .then(res => {
                    commit("UPDATE_WORKS", res.data.data);
                    commit("UPDATE_TOTAL", res.data.total);
                    resolve(res.data.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    createWork({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('auth/user/works', payload)
                .then(res => {
                    commit("ADD_WORK", res.data.work);
                    resolve(res.data.work)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    updateWork({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('auth/user/works/'+payload.id, payload)
                .then(res => {
                    commit("UPDATE_WORK", res.data.work);
                    resolve(res.data.work)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    deleteWork({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.delete('auth/user/works/'+payload)
                .then(res => {
                    commit("REMOVE_WORK", payload);
                    resolve(res.data)
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
    UPDATE_TOTAL (state, total) {
        state.total = total;
    },
    ADD_WORK (state, work) {
        state.works.push(work);
        state.total += 1;
    },
    UPDATE_WORK (state, work) {
        let item = state.works.find((i) => i.id === work.id)
        item = work;
        state.works = [...state.works.filter( (i) => i.id !== work.id), item];
    },
    REMOVE_WORK (state, id) {
        state.works = state.works.filter( (i) => i.id !== id);
        state.total -= 1;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}