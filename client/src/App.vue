<template>
  <v-app>
    <v-dialog content-class="loading" transition="0" v-model="$store.state.showLoading" fullscreen>
      <Loading/>
    </v-dialog>
    <notification-snackbar/>
    <router-view></router-view>
    <TutorialModal/>
  </v-app>
</template>

<script>
import Loading from "./components/loading/Loading";
import NotificationSnackbar from "./components/notification/Notification";
import {mapState} from "vuex";
import TutorialModal from "./components/partials/TutorialModal";

export default {
  name: 'App',
  components: {TutorialModal, NotificationSnackbar, Loading},
  data: function() {
    return {}
  },
  created() {
    this.$store.dispatch('l10s/getActiveLocales');
    if (this.isLoggedIn) this.$store.dispatch('account/downloadAccount');
    this.updateTranslations();
  },
  computed: {
    ...mapState({
      locale: (state) => state.l10s.locale,
    }),
    isLoggedIn() {
      return this.$store.getters['auth/getAuthToken'].length > 0;
    },
  },
  watch: {
    locale: function () {
      this.updateTranslations();
    },
  },
  methods: {
    updateTranslations(){
      this.$store.dispatch('l10s/getAllTranslations', this.$store.getters['l10s/getActiveLocale'].iso_code)
          .then(() => {
            // this.l10s.onUntranslatedKeyFound((key, value) => {
            //   // this.$store.dispatch('l10s/createNewTranslationKey', {
            //   //   key,
            //   //   value,
            //   //   iso_code: this.$store.getters['l10s/getActiveLocale'].iso_code,
            //   // });
            //   // this.untranslated.push({key,value,iso_code: this.$store.getters['l10s/getActiveLocale'].iso_code})
            // })
          });
    }
  },
};
</script>
