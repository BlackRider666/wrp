<template>
  <v-app>
    <v-dialog content-class="loading" transition="0" v-model="$store.state.showLoading" fullscreen>
      <Loading/>
    </v-dialog>
    <notification-snackbar/>
    <router-view></router-view>
  </v-app>
</template>

<script>
import Loading from "./components/loading/Loading";
import NotificationSnackbar from "./components/notification/Notification";

export default {
  name: 'App',
  components: {NotificationSnackbar, Loading},
  data: function() {
    return {}
  },
  beforeCreate() {
    this.$store.dispatch('l10s/getActiveLocales');
    this.$store.dispatch('l10s/getAllTranslations', this.$store.getters['l10s/getActiveLocale'].iso_code)
        .then((result) => {
          this.l10s.setAllTranslations(result);
        });
    this.l10s.onUntranslatedKeyFound((key, value) => {
      this.$store.dispatch('l10s/createNewTranslationKey', {
        key,
        value,
        iso_code: this.$store.getters['l10s/getActiveLocale'].iso_code,
      });
    });
  },
  methods: {
  },
};
</script>
