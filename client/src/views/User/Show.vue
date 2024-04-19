<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-card flat v-if="user">
          <v-card-text>
<!--            <div v-if="user.projects" class="py-1">-->
<!--              <v-toolbar dense color="primary">-->
<!--                {{$t('projects.title','Projects')}}-->
<!--              </v-toolbar>-->
<!--              <v-data-table-->
<!--                  :headers="headersProjects"-->
<!--                  :items="user.projects"-->
<!--                  :items-per-page="5"-->
<!--                  class="elevation-1"-->
<!--                  hide-default-footer-->
<!--              ></v-data-table>-->
<!--            </div>-->
            <v-row justify="center" class="py-10">
              <v-col cols="8">
                <v-row>
                  <v-col cols="4" class="text-center">
                    <v-avatar size="150">
                      <v-img :src="user.avatar_url"></v-img>
                    </v-avatar>
                    <div class="text-h4 pt-4 font-weight-medium">
                      {{user.full_name}}
                    </div>
                    <div class="text-subtitle-1 pt-1">ID: {{user.id}}</div>
                  </v-col>
                  <v-col cols="4">
                    <div v-if="user.degree" class="pb-4">
                      <div class="text-subtitle-1">{{$t('placeholder.degree','Degree')}}</div>
                      <div class="text-h6 font-weight-regular">
                        {{user.degree}}
                      </div>
                    </div>
                    <div v-if="user.city_id" class="pb-4">
                      <div class="text-subtitle-1">{{$t('placeholder.country','Country')}}, {{ $t('placeholder.city', 'City') }}</div>
                      <div class="text-h6 font-weight-regular">
                        {{user.country.name}},{{user.city.name}}
                      </div>
                    </div>
                    <div>
                      <div class="text-subtitle-1">{{$t('placeholder.phone','Phone')}}</div>
                      <div class="text-h6 font-weight-regular">
                        <template v-if="haveAccess">
                          {{user.phone}}
                        </template>
                        <template v-else>
                          <div class="align-content-center">
                          {{$t('users.get-access', 'Get Access')}} <v-icon color="primary" size="22">mdi-export</v-icon>
                          </div>
                        </template>
                      </div>
                    </div>
                  </v-col>
                  <v-col cols="4">
                    <div v-if="user.position" class="pb-4">
                      <div class="text-subtitle-1">{{$t('placeholder.position','Position')}}</div>
                      <div class="text-h6 font-weight-regular">
                        {{user.position}}
                      </div>
                    </div>
                    <div v-if="user.organization_id" class="pb-4">
                      <div class="text-subtitle-1">{{$t('placeholder.organization','Organization')}}</div>
                      <div class="text-h6 font-weight-regular">
                        {{user.organization.name[locale.iso_code].length > 47 ? user.organization.name[locale.iso_code].substring(0,44)+'...':user.organization.name[locale.iso_code] }}
                      </div>
                    </div>
                    <div>
                      <div class="text-subtitle-1">@{{$t('placeholder.email','Email')}}</div>
                      <div class="text-h6 font-weight-regular">
                        <template v-if="haveAccess">
                          {{user.email}}
                        </template>
                        <template v-else>
                          <div class="align-content-center">
                            {{$t('users.get-access', 'Get Access')}} <v-icon color="primary" size="22">mdi-export</v-icon>
                          </div>
                        </template>
                      </div>
                    </div>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
            <v-row justify="center" class="pt-2 pb-10" v-if="user.id === account.id">
              <v-col cols="3">
<!--                <v-btn tile block :to="{name:'Premium'}" class="font-weight-bold" color="#FFD600" >{{$t('users.activate-premium', 'Activate Premium')}}</v-btn>-->
              </v-col>
              <v-col cols="3">
                <v-btn class="font-weight-bold" variant="flat" tile :to="{name:'account'}" block color="#F5F5F5">{{$t('users.edit-profile', 'Edit profile')}}</v-btn>
              </v-col>
            </v-row>
            <v-tabs v-model="tab" grow @update:modelValue="changeTab">
              <v-tab>{{$t('placeholder.desc', 'Desc')}}</v-tab>
              <v-tab>{{$t('works.title','Works')}}</v-tab>
              <v-tab>{{$t('articles.index.title','Articles')}}</v-tab>
              <v-tab>{{$t('articles.books.title','Books')}}</v-tab>
              <v-tab>{{$t('articles.conferences.title','Conferences')}}</v-tab>
              <v-tab>{{$t('articles.patents.title','Patents')}}</v-tab>
              <v-tab>{{$t('grants.title','Grants')}}</v-tab>
            </v-tabs>
            <v-window v-model="tab">
              <v-window-item>
                <v-row justify="space-between" class="pt-3">
                  <v-col cols="4">
                    <div class="text-subtitle-1 font-weight-medium">Science profile</div>
                    <div class="float-left d-inline-flex py-3">
                      <a class="pr-3" v-if="socialLinks.orcid" target="_blank" :href="socialLinks.orcid" >
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/ORCID/ORCID_Color.svg')"/>
                      </a>
                      <div v-else class="pr-3">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/ORCID/ORCID_Gray.svg')"/>
                      </div>
                      <a class="px-3" v-if="socialLinks.google" target="_blank" :href="socialLinks.google" >
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/GOOGLE/GOOGLE_TEXT_Color.svg')"/>
                      </a>
                      <div v-else class="px-3">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/GOOGLE/GOOGLE_TEXT_Gray.svg')"/>
                      </div>
                      <a class="px-3" v-if="socialLinks.scopus" target="_blank" :href="socialLinks.scopus">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/SCOPUS/SCOPUS_Color.svg')"/>
                      </a>
                      <div v-else class="px-3">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/SCOPUS/SCOPUS_Gray.svg')"/>
                      </div>
                      <a class="px-3" v-if="socialLinks.academia" target="_blank" :href="socialLinks.academia">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/ACADEMIA/ACADEMIA_Color.svg')"/>
                      </a>
                      <div v-else class="px-3">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/ACADEMIA/ACADEMIA_Gray.svg')"/>
                      </div>
                      <a class="px-3" v-if="socialLinks.science" target="_blank" :href="socialLinks.science">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/SCIENCE/SCIENCE_Color.svg')"/>
                      </a>
                      <div v-else class="px-3">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/SCIENCE/SCIENCE_Gray.svg')"/>
                      </div>
                      <a class="px-3" v-if="socialLinks.linkedin" target="_blank" :href="socialLinks.linkedin">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/LINKED/LINKED_Color.svg')"/>
                      </a>
                      <div v-else class="px-3">
                        <v-img width="71" height="40" contain="contain" :src="require('@/assets/social-logo/LINKED/LINKED_Gray.svg')"/>
                      </div>
                    </div>
                  </v-col>
                  <v-col offset="4" cols="4">
                    <div class="text-subtitle-1 font-weight-medium text-right">Social profile</div>
                    <div class="float-right d-inline-flex py-3">
                      <a class="px-3" v-if="socialLinks.facebook" target="_blank" :href="socialLinks.facebook">
                        <v-img class="px-3" width="40" height="40" :src="require('@/assets/social-logo/FACEBOOK/FACEBOOK_Color.svg')"/>
                      </a>
                      <div v-else class="px-3">
                        <v-img width="40" height="40" :src="require('@/assets/social-logo/FACEBOOK/FACEBOOK_Gray.svg')"/>
                      </div>
                      <a class="pl-3" v-if="socialLinks.instagram" target="_blank" :href="socialLinks.instagram">
                        <v-img width="40" height="40" :src="require('@/assets/social-logo/INSTAGRAM/INSTAGRAM_Color.svg')"/>
                      </a>
                      <div v-else class="pl-3">
                        <v-img width="40" height="40" :src="require('@/assets/social-logo/INSTAGRAM/INSTAGRAM_Gray.svg')"/>
                      </div>
                    </div>
                  </v-col>
                  <v-col cols="12" v-html="user.desc"></v-col>
                </v-row>
              </v-window-item>
              <v-window-item>
                <v-data-table
                    :headers="headersWorks"
                    :items="user.works"
                    :items-per-page="5"
                    class="elevation-1"
                    hide-default-footer
                >
                  <template v-slot:item.finish="{ item }">
                    {{item.finish?item.finish: $t('works.now','Now')}}
                  </template>
                </v-data-table>
              </v-window-item>
              <v-window-item>
                <v-data-table
                    :headers="headersArticles"
                    :items="articles"
                    class="elevation-1"
                >
                  <template v-slot:item.full_title="{ item }">
                    {{item.full_title[locale.iso_code]}}
                  </template>
                  <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="showArticle(item)"
                    >
                      mdi-eye
                    </v-icon>
                  </template>
                </v-data-table>
              </v-window-item>
              <v-window-item>
                <v-data-table
                    :headers="headersArticles"
                    :items="articles"
                    class="elevation-1"
                >
                  <template v-slot:item.full_title="{ item }">
                    {{item.full_title[locale.iso_code]}}
                  </template>
                  <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="showArticle(item)"
                    >
                      mdi-eye
                    </v-icon>
                  </template>
                </v-data-table>
              </v-window-item>
              <v-window-item>
                <v-data-table
                    :headers="headersArticles"
                    :items="articles"
                    class="elevation-1"
                >
                  <template v-slot:item.full_title="{ item }">
                    {{item.full_title[locale.iso_code]}}
                  </template>
                  <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="showArticle(item)"
                    >
                      mdi-eye
                    </v-icon>
                  </template>
                </v-data-table>
              </v-window-item>
              <v-window-item>
                <v-data-table
                    :headers="headersArticles"
                    :items="articles"
                    class="elevation-1"
                >
                  <template v-slot:item.full_title="{ item }">
                    {{item.full_title[locale.iso_code]}}
                  </template>
                  <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="showArticle(item)"
                    >
                      mdi-eye
                    </v-icon>
                  </template>
                </v-data-table>
              </v-window-item>
              <v-window-item>
                <v-data-table
                    :headers="headersGrants"
                    :items="user.grants"
                    :items-per-page="5"
                    class="elevation-1"
                    hide-default-footer
                ></v-data-table>
              </v-window-item>
            </v-window>
            <v-row justify="end" v-if="user.id === account.id">
              <v-col cols="2">
                <v-btn tile :to="{name:'account'}" class="font-weight-bold" variant="flat" block color="#F5F5F5">{{$t('users.edit', 'Edit')}}</v-btn>
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
import {useUserStore} from "@/stores/user";
import {useAccountStore} from "@/stores/account";
import {useArticleStore} from "@/stores/article";
import {useLocalesStore} from "@/stores/l10s";

export default {
  name: "Show",
  data() {
    return {
      headersWorks: [
        { title: this.$t('works.placeholder.title', 'Title'), value: 'title' },
        { title: this.$t('works.placeholder.start', 'Worked from'), value: 'start' },
        { title: this.$t('works.placeholder.finish','Worked Until'), value: 'finish' },
      ],
      headersProjects: [
        { title: this.$t('projects.placeholder.name', 'Name'), value: 'name' },
      ],
      headersGrants: [
        { title: this.$t('grants.placeholder.name', 'Name'), value: 'name' },
      ],
      headersArticles: [
        { title: this.$t('articles.placeholder.title','Title'), value: 'full_title' },
        { title: this.$t('articles.placeholder.category','Category'), value: 'category.title' },
        { title: this.$t('articles.placeholder.year','Year'), value: 'year' },
        { title: this.$t('articles.placeholder.actions','Actions'), value: 'actions', sortable: false },
      ],
      socialLinks: {
        academia: null,
        facebook: null,
        google: null,
        instagram: null,
        linkedin: null,
        orcid: null,
        scopus: null,
        science: null,
      },
      tab: 0,
    };
  },
  computed: {
    ...mapState(useUserStore,['user']),
    ...mapState(useAccountStore,{
      account:'user'
    }),
    ...mapState(useArticleStore,['articles']),
    ...mapState(useLocalesStore,['locale']),
    haveAccess() {
      let user = this.user;
      let acc = this.account;
      if (user && acc) {
        return user.id === acc.id;
      }
      return false;
    }
  },
  mounted() {
    this.downloadUser(this.$route.params.user_id)
        .then( (res) => {
        res.user.social_links.forEach( (item) => {
          this.socialLinks[item.type] = item.url;
        })
    });
  },
  methods: {
    showArticle(item) {
      this.$router.push( { name: 'Article', params: { article_id: item.id } });
    },
    changeTab() {
      console.log(this.tab)
      let user_id = this.$route.params.user_id;
      switch (this.tab) {
        case 2:
          this.$loading();
          this.downloadArticles({user_id:user_id, sortBy:['id'], sortDesc:[1]}).then( () => {
            this.$loadingClose();
          })
          break;
        case 3:
          this.$loading();
          this.downloadArticles({user_id:user_id, category_name:'book', sortBy:['id'], sortDesc:[1]}).then( () => {
            this.$loadingClose();
          })
          break;
        case 4:
          this.$loading();
          this.downloadArticles({user_id:user_id, category_name:'conference',sortBy:['id'], sortDesc:[1]}).then( () => {
            this.$loadingClose();
          })
          break;
        case 5:
          this.$loading();
          this.downloadArticles({user_id:user_id, category_name:'patent', sortBy:['id'], sortDesc:[1]}).then( () => {
            this.$loadingClose();
          })
          break;
      }
    },
    ...mapActions(useUserStore,['downloadUser']),
    ...mapActions(useArticleStore,['downloadArticles'])
  },
}
</script>

<style scoped>

</style>
