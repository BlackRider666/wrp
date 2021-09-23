import axios from "axios";

const state = {
    categories: [],
    articles: [],
};

const getters = {
    getCategories: (state) => state.categories,
    getArticles: (state) => state.articles,
};

const actions = {
    downloadCategories({commit}) {
        return new Promise(((resolve, reject) => {
            axios.get('article-categories')
                .then(res => {
                    commit("UPDATE_CATEGORIES", res.data.data);
                    resolve(res.data.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    downloadArticles({commit}) {
        return new Promise(((resolve, reject) => {
            axios.get('article')
                .then(res => {
                    commit("UPDATE_ARTICLES", res.data.data);
                    resolve(res.data.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    createArticle({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('article', payload)
                .then(res => {
                    commit("ADD_ARTICLE", res.data.data);
                    resolve(res.data.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
};

const mutations = {
    UPDATE_CATEGORIES (state, categories) {
        state.categories = categories
    },
    ADD_ARTICLE (state, article) {
        state.articles.push(article);
    },
    UPDATE_ARTICLES (state, articles) {
        state.articles = articles
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}