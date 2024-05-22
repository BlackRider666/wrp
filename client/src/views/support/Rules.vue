<template>
  <v-container>
    <v-row dense v-if="page" justify="center" class="mt-4">
      <v-col cols="12" class="text-h5 font-weight-medium">{{page.title[locale.iso_code]}}</v-col>
      <v-col cols="12" v-html="page.content[locale.iso_code]"></v-col>
    </v-row>
  </v-container>
</template>

<script>
import {mapActions, mapState} from "pinia";
import {useLocalesStore} from "@/stores/l10s";
import {usePageStore} from "@/stores/pages";

export default {
  name: "Rules",
  mounted() {
    this.downloadRulesAndCondition();
  },
  computed: {
    ...mapState(usePageStore,['page']),
    ...mapState(useLocalesStore,['locale']),
  },
  methods: {
    ...mapActions(usePageStore,['downloadRulesAndCondition'])
  }
}
</script>

<style scoped>

</style>
