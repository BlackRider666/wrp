<template>
  <v-card
      class="mx-auto news__card"
  >
    <v-img
        :src="n.main_photo_url"
        class="rounded-0 news__img"
        cover
    >
    </v-img>
    <v-card-title class="text-body-1">
      <template v-if="n.title[locale.iso_code]">
        {{n.title[locale.iso_code].length > 106 ? n.title[locale.iso_code].substring(0,103)+'...':n.title[locale.iso_code] }}
      </template>
    </v-card-title>
    <!--                      <v-card-subtitle class="pb-0">-->
    <!--                        {{ n.tag }}-->
    <!--                      </v-card-subtitle>-->

    <v-card-text class="text-md-caption text-end">
      <span>{{n.created_at}}</span>
    </v-card-text>

    <v-card-actions>
      <v-btn
          block
          class="news__btn"
      >
        {{$t('btn.read-more','Read more')}}
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import {mapState} from "pinia";
import {useLocalesStore} from "../../stores/l10s";

export default {
  name: "NewsItem",
  props:[ 'n'],
  computed: {
    ...mapState(useLocalesStore,['locale'])
  },
}
</script>

<style scoped lang="scss">
.news {
  &__card {
     border-top: 4px solid #1976D2;
   }
  &__img {
     aspect-ratio: 16/9;
     object-fit: contain;
     width: 100%;
   }
  &__btn {
     font-weight: 500;
     box-shadow: none;
     transition: all 0.2s ease-in-out;
    &:hover {
       color: #fff;
       background: #1976D2;
     }
  }
}
</style>
