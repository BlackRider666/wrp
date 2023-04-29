<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-card
            flat
        >
          <v-card-title class="justify-space-between">
            <span class="text-h4 font-weight-medium">{{$t('news.all','All news')}}</span>
            <div class="d-inline-flex align-center">
              <v-select
                  class="mx-2"
                  :items="sortItems"
                  :label="$t('news.sortBy','Sort By')"
                  outlined
                  dense
                  solo
                  hide-details
              />
              <v-btn
                  color="primary"
              >
                {{$t('btn.filters','Filters')}}
              </v-btn>
            </div>
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="3" v-for="n in news" :key="n.id">
                <NewsItem :n="n"/>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import NewsItem from '@/components/news/NewsItem';
import {mapState} from "vuex";

export default {
  name: "Index",
  components: {NewsItem},
  data() {
    return {
      detailed: false,
      sortItems: [
        {
          text:'test',
          value: 'test',
        },
        {
          text:'test2',
          value: 'test2',
        }
      ],
    }
  },
  mounted() {
    this.$store.dispatch('news/downloadNews');
  },
  computed: {
    ...mapState({
      news: (state) => state.news.news,
    }),
  },
}
</script>

<style scoped>

</style>
