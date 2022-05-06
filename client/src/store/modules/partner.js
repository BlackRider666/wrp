import axios from "axios";

const state = {
    partners: [],
};

const getters = {
    getPartners: (state) => {
        return state.partners
    },
};

const actions = {
    downloadPartners({commit}) {
        return new Promise(((resolve, reject) => {
            axios.get('partners')
                .then(res => {
                    commit("UPDATE_PARTNERS", res.data.data);
                    resolve(res.data.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
};

const mutations = {
    UPDATE_PARTNERS(state, partners) {
        state.partners = partners
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}