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
    downloadOrganizers({commit}) {
        return new Promise(((resolve, reject) => {
            axios.get('organizers')
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