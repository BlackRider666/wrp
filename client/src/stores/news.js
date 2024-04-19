import axios from "axios";
import {defineStore} from "pinia";


export const useNewsStore = defineStore('news',{
    state: () => ({
        news: [],
    }),
    getters: {
        getNews: (state) => state.news,
    },
    actions: {
        downloadNews(payload) {
            return new Promise(((resolve, reject) => {
                let perPage = payload && payload.perPage?payload.perPage:10;
                let search = `perPage=${perPage}`;
                axios.get('news?'+search)
                    .then(res => {
                        this.news = res.data.data;
                        resolve(res.data.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
    }
})
