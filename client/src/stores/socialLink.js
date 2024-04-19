import axios from "axios";
import {defineStore} from "pinia";

export const useSocialLinkStore = defineStore('socialLink',{
    state:() => ({
        links: [],
    }),
    getters: {
        getLinks: (state) => state.links,
    },
    actions: {
        downloadLinks(payload) {
            return new Promise(((resolve, reject) => {
                let perPage = payload && payload.perPage?payload.perPage:10;
                let search = `perPage=${perPage}`;
                axios.get('social-link?'+search)
                    .then(res => {
                        this.links = res.data.data;
                        resolve(res.data.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        create(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('social-link',payload)
                    .then(res => {
                        this.links.push(res.data.link);
                        resolve(res.data.link)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        update(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('social-link/'+payload.id,payload)
                    .then(res => {
                        let link = res.data.link;
                        let item = this.links.find((i) => i.id === link.id)
                        item = link;
                        this.links = [...this.links.filter( (i) => i.id !== link.id), item];
                        resolve(res.data.link)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        delete(payload) {
            return new Promise(((resolve, reject) => {
                axios.delete('social-link/'+payload)
                    .then(res => {
                        this.links = this.links.filter( (i) => i.id !== payload);
                        resolve(res.data.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        }
    }
})
