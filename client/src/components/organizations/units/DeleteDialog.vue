<template>
  <v-dialog
      :value="deleteDialog"
      @input="closeDialog"
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
            color="red darken-1"
            text
            @click="deleteItem(item)"
        >
          Yes
        </v-btn>
        <v-spacer/>
        <v-btn
            color="darken-1"
            text
            @click="closeDialog"
        >
          No
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
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
      this.$store.dispatch('organization/deleteStructureUnit',item);
      this.$emit('closeDialog');
    },
    closeDialog() {
      this.$emit('closeDialog');
    }
  }
}
</script>

<style scoped>

</style>
