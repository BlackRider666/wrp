import axios from "axios";
import {defineStore} from "pinia";

export const useAuthStore = defineStore('auth',{
    state:() => ({
        token: localStorage.getItem('token') || '',
    }),
    getters: {
        getAuthToken: (state) => state.token,
    },
    actions: {
        async login( payload) {
            return new Promise(((resolve, reject) => {
                axios.post('auth/login', payload)
                    .then(res => {
                        this.setAuthToken(res.data.token);
                        resolve(res.data.token)
                    })
                    .catch(errors => {
                        reject(errors)
                    })
            }))
        },
        async register(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('auth/register', payload)
                    .then(res => {
                        resolve(res.data.token)
                    })
                    .catch(errors => {
                        reject(errors)
                    })
            }))
        },
        async verifyRegister(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('auth/register-confirm', payload)
                    .then(res => {
                        console.log(res.data.token)
                        this.setAuthToken(res.data.token);
                        console.log(this.token);
                        resolve(res.data.token)
                    })
                    .catch(errors => {
                        reject(errors)
                    })
            }))
        },
        async logout() {
            return new Promise(((resolve, reject) => {
                axios.post('/auth/logout')
                    .then(res => {
                        this.clearAuthToken();
                        resolve(res.data)
                    })
                    .catch(errors => {
                        this.clearAuthToken();
                        reject(errors)
                    })
            }))
        },
        clearAuthToken () {
            this.token = '';
            localStorage.removeItem('token');
            localStorage.removeItem('account');
        },
        setAuthToken(token) {
            this.token = token;
            localStorage.setItem('token', token);
        },
    },
});
