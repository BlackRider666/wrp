import axios from "axios";

const state = {
    organizers: [],
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
};

const mutations = {
    UPDATE_ORGANIZERS (state, organizers) {
        state.organizers = organizers
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}