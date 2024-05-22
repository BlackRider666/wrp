<template>
  <v-form
      ref="form"
      lazy-validation
      align="center"
      @submit.prevent="submitForm"
  ><v-card
      flat
      v-if="article"
  >
    <v-card-text>
      <v-select
          v-model="article.country_id"
          :items="countries"
          :item-title="`name[${locale.iso_code}]`"
          item-value="id"
          :label="$t('article.placeholder.country','Country')"
          prepend-inner-icon="mdi-database-search"
          variant="outlined"
          :disabled="article.category && article.category.tech_name === 'conference'"
      >
      </v-select>
      <v-select
          v-model="article.city_id"
          :items="cities"
          :item-title="`name[${locale.iso_code}]`"
          item-value="id"
          :label="$t('article.placeholder.city','City')"
          prepend-inner-icon="mdi-database-search"
          variant="outlined"
          :disabled="article.category && article.category.tech_name === 'conference'"
      ></v-select>
      <v-tabs v-model="activeTitleTab" align-tabs="end" class="pb-1" selected-class="text-primary" :disabled="article.category && article.category.tech_name === 'conference'">
        <v-tab key="en">English</v-tab>
        <v-tab key="uk">Українська</v-tab>
      </v-tabs>
      <v-window v-model="activeTitleTab" class="pt-2">
        <v-window-item key="en">
          <v-text-field
              v-model="article.title.en"
              :label="$t('articles.placeholder.title','Title')"
              variant="outlined"
              prepend-inner-icon="mdi-card-text-outline"
              :rules="[rules.required]"
              :disabled="article.category && article.category.tech_name === 'conference'"
          />
        </v-window-item>
        <v-window-item key="uk">
          <v-text-field
              v-model="article.title.uk"
              :label="$t('articles.placeholder.title','Title')"
              variant="outlined"
              prepend-inner-icon="mdi-card-text-outline"
              :rules="[rules.required]"
              :disabled="article.category && article.category.tech_name === 'conference'"
          />
        </v-window-item>
      </v-window>
      <v-select
          v-model="article.category_id"
          :label="$t('articles.placeholder.category','Category')"
          variant="outlined"
          prepend-inner-icon="mdi-shape-outline"
          :rules="[rules.required]"
          :items="mappedCategory"
          item-title="title"
          item-value="id"
          :item-props="disabledCategory"
          :disabled="article.category && article.category.tech_name === 'conference'"

      ></v-select>
      <v-text-field
          v-model="article.year"
          :label="$t('articles.placeholder.year', 'Year')"
          variant="outlined"
          prepend-inner-icon="mdi-calendar-range"
          :rules="[rules.required]"
          :disabled="article.category && article.category.tech_name === 'conference'"
      ></v-text-field>
      <v-select
          v-model="article.authors"
          :label="$t('articles.placeholder.authors','Authors')"
          variant="outlined"
          prepend-inner-icon="mdi-shape-outline"
          :rules="[rules.required]"
          :items="authors"
          item-title="full_name"
          item-value="id"
          multiple
          :disabled="article.category && article.category.tech_name === 'conference'"
      ></v-select>
      <v-text-field
          v-if="checkCategory(['article','conference','section'])"
          v-model="article.journal"
          :label="$t(checkCategoryTitleLabelTranslate(), 'Journal')"
          variant="outlined"
          prepend-inner-icon="mdi-card-text-outline"
          :rules="[rules.required]"
      />
      <v-text-field
          v-if="checkCategory(['article','conference','section', 'book','conference'])"
          v-model="article.part"
          :label="$t('articles.placeholder.part', 'Part')"
          variant="outlined"
          prepend-inner-icon="mdi-card-text-outline"
          :rules="[rules.required]"
      />
      <v-text-field
          v-if="checkCategory(['article','conference'])"
          v-model="article.number"
          :label="$t('articles.placeholder.number', 'Number')"
          variant="outlined"
          prepend-inner-icon="mdi-card-text-outline"
          :rules="[rules.required]"
      />
      <v-text-field
          v-if="checkCategory(['article','conference','section', 'book','conference','guidelines'])"
          v-model="article.pages"
          :label="$t('articles.placeholder.pages', 'Pages')"
          variant="outlined"
          prepend-inner-icon="mdi-card-text-outline"
          :rules="[rules.required]"
      />
      <v-text-field
          v-if="checkCategory(['article','section','guidelines'])"
          v-model="article.publisher"
          :label="$t('articles.placeholder.publisher', 'Publisher')"
          variant="outlined"
          prepend-inner-icon="mdi-card-text-outline"
          :rules="[rules.required]"
      />
      <v-text-field
          v-if="checkCategory(['patent'])"
          v-model="article.patent_number"
          :label="$t('articles.placeholder.patent_number', 'Patent Number')"
          variant="outlined"
          prepend-inner-icon="mdi-card-text-outline"
          :rules="[rules.required]"
      />
      <v-text-field
          v-if="checkCategory(['patent'])"
          v-model="article.app_number"
          :label="$t('articles.placeholder.app_number','App Number')"
          variant="outlined"
          prepend-inner-icon="mdi-card-text-outline"
          :rules="[rules.required]"
      />
      <v-tabs v-model="activeDescTab" align-tabs="end" class="pb-1" selected-class="text-primary">
        <v-tab key="en">English</v-tab>
        <v-tab key="uk">Українська</v-tab>
      </v-tabs>
      <v-window v-model="activeDescTab">
        <v-window-item key="en">
          <SimpleEditor
              v-model="article.desc.en"
              :placeholder="$t('articles.placeholder.desc', 'Desc')"
          ></SimpleEditor>
        </v-window-item>
        <v-window-item key="uk">
          <SimpleEditor
              v-model="article.desc.uk"
              :placeholder="$t('articles.placeholder.desc', 'Desc')"
          ></SimpleEditor>
        </v-window-item>
      </v-window>
      <v-tabs v-model="activeFullTextTab" align-tabs="end" class="pb-1" selected-class="text-primary">
        <v-tab key="en">English</v-tab>
        <v-tab key="uk">Українська</v-tab>
      </v-tabs>
      <v-window v-model="activeFullTextTab">
        <v-window-item key="en">
          <FullEditor v-model="article.full_text.en" :placeholder="$t('articles.placeholder.full_text', 'Full text')"/>
        </v-window-item>
        <v-window-item key="uk">
          <FullEditor v-model="article.full_text.uk" :placeholder="$t('articles.placeholder.full_text', 'Full text')"/>
        </v-window-item>
      </v-window>
      <v-autocomplete
          v-model="article.tags"
          :items="tags"
          hide-no-data
          multiple
          item-title="name"
          item-value="id"
          :label="$t('tags.placeholder.select','Tags')"
          :placeholder="$t('tags.placeholder.select','Tags')"
          prepend-inner-icon="mdi-database-search"
          :search-input.sync="tagSearch"
          @update:search-input="(value) => changeSearchTags(value)"
          @change="changeTags"
          return-object
          variant="outlined"
          chips
          deletable-chips
      >
      </v-autocomplete>
      <v-autocomplete
          v-model="article.citations"
          :items="articles"
          hide-no-data
          multiple
          item-title="full_title"
          item-value="id"
          :label="$t('articles.placeholder.citation','Citation')"
          :placeholder="$t('articles.placeholder.citation','Citation')"
          prepend-inner-icon="mdi-database-search"
          :search-input.sync="articleSearch"
          @update:search-input="(value) => changeSearchArticles(value)"
          @change="changeArticles"
          variant="outlined"
          chips
          deletable-chips
          :loading="loadingCitation"
      >
      </v-autocomplete>
      <template v-if="article.file_path">
        <div class="py-2">
          <a :href="article.file_path" :download="article.title[locale.iso_code]" class="align-content-center align-self-center d-flex text-decoration-none">
            <v-icon color="primary" class="mr-3">mdi-export</v-icon>
            <span class="text-body-1 text-decoration-underline">{{article.title[locale.iso_code]}}.pdf</span>
          </a>
        </div>
      </template>
      <v-file-input
          :rules="[rules.required]"
          accept="file/pdf"
          prepend-inner-icon="mdi-file"
          prepend-icon=""
          :label="$t('placeholder.file','File')"
          variant="outlined"
          v-model="file"
          :disabled="article.category && article.category.tech_name === 'conference'"
      ></v-file-input>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="primary" type="submit">{{articleValues?$t('btn.update','Update'):$t('btn.create','Create')}}</v-btn>
    </v-card-actions>
  </v-card>
  </v-form>
</template>
<script>
import SimpleEditor from "@/components/editor/SimpleEditor.vue";
import FullEditor from "@/components/editor/FullEditor.vue";
import {debouncer} from "@/plugins/l10s";
import {useArticleStore} from "@/stores/article";
import {mapActions, mapState} from "pinia";
import {useUserStore} from "@/stores/user";
import {useCountryStore} from "@/stores/country";
import {useCityStore} from "@/stores/city";
import {useTagStore} from "@/stores/tags";
import {useAccountStore} from "@/stores/account";
import {useLocalesStore} from "@/stores/l10s";
const debounceRequest = debouncer(1500)
export default {
  name: "ArticleForm",
  components: {FullEditor, SimpleEditor},
  props: ['articleValues'],
  emits: ['actionForm'],
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
      tags:[],
      file: null,
      rules: {
        required: value => !!value || 'Required.',
      },
      tagSearch: null,
      articleSearch: null,
      loadingCitation: false,
      activeTitleTab: 'en',
      activeDescTab: 'en',
      activeFullTextTab: 'en',
    };
  },
  computed: {
    ...mapState(useArticleStore,['categories','articles']),
    ...mapState(useUserStore,{
      authors:'users',
    }),
    ...mapState(useCountryStore,['countries']),
    ...mapState(useCityStore,['cities']),
    ...mapState(useLocalesStore,['locale']),
    mappedCategory() {
      return this.categories.map(item => ({
        ...item,
        disabled: item.tech_name === 'conference'
      }));
    }
  },
  mounted() {
    if (this.articleValues) {
      this.article = this.articleValues;
      this.article.country_id = this.articleValues.country.id;
      this.article.authors = this.articleValues.authors.map((item) => item.id);
    }
    let user_id = useAccountStore().user.id;
    if (!this.article.authors.find((item) => item === user_id)) {
      this.article.authors.push(user_id);
    }
    this.downloadCategories();
    this.downloadAuthors();
    this.downloadCountries();
    this.downloadTags().then( (tags) => {
      this.tags = tags;
    })
  },
  methods: {
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
          this.searchForSelect(item).then(() => {
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
    ...mapActions(useArticleStore,['downloadCategories','searchForSelect']),
    ...mapActions(useUserStore,['downloadAuthors']),
    ...mapActions(useCountryStore,['downloadCountries']),
    ...mapActions(useCityStore,['downloadCities']),
    ...mapActions(useTagStore,['downloadTags']),
    submitForm(e) {
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
      if (this.file) {
        form.append('file', this.file);
      }
      this.$emit('actionForm',form)
    },
    disabledCategory(item) {
      return {
        disabled:item.disabled,
      }
    }
  },
  watch: {
    'article.country_id': {
      handler () {
        this.downloadCities();
      },
      deep: true,
    },
  },
}
</script>
<style scoped>

</style>
