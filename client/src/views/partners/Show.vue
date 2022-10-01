<template>
<v-card flat>
  <v-card-title class="justify-center"><span class="text-uppercase">{{ partner.title }}</span></v-card-title>
  <v-card-text>
    <v-row>
      <v-col cols="4">
        <v-img contain :src="partner.logo_url" :alt="partner.title" max-height="200px"/>
      </v-col>
      <v-col cols="8">
        {{partner.desc}}
      </v-col>
    </v-row>
  </v-card-text>
</v-card>
</template>

<script>
import {mapState} from "vuex";

export default {
  name: "Show",
  computed: {
    ...mapState({
      partner: (state) => state.partner.partner,
    })
  },
  mounted() {
    this.$store.dispatch('partner/getPartner', this.$route.params.partner_id);
  },
}
</script>

<style scoped>

</style>