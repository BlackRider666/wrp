import axios from "axios";
import {defineStore} from "pinia";

export const useUserStore = defineStore('user',{
    state:() => ({
        users: [],
        total: 0,
        user: null,
    }),
    getters: {
        getUsers: (state) => state.users,
    },
    actions: {
        downloadAuthors() {
            return new Promise(((resolve, reject) => {
                axios.get('authors')
                    .then(res => {
                        this.users = res.data;
                        resolve(res.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        downloadUsers (payload) {
            return new Promise(((resolve, reject) => {
                let perPage = payload.perPage||10;
                let page = payload.page ? '&page=' + payload.page : '';
                let byTitle = payload.title ? `&title=${payload.title}` : '';
                let sortBy = payload.sortBy && payload.sortBy[0] ? `&sortBy=${payload.sortBy[0]}` : '';
                let sortDesc = payload.sortDesc && payload.sortDesc[0] ? `&sortDesc=${payload.sortDesc[0]}` : '';
                let search = `perPage=${perPage}${page}${sortBy}${sortDesc}`;
                axios.get('users?'+search + byTitle)
                    .then(res => {
                        this.users = res.data.data;
                        this.total = res.data.total;
                        resolve(res.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        downloadUser(payload) {
            return new Promise(((resolve, reject) => {
                axios.get('users/'+payload)
                    .then(res => {
                        this.user = res.data.user;
                        resolve(res.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        downloadStaff(payload) {
            return new Promise(((resolve, reject) => {
                let search = `organization_id=${payload}&forSelect=true`;
                axios.get('users?'+search)
                    .then(res => {
                        this.users = res.data;
                        resolve(res.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        createUser(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('users',payload)
                    .then(res => {
                        this.users.push(res.data.user);
                        resolve(res.data.user)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        }
    }
})
