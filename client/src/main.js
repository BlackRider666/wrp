import { createApp } from 'vue';
import { createPinia } from "pinia";
import App from './App.vue';
import router from './router';
import vuetify from './plugins/vuetify';
import './plugins/axios';
import loading from './plugins/loading';
import l10s from './plugins/l10s';
import FlagIcon from 'vue-flag-icon';
import Notifier from "@/plugins/notifier";

const pinia = createPinia();
const app = createApp(App)

app.use(pinia);
app.use(l10s);
app.use(loading);
app.use(FlagIcon);
app.use(router)
app.use(vuetify)
app.use(Notifier)
app.mount('#app');
