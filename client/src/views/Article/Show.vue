<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-card v-if="article" flat>
          <v-card-title>
            <v-row justify="end">
              <v-btn class="font-weight-bold" variant="tonal" tile :to="{ name: 'Article Edit', params: { article_id: article.id } }">Edit article</v-btn>
              <v-btn class="font-weight-bold ml-3" variant="tonal" tile @click="copyLink">Copy link</v-btn>
            </v-row>
          </v-card-title>
          <v-card-text>
            <div class="pb-8">
              <span class="text-subtitle-2 pb-1">{{$t('articles.placeholder.title', 'Title')}}</span>
              <div class="text-h4 font-weight-medium">{{article.title[locale.iso_code] }}</div>
            </div>
            <v-divider/>
            <div class="py-8">
              <p class="text-subtitle-2 mb-1">{{$t('articles.placeholder.authors','Authors')}}</p>
              <div class="d-inline-flex">
                <div class="text-center" v-for="author in article.authors" :key="author.id">
                  <v-avatar class="d-flex my-2 mx-auto" size="70">
                    <v-img :src="author.avatar_url"></v-img>
                  </v-avatar>
                  <span>{{author.full_name}}</span>
                </div>
              </div>
            </div>
            <v-divider/>
            <div class="d-inline-flex py-8">
              <div class="pr-12">
                <div class="text-subtitle-2 pb-2">{{$t('articles.placeholder.city', 'City')}}, {{$t('articles.placeholder.country', 'Country')}}</div>
                <div class="text-body-1">{{article.city.name[locale.iso_code]}}, {{article.country.name[locale.iso_code]}}</div>
              </div>
              <div class="px-12">
                <div class="text-subtitle-2  pb-2">{{$t('articles.placeholder.published_at', 'Published at')}}</div>
                <div class="text-body-1">{{article.year}}</div>
              </div>
              <div class="px-12">
                <div class="text-subtitle-2 pb-2">{{$t('articles.placeholder.category', 'Category')}}</div>
                <div class="text-body-1">{{article.category.title}}</div>
              </div>
            </div>
            <v-divider/>
            <div class="py-8">
              <span class="text-subtitle-2" v-if="article.journal">{{$t(checkCategoryTitleLabelTranslate(), 'Journal')}}</span>
              <p class="text-body-1 mb-4" v-if="article.journal">{{article.journal}}</p>
              <div class="d-inline-flex py-4">
                <div v-if="article.part" class="pr-16">
                  <span class="text-subtitle-2 pb-2">{{$t('articles.placeholder.part', 'Part')}}</span>
                  <div class="text-body-1">{{article.part}}</div>
                </div>
                <div v-if="article.number" class="pr-16">
                  <span class="text-subtitle-2 pb-2">{{$t('articles.placeholder.number', 'Number')}}</span>
                  <div class="text-body-1">{{article.number}}</div>
                </div>
                <div v-if="article.pages" class="pr-16">
                  <span class="text-subtitle-2 pb-2">{{$t('articles.placeholder.pages', 'Pages')}}</span>
                  <div class="text-body-1">{{article.pages}}</div>
                </div>
                <div v-if="article.publisher" class="pr-16">
                  <span class="text-subtitle-2 pb-2">{{$t('articles.placeholder.publisher', 'Publisher')}}</span>
                  <div class="text-body-1">{{article.publisher}}</div>
                </div>
                <div v-if="article.patent_number" class="pr-16">
                  <span class="text-subtitle-2 pb-2">{{$t('articles.placeholder.patent_number', 'Patent Number')}}</span>
                  <div class="text-body-1">{{article.patent_number}}</div>
                </div>
                <div v-if="article.app_number" class="pr-16">
                  <span class="text-subtitle-2 pb-2">{{$t('articles.placeholder.app_number', 'App Number')}}</span>
                  <div class="text-body-1">{{article.app_number}}</div>
                </div>
              </div>
              <div class="py-4">
                <span class="text-subtitle-2 pb-2">{{$t('articles.placeholder.citation_this_count', 'Citations')}}</span>
                <p class="text-body-1 mb-0">{{article.citation_this_count}}</p>
              </div>
              <div class="pt-4">
                <span class="text-subtitle-2 pb-2 d-flex">{{$t('articles.placeholder.file', 'PDF file')}}</span>
                <a :href="article.file_path" :download="article.title[locale.iso_code]" class="align-content-center align-self-center d-flex text-decoration-none">
                  <v-icon color="primary" class="mr-3">mdi-export</v-icon>
                  <span class="text-body-1 text-decoration-underline">{{article.title[locale.iso_code]}}.pdf</span>
                </a>
              </div>
            </div>
            <v-divider/>
            <div class="py-8">
              <span class="text-subtitle-2 pb-2">{{$t('articles.placeholder.desc', 'Description')}}</span>
              <p class="text-body-1 mb-8" v-html="article.desc[locale.iso_code]"></p>
              <span class="text-subtitle-2 pb-2">{{$t('articles.placeholder.full_text', 'Full text')}}</span>
              <p class="text-body-1 mb-0" v-html="article.full_text[locale.iso_code]"></p>
            </div>
            <v-divider></v-divider>
            <div class="py-8">
              <span class="text-subtitle-2 pb-2">{{$t('articles.placeholder.tags', 'Tags')}}</span>
              <p class="text-body-1 mb-0">
                <v-chip v-for="tag in article.tags" :key="tag.id" class="ma-1">{{tag.name}}</v-chip>
              </p>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import {mapActions, mapState} from "pinia";
import {useArticleStore} from "@/stores/article";
import {useLocalesStore} from "@/stores/l10s";

export default {
  name: "Show",
  computed: {
    ...mapState(useArticleStore,['article']),
    ...mapState(useLocalesStore,['locale']),
  },
  mounted() {
    this.getArticle(this.$route.params.article_id);
  },
  methods: {
    checkCategoryTitleLabelTranslate() {
      let category = this.article.category;
      if (!category) return;
      if (category.tech_name === 'article') {
        return 'articles.placeholder.journal';
      }
      if (category.tech_name === 'book') {
        return 'articles.placeholder.book';
      }
      if (category.tech_name === 'conference') {
        return 'articles.placeholder.conference';
      }
    },
    copyLink() {
      console.log('Copy');
    },
    ...mapActions(useArticleStore,['getArticle'])
  },
}
</script>

<style scoped>

</style>
