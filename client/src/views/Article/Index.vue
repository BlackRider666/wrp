<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <v-card-text>
          <v-data-table
              :headers="headers"
              :items="articles"
              class="elevation-1"
          >
            <template v-slot:top>
              <v-toolbar dense flat>
                <span class="text-h5">Articles</span>
                <v-spacer></v-spacer>
                <v-btn :to="{name:'Create Article'}" color="primary">Add Article</v-btn>
              </v-toolbar>
                <v-dialog v-model="dialogDelete" max-width="500px">
                  <v-card>
                    <v-card-title>Delete</v-card-title>
                    <v-card-text>Are you sure you want to delete this item?</v-card-text>
                    <v-card-actions>
                      <v-btn color="darken-1" text @click="closeDelete">Cancel</v-btn>
                      <v-spacer></v-spacer>
                      <v-btn color="error" text @click="deleteItemConfirm">Delete</v-btn>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
                <v-dialog v-model="dialogEdit" max-width="500px">
                  <v-card>
                    <v-card-title>Edit</v-card-title>
                    <v-card-text v-if="selectedItem">
                      <v-text-field
                          v-model="selectedItem.title"
                          :label="$t('placeholder.title')"
                          outlined
                          prepend-inner-icon="mdi-card-text-outline"
                      />
                      <v-select
                          v-model="selectedItem.category_id"
                          :label="$t('placeholder.category')"
                          outlined
                          prepend-inner-icon="mdi-shape-outline"
                          :items="categories"
                          item-text="title"
                          item-value="id"
                      ></v-select>
                      <v-text-field
                          v-model="selectedItem.year"
                          :label="$t('placeholder.year')"
                          outlined
                          prepend-inner-icon="mdi-calendar-range"
                      ></v-text-field>
                      <v-select
                          v-model="selectedItem.authors"
                          :label="$t('placeholder.category')"
                          outlined
                          prepend-inner-icon="mdi-shape-outline"
                          :items="authors"
                          item-text="full_name"
                          item-value="id"
                          multiple
                      ></v-select>
                    </v-card-text>
                    <v-card-actions>
                      <v-btn color="darken-1" text @click="closeEdit">Cancel</v-btn>
                      <v-spacer></v-spacer>
                      <v-btn color="darken-1" text @click="editItemConfirm">Update</v-btn>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
            </template>
            <template v-slot:item.actions="{ item }">
              <v-icon
                  small
                  class="mr-2"
                  @click="editItem(item)"
              >
                mdi-pencil
              </v-icon>
              <v-icon
                  small
                  @click="deleteItem(item)"
              >
                mdi-delete
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
  name: "Index",
  data() {
    return {
      headers: [
        { text: 'Title', value: 'title' },
        { text: 'Category', value: 'category.title' },
        { text: 'Year', value: 'year' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      dialogEdit: false,
      dialogDelete: false,
      selectedItem: null,
    };
  },
  computed: {
    ...mapState({
      articles: (state) => state.article.articles,
      categories: (state) => state.article.categories,
      authors: (state) => state.user.users,
    }),
  },
  mounted() {
    this.$store.dispatch('article/downloadArticles');
    this.$store.dispatch('article/downloadCategories');
    this.$store.dispatch('user/downloadAuthors');
  },
  methods: {
    editItem (item) {
      this.selectedItem = item;
      this.dialogEdit = true
    },

    deleteItem (item) {
      this.selectedItem = item;
      this.dialogDelete = true
    },

    deleteItemConfirm () {
      this.$loading();
      this.$store.dispatch('article/deleteArticle', this.selectedItem.id)
          .then( () => {
            this.$loadingClose();
            this.$notify('','success', 'Success');
            this.closeDelete()
          });
    },
    editItemConfirm () {
      this.$loading();
      this.selectedItem.authors = this.selectedItem.authors.map( (a) => a.id);
      this.$store.dispatch('article/updateArticle', this.selectedItem)
          .then( () => {
            this.$loadingClose();
            this.$notify('','success', 'Success');
            this.closeEdit()
          });
    },

    closeEdit () {
      this.dialogEdit = false;
      this.selectedItem = null;
    },

    closeDelete () {
      this.dialogDelete = false
    },
  },
}
</script>

<style scoped>

</style>