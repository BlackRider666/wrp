<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-card
            flat
        >
          <v-card-title class="heading font-weight-medium">
            {{$t('search.title','Search')}}
            <v-spacer></v-spacer>
<!--            <template v-if="isPremium">-->
<!--              <v-btn :to="{name:'Create Article'}" color="primary" icon><v-icon>mdi-plus</v-icon></v-btn>-->
<!--            </template>-->
          </v-card-title>
          <v-card-text>
              <v-toolbar
                  dense
                  color="primary"
                  v-if="articleFiltersSheet && $route.params.type === 'articles'"
              >
                <span class="pl-1">{{$t('search.articles.filters','Filters')}}</span>
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
                          variant="outlined"
                          prepend-inner-icon="mdi-card-text-outline"
                      />
                    </v-col>
                    <v-col cols="12">
                      <v-select
                          v-model="articleFilters.direction_id"
                          :items="sortedDirections"
                          :item-title="`name[${locale.iso_code}]`"
                          item-value="id"
                          :label="$t('search.placeholder.direction','Direction')"
                          :placeholder="$t('search.placeholder.direction','Direction')"
                          prepend-inner-icon="mdi-database-search"
                          variant="outlined"
                      ></v-select>
                    </v-col>
                    <v-col cols="12">
                      <v-select
                          v-model="articleFilters.country_id"
                          :items="countries"
                          item-title="name"
                          item-value="id"
                          :label="$t('search.placeholder.country','Country')"
                          :placeholder="$t('search.placeholder.country','Country')"
                          prepend-inner-icon="mdi-database-search"
                          variant="outlined"
                      ></v-select>
                    </v-col>
                    <v-col cols="12">
                      <v-select
                          v-model="articleFilters.city_id"
                          :items="cities"
                          item-title="name"
                          item-value="id"
                          :label="$t('search.placeholder.city','City')"
                          :placeholder="$t('search.placeholder.city','City')"
                          prepend-inner-icon="mdi-database-search"
                          variant="outlined"
                      ></v-select>
                    </v-col>
                    <v-col cols="12">
                      <v-btn color="primary" block @click="getData">{{$t('search.title','Search')}}</v-btn>
                    </v-col>
                  </v-row>
                </v-container>
              </v-sheet>
            <template v-if="searchType[type].showArticlesTable">
              <div class="text-h5 font-weight-medium mb-4">Articles</div>
              <v-data-table-server
                  :headers="articleHeaders"
                  :items="articles"
                  :items-length="totalArticles"
                  v-model:items-per-page="options.perPage"
                  v-model:page="options.page"
                  :items-per-page-options="[
                      {value:5,title:'5'},
                      {value:10,title:'10'},
                      {value:15,title:'15'},
                      {value:20,title:'20'}
                      ]"
                  class="elevation-1 mb-5"
                  @update:options="getData"
              >
                <template v-slot:item.full_title="{ item }">
                  {{item.full_title[locale.iso_code]}}
                </template>
                <template v-slot:item.actions="{ item }">
                  <v-icon
                      small
                      class="mr-2"
                      @click="showArticle(item)"
                  >
                    mdi-eye
                  </v-icon>
                </template>
              </v-data-table-server>
            </template>
            <template v-if="searchType[type].showUsersTable">
              <div class="text-h5 font-weight-medium mb-4">Authors</div>
              <v-data-table-server
                  :headers="userHeaders"
                  :items="users"
                  :items-length="totalUsers"
                  v-model:items-per-page="options.perPage"
                  v-model:page="options.page"
                  :items-per-page-options="[
                      {value:5,title:'5'},
                      {value:10,title:'10'},
                      {value:15,title:'15'},
                      {value:20,title:'20'}
                      ]"
                  class="elevation-1"
                  @update:options="getData"
              >
                <template v-slot:item.full_name="{ item }">
                  {{item.full_name[locale.iso_code]}}
                </template>
                <template v-slot:item.actions="{ item }">
                  <v-icon
                      small
                      class="mr-2"
                      @click="showUser(item)"
                  >
                    mdi-eye
                  </v-icon>
                </template>
              </v-data-table-server>
            </template>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import {mapActions, mapState} from "pinia";
import {useArticleStore} from "@/stores/article";
import {useUserStore} from "@/stores/user";
import {useCountryStore} from "@/stores/country";
import {useCityStore} from "@/stores/city";
import {useLocalesStore} from "@/stores/l10s";

export default {
  name: "Search",
  data() {
    return {
      articleHeaders: [
        { title: this.$t('articles.placeholder.title','Title'), value: 'full_title' },
        { title: this.$t('articles.placeholder.category','Category'), value: 'category.title' },
        { title: this.$t('articles.placeholder.direction','Direction'), value: 'direction' },
        { title: this.$t('articles.placeholder.year','Year'), value: 'year' },
        { title: this.$t('articles.placeholder.actions','Actions'), value: 'actions', sortable: false },
      ],
      userHeaders: [
        { title: this.$t('placeholder.name','Name'), value: 'full_name' },
        { title: this.$t('placeholder.actions','Actions'), value: 'actions', sortable: false },
      ],
      options: {
        page:1,
        perPage:10,
      },
      articleFiltersSheet: true,
      articleFilters: {
        country_id:null,
        city_id: null,
        title: null,
        direction_id: null,
      },
      searchType: {
        all: {
          showArticlesTable:true,
          showUsersTable:true,
        },
        articles: {
          showArticlesTable: true,
          showUsersTable:false,
        },
        authors: {
          showArticlesTable: false,
          showUsersTable: true,
        },
      },
    };
  },
  computed: {
    ...mapState(useArticleStore,{
      articles:'articles',
      directions: 'directions',
      totalArticles: 'total',
    }),
    ...mapState(useUserStore,{
      users:'users',
      totalUsers:'total',
    }),
    ...mapState(useCountryStore,['countries']),
    ...mapState(useCityStore,['cities']),
    ...mapState(useLocalesStore,['locale']),
    // isPremium() {
    //   if (this.$store.getters['auth/getAuthToken'].length > 0) {
    //     return this.$store.getters['account/getAccount'].is_premium;
    //   }
    //   return false;
    // },
    type() {
      if (this.$route.params.type) {
        if (this.searchType[this.$route.params.type]) {
          return this.$route.params.type;
        }
      }
      return 'all';
    },
    sortedDirections() {
      return this.directions.sort((a,b) => {
        return a.name[this.locale.iso_code].localeCompare(b.name[this.locale.iso_code],this.locale.iso_code);
      });
    }
  },
  mounted() {
    this.downloadCountries();
    this.downloadDirections();
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
      if (this.searchType[this.$route.params.type].showArticlesTable) {
        this.downloadArticles({
          user_id:null,
          title: this.$route.query.title,
          ...this.options,
          ...this.articleFilters,
        }).then(() => {
          this.$loadingClose();
        });
      }
      if (this.searchType[this.$route.params.type].showUsersTable) {
        this.downloadUsers({
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
    ...mapActions(useArticleStore,['downloadArticles', 'downloadDirections']),
    ...mapActions(useUserStore,['downloadUsers']),
    ...mapActions(useCountryStore,['downloadCountries']),
    ...mapActions(useCityStore,['downloadCities'])
  },
  watch: {
    'articleFilters.country_id': {
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
