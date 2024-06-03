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
          <v-tabs v-model="activeTitleTab" align-tabs="end" class="pb-1" selected-class="text-primary">
            <v-tab key="en">English</v-tab>
            <v-tab key="uk">Українська</v-tab>
          </v-tabs>
          <v-window v-model="activeTitleTab" class="pt-2">
            <v-window-item key="en">
              <v-text-field
                  v-model="form.name.en"
                  :label="$t('units.placeholder.name','Name')"
                  variant="outlined"
                  prepend-inner-icon="mdi-card-text-outline"
                  :rules="[rules.required]"
              />
            </v-window-item>
            <v-window-item key="uk">
              <v-text-field
                  v-model="form.name.uk"
                  :label="$t('units.placeholder.name','Name')"
                  variant="outlined"
                  prepend-inner-icon="mdi-card-text-outline"
                  :rules="[rules.required]"
              />
            </v-window-item>
          </v-window>
          <v-select
              v-model="form.parent_id"
              :label="$t('units.placeholder.parent_id','Parent')"
              variant="outlined"
              prepend-inner-icon="mdi-shape-outline"
              :items="structureUnits"
              :item-title="`name[${locale.iso_code}]`"
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
import {mapActions, mapState} from "pinia";
import {useOrganizationStore} from "../../../stores/organization";
import {useLocalesStore} from "../../../stores/l10s";

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
        name: {
          en:'',
          uk:'',
        },
        type:null,
      },
      rules: {
        required: value => !!value || 'Required.',
      },
      activeTitleTab: 'en',
    };
  },
  computed: {
    ...mapState(useLocalesStore,['locale'])
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
            .catch((error) => {
              console.log(error)
              this.$loadingClose();
              this.$notify('', 'error', error.response.data.message);
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
