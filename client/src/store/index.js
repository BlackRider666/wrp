import Vue from 'vue'
import Vuex from 'vuex'
import i18n from '@/plugins/i18n/i18n';
import auth from './modules/auth';
import account from './modules/account'
import news from "./modules/news";
import organizer from "./modules/organizer";
import partner from "./modules/partner";

const notifier = require('./modules/notifier/index').default;

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        showLoading: false,
        activeLangCode: i18n.locale,
        locales: [
            {
                titleTKey: 'ukrainian',
                flag: 'ua',
                iso: 'ua'
            },
            {
                titleTKey: 'english',
                flag: 'us',
                iso: 'us'
            }
        ],
    },
    getters: {
        getActiveLanguage: (state) => {
            return state.locales.find(item => item.iso === state.activeLangCode)
        }
    },
    mutations: {
        SET_SHOW_LOADING(store, val) {
            store.showLoading = val;
        },
        SET_ACTIVE_LANGUAGE(state, language) {
            localStorage.setItem('activeLocaleCode', language.iso);
            state.activeLocaleCode = language.iso;
            i18n.locale = language.iso;
        }
    },
    actions: {
    },
    modules: {
        notifier: notifier.store,
        auth,
        account,
        news,
        organizer,
        partner,
    }
});

Vue.use(notifier.plugin, store);

export default store
