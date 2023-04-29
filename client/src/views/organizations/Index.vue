<template>
<v-container>
  <v-row>
    <v-col cols="12">
      <v-card
          flat
      >
        <v-card-title class="justify-space-between">
          <span class="text-h4 font-weight-medium">{{$t('organizations.all','All organizations')}}</span>
          <div class="d-inline-flex align-center">
            <v-switch
                class="mx-2"
                v-model="detailed"
                :label="$t('organizations.detailed','Detailed')"
            />
            <v-select
                class="mx-2"
                :items="sortItems"
                :label="$t('organizations.sortBy','Sort By')"
                outlined
                dense
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
            <v-col cols="3" v-for="org in organizations" :key="org.id">
              <OrganizationItem :org="org"/>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</v-container>
</template>

<script>
import {mapState} from "vuex";
import OrganizationItem from "@/components/organizations/OrganizationItem";
export default {
  name: "Index",
  data() {
    return {
      detailed: false,
      sortItems: [
        {
          text:'test',
          value: 'test',
        },
        {
          text:'test2',
          value: 'test2',
        }
      ],
    }
  },
  components: {
    OrganizationItem,
  },
  mounted() {
    this.$store.dispatch('organization/downloadOrganizations');
  },
  computed: {
    ...mapState({
      organizations: (state) => state.organization.organizations,
    }),
  },
}
</script>

<style scoped>

</style>
