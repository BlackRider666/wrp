import Vue from 'vue'
import Vuex from 'vuex'
import l10s from './modules/l10s';
import auth from './modules/auth';
import account from './modules/account'
import news from "./modules/news";
import organizer from "./modules/organizer";
import partner from "./modules/partner";
import article from "./modules/article";
import user from "./modules/user";
import organization from "./modules/organization";
import grant from "./modules/account/grant";
import project from "./modules/account/project";
import country from "./modules/country";
import city from "./modules/city";
import premium from "./modules/premium";
import conference from "./modules/conference";
import tutorial from "./modules/tutorial";
import tags from './modules/tags';

const notifier = require('./modules/notifier/index').default;

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        showLoading: false,
    },
    getters: {
    },
    mutations: {
        SET_SHOW_LOADING(store, val) {
            store.showLoading = val;
        },
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
        article,
        user,
        organization,
        l10s,
        grant,
        project,
        country,
        city,
        premium,
        conference,
        tutorial,
        tags,
    }
});

Vue.use(notifier.plugin, store);

export default store
