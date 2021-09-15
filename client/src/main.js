import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import vuetify from './plugins/vuetify';
import './plugins/axios';
import loading from './plugins/loading';
import VueI18n from "vue-i18n";
import i18n from './plugins/i18n/i18n';
import FlagIcon from 'vue-flag-icon';

Vue.use(VueI18n);
Vue.use(loading);
Vue.use(FlagIcon);

Vue.config.productionTip = false;

new Vue({
  router,
  store,
  i18n,
  vuetify,
  render: (h) => h(App),
}).$mount('#app');
