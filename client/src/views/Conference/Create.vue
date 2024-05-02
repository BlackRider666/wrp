<template>
  <v-container>
    <v-row>
    <v-col cols="12">
      <v-card variant="text">
        <v-card-title>{{$t('conference.create.title','Create Conference')}}</v-card-title>
          <v-form
              ref="createConferenceForm"
              lazy-validation
              align="center"
              @submit.prevent="createItemConfirm"
          >
            <v-card-text>
                <v-select
                    v-model="newItem.country_id"
                    :items="countries"
                    item-title="name"
                    item-value="id"
                    :label="$t('conference.placeholder.country','Country')"
                    prepend-inner-icon="mdi-database-search"
                    variant="outlined"
                ></v-select>
                <v-select
                    v-model="newItem.city_id"
                    :items="cities"
                    item-title="name"
                    item-value="id"
                    :label="$t('conference.placeholder.city','City')"
                    prepend-inner-icon="mdi-database-search"
                    variant="outlined"
                ></v-select>
                <v-text-field
                    v-model="newItem.title"
                    :label="$t('conference.placeholder.title','Title')"
                    variant="outlined"
                    prepend-inner-icon="mdi-card-text-outline"
                    :rules="[rules.required]"
                />
                <v-menu ref="menu"
                        v-model="menuDate"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        :return-value.sync="newItem.date"
                        min-width="290px"
                >
                  <template v-slot:activator="{props}">
                    <v-text-field
                        v-model="formatedDate"
                        :label="$t('conference.placeholder.date', 'Date')"
                        prepend-inner-icon="mdi-calendar"
                        readonly
                        v-bind="props"
                        variant="outlined"
                    />
                  </template>
                  <v-date-picker
                      v-model="newItem.date"
                      color="primary"
                      scrollable
                      show-adjacent-months
                      no-title
                      @input="menuDate = false"

                  />
                </v-menu>
                <v-select
                    multiple
                    v-model="newItem.organizers"
                    :items="organizers"
                    item-title="title"
                    item-value="id"
                    :label="$t('conference.placeholder.organizers','Organizers')"
                    prepend-inner-icon="mdi-database-search"
                    variant="outlined"
                ></v-select>
                <v-file-input
                    accept="application/pdf"
                    label="PDF File"
                    v-model="pdf"
                    prepend-icon=""
                    prepend-inner-icon="mdi-file"
                    variant="outlined"
                />
            </v-card-text>
            <v-card-actions>
              <v-btn color="darken-1" variant="text" :to="{name:'Conferences'}">{{$t('btn.cancel','Cancel')}}</v-btn>
              <v-spacer></v-spacer>
              <v-btn color="primary" variant="text" type="submit">{{$t('btn.create','Create')}}</v-btn>
            </v-card-actions>
          </v-form>
      </v-card>
    </v-col>
  </v-row>
  </v-container>
</template>

<script>
import {mapActions, mapState} from "pinia";
import {useCountryStore} from "@/stores/country";
import {useCityStore} from "@/stores/city";
import {useOrganizerStore} from "@/stores/organizer";
import {useConferenceStore} from "@/stores/conference";

export default {
  name: "Create",
  data() {
    return {
      newItem: {
        country_id: null,
        city_id:null,
        title:'',
        date: null,
        organizers:[],
      },
      rules: {
        required: value => !!value || 'Required.',
      },
      menuDate: false,
      pdf: null,
    };
  },
  computed: {
    ...mapState(useCountryStore,['countries']),
    ...mapState(useCityStore,['cities']),
    ...mapState(useOrganizerStore,['organizers']),
    formatedDate() {
      return this.newItem.date ? new Date(this.newItem.date).toLocaleDateString('uk') : '';
    }
  },
  created() {
    this.downloadCountries();
    this.downloadOrganizers();
  },
  methods: {
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
      form.append('date', this.formatedDate);
      this.newItem.organizers.forEach((value,key) => form.append(`organizers[${key}]`, value));
      this.createConference(form)
          .then(() => {
            this.$loadingClose();
            this.$notify('', 'success', this.$t('messages.success', 'Success'));
            this.$router.push({name:'Conferences'})
          })
          .catch(() => {
            this.$loadingClose();
            this.$notify('', 'error', this.$t('messages.error', 'Error'));
          });
    },
    ...mapActions(useConferenceStore,['createConference']),
    ...mapActions(useCountryStore,['downloadCountries']),
    ...mapActions(useCityStore,['downloadCities']),
    ...mapActions(useOrganizerStore,['downloadOrganizers']),
  },
  watch: {
    'newItem.country_id': {
      handler () {
        this.downloadCities();
      },
      deep: true,
    },
  }
}
</script>
<style scoped>

</style>
