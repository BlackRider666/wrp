<template>
  <v-dialog
      :model-value="createDialog"
      @update:model-value="closeDialog"
      max-width="600"
      persistent
  >
    <v-form ref="createDialogForm" @submit.prevent="createItem">
      <v-card>
        <v-card-title class="text-h5">
          Create unit
        </v-card-title>
        <v-card-text>
          <v-text-field
              v-model="form.name"
              :label="$t('units.placeholder.name','Name')"
              variant="outlined"
              prepend-inner-icon="mdi-card-text-outline"
              :rules="[rules.required]"
          />
          <v-select
              v-model="form.parent_id"
              :label="$t('units.placeholder.parent_id','Parent')"
              variant="outlined"
              prepend-inner-icon="mdi-shape-outline"
              :items="structureUnits"
              item-title="name"
              item-value="id"
          ></v-select>
          <v-select
              v-model="form.type"
              :label="$t('units.placeholder.type','Type')"
              variant="outlined"
              prepend-inner-icon="mdi-shape-outline"
              :rules="[rules.required]"
              :items="unitTypes"
          ></v-select>
        </v-card-text>
        <v-card-actions>
          <v-btn
              color="darken-1"
              variant="text"
              @click="closeDialog"
          >
            Cancel
          </v-btn>
          <v-spacer/>
          <v-btn
              color="success"
              variant="text"
              type="submit"
          >
            Create
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </v-dialog>
</template>

<script>
import {mapActions} from "pinia";
import {useOrganizationStore} from "../../../stores/organization";

export default {
  name: "CreateDialog",
  props: {
    createDialog: {
      type: Boolean,
      default: false,
    },
    organization_id: {
      type: Number,
      default: null,
    },
    parent_id: {
      type: Number,
      default: null,
    },
    unitTypes: {
      type: Array,
    },
    structureUnits: {
      type:Array,
    }
  },
  data() {
    return {
      form: {
        organization_id: this.$props.organization_id,
        parent_id: this.$props.parent_id,
        name: '',
        type:null,
      },
      rules: {
        required: value => !!value || 'Required.',
      },
    };
  },
  methods: {
    createItem(e) {
      e.preventDefault();
      e.stopPropagation();
      this.$loading();
      this.$refs.createDialogForm.validate().then(valid => {
        if (!valid.valid) {
          this.$loadingClose();
          return;
        }
        this.createStructureUnit(this.form)
            .then(() => {
              this.$loadingClose();
              this.$notify('', 'success', this.$t('messages.success', 'Success'));
              this.closeDialog();
            })
            .catch(() => {
              this.$loadingClose();
              this.$notify('', 'error', this.$t('messages.error', 'Error'));
            });
      })
    },
    closeDialog() {
      this.$emit('closeDialog');
    },
    ...mapActions(useOrganizationStore,['createStructureUnit']),
  },
  watch: {
    createDialog() {
        this.form.organization_id =  this.$props.organization_id;
        this.form.parent_id = this.$props.parent_id;
      }
  },
}
</script>

<style scoped>

</style>
