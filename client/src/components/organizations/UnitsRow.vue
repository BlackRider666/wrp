<template>
    <v-col cols="2" v-for="unit in units" :key="unit.id">
      <div class="d-flex flex-column align-center">
        <v-avatar justify-self="center" size="64" class="mb-2" color="primary">U</v-avatar>
        <span class="text-caption">{{unit.name}}</span>
      </div>
    </v-col>
</template>

<script>
export default {
  name: "UnitsRow",
  props:['units'],
}
</script>

<style scoped>

</style>
