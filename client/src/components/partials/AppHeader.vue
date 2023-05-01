<template>
  <v-app-bar
      app
      :tile="false"
      fixed
  >
    <router-link
        class="text-decoration-none subtitle-1 text--primary"
        :to="{name:'dashboard'}"
    >{{$t('main.company-name', 'WRP')}}
    </router-link>
    <v-spacer/>
    <LanguageSwitcher/>
    <v-btn icon :to="{name:'contacts'}" color="#000" class="ml-0 mr-4" width="20" height="20"><v-icon>mdi-information</v-icon></v-btn>
    <v-divider vertical color="white" inset></v-divider>
    <v-btn :to="{name:'Create Article'}" color="primary" text class="mx-2"><v-icon>mdi-plus</v-icon> Add new article</v-btn>
    <v-divider vertical color="white" inset></v-divider>
    <template v-if="isLoggedIn">
      <v-btn icon class="mx-2">
        <v-icon>mdi-bell</v-icon>
        <v-badge color="primary" content="6"></v-badge>
      </v-btn>
      <MenuList :options="accountOptions" @itemClicked="goToPage" />
    </template>
    <template v-else>
      <v-btn :to="{name:'login'}" color="primary" outlined class="mx-2">Login</v-btn>
      <v-btn :to="{name:'register'}" color="primary" class="mx-2">Register</v-btn>
    </template>
<!--    <v-form-->
<!--      class="d-inline-flex"-->
<!--      ref="form"-->
<!--      lazy-validation-->
<!--      align="center"-->
<!--      @submit.prevent="mainSearch"-->
<!--    ><v-row no-gutters>-->
<!--        <v-col cols="6">-->
<!--          <v-text-field-->
<!--              v-model="search"-->
<!--              :placeholder="$t('search.placeholder', 'Search ...')"-->
<!--              hide-details-->
<!--              :rules="[rules.required]"-->
<!--          />-->
<!--        </v-col>-->
<!--        <v-col cols="3">-->
<!--          <v-select-->
<!--              v-model="searchType"-->
<!--              :items="types"-->
<!--              :placeholder="$t('search.type.placeholder', 'Choose')"-->
<!--              :item-text="(item) => $t('search.type.'+item.key, item.value)"-->
<!--              hide-details-->
<!--              :rules="[rules.required]"-->
<!--              return-object-->
<!--          ></v-select>-->
<!--        </v-col>-->
<!--        <v-col cols="3">-->
<!--          <v-btn-->
<!--              text-->
<!--              type="submit"-->
<!--          ><v-icon>mdi-magnify</v-icon></v-btn>-->
<!--        </v-col>-->
<!--      </v-row>-->
<!--    </v-form>-->
<!--    <v-btn :to="{name:'Main Search', params:{type:'articles'}}" color="primary">{{$t('articles.index.title','Articles')}}</v-btn>-->
  </v-app-bar>
</template>

<script>
import MenuList from "./MenuList";
import LanguageSwitcher from "./LanguageSwitcher";
import {mapState} from "vuex";

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
    accountOptions() {
      let items = [];
      let account = this.$store.getters['account/getAccount'];
      if (
          (account.length > 0 && account.roles.filter((item) => item.name === 'superadmin').length > 0)
          ||
          (account.length > 0 && account.roles.filter((item) => item.name === 'conference creator').length > 0)
      ) {
         items = [
          {
            title: this.account.full_name || '',
            divider: true,
            subtitleClass: 'text-center font-weight-bold',
            image: this.account.avatar_url || null,
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
            title: this.account.full_name || '',
            divider: true,
            subtitleClass: 'text-center font-weight-bold',
            image: this.account.avatar_url || null,
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
