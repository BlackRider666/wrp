<template>
  <v-app>
    <v-dialog content-class="loading" transition="0" v-model="showLoading" fullscreen>
      <Loading/>
    </v-dialog>
    <notification-snackbar/>
    <router-view></router-view>
<!--    <TutorialModal/>-->
  </v-app>
</template>

<script>
import Loading from "./components/loading/Loading.vue";
import NotificationSnackbar from "./components/notification/Notification.vue";
import {mapActions, mapState} from "pinia";
import {useLocalesStore} from "@/stores/l10s";
import {useMainStore} from "@/stores";
import {useAuthStore} from "@/stores/auth";
import {useAccountStore} from "@/stores/account";
export default {
  name: 'App',
  components: {NotificationSnackbar, Loading},
  data: function() {
    return {}
  },
  created() {
    this.getActiveLocales();
    if (this.isLoggedIn) this.downloadAccount();
    this.updateTranslations();
  },
  computed: {
    ...mapState(useLocalesStore,['locale']),
    ...mapState(useAuthStore,['token']),
    ...mapState(useMainStore,['showLoading']),
    isLoggedIn() {
      return this.token.length > 0;
    },
  },
  watch: {
    locale: function () {
      this.updateTranslations();
    },
  },
  methods: {
    updateTranslations(){
      this.getAllTranslations(this.locale.iso_code)
    },
    ...mapActions(useLocalesStore,['getActiveLocales','getAllTranslations']),
    ...mapActions(useAccountStore,['downloadAccount'])
  },
};
</script>
