import axios from "axios";
import {defineStore} from "pinia";

export const usePageStore = defineStore('page',{
    state:() => ({
        page: null,
    }),
    actions: {
        downloadContact() {
            return new Promise(((resolve, reject) => {
                axios.get('contact-info')
                    .then(res => {
                        this.page = res.data.page;
                        resolve(res.data.page)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
    }
})
