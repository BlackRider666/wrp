import axios from "axios";

const state = {
    organizers: [],
    organizer: null,
};

const getters = {
    getOrganizers: (state) => {
        return state.organizers
    },
};

const actions = {
    downloadOrganizers({commit}, payload) {
        return new Promise(((resolve, reject) => {
            let perPage = payload && payload.perPage?payload.perPage:10;
            let search = `perPage=${perPage}`;
            axios.get('organizers?'+search)
                .then(res => {
                    commit("UPDATE_ORGANIZERS", res.data.data);
                    resolve(res.data.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    getOrganizer({commit},id) {
        return new Promise(((resolve, reject) => {
            axios.get('organizers/'+id)
                .then(res => {
                    commit("UPDATE_ORGANIZER", res.data.organizer);
                    resolve(res.data.organizer)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
};

const mutations = {
    UPDATE_ORGANIZERS (state, organizers) {
        state.organizers = organizers
    },
    UPDATE_ORGANIZER (state, organizer) {
        state.organizer = organizer
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
