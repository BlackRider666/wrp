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
import {mapActions, mapState} from "pinia";
import {useOrganizerStore} from "@/stores/organizer";

export default {
  name: "Show",
  computed: {
    ...mapState(useOrganizerStore,['organizer'])
  },
  mounted() {
    this.getOrganizer(this.$route.params.organizer_id);
  },
  methods: {
    ...mapActions(useOrganizerStore,['getOrganizer'])
  }
}
</script>

<style scoped>

</style>
