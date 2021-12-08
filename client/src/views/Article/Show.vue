<template>
<v-row>
  <v-col cols="12">
    <v-card v-if="article">
      <v-card-title class="pb-0">
        <v-toolbar dense color="primary">
          {{article.category.title}} - {{article.title}}
        </v-toolbar>
      </v-card-title>
      <v-card-text>
        <v-list outlined>
          <div v-if="article.country_id">
            <v-list-item >
              <v-list-item-action>
                <v-icon>mdi-account</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-subtitle>{{$t('articles.placeholder.country', 'Country')}}</v-list-item-subtitle>
                <v-list-item-title>{{article.country_create.name}}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-divider/>
          </div>
          <div v-if="article.city_id">
            <v-list-item >
              <v-list-item-action>
                <v-icon>mdi-account</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-subtitle>{{$t('articles.placeholder.city', 'City')}}</v-list-item-subtitle>
                <v-list-item-title>{{article.city.name}}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-divider/>
          </div>
          <div v-if="article.title">
            <v-list-item >
              <v-list-item-action>
                <v-icon>mdi-account</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-subtitle>{{$t('articles.placeholder.title', 'Title')}}</v-list-item-subtitle>
                <v-list-item-title>{{article.title}}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-divider/>
          </div>
          <div v-if="article.category">
            <v-list-item>
              <v-list-item-action>
                <v-icon>mdi-account</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-subtitle>{{$t('articles.placeholder.category', 'Category')}}</v-list-item-subtitle>
                <v-list-item-title>{{article.category.title}}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-divider/>
          </div>
          <div  v-if="article.year">
            <v-list-item>
              <v-list-item-action>
                <v-icon>mdi-account</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-subtitle>{{$t('articles.placeholder.year', 'Year')}}</v-list-item-subtitle>
                <v-list-item-title>{{article.year}}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-divider/>
          </div>
          <div v-if="article.journal">
            <v-list-item>
              <v-list-item-action>
                <v-icon>mdi-account</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-subtitle>{{$t(checkCategoryTitleLabelTranslate(), 'Journal')}}</v-list-item-subtitle>
                <v-list-item-title>{{article.journal}}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-divider/>
          </div>
          <div v-if="article.part">
            <v-list-item >
              <v-list-item-action>
                <v-icon>mdi-account</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-subtitle>{{$t('articles.placeholder.part', 'Part')}}</v-list-item-subtitle>
                <v-list-item-title>{{article.part}}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-divider/>
          </div>
          <div v-if="article.number">
            <v-list-item>
              <v-list-item-action>
                <v-icon>mdi-account</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-subtitle>{{$t('articles.placeholder.number', 'Number')}}</v-list-item-subtitle>
                <v-list-item-title>{{article.number}}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-divider/>
          </div>
          <div v-if="article.pages">
            <v-list-item>
              <v-list-item-action>
                <v-icon>mdi-account</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-subtitle>{{$t('articles.placeholder.pages', 'Pages')}}</v-list-item-subtitle>
                <v-list-item-title>{{article.pages}}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-divider/>
          </div>
          <div v-if="article.publisher">
            <v-list-item>
              <v-list-item-action>
                <v-icon>mdi-account</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-subtitle>{{$t('articles.placeholder.publisher', 'Publisher')}}</v-list-item-subtitle>
                <v-list-item-title>{{article.publisher}}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-divider/>
          </div>
          <div v-if="article.country">
            <v-list-item>
              <v-list-item-action>
                <v-icon>mdi-account</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-subtitle>{{$t('articles.placeholder.patent_country', 'Patent Country')}}</v-list-item-subtitle>
                <v-list-item-title>{{article.country}}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-divider/>
          </div>
          <div v-if="article.patent_number">
            <v-list-item>
              <v-list-item-action>
                <v-icon>mdi-account</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-subtitle>{{$t('articles.placeholder.patent_number', 'Patent Number')}}</v-list-item-subtitle>
                <v-list-item-title>{{article.patent_number}}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-divider/>
          </div>
          <div v-if="article.app_number">
            <v-list-item>
              <v-list-item-action>
                <v-icon>mdi-account</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-subtitle>{{$t('articles.placeholder.app_number', 'App Number')}}</v-list-item-subtitle>
                <v-list-item-title>{{article.app_number}}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-divider/>
          </div>
        </v-list>
      </v-card-text>
    </v-card>
  </v-col>
</v-row>
</template>
<script>
import {mapState} from "vuex";

export default {
  name: "Show",
  computed: {
    ...mapState({
      article: (state) => state.article.article,
    })
  },
  mounted() {
    this.$store.dispatch('article/getArticle', this.$route.params.article_id);
  },
  methods: {
    checkCategoryTitleLabelTranslate() {
      let category = this.article.category;
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
