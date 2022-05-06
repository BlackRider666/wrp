<template>
  <v-row>
    <v-col cols="12">
      <v-card v-if="user">
        <v-card-title class="pb-0">
          <v-toolbar dense color="primary">
            User
          </v-toolbar>
        </v-card-title>
        <v-card-text>
          <v-list outlined>
            <div v-if="user.first_name">
              <v-list-item >
                <v-list-item-content>
                  <v-list-item-subtitle>{{$t('placeholder.first_name', 'First Name')}}</v-list-item-subtitle>
                  <v-list-item-title>{{user.first_name}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-divider/>
            </div>
            <div v-if="user.second_name">
              <v-list-item >
                <v-list-item-content>
                  <v-list-item-subtitle>{{$t('placeholder.second_name', 'Second Name')}}</v-list-item-subtitle>
                  <v-list-item-title>{{user.second_name}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-divider/>
            </div>
            <div v-if="user.surname">
              <v-list-item >
                <v-list-item-content>
                  <v-list-item-subtitle>{{$t('placeholder.surname', 'Surname')}}</v-list-item-subtitle>
                  <v-list-item-title>{{user.surname}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-divider/>
            </div>
            <div v-if="user.email">
              <v-list-item >
                <v-list-item-content>
                  <v-list-item-subtitle>{{$t('placeholder.email', 'Email')}}</v-list-item-subtitle>
                  <v-list-item-title>{{user.email}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-divider/>
            </div>
            <div v-if="user.phone">
              <v-list-item >
                <v-list-item-content>
                  <v-list-item-subtitle>{{$t('placeholder.phone', 'Phone')}}</v-list-item-subtitle>
                  <v-list-item-title>{{user.phone}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-divider/>
            </div>
            <div v-if="user.desc">
              <v-list-item >
                <v-list-item-content>
                  <v-list-item-subtitle>{{$t('placeholder.desc', 'Desc')}}</v-list-item-subtitle>
                  <v-list-item-title>{{user.desc}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </div>
          </v-list>
          <div v-if="user.works" class="py-1">
            <v-toolbar dense color="primary">
              {{$t('works.title','Works')}}
            </v-toolbar>
            <v-data-table
                :headers="headersWorks"
                :items="user.works"
                :items-per-page="5"
                class="elevation-1"
                hide-default-footer
            >
              <template v-slot:item.finish="{ item }">
                {{item.finish?item.finish: $t('works.now','Now')}}
              </template>
            </v-data-table>
          </div>
          <div v-if="user.projects" class="py-1">
            <v-toolbar dense color="primary">
              {{$t('projects.title','Projects')}}
            </v-toolbar>
            <v-data-table
                :headers="headersProjects"
                :items="user.projects"
                :items-per-page="5"
                class="elevation-1"
                hide-default-footer
            ></v-data-table>
          </div>
          <div v-if="user.grants" class="py-1">
            <v-toolbar dense color="primary">
              {{$t('grants.title','Grants')}}
            </v-toolbar>
            <v-data-table
                :headers="headersGrants"
                :items="user.grants"
                :items-per-page="5"
                class="elevation-1"
                hide-default-footer
            ></v-data-table>
          </div>
          <div v-if="user.articles" class="py-1">
            <v-toolbar dense color="primary">
              {{$t('articles.index.title','Articles')}}
            </v-toolbar>
            <v-data-table
                :headers="headersArticles"
                :items="user.articles"
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
      headersWorks: [
        { text: this.$t('works.placeholder.title', 'Title'), value: 'title' },
        { text: this.$t('works.placeholder.start', 'Worked from'), value: 'start' },
        { text: this.$t('works.placeholder.finish','Worked Until'), value: 'finish' },
      ],
      headersProjects: [
        { text: this.$t('projects.placeholder.name', 'Name'), value: 'name' },
      ],
      headersGrants: [
        { text: this.$t('grants.placeholder.name', 'Name'), value: 'name' },
      ],
      headersArticles: [
        { text: this.$t('articles.placeholder.title','Title'), value: 'title' },
        { text: this.$t('articles.placeholder.category','Category'), value: 'category.title' },
        { text: this.$t('articles.placeholder.year','Year'), value: 'year' },
        { text: this.$t('articles.placeholder.actions','Actions'), value: 'actions', sortable: false },
      ]
    };
  },
  computed: {
    ...mapState({
      user: (state) => state.user.user,
    })
  },
  mounted() {
    this.$store.dispatch('user/downloadUser', this.$route.params.user_id);
  },
  methods: {
    showArticle(item) {
      this.$router.push( { name: 'Article', params: { article_id: item.id } });
    },
  },
}
</script>

<style scoped>

</style>