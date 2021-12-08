import axios from "axios";

const state = {
    cities: [],
};

const getters = {
    getCities: (state) => {
        return state.cities
    },
};

const actions = {
    downloadCities({commit}) {
        return new Promise(((resolve, reject) => {
            axios.get('cities')
                .then(res => {
                    commit("UPDATE_CITIES", res.data);
                    resolve(res.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
};

const mutations = {
    UPDATE_CITIES (state, cities) {
        state.cities = cities
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
