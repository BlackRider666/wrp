import axios from "axios";
import {defineStore} from "pinia";

export const usePartnerStore = defineStore('partner',{
    state:() => ({
        partners: [],
        partner: null,
    }),
    getters: {
        getPartners: (state) => state.partners,
    },
    actions: {
        downloadPartners({commit}, payload) {
            return new Promise(((resolve, reject) => {
                let perPage = payload && payload.perPage ? payload.perPage : 10;
                let search = `perPage=${perPage}`;
                axios.get('partners?' + search)
                    .then(res => {
                        this.partners = res.data.data;
                        resolve(res.data.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        getPartner({commit}, id) {
            return new Promise(((resolve, reject) => {
                axios.get('partners/' + id)
                    .then(res => {
                        this.partner = res.data.partner;
                        resolve(res.data.partner)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
    }
})
