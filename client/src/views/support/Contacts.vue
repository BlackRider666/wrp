<template>
  <v-container>
    <v-row dense v-if="page" justify="center" class="mt-4">
      <v-col cols="12" class="text-h5 font-weight-medium">{{page.title[locale.iso_code]}}</v-col>
      <v-col cols="12" v-html="page.content[locale.iso_code]"></v-col>
    </v-row>
  </v-container>
</template>

<script>
import {mapState} from "vuex";

export default {
  name: "Contacts",
  mounted() {
    this.$store.dispatch('pages/downloadContact');
  },
  computed: {
    ...mapState({
      page: (state) => state.pages.page,
      locale: (state) => state.l10s.locale,
    }),
  },
}
</script>

<style scoped>

</style>
