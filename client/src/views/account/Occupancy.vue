<template>
  <v-col cols="12">
    <v-card flat>
      <v-card-title>{{$t('occupancy.title','Occupancy percentage account')}}</v-card-title>
      <v-card-text>
        <v-progress-linear
            :value="parseInt(occupancy.total * 100)"
            striped
            color="primary"
            height="25"
        >
          <template v-slot:default="{ value }">
            <strong>{{ Math.ceil(value) }}%</strong>
          </template>
        </v-progress-linear>
      </v-card-text>
    </v-card>
  </v-col>
</template>

<script>
import {mapActions, mapState} from "pinia";
import {useAccountStore} from "@/stores/account";

export default {
  name: "Occupancy",
  computed: {
    ...mapState(useAccountStore,['occupancy']),
  },
  mounted() {
    this.getOccupancyAccount();
  },
  methods: {
    ...mapActions(useAccountStore,['getOccupancyAccount'])
  },
}
</script>

<style scoped>

</style>
