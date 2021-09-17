<template>
  <div style="height: 100%">
    <AppHeader />
    <v-main class="main-content">
      <v-container fluid class="px-0">
        <v-row>
          <v-col cols="12" class="py-0">
            <Breadcrumbs/>
            <router-view />
          </v-col>
        </v-row>
      </v-container>
      <Footer :text="$t('footer.all-reserved')"/>
    </v-main>
  </div>
</template>

<script>
import AppHeader from "@/components/partials/AppHeader";
import NavigationMenu from "@/components/partials/NavigationMenu";
import Breadcrumbs from "@/components/partials/Breadcrumbs";
import Footer from "@/components/partials/Footer";

export default {
  name: "Main",
  components: {AppHeader, NavigationMenu, Breadcrumbs, Footer},
  data() {
    return {
      navigationOptions: {
        color: "#fff",
        mobileShowValue: false,
        items: [
          {
            title: 'channels.title',
            icon: "mdi-youtube-subscription",
            to: '/'
          },
        ],
      },
    }
  },
}
</script>

<style scoped>

</style>