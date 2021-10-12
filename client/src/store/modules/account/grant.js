import axios from "axios";

const state = {
    grants: [],
    grant:null,
};

const getters = {
    getGrants: (state) => state.grants,
    getGrant: (state) => state.grant,
};

const actions = {
    downloadGrants({commit}, payload) {
        return new Promise(((resolve, reject) => {
            let search = `&user_id=${payload.user_id}`;
            axios.get('auth/user/grant?perPage=10'+search)
                .then(res => {
                    commit("UPDATE_GRANTS", res.data.data);
                    resolve(res.data.data)
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
    },
    UPDATE_GRANTS (state, grants) {
        state.grants = grants
    },
    UPDATE_GRANT (state, grant) {
        let item = state.grants.find((i) => i.id === grant.id)
        item = grant;
        state.grants = [...state.grants.filter( (i) => i.id !== grant.id), item];
    },
    REMOVE_GRANT (state, grant) {
        state.grants = state.grants.filter( (i) => i.id !== grant);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}