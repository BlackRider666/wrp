<template>

</template>

<script>
import {mapActions} from "pinia";
import {useAuthStore} from "@/stores/auth";

export default {
  name: "Logout",
  mounted() {
    this.logout().then( () => {
      this.$router.push({name:'login'})
    })
  },
  methods: {
    ...mapActions(useAuthStore,['logout'])
  }
}
</script>

<style scoped>

</style>
