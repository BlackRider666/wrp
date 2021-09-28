<template>
  <v-app-bar
      app
      :tile="false"
      fixed
  >
    <router-link
        class="text-decoration-none"
        :to="{name:'dashboard'}"
    ><v-app-bar-nav-icon>{{$t('main.company-name', 'WRP')}}</v-app-bar-nav-icon>
    </router-link>
    <v-spacer></v-spacer>
    <router-link
        class="text-decoration-none"
        :to="{name:'Create Article'}"
    >
      <v-btn v-if="isLoggedIn" color="primary" icon><v-icon>mdi-plus</v-icon></v-btn>
    </router-link>
    <v-divider vertical color="white" inset class="mr-2"></v-divider>
    <LanguageSwitcher/>
    <template v-if="isLoggedIn">
      <MenuList :options="accountOptions" @itemClicked="goToPage" />
    </template>
  </v-app-bar>
</template>

<script>
import MenuList from "./MenuList";
import LanguageSwitcher from "./LanguageSwitcher";
import {mapState} from "vuex";

export default {
  name: "AppHeader",
  components: {MenuList, LanguageSwitcher},
  computed: {
    accountOptions() {
      return {
        items: [
          {
            title: this.account.full_name || '',
            divider: true,
            subtitleClass: 'text-center font-weight-bold',
            image: this.account.avatar_url || null,
          },
          {
            titleTKey: "header.menu.account",
            titleTDefault: "Account",
            icon: "mdi-account-outline",
            to: {
              name:'account',
            },
            divider: true,
          },
          {
            titleTKey: "header.menu.articles",
            titleTDefault: "Articles",
            icon: "mdi-book-open-variant",
            to: {
              name:'Articles',
            },
            divider: true,
          },
          {
            titleTKey: "header.menu.logout",
            titleTDefault: "Logout",
            icon: "mdi-logout",
            to: {
              name:'logout',
            },
          },
        ],
        titleClass: "v-avatar _max-h-46 _w-auto",
        titleIcon: "mdi-account-outline",
        showArrow: true,
        openOnHover: false,
        badgeContent: null,
        badgeValue: true,
        nudgeBottom: 45,
      }
    },
    isLoggedIn() {
      return this.$store.getters['auth/getAuthToken'].length > 0;
    },
    ...mapState({
      account: state => state.account.user,
    })
  },
  mounted() {
  },
  methods: {
    goToPage({pageName, action}) {
      if (pageName) this.$router.push({name: pageName});
      if (action) action();
    },
  },
}
</script>

<style scoped>

</style>