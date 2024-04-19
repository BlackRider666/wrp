import axios from "axios";
import {defineStore} from "pinia";

export const useTagStore = defineStore('tag',{
    state:() => ({
        tags: [],
    }),
    actions: {
        downloadTags() {
            return new Promise(((resolve, reject) => {
                axios.get('tags')
                    .then(res => {
                        this.tags = res.data;
                        resolve(res.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
    }
})
