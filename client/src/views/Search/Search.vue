<template>
  <v-row>
    <v-col cols="12">
      <v-card
          flat
      >
        <v-card-title class="heading font-weight-medium">
          {{$t('search.title','Search')}}
        </v-card-title>
        <v-card-text>
            <v-toolbar
                dense
                color="primary"
                v-if="$route.params.type === 'articles'"
            >
              {{$t('search.articles.filters','Filters')}}
              <v-spacer/>
              <v-btn icon @click="showArticleFiltersSheet">
                <v-icon v-if="articleFiltersSheet">mdi-chevron-up</v-icon>
                <v-icon v-else>mdi-chevron-down</v-icon>
              </v-btn>
            </v-toolbar>
            <v-sheet
                v-if="articleFiltersSheet && $route.params.type === 'articles'"
                outlined
            >
              <v-container>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                        v-model="articleFilters.title"
                        :label="$t('articles.placeholder.title','Title')"
                        outlined
                        prepend-inner-icon="mdi-card-text-outline"
                    />
                  </v-col>
                  <v-col cols="12">
                    <v-select
                        v-model="articleFilters.country_id"
                        :items="countries"
                        item-text="name"
                        item-value="id"
                        :label="$t('search.placeholder.country','Country')"
                        :placeholder="$t('search.placeholder.country','Country')"
                        prepend-inner-icon="mdi-database-search"
                        outlined
                    ></v-select>
                  </v-col>
                  <v-col cols="12">
                    <v-select
                        v-model="articleFilters.city_id"
                        :items="cities"
                        item-text="name"
                        item-value="id"
                        :label="$t('search.placeholder.city','City')"
                        :placeholder="$t('search.placeholder.city','City')"
                        prepend-inner-icon="mdi-database-search"
                        outlined
                    ></v-select>
                  </v-col>
                  <v-col cols="12">
                    <v-btn color="primary" block @click="getData">{{$t('search.title','Search')}}</v-btn>
                  </v-col>
                </v-row>
              </v-container>
            </v-sheet>
          <v-data-table
              v-if="$route.params.type === 'articles'"
              :headers="articleHeaders"
              :items="articles"
              :options.sync="options"
              :server-items-length="totalArticles"
              :footer-props="{
                  itemsPerPageOptions:[5,10,15,20]
              }"
              class="elevation-1"
          >
            <template v-slot:item.actions="{ item }">
              <v-icon
                  small
                  class="mr-2"
                  @click="showArticle(item)"
              >
                mdi-eye
              </v-icon>
            </template>
          </v-data-table>
          <v-data-table
              v-if="$route.params.type === 'users'"
              :headers="userHeaders"
              :items="users"
              :options.sync="options"
              :server-items-length="totalUsers"
              :footer-props="{
                  itemsPerPageOptions:[5,10,15,20]
              }"
              class="elevation-1"
          >
            <template v-slot:item.actions="{ item }">
              <v-icon
                  small
                  class="mr-2"
                  @click="showUser(item)"
              >
                mdi-eye
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
  name: "Search",
  data() {
    return {
      articleHeaders: [
        { text: this.$t('articles.placeholder.title','Title'), value: 'title' },
        { text: this.$t('articles.placeholder.category','Category'), value: 'category.title' },
        { text: this.$t('articles.placeholder.year','Year'), value: 'year' },
        { text: this.$t('articles.placeholder.actions','Actions'), value: 'actions', sortable: false },
      ],
      userHeaders: [
        { text: this.$t('placeholder.name','Name'), value: 'full_name' },
        { text: this.$t('placeholder.actions','Actions'), value: 'actions', sortable: false },
      ],
      options: {},
      articleFiltersSheet: true,
      articleFilters: {
        country_id:null,
        city_id: null,
        title: null,
      },
    };
  },
  computed: {
    ...mapState({
      articles: (state) => state.article.articles,
      totalArticles: (state) => state.article.total,
      users: (state) => state.user.users,
      totalUsers: (state) => state.user.total,
      countries: (state) => state.country.countries,
      cities: (state) => state.city.cities,
    }),
  },
  mounted() {
    this.$store.dispatch('country/downloadCountries');
    this.articleFilters.title = this.$route.query.title;
  },
  methods: {
    showArticle (item) {
      this.$router.push( { name: 'Article', params: { article_id: item.id } });
    },
    showUser (item) {
      this.$router.push( { name: 'User', params: { user_id: item.id } });
    },
    getData() {
      this.$loading()
      if (this.$route.params.type === 'articles') {
        this.$store.dispatch('article/downloadArticles', {
          user_id:null,
          title: this.$route.query.title,
          ...this.options,
          ...this.articleFilters,
        }).then(() => {
          this.$loadingClose();
        });
      }
      if (this.$route.params.type === 'users') {
        this.$store.dispatch('user/downloadUsers', {
          title: this.$route.query.title,
          ...this.options,
        }).then( () => {
          this.$loadingClose();
        });
      }
    },
    showArticleFiltersSheet() {
      this.articleFiltersSheet = !this.articleFiltersSheet;
    },
  },
  watch: {
    options: {
      handler () {
        this.getData();
      },
      deep: true,
    },
    'articleFilters.country_id': {
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
