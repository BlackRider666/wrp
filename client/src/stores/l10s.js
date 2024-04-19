import axios from "axios";
import { defineStore } from "pinia";
export const useLocalesStore = defineStore('locales',{
    state: () => ({
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
    }),
    getters: {
        getActiveLocale: (state) => state.locale,
    },
    actions: {
        async getAllTranslations(langIsoCode) {
            return new Promise(((resolve, reject) => {
                axios.get(`locales?iso_code=${langIsoCode}`)
                    .then((response) => {
                        this.TRANSLATIONS(response.data);
                        resolve(response.data);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            }));
        },
        async createNewTranslationKey(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('locales', {iso_code:this.locale.iso_code,keys:payload})
                    .then((response) => {
                        this.ADD_TRANSLATION_KEY(response.data.keys);
                        resolve(response.data);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            }));
        },
        async getActiveLocales() {
            return new Promise(((resolve, reject) => {
                axios.get(`locales/active`)
                    .then((response) => {
                        this.SET_LOCALES(response.data)
                        resolve(response.data);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            }));
        },
        async setActiveLocale(locale) {
            this.locale = locale;
            localStorage.setItem('activeLocale', JSON.stringify(locale));
        },
        SET_LOCALES(locales) {
            this.locales = locales;
        },
        TRANSLATIONS(translations) {
            let trans = {};
            for (let i = 0; i < translations.length; i++) {
                trans[translations[i].key] = translations[i].value;
            }
            this.translations = trans;
            localStorage.setItem('l10s', JSON.stringify(trans));
        },
        ADD_TRANSLATION_KEY (keys) {
            keys.forEach( key => {
                this.translations[key.key_title] = key.value;
            });
        },
    },
});

