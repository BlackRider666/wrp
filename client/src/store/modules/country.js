import axios from "axios";

const state = {
    countries: [],
};

const getters = {
    getCountries: (state) => {
        return state.countries
    },
};

const actions = {
    downloadCountries({commit}) {
        return new Promise(((resolve, reject) => {
            axios.get('countries')
                .then(res => {
                    commit("UPDATE_COUNTRIES", res.data);
                    resolve(res.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
};

const mutations = {
    UPDATE_COUNTRIES (state, countries) {
        state.countries = countries
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
