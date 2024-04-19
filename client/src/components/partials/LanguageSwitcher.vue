<template>
  <v-menu
      open-on-click
      close-on-click
      close-on-content-click
      bottom
      location-strategy="connected"
      offset="10"
      ref="locale"
  >
    <template v-slot:activator="{ props }">
      <div class="font-weight-medium px-1" v-bind="props">
        <span v-if="activeLocale.iso_code" v-html="activeLocale.iso_code"></span>
        <v-icon>mdi-chevron-down</v-icon>
      </div>
    </template>
    <v-list class="py-0">
          <v-list-item
              v-for="item in locales"
              :key="item.id"
              class="my-1"
              :title="item.name"
              @click="changeLanguage(item)"
          ></v-list-item>
          <v-divider></v-divider>
    </v-list>
  </v-menu>
</template>

<script>
import {mapActions, mapState} from "pinia";
import {useLocalesStore} from "@/stores/l10s";

export default {
  name: "LanguageSwitcher",
  computed: {
    LanguageOptions: function () {
      return {
        items: this.locales,
        titleClass: "subtitle-1",
        titleTKey: this.L10s.locale,
        titleColor: "primary",
      };
    },
    ...mapState(useLocalesStore,{
      locales: 'locales',
      activeLocale: 'locale',
    },),
  },
  methods: {
    ...mapActions(useLocalesStore,['setActiveLocale']),
    changeLanguage(language) {
      this.$loading();
      this.setActiveLocale(language)
          .then(() => {
            this.$loadingClose();
          });
    },
  },
};
</script>

<style scoped>

</style>
