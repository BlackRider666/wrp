import axios from "axios";

const state = {
    grants: [],
    total:0,
    grant:null,
};

const getters = {
    getGrants: (state) => state.grants,
    getGrant: (state) => state.grant,
};

const actions = {
    downloadGrants({commit}, payload) {
        return new Promise(((resolve, reject) => {
            let perPage = payload.itemsPerPage?payload.itemsPerPage:10;
            let page = payload.page?payload.page:1;
            let byUser = payload.user_id?`&user_id=${payload.user_id}`:'';
            let search = `perPage=${perPage}&page=${page}&user_id=${payload.user_id}`;
            axios.get('auth/user/grant?perPage=10'+search+byUser)
                .then(res => {
                    commit("UPDATE_GRANTS", res.data.data);
                    commit("UPDATE_TOTAL", res.data.total);
                    resolve(res.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    createGrant({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('auth/user/grant', payload)
                .then(res => {
                    commit("ADD_GRANT", res.data.grant);
                    resolve(res.data.grant)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    updateGrant({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('auth/user/grant/'+payload.id, payload)
                .then(res => {
                    commit("UPDATE_GRANT", res.data.grant);
                    resolve(res.data.grant)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    deleteGrant({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.delete('auth/user/grant/'+payload)
                .then(res => {
                    commit("REMOVE_GRANT", payload);
                    resolve(res.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
};

const mutations = {
    ADD_GRANT (state, grant) {
        state.grants.push(grant);
        state.total += 1;
    },
    UPDATE_GRANTS (state, grants) {
        state.grants = grants
    },
    UPDATE_TOTAL (state, total) {
        state.total = total
    },
    UPDATE_GRANT (state, grant) {
        let item = state.grants.find((i) => i.id === grant.id)
        item = grant;
        state.grants = [...state.grants.filter( (i) => i.id !== grant.id), item];
    },
    REMOVE_GRANT (state, grant) {
        state.grants = state.grants.filter( (i) => i.id !== grant);
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