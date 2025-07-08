<template>
  <v-menu
      open-on-click
      close-on-click
      close-on-content-click
      :offset="15"
      bottom
      location-strategy="connected"
  >
    <template v-slot:activator="{ props }">
      <div :data-v-step="dataStep" class="cursor-pointer mx-2"
           v-bind="props">
        <v-avatar size="42">
          <v-img :src="options.titleImage"/>
        </v-avatar>
      </div>
    </template>
    <v-list avatar class="py-0">
      <template v-if="options.subheader || options.subheaderTKey">
        <v-card
            color="primary"
            dark
            tile
            :elevation="0"
        >
          <v-card-title>
            <div v-if="options.subheader" v-html="options.subheader"></div>
            <div v-if="options.subheaderTKey">{{ $t(options.subheaderTKey,options.subheaderTDefault) }}</div>
          </v-card-title>
        </v-card>
      </template>
      <v-list class="px-2 py-1">
        <div v-for="(item, index) in options.items"
             :key="index">
          <v-list-item
              class="my-1"
              :to="item.to"
          >
            <v-list-item-subtitle :class="item.subtitleClass" v-if="item.title">
              <v-avatar size="26" v-if="item.image || item.icon">
                <v-img v-if="item.image" :src="item.image"></v-img>
                <v-icon v-if="item.icon">{{item.icon}}</v-icon>
              </v-avatar>
              <flag v-if="item.flag" :iso="item.flag" class="mr-2" />
              <span class="ml-3">{{item.title}}</span>
            </v-list-item-subtitle>
            <v-list-item-title :class="item.subtitleClass" v-if="item.titleTKey">
              <v-avatar size="26" v-if="item.image || item.icon">
                <v-img v-if="item.image" :src="item.image"></v-img>
                <v-icon v-if="item.icon">{{item.icon}}</v-icon>
              </v-avatar>
              <flag v-if="item.flag" :iso="item.flag" class="mr-2" />
              <span class="ml-3">{{$t(item.titleTKey,item.titleTDefault)}}</span>
            </v-list-item-title>
          </v-list-item>
          <div :class="{'list-divider': item.divider}"></div>
        </div>
      </v-list>
    </v-list>
  </v-menu>
</template>

<script>
import {mapState} from "pinia";

export default {
  name: "MenuList",
  props: {
    dataStep: {
      default: '',
      type: String,
    },
    options: {
      items: {
        default: () => {},
        type: Array,
      },
      offsetY: {
        default: true,
        type: Boolean,
      },
      nudgeBottom: {
        default: 30,
        type: Number,
      },
      offsetX: {
        default: false,
        type: Boolean,
      },
      openOnHover: {
        default: false,
        type: Boolean,
      },
      closeOnClick: {
        default: false,
        type: Boolean,
      },
      closeOnContentClick: {
        default: false,
        type: Boolean,
      },
      subheader: {
        default: null,
      },
      subheaderTKey: {
        default: null,
      },
      showArrow: {
        default: false,
        type: Boolean,
      },
      titleIcon: {
        default: null,
        type: String,
      },
      title: {
        default: null,
        type: String,
      },
      titleClass: {
        default: "",
        type: String,
      },
      titleTKey: {
        default: null,
        type: String,
      },
      titleFlag: {
        default: null,
        type: String,
      },
      titleImage: {
        default: null,
      },
      badgeContent: {
        default: null,
      },
      badgeColor: {
        default: "primary",
      },
      href: {
        default: "",
      },
      blinkAccount: {
        default:false,
        type: Boolean,
      },
    },
  },
  computed: {
    toAccount() {
      return this.$route.name !== 'account'
          // && this.$store.state.tutorial.step === 1
          // && this.$store.state.tutorial.tutorialCategory === 'account';
    },
    toArticle() {
      return this.$route.name !== 'Articles'
          // && this.$store.state.tutorial.step === 1
          // && this.$store.state.tutorial.tutorialCategory === 'article';
    },
  }
}
</script>

<style>
@keyframes blink {
  0% {
    box-shadow: 0 0 30px #e8b923;
  }
  50% {
    box-shadow: none;
  }
  100% {
    box-shadow: 0 0 30px #e8b923;
  }
}
@-webkit-keyframes blink {
  0% {
    box-shadow: 0 0 30px #e8b923;
  }
  50% {
    box-shadow: 0 0 0;
  }
  100% {
    box-shadow: 0 0 30px #e8b923;
  }
}
.blink {
  -webkit-animation: blink 1.0s linear infinite;
  -moz-animation: blink 1.0s linear infinite;
  -ms-animation: blink 1.0s linear infinite;
  -o-animation: blink 1.0s linear infinite;
  animation: blink 1.0s linear infinite;
}
.cursor-pointer {
  cursor: pointer;
}
</style>
