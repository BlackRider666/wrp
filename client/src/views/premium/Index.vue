<template>
  <v-row>
    <v-col cols="12">
      <v-card >
        <v-card-title>
          {{$t('premium.title','Premium')}}
        </v-card-title>
        <v-card-text>
          <v-btn color="primary" @click="getFreePremium">{{$t('premium.get-free','Get free premium')}}</v-btn>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "Index",
  methods: {
    getFreePremium() {
      this.$loading();
      this.$store.dispatch('premium/getFree')
          .then(() => {
            this.$loadingClose();
            this.$notify('','success', 'Success');
          })
          .catch(error => {
            this.$loadingClose();
            this.$notify('','error', error.response.data.message);
          })
    }
  },
}
</script>

<style scoped>

</style>