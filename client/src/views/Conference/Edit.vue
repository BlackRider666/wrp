
<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-card>
          <v-card-title>{{$t('conference.edit.title','Edit')}}</v-card-title>
            <v-form
                v-if="selectedItem"
                ref="updateConferenceForm"
                lazy-validation
                align="center"
                @submit.prevent="editItemConfirm"
            >
              <v-card-text>
              <v-select
                  v-model="selectedItem.country_id"
                  :items="countries"
                  item-title="name"
                  item-value="id"
                  :label="$t('conference.placeholder.country','Country')"
                  prepend-inner-icon="mdi-database-search"
                  variant="outlined"
              ></v-select>
              <v-select
                  v-model="selectedItem.city_id"
                  :items="cities"
                  item-title="name"
                  item-value="id"
                  :label="$t('conference.placeholder.city','City')"
                  prepend-inner-icon="mdi-database-search"
                  variant="outlined"
              ></v-select>
              <v-text-field
                  v-model="selectedItem.title"
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
              :return-value.sync="selectedItem.date"
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
                  v-model="selectedItem.date"
                  color="primary"
                  scrollable
                  show-adjacent-months
                  no-title
                  @input="menuDate = false"

              />
              </v-menu>
              <v-select
                  multiple
                  v-model="selectedItem.organizers"
                  :items="organizers"
                  item-title="title"
                  item-value="id"
                  :label="$t('conference.placeholder.organizers','Organizers')"
                  prepend-inner-icon="mdi-database-search"
                  variant="outlined"
              ></v-select>
            </v-card-text>
            <v-card-actions>
              <v-btn color="darken-1" variant="text" :to="{name:'Conferences'}">{{$t('btn.cancel','Cancel')}}</v-btn>
              <v-spacer></v-spacer>
              <v-btn color="primary" variant="text" type="submit">{{$t('btn.update','Update')}}</v-btn>
            </v-card-actions>
          </v-form>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import {mapActions, mapState} from "pinia";
import {useConferenceStore} from "@/stores/conference";
import {useCountryStore} from "@/stores/country";
import {useCityStore} from "@/stores/city";
import {useOrganizerStore} from "@/stores/organizer";

export default {
  name: "Edit",
  data() {
    return {
      selectedItem:null,
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
      return this.selectedItem.date ? new Date(this.selectedItem.date).toLocaleDateString('uk') : '';
    }
  },
  created() {
    this.getConference(this.$route.params.conference_id).then((res) => {
      this.selectedItem = {
        id: res.id,
        country_id: res.country_id,
        city_id : res.city_id,
        title : res.title,
        date : new Date(res.date),
        organizers : res.organizers.map( (item) => item.id)
      };
    }).catch( () => {
      this.$router.push({name:'error-404'})
    });
    this.downloadCountries();
    this.downloadOrganizers();
  },
  methods: {
    editItemConfirm (e) {
      e.preventDefault();
      e.stopPropagation();
      if (!this.$refs.updateConferenceForm.validate()) return;
      this.$loading();
      let form = this.selectedItem;
      form.date = this.formatedDate;
      this.updateConference(form)
          .then( () => {
            this.$loadingClose();
            this.$notify('','success', this.$t('messages.success','Success'));
            this.$router.push({name:'Conferences'});
          })
          .catch( () => {
            this.$loadingClose();
            this.$notify('','error', this.$t('messages.error','Error'));
          });
    },
    ...mapActions(useConferenceStore,['getConference','updateConference']),
    ...mapActions(useCountryStore,['downloadCountries']),
    ...mapActions(useCityStore,['downloadCities']),
    ...mapActions(useOrganizerStore,['downloadOrganizers']),
  },
  watch: {
    'selectedItem.country_id': {
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
