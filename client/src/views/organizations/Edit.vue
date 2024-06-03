<template>
  <v-row>
    <v-col cols="12">
      <v-card flat v-if="organization">
        <v-card-title>
          <v-toolbar dense color="primary" class="white--text">
            <span class="flex-fill ml-2">Edit {{organization.name[locale.iso_code]}}</span>
            <v-btn icon="mdi-account-group" color="white" @click="openStaffDialog()" variant="text"></v-btn>
            <v-btn icon="mdi-plus" variant="text" color="white" @click="openAddItem(null)"></v-btn>
          </v-toolbar>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="12">
              <v-list>
                <template v-for="unit in organization.units" :key="unit.id">
                  <units-row
                      :unit="unit"
                      :editItem="openEditItem"
                      :add-item="openAddItem"
                      :delete-item="openDeleteItem"
                  ></units-row>
                </template>
              </v-list>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>
    <create-dialog
        :createDialog="createDialog"
        :unitTypes="unitTypes"
        :structureUnits="structureUnits"
        :organization_id="parseInt($route.params.organization_id)"
        :parent_id="selectedItem?selectedItem.id: null"
        @closeDialog="closeAddItem"/>
    <edit-dialog
        :editDialog="editDialog"
        :unitTypes="unitTypes"
        :structureUnits="structureUnits"
        :selectedItem="selectedItem"
        @closeDialog="closeEditItem"/>
    <delete-dialog :deleteDialog="deleteDialog" :item="selectedItem" @closeDialog="closeDeleteItem"/>
    <staff-dialog
      :staffDialog="staffDialog"
      :items="users"
      :organization_id="organization?organization.id:null"
      :staff="organization?organization.staff:[]"
      :rector="organization?organization.user_id:null"
      @closeDialog="closeStaffDialog"
    ></staff-dialog>
  </v-row>
</template>

<script>
import {mapActions, mapState} from "pinia";
import DeleteDialog from "@/components/organizations/units/DeleteDialog.vue";
import CreateDialog from "@/components/organizations/units/CreateDialog.vue";
import EditDialog from "@/components/organizations/units/EditDialog.vue";
import StaffDialog from "@/components/organizations/staff/StaffDialog.vue";
import {useOrganizationStore} from "../../stores/organization";
import {useUserStore} from "../../stores/user";
import UnitsRow from "../../components/organizations/UnitsRow.vue";
import {useLocalesStore} from "../../stores/l10s";

export default {
  name: "Edit",
  components: {
    UnitsRow,
    CreateDialog,
    EditDialog,
    DeleteDialog,
    StaffDialog,
  },
  data() {
    return {
      showedUnit: null,
      createDialog:false,
      editDialog:false,
      deleteDialog:false,
      staffDialog: false,
      selectedItem: null,
      unitTypes: [
        {
          title:'ESI',
          value:'esi',
        },
        {
          title:'Faculty',
          value:'faculty',
        },
        {
          title:'Cathedra',
          value:'cathedra',
        },
        {
          title:'SRI',
          value:'sri',
        },
        {
          title:'Institute',
          value:'institute',
        },
        {
          title:'Structure unit',
          value:'unit',
        },
        {
          title:'Section',
          value:'section',
        },
        {
          title:'Department',
          value:'department',
        },
      ],
    }
  },
  computed: {
    ...mapState(useOrganizationStore,['organization','structureUnits']),
    ...mapState(useUserStore,['users']),
    ...mapState(useLocalesStore,['locale']),
  },
  mounted() {
    this.editOrganization(this.$route.params.organization_id);
    this.downloadStructureUnits(this.$route.params.organization_id);
    this.downloadStaff(this.$route.params.organization_id);
  },
  methods: {
    checkShowUnit(unit) {
      return this.showedUnit === unit.id;
    },
    showUnit(id) {
      this.showedUnit = id;
    },
    openAddItem(item = null) {
      this.selectedItem = item;
      this.createDialog = true;
    },
    closeAddItem() {
      this.selectedItem = null;
      this.createDialog = false;
    },
    openEditItem(item = null) {
      this.selectedItem = item;
      this.editDialog = true;
    },
    closeEditItem() {
      this.selectedItem = null;
      this.editDialog = false;
    },
    openDeleteItem(item = null) {
      this.selectedItem = item;
      this.deleteDialog = true;
    },
    closeDeleteItem() {
      this.selectedItem = null;
      this.downloadStructureUnits(this.$route.params.organization_id);
      this.deleteDialog = false;
    },
    openStaffDialog() {
      this.staffDialog = true;
    },
    closeStaffDialog() {
      this.staffDialog = false;
    },
    ...mapActions(useOrganizationStore,['editOrganization','downloadStructureUnits']),
    ...mapActions(useUserStore,['downloadStaff'])
  }
}
</script>

<style scoped>

</style>
