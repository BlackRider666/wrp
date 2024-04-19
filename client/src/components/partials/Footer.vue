<template>
  <v-footer
      class="font-weight-medium bg-grey-lighten-5"
  >
    <v-col
        class="text-left"
        cols="6"
    >
      <span class="text-uppercase">Copyright</span> @ {{`2021 - ${new Date().getFullYear()}` }}
    </v-col>
    <v-col
        class="text-right"
        cols="6"
    >
      <v-btn variant="text" href="https://www.patprofi.world/">Розробник: PATProfi</v-btn>
      <v-tooltip location="top" text="Асоціація науки та освіти України">
        <template v-slot:activator="{props}">
          <v-btn
              variant="text"
              v-bind="props"
              href="https://aseu.eu/"
          >
            Розпорядник: АНОУ
          </v-btn>
        </template>
      </v-tooltip>
    </v-col>
  </v-footer>
</template>

<script>
export default {
name: "Footer"
}
</script>

<style scoped>

</style>
