<template>
  <v-dialog
      :value="editDialog"
      @input="closeDialog"
      max-width="600"
      persistent
  >
    <v-form @submit.prevent="updateItem">
      <v-card>
        <v-card-title class="text-h5">
          Update unit
        </v-card-title>
        <v-card-text>
          <v-text-field
              v-model="form.name"
              :label="$t('units.placeholder.name','Name')"
              outlined
              prepend-inner-icon="mdi-card-text-outline"
              :rules="[rules.required]"
          />
          <v-select
              v-model="form.parent_id"
              :label="$t('units.placeholder.parent_id','Parent')"
              outlined
              prepend-inner-icon="mdi-shape-outline"
              :items="structureUnits"
              item-text="name"
              item-value="id"
          ></v-select>
          <v-select
              v-model="form.type"
              :label="$t('units.placeholder.type','Type')"
              outlined
              prepend-inner-icon="mdi-shape-outline"
              :rules="[rules.required]"
              :items="unitTypes"
          ></v-select>
        </v-card-text>
        <v-card-actions>
          <v-btn
              color="green darken-1"
              text
              type="submit"
          >
            Update
          </v-btn>
          <v-spacer/>
          <v-btn
              color="darken-1"
              text
              @click="closeDialog"
          >
            Cancel
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </v-dialog>
</template>

<script>
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
        name: '',
        type:'',
      },
      rules: {
        required: value => !!value || 'Required.',
      },
    };
  },
  methods: {
    updateItem() {
      this.$store.dispatch('organization/updateStructureUnit',this.form);
      this.$emit('closeDialog');
    },
    closeDialog() {
      this.$emit('closeDialog');
    }
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
