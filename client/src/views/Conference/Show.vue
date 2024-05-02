<template>
  <v-row>
    <v-col cols="12">
      <v-card v-if="conference">
        <v-card-title class="pb-0">
          <v-toolbar dense color="primary" class="pl-2">
            {{conference.title}}
          </v-toolbar>
        </v-card-title>
        <v-card-text>
          <v-list>
            <template v-if="conference.country_id">
              <v-list-item prepend-icon="mdi-account" variant="flat">
                <v-list-item-subtitle>{{$t('conference.placeholder.country', 'Country')}}</v-list-item-subtitle>
                <v-list-item-title>{{conference.country.name}}</v-list-item-title>
              </v-list-item>
              <v-divider/>
            </template>
            <template v-if="conference.city_id">
              <v-list-item prepend-icon="mdi-account" variant="flat">
                <v-list-item-subtitle>{{$t('conference.placeholder.city', 'City')}}</v-list-item-subtitle>
                <v-list-item-title>{{conference.city.name}}</v-list-item-title>
              </v-list-item>
              <v-divider/>
            </template>
            <template v-if="conference.title">
              <v-list-item prepend-icon="mdi-account" variant="flat">
                <v-list-item-subtitle>{{$t('conference.placeholder.title', 'Title')}}</v-list-item-subtitle>
                <v-list-item-title>{{conference.title}}</v-list-item-title>
              </v-list-item>
              <v-divider/>
            </template>
            <template v-if="conference.date">
              <v-list-item prepend-icon="mdi-account" variant="flat">
                <v-list-item-subtitle>{{$t('conference.placeholder.date', 'Date')}}</v-list-item-subtitle>
                <v-list-item-title>{{conference.date}}</v-list-item-title>
              </v-list-item>
              <v-divider/>
            </template>
            <template v-if="conference.file">
              <v-list-item prepend-icon="mdi-account" variant="flat">
                  <v-list-item-subtitle>{{$t('conference.placeholder.file', 'PDF File')}}</v-list-item-subtitle>
                  <v-list-item-title>
                    <v-btn color="primary" variant="text" :href="conference.file_url" target="blank" icon="mdi-file-pdf-box"></v-btn>
                  </v-list-item-title>
              </v-list-item>
              <v-divider/>
            </template>
            <template v-if="conference.organizers">
              <v-toolbar dense tile class="pl-2">
                {{$t('home.organizers.title','Organizers')}}
              </v-toolbar>
              <v-slide-group
                  show-arrows
              >
                <v-slide-group-item
                    v-for="organizer in conference.organizers"
                    :key="organizer.id"
                >
                  <v-card
                      class="ma-4"
                      flat
                  >
                    <v-card-title>
                      <v-img :src="organizer.logo_url" :alt="organizer.title" width="100%" height="100%"/>
                    </v-card-title>
                    <v-card-text>
                    {{ organizer.title }}
                    </v-card-text>
                  </v-card>
                </v-slide-group-item>
              </v-slide-group>
            </template>
          </v-list>
          <v-data-table-server
              :headers="headers"
              :items="articles"
              :items-length="total"
              v-model:items-per-page="options.perPage"
              v-model:page="options.page"
              :items-per-page-options="[
                      {value:5,title:'5'},
                      {value:10,title:'10'},
                      {value:15,title:'15'},
                      {value:20,title:'20'}
                      ]"
              @update:options="getArticles"
              class="elevation-1"
          >
            <template v-slot:top v-if="canEdit">
              <v-toolbar dense flat class="pl-2">
                <span>{{$t('articles.index.title','Articles')}}</span>
                <v-spacer></v-spacer>
                <v-btn :to="{name:'Conference Add Article', params:{conference_id:$route.conference_id}}" color="primary">{{$t('articles.create.btn.add','Add Article')}}</v-btn>
              </v-toolbar>

              <v-dialog v-model="dialogDelete" max-width="500px">
                <v-card>
                  <v-card-title>{{$t('articles.delete.title','Delete')}}</v-card-title>
                  <v-card-text>{{$t('articles.delete.message','Are you sure you want to delete this item?')}}</v-card-text>
                  <v-card-actions>
                    <v-btn color="darken-1" variant="text" @click="closeDelete">{{$t('btn.cancel','Cancel')}}</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="error" variant="text" @click="deleteItemConfirm">{{$t('btn.delete','Delete')}}</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </template>
            <template v-slot:item.actions="{ item }">
              <v-btn
                  small
                  variant="text"
                  icon="mdi-eye"
                  class="mr-2"
                  color="primary"
                  :to="{name:'Article',params:{article_id:item.id}}"
              ></v-btn>
              <v-btn
                  v-if="canEdit"
                  small
                  variant="text"
                  icon="mdi-delete"
                  color="error"
                  @click="deleteItem(item)"
              ></v-btn>
            </template>
            <template v-slot:item.full_title="{ item }">
              {{item.full_title[locale.iso_code]}}
            </template>
          </v-data-table-server>
<!--          <template v-if="canEdit">-->
<!--            <v-data-table-->
<!--                :headers="headersOrgCommittee"-->
<!--                :items="conference.org_committee"-->
<!--                :footer-props="{-->
<!--                  itemsPerPageOptions:[5,10,15,20]-->
<!--              }"-->
<!--                class="elevation-1"-->
<!--            >-->
<!--              <template v-slot:top>-->
<!--                <v-toolbar dense flat>-->
<!--                  <span class="text-h5">{{$t('conference.index.org-committee','Org Committee')}}</span>-->
<!--                  <v-spacer></v-spacer>-->
<!--                  <v-btn @click="addOrgCommitteeDialog" color="primary">{{$t('conference.org-committee.add','Add User')}}</v-btn>-->
<!--                </v-toolbar>-->
<!--                <v-dialog v-model="dialogAddOrgCommittee">-->
<!--                  <v-form-->
<!--                      v-if="newOrgCommittee"-->
<!--                      ref="addOrgCommitteeForm"-->
<!--                      lazy-validation-->
<!--                      align="center"-->
<!--                      @submit.prevent="addOrgCommitteeConfirm"-->
<!--                  >-->
<!--                    <v-card>-->
<!--                      <v-card-title>{{$t('conference.org-committee.create.title','Create')}}</v-card-title>-->
<!--                      <v-card-text>-->
<!--                        <v-autocomplete-->
<!--                            v-model="newOrgCommittee.users"-->
<!--                            :label="$t('conference.org-committee.users','Users')"-->
<!--                            outlined-->
<!--                            prepend-inner-icon="mdi-shape-outline"-->
<!--                            :rules="[rules.required]"-->
<!--                            :items="authors"-->
<!--                            item-text="full_name"-->
<!--                            item-value="id"-->
<!--                            multiple-->
<!--                        ></v-autocomplete>-->
<!--                      </v-card-text>-->
<!--                      <v-card-actions>-->
<!--                        <v-btn color="darken-1" text @click="closeAddOrgCommittee">{{$t('btn.cancel','Cancel')}}</v-btn>-->
<!--                        <v-spacer></v-spacer>-->
<!--                        <v-btn color="darken-1" text type="submit">{{$t('btn.create','Create')}}</v-btn>-->
<!--                      </v-card-actions>-->
<!--                    </v-card>-->
<!--                  </v-form>-->
<!--                </v-dialog>-->
<!--                <v-dialog v-model="dialogDeleteOrgCommittee" max-width="500px">-->
<!--                  <v-card>-->
<!--                    <v-card-title>{{$t('conference.org-committee.delete.title','Delete')}}</v-card-title>-->
<!--                    <v-card-text>{{$t('conference.org-committee.delete.message','Are you sure you want to delete this item?')}}</v-card-text>-->
<!--                    <v-card-actions>-->
<!--                      <v-btn color="darken-1" text @click="closeDeleteOrgCommittee">{{$t('btn.cancel','Cancel')}}</v-btn>-->
<!--                      <v-spacer></v-spacer>-->
<!--                      <v-btn color="error" text @click="deleteOrgCommitteeConfirm">{{$t('btn.delete','Delete')}}</v-btn>-->
<!--                    </v-card-actions>-->
<!--                  </v-card>-->
<!--                </v-dialog>-->
<!--              </template>-->
<!--              <template v-slot:item.actions="{ item }">-->
<!--                <v-icon-->
<!--                    small-->
<!--                    @click="deleteOrgCommittee(item)"-->
<!--                >-->
<!--                  mdi-delete-->
<!--                </v-icon>-->
<!--              </template>-->
<!--            </v-data-table>-->
<!--          </template>-->
<!--          <template v-else>-->
<!--            <template v-if="conference.org_committee && conference.org_committee.length > 0">-->
<!--              <v-toolbar dense tile>-->
<!--                {{$t('conference.index.org-committee','Org Committee')}}-->
<!--              </v-toolbar>-->
<!--              <v-slide-group-->
<!--                  show-arrows-->
<!--              >-->
<!--                <v-slide-item-->
<!--                    v-for="org in conference.org_committee"-->
<!--                    :key="org.id"-->
<!--                >-->
<!--                  <v-card-->
<!--                      class="ma-4"-->
<!--                      flat-->
<!--                      max-width="200px"-->
<!--                  >-->
<!--                    <v-card-title>-->
<!--                      <v-img :src="org.avatar_url" :alt="org.full_name" width="100%" height="100%"/>-->
<!--                    </v-card-title>-->
<!--                    <v-card-text>-->
<!--                      {{ org.full_name }}-->
<!--                    </v-card-text>-->
<!--                  </v-card>-->
<!--                </v-slide-item>-->
<!--              </v-slide-group>-->
<!--            </template>-->
<!--          </template>-->
<!--          <template v-if="canEdit">-->
<!--            <v-data-table-->
<!--                :headers="headersEditors"-->
<!--                :items="conference.editors"-->
<!--                :footer-props="{-->
<!--                  itemsPerPageOptions:[5,10,15,20]-->
<!--              }"-->
<!--                class="elevation-1"-->
<!--            >-->
<!--              <template v-slot:top>-->
<!--                <v-toolbar dense flat>-->
<!--                  <span class="text-h5">{{$t('conference.editors.index.title','Editorial Boards')}}</span>-->
<!--                  <v-spacer></v-spacer>-->
<!--                  <v-btn @click="addEditorsDialog" color="primary">{{$t('conference.editors.add','Add User')}}</v-btn>-->
<!--                </v-toolbar>-->
<!--                <v-dialog v-model="dialogAddEditors">-->
<!--                  <v-form-->
<!--                      v-if="newEditor"-->
<!--                      ref="addEditorsForm"-->
<!--                      lazy-validation-->
<!--                      align="center"-->
<!--                      @submit.prevent="addEditorConfirm"-->
<!--                  >-->
<!--                    <v-card>-->
<!--                      <v-card-title>{{$t('conference.editors.create.title','Create')}}</v-card-title>-->
<!--                      <v-card-text>-->
<!--                        <v-autocomplete-->
<!--                            v-model="newEditor.users"-->
<!--                            :label="$t('conference.editors.users','Users')"-->
<!--                            outlined-->
<!--                            prepend-inner-icon="mdi-shape-outline"-->
<!--                            :rules="[rules.required]"-->
<!--                            :items="authors"-->
<!--                            item-text="full_name"-->
<!--                            item-value="id"-->
<!--                            multiple-->
<!--                        ></v-autocomplete>-->
<!--                      </v-card-text>-->
<!--                      <v-card-actions>-->
<!--                        <v-btn color="darken-1" text @click="closeAddEditor">{{$t('btn.cancel','Cancel')}}</v-btn>-->
<!--                        <v-spacer></v-spacer>-->
<!--                        <v-btn color="darken-1" text type="submit">{{$t('btn.create','Create')}}</v-btn>-->
<!--                      </v-card-actions>-->
<!--                    </v-card>-->
<!--                  </v-form>-->
<!--                </v-dialog>-->
<!--                <v-dialog v-model="dialogDeleteEditors" max-width="500px">-->
<!--                  <v-card>-->
<!--                    <v-card-title>{{$t('conference.editors.delete.title','Delete')}}</v-card-title>-->
<!--                    <v-card-text>{{$t('conference.editors.delete.message','Are you sure you want to delete this item?')}}</v-card-text>-->
<!--                    <v-card-actions>-->
<!--                      <v-btn color="darken-1" text @click="closeDeleteEditor">{{$t('btn.cancel','Cancel')}}</v-btn>-->
<!--                      <v-spacer></v-spacer>-->
<!--                      <v-btn color="error" text @click="deleteEditorConfirm">{{$t('btn.delete','Delete')}}</v-btn>-->
<!--                    </v-card-actions>-->
<!--                  </v-card>-->
<!--                </v-dialog>-->
<!--              </template>-->
<!--              <template v-slot:item.actions="{ item }">-->
<!--                <v-icon-->
<!--                    small-->
<!--                    @click="deleteEditor(item)"-->
<!--                >-->
<!--                  mdi-delete-->
<!--                </v-icon>-->
<!--              </template>-->
<!--            </v-data-table>-->
<!--          </template>-->
<!--          <template v-else>-->
<!--            <template v-if="conference.editors && conference.editors.length > 0">-->
<!--              <v-toolbar dense tile>-->
<!--                {{$t('conference.editors.index.title','Editorial Boards')}}-->
<!--              </v-toolbar>-->
<!--              <v-slide-group-->
<!--                  show-arrows-->
<!--              >-->
<!--                <v-slide-item-->
<!--                    v-for="editor in conference.editors"-->
<!--                    :key="editor.id"-->
<!--                >-->
<!--                  <v-card-->
<!--                      class="ma-4"-->
<!--                      flat-->
<!--                      max-width="200px"-->
<!--                  >-->
<!--                    <v-card-title>-->
<!--                      <v-img :src="editor.avatar_url" :alt="editor.full_name" width="100%" height="100%"/>-->
<!--                    </v-card-title>-->
<!--                    <v-card-text>-->
<!--                      {{ editor.full_name }}-->
<!--                    </v-card-text>-->
<!--                  </v-card>-->
<!--                </v-slide-item>-->
<!--              </v-slide-group>-->
<!--            </template>-->
<!--          </template>-->
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import {mapActions, mapState} from "pinia";
import {useConferenceStore} from "@/stores/conference";
import {useUserStore} from "@/stores/user";
import {useAccountStore} from "@/stores/account";
import {useLocalesStore} from "@/stores/l10s";
import {useArticleStore} from "@/stores/article";

export default {
  name: "Show",
  data() {
    return {
      headers: [
        { title: this.$t('articles.placeholder.title','Title'), value: 'full_title' },
        { title: this.$t('articles.placeholder.category','Category'), value: 'category.title' },
        { title: this.$t('articles.placeholder.year','Year'), value: 'year' },
        { title: this.$t('articles.placeholder.actions','Actions'), value: 'actions', sortable: false },
      ],
      headersOrgCommittee: [
        { title: this.$t('articles.placeholder.title','Name'), value: 'full_name' },
        { title: this.$t('articles.placeholder.actions','Actions'), value: 'actions', sortable: false },
      ],
      headersEditors: [
        { title: this.$t('articles.placeholder.title','Name'), value: 'full_name' },
        { title: this.$t('articles.placeholder.actions','Actions'), value: 'actions', sortable: false },
      ],
      dialogAdd: false,
      dialogDelete: false,
      dialogAddOrgCommittee: false,
      dialogDeleteOrgCommittee: false,
      dialogAddEditors: false,
      dialogDeleteEditors: false,
      selectedItem: null,
      selectedOrgCommittee: null,
      selectedEditor: null,
      newItem: null,
      newOrgCommittee: null,
      newEditor: null,
      rules: {
        required: value => !!value || 'Required.',
      },
      options: {},
    };
  },
  computed: {
    ...mapState(useConferenceStore,['conference']),
    ...mapState(useArticleStore,['articles','total']),
    ...mapState(useUserStore,{
      authors:'users',
    }),
    ...mapState(useLocalesStore,['locale']),
    canEdit() {
      return this.conference.user_id === useAccountStore().user.id;
    },
  },
  mounted() {
    this.getConference(this.$route.params.conference_id).catch( () => {
      this.$router.push({name:'error-404'})
    });
    this.downloadAuthors();
  },
  methods: {
    addArticleDialog() {
      this.dialogAdd = true;
      this.newItem = {
        country_id: this.conference.country_id,
        city_id: this.conference.city_id,
        title: '',
        category_id: '',
        year: this.conference.date.slice(0,4),
        authors: [],
        journal: null,
        part: null,
        number: null,
        pages: null,
        publisher: this.conference.title,
        patent_number: null,
        app_number: null,
      };
    },
    deleteItem (item) {
      this.selectedItem = item;
      this.dialogDelete = true
    },
    addArticleConfirm (e) {
      e.preventDefault();
      e.stopPropagation();
      if (!this.$refs.addArticleForm.validate()) return;
      this.$loading();
      // this.$store.dispatch('conference/addArticle',{id:this.conference.id, ...this.newItem})
      //     .then( () => {
      //       this.$loadingClose();
      //       this.$notify('','success', this.$t('messages.success','Success'));
      //       this.closeAdd()
      //     })
      //     .catch( () => {
      //       this.$loadingClose();
      //       this.$notify('','error', this.$t('messages.error','Error'));
      //     });
    },
    deleteItemConfirm () {
      this.$loading();
      this.deleteArticle(this.selectedItem.id)
          .then( () => {
            this.$loadingClose();
            this.$notify('','success', this.$t('messages.success','Success'));
            this.closeDelete();
          })
          .catch( () => {
            this.$loadingClose();
            this.$notify('','error', this.$t('messages.error','Error'));
          });
    },
    closeDelete () {
      this.dialogDelete = false
    },
    addOrgCommitteeDialog() {
      this.dialogAddOrgCommittee = true;
      this.newOrgCommittee = {
        users: [],
      };
    },
    deleteOrgCommittee (item) {
      this.selectedOrgCommittee = item;
      this.dialogDeleteOrgCommittee = true
    },
    addOrgCommitteeConfirm (e) {
      e.preventDefault();
      e.stopPropagation();
      if (!this.$refs.addOrgCommitteeForm.validate()) return;
      this.$loading();
      // this.$store.dispatch('conference/addOrgCommittee',{id:this.conference.id, ...this.newOrgCommittee})
      //     .then( () => {
      //       this.$loadingClose();
      //       this.$notify('','success', this.$t('messages.success','Success'));
      //       this.closeAddOrgCommittee()
      //     })
      //     .catch( () => {
      //       this.$loadingClose();
      //       this.$notify('','error', this.$t('messages.error','Error'));
      //     });
    },
    deleteOrgCommitteeConfirm () {
      this.$loading();
      // this.$store.dispatch('conference/deleteOrgCommittee', {id:this.conference.id, users:[
      //       this.selectedOrgCommittee.id,
      //   ]})
      //     .then( () => {
      //       this.$loadingClose();
      //       this.$notify('','success', this.$t('messages.success','Success'));
      //       this.closeDeleteOrgCommittee();
      //       this.$store.dispatch('conference/getConference', this.$route.params.conference_id);
      //     })
      //     .catch( () => {
      //       this.$loadingClose();
      //       this.$notify('','error', this.$t('messages.error','Error'));
      //     });
    },
    closeAddOrgCommittee() {
      this.dialogAddOrgCommittee = false;
      this.newOrgCommittee = null;
    },
    closeDeleteOrgCommittee () {
      this.dialogDeleteOrgCommittee = false
    },
    addEditorsDialog() {
      this.dialogAddEditors = true;
      this.newEditor = {
        users: [],
      };
    },
    deleteEditor (item) {
      this.selectedEditor = item;
      this.dialogDeleteEditors = true
    },
    addEditorConfirm (e) {
      e.preventDefault();
      e.stopPropagation();
      if (!this.$refs.addEditorsForm.validate()) return;
      this.$loading();
      // this.$store.dispatch('conference/addEditors',{id:this.conference.id, ...this.newEditor})
      //     .then( () => {
      //       this.$loadingClose();
      //       this.$notify('','success', this.$t('messages.success','Success'));
      //       this.closeAddEditor()
      //     })
      //     .catch( () => {
      //       this.$loadingClose();
      //       this.$notify('','error', this.$t('messages.error','Error'));
      //     });
    },
    deleteEditorConfirm () {
      this.$loading();
      // this.$store.dispatch('conference/deleteEditors', {id:this.conference.id, users:[
      //       this.selectedEditor.id,
      //   ]})
      //     .then( () => {
      //       this.$loadingClose();
      //       this.$notify('','success', this.$t('messages.success','Success'));
      //       this.closeDeleteEditor();
      //       this.$store.dispatch('conference/getConference', this.$route.params.conference_id);
      //     })
      //     .catch( () => {
      //       this.$loadingClose();
      //       this.$notify('','error', this.$t('messages.error','Error'));
      //     });
    },
    closeAddEditor() {
      this.dialogAddEditors = false;
      this.newEditor = null;
    },
    closeDeleteEditor () {
      this.dialogDeleteEditors = false
    },
    getArticles() {
      this.$loading()
      this.downloadArticles( {
        conference_id: this.$route.params.conference_id,
        ...this.options,
      }).then(() => {
        this.$loadingClose();
      }).catch(() => {
        this.$loadingClose();
      });
    },
    ...mapActions(useConferenceStore,['getConference']),
    ...mapActions(useUserStore,['downloadAuthors']),
    ...mapActions(useArticleStore,['downloadArticles','deleteArticle'])
  },
}
</script>

<style scoped>

</style>
