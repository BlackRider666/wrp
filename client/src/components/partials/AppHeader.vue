<template>
  <v-app-bar
      app
      :tile="false"
      fixed
      class="px-4 py-1"
  >
    <router-link
        class="text-decoration-none subtitle-1 text--primary"
        :to="{name:'dashboard'}"
    >
      <template v-if="$route.name !== 'dashboard'">
        <v-img :width="67" :aspect-ratio="16/9" contain="contain" :src="require('@/assets/logo.svg')"/>
      </template>
      <template v-else>
        {{$t('main.company-name', 'WRP')}}
      </template>
    </router-link>
    <v-spacer/>
    <LanguageSwitcher/>
    <v-btn icon="mdi-information" :to="{name:'contacts'}" color="#000" class="ml-0 mr-4" width="20" height="20"></v-btn>
    <v-divider vertical inset></v-divider>
    <v-btn :to="{name:'Create Article'}" color="primary" variant="text" class="mx-2"><v-icon>mdi-plus</v-icon> Add new article</v-btn>
    <v-divider vertical inset></v-divider>
    <template v-if="isLoggedIn">
<!--      <v-btn icon class="mx-2">-->
<!--        <v-icon>mdi-bell</v-icon>-->
<!--        <v-badge color="primary" content="6"></v-badge>-->
<!--      </v-btn>-->
      <MenuList :options="accountOptions" @itemClicked="goToPage" />
    </template>
    <template v-else>
      <v-btn :to="{name:'login'}" color="primary" variant="outlined" class="mx-2">Login</v-btn>
      <v-btn :to="{name:'register'}" color="primary" variant="flat" class="mx-2">Register</v-btn>
    </template>
  </v-app-bar>
</template>

<script>
import MenuList from "./MenuList.vue";
import LanguageSwitcher from "./LanguageSwitcher.vue";
import {mapState} from "pinia";
import {useAccountStore} from "@/stores/account";
import {useAuthStore} from "@/stores/auth";
import {useLocalesStore} from "@/stores/l10s";

export default {
  name: "AppHeader",
  components: {MenuList, LanguageSwitcher},
  data() {
    return {
      search:null,
      searchType:null,
      types: [
        {
          key:'users',
          value:'Users'
        },
        {
          key:'articles',
          value:'Articles'
        }
      ],
      rules: {
        required: value => !!value || 'Required.',
      },
    };
  },
  computed: {
    ...mapState(useAccountStore,{
      account: 'user',
    }),
    ...mapState(useAuthStore,['token']),
    ...mapState(useLocalesStore,['locale']),
    accountOptions() {
      let items = [];
      let account = this.account;
      if (
          (account && account.roles.filter((item) => item.name === 'superadmin').length > 0)
          ||
          (account && account.roles.filter((item) => item.name === 'conference creator').length > 0)
      ) {
         items = [
          {
            title: this.account.full_name[this.locale.iso_code] || '',
            divider: true,
            subtitleClass: 'text-center font-weight-bold',
            image: this.account.avatar_url || null,
            to: {
              name:'User',
              params: {
                user_id: this.account.id,
              }
            }
          },
          {
            titleTKey: "header.menu.premium",
            titleTDefault: "Premium",
            icon: "mdi-account-outline",
            to: {
              name:'Premium',
            },
            divider: true,
          },
          {
            titleTKey: "header.menu.account",
            titleTDefault: "Account",
            icon: "mdi-account-outline",
            to: {
              name:'account',
            },
            divider: true,
            blinkAccount: true,
          },
          {
            titleTKey: "header.menu.conferences",
            titleTDefault: "Conferences",
            icon: "mdi-book-open-variant",
            to: {
              name:'Conferences',
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
            blinkArticles: true,
          },
          {
            titleTKey: "header.menu.logout",
            titleTDefault: "Logout",
            icon: "mdi-logout",
            to: {
              name:'logout',
            },
          },
        ];
      } else {
        items = [
          {
            title: this.account.full_name[this.locale.iso_code]  || '',
            divider: true,
            subtitleClass: 'text-center font-weight-bold',
            image: this.account.avatar_url || null,
            to: {
              name:'User',
              params: {
                user_id: this.account.id,
              }
            }
          },
          {
            titleTKey: "header.menu.premium",
            titleTDefault: "Premium",
            icon: "mdi-account-outline",
            to: {
              name:'Premium',
            },
            divider: true,
          },
          {
            titleTKey: "header.menu.account",
            titleTDefault: "Account",
            icon: "mdi-account-outline",
            to: {
              name:'account',
            },
            divider: true,
            blinkAccount: true,
          },
          {
            titleTKey: "header.menu.articles",
            titleTDefault: "Articles",
            icon: "mdi-book-open-variant",
            to: {
              name:'Articles',
            },
            divider: true,
            blinkArticles: true,
          },
          {
            titleTKey: "header.menu.logout",
            titleTDefault: "Logout",
            icon: "mdi-logout",
            to: {
              name:'logout',
            },
          },
        ]
      }

      return {
        items: items,
        titleImage: this.account.avatar_url,
        showArrow: true,
        openOnHover: false,
        badgeContent: null,
        badgeValue: true,
        nudgeBottom: 45,
      }
    },
    isLoggedIn() {
      return this.token.length > 0;
    },
  },
  mounted() {
  },
  methods: {
    goToPage({pageName, action}) {
      if (pageName) this.$router.push({name: pageName});
      if (action) action();
    },
    mainSearch(e) {
      e.preventDefault();
      e.stopPropagation();
      if (!this.$refs.form.validate()) return;
      this.$router.push({name:'Main Search', params:{type:this.searchType.key}, query: {title:this.search}})
    }
  },
}
</script>

<style scoped>

</style>
