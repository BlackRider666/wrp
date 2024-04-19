<template>
  <v-container>
    <v-row justify="center" class="my-16">
      <v-col cols="8">
        <v-row justify="center">
          <v-col cols="6" class="text-center">
            <v-img :width="150" :aspect-ratio="16/9" contain="contain" :src="require('@/assets/logo.svg')" class="mx-auto"/>
            <div class="text-h6 dashboard__title">World Research Platform</div>
          </v-col>
        </v-row>
        <v-form action="/search/all">
          <v-row>
            <v-col cols="10" offset="1">
              <v-text-field
                  variant="outlined"
                  :label="$t('home.search.label', 'Search by name or title of project')"
                  hide-details
                  name="title"
              />
              <p class="text-center text-caption text--secondary my-1">{{ $t('home.search.hint', 'A quick search on all materials of the platform') }}</p>
            </v-col>
            <v-col cols="1">
              <v-btn color="primary" type="submit" icon="mdi-magnify" size="large"></v-btn>
            </v-col>
          </v-row>
        </v-form>
        <v-row justify="center" class="my-6">
          <v-btn tile class="dashboard__search__link mx-3" :to="{name:'Main Search', params: { type: 'articles'}}">Article</v-btn>
          <v-btn tile class="dashboard__search__link mx-3" :to="{name:'Main Search', params: { type: 'authors'}}">Authors</v-btn>
          <v-btn tile class="dashboard__search__link mx-3">Conference</v-btn>
          <v-btn tile class="dashboard__search__link mx-3">Grants</v-btn>
        </v-row>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12">
        <v-card
            flat
        >
          <v-card-title class="pb-5 d-flex justify-space-between">
            <span class="text-h4 font-weight-medium">{{$t('home.news.title','News')}}</span>
            <v-btn variant="text" color="primary" :to="{name:'news'}" size="small">{{$t('home.news.all','All news')}}</v-btn>
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
    <v-row>
      <v-col cols="12">
        <v-card
            flat
        >
          <v-card-title class="pb-5 d-flex  justify-space-between">
            <span class="text-h4 font-weight-medium">{{$t('home.organization.title','Organization')}}</span>
            <v-btn variant="text" color="primary" :to="{name:'organizations'}" size="small">{{$t('home.organization.all','All organization')}}</v-btn>
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="3" v-for="org in organizations" :key="org.id">
                <OrganizationItem :org="org"/>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12">
        <v-card
            flat
        >
          <v-card-title class="pb-5 justify-space-between">
            <span class="text-h4 font-weight-medium">{{$t('home.about-us.title','About us')}}</span>
          </v-card-title>
          <v-card-text class="text-body-1">
            {{$t('home.about-us.message','Some long text')}}
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12">
        <v-card
            flat
        >
          <v-card-title class="pb-5 justify-space-between">
            <span class="text-h4 font-weight-medium">{{$t('home.contacts.title','Contacts')}}</span>
          </v-card-title>
          <v-card-text class="text-body-1">
            <div>{{$t('home.contacts.email','Email address')}} : wrp@gmail.com</div>
            <div>{{$t('home.contacts.phone','Contact center')}} : 044 535 35 35</div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12">
        <v-card
            flat
        >
          <v-card-title class="pb-5 d-flex  justify-space-between">
            <span class="text-h4 font-weight-medium">{{$t('home.partners.title','Partners')}}</span>
            <v-btn variant="text" color="primary" size="small">{{$t('home.partners.all','All partners')}}</v-btn>
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="3" v-for="partner in partners" :key="partner.id">
                <v-card
                    flat
                    class="mx-auto"
                >
                  <v-img
                      :src="partner.logo_url"
                      class="rounded-0 partners__img"
                      cover
                  >
                  </v-img>
                  <v-card-title class="justify-center"><span class="text-body-1" :title="partner.title">{{partner.title.length > 106 ? partner.title.substring(0,103)+'...':partner.title }}</span></v-card-title>
                </v-card>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12">
        <v-card
            flat
        >
          <v-card-title class="pb-5 d-flex  justify-space-between">
            <span class="text-h4 font-weight-medium">{{$t('home.organizers.title','Organizers')}}</span>
            <v-btn variant="text" color="primary" size="small">{{$t('home.organizers.all','All organizers')}}</v-btn>
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="3" v-for="organizer in organizers" :key="organizer.id">
                <v-card
                    flat
                    class="mx-auto"
                >
                  <v-img
                      :src="organizer.logo_url"
                      class="rounded-0 partners__img"
                      cover
                  >
                  </v-img>
                  <v-card-title class="justify-center"><span class="text-body-1">{{organizer.title.length > 106 ? organizer.title.substring(0,103)+'...':organizer.title }}</span></v-card-title>
                </v-card>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import {mapActions, mapState} from "pinia";
import OrganizationItem from '@/components/organizations/OrganizationItem.vue';
import NewsItem from '@/components/news/NewsItem.vue';
import {useNewsStore} from "@/stores/news";
import {useOrganizationStore} from "@/stores/organization";
import {useOrganizerStore} from "@/stores/organizer";
import {usePartnerStore} from "@/stores/partner";

export default {
  name: "Dashboard",
  components: {
    OrganizationItem,
    NewsItem
  },
  data() {
    return {
    };
  },
  mounted() {
    this.downloadNews({perPage:4});
    this.downloadOrganizations({perPage:4});
    this.downloadOrganizers({perPage:4});
    this.downloadPartners({perPage:4});
  },
  computed: {
    ...mapState(useNewsStore,['news']),
    ...mapState(useOrganizationStore,['organizations']),
    ...mapState(useOrganizerStore,['organizers']),
    ...mapState(usePartnerStore,['partners'])
  },
  methods: {
    ...mapActions(useNewsStore,['downloadNews']),
    ...mapActions(useOrganizationStore,['downloadOrganizations']),
    ...mapActions(useOrganizerStore,['downloadOrganizers']),
    ...mapActions(usePartnerStore,['downloadPartners']),
  },
}
</script>

<style scoped lang="scss">
.partners {
  &__img {
    aspect-ratio: 1/1;
    object-fit: contain;
    width: 100%;
  }
}
.dashboard {
  &__title {
    color: #1976D2;
  }
  &__search {
    &__link {
      box-shadow: none;
      font-weight: 700;
    }
  }
}
</style>
