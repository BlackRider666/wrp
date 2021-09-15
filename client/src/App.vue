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
  methods: {
  },
};
</script>
