<template>
  <v-card flat>
    <v-card-title class="justify-center"><span class="text-uppercase">{{ organizer.title }}</span></v-card-title>
    <v-card-text>
      <v-row>
        <v-col cols="4">
          <v-img contain :src="organizer.logo_url" :alt="organizer.title" max-height="200px"/>
        </v-col>
        <v-col cols="8">
          {{organizer.desc}}
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
      organizer: (state) => state.organizer.organizer,
    })
  },
  mounted() {
    this.$store.dispatch('organizer/getOrganizer', this.$route.params.organizer_id);
  },
}
</script>

<style scoped>

</style>