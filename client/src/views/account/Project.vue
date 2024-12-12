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
                <v-text-field
                    v-model="selectedProject.name"
                    :label="$t('projects.placeholder.name','Name')"
                    outlined
                    prepend-inner-icon="mdi-card-text-outline"
                />
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
          <v-text-field
              v-model="newProject.name"
              :label="$t('projects.placeholder.name','Name')"
              outlined
              prepend-inner-icon="mdi-card-text-outline"
          />
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

export default {
  name: "Project",
  props: {
    user_id: {
      type: Number,
    },
  },
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
    };
  },
  computed: {
    ...mapState(useProjectStore,['projects','total']),
    // fillProject() {
    //   return this.$store.state.tutorial.step === 6 && this.$store.state.tutorial.tutorialCategory === 'account' && this.createProjectDialog === false;
    // },
  },
  methods: {
    showProjectsSheet() {
      this.projectsSheet = !this.projectsSheet;
    },
    openProjectCreate() {
      this.createProjectDialog = true;
      this.newProject = {
        name: null,
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
        user_id:this.user_id,
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
