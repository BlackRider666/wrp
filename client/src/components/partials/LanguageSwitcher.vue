<template>
  <v-menu
      :open-on-click="true"
      :close-on-click="true"
      :close-on-content-click="true"
      left
      :nudge-bottom="30"
      ref="locale"
      @itemClicked="changeLanguage"
  >
    <template v-slot:activator="{ on }">
      <div class="font-weight-medium px-1" v-on="on">
        <v-badge
            color="primary"
            :value="null"
        >
          <span v-if="activeLocale.iso_code" v-html="activeLocale.iso_code"></span>
        </v-badge>
        <v-icon>mdi-chevron-down</v-icon>
      </div>
    </template>
    <v-list avatar class="py-0">
      <v-list-item-group class="px-2 py-1">
        <div v-for="item in locales"
             :key="item.id">
          <v-list-item
              class="my-1"
          >
            <v-list-item-content>
              <v-list-item-subtitle v-if="item.name" v-html="item.name"></v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-divider/>
        </div>
      </v-list-item-group>
    </v-list>
  </v-menu>
</template>

<script>
import { mapMutations, mapState, } from "vuex";
import MenuList from "./MenuList";

export default {
  name: "LanguageSwitcher",
  computed: {
    LanguageOptions: function () {
      return {
        items: this.$store.state.l10s.locales,
        titleClass: "subtitle-1",
        titleTKey: this.l10s.locale,
        titleColor: "primary",
      };
    },
    ...mapState({
      locales: (state) => state.l10s.locales,
      activeLocale: (state) => state.l10s.locale,
    },),
  },
  components: {
    MenuList,
  },
  methods: {
    ...mapMutations({
      setLocale: (state) => state.l10s.SET_ACTIVE_LOCALE,
    }),
    changeLanguage(language) {
      this.setLocale(language);
    },
  },
};
</script>

<style scoped>

</style>