import axios from "axios";

const state = {
    tags: [],
};

const getters = {
    getTags: (state) => {
        return state.tags
    },
};

const actions = {
    downloadTags({commit}) {
        return new Promise(((resolve, reject) => {
            axios.get('tags')
                .then(res => {
                    commit("UPDATE_TAGS", res.data);
                    resolve(res.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
};

const mutations = {
    UPDATE_TAGS (state, tags) {
        state.tags = tags
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}