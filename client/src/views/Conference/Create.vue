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
                    :item-title="`name[${locale.iso_code}]`"
                    item-value="id"
                    :label="$t('conference.placeholder.country','Country')"
                    prepend-inner-icon="mdi-database-search"
                    variant="outlined"
                    :rules="[rules.required]"
                ></v-select>
                <v-select
                    v-model="newItem.city_id"
                    :items="cities"
                    :item-title="`name[${locale.iso_code}]`"
                    item-value="id"
                    :label="$t('conference.placeholder.city','City')"
                    prepend-inner-icon="mdi-database-search"
                    variant="outlined"
                    :rules="[rules.required]"
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
                        :rules="[rules.required]"
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
                    :rules="[rules.requiredOneOf]"
                ></v-select>
                <v-select
                    multiple
                    v-model="newItem.organizations"
                    :items="organizations"
                    :item-title="`name[${locale.iso_code}]`"
                    item-value="id"
                    :label="$t('conference.placeholder.organizations','Organizations')"
                    prepend-inner-icon="mdi-database-search"
                    variant="outlined"
                    :rules="[rules.requiredOneOf]"
                ></v-select>
                <v-file-input
                    accept="application/pdf"
                    label="PDF File"
                    v-model="pdf"
                    prepend-icon=""
                    prepend-inner-icon="mdi-file"
                    variant="outlined"
                    :rules="[rules.requiredFile]"
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
import {useLocalesStore} from "@/stores/l10s";
import {useOrganizationStore} from "@/stores/organization";

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
        organizations:[],
      },
      rules: {
        required: value => !!value || 'Required.',
        requiredOneOf: () => {
          return (this.newItem.organizations.length > 0 || this.newItem.organizers.length > 0) || 'Organizations or Organizers required.';
        },
        requiredFile: value => (value !== null && value !== '' && value.length > 0) || 'You must select a file.'
      },
      menuDate: false,
      pdf: null,
    };
  },
  computed: {
    ...mapState(useCountryStore,['countries']),
    ...mapState(useCityStore,['cities']),
    ...mapState(useOrganizerStore,['organizers']),
    ...mapState(useLocalesStore,['locale']),
    ...mapState(useOrganizationStore,['organizations']),
    formatedDate() {
      return this.newItem.date ? new Date(this.newItem.date).toLocaleDateString('uk') : '';
    }
  },
  created() {
    this.downloadCountries();
    this.downloadOrganizers({perPage:-1});
    this.downloadOrganizations({perPage:-1});
  },
  methods: {
    createItemConfirm: function (e) {
      e.preventDefault();
      e.stopPropagation();
      this.$loading();
      this.$refs.createConferenceForm.validate().then((valid) => {
        if (!valid.valid) {
          this.$loadingClose();
          return;
        }
        let form = new FormData();
        if (this.pdf) {
          form.append('file', this.pdf);
        }
        form.append('country_id', this.newItem.country_id);
        form.append('city_id', this.newItem.city_id);
        form.append('title', this.newItem.title);
        form.append('date', this.formatedDate);
        this.newItem.organizers.forEach((value, key) => form.append(`organizers[${key}]`, value));
        this.newItem.organizations.forEach((value, key) => form.append(`organizations[${key}]`, value));
        this.createConference(form)
            .then(() => {
              this.$loadingClose();
              this.$notify('', 'success', this.$t('messages.success', 'Success'));
              this.$router.push({name: 'Conferences'})
            })
            .catch(() => {
              this.$loadingClose();
              this.$notify('', 'error', this.$t('messages.error', 'Error'));
            });
      })
    },
    ...mapActions(useConferenceStore,['createConference']),
    ...mapActions(useCountryStore,['downloadCountries']),
    ...mapActions(useCityStore,['downloadCities']),
    ...mapActions(useOrganizerStore,['downloadOrganizers']),
    ...mapActions(useOrganizationStore,['downloadOrganizations']),
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
