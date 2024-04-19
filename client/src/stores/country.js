import axios from "axios";
import {defineStore} from "pinia";

export const useCountryStore = defineStore('country',{
    state:() => ({
        countries: [],
    }),
    getters: {
        getCountries: (state) => state.countries,
    },
    actions: {
        downloadCountries() {
            return new Promise(((resolve, reject) => {
                axios.get('countries')
                    .then(res => {
                        this.countries = res.data;
                        resolve(res.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
    }
})
