<template>
  <v-footer
      class="font-weight-medium"
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
      <v-btn text href="https://www.patprofi.world/">Розробник: PATProfi</v-btn>
      <v-tooltip top>
        <template v-slot:activator="{ on, attrs }">
          <v-btn
              text
              v-bind="attrs"
              v-on="on"
              href="https://aseu.eu/"
          >
            Розпорядник: АНОУ
          </v-btn>
        </template>
        <span>Асоціація науки та освіти України</span>
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
