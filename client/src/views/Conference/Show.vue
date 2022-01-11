<template>
  <v-row>
    <v-col cols="12">
      <v-card v-if="conference">
        <v-card-title class="pb-0">
          <v-toolbar dense color="primary">
            {{conference.title}}
          </v-toolbar>
        </v-card-title>
        <v-card-text>
          <v-list outlined>
            <div v-if="conference.country_id">
              <v-list-item >
                <v-list-item-action>
                  <v-icon>mdi-account</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                  <v-list-item-subtitle>{{$t('conference.placeholder.country', 'Country')}}</v-list-item-subtitle>
                  <v-list-item-title>{{conference.country.name}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-divider/>
            </div>
            <div v-if="conference.city_id">
              <v-list-item >
                <v-list-item-action>
                  <v-icon>mdi-account</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                  <v-list-item-subtitle>{{$t('conference.placeholder.city', 'City')}}</v-list-item-subtitle>
                  <v-list-item-title>{{conference.city.name}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-divider/>
            </div>
            <div v-if="conference.title">
              <v-list-item >
                <v-list-item-action>
                  <v-icon>mdi-account</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                  <v-list-item-subtitle>{{$t('conference.placeholder.title', 'Title')}}</v-list-item-subtitle>
                  <v-list-item-title>{{conference.title}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-divider/>
            </div>
            <div v-if="conference.date">
              <v-list-item >
                <v-list-item-action>
                  <v-icon>mdi-account</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                  <v-list-item-subtitle>{{$t('conference.placeholder.date', 'Date')}}</v-list-item-subtitle>
                  <v-list-item-title>{{conference.date}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-divider/>
            </div>
            <div v-if="conference.organizers">
              <v-toolbar dense tile>
                {{$t('home.organizers.title','Organizers')}}
              </v-toolbar>
              <v-slide-group
                  show-arrows
              >
                <v-slide-item
                    v-for="organizer in conference.organizers"
                    :key="organizer.id"
                >
                  <v-card
                      class="ma-4"
                      flat
                      max-width="200px"
                  >
                    <v-card-title>
                      <v-img :src="organizer.logo_url" :alt="organizer.title" width="100%" height="100%"/>
                    </v-card-title>
                    <v-card-text>
                    {{ organizer.title }}
                    </v-card-text>
                  </v-card>
                </v-slide-item>
              </v-slide-group>
            </div>
          </v-list>
          <div>
            <v-data-table
                :headers="headers"
                :items="conference.articles"
                :footer-props="{
                  itemsPerPageOptions:[5,10,15,20]
              }"
                class="elevation-1"
            >
              <template v-slot:top>
                <v-toolbar dense flat>
                  <span class="text-h5">{{$t('articles.index.title','Articles')}}</span>
                  <v-spacer></v-spacer>
                  <v-btn @click="addArticleDialog" color="primary">{{$t('articles.create.btn.add','Add Article')}}</v-btn>
                </v-toolbar>
                <v-dialog v-model="dialogAdd">
                  <v-form
                      v-if="newItem"
                      ref="createConferenceForm"
                      lazy-validation
                      align="center"
                      @submit.prevent="addArticleConfirm"
                  >
                    <v-card>
                      <v-card-title>{{$t('article.create.title','Create')}}</v-card-title>
                      <v-card-text>
                        <v-text-field
                            v-model="newItem.title"
                            :label="$t('article.placeholder.title','Title')"
                            outlined
                            prepend-inner-icon="mdi-card-text-outline"
                            :rules="[rules.required]"
                        />
                        <v-select
                            v-model="newItem.category_id"
                            :label="$t('articles.placeholder.category','Category')"
                            outlined
                            prepend-inner-icon="mdi-shape-outline"
                            :rules="[rules.required]"
                            :items="categories"
                            item-text="title"
                            item-value="id"
                        ></v-select>
                        <v-select
                            v-model="newItem.authors"
                            :label="$t('articles.placeholder.authors','Authors')"
                            outlined
                            prepend-inner-icon="mdi-shape-outline"
                            :rules="[rules.required]"
                            :items="authors"
                            item-text="full_name"
                            item-value="id"
                            multiple
                        ></v-select>
                        <v-text-field
                            v-if="checkCategory(['article','conference','section'])"
                            v-model="newItem.journal"
                            :label="$t(checkCategoryTitleLabelTranslate(), 'Journal')"
                            outlined
                            prepend-inner-icon="mdi-card-text-outline"
                            :rules="[rules.required]"
                        />
                        <v-text-field
                            v-if="checkCategory(['article','conference','section', 'book','conference'])"
                            v-model="newItem.part"
                            :label="$t('articles.placeholder.part', 'Part')"
                            outlined
                            prepend-inner-icon="mdi-card-text-outline"
                            :rules="[rules.required]"
                        />
                        <v-text-field
                            v-if="checkCategory(['article','conference'])"
                            v-model="newItem.number"
                            :label="$t('articles.placeholder.number', 'Number')"
                            outlined
                            prepend-inner-icon="mdi-card-text-outline"
                            :rules="[rules.required]"
                        />
                        <v-text-field
                            v-if="checkCategory(['article','conference','section', 'book','conference','guidelines'])"
                            v-model="newItem.pages"
                            :label="$t('articles.placeholder.pages', 'Pages')"
                            outlined
                            prepend-inner-icon="mdi-card-text-outline"
                            :rules="[rules.required]"
                        />
                        <v-text-field
                            v-if="checkCategory(['patent'])"
                            v-model="newItem.patent_number"
                            :label="$t('articles.placeholder.patent_number', 'Patent Number')"
                            outlined
                            prepend-inner-icon="mdi-card-text-outline"
                            :rules="[rules.required]"
                        />
                        <v-text-field
                            v-if="checkCategory(['patent'])"
                            v-model="newItem.app_number"
                            :label="$t('articles.placeholder.app_number','App Number')"
                            outlined
                            prepend-inner-icon="mdi-card-text-outline"
                            :rules="[rules.required]"
                        />
                      </v-card-text>
                      <v-card-actions>
                        <v-btn color="darken-1" text @click="closeAdd">{{$t('btn.cancel','Cancel')}}</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn color="darken-1" text type="submit">{{$t('btn.create','Create')}}</v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-form>
                </v-dialog>
                <v-dialog v-model="dialogDelete" max-width="500px">
                  <v-card>
                    <v-card-title>{{$t('articles.delete.title','Delete')}}</v-card-title>
                    <v-card-text>{{$t('articles.delete.message','Are you sure you want to delete this item?')}}</v-card-text>
                    <v-card-actions>
                      <v-btn color="darken-1" text @click="closeDelete">{{$t('btn.cancel','Cancel')}}</v-btn>
                      <v-spacer></v-spacer>
                      <v-btn color="error" text @click="deleteItemConfirm">{{$t('btn.delete','Delete')}}</v-btn>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
              </template>
              <template v-slot:item.actions="{ item }">
                  <v-icon
                      small
                      @click="deleteItem(item)"
                  >
                    mdi-delete
                  </v-icon>
              </template>
            </v-data-table>
          </div>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import {mapState} from "vuex";

export default {
  name: "Show",
  data() {
    return {
      headers: [
        { text: this.$t('articles.placeholder.title','Title'), value: 'title' },
        { text: this.$t('articles.placeholder.category','Category'), value: 'category.title' },
        { text: this.$t('articles.placeholder.year','Year'), value: 'year' },
        { text: this.$t('articles.placeholder.actions','Actions'), value: 'actions', sortable: false },
      ],
      dialogAdd: false,
      dialogDelete: false,
      selectedItem: null,
      newItem: null,
      rules: {
        required: value => !!value || 'Required.',
      },
    };
  },
  computed: {
    ...mapState({
      conference: (state) => state.conference.conference,
      authors: (state) => state.user.users,
      categories: (state) => state.article.categories,
    })
  },
  mounted() {
    this.$store.dispatch('conference/getConference', this.$route.params.conference_id);
    this.$store.dispatch('user/downloadAuthors');
    this.$store.dispatch('article/downloadCategories');
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
      if (!this.$refs.createConferenceForm.validate()) return;
      this.$loading();
      this.$store.dispatch('conference/addArticle',{id:this.conference.id, ...this.newItem})
          .then( () => {
            this.$loadingClose();
            this.$notify('','success', this.$t('messages.success','Success'));
            this.closeAdd()
          })
          .catch( () => {
            this.$loadingClose();
            this.$notify('','error', this.$t('messages.error','Error'));
          });
    },
    deleteItemConfirm () {
      this.$loading();
      this.$store.dispatch('article/deleteArticle', this.selectedItem.id)
          .then( () => {
            this.$loadingClose();
            this.$notify('','success', this.$t('messages.success','Success'));
            this.closeDelete();
            this.$store.dispatch('conference/getConference', this.$route.params.conference_id);
          })
          .catch( () => {
            this.$loadingClose();
            this.$notify('','error', this.$t('messages.error','Error'));
          });
    },
    closeAdd() {
      this.dialogAdd = false;
      this.newItem = null;
    },
    closeDelete () {
      this.dialogDelete = false
    },
    checkCategory(arr) {

      let category = this.categories.find( (c) => c.id === this.newItem.category_id);
      if (!category) {
        return false;
      }
      return arr.includes(category.tech_name);
    },
    checkCategoryTitleLabelTranslate() {
      let category = this.categories.find( (c) => c.id === this.newItem.category_id);
      if (!category) return;
      if (category.tech_name === 'article') {
        return 'articles.placeholder.journal';
      }
      if (category.tech_name === 'section') {
        return 'articles.placeholder.book';
      }
      if (category.tech_name === 'conference') {
        return 'articles.placeholder.conference';
      }
    }
  },
}
</script>

<style scoped>

</style>