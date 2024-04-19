<template>
  <v-col cols="12">
    <v-toolbar dense dark color="primary" class="pl-2">
      {{$t('social-links.title','Social links')}}
      <v-spacer/>
      <v-btn
          icon="mdi-plus"
          @click="openLinkCreate"
      ></v-btn>
      <v-btn :icon="linksSheet?'mdi-chevron-up':'mdi-chevron-down'" @click="showLinksSheet">
      </v-btn>
    </v-toolbar>
    <v-sheet v-if="linksSheet" outlined>
      <v-data-table
          :headers="linksHeaders"
          :items="links"
          :footer-props="{
                  itemsPerPageOptions:[]
              }"
          class="elevation-1"
          dense
      >
        <template v-slot:top>
          <v-dialog v-model="editLinkDialog" max-width="500px">
            <v-card>
              <v-card-title>{{$t('social-links.edit.title','Edit')}}</v-card-title>
              <v-card-text v-if="selectedLink">
                <v-text-field
                    v-model="selectedLink.url"
                    :label="$t('social-links.placeholder.url','Url')"
                    outlined
                    prepend-inner-icon="mdi-card-text-outline"
                />
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="darken-1" variant="text" @click="closeLinkEdit">{{$t('btn.cancel','Cancel')}}</v-btn>
                <v-btn color="darken-1" variant="text" @click="editLink">{{$t('btn.update','Update')}}</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="deleteLinkDialog" max-width="500px">
            <v-card>
              <v-card-title>{{$t('social-links.delete.title','Delete')}}</v-card-title>
              <v-card-text>{{$t('social-links.delete.message','Are you sure you want to delete this link?')}}</v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="darken-1" variant="text" @click="closeLinkDelete">{{$t('btn.cancel','Cancel')}}</v-btn>
                <v-btn color="error" variant="text" @click="deleteLink">{{$t('btn.delete','Delete')}}</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon
              small
              class="mr-2"
              @click="openLinkEdit(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
              small
              @click="openLinkDelete(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-sheet>
    <v-dialog v-model="createLinkDialog" max-width="500px">
      <v-card v-if="newLink">
        <v-card-title>{{$t('social-links.create.title','Create')}}</v-card-title>
        <v-card-text>
          <v-text-field
              v-model="newLink.url"
              :label="$t('social-links.placeholder.url','Url')"
              outlined
              prepend-inner-icon="mdi-card-text-outline"
          />
          <v-select
            v-model="newLink.type"
            :items="availableSocialLinkTypes"
            hide-no-data
            :label="$t('social-links.placeholder.type','Type')"
            :placeholder="$t('social-links.placeholder.type','Type')"
          ></v-select>
        </v-card-text>
        <v-card-actions>
          <v-btn color="darken-1" variant="text" @click="closeLinkCreate">{{$t('btn.cancel','Cancel')}}</v-btn>
          <v-spacer></v-spacer>
          <v-btn color="primary" variant="text" @click="createLink">{{$t('btn.create','Create')}}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-col>
</template>

<script>
import {mapActions, mapState} from "pinia";
import {useSocialLinkStore} from "@/stores/socialLink";

export default {
  name: `SocialLink`,
  data() {
    return {
      linksSheet: false,
      createLinkDialog: false,
      editLinkDialog: false,
      deleteLinkDialog: false,
      linksHeaders: [
        { title: this.$t('social-link.placeholder.url','URL'), value: 'url' },
        { title: this.$t('social-link.placeholder.type', 'Type'), value: 'type' },
        { title: 'Actions', value: 'actions', sortable: false },
      ],
      newLink: null,
      selectedLink: null,
      socialLinkTypes:[
        {
          text:this.$t('social-link.title.academia','Academia'),
          title:'academia',
        },
        {
          text:this.$t('social-link.title.orcid','ORCID'),
          title:'orcid',
        },
        {
          text:this.$t('social-link.title.scopus','Scopus'),
          title:'scopus',
        },
        {
          text:this.$t('social-link.title.science','Science'),
          title:'science',
        },
        {
          text:this.$t('social-link.title.linkedin','LinkedIn'),
          title:'linkedin',
        },
        {
          text:this.$t('social-link.title.facebook','Facebook'),
          title:'facebook',
        },
        {
          text:this.$t('social-link.title.google','Google'),
          title:'google',
        },
        {
          text:this.$t('social-link.title.instagram','Instagram'),
          title:'instagram',
        },
      ],
    };
  },
  computed: {
    ...mapState(useSocialLinkStore,['links']),
    availableSocialLinkTypes() {
      return this.socialLinkTypes.filter( (item) => {
        return !this.links.find((link) => link.type === item.value);
      })
    }
  },
  methods: {
    showLinksSheet() {
      this.linksSheet = !this.linksSheet;
      if (this.linksSheet) this.getData();
    },
    openLinkCreate() {
      this.$loading()
      this.downloadLinks({
        ...this.options,
      }).then(() => {
        this.$loadingClose();
        this.createLinkDialog = true;
        this.newLink = {
          url: null,
          type: null,
        };
      });
    },
    closeLinkCreate() {
      this.createLinkDialog = false;
    },
    openLinkEdit (item) {
      this.editLinkDialog = true;
      this.selectedLink = {...item};
    },
    closeLinkEdit() {
      this.editLinkDialog = false;
      this.selectedLink = null;
    },
    openLinkDelete (item) {
      this.deleteLinkDialog = true;
      this.selectedLink = item;
    },
    closeLinkDelete() {
      this.deleteProjectDialog = false;
      this.selectedProject = null;
    },
    createLink () {
      this.$loading();
      this.create(this.newLink)
          .then(() => {
            this.$loadingClose();
            this.closeLinkCreate();
            this.$notify('','success', 'Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    editLink() {
      this.$loading();
      this.update(this.selectedLink)
          .then(() => {
            this.$loadingClose();
            this.closeLinkEdit();
            this.$notify('','success', 'Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    deleteLink() {
      this.$loading();
      this.delete(this.selectedLink.id)
          .then(() => {
            this.$loadingClose();
            this.closeLinkDelete();
            this.$notify('','success', 'Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    },
    getData() {
      this.$loading()
      this.downloadLinks({
        ...this.options,
      }).then(() => {
        this.$loadingClose();
      });
    },
    ...mapActions(useSocialLinkStore,['downloadLinks','create','update','delete'])
  },
}
</script>

<style scoped>

</style>
