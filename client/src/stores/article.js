import axios from "@/plugins/axios";
import {defineStore} from "pinia";

export const useArticleStore = defineStore('article',{
    state:() => ({
        categories: [],
        directions: [],
        articles: [],
        article:null,
        total:0,
    }),
    actions: {
        downloadCategories() {
            return new Promise(((resolve, reject) => {
                axios.get('article-categories')
                    .then(res => {
                        this.UPDATE_CATEGORIES(res.data.data);
                        resolve(res.data.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        downloadArticles(payload) {
            return new Promise(((resolve, reject) => {
                let perPage = payload.perPage || 10;
                let page = payload.page ? '&page=' + payload.page : '';
                let byUser = payload.user_id ? `&user_id=${payload.user_id}` : '';
                let byTitle = payload.title ? `&title=${payload.title}` : '';
                let country = payload.country_id ? `&country_id=${payload.country_id}` : '';
                let city = payload.city_id ? `&city_id=${payload.city_id}` : '';
                let sortBy = payload.sortBy && payload.sortBy[0] ? `&sortBy=${payload.sortBy[0]}` : '';
                let sortDesc = payload.sortDesc && payload.sortDesc[0] ? `&sortDesc=${payload.sortDesc[0]}` : '';
                let search = `perPage=${perPage}${page}${sortBy}${sortDesc}`;
                let NonApproved = payload.nonApproved ? '&nonApproved=1' : '';
                let byCategoryName = payload.category_name ? '&category_name=' + payload.category_name : '';
                let byDirection = payload.direction_id? `&direction_id=${payload.direction_id}` : '';
                let byConference = payload.conference_id ? '&conference_id='+payload.conference_id : '';
                axios.get('article?' + search + byUser + byTitle + country + city + NonApproved + byCategoryName + byConference + byDirection)
                    .then(res => {
                        this.UPDATE_ARTICLES(res.data.data);
                        this.UPDATE_TOTAL(res.data.meta.total);
                        resolve(res.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        createArticle(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('article', payload)
                    .then(res => {
                        this.ADD_ARTICLE(res.data.data);
                        resolve(res.data.article)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        updateArticle(id,payload) {
            return new Promise(((resolve, reject) => {
                axios.post('article/' + id, payload)
                    .then(res => {
                        this.UPDATE_ARTICLE(res.data.data);
                        resolve(res.data.article)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        deleteArticle(payload) {
            return new Promise(((resolve, reject) => {
                axios.delete('article/' + payload)
                    .then(res => {
                        this.REMOVE_ARTICLE(payload);
                        resolve(res.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        getArticle(payload) {
            return new Promise(((resolve, reject) => {
                axios.get('article/' + payload)
                    .then(res => {
                        this.CHOOSE_ARTICLE(res.data.article);
                        resolve(res.data.article)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        approveAuthor(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('article/' + payload + '/approve')
                    .then(res => {
                        resolve(res.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        searchForSelect(payload) {
            return new Promise(((resolve, reject) => {
                axios.get('article?q=' + payload + '&forSelect=1')
                    .then(res => {
                        this.UPDATE_ARTICLES(res.data.data)
                        resolve(res.data.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        downloadDirections() {
            return new Promise(((resolve, reject) => {
                axios.get('article-directions')
                    .then(res => {
                        this.directions = res.data.data;
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }));
        },
        UPDATE_CATEGORIES(categories) {
            this.categories = categories
        },
        ADD_ARTICLE(article) {
            this.articles.push(article);
            this.total += 1;
        },
        UPDATE_ARTICLES(articles) {
            this.articles = articles
        },
        UPDATE_TOTAL(total) {
            this.total = total;
        },
        UPDATE_ARTICLE(article) {
            let item = this.articles.find((i) => i.id === article.id)
            item = article;
            this.articles = [...this.articles.filter((i) => i.id !== article.id), item];
        },
        REMOVE_ARTICLE(article) {
            this.articles = this.articles.filter((i) => i.id !== article);
            this.total -= 1;
        },
        CHOOSE_ARTICLE(article) {
            this.article = article;
        },
    },
})
