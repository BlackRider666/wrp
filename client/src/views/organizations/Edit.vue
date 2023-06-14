<template>
  <v-row>
    <v-col cols="12">
      <v-card flat v-if="organization">
        <v-card-title>
          <v-toolbar dense color="primary" class="white--text">
            <span class="flex-fill">Edit {{organization.name}}</span>
            <v-btn icon color="white" @click="openStaffDialog()"><v-icon>mdi-account-group</v-icon></v-btn>
            <v-btn icon color="white" @click="openAddItem(null)"><v-icon>mdi-plus</v-icon></v-btn>
          </v-toolbar>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="3" v-for="unit in organization.units" :key="unit.id">
              <v-card >
                <v-card-text>
                  <div class="d-flex justify-space-between align-center">
                    <div class="text-body-1 flex-fill">{{ unit.name }}</div>
                    <v-btn icon color="secondary" small v-if="unit.child.length > 0" @click="showUnit(unit.id)"><v-icon>mdi-chevron-down</v-icon></v-btn>
                    <v-btn icon color="warning" small @click="openEditItem(unit)"><v-icon small>mdi-pencil</v-icon></v-btn>
                    <v-btn icon color="primary" small @click="openAddItem(unit)"><v-icon>mdi-plus</v-icon></v-btn>
                    <v-btn icon color="error" small @click="openDeleteItem(unit)"><v-icon>mdi-close</v-icon></v-btn>
                  </div>
                  <template v-if="unit.child.length > 0">
                    <v-treeview :items="unit.child" item-children="child" v-if="checkShowUnit(unit)">
                      <template v-slot:label="{item}">
                        <div class="text-body-1 theme--light">{{ item.name }}</div>
                      </template>
                      <template v-slot:append="{item}">
                        <v-btn icon color="warning" small @click="openEditItem(item)"><v-icon small>mdi-pencil</v-icon></v-btn>
                        <v-btn icon color="primary" small @click="openAddItem(item)"><v-icon>mdi-plus</v-icon></v-btn>
                        <v-btn icon color="error" small @click="openDeleteItem(item)"><v-icon>mdi-close</v-icon></v-btn>
                      </template>
                    </v-treeview>
                  </template>
                </v-card-text>
              </v-card>
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
import {mapState} from "vuex";
import DeleteDialog from "@/components/organizations/units/DeleteDialog";
import CreateDialog from "@/components/organizations/units/CreateDialog";
import EditDialog from "@/components/organizations/units/EditDialog";
import StaffDialog from "@/components/organizations/staff/StaffDialog";

export default {
  name: "Edit",
  components: {
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
          text:'ESI',
          value:'esi',
        },
        {
          text:'Faculty',
          value:'faculty',
        },
        {
          text:'Cathedra',
          value:'cathedra',
        },
        {
          text:'SRI',
          value:'sri',
        },
        {
          text:'Institute',
          value:'institute',
        },
        {
          text:'Structure unit',
          value:'unit',
        },
        {
          text:'Section',
          value:'section',
        },
        {
          text:'Department',
          value:'department',
        },
      ],
    }
  },
  computed: {
    ...mapState({
      organization: (state) => state.organization.organization,
      structureUnits: (state) => state.organization.structureUnits,
      users: (state) => state.user.users,
    })
  },
  mounted() {
    this.$store.dispatch('organization/editOrganization', this.$route.params.organization_id);
    this.$store.dispatch('organization/downloadStructureUnits', this.$route.params.organization_id);
    this.$store.dispatch('user/downloadStaff', this.$route.params.organization_id);
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
      this.$store.dispatch('organization/downloadStructureUnits', this.$route.params.organization_id);
      this.deleteDialog = false;
    },
    openStaffDialog() {
      this.staffDialog = true;
    },
    closeStaffDialog() {
      this.staffDialog = false;
    }
  }
}
</script>

<style scoped>

</style>
