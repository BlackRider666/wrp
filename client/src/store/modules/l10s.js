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
    locale: JSON.parse(localStorage.getItem('activeLocale'))
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
                    commit('TRANSLATIONS', response.data);
                    resolve(response.data);
                })
                .catch((error) => {
                    reject(error);
                });
        }));
    },
    createNewTranslationKey({ commit,state }, payload) {
        // console.log({message:'store',payload});
        return new Promise(((resolve, reject) => {
            axios.post('locales', {iso_code:state.locale.iso_code,keys:payload})
                .then((response) => {
                    commit('ADD_TRANSLATION_KEY', response.data.keys);
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
    setActiveLocale({ commit }, payload) {
        commit('SET_ACTIVE_LOCALE', payload)
    },
};

const mutations = {
    SET_LOCALES(state, locales) {
        state.locales = locales;
    },
    TRANSLATIONS(state, translations) {
        let trans = {};
        for (let i = 0; i < translations.length; i++) {
            trans[translations[i].key] = translations[i].value;
        }
        state.translations = trans;
        localStorage.setItem('l10s', JSON.stringify(trans));
    },
    ADD_TRANSLATION_KEY (state, keys) {
        keys.forEach( key => {
            state.translations[key.key_title] = key.value;
        });
    },
    SET_ACTIVE_LOCALE(state, locale) {
        state.locale = locale;
        localStorage.setItem('activeLocale', JSON.stringify(locale));
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
