<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <v-card-title>
          <v-toolbar dense color="primary">
            {{$t('articles.create.title','Create Article')}}
          </v-toolbar>
        </v-card-title>
        <v-card-text>
          <v-sheet outlined>
            <v-form
                ref="form"
                lazy-validation
                align="center"
                @submit.prevent="createArticle"
            ><v-card
                flat
            >
              <v-card-text>
                <v-select
                    v-model="article.country_id"
                    :items="countries"
                    item-text="name"
                    item-value="id"
                    :label="$t('article.placeholder.country','Country')"
                    prepend-inner-icon="mdi-database-search"
                    outlined
                ></v-select>
                <v-select
                    v-model="article.city_id"
                    :items="cities"
                    item-text="name"
                    item-value="id"
                    :label="$t('article.placeholder.city','City')"
                    prepend-inner-icon="mdi-database-search"
                    outlined
                ></v-select>
                <v-tabs v-model="activeTitleTab" right class="pb-1">
                  <v-tab key="en">English</v-tab>
                  <v-tab key="uk">Українська</v-tab>
                </v-tabs>
                <v-tabs-items v-model="activeTitleTab" class="pt-2">
                  <v-tab-item key="en">
                    <v-text-field
                        v-model="article.title.en"
                        :label="$t('articles.placeholder.title','Title')"
                        outlined
                        prepend-inner-icon="mdi-card-text-outline"
                        :rules="[rules.required]"
                    />
                  </v-tab-item>
                  <v-tab-item key="uk">
                    <v-text-field
                        v-model="article.title.uk"
                        :label="$t('articles.placeholder.title','Title')"
                        outlined
                        prepend-inner-icon="mdi-card-text-outline"
                        :rules="[rules.required]"
                    />
                  </v-tab-item>
                </v-tabs-items>
                <v-select
                  v-model="article.category_id"
                  :label="$t('articles.placeholder.category','Category')"
                  outlined
                  prepend-inner-icon="mdi-shape-outline"
                  :rules="[rules.required]"
                  :items="categories"
                  item-text="title"
                  item-value="id"
                ></v-select>
                <v-text-field
                  v-model="article.year"
                  :label="$t('articles.placeholder.year', 'Year')"
                  outlined
                  prepend-inner-icon="mdi-calendar-range"
                  :rules="[rules.required]"
                ></v-text-field>
                <v-select
                    v-model="article.authors"
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
                    v-model="article.journal"
                    :label="$t(checkCategoryTitleLabelTranslate(), 'Journal')"
                    outlined
                    prepend-inner-icon="mdi-card-text-outline"
                    :rules="[rules.required]"
                />
                <v-text-field
                    v-if="checkCategory(['article','conference','section', 'book','conference'])"
                    v-model="article.part"
                    :label="$t('articles.placeholder.part', 'Part')"
                    outlined
                    prepend-inner-icon="mdi-card-text-outline"
                    :rules="[rules.required]"
                />
                <v-text-field
                    v-if="checkCategory(['article','conference'])"
                    v-model="article.number"
                    :label="$t('articles.placeholder.number', 'Number')"
                    outlined
                    prepend-inner-icon="mdi-card-text-outline"
                    :rules="[rules.required]"
                />
                <v-text-field
                    v-if="checkCategory(['article','conference','section', 'book','conference','guidelines'])"
                    v-model="article.pages"
                    :label="$t('articles.placeholder.pages', 'Pages')"
                    outlined
                    prepend-inner-icon="mdi-card-text-outline"
                    :rules="[rules.required]"
                />
                <v-text-field
                    v-if="checkCategory(['article','section','guidelines'])"
                    v-model="article.publisher"
                    :label="$t('articles.placeholder.publisher', 'Publisher')"
                    outlined
                    prepend-inner-icon="mdi-card-text-outline"
                    :rules="[rules.required]"
                />
                <v-select
                    v-if="checkCategory(['patent'])"
                    v-model="article.country"
                    :label="$t('articles.placeholder.patent_country', 'Patent Country')"
                    outlined
                    prepend-inner-icon="mdi-shape-outline"
                    :rules="[rules.required]"
                    :items="countries"
                    item-text="name"
                    item-value="name"
                ></v-select>
                <v-text-field
                    v-if="checkCategory(['patent'])"
                    v-model="article.patent_number"
                    :label="$t('articles.placeholder.patent_number', 'Patent Number')"
                    outlined
                    prepend-inner-icon="mdi-card-text-outline"
                    :rules="[rules.required]"
                />
                <v-text-field
                    v-if="checkCategory(['patent'])"
                    v-model="article.app_number"
                    :label="$t('articles.placeholder.app_number','App Number')"
                    outlined
                    prepend-inner-icon="mdi-card-text-outline"
                    :rules="[rules.required]"
                />
                <v-tabs v-model="activeDescTab" right class="pb-1">
                  <v-tab key="en">English</v-tab>
                  <v-tab key="uk">Українська</v-tab>
                </v-tabs>
                <v-tabs-items v-model="activeDescTab">
                  <v-tab-item key="en">
                    <SimpleEditor
                        v-model="article.desc.en"
                        :placeholder="$t('articles.placeholder.desc', 'Desc')"
                    ></SimpleEditor>
                  </v-tab-item>
                  <v-tab-item key="uk">
                    <SimpleEditor
                        v-model="article.desc.uk"
                        :placeholder="$t('articles.placeholder.desc', 'Desc')"
                    ></SimpleEditor>
                  </v-tab-item>
                </v-tabs-items>
                <v-tabs v-model="activeFullTextTab" right class="pb-1">
                  <v-tab key="en">English</v-tab>
                  <v-tab key="uk">Українська</v-tab>
                </v-tabs>
                <v-tabs-items v-model="activeFullTextTab">
                  <v-tab-item key="en">
                    <FullEditor v-model="article.full_text.en" :placeholder="$t('articles.placeholder.full_text', 'Full text')"/>
                  </v-tab-item>
                  <v-tab-item key="uk">
                    <FullEditor v-model="article.full_text.uk" :placeholder="$t('articles.placeholder.full_text', 'Full text')"/>
                  </v-tab-item>
                </v-tabs-items>
                <v-autocomplete
                    v-model="article.tags"
                    :items="tags"
                    hide-no-data
                    multiple
                    item-text="name"
                    item-value="id"
                    :label="$t('tags.placeholder.select','Tags')"
                    :placeholder="$t('tags.placeholder.select','Tags')"
                    prepend-inner-icon="mdi-database-search"
                    :search-input.sync="tagSearch"
                    @update:search-input="(value) => changeSearchTags(value)"
                    @change="changeTags"
                    return-object
                    outlined
                    chips
                    deletable-chips
                >
                </v-autocomplete>
                <v-autocomplete
                    v-model="article.citations"
                    :items="articles"
                    hide-no-data
                    multiple
                    item-text="full_title"
                    item-value="id"
                    :label="$t('articles.placeholder.citation','Citation')"
                    :placeholder="$t('articles.placeholder.citation','Citation')"
                    prepend-inner-icon="mdi-database-search"
                    :search-input.sync="articleSearch"
                    @update:search-input="(value) => changeSearchArticles(value)"
                    @change="changeArticles"
                    outlined
                    chips
                    deletable-chips
                    :loading="loadingCitation"
                >
                </v-autocomplete>
                <v-file-input
                    :rules="[rules.required]"
                    accept="file/pdf"
                    prepend-inner-icon="mdi-file"
                    prepend-icon=""
                    :label="$t('placeholder.file','File')"
                    outlined
                    v-model="file"
                ></v-file-input>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" type="submit">{{$t('btn.create','Create')}}</v-btn>
              </v-card-actions>
            </v-card>
            </v-form>
          </v-sheet>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import {mapState} from "vuex";
import {debouncer} from '@/plugins/l10s';
import FullEditor from '@/components/editor/FullEditor';
import SimpleEditor from "@/components/editor/SimpleEditor";
const debounceRequest = debouncer(1500)
export default {
  name: "Create",
  components: {
    SimpleEditor,
    FullEditor,
  },
  data() {
    return {
      article: {
        title: {
          en: '',
          uk: '',
        },
        category_id: null,
        year: '',
        authors: [],
        journal: null,
        part: null,
        number: null,
        pages: null,
        publisher: null,
        country: null,
        patent_number: null,
        app_number: null,
        tags:[],
        citations: [],
        desc: {
          en: '',
          uk: '',
        },
        full_text:{
          en: '',
          uk: '',
        },
      },
      file: null,
      rules: {
        required: value => !!value || 'Required.',
      },
      tags:[],
      tagSearch: null,
      articleSearch: null,
      loadingCitation: false,
      activeTitleTab: 'en',
      activeDescTab: 'en',
      activeFullTextTab: 'en',
    };
  },
  computed: {
    ...mapState({
      categories: (state) => state.article.categories,
      authors: (state) => state.user.users,
      countries: (state) => state.country.countries,
      cities: (state) => state.city.cities,
      articles: (state) => state.article.articles,
    }),
  },
  mounted() {
    this.$store.dispatch('article/downloadCategories');
    this.$store.dispatch('user/downloadAuthors');
    this.article.authors.push(this.$store.getters['account/getAccount'].id);
    this.$store.dispatch('country/downloadCountries');
    this.$store.dispatch('tags/downloadTags').then( (tags) => {
      this.tags = tags;
    });
  },
  methods: {
    createArticle(e) {
      e.preventDefault();
      e.stopPropagation();
      if (!this.$refs.form.validate()) return;
      this.$loading();
      let form = new FormData();
      for (const [key, value] of Object.entries(this.article)) {
        if (Array.isArray(value)) {
          for(let i =0; i < value.length; i++) {
            if (typeof value[i] === 'object') {
              for (let k in value[i] ) {
                form.append(key+'['+i+']'+'['+k+']', value[i][k]);
              }
            } else {
              form.append(key+'['+i+']',value[i])
            }
          }
        } else {
          if (value && typeof value === 'object') {
            Object.entries(value).forEach(([keyInObject, valueInObject]) => {
              form.append(`${key}[${keyInObject}]`, valueInObject);
            });
          } else if (value) {
            form.append(key,value);
          }
        }
      }
      form.append('file', this.file);
      this.$store.dispatch('article/createArticle', form)
      .then( () => {
        this.$loadingClose();
        this.$notify('','success', this.$t('messages.success','Success'));

        this.$router.push({name:'Articles'});
      })
      .catch( () => {
        this.$loadingClose();
        this.$notify('','error', this.$t('messages.error','Error'));

      });
    },
    checkCategory(arr) {
      let category = this.categories.find( (c) => c.id === this.article.category_id);
      if (!category) {
        return false;
      }
      return arr.includes(category.tech_name);
    },
    checkCategoryTitleLabelTranslate() {
      let category = this.categories.find( (c) => c.id === this.article.category_id);
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
    },
    changeSearchTags(item) {
      if (item) {
        let tag = this.tags.find((o) => o.name === item);
        if (!tag) {
          let tagById = this.tags.find((i) => i.id === 'new');
          if (tagById) {
            tagById.name = item;
          } else {
            this.tags.push({id:'new',name:item});
          }
        }
      }
    },
    changeTags() {
      let newItem = this.article.tags.findIndex((t) => t.id === 'new');
      if (newItem > -1) this.article.tags[newItem].id = 'new_' + Date.now();
      this.tagSearch = '';
      this.tags = this.tags.filter((t) => t.id !== 'new');
    },
    changeSearchArticles(item) {
      if (item) {
        this.loadingCitation = true
        debounceRequest(()=>{
          this.$store.dispatch('article/searchForSelect', item).then(() => {
            this.loadingCitation = false;
          })
        })
      } else {
        debounceRequest.cancel()
      }
    },
    changeArticles() {
      this.articleSearch = '';
    },
  },
  watch: {
    'article.country_id': {
      handler () {
        this.$store.dispatch('city/downloadCities');
      },
      deep: true,
    },
  },
}
</script>

<style scoped>

</style>
