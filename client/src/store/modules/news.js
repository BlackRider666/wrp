import axios from "axios";

const state = {
    news: [],
};

const getters = {
    getNews: (state) => {
        return state.news
    },
};

const actions = {
    downloadNews({commit}) {
        return new Promise(((resolve, reject) => {
            axios.get('news')
                .then(res => {
                    commit("UPDATE_NEWS", res.data.data);
                    resolve(res.data.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
};

const mutations = {
    UPDATE_NEWS (state, news) {
        state.news = news
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}