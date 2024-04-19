import axios from "axios";
import {defineStore} from "pinia";

export const useAccountStore = defineStore('account',{
    state: () => ({
        user: JSON.parse(localStorage.getItem('account')) || {},
        works: [],
        total:0,
        occupancy: [],
    }),
    getters: {
        getAccount: (state) => state.user,
    },
    actions: {
        async downloadAccount() {
            return new Promise(((resolve, reject) => {
                axios.get('auth/user')
                    .then(res => {
                        this.UPDATE_ACCOUNT(res.data.user);
                        resolve(res.data.user)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        async update(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('auth/user/update',payload)
                    .then(res => {
                        this.UPDATE_ACCOUNT(res.data.user);
                        this.getOccupancyAccount();
                        resolve(res.data.user)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        async updatePassword(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('auth/user/change-password',payload)
                    .then(res => {
                        this.UPDATE_ACCOUNT(res.data.user);
                        resolve(res.data.user)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        async updatePhoto(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('auth/user/update-photo',payload)
                    .then(res => {
                        this.UPDATE_ACCOUNT(res.data.user);
                        this.getOccupancyAccount();
                        resolve(res.data.user)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        async downloadWorks(payload) {
            return new Promise(((resolve, reject) => {
                let perPage = payload.itemsPerPage?payload.itemsPerPage:10;
                let page = payload.page?payload.page:1;
                let search = `perPage=${perPage}&page=${page}`;
                axios.get('auth/user/works?'+search)
                    .then(res => {
                        this.UPDATE_WORKS(res.data.data);
                        this.UPDATE_TOTAL(res.data.total);
                        resolve(res.data.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        async createWork(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('auth/user/works', payload)
                    .then(res => {
                        this.ADD_WORK(res.data.work);
                        this.getOccupancyAccount();
                        resolve(res.data.work)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        async updateWork(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('auth/user/works/'+payload.id, payload)
                    .then(res => {
                        this.UPDATE_WORK(res.data.work);
                        resolve(res.data.work)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        async deleteWork(payload) {
            return new Promise(((resolve, reject) => {
                axios.delete('auth/user/works/'+payload)
                    .then(res => {
                        this.REMOVE_WORK(payload);
                        this.getOccupancyAccount();
                        resolve(res.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        async getOccupancyAccount(payload) {
            return new Promise(((resolve, reject) => {
                let id = payload?payload:this.user.id;
                axios.get('users/'+id+'/statistics')
                    .then(res => {
                        this.UPDATE_OCCUPANCY(res.data);
                        resolve(res.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        UPDATE_ACCOUNT (account) {
            this.user = account;
            localStorage.setItem('account', JSON.stringify(account));
        },
        UPDATE_WORKS (works) {
            this.works = works;
        },
        UPDATE_TOTAL (total) {
            this.total = total;
        },
        ADD_WORK (work) {
            this.works.push(work);
            this.total += 1;
        },
        UPDATE_WORK (work) {
            let item = this.works.find((i) => i.id === work.id)
            item = work;
            this.works = [...this.works.filter( (i) => i.id !== work.id), item];
        },
        REMOVE_WORK (id) {
            this.works = this.works.filter( (i) => i.id !== id);
            this.total -= 1;
        },
        UPDATE_OCCUPANCY (occupancy) {
            this.occupancy = occupancy;
        }
    }
});
