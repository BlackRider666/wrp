import axios from "axios";

const state = {
    categories: [],
    articles: [],
    article:null,
    total:0,
};

const getters = {
    getCategories: (state) => state.categories,
    getArticles: (state) => state.articles,
    getArticle: (state) => state.article,
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
    downloadArticles({commit}, payload) {
        return new Promise(((resolve, reject) => {
            let perPage = payload.itemsPerPage?payload.itemsPerPage:10;
            let page = payload.page?'&page='+payload.page:'';
            let byUser = payload.user_id?`&user_id=${payload.user_id}`:''
            let byTitle = payload.title?`&title=${payload.title}`:''
            let country = payload.country_id?`&country_id=${payload.country_id}`:'';
            let city = payload.city_id?`&city_id=${payload.city_id}`:'';
            let sortBy = payload.sortBy[0]?`&sortBy=${payload.sortBy[0]}`:''
            let sortDesc = payload.sortDesc[0]?`&sortDesc=${payload.sortDesc[0]}`:''
            let search = `perPage=${perPage}${page}${sortBy}${sortDesc}`;
            let NonApproved = payload.nonApproved?'&nonApproved=1':'';
            let byCategoryName = payload.category_name?'&category_name='+payload.category_name:'';
            axios.get('article?'+search+byUser+byTitle+country+city+NonApproved+byCategoryName)
                .then(res => {
                    commit("UPDATE_ARTICLES", res.data.data);
                    commit("UPDATE_TOTAL", res.data.total);
                    resolve(res.data)
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
                    commit("ADD_ARTICLE", res.data.article);
                    resolve(res.data.article)
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
    getArticle({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.get('article/'+payload)
                .then(res => {
                    commit("CHOOSE_ARTICLE", res.data.article);
                    resolve(res.data.article)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    // eslint-disable-next-line no-empty-pattern
    approveAuthor({},payload) {
        return new Promise(((resolve, reject) => {
            axios.post('article/'+payload+'/approve')
                .then(res => {
                    resolve(res.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    searchForSelect({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.get('article?q='+payload+'&forSelect=1')
                .then(res => {
                    resolve(res.data.data)
                    commit('UPDATE_ARTICLES', res.data.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    }
};

const mutations = {
    UPDATE_CATEGORIES (state, categories) {
        state.categories = categories
    },
    ADD_ARTICLE (state, article) {
        state.articles.push(article);
        state.total += 1;
    },
    UPDATE_ARTICLES (state, articles) {
        state.articles = articles
    },
    UPDATE_TOTAL (state, total) {
        state.total = total;
    },
    UPDATE_ARTICLE (state, article) {
        let item = state.articles.find((i) => i.id === article.id)
        item = article;
        state.articles = [...state.articles.filter( (i) => i.id !== article.id), item];
    },
    REMOVE_ARTICLE (state, article) {
        state.articles = state.articles.filter( (i) => i.id !== article);
        state.total -= 1;
    },
    CHOOSE_ARTICLE (state, article) {
        state.article = article;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
