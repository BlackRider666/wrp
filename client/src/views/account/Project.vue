<template>
  <v-col cols="12">
    <v-toolbar dense dark color="primary"  class="pl-2">
<!--      <v-toolbar dense dark :class="fillProject?'blink':''" color="primary"  class="pl-2">-->
      {{$t('projects.title','Projects')}}
      <v-spacer/>
      <v-btn
          icon="mdi-plus"
          @click="openProjectCreate"
      ></v-btn>
<!--      <v-btn-->
<!--          icon="mdi-plus"-->
<!--          @click="openProjectCreate"-->
<!--          :class="fillProject?'blink':''"-->
<!--      ></v-btn>-->
      <v-btn :icon="projectsSheet?'mdi-chevron-up':'mdi-chevron-down'" @click="showProjectsSheet"></v-btn>
    </v-toolbar>
    <v-sheet v-if="projectsSheet" outlined>
      <v-data-table
          :headers="projectsHeaders"
          :items="projects"
          :options.sync="options"
          :server-items-length="total"
          :footer-props="{
                  itemsPerPageOptions:[5,10,15,20]
              }"
          class="elevation-1"
          dense
      >
        <template v-slot:top>
          <v-dialog v-model="editProjectDialog" max-width="500px">
            <v-card>
              <v-card-title>{{$t('projects.edit.title','Edit')}}</v-card-title>
              <v-card-text v-if="selectedProject">
                <v-tabs v-model="activePositionTab" align-tabs="end" class="pb-1" selected-class="text-primary">
                  <v-tab key="en">English</v-tab>
                  <v-tab key="uk">Українська</v-tab>
                </v-tabs>
                <v-window v-model="activePositionTab" class="pt-2">
                  <v-window-item key="en">
                    <v-text-field
                        v-model="selectedProject.name.en"
                        :label="$t('projects.placeholder.name','Name')"
                        outlined
                        prepend-inner-icon="mdi-card-text-outline"
                    />
                  </v-window-item>
                  <v-window-item key="uk">
                    <v-text-field
                        v-model="selectedProject.name.uk"
                        :label="$t('projects.placeholder.name','Name')"
                        outlined
                        prepend-inner-icon="mdi-card-text-outline"
                    />
                  </v-window-item>
                </v-window>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="darken-1" variant="text" @click="closeProjectEdit">{{$t('btn.cancel','Cancel')}}</v-btn>
                <v-btn color="darken-1" variant="text" @click="editProject">{{$t('btn.update','Update')}}</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="deleteProjectDialog" max-width="500px">
            <v-card>
              <v-card-title>{{$t('projects.delete.title','Delete')}}</v-card-title>
              <v-card-text>{{$t('projects.delete.message','Are you sure you want to delete this project?')}}</v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="darken-1" variant="text" @click="closeProjectDelete">{{$t('btn.cancel','Cancel')}}</v-btn>
                <v-btn color="error" variant="text" @click="deleteProject">{{$t('btn.delete','Delete')}}</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </template>
        <template v-slot:item.name="{ item }">
          {{item.name[locale.iso_code]}}
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon
              small
              class="mr-2"
              @click="openProjectEdit(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
              small
              @click="openProjectDelete(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-sheet>
    <v-dialog v-model="createProjectDialog" max-width="500px">
      <v-card v-if="newProject">
        <v-card-title>{{$t('projects.create.title','Create')}}</v-card-title>
        <v-card-text>
          <v-tabs v-model="activePositionTab" align-tabs="end" class="pb-1" selected-class="text-primary">
            <v-tab key="en">English</v-tab>
            <v-tab key="uk">Українська</v-tab>
          </v-tabs>
          <v-window v-model="activePositionTab" class="pt-2">
            <v-window-item key="en">
              <v-text-field
                  v-model="newProject.name.en"
                  :label="$t('projects.placeholder.name','Name')"
                  outlined
                  prepend-inner-icon="mdi-card-text-outline"
              />
            </v-window-item>
            <v-window-item key="uk">
              <v-text-field
                  v-model="newProject.name.uk"
                  :label="$t('projects.placeholder.name','Name')"
                  outlined
                  prepend-inner-icon="mdi-card-text-outline"
              />
            </v-window-item>
          </v-window>
        </v-card-text>
        <v-card-actions>
          <v-btn color="darken-1" variant="text" @click="closeProjectCreate">{{$t('btn.cancel','Cancel')}}</v-btn>
          <v-spacer></v-spacer>
          <v-btn color="primary" variant="text" @click="createProject">{{$t('btn.create','Create')}}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-col>
</template>

<script>
import {mapActions, mapState} from "pinia";
import {useProjectStore} from "@/stores/project";
import {useLocalesStore} from "@/stores/l10s";

export default {
  name: "Project",
  data() {
    return {
      projectsSheet: false,
      createProjectDialog: false,
      editProjectDialog: false,
      deleteProjectDialog: false,
      projectsHeaders: [
        { title: this.$t('projects.placeholder.name','Name'), value: 'name' },
        { title: 'Actions', value: 'actions', sortable: false },
      ],
      newProject: null,
      selectedProject: null,
      options: {},
      activePositionTab:'en',
    };
  },
  computed: {
    ...mapState(useProjectStore,['projects','total']),
    ...mapState(useLocalesStore,['locale']),
    // fillProject() {
    //   return this.$store.state.tutorial.step === 6 && this.$store.state.tutorial.tutorialCategory === 'account' && this.createProjectDialog === false;
    // },
  },
  methods: {
    showProjectsSheet() {
      this.projectsSheet = !this.projectsSheet;
      if (this.projectsSheet) this.getData();
    },
    openProjectCreate() {
      this.createProjectDialog = true;
      this.newProject = {
        name: {
          en:'',
          uk:'',
        },
      };
    },
    closeProjectCreate() {
      this.createProjectDialog = false;
    },
    openProjectEdit (item) {
      this.editProjectDialog = true;
      this.selectedProject = {...item};
    },
    closeProjectEdit() {
      this.editProjectDialog = false;
      this.selectedProject = null;
    },
    openProjectDelete (item) {
      this.deleteProjectDialog = true;
      this.selectedProject = item;
    },
    closeProjectDelete() {
      this.deleteProjectDialog = false;
      this.selectedProject = null;
    },
    createProject () {
      this.$loading();
      this.create(this.newProject)
          .then(() => {
            this.$loadingClose();
            this.closeProjectCreate();
            this.$notify('','success', 'Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    editProject() {
      this.$loading();
      this.update(this.selectedProject)
          .then(() => {
            this.$loadingClose();
            this.closeProjectEdit();
            this.$notify('','success', 'Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    deleteProject() {
      this.$loading();
      this.delete(this.selectedProject.id)
          .then(() => {
            this.$loadingClose();
            this.closeProjectDelete();
            this.$notify('','success', 'Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    getData() {
      this.$loading()
      this.downloadProjects({
        ...this.options,
      }).then(() => {
        this.$loadingClose();
      });
    },
    ...mapActions(useProjectStore,{
      downloadProjects:'downloadProjects',
      delete:'deleteProject',
      update:'updateProject',
      create:'createProject'
    }),
  },
  watch: {
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
