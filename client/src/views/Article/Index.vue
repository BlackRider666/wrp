<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <v-card-text >
          <v-data-table
              :headers="headers"
              :items="articles"
              :options.sync="options"
              :server-items-length="total"
              :footer-props="{
                  itemsPerPageOptions:[5,10,15,20]
              }"
              class="elevation-1"
          >
            <template v-slot:top>
              <v-toolbar dense flat>
                <span class="text-h5 pl-4">{{$t('articles.index.title','Articles')}}</span>
                <v-spacer></v-spacer>
                <v-btn :to="{name:'Create Article'}" variant="flat" color="primary">{{$t('articles.create.btn.add','Add Article')}}</v-btn>
                <v-btn class="ml-1" @click="getNonApproved" variant="flat" color="primary">{{nonApproved?$t('articles.create.btn.approved','Approved'):$t('articles.create.btn.non-approved','Non Approved')}}</v-btn>
              </v-toolbar>
                <v-dialog v-model="dialogDelete" max-width="500px">
                  <v-card>
                    <v-card-title>{{$t('articles.delete.title','Delete')}}</v-card-title>
                    <v-card-text>{{$t('articles.delete.message','Are you sure you want to delete this item?')}}</v-card-text>
                    <v-card-actions>
                      <v-btn color="darken-1" variant="text" @click="closeDelete">{{$t('btn.cancel','Cancel')}}</v-btn>
                      <v-spacer></v-spacer>
                      <v-btn color="error" variant="text" @click="deleteItemConfirm">{{$t('btn.delete','Delete')}}</v-btn>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
            </template>
            <template v-slot:item.full_title="{ item }">
              {{item.full_title[locale.iso_code]}}
            </template>
            <template v-slot:item.actions="{ item }">
              <template v-if="!nonApproved" >
                <v-btn small icon="mdi-eye" variant="text" :to="{ name: 'Article', params: { article_id: item.id } }"></v-btn>
                <v-btn small icon="mdi-pencil" variant="text" :to="{ name: 'Article Edit', params: { article_id: item.id } }"></v-btn>
                <v-btn small icon="mdi-delete" variant="text" @click="deleteItem(item)"></v-btn>
              </template>
              <template v-else>
                <v-btn small icon="mdi-eye" variant="text" :to="{ name: 'Article', params: { article_id: item.id } }"></v-btn>
                <v-btn small icon="mdi-account-check" variant="text" @click="approveItem(item)"></v-btn>
              </template>
            </template>
          </v-data-table>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import {mapActions, mapState} from "pinia";
import {useArticleStore} from "@/stores/article";
import {useAccountStore} from "@/stores/account";
import {useCountryStore} from "@/stores/country";
import {useCityStore} from "@/stores/city";
import {useUserStore} from "@/stores/user";
import {useLocalesStore} from "@/stores/l10s";

export default {
  name: "Index",
  data() {
    return {
      headers: [
        { title: this.$t('articles.placeholder.title','Title'), value: 'full_title' },
        { title: this.$t('articles.placeholder.category','Category'), value: 'category.title' },
        { title: this.$t('articles.placeholder.year','Year'), value: 'year' },
        { title: this.$t('articles.placeholder.citation','Citation this article'), value: 'citation_this_count' },
        { title: this.$t('articles.placeholder.actions','Actions'), value: 'actions', sortable: false },
      ],
      dialogDelete: false,
      rules: {
        required: value => !!value || 'Required.',
      },
      options: {},
      nonApproved:false,
    };
  },
  computed: {
    ...mapState(useArticleStore,['articles','total','categories']),
    ...mapState(useUserStore,{
      authors:'users',
    }),
    ...mapState(useCountryStore,['countries']),
    ...mapState(useCityStore,['cities']),
    ...mapState(useLocalesStore,['locale']),
    // addArticlesTutor() {
    //   return this.$store.state.tutorial.step === 2 && this.$store.state.tutorial.tutorialCategory === 'article';
    // },
    // nonApprovedTutor() {
    //   return this.$store.state.tutorial.step === 3 && this.$store.state.tutorial.tutorialCategory === 'article';
    // },
    // articlesTableTutor() {
    //   return this.$store.state.tutorial.step === 4 && this.$store.state.tutorial.tutorialCategory === 'article';
    // }
  },
  mounted() {
    this.getData();
    this.downloadCategories();
    this.downloadAuthors();
    this.downloadCountries();
  },
  methods: {
    deleteItem (item) {
      this.selectedItem = item;
      this.dialogDelete = true
    },
    approveItem (item) {
      this.$loading();
      this.approveAuthor(item.id).then(() => {
        this.getData();
      });
    },
    deleteItemConfirm () {
      this.$loading();
      this.deleteArticle(this.selectedItem.id)
          .then( () => {
            this.$loadingClose();
            this.$notify('','success', this.$t('messages.success','Success'));
            this.closeDelete()
          });
    },
    closeDelete () {
      this.dialogDelete = false
    },
    getData() {
      this.$loading()
      this.downloadArticles({
        user_id:useAccountStore().user.id,
        ...this.options,
        nonApproved: this.nonApproved,
      }).then(() => {
        this.$loadingClose();
      }).catch(() => {
        this.$loadingClose();
      });
    },
    getNonApproved() {
      this.nonApproved = !this.nonApproved;
      this.getData();
    },
    ...mapActions(useArticleStore,['downloadArticles','downloadCategories','deleteArticle','approveAuthor']),
    ...mapActions(useCountryStore,['downloadCountries']),
    ...mapActions(useCityStore,['downloadCities']),
    ...mapActions(useUserStore,['downloadAuthors'])
  },
  watch: {
    options: {
      handler () {
        this.getData();
      },
      deep: true,
    },
    'selectedItem.country_id': {
      handler () {
        this.downloadCities();
      },
      deep: true,
    },
  },
}
</script>
