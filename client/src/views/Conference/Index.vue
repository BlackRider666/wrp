<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <v-card-text>
          <v-data-table
              :headers="headers"
              :items="conferences"
              :options.sync="options"
              :server-items-length="total"
              :footer-props="{
                  itemsPerPageOptions:[5,10,15,20]
              }"
              class="elevation-1"
          >
            <template v-slot:top>
              <v-toolbar dense flat>
                <span class="text-h5">{{$t('conference.index.title','Conference')}}</span>
                <v-spacer></v-spacer>
                <v-btn @click="createItem" color="primary">{{$t('conference.btn.add','Add Conference')}}</v-btn>
              </v-toolbar>
              <v-dialog v-model="dialogDelete" max-width="500px">
                <v-card>
                  <v-card-title>{{$t('conference.delete.title','Delete')}}</v-card-title>
                  <v-card-text>{{$t('conference.delete.message','Are you sure you want to delete this item?')}}</v-card-text>
                  <v-card-actions>
                    <v-btn color="darken-1" text @click="closeDelete">{{$t('btn.cancel','Cancel')}}</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="error" text @click="deleteItemConfirm">{{$t('btn.delete','Delete')}}</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
              <v-dialog v-model="dialogCreate">
                <v-form
                    v-if="newItem"
                    ref="createConferenceForm"
                    lazy-validation
                    align="center"
                    @submit.prevent="createItemConfirm"
                >
                  <v-card>
                    <v-card-title>{{$t('conference.create.title','Create')}}</v-card-title>
                    <v-card-text>
                      <v-select
                          v-model="newItem.country_id"
                          :items="countries"
                          item-text="name"
                          item-value="id"
                          :label="$t('conference.placeholder.country','Country')"
                          prepend-inner-icon="mdi-database-search"
                          outlined
                      ></v-select>
                      <v-select
                          v-model="newItem.city_id"
                          :items="cities"
                          item-text="name"
                          item-value="id"
                          :label="$t('conference.placeholder.city','City')"
                          prepend-inner-icon="mdi-database-search"
                          outlined
                      ></v-select>
                      <v-text-field
                          v-model="newItem.title"
                          :label="$t('conference.placeholder.title','Title')"
                          outlined
                          prepend-inner-icon="mdi-card-text-outline"
                          :rules="[rules.required]"
                      />
                      <v-menu ref="menu"
                              v-model="menuDate"
                              :close-on-content-click="true"
                              transition="scale-transition"
                              offset-y
                              min-width="290px"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field
                              :value="newItem.date"
                              :label="$t('conference.placeholder.date', 'Date')"
                              prepend-inner-icon="mdi-calendar"
                              readonly
                              v-on="on"
                              outlined
                          />
                        </template>
                        <v-date-picker v-model="newItem.date" no-title scrollable @input="menuDate = false"/>
                      </v-menu>
                      <v-select
                          multiple
                          v-model="newItem.organizers"
                          :items="organizers"
                          item-text="title"
                          item-value="id"
                          :label="$t('conference.placeholder.organizers','Organizers')"
                          prepend-inner-icon="mdi-database-search"
                          outlined
                      ></v-select>
                      <v-file-input
                          accept="application/pdf"
                          label="PDF File"
                          v-model="pdf"
                          prepend-icon=""
                          prepend-inner-icon="mdi-file"
                          outlined
                      />
                    </v-card-text>
                    <v-card-actions>
                      <v-btn color="darken-1" text @click="closeCreate">{{$t('btn.cancel','Cancel')}}</v-btn>
                      <v-spacer></v-spacer>
                      <v-btn color="darken-1" text type="submit">{{$t('btn.create','Create')}}</v-btn>
                    </v-card-actions>
                  </v-card>
                </v-form>
              </v-dialog>
              <v-dialog v-model="dialogEdit">
                <v-form
                    v-if="selectedItem"
                    ref="updateConferenceForm"
                    lazy-validation
                    align="center"
                    @submit.prevent="editItemConfirm"
                >
                  <v-card>
                    <v-card-title>{{$t('conference.edit.title','Edit')}}</v-card-title>
                    <v-card-text>
                      <v-select
                          v-model="selectedItem.country_id"
                          :items="countries"
                          item-text="name"
                          item-value="id"
                          :label="$t('conference.placeholder.country','Country')"
                          prepend-inner-icon="mdi-database-search"
                          outlined
                      ></v-select>
                      <v-select
                          v-model="selectedItem.city_id"
                          :items="cities"
                          item-text="name"
                          item-value="id"
                          :label="$t('conference.placeholder.city','City')"
                          prepend-inner-icon="mdi-database-search"
                          outlined
                      ></v-select>
                      <v-text-field
                          v-model="selectedItem.title"
                          :label="$t('conference.placeholder.title','Title')"
                          outlined
                          prepend-inner-icon="mdi-card-text-outline"
                          :rules="[rules.required]"
                      />
                      <v-menu ref="menu"
                              v-model="menuDate"
                              :close-on-content-click="true"
                              transition="scale-transition"
                              offset-y
                              min-width="290px"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field
                              :value="selectedItem.date"
                              :label="$t('conference.placeholder.date', 'Date')"
                              prepend-inner-icon="mdi-calendar"
                              readonly
                              v-on="on"
                              outlined
                          />
                        </template>
                        <v-date-picker v-model="selectedItem.date" no-title scrollable @input="menuDate = false"/>
                      </v-menu>
                      <v-select
                          multiple
                          v-model="selectedItem.organizers"
                          :items="organizers"
                          item-text="title"
                          item-value="id"
                          :label="$t('conference.placeholder.organizers','Organizers')"
                          prepend-inner-icon="mdi-database-search"
                          outlined
                      ></v-select>
                    </v-card-text>
                    <v-card-actions>
                      <v-btn color="darken-1" text @click="closeEdit">{{$t('btn.cancel','Cancel')}}</v-btn>
                      <v-spacer></v-spacer>
                      <v-btn color="darken-1" text type="submit">{{$t('btn.update','Update')}}</v-btn>
                    </v-card-actions>
                  </v-card>
                </v-form>
              </v-dialog>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon
                    small
                    class="mr-2"
                    @click="showItem(item)"
                >
                  mdi-eye
                </v-icon>
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
        { text: this.$t('conference.placeholder.title','Title'), value: 'title' },
        { text: this.$t('conference.placeholder.date','Date'), value: 'date' },
        { text: this.$t('conference.placeholder.actions','Actions'), value: 'actions', sortable: false },
      ],
      dialogCreate: false,
      dialogEdit: false,
      dialogDelete: false,
      selectedItem: null,
      newItem: null,
      rules: {
        required: value => !!value || 'Required.',
      },
      options: {},
      menuDate: false,
      pdf: null,
    };
  },
  computed: {
    ...mapState({
      conferences: (state) => state.conference.conferences,
      total: (state) => state.conference.total,
      countries: (state) => state.country.countries,
      cities: (state) => state.city.cities,
      organizers: (state) => state.organizer.organizers,
    }),
  },
  mounted() {
    this.getData();
    this.$store.dispatch('country/downloadCountries');
    this.$store.dispatch('organizer/downloadOrganizers');
  },
  methods: {
    showItem (item) {
      this.$router.push( { name: 'Conference', params: { conference_id: item.id } });
    },
    createItem() {
      this.dialogCreate = true;
      this.newItem = {
        country_id: null,
        city_id: null,
        title:'',
        date:null,
        organizers:[],
      };
    },
    editItem (item) {
      this.selectedItem = item;
      this.dialogEdit = true
    },
    deleteItem (item) {
      this.selectedItem = item;
      this.dialogDelete = true
    },
    createItemConfirm: function (e) {
      e.preventDefault();
      e.stopPropagation();
      if (!this.$refs.createConferenceForm.validate()) return;
      this.$loading();
      let form = new FormData();
      if (this.pdf) {
        form.append('file', this.pdf);
      }
      form.append('country_id', this.newItem.country_id);
      form.append('city_id', this.newItem.city_id);
      form.append('title', this.newItem.title);
      form.append('date', this.newItem.date);
      this.newItem.organizers.forEach((value,key) => form.append(`organizers[${key}]`, value));
      this.$store.dispatch('conference/createConference', form)
          .then(() => {
            this.$loadingClose();
            this.$notify('', 'success', this.$t('messages.success', 'Success'));
            this.closeCreate()
          })
          .catch(() => {
            this.$loadingClose();
            this.$notify('', 'error', this.$t('messages.error', 'Error'));
          });
    },
    editItemConfirm (e) {
      e.preventDefault();
      e.stopPropagation();
      if (!this.$refs.updateConferenceForm.validate()) return;
      this.$loading();
      this.$store.dispatch('conference/updateConference', this.selectedItem)
          .then( () => {
            this.$loadingClose();
            this.$notify('','success', this.$t('messages.success','Success'));
            this.closeEdit()
          })
          .catch( () => {
            this.$loadingClose();
            this.$notify('','error', this.$t('messages.error','Error'));
          });
    },
    deleteItemConfirm () {
      this.$loading();
      this.$store.dispatch('conference/deleteConference', this.selectedItem.id)
          .then( () => {
            this.$loadingClose();
            this.$notify('','success', this.$t('messages.success','Success'));
            this.closeDelete()
          })
          .catch( () => {
            this.$loadingClose();
            this.$notify('','error', this.$t('messages.error','Error'));
          });
    },
    closeCreate() {
      this.dialogCreate = false;
      this.newItem = null;
    },
    closeEdit () {
      this.dialogEdit = false;
      this.selectedItem = null;
    },
    closeDelete () {
      this.dialogDelete = false
    },
    getData() {
      this.$loading()
      this.$store.dispatch('conference/downloadConferences', {
        user_id:this.$store.getters['account/getAccount'].id,
        ...this.options,
      }).then(() => {
        this.$loadingClose();
      }).catch(() => {
        this.$loadingClose();
      });
    },
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
        this.$store.dispatch('city/downloadCities');
      },
      deep: true,
    },
    'newItem.country_id': {
      handler () {
        this.$store.dispatch('city/downloadCities');
      },
      deep: true,
    },
  },
}
</script>

<style scoped>

</style>