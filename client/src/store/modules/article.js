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
    updateArticle({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('article/'+payload.id, payload)
                .then(res => {
                    commit("UPDATE_ARTICLE", res.data.article);
                    resolve(res.data.article)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    deleteArticle({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.delete('article/'+payload)
                .then(res => {
                    commit("REMOVE_ARTICLE", payload);
                    resolve(res.data)
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
    UPDATE_ARTICLE (state, article) {
        let item = state.articles.find((i) => i.id === article.id)
        item = article;
        state.articles = [...state.articles.filter( (i) => i.id !== article.id), item];
    },
    REMOVE_ARTICLE (state, article) {
        state.articles = state.articles.filter( (i) => i.id !== article);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}