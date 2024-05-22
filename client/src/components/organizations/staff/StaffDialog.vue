<template>
  <v-dialog
      :model-value="staffDialog"
      @update:model-value="closeDialog"
      max-width="600"
      persistent
  >

    <v-form @submit.prevent="createItem">
      <v-card>
        <v-card-title class="text-h5">
          Update staff
        </v-card-title>
        <v-card-text>
          <v-autocomplete
              v-model="form.user_id"
              :label="$t('organization.placeholder.rector','Rector')"
              variant="outlined"
              prepend-inner-icon="mdi-account"
              :items="items"
              item-title="full_name"
              item-value="id"
          ></v-autocomplete>
          <v-autocomplete
              v-model="form.users"
              multiple
              small-chips
              :label="$t('organization.placeholder.staff','Staff')"
              variant="outlined"
              prepend-inner-icon="mdi-account-group"
              :items="items"
              item-title="full_name"
              item-value="id"
          ></v-autocomplete>
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
  name: "StaffDialog",
  props: {
    staffDialog: {
      type: Boolean,
      default: false,
    },
    organization_id: {
      type: Number,
      default:null,
    },
    staff: {
      type: Array,
    },
    rector: {
      type: Number,
      default:null,
    },
    items: {
      type: Array,
    }
  },
  data() {
    return {
      form: {
        user_id:null,
        users: null,
      },
      rules: {
        required: value => !!value || 'Required.',
      },
    };
  },
  methods: {
    createItem() {
      this.updateOrganization({...this.form, organization_id:this.organization_id});
      this.$emit('closeDialog');
    },
    closeDialog() {
      this.$emit('closeDialog');
    },
    ...mapActions(useOrganizationStore,['updateOrganization']),
  },
  watch: {
    staffDialog(val) {
      if (val) {
        this.form.users = this.$props.staff.map((i) => i.id);
        this.form.user_id = this.$props.rector;
      } else {
        this.form = {
          users: null,
          user_id: null,
        };
      }
    }
  },
}
</script>

<style scoped>

</style>
