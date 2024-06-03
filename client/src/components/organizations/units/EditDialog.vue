<template>
  <v-dialog
      :model-value="editDialog"
      @update:model-value="closeDialog"
      max-width="600"
      persistent
  >
    <v-form ref="editDialogForm" @submit.prevent="updateItem">
      <v-card>
        <v-card-title class="text-h5">
          Update unit
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
              :items="formatedUnits"
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
              color="warning"
              variant="text"
              type="submit"
          >
            Update
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
  name: "EditDialog",
  props: {
    editDialog: {
      type: Boolean,
      default: false,
    },
    selectedItem: {
      type: Object,
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
        organization_id: '',
        parent_id: '',
        name: {
          en:'',
          uk:'',
        },
        type:'',
      },
      rules: {
        required: value => !!value || 'Required.',
      },
      activeTitleTab:'en',
    };
  },
  computed: {
    formatedUnits() {
      return this.structureUnits.map(item => {
        if (this.selectedItem && item.id === this.selectedItem.id) {
          return { ...item, id: null, name: 'Without parent' };
        }
        return item;
      }).sort((a, b) => {
        if (a.id === null) return -1;
        if (b.id === null) return 1;
        return a.id - b.id;
      });
    }
  },
  methods: {
    updateItem(e) {
      e.preventDefault();
      e.stopPropagation();
      this.$loading();
      this.$refs.editDialogForm.validate().then(valid => {
        if (!valid.valid) {
          this.$loadingClose();
          return;
        }
        this.updateStructureUnit(this.form)
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
    ...mapActions(useOrganizationStore,['updateStructureUnit'])
  },
  watch: {
    editDialog(val) {
      if (val) {
        this.form = this.$props.selectedItem;
      } else {
        this.form = {
          organization_id: '',
          parent_id: '',
          name: '',
          type:'',
        };
      }
    }
  },
}
</script>

<style scoped>

</style>
