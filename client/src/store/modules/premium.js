import axios from "axios";

const state = {};

const getters = {};

const actions = {
    getFree() {
        return new Promise(((resolve, reject) => {
            axios.get('/get-free-premium')
                .then(res => {
                    resolve(res.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
};

const mutations = {};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
