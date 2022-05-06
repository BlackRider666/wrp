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
                <v-text-field
                    v-model="article.title"
                    :label="$t('articles.placeholder.title','Title')"
                    outlined
                    prepend-inner-icon="mdi-card-text-outline"
                    :rules="[rules.required]"
                />
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

export default {
  name: "Create",
  data() {
    return {
      article: {
        title: '',
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
      },
      rules: {
        required: value => !!value || 'Required.',
      },
    };
  },
  computed: {
    ...mapState({
      categories: (state) => state.article.categories,
      authors: (state) => state.user.users,
      countries: (state) => state.country.countries,
      cities: (state) => state.city.cities,
    }),
  },
  mounted() {
    this.$store.dispatch('article/downloadCategories');
    this.$store.dispatch('user/downloadAuthors');
    this.article.authors.push(this.$store.getters['account/getAccount'].id);
    this.$store.dispatch('country/downloadCountries');
  },
  methods: {
    createArticle(e) {
      e.preventDefault();
      e.stopPropagation();
      if (!this.$refs.form.validate()) return;
      this.$loading();
      this.$store.dispatch('article/createArticle', this.article)
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
    }
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
