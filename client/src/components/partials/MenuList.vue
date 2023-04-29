<template>
  <v-menu
      :open-on-hover="options.openOnHover"
      :close-on-click="options.closeOnClick"
      :close-on-content-click="options.closeOnContentClick"
      :offset-x="options.offsetX"
      :offset-y="options.offsetY"
      right
      :nudge-bottom="options.nudgeBottom"
  >
    <template v-slot:activator="{ on }">
      <div :data-v-step="dataStep" class="cursor-pointer mx-2" :class="toAccount|| toArticle?'blink '+options.iconsType: options.iconsType" v-on="on">
        <v-avatar size="42">
          <v-img :src="account.avatar_url" :alt="account.full_name"/>
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
      <v-list-item-group class="px-2 py-1">
        <div v-for="(item, index) in options.items"
             :key="index">
          <v-list-item
              class="my-1"
              :to="item.to"
              :class="(item.blinkAccount && toAccount) || (item.blinkArticles && toArticle)?'blink':''"
          >
            <v-list-item-avatar size="26" v-if="item.image || item.icon">
              <v-img v-if="item.image" :src="item.image"></v-img>
              <v-icon v-if="item.icon">{{item.icon}}</v-icon>
            </v-list-item-avatar>
            <flag v-if="item.flag" :iso="item.flag" class="mr-2" />
            <v-list-item-content>
              <v-list-item-subtitle :class="item.subtitleClass" v-if="item.title" v-html="item.title"></v-list-item-subtitle>
              <v-list-item-subtitle :class="item.subtitleClass" v-if="item.titleTKey">{{$t(item.titleTKey,item.titleTDefault)}}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <div :class="{'list-divider': item.divider}"></div>
        </div>
      </v-list-item-group>
    </v-list>
  </v-menu>
</template>

<script>
import {mapState} from "vuex";

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
      return this.$route.name !== 'account' && this.$store.state.tutorial.step === 1 && this.$store.state.tutorial.tutorialCategory === 'account';
    },
    toArticle() {
      return this.$route.name !== 'Articles' && this.$store.state.tutorial.step === 1 && this.$store.state.tutorial.tutorialCategory === 'article';
    },
    ...mapState({
      account: state => state.account.user,
    })
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
