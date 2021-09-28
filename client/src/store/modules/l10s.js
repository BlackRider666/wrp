import axios from "axios";

const state = {
    translations: JSON.parse(localStorage.getItem('l10s')) || [],
    locales:[
        {
            id:1,
            name: 'English',
            iso_code: 'en',
        },
    ],
    locale: localStorage.getItem('activeLocaleCode')
        ||
        {
            id:1,
            name: 'English',
            iso_code: 'en',
        },
};

const getters = {
    translations: () => state.translations,
    locales: () => state.locales,
    getActiveLocale: () => state.locale,
};

const actions = {
    getAllTranslations({ commit }, langIsoCode) {
        return new Promise(((resolve, reject) => {
            axios.get(`locales?iso_code=${langIsoCode}`)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((error) => {
                    reject(error);
                });
        }));
    },
    createNewTranslationKey({ commit }, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('locales', payload)
                .then((response) => {
                    resolve(response.data);
                })
                .catch((error) => {
                    reject(error);
                });
        }));
    },
    getActiveLocales({ commit }) {
        return new Promise(((resolve, reject) => {
            axios.get(`locales/active`)
                .then((response) => {
                    commit('SET_LOCALES', response.data)
                    resolve(response.data);
                })
                .catch((error) => {
                    reject(error);
                });
        }));
    },
};

const mutations = {
    SET_LOCALES(state, locales) {
        state.locales = locales;
    },
    TRANSLATIONS(state, translations) {
        state.translations = translations;
    },
    SET_ACTIVE_LOCALE(state, locale) {
        state.locale = locale;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
