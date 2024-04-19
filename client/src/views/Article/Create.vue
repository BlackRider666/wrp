<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <v-card-title>
          <v-toolbar dense color="primary" class="pl-4">
            {{$t('articles.create.title','Create Article')}}
          </v-toolbar>
        </v-card-title>
        <v-card-text>
          <v-sheet outlined>
            <ArticleForm @action-form="createArticle"/>
          </v-sheet>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import ArticleForm from "@/components/article/ArticleForm.vue";
import {mapActions} from "pinia";
import {useArticleStore} from "@/stores/article";
export default {
  name: "Create",
  components: {
    ArticleForm,
  },
  methods: {
    createArticle(form) {
      this.storeArticle(form)
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
    ...mapActions(useArticleStore,{
      storeArticle:'createArticle',
    })
  },
}
</script>

<style scoped>

</style>
