<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <v-card-title>
          <v-toolbar dense>
            Articles
            <v-spacer></v-spacer>
            <v-btn :to="{name:'Create Article'}" color="primary">Add Article</v-btn>
          </v-toolbar>
        </v-card-title>
        <v-card-text>
          <v-data-table
              :headers="headers"
              :items="articles"
              class="elevation-1"
          >
            <template v-slot:top>
              <v-toolbar
                  flat
              >
                <v-dialog v-model="dialogDelete" max-width="500px">
                  <v-card>
                    <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                      <v-btn color="blue darken-1" text @click="deleteItemConfirm()">OK</v-btn>
                      <v-spacer></v-spacer>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
              </v-toolbar>
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
                  @click="deleteItem()"
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
      toDelete: null,
    };
  },
  computed: {
    ...mapState({
      articles: (state) => state.article.articles,
    }),
  },
  mounted() {
    this.$store.dispatch('article/downloadArticles')
  },
  methods: {
    editItem (item) {
      this.dialogEdit = true
      console.log(item);
    },

    deleteItem () {
      this.dialogDelete = true
    },

    deleteItemConfirm (item) {
      console.log(item)
      this.closeDelete()
    },

    closeEdit () {
      this.dialogEdit = false
    },

    closeDelete () {
      this.dialogDelete = false
    },
  },
}
</script>

<style scoped>

</style>