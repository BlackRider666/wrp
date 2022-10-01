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
import {mapState} from "vuex";

export default {
  name: "Occupancy",
  computed: {
    ...mapState({
      occupancy: (state) => state.account.occupancy,
    }),
  },
  mounted() {
    this.$store.dispatch('account/getOccupancyAccount');
  }
}
</script>

<style scoped>

</style>