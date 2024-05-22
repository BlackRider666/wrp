<template>
  <v-dialog
      :model-value="deleteDialog"
      @update:model-value="closeDialog"
      max-width="300"
  >
    <v-card v-if="item">
      <v-card-title class="text-h5">
        Delete {{item.name}}
      </v-card-title>
      <v-card-text>
        You really want to delete {{item.name}} ?
      </v-card-text>
      <v-card-actions>
        <v-btn
            color="darken-1"
            variant="text"
            @click="closeDialog"
        >
          No
        </v-btn>
        <v-spacer/>
        <v-btn
            color="error"
            variant="text"
            @click="deleteItem(item)"
        >
          Yes
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import {mapActions} from "pinia";
import {useOrganizationStore} from "../../../stores/organization";

export default {
  name: "DeleteDialog",
  props: {
    deleteDialog: {
      type: Boolean,
      default: false,
    },
    item: {
      type: Object,
      default: null,
    }
  },
  methods: {
    deleteItem(item) {
      this.$loading();
      this.deleteStructureUnit(item)
          .then(() => {
            this.$loadingClose();
            this.$notify('', 'success', this.$t('messages.success', 'Success'));
            this.closeDialog();
          })
          .catch(() => {
            this.$loadingClose();
            this.$notify('', 'error', this.$t('messages.error', 'Error'));
          });
      this.$emit('closeDialog');
    },
    closeDialog() {
      this.$emit('closeDialog');
    },
    ...mapActions(useOrganizationStore,['deleteStructureUnit']),
  }
}
</script>

<style scoped>

</style>
