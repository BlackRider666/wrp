import axios from "axios";
import {defineStore} from "pinia";

export const useConferenceStore = defineStore('conference',{
    state:() => ({
        conferences: [],
        conference:null,
        total:0,
    }),
    actions: {
        downloadConferences(payload) {
            return new Promise(((resolve, reject) => {
                let perPage = payload.perPage || 10;
                let page = payload.page || 1;
                let byUser = payload.user_id ? `&user_id=${payload.user_id}` : '';
                let byTitle = payload.title ? `&title=${payload.title}` : '';
                let country = payload.country_id ? `&country_id=${payload.country_id}` : '';
                let city = payload.city_id ? `&city_id=${payload.city_id}` : '';
                let sortBy = payload.sortBy ? `&sortBy=${payload.sortBy}` : '';
                let sortDesc = payload.sortDesc ? `&sortDesc=${payload.sortDesc}` : '';
                let search = `perPage=${perPage}&page=${page}${sortBy}${sortDesc}${byUser}${byTitle}${country}${city}`;
                axios.get(`conference?${search}`)
                    .then(res => {
                        this.conferences = res.data.data;
                        this.total = res.data.meta.total;
                        resolve(res.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        createConference(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('conference', payload)
                    .then(res => {
                        this.conferences.push(res.data.data);
                        this.total += 1;
                        resolve(res.data.conference)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        updateConference(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('conference/'+payload.id, payload)
                    .then(res => {
                        this.UPDATE_CONFERENCE(res.data.data);
                        resolve(res.data.conference)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        deleteConference(payload) {
            return new Promise(((resolve, reject) => {
                axios.delete('conference/'+payload)
                    .then(res => {
                        this.conferences = this.conferences.filter( (i) => i.id !== payload);
                        this.total -= 1;
                        resolve(res.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        getConference(payload) {
            return new Promise(((resolve, reject) => {
                axios.get('conference/'+payload)
                    .then(res => {
                        this.conference = res.data.conference;
                        resolve(res.data.conference)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        addArticle(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('conference/add-article/'+payload.conference_id, payload)
                    .then(res => {
                        this.conference = res.data.conference;
                        resolve(res.data.conference)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        addOrgCommittee(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('conference/add-org-committee/'+payload.id, payload)
                    .then(res => {
                        this.conference = res.data.conference;
                        resolve(res.data.conference)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        deleteOrgCommittee( payload) {
            return new Promise(((resolve, reject) => {
                axios.post('conference/remove-org-committee/'+payload.id, payload)
                    .then(res => {
                        this.conference = res.data.conference;
                        resolve(res.data.conference)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        addEditors(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('conference/add-editors/'+payload.id, payload)
                    .then(res => {
                        this.conference = res.data.conference;
                        resolve(res.data.conference)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        deleteEditors(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('conference/remove-editors/'+payload.id, payload)
                    .then(res => {
                        this.conference = res.data.conference;
                        resolve(res.data.conference)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        UPDATE_CONFERENCE (conference) {
            let item = this.conferences.find((i) => i.id === conference.id)
            item = conference;
            this.conferences = [...this.conferences.filter( (i) => i.id !== conference.id), item];
        },
    }
})
