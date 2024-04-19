<template>
<v-container>
  <v-row>
    <v-col cols="12">
      <v-card
          flat
      >
        <v-card-title class="d-flex justify-space-between">
          <span class="text-h4 font-weight-medium">{{$t('organizations.all','All organizations')}}</span>
          <div class="d-inline-flex align-center justify-center">
            <v-switch
                class="mx-2"
                v-model="detailed"
                :label="$t('organizations.detailed','Detailed')"
                hide-details
            />
            <v-select
                class="mx-2"
                :items="sortItems"
                :label="$t('organizations.sortBy','Sort By')"
                variant="outlined"
                density="compact"
                solo
                hide-details
            />
            <v-btn
                color="primary"
            >
              {{$t('btn.filters','Filters')}}
            </v-btn>
          </div>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col :cols="detailed?6:3" v-for="org in organizations" :key="org.id">
              <OrganizationItem :org="org" :detailed="detailed"/>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</v-container>
</template>

<script>
import {mapActions, mapState} from "pinia";
import OrganizationItem from "@/components/organizations/OrganizationItem.vue";
import {useOrganizationStore} from "@/stores/organization";
export default {
  name: "Index",
  data() {
    return {
      detailed: false,
      sortItems: [
        {
          title:'test',
          value: 'test',
        },
        {
          title:'test2',
          value: 'test2',
        }
      ],
    }
  },
  components: {
    OrganizationItem,
  },
  mounted() {
    this.downloadOrganizations();
  },
  computed: {
    ...mapState(useOrganizationStore,['organizations']),
  },
  methods: {
    ...mapActions(useOrganizationStore,['downloadOrganizations'])
  }
}
</script>

<style scoped>

</style>
