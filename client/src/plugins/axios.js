import axios from 'axios';
import { createPinia, setActivePinia } from 'pinia';
import router from '../router';
import { useAuthStore } from '@/stores/auth';

const baseURL = import.meta.env.VITE_API_BASE_URL;
axios.defaults.baseURL = baseURL;
const pinia = createPinia();
setActivePinia(pinia);

axios.interceptors.request.use(config => {
    const authStore = useAuthStore();

    config.headers = config.headers || {};
    config.headers.common = config.headers.common || {};

    config.headers['X-Requested-With'] = 'XMLHttpRequest';
    config.headers['Accept'] = 'application/json';

    const token = authStore.token;
    if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
    }

    return config;
}, error => Promise.reject(error));


axios.interceptors.response.use(response => response, error => {
    const authStore = useAuthStore();
    if (error.response) {
        const status = error.response.status;
        switch (status) {
            case 401:
                authStore.clearAuthToken();
                if (router.currentRoute.value.name !== 'login') {
                    router.push({ name: 'login' });
                }
                break;
            case 403:
                router.push({ name: 'error-403' });
                break;
            case 429:
                alert('Too many requests');
                break;
        }
    }
    return Promise.reject(error);
});

export default axios;
