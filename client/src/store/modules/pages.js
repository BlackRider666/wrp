import axios from "axios";

const state = {
    page: null,
};

const getters = {
    getPage: (state) => state.page,
};

const actions = {
    downloadContact({commit}) {
        return new Promise(((resolve, reject) => {
            axios.get('contact-info')
                .then(res => {
                    commit("UPDATE_PAGE", res.data.page);
                    resolve(res.data.page)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
};

const mutations = {
    UPDATE_PAGE (state, page) {
        state.page = page
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
