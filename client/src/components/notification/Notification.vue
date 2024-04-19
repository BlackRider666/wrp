<template>
  <div class="text-center">
    <v-snackbar multi-line location="bottom end" :timeout="timeout" :model-value="show" @update:model-value="updateShow" :color="color">
      <template v-if="contentTKey">
        <div>{{$t(contentTKey)}}</div>
      </template>
      <template v-if="content">
        <div>{{ content }}</div>
      </template>
      <v-btn dark variant="text" @click="closeMessage">{{ $t('btn.close', 'Close') }}</v-btn>
    </v-snackbar>
  </div>
</template>

<script>
import {useNotifierStore} from "@/stores/notifier";
import {mapActions, mapState} from "pinia";

export default {
  name: "Notification",
  computed: {
    ...mapState(useNotifierStore,['show','color','contentTKey','content','options']),
    timeout: function () {
      return "timeout" in this.options ? this.options.timeout : 10000;
    },
  },
  methods: {
    ...mapActions(useNotifierStore,['closeMessage']),
    updateShow(val) {
      if (!val) {
        this.closeMessage();
      }
    }
  }
}
</script>

<style scoped>

</style>
