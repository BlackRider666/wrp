<template>
  <v-col cols="12">
    <v-toolbar dense dark :class="fillWork?'blink':''" color="primary"  class="pl-2">
      {{$t('works.title','Works')}}
      <v-spacer/>
      <v-btn
          icon="mdi-plus"
          @click="openCreateWorkDialog"
          :class="fillWork?'blink':''"
      ></v-btn>
      <v-btn :icon="worksSheet?'mdi-chevron-up':'mdi-chevron-down'" @click="showWorksSheet"></v-btn>
    </v-toolbar>
    <v-sheet v-if="worksSheet" outlined>
      <v-data-table
          :headers="worksHeaders"
          :items="works"
          :options.sync="options"
          :server-items-length="total"
          :footer-props="{
                  itemsPerPageOptions:[5,10,15,20]
              }"
          class="elevation-1"
          dense
      >
        <template v-slot:top>
          <v-dialog v-model="editWorkDialog" max-width="500px">
            <v-card>
              <v-card-title>{{$t('works.edit.title','Edit')}}</v-card-title>
              <v-card-text v-if="selectedWork">
                <v-autocomplete
                    v-model="selectedWork.organization"
                    :items="organizations"
                    hide-no-data
                    item-text="name"
                    item-value="id"
                    :label="$t('works.placeholder.organization','Organization')"
                    :placeholder="$t('works.placeholder.organization','Organization')"
                    prepend-inner-icon="mdi-database-search"
                    :search-input="organizationSearch"
                    @update:search-input="(value) => changeOrganization(value)"
                    return-object
                    outlined
                ></v-autocomplete>
                <v-autocomplete
                    v-model="selectedWork.structure_unit"
                    :items="structureUnits"
                    hide-no-data
                    item-text="name"
                    item-value="id"
                    :label="$t('works.placeholder.structure-unit','Structure Unit')"
                    :placeholder="$t('works.placeholder.structure-unit','Structure Unit')"
                    prepend-inner-icon="mdi-database-search"
                    :search-input="structureUnitSearch"
                    @update:search-input="(value) => changeStructureUnit(value)"
                    return-object
                    outlined
                ></v-autocomplete>
                <v-text-field
                    v-model="selectedWork.position"
                    :label="$t('works.placeholder.position','Position')"
                    outlined
                    prepend-inner-icon="mdi-card-text-outline"
                />
                <v-menu ref="menu"
                        v-model="menuStart"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                >
                  <template v-slot:activator="{ props }">
                    <v-text-field
                        :value="selectedWork.start"
                        :label="$t('works.placeholder.start', 'Worked from')"
                        prepend-inner-icon="mdi-calendar"
                        readonly
                        v-bind="props"
                        outlined
                    />
                  </template>
                  <v-date-picker v-model="selectedWork.start" no-title scrollable @input="menuStart = false"/>
                </v-menu>
                <v-menu ref="menu"
                        v-model="menuFinish"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                >
                  <template v-slot:activator="{ props }">
                    <v-text-field
                        :value="selectedWork.finish"
                        :label="$t('works.placeholder.finish','Worked Until')"
                        prepend-inner-icon="mdi-calendar"
                        readonly
                        v-bind="props"
                        outlined
                    />
                  </template>
                  <v-date-picker v-model="selectedWork.finish" no-title scrollable @input="menuFinish = false"/>
                </v-menu>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="darken-1" variant="text" @click="closeWorkEdit">{{$t('btn.cancel','Cancel')}}</v-btn>
                <v-btn color="darken-1" variant="text" @click="editWork">{{$t('btn.update','Update')}}</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="deleteWorkDialog" max-width="500px">
            <v-card>
              <v-card-title>{{$t('works.delete.title','Delete')}}</v-card-title>
              <v-card-text>{{$t('works.delete.message','Are you sure you want to delete this work?')}}</v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="darken-1" variant="text" @click="closeWorkDelete">{{$t('btn.cancel','Cancel')}}</v-btn>
                <v-btn color="error" variant="text" @click="deleteWork">{{$t('btn.delete','Delete')}}</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon
              small
              class="mr-2"
              @click="openWorkEdit(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
              small
              @click="openWorkDelete(item)"
          >
            mdi-delete
          </v-icon>
        </template>
        <template v-slot:item.finish="{ item }">
          {{item.finish?item.finish: $t('works.now','Now')}}
        </template>
      </v-data-table>
    </v-sheet>
    <v-dialog v-model="createWorkDialog" max-width="500px">
      <v-card v-if="newWork">
        <v-card-title>{{$t('works.create.title','Create')}}</v-card-title>
        <v-card-text>
          <v-autocomplete
              v-model="newWork.organization"
              :items="organizations"
              hide-no-data
              :item-title="`name.${locale.iso_code}`"
              item-value="id"
              :label="$t('works.placeholder.organization','Organization')"
              :placeholder="$t('works.placeholder.organization','Organization')"
              prepend-inner-icon="mdi-database-search"
              :search-input="organizationSearch"
              @update:search-input="(value) => changeOrganization(value)"
              return-object
              outlined
          ></v-autocomplete>
          <v-autocomplete
              v-model="newWork.structure_unit"
              :items="structureUnits"
              hide-no-data
              item-title="name"
              item-value="id"
              :label="$t('works.placeholder.structure-unit','Structure Unit')"
              :placeholder="$t('works.placeholder.structure-unit','Structure Unit')"
              prepend-inner-icon="mdi-database-search"
              :search-input="structureUnitSearch"
              @update:search-input="(value) => changeStructureUnit(value)"
              return-object
              outlined
          ></v-autocomplete>
          <v-text-field
              v-model="newWork.position"
              :label="$t('works.placeholder.position','Position')"
              outlined
              prepend-inner-icon="mdi-card-text-outline"
          />
          <v-menu ref="menu"
                  v-model="menuStart"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  min-width="290px"
          >
            <template v-slot:activator="{ props }">
              <v-text-field
                  :value="newWork.start"
                  :label="$t('works.placeholder.start', 'Worked from')"
                  prepend-inner-icon="mdi-calendar"
                  readonly
                  v-bind="props"
                  outlined
              />
            </template>
            <v-date-picker v-model="newWork.start" no-title scrollable @input="menuStart = false"/>
          </v-menu>
          <v-menu ref="menu"
                  v-model="menuFinish"
                  v-if="!finishNow"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  min-width="290px"
          >
            <template v-slot:activator="{ props }">
              <v-text-field
                  :value="newWork.finish"
                  :label="$t('works.placeholder.finish','Worked Until')"
                  prepend-inner-icon="mdi-calendar"
                  readonly
                  v-bind="props"
                  outlined
              />
            </template>
            <v-date-picker v-model="newWork.finish" no-title scrollable @input="menuFinish = false"/>
          </v-menu>
          <v-checkbox
              v-model="finishNow"
              :label="$t('works.placeholder.now-working','Now')"
          ></v-checkbox>
        </v-card-text>
        <v-card-actions>
          <v-btn color="darken-1" variant="text" @click="closeCreateWorkDialog">{{$t('btn.cancel','Cancel')}}</v-btn>
          <v-spacer></v-spacer>
          <v-btn color="primary" variant="text" @click="createWork">{{$t('btn.create','Create')}}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-col>
</template>

<script>
import {mapActions, mapState} from "pinia";
import {useAccountStore} from "@/stores/account";
import {useOrganizationStore} from "@/stores/organization";
import {useLocalesStore} from "@/stores/l10s";

export default {
  name: "Work",
  data() {
    return {
      worksSheet: false,
      createWorkDialog: false,
      editWorkDialog: false,
      deleteWorkDialog: false,
      worksHeaders: [
        { title: this.$t('works.placeholder.title','Title'), value: 'title' },
        { title: this.$t('works.placeholder.start', 'Worked from'), value: 'start' },
        { title: this.$t('works.placeholder.finish','Worked Until'), value: 'finish' },
        { title: 'Actions', value: 'actions', sortable: false },
      ],
      newWork: null,
      selectedWork: null,
      organizationSearch:'',
      structureUnitSearch: '',
      menuStart:false,
      menuFinish:false,
      options: {},
      finishNow:false,
    };
  },
  computed: {
    ...mapState(useAccountStore,['works','total']),
    ...mapState(useOrganizationStore,['organizations','structureUnits']),
    ...mapState(useLocalesStore,['locale']),
    // fillWork() {
    //   return this.$store.state.tutorial.step === 4 && this.$store.state.tutorial.tutorialCategory === 'account' && this.createWorkDialog === false;
    // },
  },
  methods: {
    showWorksSheet() {
      this.worksSheet = !this.worksSheet;
    },
    openCreateWorkDialog() {
      this.createWorkDialog = true;
      this.newWork = {
        organization: null,
        structure_unit: null,
        position: '',
        start: new Date().toISOString().substr(0, 10),
        finish: null,
      };
      this.downloadOrganizations();
    },
    closeCreateWorkDialog() {
      this.createWorkDialog = false;
    },
    openWorkEdit (item) {
      this.editWorkDialog = true;
      this.selectedWork = {
        ...item,
        organization: item.unit.organization,
        structure_unit:item.unit
      };
      this.downloadOrganizations();
    },
    closeWorkEdit() {
      this.editWorkDialog = false;
      this.selectedWork = null;
    },
    openWorkDelete (item) {
      this.deleteWorkDialog = true;
      this.selectedWork = item;
    },
    closeWorkDelete() {
      this.deleteWorkDialog = false;
      this.selectedWork = null;
    },
    createWork () {
      this.$loading();
      this.create(this.newWork)
          .then(() => {
            this.$loadingClose();
            this.closeCreateWorkDialog();
            this.$notify('','success', 'Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    editWork() {
      this.$loading();
      this.update(this.selectedWork)
          .then(() => {
            this.$loadingClose();
            this.closeWorkEdit();
            this.$notify('','success', 'Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    deleteWork() {
      this.$loading();
      this.delete(this.selectedWork.id)
          .then(() => {
            this.$loadingClose();
            this.closeWorkDelete();
            this.$notify('','success', 'Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    changeOrganization(item) {
      if (item) {
        let organization = this.organizations.find((o) => o.name === item);
        if (!organization) {
          if (this.createWorkDialog) this.newWork.structure_unit = null;
          if (this.editWorkDialog) this.selectedWork.structure_unit = null;
          let org = this.organizations.find((i) => i.id === 'new');
          if (org) {
            org.name = item;
          }
        }
      }
    },
    changeStructureUnit(item) {
      if (item) {
        let unit = this.structureUnits.find((u) => u.name === item);
        if (!unit) {
          let structureUnit = this.structureUnits.find((i) => i.id === 'new');
          if (structureUnit) {
            structureUnit.name = item;
          }
        }
      }
    },
    getData() {
      this.$loading()
      this.downloadWorks({
        user_id:this.user_id,
        ...this.options,
      }).then(() => {
        this.$loadingClose();
      });
    },
    ...mapActions(useOrganizationStore,['downloadOrganizations','downloadStructureUnits','clearStructureUnits']),
    ...mapActions(useAccountStore,{
      downloadWorks:'downloadWorks',
      create:'createWork',
      delete:'deleteWork'
    }),

  },
  watch: {
    'newWork.organization'(item) {
      if (item) {
        if (item.id !== 'new') {
          this.downloadStructureUnits(item.id)
        } else {
          this.clearStructureUnits();
        }
      }
    },
    'selectedWork.organization'(item) {
      if (item) {
        if (item.id !== 'new') {
          this.downloadStructureUnits(item.id)
        } else {
          this.clearStructureUnits();
        }
      }
    },
    options: {
      handler () {
        this.getData();
      },
      deep: true,
    },
  },
}
</script>

<style scoped>

</style>
