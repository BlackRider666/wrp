<template>
  <v-navigation-drawer
      :color="options.color"
      :expand-on-hover="expandOnHover"
      mobile-breakpoint="960"
      app
      class="elevation-1"
  >
    <v-list
        nav
        class="py-0"
    >
      <v-list-item class="pt-5">
        <v-list-item-avatar>
        </v-list-item-avatar>

        <v-list-item-content>
          <v-list-item-title>
            <div class="headline font-weight-bold">WeShare</div>
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item-group color="primary">
        <template v-for="(item, i) in options.items">
          <v-list-item
              :key="i"
              v-if="item.to"
              :to="item.to"
              color="#fff"
              :data-v-step="item.dataStep"
          >
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>{{ $t(item.title) }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <template v-if="item.children">
            <v-list-group :key="i" value="true" :prepend-icon="item.icon">
              <template slot="activator">
                <v-list-item-title>{{ $t(item.title) }}</v-list-item-title>
              </template>

              <v-list-item
                  v-for="(child, i) in item.children"
                  :key="i"
                  :to="child.to"
                  color="#fff"
                  :data-v-step="child.dataStep"
              >
                <v-list-item-icon>
                  <v-icon x-small>{{child.icon || 'mdi-chart-bubble'}}</v-icon>
                </v-list-item-icon>
                <v-list-item-content :data-v-step="child.dataInnerStep">
                  <v-list-item-title>{{ $t(child.title) }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-group>
          </template>
        </template>
      </v-list-item-group>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
export default {
  name: "NavigationMenu",
  props: {
    options: {
      color: {
        default: "primary",
        type: String,
      },
      background: {
        default: null,
        type: String,
      },
      items: {
        default: () => {},
        type: Array,
      },
      activeEl: {
        default: () => {},
        type: Object,
      },
    },
    expandOnHover: {
      default: false,
      type: Boolean,
    },
  },
}
</script>

<style scoped>

</style>