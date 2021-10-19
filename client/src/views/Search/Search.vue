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
    };
  },
  computed: {
    ...mapState({
      articles: (state) => state.article.articles,
      totalArticles: (state) => state.article.total,
      users: (state) => state.user.users,
      totalUsers: (state) => state.user.total,
    }),
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
    }
  },
  watch: {
    options: {
      handler () {
        this.getData();
      },
      deep: true,
    },
  },
}
</script>

<style scoped>

</style>