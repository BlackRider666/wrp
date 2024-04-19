<template>
  <v-row>
    <v-col cols="12">
      <v-card v-if="article">
        <v-card-title>
          <v-toolbar dense color="primary" class="pl-4">
            {{$t('articles.edit.title','Edit Article')}}
          </v-toolbar>
        </v-card-title>
        <v-card-text>
          <v-sheet outlined>
            <ArticleForm @action-form="editArticle" :article-values="article"/>
          </v-sheet>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import ArticleForm from "@/components/article/ArticleForm.vue";
import {mapActions, mapState} from "pinia";
import {useArticleStore} from "@/stores/article";
export default {
  name: "Edit",
  components: {ArticleForm},
  computed: {
    ...mapState(useArticleStore,['article'])
  },
  mounted() {
    this.getArticle(this.$route.params.article_id);
  },
  methods: {
    async editArticle(form) {
      await this.updateArticle(this.$route.params.article_id,form)
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
    ...mapActions(useArticleStore,['updateArticle','getArticle'])
  },
}
</script>

<style scoped>

</style>
