import axios from "axios";
import {defineStore} from "pinia";

export const useOrganizerStore = defineStore('organizer',{
    state:() => ({
        organizers: [],
        organizer: null,
    }),
    getters: {
        getOrganizers: (state) => state.organizers,
    },
    actions: {
        downloadOrganizers(payload) {
            return new Promise(((resolve, reject) => {
                let perPage = payload && payload.perPage?payload.perPage:10;
                let search = `perPage=${perPage}`;
                axios.get('organizers?'+search)
                    .then(res => {
                        this.organizers =  res.data.data;
                        resolve(res.data.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        getOrganizer(id) {
            return new Promise(((resolve, reject) => {
                axios.get('organizers/'+id)
                    .then(res => {
                        this.organizer =  res.data.organizer;
                        resolve(res.data.organizer)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
    }
})

