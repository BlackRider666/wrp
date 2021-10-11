<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <v-card-text>
          <v-data-table
              :headers="headers"
              :items="articles"
              class="elevation-1"
          >
            <template v-slot:top>
              <v-toolbar dense flat>
                <span class="text-h5">{{$t('articles.index.title','Articles')}}</span>
                <v-spacer></v-spacer>
                <v-btn :to="{name:'Create Article'}" color="primary">{{$t('articles.create.btn.add','Add Article')}}</v-btn>
              </v-toolbar>
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
                <v-dialog v-model="dialogEdit" max-width="500px">
                  <v-form
                      v-if="selectedItem"
                      ref="updateArticleForm"
                      lazy-validation
                      align="center"
                      @submit.prevent="editItemConfirm"
                  >
                  <v-card>
                    <v-card-title>{{$t('articles.edit.title','Edit')}}</v-card-title>
                    <v-card-text>
                      <v-text-field
                          v-model="selectedItem.title"
                          :label="$t('articles.placeholder.title','Title')"
                          outlined
                          prepend-inner-icon="mdi-card-text-outline"
                          :rules="[rules.required]"
                      />
                      <v-select
                          v-model="selectedItem.category_id"
                          :label="$t('articles.placeholder.category','Category')"
                          outlined
                          prepend-inner-icon="mdi-shape-outline"
                          :rules="[rules.required]"
                          :items="categories"
                          item-text="title"
                          item-value="id"
                      ></v-select>
                      <v-text-field
                          v-model="selectedItem.year"
                          :label="$t('articles.placeholder.year', 'Year')"
                          outlined
                          prepend-inner-icon="mdi-calendar-range"
                          :rules="[rules.required]"
                      ></v-text-field>
                      <v-select
                          v-model="selectedItem.authors"
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
                          v-model="selectedItem.journal"
                          :label="$t(checkCategoryTitleLabelTranslate(), 'Journal')"
                          outlined
                          prepend-inner-icon="mdi-card-text-outline"
                          :rules="[rules.required]"
                      />
                      <v-text-field
                          v-if="checkCategory(['article','conference','section', 'book','conference'])"
                          v-model="selectedItem.part"
                          :label="$t('articles.placeholder.part', 'Part')"
                          outlined
                          prepend-inner-icon="mdi-card-text-outline"
                          :rules="[rules.required]"
                      />
                      <v-text-field
                          v-if="checkCategory(['article','conference'])"
                          v-model="selectedItem.number"
                          :label="$t('articles.placeholder.number', 'Number')"
                          outlined
                          prepend-inner-icon="mdi-card-text-outline"
                          :rules="[rules.required]"
                      />
                      <v-text-field
                          v-if="checkCategory(['article','conference','section', 'book','conference','guidelines'])"
                          v-model="selectedItem.pages"
                          :label="$t('articles.placeholder.pages', 'Pages')"
                          outlined
                          prepend-inner-icon="mdi-card-text-outline"
                          :rules="[rules.required]"
                      />
                      <v-text-field
                          v-if="checkCategory(['article','section','guidelines'])"
                          v-model="selectedItem.publisher"
                          :label="$t('articles.placeholder.publisher', 'Publisher')"
                          outlined
                          prepend-inner-icon="mdi-card-text-outline"
                          :rules="[rules.required]"
                      />
                      <v-select
                          v-if="checkCategory(['patent'])"
                          v-model="selectedItem.country"
                          :label="$t('articles.placeholder.country', 'Country')"
                          outlined
                          prepend-inner-icon="mdi-shape-outline"
                          :rules="[rules.required]"
                          :items="countries"
                      ></v-select>
                      <v-text-field
                          v-if="checkCategory(['patent'])"
                          v-model="selectedItem.patent_number"
                          :label="$t('articles.placeholder.patent_number', 'Patent Number')"
                          outlined
                          prepend-inner-icon="mdi-card-text-outline"
                          :rules="[rules.required]"
                      />
                      <v-text-field
                          v-if="checkCategory(['patent'])"
                          v-model="selectedItem.app_number"
                          :label="$t('articles.placeholder.app_number','App Number')"
                          outlined
                          prepend-inner-icon="mdi-card-text-outline"
                          :rules="[rules.required]"
                      />
                    </v-card-text>
                    <v-card-actions>
                      <v-btn color="darken-1" text @click="closeEdit">{{$t('btn.cancel','Cancel')}}</v-btn>
                      <v-spacer></v-spacer>
                      <v-btn color="darken-1" text type="submit">{{$t('btn.update','Update')}}</v-btn>
                    </v-card-actions>
                  </v-card>
                  </v-form>
                </v-dialog>
            </template>
            <template v-slot:item.actions="{ item }">
              <v-icon
                  small
                  class="mr-2"
                  @click="showItem(item)"
              >
                mdi-eye
              </v-icon>
              <v-icon
                  small
                  class="mr-2"
                  @click="editItem(item)"
              >
                mdi-pencil
              </v-icon>
              <v-icon
                  small
                  @click="deleteItem(item)"
              >
                mdi-delete
              </v-icon>
            </template>
          </v-data-table>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import {mapState} from "vuex";

export default {
  name: "Index",
  data() {
    return {
      headers: [
        { text: this.$t('articles.placeholder.title','Title'), value: 'title' },
        { text: this.$t('articles.placeholder.category','Category'), value: 'category.title' },
        { text: this.$t('articles.placeholder.year','Year'), value: 'year' },
        { text: this.$t('articles.placeholder.actions','Actions'), value: 'actions', sortable: false },
      ],
      dialogEdit: false,
      dialogDelete: false,
      selectedItem: null,
      countries:[
        {
          text:'Ukraine',
          value:'Ukraine',
        },
        {
          text:'USA',
          value:'USA',
        },
      ],
      rules: {
        required: value => !!value || 'Required.',
      },
    };
  },
  computed: {
    ...mapState({
      articles: (state) => state.article.articles,
      categories: (state) => state.article.categories,
      authors: (state) => state.user.users,
    }),
  },
  mounted() {
    this.$store.dispatch('article/downloadArticles');
    this.$store.dispatch('article/downloadCategories');
    this.$store.dispatch('user/downloadAuthors');
  },
  methods: {
    showItem (item) {
      this.$store.dispatch('article/chooseArticle',item);
      this.$router.push( { name: 'Article', params: { article_id: item.id } });
    },
    editItem (item) {
      this.selectedItem = item;
      this.dialogEdit = true
    },

    deleteItem (item) {
      this.selectedItem = item;
      this.dialogDelete = true
    },

    deleteItemConfirm () {
      this.$loading();
      this.$store.dispatch('article/deleteArticle', this.selectedItem.id)
          .then( () => {
            this.$loadingClose();
            this.$notify('','success', this.$t('messages.success','Success'));
            this.closeDelete()
          });
    },
    editItemConfirm (e) {
      e.preventDefault();
      e.stopPropagation();
      if (!this.$refs.updateArticleForm.validate()) return;
      this.$loading();
      this.selectedItem.authors = this.selectedItem.authors.map( (a) => a.id);
      this.$store.dispatch('article/updateArticle', this.selectedItem)
          .then( () => {
            this.$loadingClose();
            this.$notify('','success', this.$t('messages.success','Success'));
            this.closeEdit()
          });
    },
    closeEdit () {
      this.dialogEdit = false;
      this.selectedItem = null;
    },

    closeDelete () {
      this.dialogDelete = false
    },

    checkCategory(arr) {
      let category = this.categories.find( (c) => c.id === this.selectedItem.category_id);
      if (!category) {
        return false;
      }
      return arr.includes(category.tech_name);
    },
    checkCategoryTitleLabelTranslate() {
      let category = this.categories.find( (c) => c.id === this.selectedItem.category_id);
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