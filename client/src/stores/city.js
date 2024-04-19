import axios from "axios";
import {defineStore} from "pinia";

export const useCityStore = defineStore('city',{
    state:() => ({
        cities: [],
    }),
    getters: {
        getCities: (state) => state.cities,
    },
    actions: {
        downloadCities() {
            return new Promise(((resolve, reject) => {
                axios.get('cities')
                    .then(res => {
                        this.cities = res.data;
                        resolve(res.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
    }
})
