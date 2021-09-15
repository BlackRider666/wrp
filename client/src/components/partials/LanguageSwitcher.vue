<template>
  <MenuList ref="languages" :options="LanguageOptions" @itemClicked="changeLanguage" />
</template>

<script>
import { mapMutations, mapState, } from "vuex";
import MenuList from "./MenuList";

export default {
  name: "LanguageSwitcher",
  computed: {
    LanguageOptions: function () {
      return {
        items: this.$store.state.locales,
        titleClass: "subtitle-1",
        titleTKey: this.$i18n.locale,
        titleFlag: this.$i18n.locale,
        titleColor: "primary",
        closeOnContentClick: true,
        badgeContent: null,
        openOnHover: true,
        badgeValue: null,
        nudgeBottom: 30,
      };
    },
    ...mapState({
      locales: "locales",
    },),
  },
  components: {
    MenuList,
  },
  methods: {
    ...mapMutations({
      setLocale: "SET_ACTIVE_LANGUAGE",
    }),
    changeLanguage(language) {
      this.setLocale(language);
    },
  },
};
</script>

<style scoped>

</style>