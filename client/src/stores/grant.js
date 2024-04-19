import axios from "axios";
import {defineStore} from "pinia";
import {useAccountStore} from "@/stores/account";

export const useGrantStore = defineStore('grant',{
    state:() => ({
        grants: [],
        total:0,
        grant:null,
    }),
    getters: {
        getGrants: (state) => state.grants,
        getGrant: (state) => state.grant,
    },
    actions: {
        downloadGrants(payload) {
            return new Promise(((resolve, reject) => {
                let perPage = payload.itemsPerPage?payload.itemsPerPage:10;
                let page = payload.page?payload.page:1;
                let byUser = payload.user_id?`&user_id=${payload.user_id}`:'';
                let search = `perPage=${perPage}&page=${page}&user_id=${payload.user_id}`;
                axios.get('auth/user/grant?perPage=10'+search+byUser)
                    .then(res => {
                        this.UPDATE_GRANTS(res.data.data);
                        this.UPDATE_TOTAL(res.data.total);
                        resolve(res.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        createGrant(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('auth/user/grant', payload)
                    .then(res => {
                        this.ADD_GRANT(res.data.grant);
                        useAccountStore().getOccupancyAccount();
                        resolve(res.data.grant)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        updateGrant(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('auth/user/grant/'+payload.id, payload)
                    .then(res => {
                        this.UPDATE_GRANT(res.data.grant);
                        resolve(res.data.grant)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        deleteGrant(payload) {
            return new Promise(((resolve, reject) => {
                axios.delete('auth/user/grant/'+payload)
                    .then(res => {
                        this.REMOVE_GRANT(payload);
                        useAccountStore().getOccupancyAccount();
                        resolve(res.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        ADD_GRANT (grant) {
            this.grants.push(grant);
            this.total += 1;
        },
        UPDATE_GRANTS (grants) {
            this.grants = grants
        },
        UPDATE_TOTAL (total) {
            this.total = total
        },
        UPDATE_GRANT (grant) {
            let item = this.grants.find((i) => i.id === grant.id)
            item = grant;
            this.grants = [...this.grants.filter( (i) => i.id !== grant.id), item];
        },
        REMOVE_GRANT (grant) {
            this.grants = this.grants.filter( (i) => i.id !== grant);
            this.total -= 1;
        },
    }
})
