
<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-form
            v-if="conference"
            ref="addArticleForm"
            lazy-validation
            align="center"
            @submit.prevent="addArticleConfirm"
        >
          <v-card>
            <v-card-title>{{$t('article.add.title','Add')}}</v-card-title>
            <v-card-text>
              <v-tabs v-model="activeTitleTab" align-tabs="end" class="pb-1" selected-class="text-primary">
                <v-tab key="en">English</v-tab>
                <v-tab key="uk">Українська</v-tab>
              </v-tabs>
              <v-window v-model="activeTitleTab" class="pt-2">
                <v-window-item key="en">
                  <v-text-field
                      v-model="newItem.title.en"
                      :label="$t('articles.placeholder.title','Title')"
                      variant="outlined"
                      prepend-inner-icon="mdi-card-text-outline"
                      :rules="[rules.required]"
                  />
                </v-window-item>
                <v-window-item key="uk">
                  <v-text-field
                      v-model="newItem.title.uk"
                      :label="$t('articles.placeholder.title','Title')"
                      variant="outlined"
                      prepend-inner-icon="mdi-card-text-outline"
                      :rules="[rules.required]"
                  />
                </v-window-item>
              </v-window>
              <div class="d-flex justify-end my-2">
                <v-btn prepend-icon="mdi-plus" variant="text" @click="openAddAuthorsDialog">{{$t('authors.btn.add','Add')}}</v-btn>
                <v-dialog v-model="addAuthorsDialog" transition="dialog-bottom-transition" fullscreen>
                  <v-card>
                    <v-toolbar>
                      <v-btn icon="mdi-close" @click="closeAddAuthorsDialog"></v-btn>
                      <v-toolbar-title>{{$t('authors.add.title','Add Author')}}</v-toolbar-title>
                    </v-toolbar>
                    <v-container>
                      <v-row>
                        <v-col cols="12">
                          <v-form v-if="newAuthor"
                                  ref="addAuthorForm"
                                  validate-on="lazy input"
                                  fast-fail
                                  lazy-validation
                                  align="center"
                                  @submit.prevent="addAuthorConfirm">
                            <v-card-text>
                              <v-tabs v-model="activePositionTab" align-tabs="end" class="pb-1" selected-class="text-primary">
                                <v-tab key="en">English</v-tab>
                                <v-tab key="uk">Українська</v-tab>
                              </v-tabs>
                              <v-window v-model="activePositionTab" class="pt-2">
                                <v-window-item key="en">
                                  <v-text-field
                                      v-model="newAuthor.first_name.en"
                                      :label="$t('placeholder.first_name', 'First Name')"
                                      variant="outlined"
                                      prepend-inner-icon="mdi-account-outline"
                                      :rules="[rules.required]"
                                  />
                                  <v-text-field
                                      v-model="newAuthor.second_name.en"
                                      :label="$t('placeholder.second_name', 'Second Name')"
                                      variant="outlined"
                                      prepend-inner-icon="mdi-account-outline"
                                      :rules="[rules.required]"
                                      aria-autocomplete="none"
                                  />
                                  <v-text-field
                                      v-model="newAuthor.surname.en"
                                      :label="$t('placeholder.surname', 'Surname')"
                                      variant="outlined"
                                      prepend-inner-icon="mdi-account-outline"
                                      :rules="[rules.required]"
                                  />
                                </v-window-item>
                                <v-window-item key="uk">
                                  <v-text-field
                                      v-model="newAuthor.first_name.uk"
                                      :label="$t('placeholder.first_name', 'First Name')"
                                      variant="outlined"
                                      prepend-inner-icon="mdi-account-outline"
                                      :rules="[rules.required]"
                                  />
                                  <v-text-field
                                      v-model="newAuthor.second_name.uk"
                                      :label="$t('placeholder.second_name', 'Second Name')"
                                      variant="outlined"
                                      prepend-inner-icon="mdi-account-outline"
                                      :rules="[rules.required]"
                                      aria-autocomplete="none"
                                  />
                                  <v-text-field
                                      v-model="newAuthor.surname.uk"
                                      :label="$t('placeholder.surname', 'Surname')"
                                      variant="outlined"
                                      prepend-inner-icon="mdi-account-outline"
                                      :rules="[rules.required]"
                                  />
                                </v-window-item>
                              </v-window>
                              <v-text-field
                                  v-model="newAuthor.email"
                                  variant="outlined"
                                  prepend-inner-icon="mdi-email-outline"
                                  :label="$t('placeholder.email', 'Email')"
                                  :rules="[rules.required, rules.email]"
                                  :error="emailError.length > 0"
                                  :error-messages="emailError"
                                  @change.stop="clearErrors"
                                  type="email"
                              />
                            </v-card-text>
                            <v-card-actions>
                              <v-btn :text="$t('btn.cancel','Cancel')" variant="text" @click="closeAddAuthorsDialog"></v-btn>
                              <v-spacer/>
                              <v-btn color="primary" :text="$t('authors.btn.add','Add')" variant="flat" type="submit"></v-btn>
                            </v-card-actions>
                          </v-form>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-card>
                </v-dialog>
              </div>
              <v-autocomplete
                  v-model="newItem.authors"
                  :label="$t('articles.placeholder.authors','Authors')"
                  outlined
                  prepend-inner-icon="mdi-shape-outline"
                  :rules="[rules.required]"
                  :items="authors"
                  item-title="full_name"
                  item-value="id"
                  multiple
              ></v-autocomplete>
            </v-card-text>
            <v-card-actions>
              <v-btn color="darken-1" variant="text" :to="{name:'Conference Show',params:{conference_id:$route.params.conference_id}}">{{$t('btn.cancel','Cancel')}}</v-btn>
              <v-spacer></v-spacer>
              <v-btn color="primary" variant="text" type="submit">{{$t('btn.create','Create')}}</v-btn>
            </v-card-actions>
          </v-card>
        </v-form>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import {mapActions, mapState} from "pinia";
import {useConferenceStore} from "@/stores/conference";
import {useUserStore} from "@/stores/user";
import {useAccountStore} from "@/stores/account";

export default {
  name: "Add",
  data() {
    return {
      newItem:{
        conference_id:this.$route.params.conference_id,
        title:{
          en:'',
          uk:'',
        },
        authors:[],
      },
      authors:[],
      rules: {
        required: value => !!value || 'Required.',
        email: value => {
          const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
          return pattern.test(value) || 'Invalid e-mail.'
        },
      },
      addAuthorsDialog:false,
      newAuthor: {
        first_name:{
          en:'',
          uk:'',
        },
        second_name:{
          en:'',
          uk:'',
        },
        surname:{
          en:'',
          uk:'',
        },
        email:'',
      },
      emailError: [],
      activeTitleTab:'en',
      activePositionTab:'en',
    };
  },
  computed: {
    ...mapState(useConferenceStore,['conference']),
    canEdit() {
      return this.conference.user_id === useAccountStore().user.id;
    },
  },
  mounted() {
    this.getConference(this.$route.params.conference_id)
        .then( (res) => {
            if (!this.canEdit) {
              this.$router.push({name:'error-404'})
            }
        }).catch( () => {
          this.$router.push({name:'error-404'})
        })
    this.downloadAuthors()
        .then( (res) => {
          this.authors = res;
        });
  },
  methods: {
    addArticleConfirm(e) {
      e.preventDefault();
      e.stopPropagation();
      this.$loading();
      this.$refs.addArticleForm.validate().then((valid) => {
        if (!valid.valid) {
          this.$loadingClose();
          return;
        }
        this.addArticle(this.newItem)
            .then(() => {
              this.$loadingClose();
              this.$notify('','success', this.$t('messages.success','Success'));
              this.$router.push({name:'Conference Show',params:{conference_id:this.$route.params.conference_id}});
            }).catch( (error) => {
              this.$loadingClose();
              this.$notify('', 'error', error.message);
              this.emailError = error.errors.email;
            })
      })
    },
    openAddAuthorsDialog() {
      this.addAuthorsDialog = true;
      this.clearAddAuthorForm();
    },
    closeAddAuthorsDialog() {
      this.addAuthorsDialog = false;
    },
    clearErrors() {
      this.emailError = [];
    },
    addAuthorConfirm(e) {
      e.preventDefault();
      e.stopPropagation();
      this.$loading();
      this.$refs.addAuthorForm.validate().then((valid) => {
        if (!valid.valid) {
          this.$loadingClose();
          return;
        }

        this.createUser(this.newAuthor)
            .then(() => {
              this.$loadingClose();
              this.$notify('','success', this.$t('messages.success','Success'));
              this.clearAddAuthorForm();
            }).catch( (error) => {
              this.$loadingClose();
              this.$notify('', 'error', error.message);
              this.emailError = error.errors.email;
            })
      })
    },
    clearAddAuthorForm() {
      this.emailError = [];
      if (this.$refs.addAuthorForm) {
        this.$refs.addAuthorForm.reset();
      }
    },
    ...mapActions(useConferenceStore,['getConference','addArticle']),
    ...mapActions(useUserStore,['downloadAuthors','createUser'])
  }
}
</script>

<style scoped>

</style>
