<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <v-card-title>
          <v-toolbar dense color="primary">
            Create Article
          </v-toolbar>
        </v-card-title>
        <v-card-text>
          <v-sheet outlined>
            <v-form
                lazy-validation
                align="center"
                @submit.prevent="createArticle"
            ><v-card
                flat
            >
              <v-card-text>
                <v-text-field
                    v-model="article.title"
                    :label="$t('placeholder.title')"
                    outlined
                    prepend-inner-icon="mdi-card-text-outline"
                    :rules="[rules.required]"
                />
                <v-select
                  v-model="article.category_id"
                  :label="$t('placeholder.category')"
                  outlined
                  prepend-inner-icon="mdi-shape-outline"
                  :rules="[rules.required]"
                  :items="categories"
                  item-text="title"
                  item-value="id"
                ></v-select>
                <v-text-field
                  v-model="article.year"
                  :label="$t('placeholder.year')"
                  outlined
                  prepend-inner-icon="mdi-calendar-range"
                  :rules="[rules.required]"
                ></v-text-field>
                <v-select
                    v-model="article.authors"
                    :label="$t('placeholder.category')"
                    outlined
                    prepend-inner-icon="mdi-shape-outline"
                    :rules="[rules.required]"
                    :items="authors"
                    item-text="full_name"
                    item-value="id"
                    multiple
                ></v-select>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" type="submit">Create</v-btn>
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
    }),
  },
  mounted() {
    this.$store.dispatch('article/downloadCategories');
    this.$store.dispatch('user/downloadAuthors');
    this.article.authors.push(this.$store.getters['account/getAccount'].id);
  },
  methods: {
    createArticle() {
      this.$loading();
      this.$store.dispatch('article/createArticle', this.article)
          .then( () => {
            this.$loadingClose();
            this.$notify('','success', 'Success');

            this.$router.push({name:'Articles'});
          });
    },
  },
}
</script>

<style scoped>

</style>